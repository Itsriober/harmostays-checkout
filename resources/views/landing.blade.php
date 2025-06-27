<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HarmoStays - You seem to be lost</title>
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
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #f05a28 0%, #dc0064 100%);
        }
        
        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .fade-in {
            animation: fadeIn 1s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .pulse-glow {
            animation: pulseGlow 2s infinite;
        }
        
        @keyframes pulseGlow {
            0%, 100% { box-shadow: 0 0 20px rgba(240, 90, 40, 0.3); }
            50% { box-shadow: 0 0 40px rgba(240, 90, 40, 0.6); }
        }
        
        .hover-lift {
            transition: all 0.3s ease;
        }
        
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <!-- Background decorative elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-white opacity-5 rounded-full floating-animation"></div>
        <div class="absolute bottom-1/4 right-1/4 w-48 h-48 bg-white opacity-5 rounded-full floating-animation" style="animation-delay: -3s;"></div>
        <div class="absolute top-3/4 left-1/3 w-32 h-32 bg-white opacity-5 rounded-full floating-animation" style="animation-delay: -1.5s;"></div>
    </div>
    
    <!-- Main content -->
    <div class="relative z-10 max-w-2xl mx-auto text-center fade-in">
        <!-- Logo -->
        <div class="mb-8 floating-animation">
            <img src="{{ asset('main-logo.png') }}" alt="HarmoStays Logo" class="mx-auto h-24 w-auto filter drop-shadow-2xl">
        </div>
        
        <!-- Main card -->
        <div class="glass-effect rounded-3xl p-8 md:p-12 hover-lift">
            <!-- Icon -->
            <div class="mb-6">
                <div class="mx-auto w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center pulse-glow">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.47-.881-6.08-2.33M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>
            
            <!-- Heading -->
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 leading-tight">
                Oops! You seem to be lost
            </h1>
            
            <!-- Subheading -->
            <p class="text-xl md:text-2xl text-white text-opacity-90 mb-2 font-light">
                We believe you got here by mistake
            </p>
            
            <!-- Description -->
            <p class="text-lg text-white text-opacity-80 mb-8 leading-relaxed">
                This is our secure checkout system. You're probably looking for our main website where you can discover amazing stays and experiences.
            </p>
            
            <!-- CTA Button -->
            <div class="space-y-4">
                <a href="https://harmostays.com" 
                   class="inline-flex items-center px-8 py-4 bg-white text-harmostays-orange font-semibold text-lg rounded-full hover:bg-opacity-90 transition-all duration-300 hover-lift group">
                    <svg class="w-5 h-5 mr-2 group-hover:-translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Take me home
                </a>
                
                <!-- Secondary link -->
                <div class="text-white text-opacity-70 text-sm">
                    <p>Redirecting automatically in <span id="countdown">10</span> seconds...</p>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="mt-8 text-white text-opacity-60 text-sm">
            <p>&copy; {{ date('Y') }} Harmo Stays and Tours. All rights reserved.</p>
        </div>
    </div>
    
    <!-- JavaScript for countdown and redirect -->
    <script>
        let countdown = 20;
        const countdownElement = document.getElementById('countdown');
        
        const timer = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;
            
            if (countdown <= 0) {
                clearInterval(timer);
                window.location.href = 'https://harmostays.com';
            }
        }, 1000);
        
        // Add some interactive effects
        document.addEventListener('mousemove', (e) => {
            const cards = document.querySelectorAll('.glass-effect');
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;
            
            cards.forEach(card => {
                const rect = card.getBoundingClientRect();
                const cardX = (rect.left + rect.width / 2) / window.innerWidth;
                const cardY = (rect.top + rect.height / 2) / window.innerHeight;
                
                const deltaX = (x - cardX) * 10;
                const deltaY = (y - cardY) * 10;
                
                card.style.transform = `perspective(1000px) rotateX(${deltaY}deg) rotateY(${deltaX}deg)`;
            });
        });
    </script>
</body>
</html>
