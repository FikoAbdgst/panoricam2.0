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

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Kelebihan 1 -->
                <div
                    class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1 border border-[#F16767]">
                    <div
                        class="bg-red-100 text-[#BF3131] rounded-full w-16 h-16 flex items-center justify-center mb-4 mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 text-center mb-3">Teknologi Canggih</h3>
                    <p class="text-gray-600 text-center">
                        Kamera DSLR profesional dengan pencahayaan studio menghasilkan foto berkualitas tinggi yang siap
                        dicetak dalam hitungan detik.
                    </p>
                </div>

                <!-- Kelebihan 2 -->
                <div
                    class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1 border border-[#F16767]">
                    <div
                        class="bg-red-100 text-[#BF3131] rounded-full w-16 h-16 flex items-center justify-center mb-4 mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 text-center mb-3">Berbagi Instan</h3>
                    <p class="text-gray-600 text-center">
                        Langsung bagikan foto ke media sosial atau kirim via email/SMS. Unduh foto digital atau cetak
                        langsung di tempat.
                    </p>
                </div>

                <!-- Kelebihan 3 -->
                <div
                    class="bg-white p-6 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1 border border-[#F16767]">
                    <div
                        class="bg-red-100 text-[#BF3131] rounded-full w-16 h-16 flex items-center justify-center mb-4 mx-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 text-center mb-3">Kustomisasi Lengkap</h3>
                    <p class="text-gray-600 text-center">
                        Berbagai tema, filter, dan props menarik yang dapat disesuaikan dengan acara Anda. Desain template
                        foto yang dapat dipersonalisasi.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
