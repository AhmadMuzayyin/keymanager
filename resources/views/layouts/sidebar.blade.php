<aside
    class="fixed inset-y-0 left-0 z-30 w-64 sidebar-gradient overflow-y-auto scrollbar-thin transition-transform duration-300 lg:translate-x-0"
    :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">

    {{-- Logo --}}
    <div class="flex items-center justify-between px-6 py-5 border-b border-white/10">
        <div class="flex items-center space-x-3">
            <div
                class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-400 to-purple-500 flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                    </path>
                </svg>
            </div>
            <div>
                <h1 class="text-lg font-bold text-white">KeyManager</h1>
                <p class="text-xs text-indigo-300">License & Apps</p>
            </div>
        </div>

        {{-- Close Button (Mobile Only) --}}
        <button @click="sidebarOpen = false"
            class="lg:hidden p-2 rounded-lg text-white/70 hover:text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/20 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    {{-- Navigation --}}
    <nav class="px-3 py-4 space-y-1">
        {{-- Main Menu --}}
        <p class="px-3 mb-2 text-xs font-semibold text-indigo-300 uppercase tracking-wider">Menu Utama</p>

        <a href="{{ route('dashboard.index') }}"
            class="nav-item flex items-center px-3 py-2.5 rounded-lg text-white/90 hover:text-white group {{ request()->routeIs('dashboard.*') ? 'active bg-white/10' : '' }}">
            <div
                class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center mr-3 group-hover:bg-white/20 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z">
                    </path>
                </svg>
            </div>
            <span class="font-medium">Dashboard</span>
        </a>

        {{-- License Management --}}
        <p class="px-3 mt-6 mb-2 text-xs font-semibold text-indigo-300 uppercase tracking-wider">Manajemen Lisensi</p>

        <a href="{{ route('customers.index') }}"
            class="nav-item flex items-center px-3 py-2.5 rounded-lg text-white/90 hover:text-white group {{ request()->routeIs('customers.*') ? 'active bg-white/10' : '' }}">
            <div
                class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center mr-3 group-hover:bg-white/20 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
            </div>
            <span class="font-medium">Customer</span>
        </a>

        <a href="{{ route('licenses.index') }}"
            class="nav-item flex items-center px-3 py-2.5 rounded-lg text-white/90 hover:text-white group {{ request()->routeIs('licenses.*') ? 'active bg-white/10' : '' }}">
            <div
                class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center mr-3 group-hover:bg-white/20 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                    </path>
                </svg>
            </div>
            <span class="font-medium">Lisensi</span>
        </a>

        <a href="{{ route('logs.index') }}"
            class="nav-item flex items-center px-3 py-2.5 rounded-lg text-white/90 hover:text-white group {{ request()->routeIs('logs.*') ? 'active bg-white/10' : '' }}">
            <div
                class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center mr-3 group-hover:bg-white/20 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
            </div>
            <span class="font-medium">Log Aktivitas</span>
        </a>

        {{-- E-Commerce --}}
        <p class="px-3 mt-6 mb-2 text-xs font-semibold text-indigo-300 uppercase tracking-wider">E-Commerce</p>

        <a href="{{ route('products.index') }}"
            class="nav-item flex items-center px-3 py-2.5 rounded-lg text-white/90 hover:text-white group {{ request()->routeIs('products.*') ? 'active bg-white/10' : '' }}">
            <div
                class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center mr-3 group-hover:bg-white/20 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                    </path>
                </svg>
            </div>
            <span class="font-medium">Produk</span>
        </a>

        <a href="{{ route('categories.index') }}"
            class="nav-item flex items-center px-3 py-2.5 rounded-lg text-white/90 hover:text-white group {{ request()->routeIs('categories.*') ? 'active bg-white/10' : '' }}">
            <div
                class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center mr-3 group-hover:bg-white/20 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                    </path>
                </svg>
            </div>
            <span class="font-medium">Kategori</span>
        </a>

        <a href="{{ route('orders.index') }}"
            class="nav-item flex items-center px-3 py-2.5 rounded-lg text-white/90 hover:text-white group {{ request()->routeIs('orders.*') ? 'active bg-white/10' : '' }}">
            <div
                class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center mr-3 group-hover:bg-white/20 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z">
                    </path>
                </svg>
            </div>
            <span class="font-medium">Pesanan</span>
        </a>

        <a href="{{ route('custom-orders.index') }}"
            class="nav-item flex items-center px-3 py-2.5 rounded-lg text-white/90 hover:text-white group {{ request()->routeIs('custom-orders.*') ? 'active bg-white/10' : '' }}">
            <div
                class="w-9 h-9 rounded-lg bg-white/10 flex items-center justify-center mr-3 group-hover:bg-white/20 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z">
                    </path>
                </svg>
            </div>
            <span class="font-medium">Custom Order</span>
        </a>
    </nav>

    {{-- Bottom Section --}}
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-white/10">
        <a href="{{ route('tracking.index') }}" target="_blank"
            class="flex items-center justify-center px-4 py-2.5 rounded-lg bg-white/10 hover:bg-white/20 text-white/90 hover:text-white transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9">
                </path>
            </svg>
            <span class="text-sm font-medium">Public Tracking</span>
            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                </path>
            </svg>
        </a>
    </div>
</aside>
