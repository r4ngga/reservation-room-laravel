<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - MYRR</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @yield('style')
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col transition-all duration-300">
            <div class="p-6">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <span class="text-2xl font-bold bg-indigo-600 text-white px-2 py-1 rounded">MyRR</span>
                </div>
                
                <!-- Navigation -->
                <nav class="mt-10 space-y-2">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Main Menu</p>
                    
                    @php
                        $currentRoute = Route::currentRouteName();
                        $isAdmin = auth()->user()->role == 1;
                        $dashboardRoute = $isAdmin ? 'admin' : 'client';
                    @endphp

                    <a href="{{ route($dashboardRoute) }}" 
                       class="flex items-center py-2.5 px-4 rounded transition duration-200 {{ Request::is('admin') || Request::is('client') ? 'bg-teal-500 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                        <i class="fas fa-th-large w-5 mr-3"></i>
                        Dashboard
                    </a>

                    @if($isAdmin)
                        <!-- Admin Links -->
                        <a href="{{ route('room') }}" 
                           class="flex items-center py-2.5 px-4 rounded transition duration-200 {{ Request::is('room*') ? 'bg-teal-500 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-door-open w-5 mr-3"></i>
                            Rooms
                        </a>
                        <a href="{{ route('reservation') }}" 
                           class="flex items-center py-2.5 px-4 rounded transition duration-200 {{ Request::is('reservation*') ? 'bg-teal-500 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-calendar-check w-5 mr-3"></i>
                            Confirmations
                        </a>
                        <a href="{{ route('users') }}" 
                           class="flex items-center py-2.5 px-4 rounded transition duration-200 {{ Request::is('users*') ? 'bg-teal-500 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-users w-5 mr-3"></i>
                            Users
                        </a>
                    @else
                        <!-- User Links -->
                        <a href="{{ route('rooms') }}" 
                           class="flex items-center py-2.5 px-4 rounded transition duration-200 {{ Request::is('rooms*') ? 'bg-teal-500 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-bed w-5 mr-3"></i>
                            Book a Room
                        </a>
                    @endif

                    <div class="pt-4">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Preferences</p>
                        <a href="{{ route('setting') }}" 
                           class="flex items-center py-2.5 px-4 rounded transition duration-200 {{ Request::is('setting*') ? 'bg-teal-500 text-white shadow-md' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-cog w-5 mr-3"></i>
                            Settings
                        </a>
                        <a href="{{ route('logout') }}" 
                           class="flex items-center py-2.5 px-4 rounded transition duration-200 text-red-500 hover:bg-red-50">
                            <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                            Log out
                        </a>
                    </div>
                </nav>
            </div>

            <!-- User Card -->
            <div class="mt-auto p-4 border-t border-gray-100">
                <div class="bg-indigo-50 p-4 rounded-xl">
                    <div class="flex items-center justify-between mb-1">
                         <span class="text-sm font-bold text-gray-800 truncate w-32">{{ auth()->user()->name }}</span>
                         <span class="text-[10px] px-1.5 py-0.5 bg-indigo-200 text-indigo-700 rounded uppercase font-bold">{{ auth()->user()->role == 1 ? 'Admin' : 'User' }}</span>
                    </div>
                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto bg-gray-50">
            <header class="h-16 flex items-center justify-between px-8">
                 <h1 class="text-xl font-semibold text-gray-800">@yield('page_title', 'Dashboard')</h1>
                 <div class="flex items-center space-x-4">
                    <div class="relative">
                        <input type="text" placeholder="Search..." class="bg-white border-none rounded-lg px-4 py-2 text-sm shadow-sm focus:ring-2 focus:ring-teal-500 transition-all w-64 lg:w-80">
                        <i class="fas fa-search absolute right-3 top-2.5 text-gray-400"></i>
                    </div>
                 </div>
            </header>
            
            <div class="p-8">
                @yield('content')
            </div>
        </main>
    </div>
    
    @yield('scripts')
</body>
</html>
