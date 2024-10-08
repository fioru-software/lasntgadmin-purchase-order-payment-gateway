<?php

namespace Lasntg\Admin\PaymentGateway\PurchaseOrder;

use Lasntg\Admin\Orders\OrderUtils;
use WP_REST_Request, WP_Error;

class PurchaseOrderApi {

	protected static $instance = null;

	const PATH_PREFIX = 'lasntgadmin/payment-gateway/purchase-order/v1';

	protected function __construct() {
		register_rest_route(
			self::PATH_PREFIX,
			'/statuses',
			[
				'methods' => 'POST',
				'callback' => [ self::class, 'post_update_purchase_order' ],
				'permission_callback' => [ self::class, 'auth_nonce' ],
			]
		);
	};

	public static function get_instance(): OrderApi {
		if ( null === self::$instance ) {
			self::$instance = new OrderApi();
		}
		return self::$instance;
	}

	public static function get_api_path(): string {
		return sprintf( '/%s', self::PATH_PREFIX );
	}

	/**
	 * @return bool|WP_Error
	 */
	public static function auth_nonce( WP_REST_Request $req ) {
		$nonce = $req->get_param( PurchaseOrderUtils::get_nonce_field_name() );
		die("nonce: $nonce");
		if ( ! wp_verify_nonce( $req->get_header( 'X-WP-Nonce' ), 'wp_rest' ) ) {
			return new WP_Error( 'invalid_nonce', 'Invalid nonce', array( 'status' => 403 ) );
		}
		return true;
	}

	/**
	 * @return int[]|WP_Error
	 */
	public static function post_update_purchase_order( WP_REST_Request $req ) {
		$po_number = $res->get_param('po_number_field');
		if( empty( $po_number ) ) {
			return new WP_Error( 'missing_po_number', 'Missing purchase order identifier', array( 'status', => 400 ) );
		}
	}

}

