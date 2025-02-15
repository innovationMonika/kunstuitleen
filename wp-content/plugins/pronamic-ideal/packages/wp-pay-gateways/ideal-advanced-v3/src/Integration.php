<?php
/**
 * Integration.
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2024 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay
 */

namespace Pronamic\WordPress\Pay\Gateways\IDealAdvancedV3;

use Pronamic\WordPress\Pay\Gateways\IDeal\AbstractIntegration;

/**
 * Title: iDEAL Advanced v3 integration
 * Description:
 * Copyright: 2005-2024 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.1.1
 * @since   2.0.0
 */
class Integration extends AbstractIntegration {
	/**
	 * Construct iDEAL Advanced v3 integration.
	 *
	 * @param array<string, mixed> $args Arguments.
	 * @return void
	 */
	public function __construct( $args = [] ) {
		$args = wp_parse_args(
			$args,
			[
				'id'            => 'ideal-advanced-v3',
				'name'          => 'iDEAL Advanced v3',
				'mode'          => 'live',
				'url'           => \__( 'https://www.ideal.nl/en/', 'pronamic-ideal' ),
				'product_url'   => \__( 'https://www.ideal.nl/en/', 'pronamic-ideal' ),
				'manual_url'    => null,
				'dashboard_url' => null,
				'provider'      => null,
				'acquirer_url'  => null,
				'supports'      => [
					'payment_status_request',
				],
			]
		);

		parent::__construct( $args );

		// Acquirer URL.
		$this->acquirer_url = $args['acquirer_url'];

		$this->mode = $args['mode'];

		// Actions.
		add_action( 'current_screen', [ $this, 'maybe_download_certificate' ] );
		add_action( 'current_screen', [ $this, 'maybe_download_secret_key' ] );
	}

