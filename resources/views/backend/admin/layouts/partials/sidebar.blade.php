 <aside
     class="bg-white dark:bg-gray-800 shadow-xl transition-all duration-300 ease-in-out border-r border-gray-200 dark:border-gray-700"
     :class="sidebarOpen ? 'w-64' : 'w-16'">
     <!-- Logo -->
     <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200 dark:border-gray-700">
         <div class="flex items-center space-x-3">
             <div
                 class="w-10 h-10 bg-linear-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center shadow-lg">
                 <i class="fas fa-crown dark:text-white text-gray-800 text-lg"></i>
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
                     :class="activeTab === item.id ?
                         'bg-primary-50 dark:bg-primary-900/20 text-primary-700 dark:text-primary-400 shadow-xs' :
                         'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700/50'">
                     <i :class="item.icon" class="w-5 h-5 transition-colors duration-200"
                         :class="activeTab === item.id ? 'text-primary-600 dark:text-primary-400' :
                             'text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300'"></i>
                     <span class="ml-3 transition-all duration-300" :class="sidebarOpen ? 'visible' : 'invisible w-0'"
                         x-text="item.name"></span>
                     <span x-show="item.badge && sidebarOpen"
                         class="ml-auto bg-red-100 text-red-800 text-xs font-medium px-2 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300"
                         x-text="item.badge"></span>
                 </button>
             </div>
         </template>
     </nav>
     <a href="index">
         Admin
     </a>
     <!-- User Profile -->
     <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-gray-200 dark:border-gray-700">
         <div class="flex items-center space-x-3 transition-all duration-20 ease-in-out"
             :class="sidebarOpen ? 'visible' : 'hidden w-0'">
             <img src="/placeholder.svg?height=40&width=40" alt="Profile"
                 class="w-10 h-10 rounded-full ring-2 ring-primary-500">
             <div class="transition-all duration-20 ">
                 <p class="text-sm font-medium text-gray-900 dark:text-white">Admin User</p>
                 <p class="text-xs text-gray-500 dark:text-gray-400">admin@company.com</p>
             </div>
         </div>
     </div>
 </aside>
