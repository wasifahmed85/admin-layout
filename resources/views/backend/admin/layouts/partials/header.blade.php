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
            <button @click="$store.theme.toggleTheme()"
                class="p-2 rounded-xl hover:bg-black/10 dark:hover:bg-white/10 transition-colors"
                data-tooltip="Toggle theme"
                :title="$store.theme.current.charAt(0).toUpperCase() + $store.theme.current.slice(1) + ' mode'">
                <i data-lucide="sun" x-show="!$store.theme.darkMode"
                    class="w-5 h-5 text-text-light-primary dark:text-text-white"></i>
                <i data-lucide="moon" x-show="$store.theme.darkMode"
                    class="w-5 h-5 text-text-light-primary dark:text-text-white"></i>
            </button>

            <!-- Profile Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                    <div>
                        <img src="{{ auth_storage_url(admin()->image) }}" alt=""
                            class="w-10 h-10 rounded-full ring-2 ring-primary-500">
                    </div>
                    <i class="fas fa-chevron-down text-sm text-gray-500 dark:text-gray-400"></i>
                </button>

                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50">
                    <div class="p-2">
                        <a href="#"
                            class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            <i class="fas fa-user mr-3 w-4"></i>Profile
                        </a>
                        <a href="#"
                            class="flex items-center px-3 py-2 text-sm text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200">
                            <i class="fas fa-cog mr-3 w-4"></i>Settings
                        </a>
                        <x-admin.profile-navlink route="{{ route('admin.logout') }}" logout='true'
                            name="{{ __('Sign Out') }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
