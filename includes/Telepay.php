<?php

namespace TonGateway;

use WC_Payment_Gateway;
use TelePay\TelePayEnvironment;
use TelePay\TelePayClient;
use TelePay\TelePayInvoiceInput;

add_action('init', function () {


    class Telepay extends WC_Payment_Gateway {

        public $testmode;
        public $secret_key;
        public $public_key;

        public function __construct()
        {
            $this->id = 'telepay';
            $this->icon = plugins_url('Telepay/icon.png', __FILE__);
            // $this->has_fields = true; // in case you need a custom credit card form
            $this->method_title = 'Telepay';
            $this->method_description = 'Payments via TON (Toncoin, The Open Network)'; // will be displayed on the options page

            // gateways can support subscriptions, refunds, saved payment methods,
            // but we begin with simple payments
            $this->supports = array(
                'products'
            );

            // Method with all the options fields
            $this->init_form_fields();

            // Load the settings.
            $this->init_settings();
            $this->title = $this->get_option('title');
            $this->description = $this->get_option('description');
            $this->enabled = $this->get_option('enabled');
            $this->testmode = 'yes' === $this->get_option('testmode');
            $this->public_key = $this->get_option('public_key');
            $this->secret_key = $this->get_option('secret_key');

            // This action hook saves the settings
            add_action('woocommerce_update_options_payment_gateways_' . $this->id, array($this, 'process_admin_options'));
            if ($this->enabled) {
                require_once(__DIR__ . '/Telepay/vendor/autoload.php');
            }
            add_action('woocommerce_receipt_' . $this->id, array(&$this, 'display_form'));

            // We need custom JavaScript to obtain a token
            // add_action('wp_enqueue_scripts', array($this, 'payment_scripts'));

            // You can also register a webhook here
            // add_action( 'woocommerce_api_{webhook name}', array( $this, 'webhook' ) );

        }

        function display_form($order_id)
        {
            $order = wc_get_order($order_id);

            $data = $order->get_meta('ton_invoice');
            dd($order->get_total());

            $link = sprintf('<a href="%1$s">%1$s</a>', $data['checkout_url']);
            printf('<p>Payment by link: %s</p>', $link);

            printf('<p>Amount: %s</p>', $data['amount']);
            printf('<p>TON URL: %s</p>', $data['onchain_url']);

        }

        public function init_form_fields()
        {
            $this->form_fields = array(
                'enabled' => array(
                    'title' => 'Enable/Disable',
                    'type' => 'checkbox',
                    'description' => '',
                    'default' => 'no'
                ),
                'title' => array(
                    'title' => 'Title',
                    'type' => 'text',
                    'description' => 'This controls the title which the user sees during checkout.',
                    'default' => 'Pay by TON (Toncoin)',
                    'desc_tip' => true,
                ),
                'description' => array(
                    'title' => 'Description',
                    'type' => 'textarea',
                    'description' => 'This controls the description which the user sees during checkout.',
                    'default' => 'Pay with your credit card via our super-cool payment gateway.',
                ),
                'testmode' => array(
                    'title' => 'Test mode',
                    'label' => 'Enable Test Mode',
                    'type' => 'checkbox',
                    'description' => 'Place the payment gateway in test mode using test API keys.',
                    'default' => 'yes',
                    'desc_tip' => true,
                ),
                'public_key' => array(
                    'title' => 'Public key',
                    'type' => 'text'
                ),
                'secret_key' => array(
                    'title' => 'Secret key',
                    'type' => 'password'
                )
            );
        }

        /*
         * We're processing the payments here, everything about it is in Step 5
         */
        public function process_payment($order_id)
        {
            $order = wc_get_order($order_id);

            //todo - add currency rate converter
            $amount = $order->get_total();
            $type_net = $this->testmode ? 'testnet' : 'mainnet';

            $environment = new TelePayEnvironment($this->secret_key);
            $telepay = new TelePayClient($environment);
            $invoice = new TelePayInvoiceInput("TON", "TON", $type_net, $amount);
            $invoice->setDescription("Payment from: " . site_url());
            $invoice->setMetadata([
                "order_id" => $order_id,
                "full_name" => $order->get_formatted_billing_full_name(),
            ]);
            $invoice->setSuccessUrl($order->get_checkout_order_received_url());
            $invoice->setCancelUrl($order->get_checkout_order_received_url());

            $invoice_array = $telepay->createInvoice($invoice);

            $order->update_meta_data('ton_invoice', $invoice_array);
            $order->save();

            return array(
                'result' => 'success',
                'redirect' => $order->get_checkout_payment_url(true)
            );
        }

    }


    add_filter('woocommerce_payment_gateways', __NAMESPACE__ . '\\add_gateway');
    function add_gateway($gateways)
    {
        $gateways[] = __NAMESPACE__ . '\\Telepay';
        return $gateways;
    }
});