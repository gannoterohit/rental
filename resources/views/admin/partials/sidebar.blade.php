<div class="w-64 bg-white border-r border-slate-200 flex-col shadow-xl hidden lg:flex">
    <!-- Logo -->


    <!-- Navigation -->
    <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-indigo-500 to-cyan-500 text-white shadow-lg' : 'hover:bg-slate-50 text-slate-700' }} transition transform hover:scale-105">
            <i class="fas fa-tachometer-alt mr-3 text-lg"></i>
            <span class="font-medium">Dashboard</span>
        </a>
        
        <a href="{{ route('admin.analytics') }}" 
           class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.analytics') ? 'bg-gradient-to-r from-indigo-500 to-cyan-500 text-white shadow-lg' : 'hover:bg-slate-50 text-slate-700' }} transition transform hover:scale-105">
            <i class="fas fa-chart-line mr-3 text-lg"></i>
            <span class="font-medium">Search Analytics</span>
        </a>
        
        <!-- Settings Management Dropdown -->
        <div class="relative">
            <button id="settingsDropdownBtn" 
                    class="w-full flex items-center justify-between px-4 py-3 rounded-lg {{ (request()->routeIs('admin.settings*') || request()->routeIs('admin.pages*')) ? 'bg-gradient-to-r from-indigo-500 to-cyan-500 text-white shadow-lg' : 'hover:bg-slate-50 text-slate-700' }} transition transform hover:scale-105">
                <div class="flex items-center">
                    <i class="fas fa-cog mr-3 text-lg"></i>
                    <span class="font-medium">Business Settings</span>
                </div>
                <i class="fas fa-chevron-down text-xs {{ (request()->routeIs('admin.settings*') || request()->routeIs('admin.pages*')) ? 'text-white' : 'text-slate-500' }} transition-transform" id="settingsDropdownIcon"></i>
            </button>
            
            <div id="settingsDropdown" class="{{ (request()->routeIs('admin.settings*') || request()->routeIs('admin.pages*')) ? '' : 'hidden' }} mt-1 ml-4 space-y-1">
                <a href="{{ route('admin.settings') }}" 
                   class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.settings') ? 'bg-indigo-100 text-indigo-600' : 'hover:bg-slate-50 text-slate-600' }} transition">
                    <i class="fas fa-briefcase mr-3 text-sm"></i>
                    <span class="text-sm">Business Settings</span>
                </a>
                
                <!-- Pages Sub-dropdown -->
                <div class="relative">
                    <button id="pagesDropdownBtn" 
                            class="w-full flex items-center justify-between px-4 py-2 rounded-lg {{ request()->routeIs('admin.pages*') ? 'bg-indigo-100 text-indigo-600' : 'hover:bg-slate-50 text-slate-600' }} transition">
                        <div class="flex items-center">
                            <i class="fas fa-file-alt mr-3 text-sm"></i>
                            <span class="text-sm">Pages</span>
                        </div>
                        <i class="fas fa-chevron-right text-xs transition-transform" id="pagesDropdownIcon"></i>
                    </button>
                    
                    <div id="pagesDropdown" class="{{ request()->routeIs('admin.pages*') ? '' : 'hidden' }} mt-1 ml-4 space-y-1">
                        <a href="{{ route('admin.pages.terms') }}" 
                           class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.pages.terms') ? 'bg-indigo-100 text-indigo-600' : 'hover:bg-slate-50 text-slate-600' }} transition">
                            <i class="fas fa-file-contract mr-3 text-xs"></i>
                            <span class="text-sm">Terms</span>
                        </a>
                        <a href="{{ route('admin.pages.condition') }}" 
                           class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.pages.condition') ? 'bg-indigo-100 text-indigo-600' : 'hover:bg-slate-50 text-slate-600' }} transition">
                            <i class="fas fa-shield-alt mr-3 text-xs"></i>
                            <span class="text-sm">Condition Policy</span>
                        </a>
                        <a href="{{ route('admin.pages.privacy') }}" 
                           class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.pages.privacy') ? 'bg-indigo-100 text-indigo-600' : 'hover:bg-slate-50 text-slate-600' }} transition">
                            <i class="fas fa-lock mr-3 text-xs"></i>
                            <span class="text-sm">Privacy Policy</span>
                        </a>
                        <a href="{{ route('admin.pages.contact') }}" 
                           class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.pages.contact') ? 'bg-indigo-100 text-indigo-600' : 'hover:bg-slate-50 text-slate-600' }} transition">
                            <i class="fas fa-envelope mr-3 text-xs"></i>
                            <span class="text-sm">Contact</span>
                        </a>
                        <a href="{{ route('admin.pages.faq') }}" 
                           class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.pages.faq') ? 'bg-indigo-100 text-indigo-600' : 'hover:bg-slate-50 text-slate-600' }} transition">
                            <i class="fas fa-question-circle mr-3 text-xs"></i>
                            <span class="text-sm">FAQ</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <a href="{{ route('admin.plans.index') }}" 
           class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.plans*') ? 'bg-gradient-to-r from-indigo-500 to-cyan-500 text-white shadow-lg' : 'hover:bg-slate-50 text-slate-700' }} transition transform hover:scale-105">
            <i class="fas fa-tags mr-3 text-lg"></i>
            <span class="font-medium">Plans</span>
        </a>
        <a href="{{ route('admin.offers.index') }}" 
           class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.offers*') ? 'bg-gradient-to-r from-indigo-500 to-cyan-500 text-white shadow-lg' : 'hover:bg-slate-50 text-slate-700' }} transition transform hover:scale-105">
            <i class="fas fa-bullhorn mr-3 text-lg"></i>
            <span class="font-medium">Manage Offers</span>
        </a>
        <a href="{{ route('admin.all-rooms') }}" 
           class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.all-rooms') ? 'bg-gradient-to-r from-indigo-500 to-cyan-500 text-white shadow-lg' : 'hover:bg-slate-50 text-slate-700' }} transition transform hover:scale-105">
            <i class="fas fa-home mr-3 text-lg"></i>
            <span class="font-medium">All Rooms</span>
        </a>
        <a href="{{ route('admin.payments.index') }}" 
           class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.payments.*') ? 'bg-gradient-to-r from-indigo-500 to-cyan-500 text-white shadow-lg' : 'hover:bg-slate-50 text-slate-700' }} transition transform hover:scale-105">
            <i class="fas fa-credit-card mr-3 text-lg"></i>
            <span class="font-medium">Payments</span>
        </a>
        <div class="pt-4 mt-4 border-t border-slate-200">
            <p class="px-4 py-2 text-xs text-slate-500 uppercase font-bold tracking-wider">Management</p>
        </div>
        <a href="{{ route('admin.blogs.index') }}" 
           class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.blogs*') ? 'bg-gradient-to-r from-indigo-500 to-cyan-500 text-white shadow-lg' : 'hover:bg-slate-50 text-slate-700' }} transition transform hover:scale-105">
            <i class="fas fa-newspaper mr-3 text-lg"></i>
            <span class="font-medium">Manage Blogs</span>
        </a>
        <a href="{{ route('admin.subscribers.index') }}" 
           class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.subscribers*') ? 'bg-gradient-to-r from-indigo-500 to-cyan-500 text-white shadow-lg' : 'hover:bg-slate-50 text-slate-700' }} transition transform hover:scale-105">
            <i class="fas fa-envelope mr-3 text-lg"></i>
            <span class="font-medium">Newsletter Subscribers</span>
        </a>
        <a href="{{ route('admin.city-alerts.index') }}" 
           class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.city-alerts*') ? 'bg-gradient-to-r from-indigo-500 to-cyan-500 text-white shadow-lg' : 'hover:bg-slate-50 text-slate-700' }} transition transform hover:scale-105">
            <i class="fas fa-bell mr-3 text-lg"></i>
            <span class="font-medium">City Alerts</span>
        </a>
        <a href="{{ route('admin.users') }}" 
           class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.users*') ? 'bg-gradient-to-r from-indigo-500 to-cyan-500 text-white shadow-lg' : 'hover:bg-slate-50 text-slate-700' }} transition transform hover:scale-105">
            <i class="fas fa-users mr-3 text-lg"></i>
            <span class="font-medium">All Users</span>
        </a>
        <a href="{{ route('admin.contact-messages.index') }}" 
           class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.contact-messages*') ? 'bg-gradient-to-r from-indigo-500 to-cyan-500 text-white shadow-lg' : 'hover:bg-slate-50 text-slate-700' }} transition transform hover:scale-105">
            <i class="fas fa-envelope-open-text mr-3 text-lg"></i>
            <span class="font-medium">Contact Messages</span>
        </a>
        <a href="{{ route('admin.reports') }}" 
           class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.reports') ? 'bg-gradient-to-r from-indigo-500 to-cyan-500 text-white shadow-lg' : 'hover:bg-slate-50 text-slate-700' }} transition transform hover:scale-105">
            <i class="fas fa-chart-bar mr-3 text-lg"></i>
            <span class="font-medium">Reports</span>
        </a>
        <a href="{{ route('admin.owners') }}" 
           class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.owners*') ? 'bg-gradient-to-r from-indigo-500 to-cyan-500 text-white shadow-lg' : 'hover:bg-slate-50 text-slate-700' }} transition transform hover:scale-105">
            <i class="fas fa-user-tie mr-3 text-lg"></i>
            <span class="font-medium">All Owners</span>
        </a>
        <a href="{{ route('home') }}" 
           class="flex items-center px-4 py-3 rounded-lg hover:bg-slate-50 text-slate-700 transition transform hover:scale-105">
            <i class="fas fa-globe mr-3 text-lg"></i>
            <span class="font-medium">View Website</span>
        </a>
    </nav>

    <!-- User Info -->
    <div class="p-4 border-t border-slate-200 bg-slate-50">
        <div class="flex items-center mb-3">
            <div class="bg-gradient-to-r from-indigo-500 to-cyan-500 rounded-full p-2 mr-3">
                <i class="fas fa-user-shield text-xl text-white"></i>
            </div>
            <div>
                <p class="font-bold text-slate-800">{{ Auth::user()->name }}</p>
                <p class="text-xs text-slate-600">Administrator</p>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" 
                    class="w-full px-4 py-2.5 bg-gradient-to-r from-red-500 to-pink-500 hover:from-red-600 hover:to-pink-600 text-white rounded-lg transition shadow-lg hover:shadow-xl transform hover:scale-105 text-sm font-semibold">
                <i class="fas fa-sign-out-alt mr-2"></i>Logout
            </button>
        </form>
    </div>
