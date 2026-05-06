<?php

namespace App\Services;

use Razorpay\Api\Api;

class RazorpayService
{
    protected $api;

    public function __construct()
    {
        $this->api = new Api(
            config('razorpay.key'),
            config('razorpay.secret')
        );
    }

    public function createOrder($amount)
    {
        return $this->api->order->create([
            'receipt' => 'order_' . time(),
            'amount' => $amount * 100,
            'currency' => 'INR'
        ]);
    }

    public function verifySignature($data)
    {
        return $this->api->utility->verifyPaymentSignature($data);
    }
}
