<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to HarmoStays Secure Payment System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'harmostays-green': '#636f21',
                        'harmostays-orange': '#f05a28',
                        'harmostays-pink': '#dc0064'
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .gradient-bg {
            background: linear-gradient(135deg, #f05a28 0%, #dc0064 100%);
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .floating {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-18px); }
        }
        .fade-in {
            animation: fadeIn 1.2s cubic-bezier(.4,0,.2,1);
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .pulse-glow {
            animation: pulseGlow 2.2s infinite;
        }
        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 24px rgba(240, 90, 40, 0.25); }
            50% { box-shadow: 0 0 48px rgba(220, 0, 100, 0.45); }
        }
        .hover-lift {
            transition: all 0.3s cubic-bezier(.4,0,.2,1);
        }
        .hover-lift:hover {
            transform: translateY(-6px) scale(1.03);
            box-shadow: 0 24px 48px rgba(0,0,0,0.18);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Animated Background Circles -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-72 h-72 bg-white opacity-10 rounded-full floating"></div>
        <div class="absolute bottom-1/4 right-1/4 w-56 h-56 bg-white opacity-10 rounded-full floating" style="animation-delay: -2.5s;"></div>
        <div class="absolute top-3/4 left-1/3 w-40 h-40 bg-white opacity-10 rounded-full floating" style="animation-delay: -1.2s;"></div>
    </div>
    <!-- Main Content -->
    <div class="relative z-10 max-w-2xl mx-auto text-center fade-in">
        <!-- Logo -->
        <div class="mb-8 floating">
            <img src="{{ asset('main-logo.png') }}" alt="HarmoStays Logo" class="mx-auto h-28 w-auto filter drop-shadow-2xl pulse-glow" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
            <div style="display:none;" class="mx-auto h-28 w-28 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <span class="text-white font-bold text-2xl">HS</span>
            </div>
        </div>
        <!-- Welcome Card -->
        <div class="glass-effect rounded-3xl p-10 md:p-14 hover-lift shadow-xl animate__animated animate__fadeInUp">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4 leading-tight tracking-tight animate__animated animate__pulse animate__delay-1s">
                Welcome to <span class="text-harmostays-orange animate-pulse">HarmoStays</span> Secure Payment System
            </h1>
            <p class="text-xl md:text-2xl text-white text-opacity-90 mb-6 font-light animate__animated animate__fadeIn animate__delay-2s">
                Fast, safe, and modern crypto payments for your bookings.
            </p>
            <div class="flex flex-col md:flex-row gap-4 justify-center items-center mt-8">
                <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-4 bg-harmostays-green text-white font-semibold text-lg rounded-full hover:bg-green-700 transition-all duration-300 hover-lift group shadow-lg animate__animated animate__fadeInLeft">
                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Customer Login
                </a>
                <a href="{{ route('login') }}?admin=1" class="inline-flex items-center px-8 py-4 bg-harmostays-orange text-white font-semibold text-lg rounded-full hover:bg-orange-700 transition-all duration-300 hover-lift group shadow-lg animate__animated animate__fadeInRight">
                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Admin Login
                </a>
                <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-harmostays-pink text-white font-semibold text-lg rounded-full hover:bg-pink-700 transition-all duration-300 hover-lift group shadow-lg animate__animated animate__fadeInUp">
                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Register
                </a>
            </div>
        </div>
        <div class="mt-8 text-white text-opacity-70 text-sm animate__animated animate__fadeIn animate__delay-3s">
            <p>&copy; {{ date('Y') }} Harmo Stays and Tours. All rights reserved.</p>
        </div>
    </div>
    <!-- Animate.css CDN for extra effects -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</body>
</html>
