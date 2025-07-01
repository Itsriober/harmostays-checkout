<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification - HarmoStays Secure Payment</title>
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
            <h2 class="text-2xl font-bold text-white mt-2">Verify Your Email Address</h2>
        </div>
        @if (session('status') === 'verification-link-sent')
            <div class="mb-4 text-green-600 font-semibold text-center animate__animated animate__fadeInUp">
                A new verification link has been sent to your email address.
            </div>
        @endif
        <p class="text-white text-opacity-80 mb-6">Before proceeding, please check your email for a verification link. If you did not receive the email, you can request another below.</p>
        <form method="POST" action="{{ route('verification.send') }}" class="space-y-6">
            @csrf
            <button type="submit" class="w-full bg-harmostays-orange text-white font-bold py-3 rounded-lg hover:bg-orange-700 transition hover-lift animate__animated animate__pulse animate__infinite">Resend Verification Email</button>
        </form>
        <div class="mt-6 text-center">
            <a href="{{ route('logout') }}" class="text-harmostays-pink font-semibold hover:underline">Logout</a>
        </div>
    </div>
</body>
</html>
