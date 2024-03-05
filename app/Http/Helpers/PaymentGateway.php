<?php
namespace App\Http\Helpers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\AppliedCoupon;
use App\Models\TemporaryData;
use App\Models\Admin\Currency;
use App\Models\UserNotification;
use App\Models\DoctorAppointment;
use Illuminate\Support\Facades\DB;
use App\Models\Admin\BasicSettings;
use App\Traits\PaymentGateway\Gpay;
use App\Traits\PaymentGateway\QRPay;
use App\Traits\PaymentGateway\Tatum;
use Illuminate\Support\Facades\Auth;
use App\Traits\PaymentGateway\Paypal;
use App\Traits\PaymentGateway\Stripe;
use Illuminate\Support\Facades\Route;
use App\Constants\PaymentGatewayConst;
use App\Traits\PaymentGateway\CoinGate;
use App\Traits\PaymentGateway\Razorpay;
use App\Notifications\paypalNotification;
use App\Traits\PaymentGateway\SslCommerz;
use Illuminate\Support\Facades\Validator;
use App\Traits\PaymentGateway\Flutterwave;
use App\Models\Admin\PaymentGatewayCurrency;
use App\Traits\PaymentGateway\PagaditoTrait;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\ValidationException;
use App\Notifications\patientAppointmentNotification;
use App\Models\Admin\PaymentGateway as PaymentGatewayModel;
use App\Traits\PaymentGateway\PerfectMoney;

class PaymentGateway {

    use Paypal, CoinGate,Tatum, Stripe, Flutterwave, SslCommerz, Razorpay,PagaditoTrait,PerfectMoney;

    protected $request_data;
    protected $output;
    protected $currency_input_name = "identifier";
    protected $amount_input; //only used for callback data
    protected $project_currency = PaymentGatewayConst::PROJECT_CURRENCY_MULTIPLE;
    protected $predefined_user_wallet;
    protected $predefined_guard;
    protected $predefined_user;

    public function __construct(array $request_data)
    {
        $this->request_data = $request_data;
    }

    public static function init(array $data) {
        return new PaymentGateway($data);
    }

    public function setProjectCurrency(string $type) {
        
        $this->project_currency = $type;
        return $this;
    }

    public function gateway() {
        $request_data = $this->request_data;
        
        if(empty($request_data)) throw new Exception("Gateway Information is not available. Please provide payment gateway currency alias");
        $validated = $this->validator($request_data)->validate();
        
        $temporary_data     = DoctorAppointment::where('slug',$validated['identifier'])->first();
        $gateway_currency   = PaymentGatewayCurrency::with(['gateway'])->where("alias",$validated['payment_method'])->first();
       
        if(!$gateway_currency || !$gateway_currency->gateway) {
            if(request()->acceptsJson()) throw new Exception("Gateway not available");
            throw ValidationException::withMessages([
                $this->currency_input_name = "Gateway not available",
            ]);
        }
        
        $this->output['gateway']            = $gateway_currency->gateway;
        $this->output['currency']           = $gateway_currency;
        $this->output['amount']             = $this->amount();
        $this->output['form_data']          = $this->request_data;
       
        if($gateway_currency->gateway->isAutomatic()) {
            $this->output['distribute']         = $this->gatewayDistribute($gateway_currency->gateway);
            $this->output['record_handler']     = $this->generateRecordHandler();
        }else {
            $this->output['distribute']         = "handleManualPayment";
            $this->output['gateway_type']       = PaymentGatewayConst::MANUAL;
        }
        return $this;
    }

    public function generateRecordHandler() {
        
        if($this->predefined_guard) {
            $guard = $this->predefined_guard;
        }else {
            $guard = get_auth_guard();
        }

        $method = "insertRecord". ucwords($guard);
        
        return $method;
    }

   

    public function validator($data) {
        $validator = Validator::make($data,[
            'identifier'        => "required",
            'payment_method'    => "required",
        ]);

        if(request()->acceptsJson()) {
            if($validator->fails()) {
                $errors = $validator->errors()->all();
                $first_error = $errors[0];
                throw new Exception($first_error);
            }
        }

        return $validator;
    }



