@extends('dashboard')

@section('dashboard-content')
<div class="animate__animated animate__fadeInUp">
    <div class="flex items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manage Payments</h1>
    </div>
    <div class="content-card">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Booking ID</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Example row, replace with @foreach($payments as $payment) --}}
                    <tr class="transition hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap font-mono text-sm text-gray-700">123456</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">admin@example.com</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Sample Villa</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${{ number_format($payment->amount, 2) }} {{ $payment->currency }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Paid
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2024-06-01</td>
                    </tr>
                    {{-- @endforeach --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