	/**
	 * Get settings fields.
	 *
	 * @return array<int, array<string, mixed>>>
	 */
	public function get_settings_fields() {
		$fields = parent::get_settings_fields();

		/*
		 * Secret key and certificate
		 */

		// Secret key and certificate information.
		$fields[] = [
			'section'  => 'general',
			'title'    => __( 'Secret key and certificate', 'pronamic-ideal' ),
			'type'     => 'description',
			'callback' => [ $this, 'field_security' ],
		];

		// Organization.
		$fields[] = [
			'section'  => 'general',
			'group'    => 'pk-cert',
			'meta_key' => '_pronamic_gateway_organization',
			'title'    => __( 'Organization', 'pronamic-ideal' ),
			'type'     => 'text',
			'tooltip'  => __( 'Organization name, e.g. Pronamic', 'pronamic-ideal' ),
		];

		// Organization Unit.
		$fields[] = [
			'section'  => 'general',
			'group'    => 'pk-cert',
			'meta_key' => '_pronamic_gateway_organization_unit',
			'title'    => __( 'Organization Unit', 'pronamic-ideal' ),
			'type'     => 'text',
			'tooltip'  => __( 'Organization unit, e.g. Administration', 'pronamic-ideal' ),
		];

		// Locality.
		$fields[] = [
			'section'  => 'general',
			'group'    => 'pk-cert',
			'meta_key' => '_pronamic_gateway_locality',
			'title'    => __( 'City', 'pronamic-ideal' ),
			'type'     => 'text',
			'tooltip'  => __( 'City, e.g. Amsterdam', 'pronamic-ideal' ),
		];

		// State or Province.
		$fields[] = [
			'section'  => 'general',
			'group'    => 'pk-cert',
			'meta_key' => '_pronamic_gateway_state_or_province',
			'title'    => __( 'State / province', 'pronamic-ideal' ),
			'type'     => 'text',
			'tooltip'  => __( 'State or province, e.g. Friesland', 'pronamic-ideal' ),
		];

		// Country.
		$locale = \explode( '_', \get_locale() );

		$locale = count( $locale ) > 1 ? $locale[1] : $locale[0];

		$fields[] = [
			'section'     => 'general',
			'group'       => 'pk-cert',
			'meta_key'    => '_pronamic_gateway_country',
			'title'       => __( 'Country', 'pronamic-ideal' ),
			'type'        => 'text',
			'tooltip'     => sprintf(
				'%s %s (ISO-3166-1 alpha-2)',
				__( '2 letter country code, e.g.', 'pronamic-ideal' ),
				strtoupper( $locale )
			),
			'size'        => 2,
			'description' => sprintf(
				'%s %s',
				__( '2 letter country code, e.g.', 'pronamic-ideal' ),
				strtoupper( $locale )
			),
		];

		// Email Address.
		$fields[] = [
			'section'  => 'general',
			'group'    => 'pk-cert',
			'meta_key' => '_pronamic_gateway_email',
			'title'    => __( 'E-mail address', 'pronamic-ideal' ),
			'tooltip'  => sprintf(
				/* translators: %s: admin email */
				__( 'E-mail address, e.g. %s', 'pronamic-ideal' ),
				(string) get_option( 'admin_email' )
			),
			'type'     => 'text',
		];

		// Number Days Valid.
		$fields[] = [
			'section'  => 'general',
			'filter'   => \FILTER_SANITIZE_NUMBER_INT,
			'group'    => 'pk-cert',
			'meta_key' => '_pronamic_gateway_number_days_valid',
			'title'    => __( 'Number Days Valid', 'pronamic-ideal' ),
			'type'     => 'text',
			'default'  => 1825,
			'tooltip'  => __( 'Number of days the generated certificate will be valid for, e.g. 1825 days for the maximum duration of 5 years.', 'pronamic-ideal' ),
		];

		// Secret Key Password.
		$fields[] = [
			'section'  => 'general',
			'group'    => 'pk-cert',
			'meta_key' => '_pronamic_gateway_ideal_private_key_password',
			'title'    => __( 'Secret Key Password', 'pronamic-ideal' ),
			'type'     => 'text',
			'classes'  => [ 'regular-text', 'code' ],
			'default'  => wp_generate_password(),
			'tooltip'  => __( 'A random password which will be used for the generation of the secret key and certificate.', 'pronamic-ideal' ),
			'input'    => function ( $name ) {
				// phpcs:disable WordPress.Security.NonceVerification.Missing

				if ( ! \array_key_exists( $name, $_POST ) ) {
					return '';
				}

				// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Password can contain whitespace, HTML tags and percent-encoded characters.
				return $_POST[ $name ];

				// phpcs:enable WordPress.Security.NonceVerification.Missing
			},
		];

		// Secret Key.
		$fields[] = [
			'section'  => 'general',
			'group'    => 'pk-cert',
			'meta_key' => '_pronamic_gateway_ideal_private_key',
			'title'    => __( 'Secret Key', 'pronamic-ideal' ),
			'type'     => 'textarea',
			'callback' => [ $this, 'field_private_key' ],
			'classes'  => [ 'code' ],
			'tooltip'  => __( 'The secret key is used for secure communication with the payment provider. If left empty, the secret key will be generated using the given secret key password.', 'pronamic-ideal' ),
		];

		// Certificate.
		$fields[] = [
			'section'  => 'general',
			'group'    => 'pk-cert',
			'meta_key' => '_pronamic_gateway_ideal_private_certificate',
			'title'    => __( 'Certificate', 'pronamic-ideal' ),
			'type'     => 'textarea',
			'callback' => [ $this, 'field_certificate' ],
			'classes'  => [ 'code' ],
			'tooltip'  => __( 'The certificate is used for secure communication with the payment provider. If left empty, the certificate will be generated using the secret key and given organization details.', 'pronamic-ideal' ),
		];

		// Return.
		return $fields;
	}

	/**
	 * Field security
	 *
	 * @param array<string, mixed> $field Field.
	 * @return void
	 */
	public function field_security( $field ) {
		$post_id = (int) \get_the_ID();

		$certificate = get_post_meta( $post_id, '_pronamic_gateway_ideal_private_certificate', true );

		?>
		<p>
			<?php if ( empty( $certificate ) ) : ?>

				<span class="dashicons dashicons-no"></span> <?php esc_html_e( 'The secret key and certificate have not yet been configured.', 'pronamic-ideal' ); ?>
				<br/>

				<br/>

				<?php esc_html_e( 'A secret key and certificate are required for communication with the payment provider. Enter the organization details from the iDEAL account below to generate these required files.', 'pronamic-ideal' ); ?>

			<?php else : ?>

				<span class="dashicons dashicons-yes"></span> <?php esc_html_e( 'A secret key and certificate have been configured. The certificate must be uploaded to the payment provider dashboard to complete configuration.', 'pronamic-ideal' ); ?>
				<br/>

				<br/>

				<?php

				\wp_nonce_field( 'pronamic_pay_download_certificate', 'pronamic_pay_download_certificate_nonce' );

				submit_button(
					__( 'Download certificate', 'pronamic-ideal' ),
					'secondary',
					'download_certificate',
					false
				);

				?>

			<?php endif; ?>
		</p>
		<?php
	}