    public function get() {
        return $this->output;
    }

    public function gatewayDistribute($gateway = null) {
        
        if(!$gateway) $gateway = $this->output['gateway'];
        $alias = Str::lower($gateway->alias);
        $method = PaymentGatewayConst::register($alias);
        
        if(method_exists($this,$method)) {
            
            return $method;
        }
        throw new Exception("Gateway(".$gateway->name.") Trait or Method (".$method."()) does not exists");
    }

    public function amount() {
        $currency = $this->output['currency'] ?? null;
        
        if(!$currency) throw new Exception("Gateway currency not found");
        return $this->chargeCalculate($currency);
    }

    public function chargeCalculate($currency,$receiver_currency = null) {
        $temporary_data     = DoctorAppointment::where('slug',$this->request_data['identifier'])->first();
        $sender_currency_rate   = $currency->rate;
        
        $amount                 = $temporary_data->details->payable_amount * $sender_currency_rate;
        $fees                   = $temporary_data->details->total_charge;
        
        ($sender_currency_rate == "" || $sender_currency_rate == null) ? $sender_currency_rate = 0 : $sender_currency_rate;
        ($amount == "" || $amount == null) ? $amount : $amount;
        
        if($receiver_currency) {
            $receiver_currency_rate = $receiver_currency->rate;
            ($receiver_currency_rate == "" || $receiver_currency_rate == null) ? $receiver_currency_rate = 0 : $receiver_currency_rate;
            $exchange_rate  = ($receiver_currency_rate / $sender_currency_rate);
           

            $data = [
                'requested_amount'          => floatval($amount),
                'sender_cur_code'           => $currency->currency_code,
                'sender_cur_rate'           => $sender_currency_rate ?? 0,
                'receiver_cur_code'         => $receiver_currency->currency_code,
                'receiver_cur_rate'         => $receiver_currency->rate ?? 0,
                'total_charge'              => $fees,
                'total_amount'              => floatval($amount),
                'exchange_rate'             => $exchange_rate,
                'default_currency'          => get_default_currency_code(),
            ];
        }else {
            $default_currency   = Currency::default();
            $exchange_rate      = $default_currency->rate;
            
            $data = [
                'requested_amount'          => floatval($amount),
                'sender_cur_code'           => $currency->currency_code,
                'sender_cur_rate'           => $sender_currency_rate ?? 0,
                'total_charge'              => $fees,
                'total_amount'              => floatval($amount),
                'exchange_rate'             => $exchange_rate,
                'default_currency'          => get_default_currency_code(),
            ];
        }
        
        return (object) $data;
    }

    public function render() {
        $output = $this->output;
        if(isset($output['gateway_type']) && $output['gateway_type'] == PaymentGatewayConst::MANUAL) {
            return $this->get();
        }

        if(!is_array($output)) throw new Exception("Render Failed! Please call with valid gateway/credentials");

        $common_keys = ['gateway','currency','amount','distribute'];
        foreach($output as $key => $item) {
            if(!array_key_exists($key,$common_keys)) {
                $this->gateway();
                break;
            }
        }

        $distributeMethod = $this->output['distribute'];
        
        if(!method_exists($this,$distributeMethod)) throw new Exception("Something went wrong! Please try again.");
        return $this->$distributeMethod($output);
    }