</div>

<!-- Mobile Menu Button -->
<div class="lg:hidden fixed top-4 left-4 z-[9999]">
    <button id="adminMobileMenuBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white p-3 rounded-lg shadow-2xl transition-all">
        <i class="fas fa-bars text-xl"></i>
    </button>
</div>

<!-- Mobile Sidebar -->
<div id="adminMobileMenu" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-40 hidden">
    <div class="w-64 bg-gradient-to-b from-gray-800 to-gray-900 text-white h-full shadow-2xl">
        <!-- Same content as desktop sidebar -->
        <div class="p-6 border-b border-gray-700">
            <div class="flex items-center justify-end mb-4">
                <button onclick="closeAdminMobileMenu()" class="text-gray-400 hover:text-white">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
        </div>
        <nav class="p-4 space-y-1 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" 
               class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-r from-purple-600 to-indigo-600' : 'hover:bg-gray-700' }} transition">
                <i class="fas fa-tachometer-alt mr-3"></i>
                <span>Dashboard</span>
            </a>
            
            <!-- Settings Management Dropdown for Mobile -->
            <div class="relative">
                <button id="mobileSettingsDropdownBtn" 
                        class="w-full flex items-center justify-between px-4 py-3 rounded-lg {{ (request()->routeIs('admin.settings*') || request()->routeIs('admin.pages*')) ? 'bg-gradient-to-r from-purple-600 to-indigo-600' : 'hover:bg-gray-700' }} transition">
                    <div class="flex items-center">
                        <i class="fas fa-cog mr-3"></i>
                        <span>Settings Management</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs" id="mobileSettingsDropdownIcon"></i>
                </button>
                
                <div id="mobileSettingsDropdown" class="{{ (request()->routeIs('admin.settings*') || request()->routeIs('admin.pages*')) ? '' : 'hidden' }} mt-1 ml-4 space-y-1">
                    <a href="{{ route('admin.settings') }}" 
                       class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.settings') ? 'bg-purple-700' : 'hover:bg-gray-700' }} transition">
                        <i class="fas fa-briefcase mr-3 text-sm"></i>
                        <span class="text-sm">Business Settings</span>
                    </a>
                    
                    <!-- Pages Sub-dropdown for Mobile -->
                    <div class="relative">
                        <button id="mobilePagesDropdownBtn" 
                                class="w-full flex items-center justify-between px-4 py-2 rounded-lg {{ request()->routeIs('admin.pages*') ? 'bg-purple-700' : 'hover:bg-gray-700' }} transition">
                            <div class="flex items-center">
                                <i class="fas fa-file-alt mr-3 text-sm"></i>
                                <span class="text-sm">Pages</span>
                            </div>
                            <i class="fas fa-chevron-right text-xs" id="mobilePagesDropdownIcon"></i>
                        </button>
                        
                        <div id="mobilePagesDropdown" class="{{ request()->routeIs('admin.pages*') ? '' : 'hidden' }} mt-1 ml-4 space-y-1">
                            <a href="{{ route('admin.pages.terms') }}" 
                               class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.pages.terms') ? 'bg-purple-700' : 'hover:bg-gray-700' }} transition">
                                <i class="fas fa-file-contract mr-3 text-xs"></i>
                                <span class="text-sm">Terms</span>
                            </a>
                            <a href="{{ route('admin.pages.condition') }}" 
                               class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.pages.condition') ? 'bg-purple-700' : 'hover:bg-gray-700' }} transition">
                                <i class="fas fa-shield-alt mr-3 text-xs"></i>
                                <span class="text-sm">Condition Policy</span>
                            </a>
                            <a href="{{ route('admin.pages.privacy') }}" 
                               class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.pages.privacy') ? 'bg-purple-700' : 'hover:bg-gray-700' }} transition">
                                <i class="fas fa-lock mr-3 text-xs"></i>
                                <span class="text-sm">Privacy Policy</span>
                            </a>
                            <a href="{{ route('admin.pages.contact') }}" 
                               class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.pages.contact') ? 'bg-purple-700' : 'hover:bg-gray-700' }} transition">
                                <i class="fas fa-envelope mr-3 text-xs"></i>
                                <span class="text-sm">Contact</span>
                            </a>
                            <a href="{{ route('admin.pages.faq') }}" 
                               class="flex items-center px-4 py-2 rounded-lg {{ request()->routeIs('admin.pages.faq') ? 'bg-purple-700' : 'hover:bg-gray-700' }} transition">
                                <i class="fas fa-question-circle mr-3 text-xs"></i>
                                <span class="text-sm">FAQ</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <a href="{{ route('admin.plans.index') }}" 
               class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.plans*') ? 'bg-gradient-to-r from-purple-600 to-indigo-600' : 'hover:bg-gray-700' }} transition">
                <i class="fas fa-tags mr-3"></i>
                <span>Plans</span>
            </a>
            <a href="{{ route('admin.offers.index') }}" 
               class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.offers*') ? 'bg-gradient-to-r from-purple-600 to-indigo-600' : 'hover:bg-gray-700' }} transition">
                <i class="fas fa-bullhorn mr-3"></i>
                <span>Manage Offers</span>
            </a>
            <a href="{{ route('admin.all-rooms') }}" 
               class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.all-rooms') ? 'bg-gradient-to-r from-purple-600 to-indigo-600' : 'hover:bg-gray-700' }} transition">
                <i class="fas fa-home mr-3"></i>
                <span>All Rooms</span>
            </a>
            <a href="{{ route('admin.payments.index') }}" 
               class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.payments.*') ? 'bg-gradient-to-r from-purple-600 to-indigo-600' : 'hover:bg-gray-700' }} transition">
                <i class="fas fa-credit-card mr-3"></i>
                <span>Payments</span>
            </a>
            <div class="pt-4 mt-4 border-t border-gray-700">
                <p class="px-4 py-2 text-xs text-gray-400 uppercase font-bold">Management</p>
            </div>
            <a href="{{ route('admin.blogs.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.blogs*') ? 'bg-gradient-to-r from-purple-600 to-indigo-600' : 'hover:bg-gray-700' }} transition">
                <i class="fas fa-newspaper mr-3"></i>
                <span>Manage Blogs</span>
            </a>
            <a href="{{ route('admin.city-alerts.index') }}" class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.city-alerts*') ? 'bg-gradient-to-r from-purple-600 to-indigo-600' : 'hover:bg-gray-700' }} transition">
                <i class="fas fa-bell mr-3"></i>
                <span>City Alerts</span>
            </a>
            <a href="{{ route('admin.users') }}" 
               class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.users*') ? 'bg-gradient-to-r from-purple-600 to-indigo-600' : 'hover:bg-gray-700' }} transition">
                <i class="fas fa-users mr-3"></i>
                <span>All Users</span>
            </a>
            <a href="{{ route('admin.contact-messages.index') }}" 
               class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.contact-messages*') ? 'bg-gradient-to-r from-purple-600 to-indigo-600' : 'hover:bg-gray-700' }} transition">
                <i class="fas fa-envelope-open-text mr-3"></i>
                <span>Contact Messages</span>
            </a>
            <a href="{{ route('admin.reports') }}" 
               class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.reports') ? 'bg-gradient-to-r from-purple-600 to-indigo-600' : 'hover:bg-gray-700' }} transition">
                <i class="fas fa-chart-bar mr-3"></i>
                <span>Reports</span>
            </a>
            <a href="{{ route('admin.owners') }}" 
               class="flex items-center px-4 py-3 rounded-lg {{ request()->routeIs('admin.owners*') ? 'bg-gradient-to-r from-purple-600 to-indigo-600' : 'hover:bg-gray-700' }} transition">
                <i class="fas fa-user-tie mr-3"></i>
                <span>All Owners</span>
            </a>
            <a href="{{ route('home') }}" 
               class="flex items-center px-4 py-3 rounded-lg hover:bg-gray-700 transition">
                <i class="fas fa-globe mr-3"></i>
                <span>View Website</span>
            </a>
        </nav>
        <div class="p-4 border-t border-gray-700">
            <div class="flex items-center mb-3">
                <div class="bg-purple-600 rounded-full p-2 mr-3">
                    <i class="fas fa-user-shield"></i>
                </div>
                <div>
                    <p class="font-bold">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400">Admin</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" 
                        class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 rounded-lg transition text-sm">
                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('adminMobileMenuBtn')?.addEventListener('click', function() {
    document.getElementById('adminMobileMenu').classList.remove('hidden');
});

