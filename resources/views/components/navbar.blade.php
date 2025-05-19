<nav id="navbar"
    class="bg-[#FEF3E2] font-['Poppins'] w-full h-24 z-50 transition-all duration-300 px-4 sm:px-6 lg:px-8 absolute">
    <div class="max-w-7xl mx-auto h-full ">
        <div class="flex justify-between h-full">
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-[#BF3131]"> <img
                            src="{{ asset('logo.png') }}" alt="Logo" class="h-[70px] w-auto mx-auto"></a>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('home') }}"
                    class="text-gray-700 hover:text-[#BF3131] px-3 py-2 rounded-md text-sm font-medium relative group">
                    Home
                    <span
                        class="absolute bottom-0 left-0 w-full h-0.5 bg-[#BF3131] transform scale-x-0 origin-left transition-transform duration-300 ease-in-out group-hover:scale-x-100"></span>
                </a>
                <a href="{{ route('frametemp') }}"
                    class="text-gray-700 hover:text-[#BF3131] px-3 py-2 rounded-md text-sm font-medium relative group">
                    Frame
                    <span
                        class="absolute bottom-0 left-0 w-full h-0.5 bg-[#BF3131] transform scale-x-0 origin-left transition-transform duration-300 ease-in-out group-hover:scale-x-100"></span>
                </a>
                <a href="{{ route('about') }}"
                    class="text-gray-700 hover:text-[#BF3131] px-3 py-2 rounded-md text-sm font-medium relative group">
                    About
                    <span
                        class="absolute bottom-0 left-0 w-full h-0.5 bg-[#BF3131] transform scale-x-0 origin-left transition-transform duration-300 ease-in-out group-hover:scale-x-100"></span>
                </a>
            </div>
        </div>
    </div>
</nav>