    /**
     * Collect user data from temporary data and clears next routes
     */
    public function authenticateTempData(){
        $tempData = $this->request_data;
        
        if(empty($tempData) || empty($tempData['type'])) throw new Exception('Transaction failed. Record didn\'t saved properly. Please try again.');

        if($this->requestIsApiUser()) {
            $creator_table = $tempData['data']->creator_table ?? null;
            $creator_id = $tempData['data']->creator_id ?? null;
            $creator_guard = $tempData['data']->creator_guard ?? null;

            $api_authenticated_guards = PaymentGatewayConst::apiAuthenticateGuard();
            if(!array_key_exists($creator_guard,$api_authenticated_guards)) throw new Exception('Request user doesn\'t save properly. Please try again');

            if($creator_table == null || $creator_id == null || $creator_guard == null) throw new Exception('Request user doesn\'t save properly. Please try again');
            $creator = DB::table($creator_table)->where("id",$creator_id)->first();
            if(!$creator) throw new Exception("Request user doesn\'t save properly. Please try again");

            $api_user_login_guard = $api_authenticated_guards[$creator_guard];
            $this->output['api_login_guard'] = $api_user_login_guard;
            Auth::guard($api_user_login_guard)->loginUsingId($creator->id);
        }
        
        $currency_id = $tempData['data']->currency ?? "";
   
        $gateway_currency = PaymentGatewayCurrency::find($currency_id->id);
        if(!$gateway_currency) throw new Exception('Transaction failed. Gateway currency not available.');
        $requested_amount = $tempData['data']->amount->requested_amount ?? 0;
        
        $validator_data = [
            'identifier'  => $tempData['data']->user_record,
            'payment_method' => $tempData['data']->currency->alias
        ];
        
        $this->request_data = $validator_data;
       
        $this->gateway();
        
        $this->output['tempData'] = $tempData;

    }

    public function responseReceive() {
        $this->authenticateTempData();
        $method_name = $this->getResponseMethod($this->output['gateway']);
        
        if(method_exists($this,$method_name)) {
            return $this->$method_name($this->output);
        }
        throw new Exception("Response method ".$method_name."() does not exists.");
    }

    public function type($type) {
        $this->output['type']  = $type;
        return $this;
    }

    public function getRedirection() {
        $redirection = PaymentGatewayConst::registerRedirection();
        
        $guard = get_auth_guard();
        if($guard != ""){
            if(!array_key_exists($guard,$redirection)) {
                throw new Exception("Gateway Redirection URLs/Route Not Registered. Please Register in PaymentGatewayConst::class");
            }
            $gateway_redirect_route = $redirection[$guard];
            return $gateway_redirect_route;
        }else{
            
            return $redirection;
        }
        
    }

    public static function getToken(array $response, string $gateway) {
        switch($gateway) {
            case PaymentGatewayConst::PAYPAL:
                return $response['token'] ?? "";
                break;
            case PaymentGatewayConst::G_PAY:
                return $response['gpay_trans_id'] ?? "";
                break;
            case PaymentGatewayConst::COIN_GATE:
                return $response['token'] ?? "";
                break;
            case PaymentGatewayConst::QRPAY:
                return $response['token'] ?? "";
                break;
            case PaymentGatewayConst::STRIPE:
                return $response['token'] ?? "";
                break;
            case PaymentGatewayConst::FLUTTERWAVE:
                return $response['token'] ?? "";
                break;
            case PaymentGatewayConst::RAZORPAY:
                return $response['token'] ?? "";
                break;
            case PaymentGatewayConst::SSLCOMMERZ:
                return $response['token'] ?? "";
                break;
            case PaymentGatewayConst::PAGADITO:
                return $response['param1'] ?? "";
                break;
            case PaymentGatewayConst::PERFECT_MONEY:
                return $response['PAYMENT_ID'] ?? "";
                break;
            default:
                throw new Exception("Oops! Gateway not registered in getToken method");
        }
        throw new Exception("Gateway token not found!");
    }

    public function getResponseMethod($gateway) {

        $gateway_is = PaymentGatewayConst::registerGatewayRecognization();

        foreach($gateway_is as $method => $gateway_name) {
            if(method_exists($this,$method)) {
                if($this->$method($gateway)) {
                    return $this->generateSuccessMethodName($gateway_name);
                    break;
                }
            }
        }
        throw new Exception("Payment gateway response method not declared in generateResponseMethod");
    }

