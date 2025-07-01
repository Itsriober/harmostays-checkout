<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $payment->booking_id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap');
        body { font-family: 'Inter', sans-serif; }
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="max-w-2xl mx-auto my-10 bg-white rounded-lg shadow-lg p-8">
        <div class="flex justify-between items-center border-b pb-4 mb-6">
            <div>
                <img src="{{ asset('main-logo.png') }}" alt="HarmoStays Logo" class="h-16 w-auto">
                <h1 class="text-2xl font-bold text-gray-800 mt-2">Payment Receipt</h1>
            </div>
            <div class="text-right">
                <p class="text-gray-500">Booking ID: {{ $payment->booking_id }}</p>
                <p class="text-gray-500">Date: {{ $payment->paid_at->format('M d, Y') }}</p>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-6 mb-8">
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Billed To</h3>
                <p class="text-gray-600">{{ $payment->customer_name }}</p>
                <p class="text-gray-600">{{ $payment->customer_email }}</p>
            </div>
            <div class="text-right">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Payment Details</h3>
                <p class="text-gray-600">Transaction ID: {{ $payment->payment_transaction_id }}</p>
                <p class="text-gray-600">Payment Method: Crypto (PayGate)</p>
            </div>
        </div>
        <table class="w-full mb-8">
            <thead>
                <tr class="bg-gray-200">
                    <th class="text-left p-3">Description</th>
                    <th class="text-right p-3">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="p-3">{{ $payment->property_name }} - {{ $payment->booking_details }}</td>
                    <td class="text-right p-3">${{ number_format($payment->amount, 2) }} {{ $payment->currency }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="font-bold">
                    <td class="text-right p-3">Total Paid</td>
                    <td class="text-right p-3">${{ number_format($payment->amount, 2) }} {{ $payment->currency }}</td>
                </tr>
            </tfoot>
        </table>
        <div class="text-center text-gray-500 text-sm">
            <p>Thank you for your business!</p>
            <p>{{ env('APP_NAME') }}</p>
        </div>
        <div class="text-center mt-8 no-print">
            <button onclick="window.print()" class="bg-harmostays-orange text-white font-bold py-2 px-6 rounded-lg hover:bg-orange-700 transition">Print Receipt</button>
        </div>
    </div>
</body>
</html>
