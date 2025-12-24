<header class="sticky top-0 z-10 bg-white/80 backdrop-blur-md border-b border-slate-200/50">
    <div class="flex items-center justify-between px-4 sm:px-6 lg:px-8 py-4">
        {{-- Left Section --}}
        <div class="flex items-center space-x-4">
            {{-- Mobile Menu Button --}}
            <button @click="sidebarOpen = !sidebarOpen"
                class="lg:hidden p-2 rounded-lg text-slate-500 hover:text-slate-700 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>

            {{-- Page Title & Breadcrumb --}}
            <div class="hidden lg:block">
                <h1 class="text-xl font-semibold text-slate-800">@yield('page-title', 'Dashboard')</h1>
                <nav class="flex items-center space-x-1 text-sm text-slate-500 mt-0.5">
                    <a href="{{ route('dashboard.index') }}" class="hover:text-indigo-600 transition-colors">Home</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="text-slate-700">@yield('page-title', 'Dashboard')</span>
                </nav>
            </div>

            {{-- Mobile Title --}}
            <h1 class="lg:hidden text-lg font-semibold text-slate-800">@yield('page-title', 'Dashboard')</h1>
        </div>

        {{-- Right Section --}}
        <div class="flex items-center space-x-3">
            {{-- Search (Desktop) --}}
            <div class="hidden md:block relative">
                <input type="text" placeholder="Cari..."
                    class="w-64 pl-10 pr-4 py-2 text-sm bg-slate-100 border-0 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:bg-white transition-all">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>

            {{-- Notifications --}}
            <button
                class="relative p-2 rounded-xl text-slate-500 hover:text-slate-700 hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                    </path>
                </svg>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>

            {{-- Profile Dropdown --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open"
                    class="flex items-center space-x-3 p-1.5 pr-3 rounded-xl hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                    <div
                        class="w-9 h-9 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-semibold text-sm shadow-md">
                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                    </div>
                    <div class="hidden sm:block text-left">
                        <p class="text-sm font-medium text-slate-700">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-slate-500">Administrator</p>
                    </div>
                    <svg class="hidden sm:block w-4 h-4 text-slate-400 transition-transform"
                        :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-slate-200/50 py-2 z-50"
                    x-cloak>

                    <div class="px-4 py-3 border-b border-slate-100">
                        <p class="text-sm font-medium text-slate-800">{{ auth()->user()->name ?? 'Admin' }}</p>
                        <p class="text-xs text-slate-500">{{ auth()->user()->email ?? 'admin@example.com' }}</p>
                    </div>

                    <div class="py-1">
                        <a href="#"
                            class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                            <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Profil Saya
                        </a>
                        <a href="#"
                            class="flex items-center px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 transition-colors">
                            <svg class="w-5 h-5 mr-3 text-slate-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Pengaturan
                        </a>
                    </div>

                    <div class="border-t border-slate-100 py-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
