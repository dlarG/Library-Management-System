<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | LibraLynx</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .librarian-layout {
            --primary-color: #4f46e5;
            --primary-light: #e0e7ff;
        }
        
        .librarian-layout .sidebar {
            transition: all 0.3s ease;
            transform: translateX(-100%);
        }
        
        .librarian-layout .sidebar-open {
            transform: translateX(0);
        }
        
        .librarian-layout .active-nav {
            background-color: var(--primary-light);
            border-left: 4px solid var(--primary-color);
        }
        
        .librarian-layout .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
        }
        
        @media (min-width: 768px) {
            .librarian-layout .sidebar {
                transform: translateX(0);
            }
            .librarian-layout .overlay {
                display: none !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="librarian-layout flex h-screen overflow-hidden">
    <!-- Mobile overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Include Sidebar -->
    @include('layouts.partials.librarian-sidebar')

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Include Top Navigation -->
        @include('layouts.partials.librarian-navbar')

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        // Sidebar toggle logic similar to admin
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const openSidebarBtn = document.getElementById('openSidebar');
            const closeSidebarBtn = document.getElementById('closeSidebar');

            // Open sidebar
            openSidebarBtn?.addEventListener('click', function() {
                sidebar.classList.add('sidebar-open');
                overlay.classList.add('overlay-open');
                document.body.style.overflow = 'hidden';
            });

            // Close sidebar
            function closeSidebar() {
                sidebar.classList.remove('sidebar-open');
                overlay.classList.remove('overlay-open');
                document.body.style.overflow = '';
            }

            closeSidebarBtn?.addEventListener('click', closeSidebar);
            overlay?.addEventListener('click', closeSidebar);
        });
    </script>
    @stack('scripts')
</body>
</html>