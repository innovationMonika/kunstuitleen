<?php
/**
 * Client.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3;

use DOMDocument;
use Pronamic\WordPress\Http\Facades\Http;
use Pronamic\WordPress\Pay\Core\Util as Core_Util;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML\AcquirerErrorResMessage;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML\AcquirerStatusReqMessage;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML\AcquirerStatusResMessage;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML\DirectoryRequestMessage;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML\DirectoryResponseMessage;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML\Message;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML\RequestMessage;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML\TransactionRequestMessage;
use Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3\XML\TransactionResponseMessage;
use SimpleXMLElement;
use WP_Error;
use XMLSecurityDSig;
use XMLSecurityKey;

/**
 * Title: iDEAL client
 * Description:
 * Copyright: 2005-2024 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.0.5
 * @since   1.0.0
 */
class Client {
	/**
	 * Acquirer URL
	 *
	 * @var string
	 */
	public $acquirer_url;

	/**
	 * Directory request URL
	 *
	 * @var string
	 */
	public $directory_request_url;

	/**
	 * Transaction request URL
	 *
	 * @var string
	 */
	public $transaction_request_url;

	/**
	 * Status request URL
	 *
	 * @var string
	 */
	public $status_request_url;

	/**
	 * Merchant ID
	 *
	 * @var string
	 */
	public $merchant_id;

	/**
	 * Sub ID
	 *
	 * @var string
	 */
	public $sub_id;

	/**
	 * Certificate
	 *
	 * @var string
	 */
	public $certificate;

	/**
	 * Private key
	 *
	 * @var string
	 */
	public $private_key;

	/**
	 * Private key password
	 *
	 * @var string
	 */
	public $private_key_password;

	/**
	 * Set the acquirer URL
	 *
	 * @param string $url URL.
	 * @return void
	 */
	public function set_acquirer_url( $url ) {
		$this->acquirer_url = $url;

		$this->directory_request_url   = $url;
		$this->transaction_request_url = $url;
		$this->status_request_url      = $url;
	}

	/**
	 * Send an specific request message to an specific URL
	 *
	 * @param string         $url     URL.
	 * @param RequestMessage $message Message.
	 * @return DirectoryResponseMessage|TransactionResponseMessage|AcquirerStatusResMessage
	 * @throws \Exception Throws exception on error with private key when signing document.
	 */
	private function send_message( $url, RequestMessage $message ) {
		// Sign.
		$document = $message->get_document();
		$document = $this->sign_document( $document );

		// Stringify.
		$data = $document->saveXML();

		/*
		 * Fix for a incorrect implementation at https://www.ideal-checkout.nl/simulator/.
		 *
		 * @since 1.1.11
		 */
		if ( 'https://www.ideal-checkout.nl/simulator/' === $url ) {
			$data = $document->C14N( true, false );
		}

		// Remote post.
		$response = Http::request(
			$url,
			[
				'method'  => 'POST',
				'headers' => [
					'Content-Type' => 'text/xml; charset=' . Message::XML_ENCODING,
				],
				'body'    => $data,
			]
		);

		$xml = $response->simplexml();

		$result = $this->parse_document( $xml );

		return $result;
	}

	/**
	 * Parse the specified document and return parsed result
	 *
	 * @param SimpleXMLElement $document Document.
	 * @return DirectoryResponseMessage|TransactionResponseMessage|AcquirerStatusResMessage
	 * @throws \Exception Throws exception if response XML document can not be parsed.
	 */
	private function parse_document( SimpleXMLElement $document ) {
		$name = $document->getName();

		switch ( $name ) {
			case AcquirerErrorResMessage::NAME:
				$message = AcquirerErrorResMessage::parse( $document );

				throw $message->error;
			case DirectoryResponseMessage::NAME:
				return DirectoryResponseMessage::parse( $document );
			case TransactionResponseMessage::NAME:
				return TransactionResponseMessage::parse( $document );
			case AcquirerStatusResMessage::NAME:
				return AcquirerStatusResMessage::parse( $document );
			default:
				throw new \Exception(
					\sprintf(
						/* translators: %s: XML document element name */
						\esc_html__( 'Unknown iDEAL message (%s)', 'pronamic-ideal' ),
						\esc_html( $name )
					)
				);
		}
	}

	/**
	 * Get directory of issuers
	 *
	 * @return null|Directory
	 */
	public function get_directory() {
		$directory = null;

		$request_dir_message = new DirectoryRequestMessage();

		$merchant = $request_dir_message->get_merchant();
		$merchant->set_id( $this->merchant_id );
		$merchant->set_sub_id( $this->sub_id );

		$response_dir_message = $this->send_message( $this->directory_request_url, $request_dir_message );

		if ( $response_dir_message instanceof DirectoryResponseMessage ) {
			$directory = $response_dir_message->get_directory();
		}

		return $directory;
	}

	/**
	 * Create transaction
	 *
	 * @param Transaction $transaction Transaction.
	 * @param string      $return_url  Return URL.
	 * @param string      $issuer_id   Issuer ID.
	 * @return TransactionResponseMessage
	 * @throws \Exception Throws exception on unexpected transaction request response.
	 */
	public function create_transaction( Transaction $transaction, $return_url, $issuer_id ) {
		$message = new TransactionRequestMessage();

		$merchant = $message->get_merchant();
		$merchant->set_id( $this->merchant_id );
		$merchant->set_sub_id( $this->sub_id );
		$merchant->set_return_url( $return_url );

		$message->issuer = new Issuer();
		$message->issuer->set_id( $issuer_id );

		$message->transaction = $transaction;

		$result = $this->send_message( $this->transaction_request_url, $message );

		if ( ! ( $result instanceof TransactionResponseMessage ) ) {
			throw new \Exception( 'Unexpected response for transaction request.' );
		}

		return $result;
	}

	/**
	 * Get the status of the specified transaction ID
	 *
	 * @param string $transaction_id Transaction ID.
	 * @return AcquirerStatusResMessage
	 * @throws \Exception Throws exception on unexpected acquirer status response.
	 */
	public function get_status( $transaction_id ) {
		$message = new AcquirerStatusReqMessage();

		$merchant = $message->get_merchant();
		$merchant->set_id( $this->merchant_id );
		$merchant->set_sub_id( $this->sub_id );

		$message->transaction = new Transaction();
		$message->transaction->set_id( $transaction_id );

		$result = $this->send_message( $this->status_request_url, $message );

		if ( ! ( $result instanceof AcquirerStatusResMessage ) ) {
			throw new \Exception( 'Unexpected response for acquirer status request.' );
		}

		return $result;
	}

	/**
	 * Sign the specified DOMDocument
	 *
	 * @link https://github.com/Maks3w/xmlseclibs/blob/v1.3.0/tests/xml-sign.phpt
	 *
	 * @param DOMDocument $document Document.
	 * @return DOMDocument
	 * @throws \Exception Can not load private key.
	 */
	private function sign_document( DOMDocument $document ) {
		$certificate = new Certificate( $this->certificate );

		$private_key = \openssl_pkey_get_private( $this->private_key, $this->private_key_password );

		if ( false === $private_key ) {
			throw new \Exception( 'Can not load private key' );
		}

		$xml_signer = new XmlSigner(
			$certificate->get_fingerprint(),
			$private_key
		);

		$xml_signer->sign_document( $document );

		return $document;
	}
}
