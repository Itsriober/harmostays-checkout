<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - HarmoStays Secure Payment</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f0f2f5; }
        .sidebar-link { display: flex; align-items: center; padding: 0.75rem 1rem; border-radius: 0.5rem; transition: all 0.2s ease-in-out; font-weight: 600; }
        .sidebar-link:hover, .sidebar-link.active { background-color: #f05a28; color: white; box-shadow: 0 4px 12px rgba(240, 90, 40, 0.3); transform: translateY(-2px); }
        .sidebar-link svg { margin-right: 0.75rem; }
        .content-card { background-color: white; border-radius: 1rem; box-shadow: 0 10px 30px rgba(0,0,0,0.07); padding: 2rem; transition: all 0.3s ease; }
    </style>
</head>
<body class="antialiased">
<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 flex-shrink-0 bg-white shadow-lg flex flex-col">
        <div class="flex items-center justify-center p-4 border-b">
            <img src="{{ asset('main-logo.png') }}" alt="HarmoStays Logo" class="h-12 w-auto">
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a>
            <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Profile
            </a>
            <a href="{{ route('payments.create') }}" class="sidebar-link {{ request()->routeIs('payments.create') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Generate Payment
            </a>
            <a href="{{ route('payments.index') }}" class="sidebar-link {{ request()->routeIs('payments.index') ? 'active' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8"></path></svg>
                Payment History
            </a>
            @if(auth()->user() && auth()->user()->is_admin)
                <div class="pt-4 border-t">
                    <h6 class="px-4 text-xs font-bold text-gray-400 uppercase">Admin</h6>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link mt-2 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Admin Dashboard
                    </a>
                </div>
            @endif
        </nav>
        <div class="p-4 border-t">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center text-red-500 font-semibold p-3 rounded-lg hover:bg-red-100 transition">
                    <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 md:p-10 overflow-y-auto">
        @yield('dashboard-content')
    </main>
</div>
</body>
</html>
