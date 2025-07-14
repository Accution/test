<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Booking System') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        [x-cloak] { display: none !important; }
        .sidebar-gradient {
            background: #181F2A;
            box-shadow: 2px 0 24px 0 rgba(24,31,42,0.12);
        }
        .sidebar-item {
            transition: all 0.3s cubic-bezier(.4,0,.2,1);
            border-radius: 1rem;
            margin-bottom: 0.25rem;
            font-size: 1rem;
            font-weight: 500;
            padding: 0.75rem 1.25rem;
        }
        .sidebar-item.active, .sidebar-item[aria-current="page"] {
            background: linear-gradient(90deg, #6C63FF 0%, #48C6EF 100%);
            color: #fff !important;
            box-shadow: 0 2px 8px 0 rgba(76,110,245,0.10);
        }
        .sidebar-item:hover {
            background: rgba(108,99,255,0.10);
            color: #6C63FF !important;
            transform: translateX(6px) scale(1.03);
        }
        .sidebar-icon {
            background: #232B3E;
            border-radius: 50%;
            padding: 0.5rem;
            margin-right: 1rem;
            color: #6C63FF;
            font-size: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .notification-pulse {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
</head>
<body class="bg-gray-50">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-50">
        <!-- Enhanced Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-72 sidebar-gradient shadow-2xl transform transition-transform duration-300 ease-in-out" 
             :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
             x-show="sidebarOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full">
            
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between h-20 px-6 bg-black bg-opacity-20">
                <div class="flex items-center">
                    <div class="p-2 bg-white bg-opacity-20 rounded-lg">
                        <i class="fas fa-calendar-alt text-white text-2xl"></i>
                    </div>
                    <div class="ml-3">
                        <h1 class="text-xl font-bold text-white">Booking System</h1>
                        <p class="text-gray-200 text-xs">Management Portal</p>
                    </div>
                </div>
                <button @click="sidebarOpen = false" class="text-white hover:text-gray-200 transition-colors duration-200">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <!-- User Profile Section -->
            @auth
            <div class="px-6 py-4 border-b border-white border-opacity-20">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                        <span class="text-white text-lg font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </div>
                    <div class="ml-3">
                        <p class="text-white font-semibold">{{ auth()->user()->name }}</p>
                        <p class="text-gray-200 text-sm">{{ auth()->user()->email }}</p>
                        <div class="flex items-center mt-1">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                @if(auth()->user()->isAdmin()) bg-amber-100 text-amber-800 @else bg-slate-100 text-slate-800 @endif">
                                <i class="fas fa-circle mr-1 text-xs"></i>
                                {{ auth()->user()->isAdmin() ? 'Admin' : 'User' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endauth
            
            <!-- Navigation -->
            <nav class="mt-6 px-4">
                @auth
                    @if(auth()->user()->isAdmin())
                        <!-- Admin Navigation -->
                        <div class="mb-6">
                            <h3 class="text-xs font-semibold text-gray-200 uppercase tracking-wider mb-3 px-3">Admin Panel</h3>
                            <div class="space-y-1">
                                <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center px-3 py-3 text-white rounded-lg hover:bg-white hover:bg-opacity-20 group">
                                    <i class="fas fa-tachometer-alt w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span class="font-medium">Dashboard</span>
                                </a>
                                <a href="{{ route('admin.users') }}" class="sidebar-item flex items-center px-3 py-3 text-white rounded-lg hover:bg-white hover:bg-opacity-20 group">
                                    <i class="fas fa-users w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span class="font-medium">Manage Users</span>
                                </a>
                                <a href="{{ route('admin.bookings') }}" class="sidebar-item flex items-center px-3 py-3 text-white rounded-lg hover:bg-white hover:bg-opacity-20 group">
                                    <i class="fas fa-calendar-check w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span class="font-medium">All Bookings</span>
                                </a>
                            </div>
                        </div>
                    @else
                        <!-- User Navigation -->
                        <div class="mb-6">
                            <h3 class="text-xs font-semibold text-gray-200 uppercase tracking-wider mb-3 px-3">My Account</h3>
                            <div class="space-y-1">
                                <a href="{{ route('dashboard') }}" class="sidebar-item flex items-center px-3 py-3 text-white rounded-lg hover:bg-white hover:bg-opacity-20 group">
                                    <i class="fas fa-tachometer-alt w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span class="font-medium">Dashboard</span>
                                </a>
                                <a href="{{ route('bookings.index') }}" class="sidebar-item flex items-center px-3 py-3 text-white rounded-lg hover:bg-white hover:bg-opacity-20 group">
                                    <i class="fas fa-calendar w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span class="font-medium">My Bookings</span>
                                </a>
                                <a href="{{ route('bookings.create') }}" class="sidebar-item flex items-center px-3 py-3 text-white rounded-lg hover:bg-white hover:bg-opacity-20 group">
                                    <i class="fas fa-plus w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                    <span class="font-medium">Create Booking</span>
                                </a>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Common Navigation -->
                    <div class="mb-6">
                        <h3 class="text-xs font-semibold text-gray-200 uppercase tracking-wider mb-3 px-3">General</h3>
                        <div class="space-y-1">
                            <a href="{{ route('notifications.index') }}" class="sidebar-item flex items-center px-3 py-3 text-white rounded-lg hover:bg-white hover:bg-opacity-20 group">
                                <i class="fas fa-bell w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                <span class="font-medium">Notifications</span>
                                <span id="notification-count" class="ml-auto bg-red-500 text-white text-xs rounded-full px-2 py-1 notification-pulse" style="display:none;">0</span>
                            </a>
                            
                            <a href="{{ route('profile.index') }}" class="sidebar-item flex items-center px-3 py-3 text-white rounded-lg hover:bg-white hover:bg-opacity-20 group">
                                <i class="fas fa-user w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                <span class="font-medium">My Profile</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Logout Section -->
                    <div class="mt-auto pt-6 border-t border-white border-opacity-20">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="sidebar-item w-full flex items-center px-3 py-3 text-white rounded-lg hover:bg-red-500 hover:bg-opacity-20 group transition-all duration-200">
                                <i class="fas fa-sign-out-alt w-5 h-5 mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                                <span class="font-medium">Logout</span>
                            </button>
                        </form>
                    </div>
                @endauth
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Enhanced Top Navigation -->
            <header class="bg-white shadow-lg border-b border-gray-200">
                <div class="flex items-center justify-between h-16 px-6">
                    <div class="flex items-center">
                        <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-700 transition-colors duration-200">
                            <i class="fas fa-bars text-xl"></i>
                        </button>
                        <h2 class="ml-4 text-xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h2>
                    </div>
                    
                    @auth
                        <div class="flex items-center space-x-4">
                            <a href="{{ route('notifications.index') }}" class="relative text-gray-500 hover:text-gray-700 transition-colors duration-200">
                                <i class="fas fa-bell text-xl"></i>
                                <span id="notification-badge" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full px-2 py-1 notification-pulse" style="display:none;">0</span>
                            </a>
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gradient-to-r from-slate-600 to-gray-700 rounded-full flex items-center justify-center">
                                    <span class="text-white text-sm font-bold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                </div>
                                <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
                            </div>
                        </div>
                    @endauth
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @if(session('success'))
                    <div class="mb-6 bg-gradient-to-r from-emerald-50 to-green-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl shadow-sm">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle mr-3 text-emerald-500"></i>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl shadow-sm">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle mr-3 text-red-500"></i>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-6 bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 text-red-700 px-6 py-4 rounded-xl shadow-sm">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-exclamation-triangle mr-3 text-red-500"></i>
                            <span class="font-medium">Please fix the following errors:</span>
                        </div>
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Update notification count
        function updateNotificationCount() {
            fetch('{{ route("notifications.unread-count") }}')
                .then(response => response.json())
                .then(data => {
                    const count = data.count;
                    const badge = document.getElementById('notification-badge');
                    const sidebarCount = document.getElementById('notification-count');
                    if (count > 0) {
                        badge.textContent = count;
                        badge.style.display = '';
                        sidebarCount.textContent = count;
                        sidebarCount.style.display = '';
                    } else {
                        badge.style.display = 'none';
                        sidebarCount.style.display = 'none';
                    }
                });
        }
        setInterval(updateNotificationCount, 30000);
        updateNotificationCount();
    </script>
</body>
</html> 