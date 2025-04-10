<?php

/**
 * The Axo module services.
 *
 * @package WooCommerce\PayPalCommerce\Axo
 */
declare (strict_types=1);
namespace WooCommerce\PayPalCommerce\AxoBlock;

use WooCommerce\PayPalCommerce\Button\Assets\SmartButtonInterface;
use WooCommerce\PayPalCommerce\Vendor\Psr\Container\ContainerInterface;
return array(
    // If AXO Block is configured and onboarded.
    'axoblock.available' => static function (ContainerInterface $container): bool {
        return \true;
    },
    'axoblock.url' => static function (ContainerInterface $container): string {
        /**
         * The path cannot be false.
         *
         * @psalm-suppress PossiblyFalseArgument
         */
        return plugins_url('/modules/ppcp-axo-block/', dirname(realpath(__FILE__), 3) . '/woocommerce-paypal-payments.php');
    },
    'axoblock.method' => static function (ContainerInterface $container): \WooCommerce\PayPalCommerce\AxoBlock\AxoBlockPaymentMethod {
        return new \WooCommerce\PayPalCommerce\AxoBlock\AxoBlockPaymentMethod($container->get('axoblock.url'), $container->get('ppcp.asset-version'), $container->get('axo.gateway'), fn(): SmartButtonInterface => $container->get('button.smart-button'), $container->get('wcgateway.settings'), $container->get('wcgateway.configuration.card-configuration'), $container->get('settings.environment'), $container->get('wcgateway.url'), $container->get('axo.payment_method_selected_map'), $container->get('axo.supported-country-card-type-matrix'));
    },
);
