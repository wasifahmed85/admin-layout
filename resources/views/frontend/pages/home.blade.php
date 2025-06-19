<x-frontend::layout>
    <x-slot name="title">Home</x-slot>
    <x-slot name="page_slug">home</x-slot>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Main Content -->
        <div class="min-h-screen flex items-center justify-center px-4">
            <div class="max-w-md w-full space-y-8">
                <!-- Logo/App Name -->
                <div class="text-center">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                        {{ config('app.name', 'Dashboard') }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-300">
                        Please select your login portal
                    </p>
                </div>

                <!-- Login Cards -->
                <div class="space-y-4">
                    <!-- Student Login -->
                    <a href="{{ url('/login') }}" class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition-shadow duration-300 border border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                <i data-lucide="user" class="w-6 h-6 text-blue-600 dark:text-blue-300"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Log In</h2>
                                <p class="text-gray-600 dark:text-gray-400">Access your User dashboard</p>
                            </div>
                            <div class="ml-auto text-blue-600 dark:text-blue-400">
                                <i data-lucide="arrow-right" class="w-5 h-5"></i>
                            </div>
                        </div>
                    </a>
                    <a href="{{ url('/register') }}" class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition-shadow duration-300 border border-gray-200 dark:border-gray-700 hover:border-blue-500 dark:hover:border-blue-400">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                                <i data-lucide="user" class="w-6 h-6 text-blue-600 dark:text-blue-300"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Register</h2>
                                <p class="text-gray-600 dark:text-gray-400">Make a new account</p>
                            </div>
                            <div class="ml-auto text-blue-600 dark:text-blue-400">
                                <i data-lucide="arrow-right" class="w-5 h-5"></i>
                            </div>
                        </div>
                    </a>

                    <!-- Admin Login -->
                    <a href="{{ url('/admin/login') }}" class="block p-6 bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition-shadow duration-300 border border-gray-200 dark:border-gray-700 hover:border-indigo-500 dark:hover:border-indigo-400">
                        <div class="flex items-center space-x-4">
                            <div class="p-3 bg-indigo-100 dark:bg-indigo-900 rounded-lg">
                                <i data-lucide="user-cog" class="w-6 h-6 text-indigo-600 dark:text-indigo-300"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Admin Dashboard</h2>
                                <p class="text-gray-600 dark:text-gray-400">Access admin control panel</p>
                            </div>
                            <div class="ml-auto text-indigo-600 dark:text-indigo-400">
                                <i data-lucide="arrow-right" class="w-5 h-5"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-frontend::layout>