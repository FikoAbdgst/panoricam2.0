@extends('layouts.app')

@section('content section')
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
        // Define these variables globally so they're accessible in your script
        const frameId = {{ $frame->id }};
        const savePhotoRoute = '{{ route('savePhoto') }}';
        const csrfToken = '{{ csrf_token() }}';
    </script>


    <div class="min-h-screen bg-gradient-to-b from-blue-100 via-indigo-50 to-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header with back button -->
            <div class="mb-6 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center text-blue-600 hover:text-blue-800 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="font-medium">Kembali ke Galeri Frame</span>
                </a>
            </div>

            <!-- Title -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">
                    <span class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600">
                        {{ $frame->name }}
                    </span>
                </h1>
                <p class="mt-2 text-gray-600 text-lg">Ambil foto sesuai dengan frame yang Anda pilih</p>
            </div>

            <!-- Main Content Area -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8 border border-gray-100">
                <!-- Middle - Camera View -->
                <div class="md:flex">
                    <!-- Middle - Camera View -->
                    <div class="md:w-3/5 p-6 flex flex-col" id="camera-container">
                        <div class="relative w-full">
                            <!-- Video container with 4:3 aspect ratio -->
                            <div class="aspect-ratio-container" style="position: relative; padding-top: 75%;">
                                <!-- Video element for the camera feed -->
                                <video id="camera"
                                    class="absolute inset-0 w-full h-full bg-black rounded-xl shadow-inner object-cover"
                                    autoplay playsinline></video>

                                <div id="countdown"
                                    class="absolute inset-0 flex items-center justify-center text-7xl font-bold text-white bg-black bg-opacity-50 rounded-xl hidden">
                                    3
                                </div>


                                <!-- Loading spinner overlay -->
                                <div id="loading"
                                    class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-50 rounded-xl hidden">
                                    <div class="animate-spin rounded-full h-20 w-20 border-t-4 border-b-4 border-blue-500">
                                    </div>
                                </div>

                                <!-- Camera status -->
                                <div id="camera-status"
                                    class="absolute top-3 left-3 bg-red-500 text-white text-sm px-3 py-1 rounded-full hidden flex items-center">
                                    <span class="mr-2 inline-block h-2 w-2 rounded-full bg-white animate-pulse"></span>
                                    REC
                                </div>
                            </div>
                        </div>

                        <!-- Controls and info -->
                        <div class="w-full mt-6 space-y-6">
                            <!-- Photos counter -->
                            <div class="flex justify-between items-center">
                                <div class="bg-blue-50 px-4 py-2 rounded-lg flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    </svg>
                                    <span class="font-medium text-gray-700">
                                        Foto <span id="current-photo" class="font-bold text-blue-600">0</span>/<span
                                            id="total-photos">3</span>
                                    </span>
                                </div>
                                <div class="flex space-x-2">
                                    <span id="timer-display"
                                        class="text-base font-mono bg-indigo-100 text-indigo-800 px-3 py-2 rounded-lg flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        0s
                                    </span>
                                </div>
                            </div>

                            <!-- Control buttons -->
                            <div class="flex justify-center space-x-6">
                                <button id="timer-btn"
                                    class="px-4 py-3 bg-indigo-100 text-indigo-700 rounded-xl hover:bg-indigo-200 transition-colors flex items-center shadow-sm font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span id="timer-text">3s</span>
                                </button>

                                <button id="capture-btn"
                                    class="px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-xl hover:from-blue-600 hover:to-indigo-700 transition-colors flex items-center shadow-md font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    Ambil Foto
                                </button>
                            </div>
                        </div>

                        <!-- Preview Photos -->
                        <div class="mt-8">
                            <h3 class="text-center font-medium text-gray-700 mb-4 text-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Hasil Foto
                            </h3>
                            <div id="preview-photos"
                                class="flex justify-center gap-6 overflow-x-auto py-3 px-4 bg-gray-50 rounded-xl">
                                <!-- Preview photos will be displayed here -->
                                <div class="text-center text-gray-500 italic text-sm py-6" id="no-preview-photos-message">
                                    Belum ada foto yang diambil
                                </div>
                            </div>
                        </div>

                        <!-- Finish Button (moved from sidebar) -->
                        <div class="mt-6">
                            <button id="finish-btn"
                                class="w-full px-4 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors shadow-md font-medium hidden flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Selesai
                            </button>
                        </div>
                    </div>

                    <!-- Right Side - Frame Preview (Now full height) -->
                    <div
                        class="md:w-2/5 bg-gradient-to-br from-gray-50 to-blue-50 p-6 flex flex-col border-l border-gray-200">
                        <h3 class="text-center font-medium text-gray-700 mb-4 text-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Frame Preview
                        </h3>

                        <!-- Frame preview container - now takes full available height -->
                        <div class="relative w-4/5 flex-grow items-center   justify-center mx-auto">
                            <div class="absolute inset-0 rounded-xl shadow-md bg-gray-100 overflow-hidden">
                                <!-- Frame template will be loaded here -->
                                <div id="frame-preview" class="absolute inset-0">
                                    @include($templatePath)
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Finish Button (initially hidden) -->
                <button id="finish-btn"
                    class="mt-6 w-full px-4 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors shadow-md font-medium hidden flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Selesai
                </button>
            </div>
        </div>

        <!-- Instructions Panel -->
        <div class="bg-blue-50 rounded-xl shadow-md p-6 mx-6 mb-6 border border-blue-100">
            <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Panduan Penggunaan
            </h3>
            <ol class="list-decimal list-inside space-y-2 text-gray-600 ml-4">
                <li class="flex items-start">
                    <span class="mr-2">1.</span>
                    <span>Pilih timer yang diinginkan (3, 5, atau 10 detik)</span>
                </li>
                <li class="flex items-start">
                    <span class="mr-2">2.</span>
                    <span>Klik tombol "Ambil Foto" untuk mulai mengambil gambar</span>
                </li>
                <li class="flex items-start">
                    <span class="mr-2">3.</span>
                    <span>Tunggu hitungan mundur selesai</span>
                </li>
                <li class="flex items-start">
                    <span class="mr-2">4.</span>
                    <span>Ulangi jika hasil tidak sesuai dengan tombol "Ambil Ulang"</span>
                </li>
                <li class="flex items-start">
                    <span class="mr-2">5.</span>
                    <span>Klik "Selesai" untuk menyimpan dan berbagi hasil foto</span>
                </li>
            </ol>
        </div>
    </div>

    <!-- Replace the existing Success Modal with this updated version -->
    <div id="success-modal" class="fixed inset-0 z-50 overflow-y-auto hidden">
        <div class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm transition-opacity"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full mx-auto transform transition-all p-8">
                <div class="flex flex-col md:flex-row">
                    <!-- Left side - Text and actions -->
                    <div class="md:w-1/2 flex flex-col">
                        <div class="text-center md:text-left">
                            <div
                                class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-green-100 text-green-600 mb-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-gray-900 mb-3">Foto Berhasil Disimpan!</h3>
                            <p class="text-gray-600 mb-8">Foto Anda telah berhasil disimpan. Anda dapat mengunduh atau
                                membagikannya.</p>
                        </div>
                    </div>

                    <!-- Right side - Final photo preview -->
                    <div class="md:w-1/2 p-3 border border-gray-200 rounded-xl shadow-md mb-8 md:mb-0">
                        <div id="final-photo-preview" class="w-full">
                            <!-- Final photo will be displayed here -->
                        </div>
                    </div>
                </div>

                <!-- Bottom buttons -->
                <div class="flex flex-wrap justify-center gap-4 mt-6">
                    <button id="download-btn"
                        class="flex items-center px-5 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors shadow-md font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Unduh
                    </button>
                    <button id="share-btn"
                        class="flex items-center px-5 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors shadow-md font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                        </svg>
                        Bagikan
                    </button>
                    <a href="{{ route('home') }}"
                        class="flex items-center px-5 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition-colors shadow-md font-medium">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Galeri
                    </a>
                </div>
            </div>
        </div>
    </div>


    <!-- JavaScript for the camera functionality -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Elements
            const cameraElement = document.getElementById('camera');
            const countdownElement = document.getElementById('countdown');
            const loadingElement = document.getElementById('loading');
            const cameraStatusElement = document.getElementById('camera-status');
            const captureBtn = document.getElementById('capture-btn');
            const timerBtn = document.getElementById('timer-btn');
            const timerText = document.getElementById('timer-text');
            const timerDisplay = document.getElementById('timer-display');
            const currentPhotoElement = document.getElementById('current-photo');
            const totalPhotosElement = document.getElementById('total-photos');
            const capturedPhotosContainer = document.getElementById('captured-photos');
            const previewPhotosContainer = document.getElementById('preview-photos');
            const noPhotosMessage = document.getElementById('no-photos-message');
            const noPreviewPhotosMessage = document.getElementById('no-preview-photos-message');
            const finishBtn = document.getElementById('finish-btn');
            const successModal = document.getElementById('success-modal');
            const finalPhotoPreview = document.getElementById('final-photo-preview');
            const downloadBtn = document.getElementById('download-btn');
            const shareBtn = document.getElementById('share-btn');
            const framePreview = document.getElementById('frame-preview');

            // Variables
            let stream = null;
            let capturedPhotos = [null, null, null]; // Initialize with 3 null slots
            let currentTimerValue = 3; // Default timer in seconds
            let timerInterval = null;
            let currentPhotoIndex = 0; // Track which photo we're capturing (0, 1, or 2)
            let totalPhotos = 3;
            let isCapturing = false;
            let finalImageDataUrl = null; // Store the final image for direct download

            // Initialize
            initCamera();
            updatePhotoCounter();

            // Get photo slots from the frame
            const photoSlots = framePreview.querySelectorAll('.photo-slot');

            // Timer button click handler
            timerBtn.addEventListener('click', function() {
                // Rotate through timer options: 3s -> 5s -> 10s -> 3s
                if (currentTimerValue === 3) {
                    currentTimerValue = 5;
                } else if (currentTimerValue === 5) {
                    currentTimerValue = 10;
                } else {
                    currentTimerValue = 3;
                }

                timerText.textContent = currentTimerValue + 's';

                // Add a subtle animation to the button
                timerBtn.classList.add('scale-105');
                setTimeout(() => {
                    timerBtn.classList.remove('scale-105');
                }, 200);
            });

            // Capture button click handler
            captureBtn.addEventListener('click', function() {
                if (isCapturing) return;

                // Find the next available slot
                currentPhotoIndex = capturedPhotos.findIndex(photo => photo === null);
                if (currentPhotoIndex === -1) {
                    // All slots filled, can't take more photos
                    return;
                }

                isCapturing = true;

                // Add a subtle animation to the button
                captureBtn.classList.add('scale-105');
                setTimeout(() => {
                    captureBtn.classList.remove('scale-105');
                }, 200);

                // Start countdown
                startCountdown();
            });

            // Finish button click handler
            finishBtn.addEventListener('click', function() {
                // Show loading while generating final image
                loadingElement.classList.remove('hidden');

                // Remove null values from capturedPhotos
                const photosToSave = capturedPhotos.filter(photo => photo !== null);

                // Make sure all image slots in the frame have proper styling
                photoSlots.forEach((slot, index) => {
                    if (capturedPhotos[index]) {
                        slot.style.backgroundImage = `url(${capturedPhotos[index]})`;
                        slot.style.backgroundSize = 'cover';
                        slot.style.backgroundPosition = 'center';
                    }
                });

                // Give the browser a moment to render everything properly
                setTimeout(() => {
                    // Create vertical frame layout for the result
                    createVerticalFrameLayout(photosToSave)
                        .then(finalImage => {
                            // Hide loading
                            loadingElement.classList.add('hidden');

                            // Save the final image for download
                            finalImageDataUrl = finalImage;

                            // Replace finish button with download button
                            finishBtn.classList.add('hidden');

                            // Create a new download button
                            const directDownloadBtn = document.createElement('button');
                            directDownloadBtn.id = 'direct-download-btn';
                            directDownloadBtn.className =
                                'w-full px-4 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors shadow-md font-medium flex items-center justify-center';
                            directDownloadBtn.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Download Frame
                `;

                            // Add event listener to the download button
                            directDownloadBtn.addEventListener('click', function() {
                                if (finalImageDataUrl) {
                                    // Create a temporary link to download the image
                                    const link = document.createElement('a');
                                    link.href = finalImageDataUrl;
                                    link.download = 'photobooth_' + new Date()
                                        .getTime() + '.jpg';
                                    document.body.appendChild(link);
                                    link.click();
                                    document.body.removeChild(link);
                                }
                            });

                            // Insert the new download button where the finish button was
                            finishBtn.parentNode.insertBefore(directDownloadBtn, finishBtn
                                .nextSibling);

                            // Save photos to server in background
                            savePhotosToServer(photosToSave, finalImage);
                        })
                        .catch(error => {
                            console.error("Error creating vertical frame:", error);
                            loadingElement.classList.add('hidden');

                            // Fallback to alternative method
                            createFallbackImage(photosToSave);
                        });
                }, 300);

                // Add a subtle animation to the button
                finishBtn.classList.add('scale-105');
                setTimeout(() => {
                    finishBtn.classList.remove('scale-105');
                }, 200);
            });

            // Create vertical frame layout
            async function createVerticalFrameLayout(photosToSave) {
                return new Promise((resolve, reject) => {
                    try {
                        const canvas = document.createElement('canvas');
                        const ctx = canvas.getContext('2d');

                        // Set canvas dimensions (portrait orientation)
                        const frameWidth = 800;
                        const frameHeight = 1200;

                        canvas.width = frameWidth;
                        canvas.height = frameHeight;

                        // Fill with gradient background
                        const gradient = ctx.createLinearGradient(0, 0, 0, frameHeight);
                        gradient.addColorStop(0, '#e0e7ff'); // indigo-100
                        gradient.addColorStop(1, '#ffffff');
                        ctx.fillStyle = gradient;
                        ctx.fillRect(0, 0, frameWidth, frameHeight);

                        // Draw frame title
                        ctx.fillStyle = '#1e40af'; // indigo-800
                        ctx.font = 'bold 36px Arial, sans-serif';
                        ctx.textAlign = 'center';
                        ctx.fillText(document.querySelector('h1').textContent.trim(), frameWidth / 2,
                            60);

                        // Load frame template from DOM
                        html2canvas(framePreview, {
                                backgroundColor: null,
                                useCORS: true,
                                allowTaint: true,
                                scale: 2,
                                logging: false
                            }).then(frameCanvas => {
                                // Draw the frame in the top section
                                const frameAspectRatio = frameCanvas.width / frameCanvas.height;
                                const frameDestWidth = frameWidth * 0.9; // 90% of canvas width
                                const frameDestHeight = frameDestWidth / frameAspectRatio;

                                // Position the frame at the top with some padding
                                const frameX = (frameWidth - frameDestWidth) / 2;
                                const frameY = 100; // Below the title

                                // Draw the frame
                                ctx.drawImage(frameCanvas,
                                    0, 0, frameCanvas.width, frameCanvas.height,
                                    frameX, frameY, frameDestWidth, frameDestHeight);

                                // Calculate space for photos
                                const photoStartY = frameY + frameDestHeight + 40;
                                const photoContainerHeight = frameHeight - photoStartY - 40;
                                const photoHeight = photoContainerHeight / photosToSave.length - 20;

                                // Load all photos
                                const photoPromises = photosToSave.map((photoUrl, index) => {
                                    return new Promise((res) => {
                                        const img = new Image();
                                        img.crossOrigin = "Anonymous";
                                        img.onload = () => res({
                                            img,
                                            index
                                        });
                                        img.src = photoUrl;
                                    });
                                });

                                // Draw photos vertically
                                Promise.all(photoPromises)
                                    .then(loadedPhotos => {
                                        loadedPhotos.forEach(({
                                            img,
                                            index
                                        }) => {
                                            const photoWidth = frameWidth * 0.8;
                                            const photoY = photoStartY + index * (
                                                photoHeight + 20);
                                            const photoX = (frameWidth - photoWidth) /
                                                2;

                                            // Add photo border/shadow effect
                                            ctx.fillStyle = "#ffffff";
                                            ctx.shadowColor = "rgba(0, 0, 0, 0.2)";
                                            ctx.shadowBlur = 10;
                                            ctx.shadowOffsetX = 0;
                                            ctx.shadowOffsetY = 4;
                                            ctx.fillRect(photoX - 5, photoY - 5,
                                                photoWidth + 10, photoHeight + 10);

                                            // Reset shadow
                                            ctx.shadowColor = "transparent";
                                            ctx.shadowBlur = 0;
                                            ctx.shadowOffsetX = 0;
                                            ctx.shadowOffsetY = 0;

                                            // Draw the image
                                            ctx.drawImage(img, photoX, photoY,
                                                photoWidth, photoHeight);

                                            // Photo label
                                            ctx.fillStyle = "#4b5563"; // gray-600
                                            ctx.font = 'bold 16px Arial, sans-serif';
                                            ctx.textAlign = 'left';
                                            ctx.fillText(`Photo ${index + 1}`, photoX +
                                                10, photoY + 26);
                                        });

                                        // Add timestamp
                                        ctx.fillStyle = "#4b5563"; // gray-600
                                        ctx.font = '14px Arial, sans-serif';
                                        ctx.textAlign = 'right';
                                        ctx.fillText(new Date().toLocaleDateString(),
                                            frameWidth - 30, frameHeight - 20);

                                        // Get the final image data URL
                                        const finalImage = canvas.toDataURL('image/jpeg', 0.9);
                                        resolve(finalImage);
                                    })
                                    .catch(err => {
                                        console.error("Error loading photos:", err);
                                        reject(err);
                                    });
                            })
                            .catch(err => {
                                console.error("Error with html2canvas:", err);
                                reject(err);
                            });
                    } catch (error) {
                        console.error("Error creating vertical layout:", error);
                        reject(error);
                    }
                });
            }

            // Fallback image creation
            // Fallback image creation
            function createFallbackImage(photosToSave) {
                // Create a simple collage manually
                const canvas = document.createElement('canvas');
                const context = canvas.getContext('2d');

                // Set canvas size to portrait orientation
                canvas.width = 800;
                canvas.height = 1200;

                // Fill with a gradient background
                const gradient = context.createLinearGradient(0, 0, 0, canvas.height);
                gradient.addColorStop(0, '#e0e7ff');
                gradient.addColorStop(1, '#ffffff');
                context.fillStyle = gradient;
                context.fillRect(0, 0, canvas.width, canvas.height);

                // Draw a title
                context.fillStyle = '#1e40af';
                context.font = 'bold 32px Arial';
                context.textAlign = 'center';
                context.fillText('Photo Booth', canvas.width / 2, 60);

                // Set up promises to load all images
                const imagePromises = photosToSave.map((photoUrl, index) => {
                    return new Promise((resolve, reject) => {
                        const img = new Image();
                        img.crossOrigin = 'Anonymous';
                        img.onload = () => resolve({
                            img,
                            index
                        });
                        img.onerror = reject;
                        img.src = photoUrl;
                    });
                });

                // Once all images are loaded, draw them on the canvas
                Promise.all(imagePromises)
                    .then(loadedImages => {
                        // Calculate dimensions for vertical image layout
                        const imgWidth = canvas.width * 0.8;
                        const imgHeight = imgWidth * 0.75; // Maintain 4:3 aspect ratio
                        const startX = (canvas.width - imgWidth) / 2;
                        const verticalSpacing = 30;

                        // Draw each photo vertically
                        loadedImages.forEach((item, i) => {
                            const startY = 120 + i * (imgHeight + verticalSpacing);

                            // Draw white background with shadow
                            context.shadowColor = 'rgba(0, 0, 0, 0.2)';
                            context.shadowBlur = 10;
                            context.shadowOffsetX = 0;
                            context.shadowOffsetY = 5;
                            context.fillStyle = '#ffffff';
                            context.fillRect(startX - 10, startY - 10, imgWidth + 20, imgHeight + 20);

                            // Reset shadow
                            context.shadowColor = 'transparent';
                            context.shadowBlur = 0;

                            // Draw the image
                            context.drawImage(item.img, startX, startY, imgWidth, imgHeight);

                            // Add photo number
                            context.fillStyle = '#4b5563';
                            context.font = 'bold 16px Arial';
                            context.textAlign = 'left';
                            context.fillText(`Photo ${i + 1}`, startX + 10, startY + 26);
                        });

                        // Add a footer
                        const today = new Date();
                        context.fillStyle = '#4b5563';
                        context.font = '16px Arial';
                        context.textAlign = 'right';
                        context.fillText(today.toLocaleDateString(), canvas.width - 30, canvas.height - 30);

                        // Get the data URL and proceed
                        finalImageDataUrl = canvas.toDataURL('image/jpeg', 0.92);

                        // Hide loading
                        loadingElement.classList.add('hidden');

                        // Replace finish button with download button
                        finishBtn.classList.add('hidden');

                        // Create a new download button
                        const directDownloadBtn = document.createElement('button');
                        directDownloadBtn.id = 'direct-download-btn';
                        directDownloadBtn.className =
                            'w-full px-4 py-3 bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors shadow-md font-medium flex items-center justify-center';
                        directDownloadBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Download Frame
            `;

                        // Add event listener to the download button
                        directDownloadBtn.addEventListener('click', function() {
                            if (finalImageDataUrl) {
                                // Create a temporary link to download the image
                                const link = document.createElement('a');
                                link.href = finalImageDataUrl;
                                link.download = 'photobooth_' + new Date().getTime() + '.jpg';
                                document.body.appendChild(link);
                                link.click();
                                document.body.removeChild(link);
                            }
                        });

                        // Insert the new download button where the finish button was
                        finishBtn.parentNode.insertBefore(directDownloadBtn, finishBtn.nextSibling);

                        // Save photos to server
                        savePhotosToServer(photosToSave, finalImageDataUrl);
                    })
                    .catch(error => {
                        console.error("Fallback method failed:", error);
                        loadingElement.classList.add('hidden');
                        alert("Unable to generate final image. Please try again or contact support.");
                    });
            }

            // Save photos to server function
            function savePhotosToServer(photosToSave, finalImage) {
                // Collect all photos to send to server
                const photosData = {
                    photos: photosToSave,
                    frame_id: frameId,
                    final_image: finalImage
                };

                // Send the photos to the server
                fetch(savePhotoRoute, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify(photosData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            console.error('Server save error:', data.message);
                            // Silent error - user already has the download available
                        } else {
                            console.log('Photos saved successfully to server');
                            // Optional: Update download button to use server URL if needed
                            // downloadBtn.setAttribute('data-server-url', data.download_url);
                        }
                    })
                    .catch(error => {
                        console.error('Error saving photos to server:', error);
                        // Silent error - user already has the download available
                    });
            }

            // Download button click handler - Direct download from browser
            downloadBtn.addEventListener('click', function() {
                if (finalImageDataUrl) {
                    // Create a temporary link to download the image
                    const link = document.createElement('a');
                    link.href = finalImageDataUrl;
                    link.download = 'photobooth_' + new Date().getTime() + '.jpg';
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                }

                // Add a subtle animation to the button
                downloadBtn.classList.add('scale-105');
                setTimeout(() => {
                    downloadBtn.classList.remove('scale-105');
                }, 200);
            });

            // Share button click handler
            shareBtn.addEventListener('click', function() {
                if (navigator.share && finalImageDataUrl) {
                    // Convert image to blob
                    fetch(finalImageDataUrl)
                        .then(res => res.blob())
                        .then(blob => {
                            const file = new File([blob], 'photobooth.jpg', {
                                type: 'image/jpeg'
                            });
                            navigator.share({
                                title: 'My Photo Booth Picture',
                                files: [file]
                            }).catch(console.error);
                        });
                } else {
                    alert(
                        'Web Share API not supported in your browser. Please use the download button instead.'
                    );
                }

                // Add a subtle animation to the button
                shareBtn.classList.add('scale-105');
                setTimeout(() => {
                    shareBtn.classList.remove('scale-105');
                }, 200);
            });

            // Initialize camera
            function initCamera() {
                loadingElement.classList.remove('hidden');

                navigator.mediaDevices.getUserMedia({
                        video: {
                            width: {
                                ideal: 640
                            },
                            height: {
                                ideal: 480
                            }, // 4:3 aspect ratio (640x480)
                            facingMode: 'user'
                        },
                        audio: false
                    })
                    .then(function(mediaStream) {
                        stream = mediaStream;
                        cameraElement.srcObject = mediaStream;
                        loadingElement.classList.add('hidden');
                    })
                    .catch(function(err) {
                        console.error('Error accessing camera:', err);
                        loadingElement.classList.add('hidden');
                        alert(
                            'Camera access denied or not available. Please allow camera access and refresh the page.'
                        );
                    });
            }

            // Start countdown
            function startCountdown() {
                let seconds = currentTimerValue;
                countdownElement.textContent = seconds;

                // Make countdown transparent so camera is visible behind it
                countdownElement.classList.remove('hidden');
                countdownElement.classList.add('bg-opacity-60'); // Make background semi-transparent

                cameraStatusElement.classList.remove('hidden');

                // Update timer display
                timerDisplay.textContent = seconds + 's';

                timerInterval = setInterval(function() {
                    seconds--;

                    // Update countdown
                    countdownElement.textContent = seconds;
                    timerDisplay.textContent = seconds + 's';

                    // Add a gentle pulse animation without scaling the camera view
                    countdownElement.classList.add('text-pulse');
                    setTimeout(() => {
                        countdownElement.classList.remove('text-pulse');
                    }, 300);

                    if (seconds <= 0) {
                        clearInterval(timerInterval);
                        capturePhoto();
                    }
                }, 1000);
            }

            // Function to delete a photo by index
            function deletePhoto(index) {
                // Remove the photo from the array
                capturedPhotos[index] = null;

                // Update UI - only the preview display is needed
                updatePreviewPhotosDisplay();
                updatePhotoCounter();

                // Reset current photo slot in frame
                if (photoSlots && photoSlots[index]) {
                    photoSlots[index].style.backgroundImage = '';
                }

                isCapturing = false;
            }

            // Capture photo
            function capturePhoto() {
                // Hide countdown
                countdownElement.classList.add('hidden');
                cameraStatusElement.classList.add('hidden');

                // Create canvas to capture the frame with 4:3 aspect ratio
                const canvas = document.createElement('canvas');
                const aspectRatio = 4 / 3;

                // Use video's intrinsic size but maintain 4:3 aspect ratio
                let canvasWidth = cameraElement.videoWidth;
                let canvasHeight = canvasWidth / aspectRatio;

                // If the video's height is less than the computed height, adjust width instead
                if (canvasHeight > cameraElement.videoHeight) {
                    canvasHeight = cameraElement.videoHeight;
                    canvasWidth = canvasHeight * aspectRatio;
                }

                // Set canvas dimensions
                canvas.width = canvasWidth;
                canvas.height = canvasHeight;

                const context = canvas.getContext('2d');

                // Center the crop in the video frame
                const sourceX = (cameraElement.videoWidth - canvasWidth) / 2;
                const sourceY = (cameraElement.videoHeight - canvasHeight) / 2;

                // Draw video frame to canvas with 4:3 aspect ratio
                context.drawImage(
                    cameraElement,
                    sourceX, sourceY, canvasWidth, canvasHeight,
                    0, 0, canvasWidth, canvasHeight
                );

                // Get the data URL of the camera image
                const photoDataUrl = canvas.toDataURL('image/jpeg');

                // Store the captured photo in the correct slot
                capturedPhotos[currentPhotoIndex] = photoDataUrl;

                // Update the photo slot in the frame
                if (photoSlots && photoSlots[currentPhotoIndex]) {
                    photoSlots[currentPhotoIndex].style.backgroundImage = `url(${photoDataUrl})`;
                    photoSlots[currentPhotoIndex].style.backgroundSize = 'cover';
                    photoSlots[currentPhotoIndex].style.backgroundPosition = 'center';
                }

                // Only update the preview photos display
                updatePreviewPhotosDisplay();

                // Update photo counter
                updatePhotoCounter();

                // Check if we've taken all the photos
                if (!capturedPhotos.includes(null)) {
                    finishPhotos();
                }

                isCapturing = false;
            }

            // Update preview photos display (horizontal at bottom)
            function updatePreviewPhotosDisplay() {
                // Clear container
                previewPhotosContainer.innerHTML = '';

                const photosExist = capturedPhotos.some(photo => photo !== null);

                if (!photosExist) {
                    // Show "No photos" message
                    previewPhotosContainer.innerHTML =
                        '<div class="text-center text-gray-500 italic text-sm" id="no-preview-photos-message">Belum ada foto yang diambil</div>';
                } else {
                    // Add each photo as a thumbnail
                    capturedPhotos.forEach((photo, index) => {
                        if (photo !== null) {
                            const thumbnail = document.createElement('div');
                            thumbnail.className =
                                'relative flex-shrink-0 w-24 h-24 rounded overflow-hidden shadow-md';

                            const img = document.createElement('img');
                            img.src = photo;
                            img.className = 'w-full h-full object-cover';
                            thumbnail.appendChild(img);

                            // Add photo number
                            const photoNumber = document.createElement('div');
                            photoNumber.className =
                                'absolute top-1 left-1 bg-white bg-opacity-70 rounded-full h-5 w-5 flex items-center justify-center text-xs font-bold';
                            photoNumber.textContent = index + 1;
                            thumbnail.appendChild(photoNumber);

                            // Add delete button (X)
                            const deleteBtn = document.createElement('button');
                            deleteBtn.className =
                                'absolute top-1 right-1 bg-red-500 text-white rounded-full h-5 w-5 flex items-center justify-center text-xs font-bold hover:bg-red-600';
                            deleteBtn.innerHTML = '×';
                            deleteBtn.addEventListener('click', function() {
                                deletePhoto(index);
                            });
                            thumbnail.appendChild(deleteBtn);

                            previewPhotosContainer.appendChild(thumbnail);
                        }
                    });
                }
            }

            // Update photos display in sidebar
            function updatePhotosDisplay() {
                if (!capturedPhotosContainer) return;

                // Clear the container
                capturedPhotosContainer.innerHTML = '';

                const photosExist = capturedPhotos.some(photo => photo !== null);

                if (!photosExist) {
                    // Show "No photos" message if no photos
                    capturedPhotosContainer.innerHTML =
                        '<div class="text-center text-gray-500 italic text-sm" id="no-photos-message">Belum ada foto yang diambil</div>';
                } else {
                    // Add each photo as a thumbnail
                    capturedPhotos.forEach((photo, index) => {
                        if (photo !== null) {
                            const thumbnail = document.createElement('div');
                            thumbnail.className = 'relative rounded overflow-hidden shadow-md mb-3';

                            // Container for the image with 4:3 aspect ratio
                            const aspectRatioContainer = document.createElement('div');
                            aspectRatioContainer.style.position = 'relative';
                            aspectRatioContainer.style.paddingTop = '75%'; // 4:3 aspect ratio (75%)

                            const img = document.createElement('img');
                            img.src = photo;
                            img.className = 'absolute inset-0 w-full h-full object-cover';

                            aspectRatioContainer.appendChild(img);
                            thumbnail.appendChild(aspectRatioContainer);

                            // Add photo number
                            const photoNumber = document.createElement('div');
                            photoNumber.className =
                                'absolute top-1 left-1 bg-white bg-opacity-70 rounded-full h-5 w-5 flex items-center justify-center text-xs font-bold';
                            photoNumber.textContent = index + 1;
                            thumbnail.appendChild(photoNumber);

                            // Add delete button
                            const deleteBtn = document.createElement('button');
                            deleteBtn.className =
                                'absolute top-1 right-1 bg-red-500 text-white rounded-full h-5 w-5 flex items-center justify-center text-xs font-bold hover:bg-red-600';
                            deleteBtn.innerHTML = '×';
                            deleteBtn.addEventListener('click', function() {
                                deletePhoto(index);
                            });
                            thumbnail.appendChild(deleteBtn);

                            capturedPhotosContainer.appendChild(thumbnail);
                        }
                    });
                }
            }

            // Update photo counter
            function updatePhotoCounter() {
                const photosCount = capturedPhotos.filter(photo => photo !== null).length;
                currentPhotoElement.textContent = photosCount;
                totalPhotosElement.textContent = totalPhotos;

                // Show/hide finish button
                if (photosCount > 0) {
                    finishBtn.classList.remove('hidden');
                } else {
                    finishBtn.classList.add('hidden');
                }
            }

            // Finish photos
            function finishPhotos() {
                // Make finish button more prominent
                finishBtn.classList.add('animate-pulse', 'bg-green-500');
            }

            // Close modal when clicking outside
            successModal.addEventListener('click', function(e) {
                if (e.target === successModal) {
                    successModal.classList.add('hidden');
                }
            });

            // Stop the camera when leaving the page
            window.addEventListener('beforeunload', function() {
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                }
            });

            // Add CSS for countdown style
            const style = document.createElement('style');
            style.textContent = `
        #countdown {
            background-color: rgba(0, 0, 0, 0.5) !important;
            color: white;
            font-size: 5rem;
            border-radius: 1rem;
        }
        
        .text-pulse {
            animation: textPulse 0.3s ease-in-out;
        }
        
        @keyframes textPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
    `;
            document.head.appendChild(style);

            // Also update the success modal HTML in case it needs to be adjusted for vertical layout
            const successModalContent = document.querySelector('#success-modal .max-w-lg');
            if (successModalContent) {
                // Make the modal wider for vertical layout
                successModalContent.classList.remove('max-w-lg');
                successModalContent.classList.add('max-w-2xl');
            }
        });
    </script>
@endsection
