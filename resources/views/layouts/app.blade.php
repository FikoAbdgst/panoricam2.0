<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Photobooth App' }}</title>
    @vite('resources/css/app.css')
    @stack('styles')
</head>

<body class="bg-gray-100">
    @include('components.navbar')

    <main>
        @yield('hero_section')
        @yield('content_section')
    </main>

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbar = document.getElementById('navbar');
            const originalClasses = navbar.className;

            window.addEventListener('scroll', function() {
                if (window.scrollY > 10) {
                    navbar.className =
                        'fixed top-0 left-0 right-0 bg-white shadow-md w-full h-20 z-50 transition-all duration-300';
                } else {
                    navbar.className = originalClasses;
                }
            });
        });
    </script>
</body>

</html>