	/**
	 * Field private key.
	 *
	 * @param array<string, mixed> $field Field.
	 * @return void
	 */
	public function field_private_key( $field ) {
		$post_id = (int) \get_the_ID();

		$private_key          = get_post_meta( $post_id, '_pronamic_gateway_ideal_private_key', true );
		$private_key_password = get_post_meta( $post_id, '_pronamic_gateway_ideal_private_key_password', true );
		$number_days_valid    = get_post_meta( $post_id, '_pronamic_gateway_number_days_valid', true );

		if ( ! empty( $private_key_password ) && ! empty( $number_days_valid ) ) {
			if ( \function_exists( '\escapeshellarg' ) ) {
				$filename = __( 'ideal.key', 'pronamic-ideal' );

				$command = sprintf(
					'openssl genrsa -aes128 -out %s -passout pass:%s 2048',
					\escapeshellarg( $filename ),
					\escapeshellarg( $private_key_password )
				);

				?>

				<p><?php esc_html_e( 'OpenSSL command', 'pronamic-ideal' ); ?></p>
				<input id="pronamic_ideal_openssl_command_key" name="pronamic_ideal_openssl_command_key" value="<?php echo esc_attr( $command ); ?>" type="text" class="large-text code" readonly="readonly"/>

				<?php
			}
		} else {
			printf(
				'<p class="pronamic-pay-description description">%s</p>',
				esc_html__( 'Leave empty and save the configuration to generate the secret key or view the OpenSSL command.', 'pronamic-ideal' )
			);
		}

		?>
		<p>
			<?php

			if ( ! empty( $private_key ) ) {
				\wp_nonce_field( 'pronamic_pay_download_secret_key', 'pronamic_pay_download_secret_key_nonce' );

				submit_button(
					__( 'Download', 'pronamic-ideal' ),
					'secondary',
					'download_secret_key',
					false
				);

				echo ' ';
			}

			printf(
				'<label class="pronamic-pay-form-control-file-button button">%s <input type="file" name="%s" /></label>',
				esc_html__( 'Upload', 'pronamic-ideal' ),
				'_pronamic_gateway_ideal_private_key_file'
			);

			?>
		</p>
		<?php
	}

