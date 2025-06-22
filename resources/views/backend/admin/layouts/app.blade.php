<!DOCTYPE html>
<html html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        {{ isset($title) ? $title . ' - ' : '' }}
        {{ config('app.name', 'Dashboard Setup') }}
    </title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        [x-cloak] {
            display: none !important;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
    </style>
      <script>
        // On page load, immediately apply theme from localStorage to prevent flash
        (function() {
            let theme = localStorage.getItem('theme') || 'system';

            // Apply theme immediately
            if (theme === 'system') {
                const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.classList.toggle('dark', systemPrefersDark);
                document.documentElement.setAttribute('data-theme', systemPrefersDark ? 'dark' : 'light');
            } else {
                document.documentElement.classList.toggle('dark', theme === 'dark');
                document.documentElement.setAttribute('data-theme', theme);
            }
        })();
    </script>
     <script src="{{ asset('assets/js/toggle-theme.js') }}"></script>
    {{-- BoxIcon  --}}
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    

    @stack('cs')
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
        <x-admin::sidebar />
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <x-admin::header />

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto bg-gray-50 dark:bg-gray-900">
                <div class="p-6">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <!-- User Modal -->
    <div x-show="showUserModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4"
        @click.self="closeUserModal()">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 w-full max-w-md"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
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
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email
                            Address</label>
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
                    <button type="submit" :disabled="isSubmitting"
                        class="px-4 py-2 text-sm font-medium text-white bg-primary-500 rounded-lg hover:bg-primary-600 disabled:opacity-50 disabled:cursor-not-allowed transition-colors duration-200 flex items-center space-x-2">
                        <i x-show="isSubmitting" class="fas fa-spinner fa-spin"></i>
                        <span
                            x-text="isSubmitting ? 'Saving...' : (editingUser ? 'Update User' : 'Create User')"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div x-show="showDeleteModal" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4"
        @click.self="showDeleteModal = false">
        <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 w-full max-w-md p-6">
            <div class="text-center">
                <div
                    class="w-12 h-12 mx-auto bg-red-100 dark:bg-red-900/20 rounded-full flex items-center justify-center mb-4">
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
    <script src="{{ asset('assets/js/lucide-icon.js') }}"></script>
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
                navigation: [{
                        id: 'dashboard',
                        name: 'Dashboard',
                        icon: 'fas fa-tachometer-alt'
                    },
                    {
                        id: 'users',
                        name: 'Users',
                        icon: 'fas fa-users',
                        badge: '12'
                    },
                    {
                        id: 'analytics',
                        name: 'Analytics',
                        icon: 'fas fa-chart-bar'
                    },
                    {
                        id: 'Admin',
                        name: 'Admin',
                        icon: 'fas fa-file-alt'
                    },
                    {
                        id: 'settings',
                        name: 'Settings',
                        icon: 'fas fa-cog'
                    },
                ],

                // Data
                stats: [{
                        id: 1,
                        title: 'Total Users',
                        value: '2,847',
                        change: '+12.5%',
                        changeColor: 'text-green-600 dark:text-green-400',
                        icon: 'fas fa-users',
                        bgColor: 'bg-linear-to-br from-blue-500 to-blue-600'
                    },
                    {
                        id: 2,
                        title: 'Revenue',
                        value: '$89,247',
                        change: '+8.2%',
                        changeColor: 'text-green-600 dark:text-green-400',
                        icon: 'fas fa-dollar-sign',
                        bgColor: 'bg-linear-to-br from-green-500 to-green-600'
                    },
                    {
                        id: 3,
                        title: 'Orders',
                        value: '1,429',
                        change: '-2.4%',
                        changeColor: 'text-red-600 dark:text-red-400',
                        icon: 'fas fa-shopping-cart',
                        bgColor: 'bg-linear-to-br from-yellow-500 to-orange-500'
                    },
                    {
                        id: 4,
                        title: 'Growth Rate',
                        value: '24.8%',
                        change: '+15.3%',
                        changeColor: 'text-green-600 dark:text-green-400',
                        icon: 'fas fa-chart-line',
                        bgColor: 'bg-linear-to-br from-purple-500 to-purple-600'
                    }
                ],

                quickStats: [{
                        id: 1,
                        label: 'Active Sessions',
                        value: '1,247',
                        icon: 'fas fa-circle',
                        bgColor: 'bg-green-500'
                    },
                    {
                        id: 2,
                        label: 'Pending Tasks',
                        value: '23',
                        icon: 'fas fa-clock',
                        bgColor: 'bg-yellow-500'
                    },
                    {
                        id: 3,
                        label: 'New Messages',
                        value: '8',
                        icon: 'fas fa-envelope',
                        bgColor: 'bg-blue-500'
                    },
                    {
                        id: 4,
                        label: 'System Health',
                        value: '98%',
                        icon: 'fas fa-heart',
                        bgColor: 'bg-red-500'
                    },
                ],

                recentActivity: [{
                        id: 1,
                        description: 'New user registration: Sarah Johnson',
                        time: '2 minutes ago',
                        type: 'User'
                    },
                    {
                        id: 2,
                        description: 'Order #ORD-2024-001 completed successfully',
                        time: '5 minutes ago',
                        type: 'Order'
                    },
                    {
                        id: 3,
                        description: 'System backup completed',
                        time: '1 hour ago',
                        type: 'System'
                    },
                    {
                        id: 4,
                        description: 'Security scan completed - No threats detected',
                        time: '2 hours ago',
                        type: 'Security'
                    },
                    {
                        id: 5,
                        description: 'Database optimization completed',
                        time: '3 hours ago',
                        type: 'System'
                    },
                ],

                notifications: [{
                        id: 1,
                        message: 'New user registered',
                        time: '5 minutes ago'
                    },
                    {
                        id: 2,
                        message: 'Server maintenance scheduled',
                        time: '1 hour ago'
                    },
                    {
                        id: 3,
                        message: 'Backup completed successfully',
                        time: '2 hours ago'
                    },
                ],

                users: [{
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

                // // Initialization
                // init() {
                //     this.filteredUsers = [...this.users];

                //     // Apply dark mode
                //     if (this.darkMode) {
                //         document.documentElement.classList.add('dark');
                //     }

                //     // Simulate loading
                //     setTimeout(() => {
                //         this.isLoading = false;
                //     }, 1500);

                //     // Watch for dark mode changes
                //     this.$watch('darkMode', (value) => {
                //         localStorage.setItem('darkMode', value);
                //         if (value) {
                //             document.documentElement.classList.add('dark');
                //         } else {
                //             document.documentElement.classList.remove('dark');
                //         }
                //     });

                //     // Load initial data
                //     this.loadDashboardData();
                // },

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
                        this.userForm = {
                            ...user
                        };
                    } else {
                        this.userForm = {
                            name: '',
                            email: '',
                            role: '',
                            status: 'Active'
                        };
                    }
                    this.showUserModal = true;
                },

                closeUserModal() {
                    this.showUserModal = false;
                    this.editingUser = null;
                    this.userForm = {
                        name: '',
                        email: '',
                        role: '',
                        status: 'Active'
                    };
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
    
    <script src="{{ asset('assets/js/details-modal.js') }}"></script>
    @stack('js')
</body>

</html>