    public function getCallbackResponseMethod($gateway) {

        $gateway_is = PaymentGatewayConst::registerGatewayRecognization();
        foreach($gateway_is as $method => $gateway_name) {
            if(method_exists($this,$method)) {
                if($this->$method($gateway)) {
                    return $this->generateCallbackMethodName($gateway_name);
                    break;
                }
            }
        }

    }

    public function generateCallbackMethodName(string $name) {
        return $name . "CallbackResponse";
    }

    public function generateSuccessMethodName(string $name) {
        return $name . "Success";
    }

    function removeSpacialChar($string, $replace_string = "") {
        return preg_replace("/[^A-Za-z0-9]/",$replace_string,$string);
    }

    public function generateBtnPayResponseMethod(string $gateway)
    {
        $name = $this->removeSpacialChar($gateway,"");
        
        return $name . "BtnPay";
    }

    // Update Code (Need to check)
    public function createTransaction($output, $status,$temp_remove = true) {
        
        $basic_setting = BasicSettings::first();
        $record_handler = $output['record_handler'];
        
        if($this->predefined_user) {
            $user = $this->predefined_user;
        }else {
            $user = auth()->guard(get_auth_guard())->user();
        }
        $inserted_id = $this->$record_handler($output,$status);
        $trx_id     = DoctorAppointment::where('id',$inserted_id)->first();

        $data = DoctorAppointment::with(['doctors','schedules'])->where('slug',$output['form_data']['identifier'])->first();
        $from_time        = $data->schedules->from_time ?? '';
        $parsed_from_time = Carbon::createFromFormat('H:i', $from_time)->format('h A');

        $to_time          = $data->schedules->to_time ?? '';
        $parsed_to_time   = Carbon::createFromFormat('H:i', $to_time)->format('h A');
        if(auth()->check()){
            UserNotification::create([
                'user_id'  => auth()->user()->id,
                'message'  => "Your appointment (Doctor: ".$data->doctors->name.",
                Day: ".$data->schedules->week->day.", Time: ".$parsed_from_time."-".$parsed_to_time.", Serial Number: ".$data->patient_number.") Successfully booked.", 
            ]);
        }
        
        $trx_id     = Transaction::where('id',$inserted_id)->first();
        $form_data = [
            'name'               => $data->name,
            'email'              => $data->email,
            'phone'              => $data->phone,
            'type'               => $data->type,
            'gender'             => $data->gender,
            'schedule'           => $data->schedules->week->day,
            'doctor_name'        => $data->doctors->name,
            'doctor_speciality'  => $data->doctors->speciality,
            'from_time'          => $parsed_from_time,
            'to_time'            => $parsed_to_time,
            'serial_number'      => $data->patient_number,
            
        ];
        if( $basic_setting->email_notification == true){
            Notification::route("mail",$data->email)->notify(new patientAppointmentNotification($form_data));
        }
        if($temp_remove == true) {
            $this->removeTempData($output);
        }
        
        

