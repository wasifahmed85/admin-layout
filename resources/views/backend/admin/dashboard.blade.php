{{-- <x-admin::layout>

    <h1>{{ 'This is Admin dashboard' }}</h1>
    <form action="{{ route('admin.logout') }}" method="POST">
        @csrf
        <button type="submit">Logout</button>
    </form>
</x-admin::layout> --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Admin Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                        gray: {
                            50: '#f9fafb',
                            100: '#f3f4f6',
                            200: '#e5e7eb',
                            300: '#d1d5db',
                            400: '#9ca3af',
                            500: '#6b7280',
                            600: '#4b5563',
                            700: '#374151',
                            800: '#1f2937',
                            900: '#111827',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                        'slide-in': 'slideIn 0.3s ease-out',
                        'pulse-slow': 'pulse 3s infinite',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' },
                        },
                        slideIn: {
                            '0%': { transform: 'translateX(-100%)' },
                            '100%': { transform: 'translateX(0)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 font-inter antialiased" x-data="adminDashboard()" x-cloak>
    <!-- Loading Overlay -->
    {{-- <div x-show="isLoading" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="fixed inset-0 bg-white dark:bg-gray-900 z-50 flex items-center justify-center">
        <div class="text-center">
            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-primary-500 mx-auto"></div>
            <p class="mt-4 text-gray-600 dark:text-gray-400">Loading dashboard...</p>
        </div>
    </div> --}}

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="bg-white dark:bg-gray-800 shadow-xl transition-all duration-300 ease-in-out border-r border-gray-200 dark:border-gray-700" 
               :class="sidebarOpen ? 'w-64' : 'w-16'">
            <!-- Logo -->
            <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-crown text-white text-lg"></i>
                    </div>
                    <div class="transition-all duration-300" :class="sidebarOpen ? 'visible' : 'invisible w-0'">
                        <h1 class="text-xl font-bold text-gray-900 dark:text-white">AdminPro</h1>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="mt-6 px-3">
                <template x-for="item in navigation" :key="item.id">
                    <div class="mb-1">
                        <button @click="setActiveTab(item.id)"
                                class="w-full flex items-center px-3 py-3 text-sm font-medium rounded-lg transition-all duration-200 group"
                                :class="activeTab === item.id 
                                    ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-400 shadow-sm' 
                                    : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50'">
                            <i :class="item.icon" 
                               class="w-5 h-5 transition-colors duration-200"
                               :class="activeTab === item.id ? 'text-primary-600 dark:text-primary-400' : 'text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300'"></i>
                            <span class="ml-3 transition-all duration-300" 
                                  :class="sidebarOpen ? 'visible' : 'invisible w-0'" 
                                  x-text="item.name"></span>
                            <span x-show="item.badge && sidebarOpen" 
                                  class="ml-auto bg-red-100 text-red-800 text-xs font-medium px-2 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300"
                                  x-text="item.badge"></span>
                        </button>
                    </div>
                </template>
            </nav>

            <!-- User Profile -->
            <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-center space-x-3 transition-all duration-20 ease-in-out" :class="sidebarOpen ? 'visible' : 'hidden w-0'">
                    <img src="/placeholder.svg?height=40&width=40" alt="Profile" class="w-10 h-10 rounded-full ring-2 ring-primary-500">
                    <div class="transition-all duration-20 ">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">Admin User</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">admin@company.com</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700 h-16">
                <div class="flex items-center justify-between h-full px-6">
                    <div class="flex items-center space-x-4">
                        <button @click="toggleSidebar()" 
                                class="p-2 rounded-lg text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-gray-700 transition-colors duration-200">
                            <i class="fas  fa-bars text-lg"></i>
                        </button>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white" x-text="getCurrentTabName()"></h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400" x-text="getCurrentDate()"></p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                         
                        <!-- Theme Toggle -->
                        <button @click="toggleTheme()" 
                                class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                            <i :class="darkMode ? 'fas fa-sun' : 'fas fa-moon'" class="text-lg"></i>
                        </button>

                        <!-- Profile Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                <img src="/placeholder.svg?height=32&width=32" alt="Avatar" class="w-8 h-8 rounded-full ring-2 ring-primary-500">
                                <i class="fas fa-chevron-down text-sm text-gray-500 dark:text-gray-400"></i>
                            </button>
                            
                            <div x-show="open" @click.away="open = false" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50">
                                <div class="p-2">
                                    <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                        <i class="fas fa-user mr-3 w-4"></i>Profile
                                    </a>
                                    <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                                        <i class="fas fa-cog mr-3 w-4"></i>Settings
                                    </a>
                                    <hr class="my-2 border-gray-200 dark:border-gray-700">
                                    <a href="#" class="flex items-center px-3 py-2 text-sm text-red-600 dark:text-red-400 rounded-md hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors duration-200">
                                        <i class="fas fa-sign-out-alt mr-3 w-4"></i>Sign out
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-900">
                <div class="p-6">
                    <!-- Dashboard Tab -->
                    <div x-show="activeTab === 'dashboard'" class="space-y-6 animate-fade-in">
                        <!-- Stats Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <template x-for="(stat, index) in stats" :key="stat.id">
                                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 hover:shadow-md transition-shadow duration-200"
                                     :style="`animation-delay: ${index * 100}ms`">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-medium text-gray-600 dark:text-gray-400" x-text="stat.title"></p>
                                            <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2" x-text="stat.value"></p>
                                            <div class="flex items-center mt-2">
                                                <span class="text-sm font-medium" :class="stat.changeColor" x-text="stat.change"></span>
                                                <span class="text-sm text-gray-500 dark:text-gray-400 ml-2">vs last month</span>
                                            </div>
                                        </div>
                                        <div class="p-3 rounded-xl" :class="stat.bgColor">
                                            <i :class="stat.icon + ' text-white text-xl'"></i>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <!-- Charts and Activity -->
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Recent Activity -->
                            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Activity</h3>
                                </div>
                                <div class="p-6">
                                    <div class="space-y-4">
                                        <template x-for="activity in recentActivity" :key="activity.id">
                                            <div class="flex items-start space-x-4 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                                <div class="w-2 h-2 bg-primary-500 rounded-full mt-2 flex-shrink-0"></div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="activity.description"></p>
                                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" x-text="activity.time"></p>
                                                </div>
                                                <span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 px-2 py-1 rounded-full" x-text="activity.type"></span>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Stats -->
                            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Stats</h3>
                                </div>
                                <div class="p-6 space-y-4">
                                    <template x-for="quickStat in quickStats" :key="quickStat.id">
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-3">
                                                <div class="w-8 h-8 rounded-lg flex items-center justify-center" :class="quickStat.bgColor">
                                                    <i :class="quickStat.icon + ' text-white text-sm'"></i>
                                                </div>
                                                <span class="text-sm font-medium text-gray-900 dark:text-white" x-text="quickStat.label"></span>
                                            </div>
                                            <span class="text-sm font-bold text-gray-900 dark:text-white" x-text="quickStat.value"></span>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Users Tab -->
                    <div x-show="activeTab === 'users'" class="space-y-6 animate-fade-in">
                        <!-- Users Header -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">User Management</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage your team members and their permissions</p>
                                </div>
                                <div class="flex items-center space-x-3">
                                    <div class="relative">
                                        <input type="text" 
                                               x-model="searchQuery"
                                               @input="searchUsers()"
                                               placeholder="Search users..." 
                                               class="pl-10 pr-4 py-2 w-64 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200">
                                        <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
                                    </div>
                                    <button @click="openUserModal()" 
                                            class="bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors duration-200 shadow-sm">
                                        <i class="fas fa-plus text-sm"></i>
                                        <span>Add User</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Users Table -->
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                <input type="checkbox" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                            </th>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Last Active</th>
                                            <th class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        <template x-for="user in paginatedUsers" :key="user.id">
                                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="checkbox" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <img :src="user.avatar" :alt="user.name" class="w-10 h-10 rounded-full ring-2 ring-gray-200 dark:ring-gray-700">
                                                        <div class="ml-4">
                                                            <div class="text-sm font-medium text-gray-900 dark:text-white" x-text="user.name"></div>
                                                            <div class="text-sm text-gray-500 dark:text-gray-400" x-text="user.email"></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                                          :class="getRoleBadgeClass(user.role)" x-text="user.role"></span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                                          :class="user.status === 'Active' ? 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' : 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100'"
                                                          x-text="user.status"></span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400" x-text="user.lastActive"></td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <div class="flex items-center justify-end space-x-2">
                                                        <button @click="editUser(user)" 
                                                                class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300 p-1 rounded transition-colors duration-200">
                                                            <i class="fas fa-edit"></i>
                                                        </button>
                                                        <button @click="confirmDeleteUser(user)" 
                                                                class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 p-1 rounded transition-colors duration-200">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="bg-white dark:bg-gray-800 px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center justify-between">
                                    <div class="text-sm text-gray-700 dark:text-gray-300">
                                        Showing <span class="font-medium" x-text="(currentPage - 1) * itemsPerPage + 1"></span> 
                                        to <span class="font-medium" x-text="Math.min(currentPage * itemsPerPage, filteredUsers.length)"></span> 
                                        of <span class="font-medium" x-text="filteredUsers.length"></span> results
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <button @click="previousPage()" 
                                                :disabled="currentPage === 1"
                                                class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                                            Previous
                                        </button>
                                        <template x-for="page in getPageNumbers()" :key="page">
                                            <button @click="currentPage = page" 
                                                    class="px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200"
                                                    :class="currentPage === page 
                                                        ? 'bg-primary-500 text-white' 
                                                        : 'text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700'"
                                                    x-text="page"></button>
                                        </template>
                                        <button @click="nextPage()" 
                                                :disabled="currentPage === totalPages"
                                                class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                                            Next
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Settings Tab -->
                    <div x-show="activeTab === 'settings'" class="space-y-6 animate-fade-in">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- General Settings -->
                            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">General Settings</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage your application settings</p>
                                </div>
                                <div class="p-6 space-y-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Company Name</label>
                                            <input type="text" value="AdminPro Inc." 
                                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Admin Email</label>
                                            <input type="email" value="admin@adminpro.com" 
                                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200">
                                        </div>
                                    </div>
                                    
                                    <div class="space-y-4">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Email Notifications</h4>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Receive email notifications for important updates</p>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" checked class="sr-only peer">
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                                            </label>
                                        </div>
                                        
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Two-Factor Authentication</h4>
                                                <p class="text-sm text-gray-500 dark:text-gray-400">Add an extra layer of security to your account</p>
                                            </div>
                                            <label class="relative inline-flex items-center cursor-pointer">
                                                <input type="checkbox" class="sr-only peer">
                                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600"></div>
                                            </label>
                                        </div>
                                    </div>
                                    
                                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                        <button class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-lg transition-colors duration-200 shadow-sm">
                                            Save Changes
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="space-y-6">
                                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Actions</h3>
                                    </div>
                                    <div class="p-6 space-y-3">
                                        <button class="w-full flex items-center justify-between p-3 text-left rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                            <div class="flex items-center space-x-3">
                                                <i class="fas fa-download text-primary-500"></i>
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">Export Data</span>
                                            </div>
                                            <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                                        </button>
                                        <button class="w-full flex items-center justify-between p-3 text-left rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                            <div class="flex items-center space-x-3">
                                                <i class="fas fa-shield-alt text-green-500"></i>
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">Security Audit</span>
                                            </div>
                                            <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                                        </button>
                                        <button class="w-full flex items-center justify-between p-3 text-left rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                            <div class="flex items-center space-x-3">
                                                <i class="fas fa-database text-blue-500"></i>
                                                <span class="text-sm font-medium text-gray-900 dark:text-white">Backup System</span>
                                            </div>
                                            <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- User Modal -->
    <div x-show="showUserModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4"
         @click.self="closeUserModal()">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 w-full max-w-md"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white" 
                        x-text="editingUser ? 'Edit User' : 'Add New User'"></h3>
                    <button @click="closeUserModal()" 
                            class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors duration-200">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>
            
            <form @submit.prevent="saveUser()" class="p-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Full Name</label>
                        <input type="text" x-model="userForm.name" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200"
                               placeholder="Enter full name">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email Address</label>
                        <input type="email" x-model="userForm.email" required
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200"
                               placeholder="Enter email address">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role</label>
                        <select x-model="userForm.role" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200">
                            <option value="">Select a role</option>
                            <option value="Admin">Administrator</option>
                            <option value="Manager">Manager</option>
                            <option value="Editor">Editor</option>
                            <option value="User">User</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                        <select x-model="userForm.status" required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3 mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" @click="closeUserModal()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                        Cancel
                    </button>
                    <button type="submit" 
                            :disabled="isSubmitting"
                            class="px-4 py-2 text-sm font-medium text-white bg-primary-500 rounded-lg hover:bg-primary-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200 flex items-center space-x-2">
                        <i x-show="isSubmitting" class="fas fa-spinner fa-spin"></i>
                        <span x-text="isSubmitting ? 'Saving...' : (editingUser ? 'Update User' : 'Create User')"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="showDeleteModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4"
         @click.self="showDeleteModal = false">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 w-full max-w-md p-6">
            <div class="text-center">
                <div class="w-12 h-12 mx-auto bg-red-100 dark:bg-red-900/20 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400 text-xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Delete User</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                    Are you sure you want to delete this user? This action cannot be undone.
                </p>
                <div class="flex justify-center space-x-3">
                    <button @click="showDeleteModal = false" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                        Cancel
                    </button>
                    <button @click="deleteUser()" 
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors duration-200">
                        Delete User
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function adminDashboard() {
            return {
                // State
                isLoading: true,
                sidebarOpen: true,
                activeTab: 'dashboard',
                darkMode: localStorage.getItem('darkMode') === 'true',
                showUserModal: false,
                showDeleteModal: false,
                editingUser: null,
                userToDelete: null,
                searchQuery: '',
                isSubmitting: false,
                currentPage: 1,
                itemsPerPage: 10,

                // Navigation
                navigation: [
                    { id: 'dashboard', name: 'Dashboard', icon: 'fas fa-tachometer-alt' },
                    { id: 'users', name: 'Users', icon: 'fas fa-users', badge: '12' },
                    { id: 'analytics', name: 'Analytics', icon: 'fas fa-chart-bar' },
                    { id: 'settings', name: 'Settings', icon: 'fas fa-cog' },
                ],

                // Data
                stats: [
                    {
                        id: 1,
                        title: 'Total Users',
                        value: '2,847',
                        change: '+12.5%',
                        changeColor: 'text-green-600 dark:text-green-400',
                        icon: 'fas fa-users',
                        bgColor: 'bg-gradient-to-br from-blue-500 to-blue-600'
                    },
                    {
                        id: 2,
                        title: 'Revenue',
                        value: '$89,247',
                        change: '+8.2%',
                        changeColor: 'text-green-600 dark:text-green-400',
                        icon: 'fas fa-dollar-sign',
                        bgColor: 'bg-gradient-to-br from-green-500 to-green-600'
                    },
                    {
                        id: 3,
                        title: 'Orders',
                        value: '1,429',
                        change: '-2.4%',
                        changeColor: 'text-red-600 dark:text-red-400',
                        icon: 'fas fa-shopping-cart',
                        bgColor: 'bg-gradient-to-br from-yellow-500 to-orange-500'
                    },
                    {
                        id: 4,
                        title: 'Growth Rate',
                        value: '24.8%',
                        change: '+15.3%',
                        changeColor: 'text-green-600 dark:text-green-400',
                        icon: 'fas fa-chart-line',
                        bgColor: 'bg-gradient-to-br from-purple-500 to-purple-600'
                    }
                ],

                quickStats: [
                    { id: 1, label: 'Active Sessions', value: '1,247', icon: 'fas fa-circle', bgColor: 'bg-green-500' },
                    { id: 2, label: 'Pending Tasks', value: '23', icon: 'fas fa-clock', bgColor: 'bg-yellow-500' },
                    { id: 3, label: 'New Messages', value: '8', icon: 'fas fa-envelope', bgColor: 'bg-blue-500' },
                    { id: 4, label: 'System Health', value: '98%', icon: 'fas fa-heart', bgColor: 'bg-red-500' },
                ],

                recentActivity: [
                    { id: 1, description: 'New user registration: Sarah Johnson', time: '2 minutes ago', type: 'User' },
                    { id: 2, description: 'Order #ORD-2024-001 completed successfully', time: '5 minutes ago', type: 'Order' },
                    { id: 3, description: 'System backup completed', time: '1 hour ago', type: 'System' },
                    { id: 4, description: 'Security scan completed - No threats detected', time: '2 hours ago', type: 'Security' },
                    { id: 5, description: 'Database optimization completed', time: '3 hours ago', type: 'System' },
                ],

                notifications: [
                    { id: 1, message: 'New user registered', time: '5 minutes ago' },
                    { id: 2, message: 'Server maintenance scheduled', time: '1 hour ago' },
                    { id: 3, message: 'Backup completed successfully', time: '2 hours ago' },
                ],

                users: [
                    {
                        id: 1,
                        name: 'Sarah Johnson',
                        email: 'sarah.johnson@company.com',
                        role: 'Admin',
                        status: 'Active',
                        lastActive: '2 minutes ago',
                        avatar: '/placeholder.svg?height=40&width=40'
                    },
                    {
                        id: 2,
                        name: 'Michael Chen',
                        email: 'michael.chen@company.com',
                        role: 'Manager',
                        status: 'Active',
                        lastActive: '1 hour ago',
                        avatar: '/placeholder.svg?height=40&width=40'
                    },
                    {
                        id: 3,
                        name: 'Emily Rodriguez',
                        email: 'emily.rodriguez@company.com',
                        role: 'Editor',
                        status: 'Active',
                        lastActive: '3 hours ago',
                        avatar: '/placeholder.svg?height=40&width=40'
                    },
                    {
                        id: 4,
                        name: 'David Kim',
                        email: 'david.kim@company.com',
                        role: 'User',
                        status: 'Inactive',
                        lastActive: '2 days ago',
                        avatar: '/placeholder.svg?height=40&width=40'
                    },
                    {
                        id: 5,
                        name: 'Lisa Thompson',
                        email: 'lisa.thompson@company.com',
                        role: 'Editor',
                        status: 'Active',
                        lastActive: '30 minutes ago',
                        avatar: '/placeholder.svg?height=40&width=40'
                    }
                ],

                filteredUsers: [],
                userForm: {
                    name: '',
                    email: '',
                    role: '',
                    status: 'Active'
                },

                // Computed properties
                get paginatedUsers() {
                    const start = (this.currentPage - 1) * this.itemsPerPage;
                    const end = start + this.itemsPerPage;
                    return this.filteredUsers.slice(start, end);
                },

                get totalPages() {
                    return Math.ceil(this.filteredUsers.length / this.itemsPerPage);
                },

                // Initialization
                init() {
                    this.filteredUsers = [...this.users];
                    
                    // Apply dark mode
                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                    }

                    // Simulate loading
                    setTimeout(() => {
                        this.isLoading = false;
                    }, 1500);

                    // Watch for dark mode changes
                    this.$watch('darkMode', (value) => {
                        localStorage.setItem('darkMode', value);
                        if (value) {
                            document.documentElement.classList.add('dark');
                        } else {
                            document.documentElement.classList.remove('dark');
                        }
                    });

                    // Load initial data
                    this.loadDashboardData();
                },

                // Methods
                setActiveTab(tab) {
                    this.activeTab = tab;
                    this.currentPage = 1; // Reset pagination when switching tabs
                },

                getCurrentTabName() {
                    const tab = this.navigation.find(item => item.id === this.activeTab);
                    return tab ? tab.name : 'Dashboard';
                },

                getCurrentDate() {
                    return new Date().toLocaleDateString('en-US', { 
                        weekday: 'long', 
                        year: 'numeric', 
                        month: 'long', 
                        day: 'numeric' 
                    });
                },

                toggleTheme() {
                    this.darkMode = !this.darkMode;
                },

                toggleSidebar() {
                    this.sidebarOpen = !this.sidebarOpen;
                    console.log('Sidebar toggled:', this.sidebarOpen); // Debug log
                },

                async loadDashboardData() {
                    try {
                        // Simulate API calls
                        // const [statsData, usersData, activityData] = await Promise.all([
                        //     axios.get('/api/stats'),
                        //     axios.get('/api/users'),
                        //     axios.get('/api/activity')
                        // ]);
                        
                        // Update data
                        this.filteredUsers = [...this.users];
                    } catch (error) {
                        console.error('Error loading dashboard data:', error);
                        this.showNotification('Error loading data', 'error');
                    }
                },

                // User Management
                searchUsers() {
                    if (!this.searchQuery.trim()) {
                        this.filteredUsers = [...this.users];
                    } else {
                        const query = this.searchQuery.toLowerCase();
                        this.filteredUsers = this.users.filter(user => 
                            user.name.toLowerCase().includes(query) ||
                            user.email.toLowerCase().includes(query) ||
                            user.role.toLowerCase().includes(query)
                        );
                    }
                    this.currentPage = 1; // Reset to first page after search
                },

                openUserModal(user = null) {
                    this.editingUser = user;
                    if (user) {
                        this.userForm = { ...user };
                    } else {
                        this.userForm = { name: '', email: '', role: '', status: 'Active' };
                    }
                    this.showUserModal = true;
                },

                closeUserModal() {
                    this.showUserModal = false;
                    this.editingUser = null;
                    this.userForm = { name: '', email: '', role: '', status: 'Active' };
                },

                async saveUser() {
                    this.isSubmitting = true;
                    
                    try {
                        // Validate form
                        if (!this.userForm.name || !this.userForm.email || !this.userForm.role) {
                            throw new Error('Please fill in all required fields');
                        }

                        // Simulate API call
                        await new Promise(resolve => setTimeout(resolve, 1000));

                        if (this.editingUser) {
                            // Update existing user
                            const index = this.users.findIndex(u => u.id === this.editingUser.id);
                            if (index !== -1) {
                                this.users[index] = { 
                                    ...this.userForm, 
                                    id: this.editingUser.id,
                                    avatar: this.editingUser.avatar,
                                    lastActive: 'Just now'
                                };
                            }
                        } else {
                            // Create new user
                            const newUser = {
                                ...this.userForm,
                                id: Date.now(),
                                avatar: '/placeholder.svg?height=40&width=40',
                                lastActive: 'Just now'
                            };
                            this.users.unshift(newUser);
                        }

                        this.searchUsers(); // Refresh filtered list
                        this.closeUserModal();
                        this.showNotification(
                            this.editingUser ? 'User updated successfully' : 'User created successfully',
                            'success'
                        );

                    } catch (error) {
                        console.error('Error saving user:', error);
                        this.showNotification(error.message || 'Error saving user', 'error');
                    } finally {
                        this.isSubmitting = false;
                    }
                },

                editUser(user) {
                    this.openUserModal(user);
                },

                confirmDeleteUser(user) {
                    this.userToDelete = user;
                    this.showDeleteModal = true;
                },

                async deleteUser() {
                    try {
                        // Simulate API call
                        await new Promise(resolve => setTimeout(resolve, 500));

                        this.users = this.users.filter(user => user.id !== this.userToDelete.id);
                        this.searchUsers(); // Refresh filtered list
                        this.showDeleteModal = false;
                        this.userToDelete = null;
                        this.showNotification('User deleted successfully', 'success');

                    } catch (error) {
                        console.error('Error deleting user:', error);
                        this.showNotification('Error deleting user', 'error');
                    }
                },

                // Pagination
                previousPage() {
                    if (this.currentPage > 1) {
                        this.currentPage--;
                    }
                },

                nextPage() {
                    if (this.currentPage < this.totalPages) {
                        this.currentPage++;
                    }
                },

                getPageNumbers() {
                    const pages = [];
                    const maxVisible = 5;
                    let start = Math.max(1, this.currentPage - Math.floor(maxVisible / 2));
                    let end = Math.min(this.totalPages, start + maxVisible - 1);
                    
                    if (end - start + 1 < maxVisible) {
                        start = Math.max(1, end - maxVisible + 1);
                    }
                    
                    for (let i = start; i <= end; i++) {
                        pages.push(i);
                    }
                    
                    return pages;
                },

                // Utility methods
                getRoleBadgeClass(role) {
                    const classes = {
                        'Admin': 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100',
                        'Manager': 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100',
                        'Editor': 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100',
                        'User': 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-100'
                    };
                    return classes[role] || classes['User'];
                },

                showNotification(message, type = 'info') {
                    // Simple notification system - could be enhanced with a proper toast library
                    console.log(`${type.toUpperCase()}: ${message}`);
                    // In a real app, you'd show a toast notification here
                }
            }
        }
    </script>
</body>
</html>