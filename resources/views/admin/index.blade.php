@extends('dashboard')

@section('dashboard-content')
<div class="animate__animated animate__fadeInUp">
    <div class="flex items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="content-card text-center transform hover:scale-105 transition-transform duration-300">
            <h3 class="text-lg font-semibold text-gray-500 mb-2">Total Users</h3>
            <p class="text-4xl font-bold text-harmostays-green">1</p> {{-- Replace with dynamic count --}}
        </div>
        <div class="content-card text-center transform hover:scale-105 transition-transform duration-300">
            <h3 class="text-lg font-semibold text-gray-500 mb-2">Total Payments</h3>
            <p class="text-4xl font-bold text-harmostays-orange">1</p> {{-- Replace with dynamic count --}}
        </div>
        <div class="content-card text-center transform hover:scale-105 transition-transform duration-300">
            <h3 class="text-lg font-semibold text-gray-500 mb-2">Total Revenue</h3>
            <p class="text-4xl font-bold text-harmostays-pink">$500</p> {{-- Replace with dynamic sum --}}
        </div>
    </div>
    <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="{{ route('admin.users') }}" class="content-card flex items-center justify-between transform hover:scale-105 transition-transform duration-300">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Manage Users</h3>
                <p class="text-gray-500">View and manage all registered users.</p>
            </div>
            <svg class="w-8 h-8 text-harmostays-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
        </a>
        <a href="{{ route('admin.payments') }}" class="content-card flex items-center justify-between transform hover:scale-105 transition-transform duration-300">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Manage Payments</h3>
                <p class="text-gray-500">View and manage all payment transactions.</p>
            </div>
            <svg class="w-8 h-8 text-harmostays-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
        </a>
    </div>
</div>
@endsection
