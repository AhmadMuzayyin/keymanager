<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title', config('app.name', 'AppStore')) - Marketplace Aplikasi Terbaik</title>
    <meta name="description" content="@yield('meta_description', 'Marketplace aplikasi Android, Desktop & Web terbaik dengan license key resmi. Dapatkan aplikasi berkualitas dengan harga terjangkau.')">
    <meta name="keywords" content="@yield('meta_keywords', 'aplikasi android, aplikasi desktop, aplikasi web, source code, license key, marketplace aplikasi')">
    <meta name="author" content="{{ config('app.name') }}">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="@yield('canonical_url', url()->current())">

    <meta property="og:title" content="@yield('og_title', config('app.name'))">
    <meta property="og:description" content="@yield('og_description', 'Marketplace aplikasi Android, Desktop & Web terbaik dengan license key resmi.')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:locale" content="id_ID">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', config('app.name'))">
    <meta name="twitter:description" content="@yield('twitter_description', 'Marketplace aplikasi Android, Desktop & Web terbaik.')">
    <meta name="twitter:image" content="@yield('twitter_image', asset('images/og-default.jpg'))">

    @yield('structured_data')

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        .hero-gradient {
            background: linear-gradient(135deg, #009B4D 0%, #007a3d 100%);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px -15px rgba(0, 155, 77, 0.25);
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .gradient-text {
            background: linear-gradient(135deg, #009B4D 0%, #007a3d 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glass-effect {
            background: rgba(250, 245, 233, 0.95);
            backdrop-filter: blur(10px);
        }

        .bg-primary {
            background-color: #009B4D;
        }

        .bg-primary-dark {
            background-color: #007a3d;
        }

        .bg-accent {
            background-color: #FFCC00;
        }

        .bg-ivory {
            background-color: #FAF5E9;
        }

        .text-primary {
            color: #009B4D;
        }

        .text-accent {
            color: #FFCC00;
        }

        .hover\:text-primary:hover {
            color: #009B4D;
        }

        .btn-primary {
            background: linear-gradient(135deg, #009B4D 0%, #007a3d 100%);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #007a3d 0%, #006030 100%);
        }

        /* Custom Pagination Styling */
        nav[role="navigation"] {
            display: flex;
            justify-content: center;
        }

        nav[role="navigation"]>div {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        nav[role="navigation"] span[aria-current="page"] span {
            background-color: #009B4D !important;
            color: white !important;
            border-color: #009B4D !important;
        }

        nav[role="navigation"] a,
        nav[role="navigation"] span:not([aria-current="page"]) span {
            background-color: white !important;
            color: #374151 !important;
            border: 1px solid #e5e7eb !important;
            border-radius: 0.5rem !important;
            padding: 0.5rem 1rem !important;
            font-weight: 500 !important;
            transition: all 0.2s !important;
        }

        nav[role="navigation"] a:hover {
            background-color: #009B4D !important;
            color: white !important;
            border-color: #009B4D !important;
        }

        nav[role="navigation"] span[aria-disabled="true"] span {
            background-color: #f3f4f6 !important;
            color: #9ca3af !important;
            cursor: not-allowed !important;
        }

        /* Pagination wrapper */
        .pagination-wrapper nav {
            background: transparent !important;
        }

        .pagination-wrapper nav>div:first-child {
            display: none !important;
        }

        .pagination-wrapper nav>div:last-child span,
        .pagination-wrapper nav>div:last-child a {
            border-radius: 0.5rem !important;
            min-width: 2.5rem !important;
            height: 2.5rem !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
    </style>
</head>

<body class="bg-[#FAF5E9] text-slate-800 antialiased">
    <nav class="fixed top-0 left-0 right-0 z-50 glass-effect border-b border-slate-200/50" x-data="{ mobileOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('front.home') }}" class="flex items-center space-x-2">
                    <div class="w-10 h-10 rounded-xl bg-[#009B4D] flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <span class="text-xl font-bold gradient-text">{{ config('app.name', 'AppStore') }}</span>
                </a>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('front.home') }}"
                        class="text-slate-600 hover:text-[#009B4D] transition-colors font-medium">Beranda</a>
                    <a href="{{ route('front.products') }}"
                        class="text-slate-600 hover:text-[#009B4D] transition-colors font-medium">Produk</a>
                    <a href="{{ route('front.order.license-only') }}"
                        class="text-slate-600 hover:text-[#009B4D] transition-colors font-medium">License Key</a>
                    <a href="{{ route('tracking.index') }}"
                        class="text-slate-600 hover:text-[#009B4D] transition-colors font-medium">Lacak Order</a>
                </div>

                <div class="hidden md:flex items-center space-x-3">
                    @auth
                        <a href="{{ route('dashboard.index') }}"
                            class="px-5 py-2.5 bg-[#009B4D] text-white rounded-xl font-medium hover:bg-[#007a3d] hover:shadow-lg transition-all">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-5 py-2.5 text-slate-700 hover:text-[#009B4D] font-medium transition-colors">
                            Login
                        </a>
                    @endauth
                </div>

                <button @click="mobileOpen = !mobileOpen" class="md:hidden p-2 rounded-lg hover:bg-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div x-show="mobileOpen" x-collapse class="md:hidden pb-4">
                <div class="flex flex-col space-y-2">
                    <a href="{{ route('front.home') }}"
                        class="px-4 py-2 rounded-lg hover:bg-slate-100 text-slate-700">Beranda</a>
                    <a href="{{ route('front.products') }}"
                        class="px-4 py-2 rounded-lg hover:bg-slate-100 text-slate-700">Produk</a>
                    <a href="{{ route('front.order.license-only') }}"
                        class="px-4 py-2 rounded-lg hover:bg-slate-100 text-slate-700">License Key</a>
                    <a href="{{ route('tracking.index') }}"
                        class="px-4 py-2 rounded-lg hover:bg-slate-100 text-slate-700">Lacak Order</a>
                    @auth
                        <a href="{{ route('dashboard.index') }}"
                            class="px-4 py-2 bg-[#009B4D] text-white rounded-lg text-center">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 bg-[#009B4D] text-white rounded-lg text-center">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="pt-16">
        @yield('content')
    </main>

    <footer class="bg-[#007a3d] text-white mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-[#FFCC00] flex items-center justify-center">
                            <svg class="w-6 h-6 text-[#007a3d]" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white">{{ config('app.name', 'AppStore') }}</span>
                    </div>
                    <p class="text-white/70 mb-4 max-w-md">
                        Marketplace aplikasi terbaik untuk kebutuhan bisnis Anda. Dapatkan aplikasi Android, Desktop,
                        dan Web berkualitas dengan license key resmi.
                    </p>
                </div>

                <div>
                    <h4 class="font-semibold text-[#FFCC00] mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('front.products') }}"
                                class="text-white/70 hover:text-[#FFCC00] transition-colors">Semua Produk</a></li>
                        <li><a href="{{ route('front.order.license-only') }}"
                                class="text-white/70 hover:text-[#FFCC00] transition-colors">Beli License</a></li>
                        <li><a href="{{ route('tracking.index') }}"
                                class="text-white/70 hover:text-[#FFCC00] transition-colors">Lacak Order</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold text-[#FFCC00] mb-4">Kategori</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('front.products', ['type' => 'android']) }}"
                                class="text-white/70 hover:text-[#FFCC00] transition-colors">Android Apps</a></li>
                        <li><a href="{{ route('front.products', ['type' => 'desktop']) }}"
                                class="text-white/70 hover:text-[#FFCC00] transition-colors">Desktop Apps</a></li>
                        <li><a href="{{ route('front.products', ['type' => 'web']) }}"
                                class="text-white/70 hover:text-[#FFCC00] transition-colors">Web Apps</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-white/20 mt-8 pt-8 text-center text-white/50">
                <p>&copy; {{ date('Y') }} {{ config('app.name', 'AppStore') }}. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>

</html>
