@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500">
    <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full animate-fadeIn">
        <div class="flex flex-col items-center mb-6">
            <img src="/logo.png" alt="HarmoStays" class="w-20 h-20 mb-2 animate-bounce" />
            <h1 class="text-2xl font-bold text-gray-800">Confirm Your Booking</h1>
        </div>
        <div class="space-y-2 text-gray-700">
            <div><span class="font-semibold">Booking ID:</span> {{ $booking_id }}</div>
            <div><span class="font-semibold">Name:</span> {{ $user_name }}</div>
            <div><span class="font-semibold">Email:</span> {{ $user_email }}</div>
            <div><span class="font-semibold">Amount:</span> <span class="text-lg font-bold text-indigo-600">{{ $amount }} {{ $currency }}</span></div>
        </div>
        <form id="payForm" method="POST" action="{{ route('checkout.startPayment') }}" class="mt-8">
            @csrf
            <input type="hidden" name="booking_id" value="{{ $booking_id }}">
            <input type="hidden" name="user_id" value="{{ $user_id }}">
            <input type="hidden" name="user_name" value="{{ $user_name }}">
            <input type="hidden" name="user_email" value="{{ $user_email }}">
            <input type="hidden" name="amount" value="{{ $amount }}">
            <input type="hidden" name="currency" value="{{ $currency }}">
            <input type="hidden" name="signature" value="{{ $signature }}">
            <button type="button" onclick="showModal()" class="w-full py-3 px-6 bg-gradient-to-r from-indigo-500 to-pink-500 text-white font-bold rounded-lg shadow-lg hover:scale-105 transition-transform duration-200 animate-pulse">
                Pay with PayGate
            </button>
        </form>
    </div>
    <!-- Modal -->
    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-8 shadow-xl text-center animate-fadeInUp">
            <h2 class="text-xl font-bold mb-4">Ready to Pay?</h2>
            <p class="mb-6">You will be redirected to PayGate to complete your payment securely.</p>
            <div class="flex justify-center gap-4">
                <button onclick="hideModal()" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</button>
                <button onclick="submitPayForm()" class="px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 font-bold shadow">Proceed</button>
            </div>
        </div>
    </div>
</div>
<script>
function showModal() {
    document.getElementById('confirmModal').classList.remove('hidden');
}
function hideModal() {
    document.getElementById('confirmModal').classList.add('hidden');
}
function submitPayForm() {
    document.getElementById('payForm').submit();
}
</script>
@endsection
