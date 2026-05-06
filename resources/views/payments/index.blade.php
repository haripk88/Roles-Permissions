<div id="paymentModal"
    class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">

    <div class="bg-white p-6 rounded-lg w-[500px]">

        <h2 class="text-xl font-bold mb-4">
            Add Wallet Balance
        </h2>

        <input
            type="number"
            id="paymentAmount"
            placeholder="Enter Amount"
            class="w-full border rounded px-3 py-2 mb-4">

        <div class="flex justify-end gap-2">

            <button onclick="closePaymentModal()"
                class="px-4 py-2 bg-gray-400 text-white rounded">
                Cancel
            </button>

            <button onclick="payNow()"
                class="px-4 py-2 bg-blue-500 text-white rounded">
                Continue
            </button>

        </div>

    </div>
</div>

<div id="purchaseModal"
    class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">

    <div class="bg-white p-6 rounded-lg w-[500px]">

        <h2 class="text-xl font-bold mb-4">
            Purchase Item
        </h2>

        <input
            type="number"
            id="purchaseAmount"
            placeholder="Enter Amount"
            class="w-full border rounded px-3 py-2 mb-4">

        <div class="flex justify-end gap-2">

            <button onclick="closePurchaseModal()"
                class="px-4 py-2 bg-gray-400 text-white rounded">
                Cancel
            </button>

            <button onclick="purchaseNow()"
                class="px-4 py-2 bg-blue-500 text-white rounded">
                Purchase
            </button>

        </div>

    </div>
</div>

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Payments') }}
            </h2>
            <div class="mb-4 text-lg font-bold text-green-600">
                Wallet Balance:
                ₹{{ auth()->user()->wallet_balance }}
            </div>
            <div>
                <button class="px-4 py-2 bg-blue-500  hover:bg-blue-700 text-white rounded-md" onclick="openPaymentModal()">Pay Now</button>
                <button class="px-4 py-2 bg-blue-500  hover:bg-blue-700 text-white rounded-md" onclick="openPurchaseModal()">Purchase</button>

            </div>

        </div>
    </x-slot>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message />
            <table class="w-full">
                <thead class="bg-gray-100">
                    <tr class="border-b">
                        <th class="px-6 py-3 text-left">#</th>
                        <th class="px-6 py-3 text-left">User</th>
                        <th class="px-6 py-3 text-left">Amount</th>
                        <th class="px-6 py-3 text-left">Payment Type</th>
                        <th class="px-6 py-3 text-left">Currency</th>
                        <th class="px-6 py-3 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white-500">
                    @if($payments->isNotEmpty())
                    @foreach($payments as $payment)
                    <tr class="border-b">
                        <td class="px-6 py-4 text-left">{{ $payment->id }}</td>
                        <td class="px-6 py-4 text-left">{{ $payment->user->name }}</td>
                        <td class="px-6 py-4 text-left">{{ $payment->amount }}</td>
                        <td class="px-6 py-4 text-left">{{ $payment->type }}</td>
                        <td class="px-6 py-4 text-left">{{ $payment->currency }}</td>
                        <td class="px-6 py-4 text-center">
                            {{ $payment->status }}
                        </td>
                        @endforeach
                        @else
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center">No payments found.</td>
                    </tr>
                    @endif
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <x-slot name="script">
        <script>
            function openPurchaseModal() {
                document.getElementById('purchaseModal').classList.remove('hidden');
            }

            function closePurchaseModal() {
                document.getElementById('purchaseModal').classList.add('hidden');
            }

            function purchaseNow() {
                let amount = document.getElementById('purchaseAmount').value;

                if (!amount || amount <= 0) {
                    alert('Please enter a valid amount');
                    return;
                }

                let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch('/purchase-order', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        amount: amount
                    }),
                }).then(res => res.json()).then(data => {
                    if (data.success) {
                        alert('Purchase Successful');
                        window.location.reload();
                    } else {
                        alert('Purchase Failed');
                    }
                })
            }

            function openPaymentModal() {
                document.getElementById('paymentModal')
                    .classList.remove('hidden');
            }

            function closePaymentModal() {
                document.getElementById('paymentModal')
                    .classList.add('hidden');
            }

            async function payNow() {
                let amount = document.getElementById('paymentAmount').value;

                if (!amount || amount <= 0) {
                    alert('Please enter valid amount');
                    return;
                }

                let token = document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content');

                let response = await fetch('/create-order', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        amount: amount
                    })
                });

                let data = await response.json();

                var options = {

                    key: "{{ config('razorpay.key') }}",

                    amount: data.amount,

                    currency: "INR",

                    order_id: data.order_id,

                    handler: async function(response) {
                        let verify = await fetch('/verify-payment', {

                            method: 'POST',

                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },

                            body: JSON.stringify(response)
                        });

                        let verifyData = await verify.json();

                        if (verifyData.success) {

                            alert('Payment Successful');

                            window.location.reload();

                        } else {

                            alert('Payment Failed');
                        }
                    }
                };

                var rzp = new Razorpay(options);

                rzp.open();

                closePaymentModal();
            }
        </script>
    </x-slot>
</x-app-layout>