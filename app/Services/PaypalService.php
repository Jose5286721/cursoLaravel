<?php
namespace App\Services;
use Illuminate\Http\Request;
use App\Traits\ConsumesExternalServices;

class PaypalService{
    use ConsumesExternalServices;

    protected $baseUri;
    protected $clientId;
    protected $clientSecret;

    public function __construct(){
        $this->baseUri = config('services.paypal.base_uri');
        $this->clientId = config('services.paypal.client_id');
        $this->clientSecret = config('services.paypal.client_secret');
    }

    public function resolveAuthorization(&$headers,&$formParams,&$queryParams){
        $headers['Authorization'] = $this->resolveAccessToken();
    }

    public function decodeResponse($response){
        return json_decode($response);
    }

    public function resolveAccessToken(){
        $credentials = base64_encode("{$this->clientId}:{$this->clientSecret}");
        return "Basic {$credentials}";
    }

    public function handlePayment(){
        $order = $this->createOrder(100.34,"usd");
        session()->put("order_id",$order->id);
        $links = collect($order->links);
        $approveLink = $links->where('rel','approve')->first();
        return redirect($approveLink->href);
    }

    public function capturePaymentOrder(){
        $orderId = session()->get('order_id');
        $response = $this->makeRequest(
            'POST',
            "/v2/checkout/orders/{$orderId}/capture",
            [],
            [],
            [
                "Content-Type" => "application/json",
            ]
        );
        return $response->payer->email_address;
    }

    public function createOrder($value,$currency){
        return $this->makeRequest(
            'POST',
            '/v2/checkout/orders',
            [],
            [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    0 => [
                        'amount' => [
                            'currency_code' => strtoupper($currency),
                            'value' => $value
                        ],
                    ],
                ],
                'application_context' => [
                        'brand_name' => env('app.name'),
                        'shipping_preference' => 'NO_SHIPPING',
                        'user_action' => 'PAY_NOW',
                        'return_url' => route('approbal'),
                        'cancel_url' => route('cancelled')
                ],
            ],
            [],
            $isJsonBody = true
        );
    }
}