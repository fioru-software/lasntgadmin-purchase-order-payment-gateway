<?php

namespace Lasntg\Admin\PaymentGateway\PurchaseOrder;

class PurchaseOrderUtils {

	public static function get_nonce_field_name(): string {
		return sprintf( '%s-nonce', self::get_kebab_case_name() );
	}

	public static function get_snake_case_name(): string {
        return 'lasntgadmin_purchase_order_payment_gateway';
    }

    public static function get_kebab_case_name(): string {
        return 'lasntgadmin-purchase-order-payment-gateway';
    }

    public static function get_absolute_plugin_path(): string {    
        return sprintf( '/var/www/html/wp-content/plugins/%s', self::get_kebab_case_name() );
    }

}
