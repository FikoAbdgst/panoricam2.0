@extends('layouts.app')

@section('hero section')
    <div class="py-12 bg-white h-screen relative overflow-hidden">
        <div id="random-boxes" class="absolute inset-0 w-full h-full pointer-events-none"></div>

        <div
            class="photo-icons-left absolute left-0 inset-y-0 w-16 md:hidden lg:block lg:w-48 xl:w-64 overflow-hidden pointer-events-none z-10 hidden ">
            <div class="absolute z-50 top-20 left-8 transform rotate-12 text-2xl lg:text-3xl xl:text-4xl">📷</div>
            <div class="absolute z-50 top-48 left-24 transform -rotate-6 text-2xl lg:text-3xl xl:text-4xl">🖼️</div>
            <div class="absolute z-50 top-28 left-48 transform -rotate-6 text-2xl lg:text-3xl xl:text-4xl">🎉</div>
            <div class="absolute z-50 bottom-72 left-12 transform rotate-2 text-2xl lg:text-3xl xl:text-4xl">👑</div>
            <div class="absolute z-50 bottom-32 left-38 transform rotate-10 text-2xl lg:text-3xl xl:text-4xl">🥸</div>
            <div class="absolute z-50 bottom-80 left-54 transform rotate-10 text-2xl lg:text-3xl xl:text-4xl">🎭</div>


            <div
                class="absolute z-50 bottom-48 left-8 transform -rotate-4 text-2xl lg:text-3xl xl:text-4xl hidden lg:block">
                🎬</div>
            <div
                class="absolute z-50 bottom-96 left-36 transform rotate-15 text-2xl lg:text-3xl xl:text-4xl hidden lg:block">
                🎪</div>
            <div class="absolute z-50 top-10 left-36 transform -rotate-10 text-2xl lg:text-3xl xl:text-4xl hidden lg:block">
                ✨</div>
            <div
                class="absolute top-36 left-6 w-20 h-24 lg:w-16 lg:h-20 xl:w-24 xl:h-28 bg-white rounded shadow-md transform -rotate-6">
                <div class="w-full h-4/5 bg-blue-200"></div>
                <div class="w-full h-1/5 bg-white flex items-center justify-center">
                    <span class="text-xs text-gray-500">Photobooth</span>
                </div>
            </div>



            <div
                class="absolute bottom-20 left-10 w-20 h-24 lg:w-16 lg:h-20 xl:w-28 xl:h-32 bg-white rounded shadow-md transform -rotate-4">
                <div class="w-full h-4/5 bg-violet-300"></div>
                <div class="w-full h-1/5 bg-white flex items-center justify-center">
                    <span class="text-xs text-gray-500">Cool</span>
                </div>
            </div>

            <div
                class="absolute top-80 left-24 w-16 h-20 xl:w-24 xl:h-28 bg-white rounded shadow-md transform rotate-8 hidden lg:block">
                <div class="w-full h-4/5 bg-pink-200"></div>
                <div class="w-full h-1/5 bg-white flex items-center justify-center">
                    <span class="text-xs text-gray-500">Memories</span>
                </div>
            </div>
        </div>

        <div
            class="photo-props-right absolute right-0 inset-y-0 w-16 md:hidden lg:block lg:w-48 xl:w-64 overflow-hidden pointer-events-none z-10 hidden ">
            <!-- Props statis -->
            <div class="absolute z-50 top-24 left-0 text-4xl lg:text-3xl xl:text-5xl transform -rotate-12">✨</div>
            <div class="absolute z-50 top-52 right-8 text-4xl lg:text-3xl xl:text-5xl transform rotate-6">👓</div>
            <div class="absolute z-50 bottom-40 right-40 text-4xl lg:text-3xl xl:text-5xl transform -rotate-15">🎩</div>
            <div class="absolute z-50 bottom-28 right-10 text-4xl lg:text-3xl xl:text-5xl transform -rotate-15">🐱</div>
            <div class="absolute z-50 bottom-72 left-5 text-4xl lg:text-3xl xl:text-5xl transform rotate-20">🥸</div>
            <div class="absolute z-50 top-32 right-28 text-4xl lg:text-3xl xl:text-5xl transform -rotate-8">👑</div>
            <div class="absolute z-50 top-80 right-20 text-4xl lg:text-3xl xl:text-5xl transform rotate-12">🎪</div>

            <div class="absolute z-50 bottom-64 right-10 text-3xl xl:text-4xl transform -rotate-6 hidden lg:block">🤖</div>

            <div
                class="absolute top-40 right-12 w-20 h-24 lg:w-16 lg:h-20 xl:w-24 xl:h-28 bg-white rounded shadow-md transform rotate-8">
                <div class="w-full h-4/5 bg-green-200"></div>
                <div class="w-full h-1/5 bg-white flex items-center justify-center">
                    <span class="text-xs text-gray-500">Fun shots</span>
                </div>
            </div>

            <div
                class="absolute bottom-40 right-12 w-20 h-24 lg:w-16 lg:h-20 xl:w-24 xl:h-28 bg-white rounded shadow-md transform -rotate-10">
                <div class="w-full h-4/5 bg-yellow-200"></div>
                <div class="w-full h-1/5 bg-white flex items-center justify-center">
                    <span class="text-xs text-gray-500">Chants!!</span>
                </div>
            </div>

            <div
                class="absolute top-72 right-24 w-16 h-20 xl:w-24 xl:h-28 bg-white rounded shadow-md transform -rotate-6 hidden lg:block">
                <div class="w-full h-4/5 bg-teal-200"></div>
                <div class="w-full h-1/5 bg-white flex items-center justify-center">
                    <span class="text-xs text-gray-500">Smile</span>
                </div>
            </div>
        </div>

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
                        class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 cursor-pointer">
                        Mulai Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>


    <style>
        @keyframes fadeInOut {
            0% {
                opacity: 0;
            }

            20% {
                opacity: 0.2;
            }

            80% {
                opacity: 0.2;
            }

            100% {
                opacity: 0;
            }
        }

        @media (min-width: 1024px) {

            .photo-icons-left div,
            .photo-props-right div {
                font-size: 1.75rem;
            }
        }

        @media (min-width: 1280px) {

            .photo-icons-left div,
            .photo-props-right div {
                font-size: 2rem;
            }
        }

        .photo-frame {
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 5px;
            border-radius: 2px;
        }
    </style>
