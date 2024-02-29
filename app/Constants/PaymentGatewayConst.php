<?php
namespace App\Constants;
use Illuminate\Support\Str;

class PaymentGatewayConst {

    const AUTOMATIC = "AUTOMATIC";
    const MANUAL    = "MANUAL";
    const ADDMONEY  = "Add Money";
    const MONEYOUT  = "Money Out";
    const ACTIVE    =  true;
    const PAYMENTMETHOD  = "Payment Method";

    const ENV_SANDBOX       = "SANDBOX";
    const ENV_PRODUCTION    = "PRODUCTION";


    const PAYPAL                    = 'paypal';
    const G_PAY                     = 'gpay';
    const COIN_GATE                 = 'coingate';
    const QRPAY                     = 'qrpay';
    const TATUM                     = 'tatum';
    const STRIPE                    = 'stripe';
    const FLUTTERWAVE               = 'flutterwave';
    const SSLCOMMERZ                = 'sslcommerz';
    const RAZORPAY                  = 'razorpay';
    const PERFECT_MONEY             = 'perfect-money';
    const PAGADITO                  = 'pagadito';

    const PROJECT_CURRENCY_MULTIPLE = "PROJECT_CURRENCY_MULTIPLE";
    const PROJECT_CURRENCY_SINGLE   = "PROJECT_CURRENCY_SINGLE";
    const CALLBACK_HANDLE_INTERNAL  = "CALLBACK_HANDLE_INTERNAL";

    public static function add_money_slug() {
        return Str::slug(self::ADDMONEY);
    }

    public static function payment_method_slug() {
        return Str::slug(self::PAYMENTMETHOD);
    }


    public static function money_out_slug() {
        return Str::slug(self::MONEYOUT);
    }

    public static function register($alias = null) {
        $gateway_alias  = [
            self::PAYPAL        => "paypalInit",
            self::G_PAY         => "gpayInit",
            self::COIN_GATE     => "coinGateInit",
            self::QRPAY         => "qrpayInit",
            self::TATUM         => 'tatumInit',
            self::STRIPE        => 'stripeInit',
            self::FLUTTERWAVE   => 'flutterwaveInit',
            self::SSLCOMMERZ    => 'sslCommerzInit',
            self::RAZORPAY      => 'razorpayInit',
            self::PERFECT_MONEY => 'perfectMoneyInit',
            self::PAGADITO      => 'pagaditoInit'
        ];

        if($alias == null) {
            return $gateway_alias;
        }

        if(array_key_exists($alias,$gateway_alias)) {
            return $gateway_alias[$alias];
        }
        return "init";
    }
    public static function registerGatewayRecognization() {
        return [
            'isGpay'        => self::G_PAY,
            'isPaypal'      => self::PAYPAL,
            'isCoinGate'    => self::COIN_GATE,
            'isQrpay'       => self::QRPAY,
            'isTatum'       => self::TATUM,
            'isStripe'      => self::STRIPE,
            'isFlutterwave' => self::FLUTTERWAVE,
            'isSslCommerz'  => self::SSLCOMMERZ,
            'isRazorpay'    => self::RAZORPAY,
            'isPerfectMoney'    => self::PERFECT_MONEY,
            'isPagadito'        => self::PAGADITO
        ];
    }
    public static function apiAuthenticateGuard() {
        return [
            'api'   => 'web',
        ];
    }

    public static function registerRedirection() {
        return [
            
            'return_url'    => 'frontend.appointment.booking.payment.success',
            'cancel_url'    => 'frontend.appointment.booking.payment.cancel',
            'callback_url'  => 'frontend.appointment.booking.payment.callback',
            'btn_pay'       => 'frontend.appointment.booking.payment.btn.pay',
            'web'           => [
                'return_url'    => 'frontend.appointment.booking.payment.success',
                'cancel_url'    => 'frontend.appointment.booking.payment.cancel',
                'callback_url'  => 'frontend.appointment.booking.payment.callback',
                'btn_pay'       => 'frontend.appointment.booking.payment.btn.pay',
            ],
            'api'       => [
                'return_url'    => 'api.frontend.appointment.booking.payment.success',
                'cancel_url'    => 'api.frontend.appointment.booking.payment.cancel',
                'callback_url'  => 'frontend.appointment.booking.payment.callback',
                'btn_pay'       => 'api.frontend.appointment.booking.payment.btn.pay',
            ],
        ];
    }
}
