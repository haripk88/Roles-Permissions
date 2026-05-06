<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RazorpayService;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::where('user_id', auth()->id())->get();
        return view('payments.index', [
            'payments' => $payments
        ]);
    }

    public function createOrder(Request $request, RazorpayService $razorpay)
    {

        $order = $razorpay->createOrder($request->amount);

        $payment = Payment::create([
            'user_id' => auth()->id(),
            'razorpay_order_id' => $order['id'],
            'amount' => $request->amount,
            'status' => 'created'
        ]);

        return response()->json([
            'order_id' => $order['id'],
            'amount' => $order['amount']
        ]);
    }

    public function verify(Request $request, RazorpayService $razorpay)
    {
        try {
            $razorpay->verifySignature([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
            ]);

            $payment = Payment::where('razorpay_order_id', $request->razorpay_order_id)->first();

            $payment->update([
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'status' => 'paid'
            ]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Payment failed']);
        }
    }
}