	/**
	 * Field certificate.
	 *
	 * @param array<string, mixed> $field Field.
	 * @return void
	 */
	public function field_certificate( $field ) {
		$post_id = (int) \get_the_ID();

		$certificate = get_post_meta( $post_id, '_pronamic_gateway_ideal_private_certificate', true );

		$private_key_password = get_post_meta( $post_id, '_pronamic_gateway_ideal_private_key_password', true );
		$number_days_valid    = get_post_meta( $post_id, '_pronamic_gateway_number_days_valid', true );

		$filename_key = __( 'ideal.key', 'pronamic-ideal' );
		$filename_cer = __( 'ideal.cer', 'pronamic-ideal' );

		// @link http://www.openssl.org/docs/apps/req.html
		$subj_args = [
			'C'            => get_post_meta( $post_id, '_pronamic_gateway_country', true ),
			'ST'           => get_post_meta( $post_id, '_pronamic_gateway_state_or_province', true ),
			'L'            => get_post_meta( $post_id, '_pronamic_gateway_locality', true ),
			'O'            => get_post_meta( $post_id, '_pronamic_gateway_organization', true ),
			'OU'           => get_post_meta( $post_id, '_pronamic_gateway_organization_unit', true ),
			'CN'           => get_post_meta( $post_id, '_pronamic_gateway_organization', true ),
			'emailAddress' => get_post_meta( $post_id, '_pronamic_gateway_email', true ),
		];

		$subj_args = array_filter( $subj_args );

		$subj = '';

		foreach ( $subj_args as $type => $value ) {
			$subj .= '/' . $type . '=' . addslashes( $value );
		}

		if ( ! empty( $subj ) ) {
			if ( \function_exists( '\escapeshellarg' ) ) {
				$command = \trim(
					\sprintf(
						'openssl req -x509 -sha256 -new -key %s -passin pass:%s -days %s -out %s %s',
						\escapeshellarg( $filename_key ),
						\escapeshellarg( $private_key_password ),
						\escapeshellarg( $number_days_valid ),
						\escapeshellarg( $filename_cer ),
						\sprintf( '-subj %s', \escapeshellarg( $subj ) )
					)
				);

				?>

				<p><?php \esc_html_e( 'OpenSSL command', 'pronamic-ideal' ); ?></p>
				<input id="pronamic_ideal_openssl_command_certificate" name="pronamic_ideal_openssl_command_certificate" value="<?php echo \esc_attr( $command ); ?>" type="text" class="large-text code" readonly="readonly"/>

				<?php
			}
		} else {
			printf(
				'<p class="pronamic-pay-description description">%s</p>',
				esc_html__( 'Leave empty and save the configuration to generate the certificate or view the OpenSSL command.', 'pronamic-ideal' )
			);
		}

		if ( ! empty( $certificate ) ) {
			$certificate_object = new Certificate( $certificate );

			$fingerprint = $certificate_object->get_fingerprint();
			$fingerprint = str_split( $fingerprint, 2 );
			$fingerprint = implode( ':', $fingerprint );

			echo '<dl>';

			echo '<dt>', esc_html__( 'SHA Fingerprint', 'pronamic-ideal' ), '</dt>';
			echo '<dd>', esc_html( $fingerprint ), '</dd>';

			$info = openssl_x509_parse( $certificate );

			if ( $info ) {
				$date_format = __( 'M j, Y @ G:i', 'pronamic-ideal' );

				if ( isset( $info['validFrom_time_t'] ) ) {
					echo '<dt>', esc_html__( 'Valid From', 'pronamic-ideal' ), '</dt>';
					echo '<dd>', esc_html( date_i18n( $date_format, $info['validFrom_time_t'] ) ), '</dd>';
				}

				if ( isset( $info['validTo_time_t'] ) ) {
					echo '<dt>', esc_html__( 'Valid To', 'pronamic-ideal' ), '</dt>';
					echo '<dd>', esc_html( date_i18n( $date_format, $info['validTo_time_t'] ) ), '</dd>';
				}
			}

			echo '</dl>';
		}

		?>
		<p>
			<?php

			if ( ! empty( $certificate ) ) {
				\wp_nonce_field( 'pronamic_pay_download_certificate', 'pronamic_pay_download_certificate_nonce' );

				submit_button(
					__( 'Download', 'pronamic-ideal' ),
					'secondary',
					'download_certificate',
					false
				);

				echo ' ';
			}

			printf(
				'<label class="pronamic-pay-form-control-file-button button">%s <input type="file" name="%s" /></label>',
				esc_html__( 'Upload', 'pronamic-ideal' ),
				'_pronamic_gateway_ideal_certificate_file'
			);

			?>
		</p>
		<?php
	}

	/**
	 * Download certificate.
	 *
	 * @return void
	 */
	public function maybe_download_certificate() {
		if ( ! \array_key_exists( 'download_certificate', $_POST ) ) {
			return;
		}

		if ( ! \array_key_exists( 'pronamic_pay_download_certificate_nonce', $_POST ) ) {
			return;
		}

		$nonce = \sanitize_text_field( \wp_unslash( $_POST['pronamic_pay_download_certificate_nonce'] ) );

		if ( ! \wp_verify_nonce( $nonce, 'pronamic_pay_download_certificate' ) ) {
			return;
		}

		if ( ! \array_key_exists( 'post_ID', $_POST ) ) {
			return;
		}

		$post_id = \sanitize_text_field( \wp_unslash( $_POST['post_ID'] ) );

		$filename = sprintf( 'ideal-certificate-%s.cer', $post_id );

		header( 'Content-Description: File Transfer' );
		header( 'Content-Disposition: attachment; filename=' . $filename );
		header( 'Content-Type: application/x-x509-ca-cert; charset=' . get_option( 'blog_charset' ), true );

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo get_post_meta( $post_id, '_pronamic_gateway_ideal_private_certificate', true );

		exit;
	}

