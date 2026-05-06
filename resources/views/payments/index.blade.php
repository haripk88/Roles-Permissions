<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Payments') }}
            </h2>
            <div>
                <button class="px-4 py-2 bg-blue-500  hover:bg-blue-700 text-white rounded-md" onclick="payNow()">Pay Now</button>

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
            async function payNow() {
                let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                let response = await fetch('/create-order', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        amount: 500
                    })
                });

                let data = await response.json();
                console.log(data);
                var options = {
                    key: "{{ config('razorpay.key') }}",
                    amount: data.amount,
                    currency: "INR",
                    order_id: data.order_id,

                    handler: function(response) {
                        fetch('/verify-payment', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify(response)
                        });
                    }
                };

                var rzp = new Razorpay(options);
                rzp.open();
            }
        </script>
        <!-- <script>
            $(document).on('click', '.delete-btn', function() {
                let id = $(this).data('id');

                if (confirm('Are you sure you want to delete this payment?')) {
                    $.ajax({
                        url: '/payments/',
                        type: 'DELETE',
                        dataType: 'json',
                        data: {
                            'id': id
                        },
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            window.location.reload();
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                        }
                    });
                }
            });
        </script> -->
    </x-slot>
</x-app-layout>