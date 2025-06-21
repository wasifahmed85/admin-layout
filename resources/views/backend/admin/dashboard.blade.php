<x-admin::layout>
    <x-slot name="title">Admin Dashboard</x-slot>


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
            <div
                class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Activity</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <template x-for="activity in recentActivity" :key="activity.id">
                            <div
                                class="flex items-start space-x-4 p-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                <div class="w-2 h-2 bg-primary-500 rounded-full mt-2 flex-shrink-0"></div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white"
                                        x-text="activity.description"></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" x-text="activity.time"></p>
                                </div>
                                <span
                                    class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 px-2 py-1 rounded-full"
                                    x-text="activity.type"></span>
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
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center"
                                    :class="quickStat.bgColor">
                                    <i :class="quickStat.icon + ' text-white text-sm'"></i>
                                </div>
                                <span class="text-sm font-medium text-gray-900 dark:text-white"
                                    x-text="quickStat.label"></span>
                            </div>
                            <span class="text-sm font-bold text-gray-900 dark:text-white"
                                x-text="quickStat.value"></span>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Tab -->
    {{-- <div x-show="activeTab === 'users'" class="space-y-6 animate-fade-in">
        <!-- Users Header -->
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">User Management</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage your team members and their
                        permissions</p>
                </div>
                <div class="flex items-center space-x-3">
                    <div class="relative">
                        <input type="text" x-model="searchQuery" @input="searchUsers()" placeholder="Search users..."
                            class="pl-10 pr-4 py-2 w-64 text-sm border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400 text-sm"></i>
                    </div>
                    <button @click="openUserModal()"
                        class="bg-primary-500 hover:bg-primary-600 dark:text-white  px-4 py-2 rounded-lg flex items-center space-x-2 transition-colors duration-200 shadow-sm">
                        <i class="fas fa-plus text-sm"></i>
                        <span>Add User</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Users Table -->
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                <input type="checkbox"
                                    class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                User</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Role</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-6 py-4 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Last Active</th>
                            <th
                                class="px-6 py-4 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        <template x-for="user in paginatedUsers" :key="user.id">
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox"
                                        class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img :src="user.avatar" :alt="user.name"
                                            class="w-10 h-10 rounded-full ring-2 ring-gray-200 dark:ring-gray-700">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900 dark:text-white"
                                                x-text="user.name"></div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400" x-text="user.email">
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                        :class="getRoleBadgeClass(user.role)" x-text="user.role"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                        :class="user.status === 'Active' ?
                                            'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100' :
                                            'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100'"
                                        x-text="user.status"></span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400"
                                    x-text="user.lastActive"></td>
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
                        to <span class="font-medium"
                            x-text="Math.min(currentPage * itemsPerPage, filteredUsers.length)"></span>
                        of <span class="font-medium" x-text="filteredUsers.length"></span> results
                    </div>
                    <div class="flex items-center space-x-2">
                        <button @click="previousPage()" :disabled="currentPage === 1"
                            class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700">
                            Previous
                        </button>
                        <template x-for="page in getPageNumbers()" :key="page">
                            <button @click="currentPage = page"
                                class="px-3 py-2 text-sm font-medium rounded-md transition-colors duration-200"
                                :class="currentPage === page ?
                                    'bg-primary-500 text-white' :
                                    'text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-700'"
                                x-text="page"></button>
                        </template>
                        <button @click="nextPage()" :disabled="currentPage === totalPages"
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
            <div
                class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">General Settings</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage your application settings</p>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Company
                                Name</label>
                            <input type="text" value="AdminPro Inc."
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Admin
                                Email</label>
                            <input type="email" value="admin@adminpro.com"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-colors duration-200">
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Email Notifications</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Receive email notifications for
                                    important updates</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" checked class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600">
                                </div>
                            </label>
                        </div>

                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900 dark:text-white">Two-Factor Authentication
                                </h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Add an extra layer of security to
                                    your account</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 dark:peer-focus:ring-primary-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-primary-600">
                                </div>
                            </label>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <button
                            class="bg-primary-500 hover:bg-primary-600 text-white px-6 py-2 rounded-lg transition-colors duration-200 shadow-sm">
                            Save Changes
                        </button>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="space-y-6">
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Actions</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <button
                            class="w-full flex items-center justify-between p-3 text-left rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-download text-primary-500"></i>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Export Data</span>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                        </button>
                        <button
                            class="w-full flex items-center justify-between p-3 text-left rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
                            <div class="flex items-center space-x-3">
                                <i class="fas fa-shield-alt text-green-500"></i>
                                <span class="text-sm font-medium text-gray-900 dark:text-white">Security Audit</span>
                            </div>
                            <i class="fas fa-chevron-right text-gray-400 text-sm"></i>
                        </button>
                        <button
                            class="w-full flex items-center justify-between p-3 text-left rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors duration-200">
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
    </div> --}}
</x-admin::layout>
