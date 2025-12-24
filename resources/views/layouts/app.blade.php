<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'KeyManager') - Admin Panel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        .sidebar-gradient {
            background: linear-gradient(180deg, #1e1b4b 0%, #312e81 50%, #3730a3 100%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .hover-lift {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 20px -10px rgba(0, 0, 0, 0.15);
        }

        .nav-item {
            position: relative;
            transition: all 0.2s ease;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: transparent;
            border-radius: 0 4px 4px 0;
            transition: all 0.2s ease;
        }

        .nav-item:hover::before,
        .nav-item.active::before {
            background: linear-gradient(180deg, #818cf8, #c084fc);
        }

        .nav-item:hover,
        .nav-item.active {
            background: rgba(255, 255, 255, 0.1);
        }

        .scrollbar-thin::-webkit-scrollbar {
            width: 4px;
        }

        .scrollbar-thin::-webkit-scrollbar-track {
            background: transparent;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 4px;
        }

        .scrollbar-thin::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .btn-gradient {
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            transition: all 0.2s ease;
        }

        .btn-gradient:hover {
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);
        }

        .stat-card {
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1) 0%, transparent 100%);
            border-radius: 0 0 0 100%;
        }
    </style>
</head>

<body class="bg-slate-100 antialiased" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">
        @include('layouts.sidebar')

        <div class="flex flex-col flex-1 w-full overflow-hidden lg:ml-64">
            @include('layouts.header')

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-100">
                <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 animate-fade-in">
                    @if (session('success'))
                        <x-alert type="success" :message="session('success')" />
                    @endif

                    @if (session('error'))
                        <x-alert type="error" :message="session('error')" />
                    @endif

                    @if ($errors->any())
                        <x-alert type="error" message="Terjadi kesalahan. Silakan periksa form Anda." />
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <div x-show="sidebarOpen" x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="sidebarOpen = false"
        class="fixed inset-0 z-20 bg-slate-900/50 backdrop-blur-sm lg:hidden" x-cloak>
    </div>
</body>

</html>