@endsection


@section('content section')
    <div class="py-16 bg-gradient-to-b from-blue-50 via-indigo-50 to-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 inline-block relative">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600">Pilih Frame
                        Terbaikmu</span>
                    <div
                        class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-1/2 h-1 bg-gradient-to-r from-blue-400 to-indigo-500 rounded-full">
                    </div>
                </h2>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Temukan koleksi frame eksklusif untuk menciptakan kenangan
                    yang tak terlupakan</p>
            </div>

            <div
                class="mb-16 backdrop-blur-sm bg-white bg-opacity-80 rounded-2xl shadow-lg p-8 transform hover:shadow-xl transition-all duration-300">
                <div class="flex flex-wrap gap-6 justify-center">
                    <a href="{{ route('home') }}" class="group text-center">
                        <div
                            class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-white flex items-center justify-center
                              shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group-hover:bg-blue-50
                              {{ !isset($selectedCategory) ? 'ring-4 ring-blue-300' : '' }}">
                            <span
                                class="text-3xl md:text-4xl transform group-hover:scale-110 transition-transform duration-300">🏠</span>
                        </div>
                        <p class="mt-2 text-sm font-medium text-gray-700 group-hover:text-blue-600">Semua</p>
                    </a>

                    @foreach ($categories as $category)
                        <a href="{{ route('home', ['category' => $category->id]) }}" class="group text-center">
                            <div
                                class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-white flex items-center justify-center
                                  shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden group-hover:bg-blue-50
                                  {{ isset($selectedCategory) && $selectedCategory->id == $category->id ? 'ring-4 ring-blue-300' : '' }}">
                                <span
                                    class="text-3xl md:text-4xl transform group-hover:scale-110 transition-transform duration-300">{{ $category->icon }}</span>
                            </div>
                            <p class="mt-2 text-sm font-medium text-gray-700 group-hover:text-blue-600">
                                {{ $category->name }}</p>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="mt-12">
                @if ($frames->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                        @foreach ($frames as $frame)
                            <div
                                class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-500 transform hover:-translate-y-2 frame-card">
                                <div
                                    class="relative p-3 h-52 md:h-60 bg-gradient-to-br from-gray-50 to-blue-50 flex items-center justify-center group">
                                    @if ($frame->image_path)
                                        <img src="{{ asset('storage/' . $frame->image_path) }}" alt="{{ $frame->name }}"
                                            class="max-h-full max-w-full object-contain transition-transform duration-500 group-hover:scale-105">
                                    @else
                                        <div class="text-gray-400 text-5xl">🖼️</div>
                                    @endif

                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/70 to-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        <button
                                            class="px-4 py-2 bg-white/90 text-gray-800 rounded-full font-medium hover:bg-blue-50 transition-colors duration-300 transform hover:scale-105">
                                            Preview
                                        </button>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <h3 class="text-lg font-medium text-gray-900">{{ $frame->name }}</h3>
                                    <div class="flex items-center mt-2">
                                        <span class="text-lg mr-2">{{ $frame->category->icon }}</span>
                                        <span class="text-sm text-gray-600">{{ $frame->category->name }}</span>
                                    </div>
                                    <!-- Replace button with direct link to booth -->
                                    <a href="{{ route('booth', ['frame_id' => $frame->id]) }}"
                                        class="mt-4 inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-full text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 w-full transition-all duration-300 shadow-sm hover:shadow-md">
                                        Gunakan Frame
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-20 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl shadow-inner">
                        <div class="inline-block text-7xl mb-6 animate-pulse">🖼️</div>
                        <p class="text-xl text-gray-600 font-light">Belum ada frame yang tersedia untuk kategori ini.</p>
                        <p class="mt-3 text-gray-500">Silakan pilih kategori lain atau kembali lagi nanti.</p>
                    </div>
                @endif
            </div>


            <div class="mt-20 rounded-2xl overflow-hidden shadow-xl">
                <div class="md:flex">
                    <div
                        class="md:w-1/2 bg-gradient-to-br from-blue-600 to-indigo-800 text-white p-8 md:p-12 flex flex-col justify-center">
                        <h2 class="text-3xl font-bold mb-6">Photobooth Experience</h2>
                        <p class="mb-6 text-blue-100 leading-relaxed">
                            Aplikasi ini memungkinkan Anda untuk mengambil foto dengan berbagai pilihan frame menarik.
                            Abadikan momen spesial Anda dengan tampilan yang lebih keren dan berbagi ke media sosial secara
                            instan!
                        </p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-300" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Frame berkualitas tinggi</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-300" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Berbagi ke media sosial</span>
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-300" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span>Pengalaman yang menyenangkan</span>
                            </li>
                        </ul>
                        <div>
                            <a href="{{ route('about') }}"
                                class="inline-flex items-center px-5 py-2 bg-white text-blue-700 rounded-full font-medium hover:bg-blue-50 transition-colors duration-300 shadow-md hover:shadow-lg">
                                <span>Pelajari lebih lanjut</span>
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div
                        class="md:w-1/2 bg-gradient-to-br from-indigo-50 to-blue-100 p-8 md:p-12 flex items-center justify-center">
                        <div class="relative">
                            <div
                                class="w-64 h-64 md:w-72 md:h-72 bg-white p-2 rounded-xl shadow-lg transform rotate-3 z-20 relative">
                                <div
                                    class="w-full h-full bg-blue-100 rounded-lg flex items-center justify-center overflow-hidden">
                                    <div class="text-8xl">📸</div>
                                </div>
                                <div
                                    class="absolute bottom-4 left-4 right-4 text-center text-sm font-medium text-gray-700 bg-white/80 backdrop-blur-sm py-1 rounded">
                                    Photobooth App</div>
                            </div>

                            <div
                                class="absolute -bottom-6 -left-6 w-32 h-32 bg-white p-2 rounded-lg shadow-md transform -rotate-6 z-10">
                                <div class="w-full h-full bg-pink-100 rounded flex items-center justify-center">
                                    <div class="text-4xl">✨</div>
                                </div>
                            </div>
                            <div
                                class="absolute -top-4 -right-4 w-24 h-24 bg-white p-2 rounded-lg shadow-md transform rotate-12 z-10">
                                <div class="w-full h-full bg-yellow-100 rounded flex items-center justify-center">
                                    <div class="text-3xl">🎉</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


@endsection
