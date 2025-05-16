<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | My Library</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .member-layout {
            --primary-color: #3b82f6;
            --primary-light: #dbeafe;
        }
        
        .member-layout .sidebar {
            transition: all 0.3s ease;
            transform: translateX(-100%);
        }
        
        .member-layout .sidebar-open {
            transform: translateX(0);
        }
        
        .member-layout .active-nav {
            background-color: var(--primary-light);
            border-left: 4px solid var(--primary-color);
        }
        
        .member-layout .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 40;
        }
        
        .member-layout .overlay-open {
            display: block;
        }
        
        @media (min-width: 768px) {
            .member-layout .sidebar {
                transform: translateX(0);
            }
            .member-layout .overlay {
                display: none !important;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="member-layout flex h-screen overflow-hidden">
    <!-- Mobile overlay -->
    <div class="overlay" id="overlay"></div>

    <!-- Include Sidebar -->
    @include('layouts.partials.member-sidebar')

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Include Top Navigation -->
        @include('layouts.partials.member-navbar')

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto p-6 bg-gray-50">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('member-sidebar');
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

            // Auto-close sidebar when clicking nav links
            const navLinks = document.querySelectorAll('#member-sidebar nav a');
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