	/**
	 * Download secret key.
	 *
	 * @return void
	 */
	public function maybe_download_secret_key() {
		if ( ! \array_key_exists( 'download_secret_key', $_POST ) ) {
			return;
		}

		if ( ! \array_key_exists( 'pronamic_pay_download_secret_key_nonce', $_POST ) ) {
			return;
		}

		$nonce = \sanitize_text_field( \wp_unslash( $_POST['pronamic_pay_download_secret_key_nonce'] ) );

		if ( ! \wp_verify_nonce( $nonce, 'pronamic_pay_download_secret_key' ) ) {
			return;
		}

		if ( ! \array_key_exists( 'post_ID', $_POST ) ) {
			return;
		}

		$post_id = \sanitize_text_field( \wp_unslash( $_POST['post_ID'] ) );

		$filename = sprintf( 'ideal-secret-key-%s.key', $post_id );

		header( 'Content-Description: File Transfer' );
		header( 'Content-Disposition: attachment; filename=' . $filename );
		header( 'Content-Type: application/pgp-keys; charset=' . get_option( 'blog_charset' ), true );

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo get_post_meta( $post_id, '_pronamic_gateway_ideal_private_key', true );

		exit;
	}

	/**
	 * Save post.
	 *
	 * @param int $post_id Post ID.
	 * @return void
	 */
	public function save_post( $post_id ) {
		// phpcs:disable WordPress.Security.NonceVerification.Missing

		// Files.
		$files = [
			'_pronamic_gateway_ideal_private_key_file' => '_pronamic_gateway_ideal_private_key',
			'_pronamic_gateway_ideal_certificate_file' => '_pronamic_gateway_ideal_private_certificate',
		];

		foreach ( $files as $name => $meta_key ) {
			// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated
			if ( isset( $_FILES[ $name ] ) && UPLOAD_ERR_OK === $_FILES[ $name ]['error'] ) {
				// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotValidated, WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized
				$value = file_get_contents( $_FILES[ $name ]['tmp_name'] );

				update_post_meta( $post_id, $meta_key, $value );
			}
		}

		// phpcs:enable WordPress.Security.NonceVerification.Missing

		// Generate private key and certificate.
		$private_key          = get_post_meta( $post_id, '_pronamic_gateway_ideal_private_key', true );
		$private_key_password = get_post_meta( $post_id, '_pronamic_gateway_ideal_private_key_password', true );

		if ( empty( $private_key_password ) ) {
			// Without private key password we can't create private key and certificate.
			return;
		}

		if ( ! in_array( 'aes-128-cbc', openssl_get_cipher_methods(), true ) ) {
			// Without AES-128-CBC cipher method we can't create private key and certificate.
			return;
		}

		$args = [
			'digest_alg'             => 'SHA256',
			'private_key_bits'       => 2048,
			'private_key_type'       => \OPENSSL_KEYTYPE_RSA,
			'encrypt_key'            => true,
			'subjectKeyIdentifier'   => 'hash',
			'authorityKeyIdentifier' => 'keyid:always,issuer:always',
			'basicConstraints'       => 'CA:true',
		];

		// Private key.
		$pkey = \openssl_pkey_get_private( $private_key, $private_key_password );

		if ( false === $pkey ) {
			// If we can't open the private key we will create a new private key and certificate.
			if ( defined( 'OPENSSL_CIPHER_AES_128_CBC' ) ) {
				$args['encrypt_key_cipher'] = \OPENSSL_CIPHER_AES_128_CBC;
			} elseif ( defined( 'OPENSSL_CIPHER_3DES' ) ) {
				// @link https://www.pronamic.nl/wp-content/uploads/2011/12/iDEAL_Advanced_PHP_EN_V2.2.pdf
				$args['encrypt_key_cipher'] = \OPENSSL_CIPHER_3DES;
			} else {
				// Unable to create private key without cipher.
				return;
			}

			$pkey = openssl_pkey_new( $args );

			if ( false === $pkey ) {
				return;
			}

			// Export key.
			$result = openssl_pkey_export( $pkey, $private_key, $private_key_password, $args );

			if ( false === $result ) {
				return;
			}

			update_post_meta( $post_id, '_pronamic_gateway_ideal_private_key', $private_key );

			// Delete certificate since this is no longer valid.
			delete_post_meta( $post_id, '_pronamic_gateway_ideal_private_certificate' );
		}

		// Certificate.
		$certificate       = get_post_meta( $post_id, '_pronamic_gateway_ideal_private_certificate', true );
		$number_days_valid = get_post_meta( $post_id, '_pronamic_gateway_number_days_valid', true );

		if ( empty( $certificate ) ) {
			$required_keys = [
				'countryName',
				'stateOrProvinceName',
				'localityName',
				'organizationName',
				'commonName',
				'emailAddress',
			];

			$distinguished_name = [
				'countryName'            => get_post_meta( $post_id, '_pronamic_gateway_country', true ),
				'stateOrProvinceName'    => get_post_meta( $post_id, '_pronamic_gateway_state_or_province', true ),
				'localityName'           => get_post_meta( $post_id, '_pronamic_gateway_locality', true ),
				'organizationName'       => get_post_meta( $post_id, '_pronamic_gateway_organization', true ),
				'organizationalUnitName' => get_post_meta( $post_id, '_pronamic_gateway_organization_unit', true ),
				'commonName'             => get_post_meta( $post_id, '_pronamic_gateway_organization', true ),
				'emailAddress'           => get_post_meta( $post_id, '_pronamic_gateway_email', true ),
			];

			$distinguished_name = array_filter( $distinguished_name );

			/*
			 * Create certificate only if distinguished name contains all required elements
			 *
			 * @link http://stackoverflow.com/questions/13169588/how-to-check-if-multiple-array-keys-exists
			 */
			if ( count( array_intersect_key( array_flip( $required_keys ), $distinguished_name ) ) === count( $required_keys ) ) {
				// Determine cipher.
				if ( defined( 'OPENSSL_CIPHER_AES_128_CBC' ) ) {
					$args['encrypt_key_cipher'] = \OPENSSL_CIPHER_AES_128_CBC;
				} elseif ( defined( 'OPENSSL_CIPHER_3DES' ) ) {
					// @link https://www.pronamic.nl/wp-content/uploads/2011/12/iDEAL_Advanced_PHP_EN_V2.2.pdf
					$args['encrypt_key_cipher'] = \OPENSSL_CIPHER_3DES;
				} else {
					// Unable to create certificate without cipher.
					return;
				}

				$csr = openssl_csr_new( $distinguished_name, $pkey );

				if ( false !== $csr ) {
					$cert = openssl_csr_sign( $csr, null, $pkey, $number_days_valid, $args, time() );

					if ( false !== $cert ) {
						openssl_x509_export( $cert, $certificate );

						update_post_meta( $post_id, '_pronamic_gateway_ideal_private_certificate', $certificate );
					}
				}
			}
		}
	}

