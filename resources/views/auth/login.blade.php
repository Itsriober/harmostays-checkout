<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HarmoStays Secure Payment</title>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
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
        .hover-lift { transition: all 0.3s cubic-bezier(.4,0,.2,1); }
        .hover-lift:hover { transform: translateY(-6px) scale(1.03); box-shadow: 0 24px 48px rgba(0,0,0,0.18); }
        .pulse-glow { animation: pulseGlow 2.2s infinite; }
        @keyframes pulseGlow { 0%, 100% { box-shadow: 0 0 24px rgba(240, 90, 40, 0.25); } 50% { box-shadow: 0 0 48px rgba(220, 0, 100, 0.45); } }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md mx-auto glass-effect rounded-3xl shadow-xl p-8 animate__animated animate__fadeInDown">
        <div class="flex flex-col items-center mb-8">
            <img src="{{ asset('main-logo.png') }}" alt="HarmoStays Logo" class="h-20 w-auto mb-2 pulse-glow" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
            <div style="display:none;" class="h-20 w-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <span class="text-white font-bold text-xl">HS</span>
            </div>
            <h2 class="text-2xl font-bold text-white mt-2">Login to HarmoStays</h2>
        </div>
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            <div>
                <label class="block text-white font-semibold mb-1">Email</label>
                <input type="email" name="email" required autofocus class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-harmostays-orange">
            </div>
            <div>
                <label class="block text-white font-semibold mb-1">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-harmostays-orange">
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="mr-2">
                    <label for="remember" class="text-white">Remember me</label>
                </div>
                <a href="{{ route('password.request') }}" class="text-harmostays-pink hover:underline">Forgot password?</a>
            </div>
            <button type="submit" class="w-full bg-harmostays-orange text-white font-bold py-3 rounded-lg hover:bg-orange-700 transition hover-lift animate__animated animate__pulse animate__infinite">Login</button>
        </form>
        <div class="mt-6 text-center">
            <span class="text-white">Don't have an account?</span>
            <a href="{{ route('register') }}" class="text-harmostays-green font-semibold hover:underline ml-1">Register</a>
        </div>
    </div>
</body>
</html>
