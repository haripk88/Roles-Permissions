<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RazorpayService;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:payments_view')->only(['index', 'show']);
        $this->middleware('permission:payments_create')->only(['create', 'store']);
    }
    public function index()
    {
        $payments = Payment::where('user_id', auth()->id())
            ->latest()
            ->get();
        return view('payments.index', [
            'payments' => $payments
        ]);
    }

    public function createOrder(Request $request, RazorpayService $razorpay)
    {

        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        $order = $razorpay->createOrder($request->amount);

        Payment::create([
            'user_id' => auth()->id(),
            'razorpay_order_id' => $order['id'],
            'amount' => $request->amount,
            'currency' => 'INR',
            'status' => 'created',
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

            $payment = Payment::where(
                'razorpay_order_id',
                $request->razorpay_order_id
            )->first();

            if (!$payment || $payment->status == 'paid') {
                return response()->json([
                    'success' => false
                ]);
            }

            $user = auth()->user();

            // Add balance
            $user->wallet_balance += $payment->amount;
            $user->save();

            // Update payment
            $payment->update([
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature,
                'status' => 'paid',
                'payment_method' => 'razorpay',
                'remaining_balance' => $user->wallet_balance
            ]);

            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function purchase(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1'
        ]);

        $user = auth()->user();

        if ($user->wallet_balance < $request->amount) {
            return response()->json([
                'success' => false,
                'message' => 'You have insufficient balance'
            ]);
        }

        // Deduct balance
        $user->wallet_balance -= $request->amount;
        $user->save();

        // Create payment record
        Payment::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'currency' => 'INR',
            'status' => 'paid',
            'payment_method' => 'wallet',
            'type' => 'debit',
            'remaining_balance' => $user->wallet_balance
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Purchase successful'
        ]);
    }
}
