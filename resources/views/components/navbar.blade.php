<nav id="navbar" class="bg-white w-full h-24 z-50 transition-all duration-300 px-4 sm:px-6 lg:px-8 absolute">
    <div class="max-w-7xl mx-auto h-full ">
        <div class="flex justify-between h-full">
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-blue-600">Photobooth</a>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}"
                    class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">Home</a>
                <a href="{{ route('about') }}"
                    class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium">About</a>
            </div>
        </div>
    </div>
</nav>
