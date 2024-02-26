<?php

namespace Database\Seeders\Admin;

use App\Constants\PaymentGatewayConst;
use App\Models\Admin\PaymentGateway;
use App\Models\Admin\PaymentGatewayCurrency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $payment_gateways = array(
            
            array('id' => '5000' ,'slug' => 'payment-method','code' => '10015','type' => 'AUTOMATIC','name' => 'Paypal','title' => 'Paypal Gateway','alias' => 'paypal','image' => 'seeder/paypal.webp','credentials' => '[{"label":"Client ID","placeholder":"Enter Client ID","name":"client-id","value":"AbMgZu03hDEAs8aMK96dj52nCFfEEFd2nSffXsdf8NIBbOiogClRVFbsFqxqPjQHeb221XXCrZR2GXyZ"},{"label":"Secret ID","placeholder":"Enter Secret ID","name":"secret-id","value":"EHjAeQn76vtKvJBUipJ54BFqUrcuP4bB01xgbAGAn7q-p5WgtGzj6FFeEzXuTNEVaPtCcP4qKSwQu0sb"}]','supported_currencies' => '["USD","GBP","PHP","NZD","MYR","EUR","CNY","CAD","AUD"]','crypto' => '0','desc' => NULL,'input_fields' => NULL,'env' => 'SANDBOX','status' => '1','last_edit_by' => '1','created_at' => '2023-05-29 11:09:41','updated_at' => '2023-11-30 08:42:48'),

            array('id' => '5001' ,'slug' => 'payment-method','code' => '10020','type' => 'AUTOMATIC','name' => 'Stripe','title' => 'Stripe Gateway','alias' => 'stripe','image' => 'seeder/stripe.webp','credentials' => '[{"label":"Test Publishable Key","placeholder":"Enter Test Publishable Key","name":"test-publishable-key","value":"pk_test_51NECrlJXLo7QTdMco2E4YxHSeoBnDvKmmi0CZl3hxjGgH1JwgcLVUF3ZR0yFraoRgT7hf0LtOReFADhShAZqTNuB003PnBSlGP"},{"label":"Test Secret Key","placeholder":"Enter Test Secret Key","name":"test-secret-key","value":"sk_test_51NECrlJXLo7QTdMc2x7K5LaDuiS0MGNYHkO9dzzV0Y9XuWNZsXjECFsusjZEnqtxMIjCh3qtogc5sHHwL2oQ083900aFy1k7DE"},{"label":"Live Publishable Key","placeholder":"Enter Live Publishable Key","name":"live-publishable-key","value":null},{"label":"Live Secret Key","placeholder":"Enter Live Secret Key","name":"live-secret-key","value":null}]','supported_currencies' => '["USD","GBP","PHP","NZD","MYR","EUR","CNY","CAD","AUD","NGN"]','crypto' => '0','desc' => NULL,'input_fields' => NULL,'env' => 'SANDBOX','status' => '1','last_edit_by' => '1','created_at' => '2023-11-30 08:42:28','updated_at' => '2023-11-30 08:43:57'),

            array('id' => '5002' ,'slug' => 'payment-method','code' => '10025','type' => 'AUTOMATIC','name' => 'Flutterwave','title' => 'Flutterwave Gateway','alias' => 'flutterwave','image' => 'seeder/flutterwave.webp','credentials' => '[{"label":"Encryption key","placeholder":"Enter Encryption key","name":"encryption-key","value":"FLWSECK_TEST27bee2235efd"},{"label":"Secret key","placeholder":"Enter Secret key","name":"secret-key","value":"FLWSECK_TEST-da35e3dbd28be1e7dc5d5f3519e2ebef-X"}]','supported_currencies' => '["USD","GBP","PHP","NZD","MYR","EUR","CNY","CAD","AUD","NGN"]','crypto' => '0','desc' => NULL,'input_fields' => NULL,'env' => 'SANDBOX','status' => '1','last_edit_by' => '1','created_at' => '2023-11-30 08:49:31','updated_at' => '2023-11-30 08:51:26'),

            array('id' => '5003','slug' => 'payment-method','code' => '10030','type' => 'AUTOMATIC','name' => 'SSLCommerz','title' => 'SSLCommerz Payment Gateway For Sell Crypto','alias' => 'sslcommerz','image' => 'seeder/sslcommerz.webp','credentials' => '[{"label":"Store Id","placeholder":"Enter Store Id","name":"store-id","value":"appde6513b3970d62c"},{"label":"Store Password","placeholder":"Enter Store Password","name":"store-password","value":"appde6513b3970d62c@ssl"},{"label":"Sandbox Url","placeholder":"Enter Sandbox Url","name":"sandbox-url","value":"https:\\/\\/sandbox.sslcommerz.com"},{"label":"Live Url","placeholder":"Enter Live Url","name":"live-url","value":"https:\\/\\/securepay.sslcommerz.com"}]','supported_currencies' => '["BDT","EUR","GBP","AUD","USD","CAD"]','crypto' => '0','desc' => NULL,'input_fields' => NULL,'status' => '1','last_edit_by' => '1','created_at' => '2023-09-27 16:11:26','updated_at' => '2023-09-27 16:11:53','env' => 'SANDBOX'),
            
            array('id' => '5004','slug' => 'payment-method','code' => '10035','type' => 'AUTOMATIC','name' => 'Razorpay','title' => 'Razorpay Gateway','alias' => 'razorpay','image' => 'seeder/razor-pay.webp','credentials' => '[{"label":"Key ID","placeholder":"Enter Key ID","name":"key-id","value":"rzp_test_voV4gKUbSxoQez"},{"label":"Secret Key","placeholder":"Enter Secret Key","name":"secret-key","value":"cJltc1jy6evA4Vvh9lTO7SWr"}]','supported_currencies' => '["USD","EUR","GBP","SGD","AED","AUD","CAD","CNY","SEK","NZD","MXN","BDT","EGP","HKD","INR","LBP","LKR","MAD","MYR","NGN","NPR","PHP","PKR","QAR","SAR","UZS","GHS"]','crypto' => '0','desc' => NULL,'input_fields' => NULL,'env' => 'SANDBOX','status' => '1','last_edit_by' => '1','created_at' => '2023-11-09 17:26:21','updated_at' => '2023-11-09 17:36:05'),

            array('id' => '5005','slug' => 'payment-method','code' => '10040','type' => 'AUTOMATIC','name' => 'Pagadito','title' => 'Pagadito Payment gateway','alias' => 'pagadito','image' => 'seeder/pagadito.webp','credentials' => '[{"label":"UID","placeholder":"Enter UID","name":"uid","value":"b73eb3fa1dc8bea4b4363322c906a8fd"},{"label":"WSK","placeholder":"Enter WSK","name":"wsk","value":"dc843ff5865bac2858ad8f23af081256"},{"label":"base_url","placeholder":"Enter base_url","name":"base_url","value":"https:\\/\\/sandbox.pagadito.com"}]','supported_currencies' => '["USD","HNL","CRC","DOP","GTQ","NIO","PAB"]','crypto' => '0','desc' => NULL,'input_fields' => NULL,'env' => 'SANDBOX','status' => '1','last_edit_by' => '1','created_at' => '2024-01-08 04:05:40','updated_at' => '2024-01-08 04:05:40'),

            array('id' => '5006','slug' => 'payment-method','code' => '10045','type' => 'AUTOMATIC','name' => 'Perfect Money','title' => 'Perfect Money Gateway','alias' => 'perfect-money','image' => 'seeder/perfect-money.webp','credentials' => '[{"label":"USD Account","placeholder":"Enter USD Account","name":"usd-account","value":""},{"label":"EUR Account","placeholder":"Enter EUR Account","name":"eur-account","value":""},{"label":"Alternate Passphrase","placeholder":"Enter Alternate Passphrase","name":"alternate_passphrase","value":""}]','supported_currencies' => '["USD","EUR"]','crypto' => '0','desc' => NULL,'input_fields' => NULL,'env' => 'SANDBOX','status' => '1','last_edit_by' => '1','created_at' => '2023-12-30 16:05:59','updated_at' => '2024-01-03 06:22:22'),

            array('id' => '5007' ,'slug' => 'payment-method','code' => '10005','type' => 'AUTOMATIC','name' => 'CoinGate','title' => 'Crypto Payment gateway','alias' => 'coingate','image' => 'seeder/coin_gate.png','credentials' => '[{"label":"Sandbox URL","placeholder":"Enter Sandbox URL","name":"sandbox-url","value":"https:\\/\\/api-sandbox.coingate.com\\/v2"},{"label":"Sandbox App Token","placeholder":"Enter Sandbox App Token","name":"sandbox-app-token","value":"XJW4RyhT8F-xssX2PvaHMWJjYe5nsbsrbb2Uqy4m"},{"label":"Production URL","placeholder":"Enter Production URL","name":"production-url","value":"https:\\/\\/api.coingate.com\\/v2"},{"label":"Production App Token","placeholder":"Enter Production App Token","name":"production-app-token","value":null}]','supported_currencies' => '["USD","BTC","LTC","ETH","BCH","TRX","ETC","DOGE","BTG","BNB","TUSD","USDT","BSV","MATIC","BUSD","SOL","WBTC","RVN","BCD","ATOM","BTTC","EURT"]','crypto' => '1','desc' => NULL,'input_fields' => NULL,'env' => 'SANDBOX','status' => '1','last_edit_by' => '1','created_at' => '2023-08-07 10:36:30','updated_at' => '2023-08-07 12:06:12'),

            array('id' => '5008' ,'slug' => 'payment-method','code' => '10010','type' => 'AUTOMATIC','name' => 'Tatum','title' => 'Tatum Gateway','alias' => 'tatum','image' => 'seeder/tatum.jpg','credentials' => '[{"label":"Testnet","placeholder":"Enter Testnet","name":"test-net","value":"t-6582a4f67a5ea0001c55dab5-80ad272cb3324f9ba3a67ec3"},{"label":"Mainnet","placeholder":"Enter Mainnet","name":"main-net","value":"t-6582a4f67a5ea0001c55dab5-eed952f5e418465ea41aeedf"}]','supported_currencies' => '["BTC","ETH","SOL"]','crypto' => '1','desc' => NULL,'input_fields' => NULL,'env' => 'SANDBOX','status' => '1','last_edit_by' => '1','created_at' => '2023-11-07 17:05:37','updated_at' => '2023-11-07 17:44:00'),

        );

        PaymentGateway::upsert($payment_gateways,['code'],[]);

        $payment_gateway_currencies = array(
            
            array('payment_gateway_id' => '5000','name' => 'Paypal USD','alias' => 'payment-method-paypal-usd-automatic','currency_code' => 'USD','currency_symbol' => '$','image' => 'seeder/paypal.webp','min_limit' => '1','max_limit' => '1000.00000000','percent_charge' => '1.00000000','fixed_charge' => '2.00000000','rate' => '1','created_at' => '2023-11-30 07:22:48','updated_at' => '2023-11-30 08:42:48'),
            
            array('payment_gateway_id' => '5001','name' => 'Stripe AUD','alias' => 'payment-method-stripe-aud-automatic','currency_code' => 'AUD','currency_symbol' => 'A$','image' => 'seeder/stripe.webp','min_limit' => '1.00000000','max_limit' => '1000.00000000','percent_charge' => '1.00000000','fixed_charge' => '2.00000000','rate' => '1.52','created_at' => '2023-11-30 08:43:57','updated_at' => '2023-11-30 08:43:57'),
            
            array('payment_gateway_id' => '5002','name' => 'Flutterwave NGN','alias' => 'payment-method-flutterwave-ngn-automatic','currency_code' => 'NGN','currency_symbol' => '₦','image' => 'seeder/flutterwave.webp','min_limit' => '1.00000000','max_limit' => '1000.00000000','percent_charge' => '1.00000000','fixed_charge' => '2.00000000','rate' => '1605.05','created_at' => '2023-11-30 08:51:26','updated_at' => '2023-11-30 08:51:26'),

            array('payment_gateway_id' => '5003','name' => 'SSLCommerz BDT','alias' => 'payment-method-sslcommerz-bdt-automatic','currency_code' => 'BDT','currency_symbol' => '৳','image' => 'seeder/sslcommerz.webp','min_limit' => '100.00000000','max_limit' => '50000.00000000','percent_charge' => '0.00000000','fixed_charge' => '1.00000000','rate' => '110.07','created_at' => '2023-09-27 16:11:53','updated_at' => '2023-09-27 16:12:04'),

            array('payment_gateway_id' => '5004','name' => 'Razorpay USD','alias' => 'payment-method-razorpay-usd-automatic','currency_code' => 'USD','currency_symbol' => NULL,'image' => 'seeder/razor-pay.webp','min_limit' => '1.00000000','max_limit' => '1000.00000000','percent_charge' => '2.00000000','fixed_charge' => '1.00000000','rate' => '1','created_at' => '2023-11-09 17:36:05','updated_at' => '2023-11-09 17:36:05'),
            
            array('payment_gateway_id' => '5005','name' => 'Pagadito USD','alias' => 'payment-method-pagadito-usd-automatic','currency_code' => 'USD','currency_symbol' => '$','image' => 'seeder/pagadito.webp','min_limit' => '1.00000000','max_limit' => '1000.00000000','percent_charge' => '2.00000000','fixed_charge' => '1.00000000','rate' => '1','created_at' => '2024-01-08 04:11:48','updated_at' => '2024-01-08 04:12:21'),

            array('payment_gateway_id' => '5006','name' => 'Perfect Money USD','alias' => 'payment-method-perfect-money-usd-automatic','currency_code' => 'USD','currency_symbol' => '$','image' => 'seeder/perfect-money.webp','min_limit' => '1.00000000','max_limit' => '5000.00000000','percent_charge' => '2.00000000','fixed_charge' => '1.00000000','rate' => '1','created_at' => '2023-12-30 16:44:49','updated_at' => '2023-12-30 16:44:49'),
        
            array('payment_gateway_id' => '5007','name' => 'CoinGate USDT','alias' => 'payment-method-coingate-usdt-automatic','currency_code' => 'USDT','currency_symbol' => '$','image' => 'seeder/coin_gate.png','min_limit' => '1.00000000','max_limit' => '1000.00000000','percent_charge' => '3.00000000','fixed_charge' => '2.00000000','rate' => '1','created_at' => '2023-08-07 12:06:12','updated_at' => '2023-08-07 12:36:10'),
            
            array('payment_gateway_id' => '5008','name' => 'Tatum ETH','alias' => 'payment-method-tatum-eth-automatic','currency_code' => 'ETH','currency_symbol' => 'ETH','image' => 'seeder/tatum.jpg','min_limit' => '1','max_limit' => '1000.00000000','percent_charge' => '2.00000000','fixed_charge' => '1.00000000','rate' => '0.00034','created_at' => '2023-11-07 17:10:38','updated_at' => '2023-11-07 17:44:00'),
            
        );

        PaymentGatewayCurrency::upsert($payment_gateway_currencies,['alias'],[]);



    }
}
