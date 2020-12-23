<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaypalService;
class PaypalController extends Controller
{
    private $payment;
    public function __construct(){
        $this->payment = resolve(PaypalService::class);
    }

    public function pay(){
        return $this->payment->handlePayment();
    }

    public function approvalTransaction(){
        return $this->payment->capturePaymentOrder();
    }

    public function cancelledTransaction(){

    }

}