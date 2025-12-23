<aside
    class="fixed inset-y-0 left-0 z-30 w-64 overflow-y-auto transition duration-300 transform bg-gray-900 lg:translate-x-0 lg:static lg:inset-0"
    :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }" @click.away="sidebarOpen = false">

    <div class="flex items-center justify-center mt-8">
        <div class="flex items-center">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                </path>
            </svg>
            <span class="mx-2 text-2xl font-semibold text-white">License Manager</span>
        </div>
    </div>

    <nav class="mt-10">
        <a href="{{ route('dashboard.index') }}"
            class="flex items-center px-6 py-3 text-gray-100 hover:bg-gray-700 hover:text-white {{ request()->routeIs('dashboard.*') ? 'bg-gray-700' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                </path>
            </svg>
            <span class="mx-3">Dashboard</span>
        </a>

        <a href="{{ route('licenses.index') }}"
            class="flex items-center px-6 py-3 text-gray-100 hover:bg-gray-700 hover:text-white {{ request()->routeIs('licenses.*') ? 'bg-gray-700' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                </path>
            </svg>
            <span class="mx-3">Lisensi</span>
        </a>

        <a href="{{ route('logs.index') }}"
            class="flex items-center px-6 py-3 text-gray-100 hover:bg-gray-700 hover:text-white {{ request()->routeIs('logs.*') ? 'bg-gray-700' : '' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                </path>
            </svg>
            <span class="mx-3">Log Aktivitas</span>
        </a>
    </nav>
</aside>

<div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black opacity-50 lg:hidden"
    style="display: none;"></div>
