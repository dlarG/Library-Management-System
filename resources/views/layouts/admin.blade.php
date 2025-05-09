<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Library Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }
        .sidebar {
            transition: all 0.3s ease;
            transform: translateX(-100%);
        }
        .sidebar-open {
            transform: translateX(0);
        }
        .active-nav {
            background-color: #e0e7ff;
            color: #4f46e5;
            border-left: 4px solid #4f46e5;
        }
        .active-nav svg {
            color: #4f46e5;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
        }
        .overlay-open {
            display: block;
        }
        @media (min-width: 768px) {
            .sidebar {
                transform: translateX(0);
            }
            .overlay {
                display: none !important;
            }
        }
        @font-face {
            font-family: 'Inter';
            font-style: normal;
            font-weight: 300 700;
            font-display: swap;
            src: url('{{ asset('fonts/Inter-VariableFont_slnt,wght.ttf') }}') format('truetype');
        }
    </style>
    @stack('styles')
</head>
<body class="flex h-screen overflow-hidden">
    <!-- Mobile overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Include Sidebar -->
    @include('layouts.partials.admin-sidebar')

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Include Top Navigation -->
        @include('layouts.partials.admin-navbar')

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const openSidebarBtn = document.getElementById('openSidebar');
            const closeSidebarBtn = document.getElementById('closeSidebar');

            // Open sidebar
            openSidebarBtn.addEventListener('click', function() {
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

            closeSidebarBtn.addEventListener('click', closeSidebar);
            overlay.addEventListener('click', closeSidebar);

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth < 768 && 
                    !sidebar.contains(event.target) && 
                    !openSidebarBtn.contains(event.target)) {
                    closeSidebar();
                }
            });

            // Close sidebar when pressing Escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeSidebar();
                }
            });

            // Auto-close sidebar when clicking a nav link on mobile
            const navLinks = document.querySelectorAll('nav a');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        closeSidebar();
                    }
                });
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>