@extends('layouts.app')

{{-- frame.blade --}}
@section('hero_section')
    <div class="py-32 bg-[#FEF3E2]">
        <div class="container mx-auto px-4 md:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Tentang <span
                        class="text-[#BF3131]">Panociram</span></h2>
                <div class="w-24 h-1 bg-[#BF3131] mx-auto mb-6"></div>
                <p class="text-gray-600 max-w-2xl mx-auto">Kami menciptakan momen-momen spesial dengan teknologi photobooth
                    modern</p>
            </div>

            <div class="flex flex-col md:flex-row items-center gap-8 mb-16">
                <div class="w-full md:w-1/2 order-2 md:order-1">
                    <h3 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Selamat Datang di Panoricam</h3>
                    <p class="text-gray-600 mb-6">
                        Panoricam, photobooth kekinian yang siap bikin tiap momen jadi makin pecah! Mau selfie ramean, pose
                        lucu, atau gaya aesthetic? Semua bisa banget di sini.
                    </p>
                    <p class="text-gray-600 mb-6">
                        Cukup berdiri, pose, cekrek—langsung jadi kenangan digital. Karena tiap momen layak diabadikan!
                    </p>
                    <div class="mt-6">
                        <a href="#contact"
                            class="inline-block bg-[#BF3131] hover:bg-[#F16767] text-white font-semibold py-3 px-6 rounded-lg transition duration-300 transform hover:scale-105">
                            Hubungi Kami
                        </a>
                    </div>
                </div>
                <div class="w-full md:w-1/2 order-1 md:order-2 mb-8 md:mb-0">
                    <div class="relative">
                        <div class="absolute -top-4 -left-4 w-24 h-24 bg-[#BF3131] rounded-full opacity-20"></div>
                        <div class="absolute -bottom-4 -right-4 w-32 h-32 bg-[#F16767] rounded-full opacity-20"></div>
                        <img src="{{ asset('logo.png') }} " alt="PhotoMagic Booth"
                            class="rounded-lg shadow-xl w-full h-auto object-cover relative z-10 border-4 border-[#BF3131]"
                            onerror="this.src='/api/placeholder/600/400';this.onerror='';">
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection
