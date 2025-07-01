@extends('dashboard')

@section('dashboard-content')
<div class="animate__animated animate__fadeInUp">
    <div class="flex items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Welcome, {{ auth()->user()->name }}!</h1>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="content-card text-center transform hover:scale-105 transition-transform duration-300">
            <h3 class="text-lg font-semibold text-gray-500 mb-2">Payments Generated</h3>
            <p class="text-4xl font-bold text-harmostays-green">{{ $payments->count() }}</p>
        </div>
        <div class="content-card text-center transform hover:scale-105 transition-transform duration-300">
            <h3 class="text-lg font-semibold text-gray-500 mb-2">Total Spent</h3>
            <p class="text-4xl font-bold text-harmostays-orange">${{ number_format($payments->where('status', 'paid')->sum('amount'), 2) }}</p>
        </div>
    </div>
    <div class="mt-10">
        <a href="{{ route('payments.create') }}" class="content-card flex items-center justify-between transform hover:scale-105 transition-transform duration-300">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Generate a New Payment</h3>
                <p class="text-gray-500">Create a new booking and payment link.</p>
            </div>
            <svg class="w-8 h-8 text-harmostays-pink" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
        </a>
    </div>
</div>
@endsection