	/**
	 * Get config.
	 *
	 * @param int $post_id Post ID.
	 * @return Config
	 */
	public function get_config( $post_id ) {
		$config = new Config();

		$config->payment_server_url = $this->acquirer_url;

		$config->set_merchant_id( get_post_meta( $post_id, '_pronamic_gateway_ideal_merchant_id', true ) );
		$config->set_sub_id( get_post_meta( $post_id, '_pronamic_gateway_ideal_sub_id', true ) );
		$config->set_purchase_id( get_post_meta( $post_id, '_pronamic_gateway_ideal_purchase_id', true ) );

		$config->set_private_key( get_post_meta( $post_id, '_pronamic_gateway_ideal_private_key', true ) );
		$config->set_private_key_password( get_post_meta( $post_id, '_pronamic_gateway_ideal_private_key_password', true ) );
		$config->set_certificate( get_post_meta( $post_id, '_pronamic_gateway_ideal_private_certificate', true ) );

		return $config;
	}

	/**
	 * Get gateway.
	 *
	 * @param int $post_id Post ID.
	 * @return Gateway
	 */
	public function get_gateway( $post_id ) {
		$gateway = new Gateway( $this->get_config( $post_id ) );

		$gateway->mode = $this->mode;

		return $gateway;
	}
}
