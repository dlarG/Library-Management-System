<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | My Library</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .member {
            --primary-color: #3b82f6;
            --primary-light: #dbeafe;
        }
        
        .member .active-nav {
            background-color: var(--primary-light);
            border-left: 4px solid var(--primary-color);
        }
        
        .member .btn-primary {
            @apply bg-blue-600 hover:bg-blue-700 text-white;
        }
        
        .member .card {
            @apply bg-white rounded-xl shadow-sm border border-blue-50;
        }
        
        .progress-bar {
            height: 8px;
            @apply bg-blue-100 rounded-full overflow-hidden;
        }
        
        .progress-fill {
            height: 100%;
            @apply bg-blue-500;
            transition: width 0.3s ease;
        }
    </style>
    @stack('styles')
</head>
<body class="member flex h-screen overflow-hidden">
    <!-- Mobile overlay -->
    <div class="overlay" id="overlay"></div>

    @include('layouts.partials.member-sidebar')

    <div class="flex-1 flex flex-col overflow-hidden">
        @include('layouts.partials.member-navbar')

        <main class="flex-1 overflow-y-auto p-6 bg-blue-50">
            @yield('content')
        </main>
    </div>

    <!-- Reuse admin scripts -->
    <script>
        // Same sidebar functionality as admin
    </script>
    
    @stack('scripts')
</body>
</html>