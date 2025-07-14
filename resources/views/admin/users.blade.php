@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="max-w-7xl mx-auto space-y-8">
    <!-- Header -->
    <div class="bg-white rounded-xl shadow-lg p-8 border border-blue-100">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-blue-900 mb-2">User Management</h1>
                <p class="text-blue-700 text-lg">Administer user accounts and permissions</p>
            </div>
            <div class="hidden md:block">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-users-cog text-blue-700 text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="bg-white rounded-xl shadow-lg p-6 border border-blue-100">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-users text-blue-700 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-blue-900">Total Users</p>
                    <p class="text-2xl font-bold text-blue-900">{{ $users->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border border-green-100">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-check text-green-700 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-green-700">Regular Users</p>
                    <p class="text-2xl font-bold text-green-700">{{ $users->where('is_admin', false)->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border border-yellow-100">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-user-shield text-yellow-700 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-yellow-700">Administrators</p>
                    <p class="text-2xl font-bold text-yellow-700">{{ $users->where('is_admin', true)->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-6 border border-purple-100">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-calendar-check text-purple-700 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-purple-700">Total Bookings</p>
                    <p class="text-2xl font-bold text-purple-700">{{ $users->sum(function($user) { return $user->bookings->count(); }) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-6">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="flex-1 max-w-md">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-blue-400"></i>
                    </div>
                    <input type="text" 
                           id="search" 
                           placeholder="Search users by name or email..." 
                           class="w-full pl-10 pr-4 py-2 border border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                </div>
            </div>
            
            <div class="flex space-x-3">
                <select id="role-filter" class="px-4 py-2 border border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                    <option value="">All Roles</option>
                    <option value="admin">Administrators</option>
                    <option value="user">Regular Users</option>
                </select>
                
                <select id="status-filter" class="px-4 py-2 border border-blue-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200">
                    <option value="">All Status</option>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Users Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($users as $user)
            <div class="bg-white rounded-xl shadow-lg border border-blue-100 hover:shadow-xl transition-all duration-300">
                <!-- User Header -->
                <div class="p-6 border-b border-blue-100">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-700 font-bold text-lg">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-lg font-semibold text-blue-900">{{ $user->name }}</h3>
                                <p class="text-sm text-blue-700">{{ $user->email }}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 text-xs font-medium rounded-full 
                            @if($user->isAdmin()) bg-yellow-100 text-yellow-800 @else bg-green-100 text-green-800 @endif">
                            <i class="fas fa-circle mr-1 text-xs"></i>
                            {{ $user->isAdmin() ? 'Admin' : 'User' }}
                        </span>
                    </div>
                </div>
                
                <!-- User Stats -->
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div class="text-center p-3 bg-blue-50 rounded-lg border border-blue-200">
                            <div class="text-xl font-bold text-blue-700">{{ $user->bookings->count() }}</div>
                            <div class="text-xs text-blue-700">Bookings</div>
                        </div>
                        <div class="text-center p-3 bg-green-50 rounded-lg border border-green-200">
                            <div class="text-xl font-bold text-green-700">{{ $user->bookings->where('status', 'confirmed')->count() }}</div>
                            <div class="text-xs text-green-700">Confirmed</div>
                        </div>
                    </div>
                    
                    <!-- User Details -->
                    <div class="space-y-2 mb-6">
                        <div class="flex items-center text-sm text-blue-700">
                            <i class="fas fa-calendar w-4 h-4 mr-2 text-blue-400"></i>
                            <span>Joined {{ $user->created_at->format('M d, Y') }}</span>
                        </div>
                        <div class="flex items-center text-sm text-blue-700">
                            <i class="fas fa-clock w-4 h-4 mr-2 text-blue-400"></i>
                            <span>Last active {{ $user->updated_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.user-details', $user) }}" 
                           class="flex-1 text-center px-4 py-2 text-sm font-medium text-blue-700 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                            <i class="fas fa-eye mr-1"></i> View
                        </a>
                        
                        @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.toggle-admin', $user) }}" class="flex-1">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="w-full px-4 py-2 text-sm font-medium 
                                            @if($user->isAdmin()) text-red-600 bg-red-50 hover:bg-red-100 @else text-orange-600 bg-orange-50 hover:bg-orange-100 @endif rounded-lg transition-colors duration-200"
                                        onclick="return confirm('Are you sure you want to change this user\'s role?')">
                                    <i class="fas @if($user->isAdmin()) fa-user @else fa-user-shield @endif mr-1"></i>
                                    {{ $user->isAdmin() ? 'Remove Admin' : 'Make Admin' }}
                                </button>
                            </form>
                        @else
                            <div class="flex-1 text-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-50 rounded-lg">
                                <i class="fas fa-user mr-1"></i> Current User
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Empty State -->
    @if($users->count() === 0)
        <div class="bg-white rounded-xl shadow-lg p-12 text-center border border-gray-100">
            <div class="mx-auto h-24 w-24 bg-gray-100 rounded-full flex items-center justify-center mb-6">
                <i class="fas fa-users text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">No users found</h3>
            <p class="text-gray-600 mb-8 max-w-md mx-auto">There are no users registered in the system yet.</p>
        </div>
    @endif
</div>

<script>
    // Search functionality
    document.getElementById('search').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const userCards = document.querySelectorAll('.grid > div');
        
        userCards.forEach(card => {
            const userName = card.querySelector('h3').textContent.toLowerCase();
            const userEmail = card.querySelector('p').textContent.toLowerCase();
            
            if (userName.includes(searchTerm) || userEmail.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Role filter
    document.getElementById('role-filter').addEventListener('change', function() {
        const selectedRole = this.value;
        const userCards = document.querySelectorAll('.grid > div');
        
        userCards.forEach(card => {
            const roleBadge = card.querySelector('span');
            const isAdmin = roleBadge.textContent.includes('Admin');
            
            if (selectedRole === '' || 
                (selectedRole === 'admin' && isAdmin) || 
                (selectedRole === 'user' && !isAdmin)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });
</script>
@endsection 