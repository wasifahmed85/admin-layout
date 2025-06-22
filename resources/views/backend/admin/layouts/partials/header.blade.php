<header class="bg-white dark:bg-gray-800 shadow-xs border-b border-gray-200 dark:border-gray-700 h-16">
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