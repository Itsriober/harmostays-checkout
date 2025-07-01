@extends('dashboard')

@section('dashboard-content')
<div class="max-w-xl mx-auto text-center fade-in">
    <div class="relative bg-gradient-to-br from-harmostays-pink via-harmostays-orange to-red-600 rounded-3xl shadow-xl p-10 mb-8 animate__animated animate__fadeInDown">
        <div class="flex justify-center mb-6">
            <div class="bg-white bg-opacity-80 rounded-full p-6 shadow-lg pulse-glow animate__animated animate__shakeX">
                <svg class="w-16 h-16 text-red-600 animate__animated animate__headShake animate__delay-1s" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                    <path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 9l6 6m0-6l-6 6"/>
                </svg>
            </div>
        </div>
        <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-2 animate__animated animate__fadeInUp">Payment Failed</h2>
        <p class="mb-4 text-lg text-white animate__animated animate__fadeIn animate__delay-1s">Your payment for <span class="font-semibold">{{ $payment->property_name }}</span> was not successful.</p>
        <div class="mb-2 text-white"><span class="font-semibold">Booking ID:</span> {{ $payment->booking_id }}</div>
        <div class="mb-2 text-white"><span class="font-semibold">Amount:</span> ${{ number_format($payment->amount, 2) }} USDC</div>
        <div class="mb-2 text-white"><span class="font-semibold">Status:</span> <span class="text-red-200 font-semibold animate__animated animate__flash animate__infinite">Failed</span></div>
    </div>
    <a href="{{ route('dashboard') }}" class="inline-block bg-harmostays-orange text-white px-8 py-3 rounded-full font-bold text-lg shadow-lg hover:bg-orange-700 transition-all duration-300 hover-lift animate__animated animate__pulse animate__infinite">Go to Dashboard</a>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        .fade-in { animation: fadeIn 1.2s cubic-bezier(.4,0,.2,1); }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }
        .pulse-glow { animation: pulseGlow 2.2s infinite; }
        @keyframes pulseGlow { 0%, 100% { box-shadow: 0 0 24px rgba(240, 90, 40, 0.25); } 50% { box-shadow: 0 0 48px rgba(220, 0, 100, 0.45); } }
        .hover-lift { transition: all 0.3s cubic-bezier(.4,0,.2,1); }
        .hover-lift:hover { transform: translateY(-6px) scale(1.03); box-shadow: 0 24px 48px rgba(0,0,0,0.18); }
    </style>
</div>
@endsection
