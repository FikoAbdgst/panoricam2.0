<div class="py-12 bg-[#FEF3E2] font-['Poppins'] h-screen relative">
    <!-- Left side floating photo frames -->
    <div class="absolute left-0 top-1/2 transform -translate-y-1/2 z-30 hidden md:block">
        <div class="relative">
            <!-- Frame 1 - Multi-photo frame -->
            <div class="absolute -left-10 -top-20 transform -rotate-6 shadow-lg">
                <div class="w-64 bg-white border-4 border-[#BF3131]  rounded-lg relative pt-10 pb-5 ">
                    <div class="border-2 border-[#BF3131] ">
                        <div class="absolute top-2 right-2">
                            <svg class="w-5 h-5 text-[#BF3131]" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="grid grid-cols-1">
                        <!-- Photo slot 1 -->
                        <div class="relative">
                            <div class="h-36  overflow-hidden flex justify-center">
                                <img src="{{ asset('images/m1.jpeg') }}" alt="Memory placeholder 1"
                                    class="object-cover w-full h-full" />

                            </div>
                        </div>
                        <!-- Photo slot 2 -->
                        <div class="relative">
                            <div class="h-36  overflow-hidden flex justify-center">
                                <img src="{{ asset('images/m2.jpeg') }}" alt="Memory placeholder 2"
                                    class="object-cover w-full h-full" />
                            </div>
                        </div>
                        <!-- Photo slot 3 -->
                        <div class="relative">
                            <div class="h-36  overflow-hidden flex justify-center">
                                <img src="{{ asset('images/m3.jpeg') }}" alt="Memory placeholder 3"
                                    class="object-cover w-full h-full" />

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Right side floating photo frames -->
    <div class="absolute right-0 top-1/2 transform -translate-y-1/2 z-30 hidden md:block">
        <div class="relative">
            <!-- Frame 1 - Multi-photo frame with 3 slots -->
            <div class="absolute -right-20 -top-20 transform rotate-6 shadow-lg">
                <div class="w-64 bg-white border-4 border-[#BF3131]  rounded-lg relative pt-10 pb-5 ">
                    <div class="border-2 border-[#BF3131] ">
                        <div class="absolute top-2 left-2">
                            <svg class="w-5 h-5 text-[#BF3131]" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                    </div>
                    <div class="grid grid-cols-1">
                        <!-- Photo slot 1 -->
                        <div class="relative">
                            <div class="h-36  overflow-hidden flex justify-center">
                                <img src="{{ asset('images/m1.jpeg') }}" alt="Memory placeholder 1"
                                    class="object-cover w-full h-full" />

                            </div>
                        </div>
                        <!-- Photo slot 2 -->
                        <div class="relative">
                            <div class="h-36  overflow-hidden flex justify-center">
                                <img src="{{ asset('images/m2.jpeg') }}" alt="Memory placeholder 2"
                                    class="object-cover w-full h-full" />
                            </div>
                        </div>
                        <!-- Photo slot 3 -->
                        <div class="relative">
                            <div class="h-36  overflow-hidden flex justify-center">
                                <img src="{{ asset('images/m3.jpeg') }}" alt="Memory placeholder 3"
                                    class="object-cover w-full h-full" />

                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>

    <!-- Decorative elements -->
    <div class="absolute inset-0 z-20">
        <div class="absolute top-1/4 left-1/4 w-12 h-12 text-red-500 opacity-20">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
            </svg>
        </div>
        <div class="absolute bottom-1/4 right-1/4 w-16 h-16 text-red-500 opacity-20">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
        </div>

        <!-- Dashed lines similar to the reference image -->
        <div class="absolute w-24 h-24 top-1/3 left-1/3 border-2 border-dashed border-red-400 rounded-full opacity-30">
        </div>
        <div
            class="absolute w-36 h-36 bottom-1/3 right-1/3 border-2 border-dashed border-red-400 rounded-full opacity-30">
        </div>
    </div>

    <!-- Main content -->
    <div class="max-w-7xl h-full mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-center relative z-20">
        <div class="text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">
                Photobooth App
            </h1>
            <p class="mt-5 max-w-xl mx-auto text-xl text-gray-500">
                Abadikan momen spesial Anda dengan frame keren dan berbagi dengan teman-teman!
            </p>
            <div class="mt-8">
                <button id="scrollToContentBtn"
                    class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-[#BF3131] hover:bg-[#F16767] transition duration-300 shadow-sm hover:shadow-lg cursor-pointer hover:scale-105">
                    Mulai Sekarang
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('scrollToContentBtn').addEventListener('click', function() {
        const contentSection = document.querySelector('.content_section');
        contentSection.scrollIntoView({
            behavior: 'smooth'
        });
    });
</script>
