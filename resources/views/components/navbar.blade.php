<nav id="navbar" class="bg-[#FEF3E2] font-['Poppins'] w-full h-24 z-50 transition-all duration-300 px-4 sm:px-6 lg:px-8 absolute">
    <div class="max-w-7xl mx-auto h-full">
        <div class="flex justify-between h-full">
    <div class="flex items-center justify-between w-full">
        <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold text-[#BF3131]">
                    <img src="{{ asset('logo.png') }}" alt="Logo" class="h-12 sm:h-16 md:h-[80px] w-auto mx-auto">
                </a>
            </div>
            <div class="flex items-center gap-2 sm:gap-5">
                <a href="{{ route('home') }}"
                    class="text-gray-700 hover:text-[#BF3131] px-2 sm:px-3 py-2 rounded-md text-xs sm:text-sm font-medium relative group nav-link"
                    data-route="home">
                    Home
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-[#BF3131] transform scale-x-0 origin-left transition-transform duration-300 ease-in-out group-hover:scale-x-100 active:scale-x-100"></span>
                </a>
                <a href="{{ route('frametemp') }}"
                    class="text-gray-700 hover:text-[#BF3131] px-2 sm:px-3 py-2 rounded-md text-xs sm:text-sm font-medium relative group nav-link"
                    data-route="frametemp">
                    Frame
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-[#BF3131] transform scale-x-0 origin-left transition-transform duration-300 ease-in-out group-hover:scale-x-100 active:scale-x-100"></span>
                </a>
                <a href="{{ route('about') }}"
                    class="text-gray-700 hover:text-[#BF3131] px-2 sm:px-3 py-2 rounded-md text-xs sm:text-sm font-medium relative group nav-link"
                    data-route="about">
                    About
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-[#BF3131] transform scale-x-0 origin-left transition-transform duration-300 ease-in-out group-hover:scale-x-100 active:scale-x-100"></span>
                </a>
            </div>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navLinks = document.querySelectorAll('.nav-link');
        const currentPath = window.location.pathname;
        navLinks.forEach(link => {
            const routeName = link.dataset.route;
            let routePath = '';
            const routeMap = {
                'home': '/',
                'frametemp': '/frame',
                'about': '/about'
            };
            routePath = routeMap[routeName] || '/';
            if (currentPath === routePath || (routeName === 'home' && currentPath === '/')) {
                link.classList.add('active');
                link.querySelector('span').classList.add('active');
            }
        });
    });
</script>

<style>
    .nav-link.active {
        color: #BF3131 !important;
        font-weight: 600;
    }
</style>