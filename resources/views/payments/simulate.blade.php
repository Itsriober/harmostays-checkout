@extends('dashboard')

@section('dashboard-content')
<div class="max-w-xl mx-auto">
    <h2 class="text-2xl font-bold mb-6">Simulated Payment</h2>
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="mb-2"><span class="font-semibold">Booking ID:</span> {{ $payment->booking_id }}</div>
        <div class="mb-2"><span class="font-semibold">Property:</span> {{ $payment->property_name }}</div>
        <div class="mb-2"><span class="font-semibold">Customer:</span> {{ $payment->customer_name }} ({{ $payment->customer_email }})</div>
        <div class="mb-2"><span class="font-semibold">Booking Details:</span> {{ $payment->booking_details }}</div>
        <div class="mb-2"><span class="font-semibold">Amount:</span> ${{ number_format($payment->amount, 2) }} {{ $payment->currency }}</div>
        <div class="mb-2"><span class="font-semibold">Status:</span> <span class="font-semibold {{ $payment->status === 'paid' ? 'text-green-600' : ($payment->status === 'failed' ? 'text-red-600' : 'text-yellow-600') }}">{{ ucfirst($payment->status) }}</span></div>
    </div>
    @if($payment->status === 'pending')
    <form method="POST" action="{{ route('payments.simulate.pay', $payment->booking_id) }}">
        @csrf
        <button type="submit" class="bg-harmostays-orange text-white font-semibold px-6 py-2 rounded hover:bg-orange-600 transition">Simulate Successful Payment</button>
    </form>
    <form method="POST" action="{{ route('payments.simulate.fail', $payment->booking_id) }}" class="mt-2">
        @csrf
        <button type="submit" class="bg-red-500 text-white font-semibold px-6 py-2 rounded hover:bg-red-700 transition">Simulate Failed Payment</button>
    </form>
    @else
    <div class="text-green-700 font-semibold">Payment already processed.</div>
    <a href="{{ route('dashboard') }}" class="inline-block mt-4 bg-harmostays-green text-white px-4 py-2 rounded hover:bg-green-700 transition">Go to Dashboard</a>
    @endif
</div>
@endsection