function closeAdminMobileMenu() {
    document.getElementById('adminMobileMenu').classList.add('hidden');
}

// Close on outside click
document.getElementById('adminMobileMenu')?.addEventListener('click', function(e) {
    if (e.target.id === 'adminMobileMenu') {
        closeAdminMobileMenu();
    }
});

// Settings dropdown functionality for desktop
document.getElementById('settingsDropdownBtn')?.addEventListener('click', function() {
    const dropdown = document.getElementById('settingsDropdown');
    const icon = document.getElementById('settingsDropdownIcon');
    
    dropdown.classList.toggle('hidden');
    icon.classList.toggle('rotate-180');
});

// Pages dropdown functionality for desktop
document.getElementById('pagesDropdownBtn')?.addEventListener('click', function() {
    const dropdown = document.getElementById('pagesDropdown');
    const icon = document.getElementById('pagesDropdownIcon');
    
    dropdown.classList.toggle('hidden');
    icon.classList.toggle('rotate-90');
});

// Settings dropdown functionality for mobile
document.getElementById('mobileSettingsDropdownBtn')?.addEventListener('click', function() {
    const dropdown = document.getElementById('mobileSettingsDropdown');
    const icon = document.getElementById('mobileSettingsDropdownIcon');
    
    dropdown.classList.toggle('hidden');
    icon.classList.toggle('rotate-180');
});

// Pages dropdown functionality for mobile
document.getElementById('mobilePagesDropdownBtn')?.addEventListener('click', function() {
    const dropdown = document.getElementById('mobilePagesDropdown');
    const icon = document.getElementById('mobilePagesDropdownIcon');
    
    dropdown.classList.toggle('hidden');
    icon.classList.toggle('rotate-90');
});
</script>