        if($this->requestIsApiUser()) {
            // logout user
            $api_user_login_guard = $this->output['api_login_guard'] ?? null;
            if($api_user_login_guard != null) {
                auth()->guard($api_user_login_guard)->logout();
            }
        }
        return $this->output['trx_id'] ?? "";
        
    }

    

    public function insertRecord($output, $status) {
        $data  = DoctorAppointment::where('slug',$output['form_data']['identifier'])->first();
       
        if($this->predefined_user) {
            $user = $this->predefined_user;
        }else {
            $user = auth()->guard('web')->user();
        }
        $gateway_payable  = $data->details->payable_amount * $output['currency']->rate;
        $details                   = [
            'doctor_fees'       => $data->details->doctor_fees,
            'fixed_charge'      => $data->details->fixed_charge,
            'percent_charge'    => $data->details->percent_charge,
            'total_charge'      => $data->details->total_charge,
            'payable_amount'    => $data->details->payable_amount,
            'gateway_payable'   => $gateway_payable,
            'payment_method'    => $output['gateway']->name,
            'currency'          => get_default_currency_code(),
        ];
        
       
        DB::beginTransaction();
        try{
            $data->update([
                'status'          => $status,
                'details'         => $details,
                'callback_ref'    => $output['callback_ref'] ?? null,
            ]);
            
            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        return $data->id;
    }
    public function insertRecordWeb($output, $status) {
        $data  = DoctorAppointment::where('slug',$output['form_data']['identifier'])->first();
       
        if($this->predefined_user) {
            $user = $this->predefined_user;
        }else {
            $user = auth()->guard('web')->user();
        }
        $details                   = [
            'doctor_fees'       => $data->details->doctor_fees,
            'fixed_charge'      => $data->details->fixed_charge,
            'percent_charge'    => $data->details->percent_charge,
            'total_charge'      => $data->details->total_charge,
            'payable_amount'    => $data->details->payable_amount,
            'payment_method'    => $output['gateway']->name,
            'currency'          => get_default_currency_code(),
        ];
        
       
        DB::beginTransaction();
        try{
            $data->update([
                'status'    => $status,
                'details'   => $details
            ]);

            DB::commit();
        }catch(Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
        return $data->id;
    }

    public function removeTempData($output) {
        try{
            $id = $output['tempData']['id'];
            TemporaryData::find($id)->delete();
        }catch(Exception $e) {
            // handle error
        }
    }

    public function api() {
        $output = $this->output;
        if(!$output) throw new Exception("Something went wrong! Gateway render failed. Please call gateway() method before calling api() method");
        $sources = $this->setSource(PaymentGatewayConst::APP);
        $url_params = $this->makeUrlParams($sources);
        $this->setUrlParams($url_params);
        return $this;
    }

    public function setSource(string $source) {
        $sources = [
            'r-source'  => $source,
        ];

        return $sources;
    }

    public function makeUrlParams(array $sources) {
        try{
            $params = http_build_query($sources);
        }catch(Exception $e) {
            throw new Exception("Something went wrong! Failed to make URL Params.");
        }
        return $params;
    }

    public function setUrlParams(string $url_params) {
        $output = $this->output;
        if(!$output) throw new Exception("Something went wrong! Gateway render failed. Please call gateway() method before calling api() method");
        if(isset($output['url_params'])) {
            // if already param has
            $params = $this->output['url_params'];
            $update_params = $params . "&" . $url_params;
            $this->output['url_params'] = $update_params; // Update/ reassign URL Parameters
        }else {
            $this->output['url_params']  = $url_params; // add new URL Parameters;
        }
    }

    public function getUrlParams() {
        $output = $this->output;
        if(!$output || !isset($output['url_params'])) $params = "";
        $params = $output['url_params'] ?? "";
        
        return $params;
    }

    public function setGatewayRoute($route_name, $gateway, $params = null) {
        
        if(!Route::has($route_name)) throw new Exception('Route name ('.$route_name.') is not defined');
        if($params) {
            return route($route_name,$gateway."?".$params);
        }
        
        return route($route_name,$gateway);
    }

    public function requestIsApiUser() {
        $request_source = request()->get('r-source');
        if($request_source != null && $request_source == PaymentGatewayConst::APP) return true;
        return false;
    }

    public static function makePlainText($string) {
        $string = Str::lower($string);
        return preg_replace("/[^A-Za-z0-9]/","",$string);
    }

    public function searchWithReferenceInTransaction($reference) {

        $transaction = DB::table('doctor_appointments')->where('callback_ref',$reference)->first();

        if($transaction) {
            return $transaction;
        }

        return false;
    }

    public function handleCallback($reference,$callback_data,$gateway_name) {
        
        if($reference == PaymentGatewayConst::CALLBACK_HANDLE_INTERNAL) {
            $gateway = PaymentGatewayModel::gateway($gateway_name)->first();
            $callback_response_receive_method = $this->getCallbackResponseMethod($gateway);
            return $this->$callback_response_receive_method($callback_data, $gateway);
        }
        

        $transaction = DoctorAppointment::where('callback_ref',$reference)->first();
        $this->output['callback_ref']       = $reference;
        $this->output['capture']            = $callback_data;

        if($transaction) {
            
            $gateway_currency_id = $transaction->payment_gateway_currency_id;
            $gateway_currency = PaymentGatewayCurrency::find($gateway_currency_id);
            $gateway = $gateway_currency->gateway;
           
            $requested_amount = $transaction->request_amount;
            $validator_data = [
                $this->currency_input_name  => $transaction->remittance_data->user_record,
            ];

            // $user_wallet = $transaction->creator_wallet;
            // $this->predefined_user_wallet = $user_wallet;
            $this->predefined_guard = $transaction->user->modelGuardName();
            $this->predefined_user = $transaction->user;

            $this->output['transaction']    = $transaction;
            

        }else {
            // find reference on temp table
            $tempData = TemporaryData::where('identifier',$reference)->first();
            if($tempData) {
               
                
                $gateway_currency_id = $tempData->data->currency->id ?? null;
               
                $gateway_currency = PaymentGatewayCurrency::find($gateway_currency_id);
                
                if($gateway_currency) {
                   
                    $gateway = $gateway_currency->gateway;
                    
                    $requested_amount = $tempData['data']->amount->requested_amount ?? 0;
                    $validator_data = [
                        $this->currency_input_name  => $tempData->data->user_record,
                    ];

                    // $get_wallet_model = PaymentGatewayConst::registerWallet()[$tempData->data->creator_guard];
                    // $user_wallet = $get_wallet_model::find($tempData->data->wallet_id);
                    // $this->predefined_user_wallet = $user_wallet;
                    $user    = User::where('id',$tempData->data->creator_id)->first();
                    $this->predefined_guard = $user->modelGuardName(); // need to update
                    $this->predefined_user = $user;

                    $this->output['tempData'] = $tempData;
                    
                }
            }
        }
        
       
        if(isset($gateway)) {
            
            $this->request_data = $validator_data;
            $this->gateway();

            $callback_response_receive_method = $this->getCallbackResponseMethod($gateway);
            return $this->$callback_response_receive_method($reference, $callback_data, $this->output);
        }

        logger("Gateway not found!!" , [
            "reference"     => $reference,
            
        ]);
    }

    public static function getValueFromGatewayCredentials($gateway, $keywords) {
        $result = "";
        $outer_break = false;
        foreach($keywords as $item) {
            if($outer_break == true) {
                break;
            }
            $modify_item = PaymentGateway::makePlainText($item);
            foreach($gateway->credentials ?? [] as $gatewayInput) {
                $label = $gatewayInput->label ?? "";
                $label = PaymentGateway::makePlainText($label);

                if($label == $modify_item) {
                    $result = $gatewayInput->value ?? "";
                    $outer_break = true;
                    break;
                }
            }
        }
        return $result;
    }

    public function generateLinkForRedirectForm($token, $gateway)
    {
        $redirection = $this->getRedirection();
        $form_redirect_route = $redirection['redirect_form'];
        return route($form_redirect_route, [$gateway, 'token' => $token]);
    }

    /**
     * Link generation for button pay (JS checkout)
     */
    public function generateLinkForBtnPay($token, $gateway)
    {
        $redirection = $this->getRedirection();
        $form_redirect_route = $redirection['btn_pay'];
        return route($form_redirect_route, [$gateway, 'token' => $token]);
    }

    /**
     * Handle Button Pay (JS Checkout) Redirection
     */
    public function handleBtnPay($gateway, $request_data)
    {

        if(!array_key_exists('token', $request_data)) throw new Exception("Requested with invalid token");
        $temp_token = $request_data['token'];

        $temp_data = TemporaryData::where('identifier', $temp_token)->first();
        
        if(!$temp_data) throw new Exception("Requested with invalid token");
        
        $this->request_data = $temp_data->toArray();
        $this->authenticateTempData();
        
        $method = $this->generateBtnPayResponseMethod($gateway);
        
        if(method_exists($this, $method)) {
            return $this->$method($temp_data);
        }

        throw new Exception("Button Pay response method [" . $method ."()] not available in this gateway");
    }
}
