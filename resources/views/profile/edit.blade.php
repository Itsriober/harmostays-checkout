@extends('dashboard')

@section('dashboard-content')
<div class="max-w-xl mx-auto animate__animated animate__fadeInUp">
    <div class="flex flex-col items-center mb-8">
        <img src="{{ asset('uploads/Main-logo.png') }}" alt="HarmoStays Logo" class="h-20 w-auto mb-2 pulse-glow" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
        <div style="display:none;" class="h-20 w-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
            <span class="text-harmostays-orange font-bold text-xl">HS</span>
        </div>
        <h2 class="text-2xl font-bold text-harmostays-orange mt-2">My Profile</h2>
        <p class="text-gray-500">Update your account information below.</p>
    </div>
    <form method="POST" action="{{ route('profile.update') }}" class="space-y-6 glass-effect rounded-2xl p-8 shadow-lg">
        @csrf
        @method('patch')
        <div>
            <label class="block text-harmostays-green font-semibold mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-harmostays-orange">
        </div>
        <div>
            <label class="block text-harmostays-green font-semibold mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-harmostays-orange">
        </div>
        <div class="flex gap-4">
            <button type="submit" class="flex-1 bg-harmostays-orange text-white font-bold py-3 rounded-lg hover:bg-orange-700 transition hover-lift animate__animated animate__pulse animate__infinite">Update Profile</button>
            <a href="{{ route('dashboard') }}" class="flex-1 bg-gray-200 text-gray-700 font-bold py-3 rounded-lg hover:bg-gray-300 transition hover-lift">Cancel</a>
        </div>
    </form>
    <form method="POST" action="{{ route('profile.destroy') }}" class="mt-8 text-center animate__animated animate__fadeInUp animate__delay-1s">
        @csrf
        @method('delete')
        <button type="submit" class="bg-red-500 text-white font-bold px-6 py-2 rounded-lg hover:bg-red-700 transition hover-lift">Delete Account</button>
    </form>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        .glass-effect { background: rgba(255,255,255,0.15); backdrop-filter: blur(12px); border: 1px solid rgba(255,255,255,0.2); }
        .pulse-glow { animation: pulseGlow 2.2s infinite; }
        @keyframes pulseGlow { 0%, 100% { box-shadow: 0 0 24px rgba(240, 90, 40, 0.25); } 50% { box-shadow: 0 0 48px rgba(220, 0, 100, 0.45); } }
        .hover-lift { transition: all 0.3s cubic-bezier(.4,0,.2,1); }
        .hover-lift:hover { transform: translateY(-6px) scale(1.03); box-shadow: 0 24px 48px rgba(0,0,0,0.18); }
    </style>
</div>
@endsection
