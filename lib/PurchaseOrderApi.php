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
			'/update',
			[
				'methods' => 'POST',
				'callback' => [ self::class, 'post_update_purchase_order' ],
				'permission_callback' => '__return_true'
			]
		);
	}

	public static function get_instance(): PurchaseOrderApi {
		if ( null === self::$instance ) {
			self::$instance = new PurchaseOrderApi();
		}
		return self::$instance;
	}

	public static function get_api_path(): string {
		return sprintf( '/%s', self::PATH_PREFIX );
	}

	/**
	 * @return int[]|WP_Error
	 */
	public static function post_update_purchase_order( WP_REST_Request $req ) {
		$po_number = $req->get_param('po_number_field');
		$order_id = $req->get_param('order_id');
		if( empty( $po_number ) ) {
			return new WP_Error( 'missing_po_number', 'Missing purchase order identifier', array( 'status' => 400 ) );
		}
		if( empty($order_id ) ) {
			return new WP_Error( 'missing_order_id', 'Missing order id', array( 'status' => 400 ) );
		}
		$order = wc_get_order( $order_id );
		$order->update_meta_data('_po_number', $po_number);
		$order->save();
		return (object)[
			'http_referer' => $req->get_param('_wp_http_referer'),
			'order_id' => $order_id,
			'po_number' => $po_number
		];
	}

}

