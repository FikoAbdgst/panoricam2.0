@extends('layouts.app')

@section('hero_section')
    <div class="py-12 bg-white h-screen relative overflow-hidden">
        <div id="random-boxes" class="absolute inset-0 w-full h-full pointer-events-none"></div>

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

    <script>
        document.getElementById('scrollToContentBtn').addEventListener('click', function() {
            const contentSection = document.querySelector('.content_section');
            contentSection.scrollIntoView({
                behavior: 'smooth'
            });
        });
    </script>
@endsection


{{-- home.blade.php --}}
@section('content_section')
    <style>
        /* Preview Modal Styles */
        #previewCountdownOverlay {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            transition: opacity 0.3s ease, background-color 0.2s ease;
            font-size: 3rem;
            /* Ukuran teks lebih kecil agar lebih rapi */
            color: white;
            display: none;
            /* Sembunyikan secara default */
        }

        #previewCountdownOverlay.show {
            display: flex;
            /* Tampilkan saat aktif */
        }

        /* Efek flash */
        #previewCountdownOverlay.flash {
            background-color: rgba(255, 255, 255, 0.9);
            transition: background-color 0.2s ease;
        }

        #previewCameraModal {
            font-family: 'Poppins', sans-serif;
        }

        #previewVideo {
            background-color: #000;
        }

        #previewFrameContainer {
            height: 100%;
            width: 100%;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #previewFrameImage {
            position: relative;
            height: 100%;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Watermark styles for paid frames */
        .watermark {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 10;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: rgba(255, 255, 255, 0.7);
            font-weight: bold;
            user-select: none;
        }

        .watermark-text {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .watermark-pattern {
            position: absolute;
            width: 100%;
            height: 100%;
            background-image: repeating-linear-gradient(45deg,
                    rgba(255, 255, 255, 0.1),
                    rgba(255, 255, 255, 0.1) 10px,
                    transparent 10px,
                    transparent 20px);
            opacity: 0.3;
        }

        /* Button styles */
        #previewCaptureButton:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        /* Animation for countdown */
        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        #previewCountdownOverlay {
            animation: pulse 1s infinite;
        }

        #previewFrameImage img,
        #previewFrameImage svg,
        #previewFrameImage>div {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
        }

        /* Photo slot styles specific to preview mode */
        #previewFrameContainer .photo-slot {
            position: absolute;
            background-color: rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        #previewFrameContainer .photo-slot img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Custom styles for photo slots that need to be maintained */
        .photo-slot-container {
            position: absolute;
            overflow: hidden;
        }

        .photo-slot {
            width: 100%;
            height: 100%;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .photo-slot img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        .photo-slot img[src]:not([src=""]) {
            display: block;
        }

        /* Watermark Styles */
        #previewWatermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            pointer-events: none;
            z-index: 10;
            opacity: 0.4;
            /* TransmediaDevices: Transparansi watermark */
            transition: opacity 1.5s ease;
            display: none;
            /* Sembunyikan secara default */
        }

        #previewWatermark.show {
            display: flex;
            /* Tampilkan saat frame berbayar */
        }

        #previewWatermark .watermark-content {
            background-color: rgba(0, 0, 0, 0.3);
            padding: 10px 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        #previewWatermark .watermark-content span {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
        }

        /* Adding keyframes animation for modal */
        @keyframes modalFadeIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    <div class="py-16 bg-gradient-to-b from-blue-50 via-indigo-50 to-white content_section">
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
                    <a href="{{ route('home') }}" class="category-link group text-center">
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
                        <a href="{{ route('home', ['category' => $category->id]) }}"
                            class="group text-center category-link">
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
                                    <a href="{{ $frame->status === 'paid' ? route('maintenance') : route('booth', ['frame_id' => $frame->id]) }}"
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

    <!-- Modal Preview Section -->
    <div id="previewCameraModal" class="hidden fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/30 backdrop-blur-sm"></div>

        <div class="relative bg-white rounded-xl shadow-xl p-6 w-full max-w-4xl mx-4 animate-[modalFadeIn_0.3s]">
            <button class="modal-close absolute top-4 right-4 text-2xl text-gray-500 hover:text-black">&times;</button>

            <h2 class="text-xl font-semibold mb-4 text-center">Frame Preview</h2>

            <div class="flex flex-col md:flex-row gap-6 justify-center items-center">
                <!-- Camera Preview (4:3) -->
                <div class="w-full md:w-3/5">
                    <div class="relative bg-gray-100 rounded-lg overflow-hidden" style="aspect-ratio: 4/3;">
                        <video id="previewVideo" autoplay muted class="w-full h-full object-cover scale-x-[-1]"></video>
                        <div id="previewWatermark" class="hidden">
                            <div class="watermark-content">
                                <img src="{{ asset('logo4.png') }}" alt="Logo" class="h-10">
                            </div>
                        </div>
                        <div id="previewCountdownOverlay"
                            class="absolute inset-0 flex items-center justify-center text-6xl font-bold text-white/90">
                        </div>
                    </div>

                    <button id="previewCaptureButton"
                        class="mt-4 w-full py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg text-sm font-medium transition-colors">
                        📷 Start Session
                    </button>
                </div>

                <div class="w-[190px] h-[450px] relative">
                    <div id="previewFrameContainer"
                        class="w-full h-full relative bg-transparent shadow-md overflow-hidden">
                        <div id="previewFrameImage" class="absolute inset-0 flex items-center justify-center bg-gray-100">
                            <p class="text-gray-400 text-center p-4">Frame akan muncul di sini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Scrolling functionality
            document.getElementById('scrollToContentBtn')?.addEventListener('click', function() {
                document.querySelector('.content_section').scrollIntoView({
                    behavior: 'smooth'
                });
            });


            // Category link handling
            document.querySelectorAll('.category-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.href;
                    const scrollPosition = window.scrollY;

                    fetch(url)
                        .then(response => response.text())
                        .then(html => {
                            const parser = new DOMParser();
                            const doc = parser.parseFromString(html, 'text/html');
                            const newContent = doc.querySelector('.content_section');

                            if (newContent) {
                                // Update content
                                document.querySelector('.content_section').outerHTML =
                                    newContent.outerHTML;
                                // Update URL without reload
                                window.history.pushState({}, '', url);
                                // Restore scroll position
                                window.scrollTo(0, scrollPosition);
                                // Re-attach event listeners
                                attachCategoryListeners();
                                setupFrameCards();
                            }
                        });
                });
            });

            // Browser back/forward navigation
            window.addEventListener('popstate', function() {
                location.reload();
            });

            function attachCategoryListeners() {
                document.querySelectorAll('.category-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const url = this.href;
                        const scrollPosition = window.scrollY;

                        fetch(url)
                            .then(response => response.text())
                            .then(html => {
                                const parser = new DOMParser();
                                const doc = parser.parseFromString(html, 'text/html');
                                const newContent = doc.querySelector('.content_section');

                                if (newContent) {
                                    document.querySelector('.content_section').outerHTML =
                                        newContent.outerHTML;
                                    window.history.pushState({}, '', url);
                                    window.scrollTo(0, scrollPosition);
                                    attachCategoryListeners();
                                    setupFrameCards();
                                }
                            });
                    });
                });
            }

            // Setup frame cards and preview functionality
            setupFrameCards();

            // Create html2canvas script if needed
            if (!window.html2canvas) {
                const script = document.createElement('script');
                script.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js';
                script.async = true;
                document.head.appendChild(script);
            }
        });

        function setupFrameCards() {
            // Add preview button to each frame card
            const frameCards = document.querySelectorAll('.frame-card');

            frameCards.forEach(card => {
                const overlay = card.querySelector('.group-hover\\:opacity-100');

                // Create preview button
                const previewBtn = document.createElement('button');
                previewBtn.className =
                    'px-4 py-2 bg-white/90 text-gray-800 rounded-full font-medium hover:bg-blue-50 transition-colors duration-300 transform hover:scale-105';
                previewBtn.textContent = 'Preview';
                previewBtn.addEventListener('click', openPreviewCameraModal);

                // Replace existing button or add if none exists
                const existingBtn = overlay.querySelector('button');
                if (existingBtn) {
                    overlay.replaceChild(previewBtn, existingBtn);
                } else {
                    overlay.appendChild(previewBtn);
                }
            });
        }

        function openPreviewCameraModal(e) {
            e.preventDefault();
            e.stopPropagation();

            const modal = document.getElementById('previewCameraModal');
            const video = document.getElementById('previewVideo');
            const previewFrameContainer = document.getElementById('previewFrameContainer');
            const previewFrameImage = document.getElementById('previewFrameImage');
            const captureButton = document.getElementById('previewCaptureButton');
            const watermark = document.getElementById('previewWatermark');

            // Reset modal state
            resetModalState();

            // Hide watermark initially
            if (watermark) {
                watermark.classList.add('hidden');
                watermark.classList.remove('show');
            }
            // Show the modal
            modal.style.display = 'flex';

            // Get frame ID from the card
            const frameCard = e.target.closest('.frame-card');
            const frameIdElement = frameCard.querySelector('a[href*="frame_id="]');
            let frameId = null;

            if (frameIdElement) {
                const href = frameIdElement.getAttribute('href');
                const match = href.match(/frame_id=(\d+)/);
                if (match && match[1]) {
                    frameId = match[1];
                    modal.setAttribute('data-frame-id', frameId);
                    window.currentFrameId = frameId;
                }
            }

            // Load the frame template
            if (frameId) {
                // Show loading state
                previewFrameImage.innerHTML =
                    '<div class="flex items-center justify-center w-full h-full"><div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-blue-500"></div></div>';

                // Add this line to fetch frame status
                fetchFrameDetails(frameId);

                // Fetch the frame template
                fetch(`/get-frame-template/${frameId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.text();
                    })
                    .then(html => {
                        // Insert the frame HTML
                        previewFrameImage.innerHTML = html;
                        // Initialize photo slots
                        initializePhotoSlots(previewFrameImage);
                    })
                    .catch(error => {
                        console.error('Error loading frame template:', error);
                        previewFrameImage.innerHTML = `
                            <div class="flex flex-col items-center justify-center w-full h-full text-red-500">
                                <svg class="w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <p class="text-center">Failed to load frame template.</p>
                            </div>
                        `;

                        // Create 3 dummy slots instead
                        for (let i = 0; i < 3; i++) {
                            const dummySlot = document.createElement('div');
                            dummySlot.className = 'photo-slot';
                            dummySlot.style.width = '100px';
                            dummySlot.style.height = '100px';
                            dummySlot.style.position = 'absolute';
                            dummySlot.style.top = `${25 + (i * 30)}%`;
                            dummySlot.style.left = '50%';
                            dummySlot.style.transform = 'translate(-50%, -50%)';
                            dummySlot.style.backgroundColor = 'rgba(0,0,0,0.2)';
                            previewFrameImage.appendChild(dummySlot);

                            // Add img element
                            const img = document.createElement('img');
                            dummySlot.appendChild(img);
                            window.photoSlots.push(img);
                        }
                    });
            } else {
                // Handle case with no frame ID
                const frameImageElement = frameCard.querySelector('img');
                let frameImageSrc = '';

                if (frameImageElement && frameImageElement.src) {
                    frameImageSrc = frameImageElement.src;
                }

                previewFrameImage.innerHTML = `
                    <div class="w-full h-full flex items-center justify-center">
                        ${frameImageSrc ? `<img src="${frameImageSrc}" alt="Frame" class="max-w-full max-h-full object-contain">` : '<div class="text-gray-400 text-5xl">🖼️</div>'}
                    </div>
                `;

                // Initialize photo slots
                initializePhotoSlots(previewFrameImage);
            }

            // Initialize camera
            if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia({
                        video: {
                            width: {
                                ideal: 640
                            },
                            height: {
                                ideal: 480
                            },
                            aspectRatio: 4 / 3
                        }
                    })
                    .then(stream => {
                        video.srcObject = stream;
                        window.stream = stream;
                        video.onloadedmetadata = function(e) {
                            video.play();
                        };
                    })
                    .catch(err => {
                        console.error("Error accessing webcam: " + err);
                        handleCameraError(video, captureButton);
                    });
            } else {
                console.error("getUserMedia not supported");
                alert("Your browser doesn't support camera access. Please try a different browser.");
            }

            // Setup modal close handlers
            const modalClose = modal.querySelector('.modal-close');
            modalClose.addEventListener('click', closePreviewCameraModal);
            window.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closePreviewCameraModal();
                }
            });

            // Setup capture button
            captureButton.addEventListener('click', startPhotoSession);
        }

        function initializePhotoSlots(frameElement) {
            console.log("Initializing photo slots");

            // Clear previous photo slots data
            window.photoSlots = [];

            // Remove any existing photo slots for a clean start
            const existingSlots = frameElement.querySelectorAll('.photo-slot');
            existingSlots.forEach(slot => slot.remove());

            // Create 3 photo slots with the same dimensions and positions as in index.blade.php
            const slotPositions = [{
                    top: '20%',
                    left: '50%'
                }, // First slot position
                {
                    top: '47%',
                    left: '50%'
                }, // Second slot position
                {
                    top: '74%',
                    left: '50%'
                } // Third slot position
            ];

            // Create 3 photo slots
            for (let i = 0; i < 3; i++) {
                const photoSlot = document.createElement('div');
                photoSlot.className = 'photo-slot';
                photoSlot.style.width = '150px'; // Same width as in booth
                photoSlot.style.height = '100px'; // Same height as in booth
                photoSlot.style.position = 'absolute';
                photoSlot.style.top = slotPositions[i].top;
                photoSlot.style.left = slotPositions[i].left;
                photoSlot.style.transform = 'translate(-50%, -50%)';
                photoSlot.style.backgroundColor = '#e6e6e6';
                photoSlot.style.borderRadius = '4px';

                // Create the image element for this slot
                const img = document.createElement('img');
                img.style.width = '100%';
                img.style.height = '100%';
                img.style.objectFit = 'cover';
                img.style.display = 'none';
                photoSlot.appendChild(img);

                // Add the slot to the frame
                frameElement.appendChild(photoSlot);

                // Add to photoSlots array
                window.photoSlots.push(img);
            }
        }

        function processPhotoSlot(slot) {
            // Find the img element or create one if it doesn't exist
            let img = slot.querySelector('img');
            if (!img) {
                img = document.createElement('img');
                slot.appendChild(img);
            }

            // Reset the image
            img.src = "";
            img.style.display = "none";

            // Add to photoSlots array
            window.photoSlots.push(img);
        }



        function handleNoFrameId(frameCard, previewFrameImage) {
            // Extract frame image from the card
            const frameImageElement = frameCard.querySelector('img');
            let frameImageSrc = '';

            if (frameImageElement && frameImageElement.src) {
                frameImageSrc = frameImageElement.src;
            }

            // Create a basic frame display with the image
            previewFrameImage.innerHTML = `
        <div class="w-full h-full flex items-center justify-center">
            ${frameImageSrc ? `<img src="${frameImageSrc}" alt="Frame" class="max-w-full max-h-full object-contain">` : '<div class="text-gray-400 text-5xl">🖼️</div>'}
        </div>
    `;

            // Initialize photo slots using our improved function
            initializePhotoSlots(previewFrameImage);
        }

        function handleCameraError(video, captureButton) {
            const videoContainer = video.parentElement;
            videoContainer.innerHTML = `
        <div class="flex flex-col items-center justify-center w-full h-full bg-black text-white p-4">
            <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <p class="text-lg mb-2">Camera Access Denied</p>
            <p class="text-sm text-center">Please allow camera access in your browser settings to use this feature.</p>
        </div>
        `;

            // Disable capture button
            captureButton.disabled = true;
        }

        function resetModalState() {
            const countdownOverlay = document.getElementById('previewCountdownOverlay');
            const captureButton = document.getElementById('previewCaptureButton');
            const watermark = document.getElementById('previewWatermark');

            // Reset photo slots
            if (window.photoSlots) {
                window.photoSlots.forEach(slot => {
                    slot.src = '';
                    slot.style.display = 'none';
                });
            }
            window.photoSlots = [];

            // Reset watermark
            if (watermark) {
                watermark.classList.add('hidden');
                watermark.classList.remove('show');
            }

            // Reset other elements
            if (countdownOverlay) {
                countdownOverlay.textContent = '';
                countdownOverlay.style.display = 'none';
                countdownOverlay.style.backgroundColor = 'transparent';
            }
            if (captureButton) {
                captureButton.textContent = "📷 Mulai Sesi Foto";
                captureButton.disabled = false;
            }

            // Clear any running countdown
            if (window.timer) {
                clearInterval(window.timer);
                window.timer = null;
            }
        }

        function closePreviewCameraModal() {
            const modal = document.getElementById('previewCameraModal');
            const video = document.getElementById('previewVideo');

            // Stop all camera tracks
            if (video.srcObject) {
                const tracks = video.srcObject.getTracks();
                tracks.forEach(track => track.stop());
                video.srcObject = null;
            }

            // Reset modal state
            resetModalState();

            // Hide modal
            modal.style.display = 'none';
        }

        function addScriptIfNeeded() {
            // Check if html2canvas script is already loaded
            if (!window.html2canvas) {
                const html2canvasScript = document.createElement('script');
                html2canvasScript.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js';
                html2canvasScript.async = true;
                document.head.appendChild(html2canvasScript);
            }
        }

        function startPhotoSession() {
            const video = document.getElementById('previewVideo');
            const captureButton = document.getElementById('previewCaptureButton');
            const countdownOverlay = document.getElementById('previewCountdownOverlay');

            // Clear any existing photos first
            if (window.photoSlots) {
                window.photoSlots.forEach(img => {
                    img.src = '';
                    img.style.display = 'none';
                });
            }

            // Disable tombol selama sesi
            captureButton.disabled = true;
            captureButton.textContent = "Sedang mengambil foto...";

            let photosLeft = 3; // Jumlah foto yang akan diambil
            let currentPhoto = 0; // Indeks slot foto saat ini

            // Fungsi untuk memulai countdown per foto
            function startCountdown() {
                let countdown = 3; // Mulai dari 3
                countdownOverlay.textContent = countdown;
                countdownOverlay.style.display = 'flex';
                countdownOverlay.style.backgroundColor = 'transparent'; // Reset efek flash

                // Interval untuk countdown
                const countdownTimer = setInterval(() => {
                    countdown--;

                    if (countdown > 0) {
                        // Update tampilan countdown
                        countdownOverlay.textContent = countdown;
                    } else if (countdown === 0) {
                        // Tampilkan "Snap!" saat countdown mencapai 0
                        countdownOverlay.textContent = 'Snap!';
                    } else {
                        // Ambil foto
                        takePhoto(currentPhoto);
                        currentPhoto++;
                        photosLeft--;

                        // Bersihkan interval setelah foto diambil
                        clearInterval(countdownTimer);

                        if (photosLeft > 0) {
                            // Mulai countdown untuk foto berikutnya
                            setTimeout(startCountdown, 500); // Jeda singkat antar foto
                        } else {
                            // Sesi selesai
                            countdownOverlay.style.display = 'none';
                            captureButton.textContent = "Selesai! Klik untuk ulang";
                            captureButton.disabled = false;
                        }
                    }
                }, 1000); // Interval 1 detik
            }

            // Mulai countdown untuk foto pertama
            startCountdown();
        }

        function takePhoto(slotIndex) {
            const video = document.getElementById('previewVideo');
            const countdownOverlay = document.getElementById('previewCountdownOverlay');
            const watermark = document.getElementById('previewWatermark');

            // Efek flash
            countdownOverlay.style.backgroundColor = 'rgba(255, 255, 255, 0.9)';
            countdownOverlay.textContent = '';

            // Buat canvas untuk menangkap frame dari video
            const canvas = document.createElement('canvas');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            const ctx = canvas.getContext('2d');

            // Flip gambar secara horizontal (efek cermin)
            ctx.translate(canvas.width, 0);
            ctx.scale(-1, 1);

            // Gambar frame video ke canvas
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

            // Reset transformasi untuk watermark
            ctx.setTransform(1, 0, 0, 1, 0, 0);

            // Fungsi untuk menambahkan watermark
            const addWatermark = () => {
                return new Promise((resolve) => {
                    if (watermark && watermark.classList.contains('show')) {
                        ctx.save();
                        ctx.translate(canvas.width / 2, canvas.height / 2);
                        ctx.globalAlpha = 0.4; // Transparansi watermark


                        // Gambar logo
                        const logo = new Image();
                        logo.src = '{{ asset('logo4.png') }}';
                        logo.onload = () => {
                            ctx.drawImage(logo, -60, -20, 140, 80); // Sesuaikan ukuran dan posisi logo
                            ctx.restore();
                            resolve();
                        };
                        logo.onerror = () => {
                            console.error('Failed to load watermark logo');
                            ctx.restore();
                            resolve(); // Lanjutkan meskipun logo gagal dimuat
                        };
                    } else {
                        resolve(); // Tidak ada watermark, lanjutkan
                    }
                });
            };

            // Tambahkan watermark dan simpan foto
            addWatermark().then(() => {
                // Konversi canvas ke data URL
                const photoDataUrl = canvas.toDataURL('image/jpeg');

                // Tambahkan foto ke slot yang sesuai
                if (window.photoSlots && window.photoSlots[slotIndex]) {
                    window.photoSlots[slotIndex].src = photoDataUrl;
                    window.photoSlots[slotIndex].style.display = 'block';
                }

                // Hilangkan efek flash setelah 200ms
                setTimeout(() => {
                    countdownOverlay.style.backgroundColor = 'transparent';
                    countdownOverlay.textContent = '';
                }, 200);
            });
        }

        function fetchFrameDetails(frameId) {
            return fetch(`/get-frame-status/${frameId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    // Show/hide watermark based on frame status
                    const watermark = document.getElementById('previewWatermark');
                    if (watermark) {
                        if (data.status === 'paid') {
                            watermark.classList.add('show');
                            watermark.classList.remove('hidden');
                        } else {
                            watermark.classList.add('hidden');
                            watermark.classList.remove('show');
                        }
                    }
                    return data;
                })
                .catch(error => {
                    console.error('Error fetching frame status:', error);
                    // Default: hide watermark on error
                    const watermark = document.getElementById('previewWatermark');
                    if (watermark) {
                        watermark.classList.add('hidden');
                        watermark.classList.remove('show');
                    }
                    return null;
                });
        }
    </script>

@endsection
