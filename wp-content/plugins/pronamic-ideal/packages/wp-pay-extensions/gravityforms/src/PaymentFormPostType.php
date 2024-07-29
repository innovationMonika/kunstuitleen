<?php
/**
 * Payment form post type
 *
 * @author    Pronamic <info@pronamic.eu>
 * @copyright 2005-2023 Pronamic
 * @license   GPL-3.0-or-later
 * @package   Pronamic\WordPress\Pay\Extensions\GravityForms
 */

namespace Pronamic\WordPress\Pay\Extensions\GravityForms;

/**
 * Title: WordPress payment form post type
 * Description:
 * Copyright: 2005-2023 Pronamic
 * Company: Pronamic
 *
 * @author  Remco Tolsma
 * @version 2.1.2
 * @since   1.1.0
 */
class PaymentFormPostType {
	/**
	 * Construct and initialize payment form post type
	 */
	public function __construct() {
		/**
		 * Priority of the initial post types function should be set to < 10.
		 *
		 * @link https://core.trac.wordpress.org/ticket/28488
		 * @link https://core.trac.wordpress.org/changeset/29318
		 *
		 * @link https://github.com/WordPress/WordPress/blob/4.0/wp-includes/post.php#L167
		 */
		add_action( 'init', [ $this, 'init' ], 0 ); // Highest priority.
	}

	/**
	 * Initialize.
	 * 
	 * @return void
	 */
	public function init() {
		register_post_type(
			'pronamic_pay_gf',
			[
				'label'              => __( 'Payment Feeds', 'pronamic-ideal' ),
				'labels'             => [
					'name'                  => __( 'Payment Feeds', 'pronamic-ideal' ),
					'singular_name'         => __( 'Payment Feed', 'pronamic-ideal' ),
					'add_new'               => __( 'Add New', 'pronamic-ideal' ),
					'add_new_item'          => __( 'Add New Payment Feed', 'pronamic-ideal' ),
					'edit_item'             => __( 'Edit Payment Feed', 'pronamic-ideal' ),
					'new_item'              => __( 'New Payment Feed', 'pronamic-ideal' ),
					'all_items'             => __( 'All Payment Feeds', 'pronamic-ideal' ),
					'view_item'             => __( 'View Payment Feed', 'pronamic-ideal' ),
					'search_items'          => __( 'Search Payment Feeds', 'pronamic-ideal' ),
					'not_found'             => __( 'No payment feeds found.', 'pronamic-ideal' ),
					'not_found_in_trash'    => __( 'No payment feeds found in Trash.', 'pronamic-ideal' ),
					'menu_name'             => __( 'Payment Feeds', 'pronamic-ideal' ),
					'filter_items_list'     => __( 'Filter payment feeds list', 'pronamic-ideal' ),
					'items_list_navigation' => __( 'Payment feeds list navigation', 'pronamic-ideal' ),
					'items_list'            => __( 'Payment feeds list', 'pronamic-ideal' ),
				],
				'public'             => false,
				'publicly_queryable' => false,
				'show_ui'            => false,
				'show_in_nav_menus'  => false,
				'show_in_menu'       => false,
				'show_in_admin_bar'  => false,
				'supports'           => [ 'title', 'revisions' ],
				'rewrite'            => false,
				'query_var'          => false,
			]
		);
	}
}
