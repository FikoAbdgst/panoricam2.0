<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Photo Strip Booth</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="m-0 font-['Poppins'] bg-pink-50 flex flex-col items-center p-5">
    <!-- Header remains unchanged -->
    <header class="w-[90%] mx-auto my-5 p-5 px-12 flex justify-between items-center bg-white shadow-lg rounded-2xl">
        <div class="logo">
            <img src="logo4.png" alt="Logo" class="h-12">
        </div>
        <nav>
            <a href="{{ route('home') }}"
                class="ml-8 no-underline text-gray-600 font-medium transition-colors duration-300 hover:text-pink-500">home</a>
            <a href="{{ route('about') }}"
                class="ml-8 no-underline text-gray-600 font-medium transition-colors duration-300 hover:text-pink-500">about</a>
        </nav>
    </header>

    <div
        class="w-[90%] max-w-[1200px] bg-[url('bg.png')] bg-cover bg-center p-10 mt-1 rounded-3xl shadow-lg flex flex-col items-center">
        <h1 class="mb-5 font-semibold text-gray-800 text-5xl p-4 bg-white rounded-lg">
            <span class="text-red-600">C</span><span class="text-pink-300">A</span><span
                class="text-green-400">P</span><span class="text-yellow-300">T</span><span
                class="text-blue-300">U</span><span class="text-purple-400">R</span><span
                class="text-yellow-300">E</span>
            <span class="text-blue-300">T</span><span class="text-green-300">I</span><span
                class="text-orange-300">M</span><span class="text-purple-400">E</span><span
                class="text-pink-300">!</span>
        </h1>

        <div class="flex gap-8 flex-wrap items-start justify-center">
            <div class="relative w-[660px] h-[500px]">
                <video id="video" autoplay
                    class="w-full h-full bg-gray-200 rounded-xl shadow-md scale-x-[-1]"></video>
                <div id="countdown-overlay"
                    class="absolute top-0 left-0 w-full h-full flex justify-center items-center text-8xl font-bold text-white pointer-events-none"
                    style="text-shadow: 0 0 10px rgba(0, 0, 0, 0.7);"></div>
            </div>
            <div class="w-[190px] h-[500px] relative frame-container">
                <div id="frameTemplate" class="w-full h-full relative">
                    @include($templatePath, ['frame' => $frame])
                </div>
            </div>
        </div>

        <div id="timer" class="text-3xl font-bold text-gray-700 mt-4"></div>

        <div class="mt-5 flex gap-3 flex-wrap justify-center font-medium">
            <button id="captureButton"
                class="bg-white text-black border-2 border-pink-300 py-4 px-8 text-base font-semibold rounded-xl cursor-pointer transition-all duration-300 ease-in-out hover:bg-pink-300 hover:scale-105">
                <span class="text-red-600">S</span>
                <span class="text-pink-500">t</span>
                <span class="text-green-400">a</span>
                <span class="text-yellow-500">r</span>
                <span class="text-blue-300">t</span>
                <span class="text-purple-400"> </span>
                <span class="text-yellow-500">C</span>
                <span class="text-blue-400">a</span>
                <span class="text-green-500">p</span>
                <span class="text-orange-500">t</span>
                <span class="text-purple-400">u</span>
                <span class="text-pink-400">r</span>
                <span class="text-red-600">e</span>
            </button>

            <button id="uploadButton"
                class="bg-white text-black border-2 border-blue-300 py-4 px-8 text-base font-semibold rounded-xl cursor-pointer transition-all duration-300 ease-in-out hover:bg-blue-300 hover:scale-105">
                <span class="text-blue-600">U</span>
                <span class="text-purple-500">p</span>
                <span class="text-green-400">l</span>
                <span class="text-orange-500">o</span>
                <span class="text-pink-300">a</span>
                <span class="text-yellow-500">d</span>
                <span class="text-blue-400"> </span>
                <span class="text-green-500">P</span>
                <span class="text-red-500">h</span>
                <span class="text-purple-400">o</span>
                <span class="text-pink-400">t</span>
                <span class="text-blue-600">o</span>
            </button>

            <input type="file" id="fileInput" accept="image/*" class="hidden">

            <select id="filterSelect"
                class="py-3.5 px-3 rounded-xl bg-pink-200 text-base font-medium cursor-pointer border-2 border-pink-300 transition-all duration-300 ease-in-out hover:bg-pink-300">
                <option value="none">No Filter</option>
                <option value="grayscale(100%)">Grayscale</option>
                <option value="sepia(100%)">Sepia</option>
                <option value="contrast(150%)">High Contrast</option>
                <option value="brightness(120%)">Bright</option>
            </select>

            <!-- Toggle Mirror Camera -->
            <button id="mirrorToggle"
                class="bg-white text-black border-2 border-blue-300 py-4 px-8 text-base font-semibold rounded-xl cursor-pointer transition-all duration-300 ease-in-out hover:bg-blue-300 hover:scale-105">
                Mirror: Off
            </button>

            <!-- Dropdown Countdown -->
            <select id="countdownSelect"
                class="py-3.5 px-3 rounded-xl bg-pink-200 text-base font-medium cursor-pointer border-2 border-pink-300 transition-all duration-300 ease-in-out hover:bg-pink-300">
                <option value="3">3 Seconds</option>
                <option value="5">5 Seconds</option>
                <option value="0">No Countdown</option>
            </select>

            <button id="finishButton"
                class="hidden bg-green-500 text-white border-2 border-green-700 py-4 px-8 text-base font-medium rounded-xl cursor-pointer transition-all duration-300 ease-in-out hover:bg-green-700 hover:scale-105">
                Selesai!
            </button>
        </div>
    </div>

    <!-- Upload and Preview Modals remain unchanged -->
    <div id="uploadModal"
        class="hidden fixed z-50 left-0 top-0 w-full h-full bg-black bg-opacity-70 overflow-auto justify-center items-center">
        <div
            class="bg-white mx-auto w-4/5 max-w-[600px] rounded-3xl shadow-lg p-8 relative flex flex-col items-center animate-[modalFadeIn_0.4s]">
            <button
                class="upload-modal-close absolute top-4 right-4 text-3xl font-bold text-gray-400 bg-transparent border-none cursor-pointer hover:text-black">×</button>
            <h2 class="text-2xl mb-5 text-gray-800">Select Photo Slot</h2>
            <p class="mb-5 text-gray-600">Choose which slot to place your uploaded photo:</p>
            <div class="flex gap-4 justify-center mb-6">
                <button
                    class="slot-select-button bg-pink-500 text-white border-none py-3 px-6 text-base font-medium rounded-xl cursor-pointer hover:bg-pink-600"
                    data-slot="0">Slot 1</button>
                <button
                    class="slot-select-button bg-pink-500 text-white border-none py-3 px-6 text-base font-medium rounded-xl cursor-pointer hover:bg-pink-600"
                    data-slot="1">Slot 2</button>
                <button
                    class="slot-select-button bg-pink-500 text-white border-none py-3 px-6 text-base font-medium rounded-xl cursor-pointer hover:bg-pink-600"
                    data-slot="2">Slot 3</button>
            </div>
        </div>
    </div>

    <div id="previewModal"
        class="hidden fixed z-50 left-0 top-0 w-full h-full bg-black bg-opacity-70 overflow-auto justify-center items-center">
        <div
            class="bg-white mx-auto w-4/5 max-w-[800px] rounded-3xl shadow-lg p-8 relative flex flex-col items-center animate-[modalFadeIn_0.4s]">
            <button
                class="modal-close absolute top-4 right-4 text-3xl font-bold text-gray-400 bg-transparent border-none cursor-pointer hover:text-black">×</button>
            <h2 class="text-2xl mb-5 text-gray-800">Preview Photo Strip</h2>
            <div class="w-full flex justify-center mb-8">
                <div class="w-[180px] shadow-md" id="modalPhotostrip"></div>
            </div>
            <div class="flex gap-4 mt-5">
                <button id="modalResetButton"
                    class="bg-red-600 text-white border-none py-4 px-8 text-base font-medium rounded-xl cursor-pointer transition-all duration-300 ease-in-out hover:bg-red-700 hover:scale-105">🔁
                    Reset All</button>
                <button id="modalDownloadButton"
                    class="bg-green-600 text-white border-none py-4 px-8 text-base font-medium rounded-xl cursor-pointer transition-all duration-300 ease-in-out hover:bg-green-700 hover:scale-105">⬇
                    Download</button>
                <button id="modalShareButton"
                    class="bg-blue-600 text-white border-none py-4 px-8 text-base font-medium rounded-xl cursor-pointer transition-all duration-300 ease-in-out hover:bg-blue-700 hover:scale-105">📤
                    Share</button>
            </div>
        </div>
    </div>

    <input type="hidden" id="frameId" value="{{ $frame->id }}">

    <style>
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

        #mirrorToggle.active {
            background-color: #60a5fa;
            color: white;
            border-color: #3b82f6;
        }

        #countdownSelect {
            min-width: 120px;
        }

        .photo-slot-container {
            position: absolute;
            overflow: hidden;
            width: 150px;
            height: 150px;
        }

        .photo-slot {
            width: 100%;
            height: 100%;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        .photo-slot img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .photo-slot-container[data-has-photo="true"]:hover .photo-slot::before {
            content: "Click photo to retake";
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            z-index: 20;
            white-space: nowrap;
        }

        .photo-slot-container:hover .retake-button {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }

        .retake-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.8);
            opacity: 0;
            transition: all 0.3s ease;
            background-color: rgba(255, 0, 0, 0.7);
            color: white;
            border: none;
            padding: 10px 12px;
            border-radius: 50%;
            font-size: 20px;
            z-index: 15;
            cursor: pointer;
        }

        .photo-slot img:not([src]),
        .photo-slot img[src=""] {
            display: none;
        }

        /* Overlay effect on hover */
        .photo-slot-container:hover .photo-slot::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            /* Darker overlay for visibility */
            pointer-events: none;
        }

        /* Tooltip for "Click photo to retake" */
        .photo-slot-container[data-has-photo="true"]:hover .photo-slot::before {
            content: "Click photo to retake";
            position: absolute;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            background-color: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            z-index: 20;
            white-space: nowrap;
        }

        .retake-button:hover {
            background-color: rgba(255, 0, 0, 0.9);
            transform: translate(-50%, -50%) scale(1.1);
        }

        [data-photo-index]:hover img {
            filter: blur(2px);
            transform: scale(1.05);
            transition: all 0.3s ease;
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        let photoSlots = document.querySelectorAll('.photo-slot img');
        let video = document.getElementById('video');
        let captureButton = document.getElementById('captureButton');
        let uploadButton = document.getElementById('uploadButton');
        let fileInput = document.getElementById('fileInput');
        let finishButton = document.getElementById('finishButton');
        let filterSelect = document.getElementById('filterSelect');
        let timerDisplay = document.getElementById('timer');
        let countdownOverlay = document.getElementById('countdown-overlay');
        let canvas = document.createElement('canvas');
        let ctx = canvas.getContext('2d');

        let retakeButtons = document.querySelectorAll('.retake-button');
        let frameId = document.getElementById('frameId').value;

        let modal = document.getElementById('previewModal');
        let modalClose = document.querySelector('.modal-close');
        let modalPhotostrip = document.getElementById('modalPhotostrip');
        let modalResetButton = document.getElementById('modalResetButton');
        let modalDownloadButton = document.getElementById('modalDownloadButton');
        let modalShareButton = document.getElementById('modalShareButton');

        let uploadModal = document.getElementById('uploadModal');
        let slotSelectButtons = document.querySelectorAll('.slot-select-button');
        let uploadModalClose = document.querySelector('.upload-modal-close');

        let currentPhotoIndex = null;
        let countdown = 3;
        let timer;
        let capturing = false;
        let photoStripImage = null;
        let selectedFile = null;
        let selectedSlotIndex = null;
        let isInitialized = false;

        let isMirrored = true; // Default: mirrored
        let selectedCountdown = 3; // Default: 3 seconds

        // Store original capture button HTML for consistent styling
        const originalCaptureButtonHTML = captureButton ? captureButton.innerHTML : '';

        console.log('Initial elements:', {
            photoSlots: photoSlots.length,
            video: !!video,
            captureButton: !!captureButton,
            uploadButton: !!uploadButton,
            fileInput: !!fileInput,
            finishButton: !!finishButton,
            filterSelect: !!filterSelect,
            uploadModal: !!uploadModal,
            slotSelectButtons: slotSelectButtons.length
        });

        function initializeWebcam() {
            navigator.mediaDevices.getUserMedia({
                    video: true
                })
                .then(stream => {
                    video.srcObject = stream;
                })
                .catch(err => {
                    console.error("Error accessing webcam: " + err);
                    alert(
                        "Failed to access webcam. Please ensure your camera is connected and permissions are granted."
                    );
                });
        }

        function setupFilterChange() {
            if (filterSelect) {
                filterSelect.addEventListener('change', () => {
                    if (video) {
                        video.style.filter = filterSelect.value;
                    }
                });
            }
        }

        // Perbarui fungsi capturePhoto untuk menangani mirror
        function capturePhoto() {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.save();
            if (isMirrored) {
                ctx.translate(canvas.width, 0);
                ctx.scale(-1, 1);
            }
            ctx.filter = getComputedStyle(video).filter;
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            ctx.restore();
            const dataUrl = canvas.toDataURL();

            if (photoSlots[currentPhotoIndex]) {
                photoSlots[currentPhotoIndex].src = dataUrl;
                photoSlots[currentPhotoIndex].style.display = 'block';
                photoSlots[currentPhotoIndex].style.width = '100%';
                photoSlots[currentPhotoIndex].style.height = '100%';
                photoSlots[currentPhotoIndex].style.objectFit = 'cover';
                if (retakeButtons[currentPhotoIndex]) {
                    retakeButtons[currentPhotoIndex].setAttribute('data-has-photo', 'true');
                    retakeButtons[currentPhotoIndex].parentElement.setAttribute('data-has-photo', 'true');
                }
            }

            if (captureButton) {
                captureButton.innerHTML = originalCaptureButtonHTML;
                updateCaptureButtonStyle(filterSelect.value); // Update button style after capture
            }
            capturing = false;
            checkAllPhotosTaken();
        }

        function checkAllPhotosTaken() {
            let allTaken = true;
            for (let i = 0; i < photoSlots.length; i++) {
                if (!photoSlots[i].src || photoSlots[i].src === window.location.href || photoSlots[i].src.length < 10) {
                    allTaken = false;
                    break;
                }
            }
            if (finishButton) {
                finishButton.style.display = allTaken ? 'block' : 'none';
            }
        }

        function findNextEmptySlot() {
            for (let i = 0; i < photoSlots.length; i++) {
                if (!photoSlots[i].src || photoSlots[i].src === window.location.href || photoSlots[i].src.length < 10) {
                    return i;
                }
            }
            return null;
        }

        // Perbarui fungsi startCountdown untuk menggunakan countdown yang dipilih
        function startCountdown(photoIndex) {
            if (capturing) return;
            capturing = true;
            currentPhotoIndex = photoIndex;

            countdown = selectedCountdown;
            if (countdownOverlay) countdownOverlay.textContent = countdown;

            if (captureButton) {
                captureButton.innerHTML = `<span class="text-red-600">C</span>
                                  <span class="text-pink-500">a</span>
                                  <span class="text-green-400">p</span>
                                  <span class="text-yellow-500">t</span>
                                  <span class="text-blue-300">u</span>
                                  <span class="text-purple-400">r</span>
                                  <span class="text-yellow-500">i</span>
                                  <span class="text-blue-400">n</span>
                                  <span class="text-green-500">g</span>
                                  <span class="text-orange-500">.</span>
                                  <span class="text-purple-400">.</span>
                                  <span class="text-pink-400">.</span>`;
            }

            if (selectedCountdown === 0) {
                // No countdown, capture immediately
                if (countdownOverlay) countdownOverlay.textContent = "";
                capturePhoto();
            } else {
                timer = setInterval(() => {
                    countdown--;
                    if (countdown > 0) {
                        if (countdownOverlay) countdownOverlay.textContent = countdown;
                    } else {
                        clearInterval(timer);
                        if (countdownOverlay) countdownOverlay.textContent = "";
                        capturePhoto();
                    }
                }, 1000);
            }
        }

        function resetPhotos() {
            clearInterval(timer);
            capturing = false;
            if (countdownOverlay) countdownOverlay.textContent = "";

            photoSlots.forEach(photo => {
                if (photo) {
                    photo.src = "";
                    photo.removeAttribute('style');
                }
            });

            if (timerDisplay) timerDisplay.textContent = "";
            if (captureButton) captureButton.innerHTML = originalCaptureButtonHTML;
            if (finishButton) finishButton.style.display = 'none';

            retakeButtons.forEach(button => {
                if (button) {
                    button.setAttribute('data-has-photo', 'false');
                    button.parentElement.setAttribute('data-has-photo', 'false');
                }
            });

            if (modal) modal.style.display = 'none';
        }

        function getAllPhotoData() {
            const photos = [];
            photoSlots.forEach(slot => {
                if (slot && slot.src && slot.src !== window.location.href && slot.src.length > 10) {
                    photos.push(slot.src);
                }
            });
            return photos;
        }

        function savePhotos(finalImage) {
            const tokenElement = document.querySelector('meta[name="csrf-token"]');
            if (!tokenElement) {
                console.error('CSRF token not found');
                return;
            }

            const token = tokenElement.getAttribute('content');

            fetch('/savePhoto', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        photos: getAllPhotoData(),
                        frame_id: frameId,
                        final_image: finalImage
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        console.log('Photos saved successfully');
                        if (data.download_url) {
                            photoStripImage = data.download_url;
                        }
                    } else {
                        console.error('Error saving photos');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function downloadPhotoStrip() {
            if (photoStripImage && photoStripImage.startsWith('http')) {
                const a = document.createElement('a');
                a.href = photoStripImage;
                a.download = 'photo-strip.png';
                a.click();
            } else {
                html2canvas(document.querySelector('.frame-container')).then(canvas => {
                    photoStripImage = canvas.toDataURL();
                    const a = document.createElement('a');
                    a.href = photoStripImage;
                    a.download = 'photo-strip.png';
                    a.click();
                });
            }
        }

        function sharePhotoStrip() {
            if (navigator.share && photoStripImage) {
                if (photoStripImage.startsWith('http')) {
                    navigator.share({
                            title: 'My Photo Strip',
                            text: 'Check out my photo strip!',
                            url: photoStripImage
                        })
                        .then(() => console.log('Shared successfully'))
                        .catch(err => {
                            console.error('Error sharing:', err);
                            alert('Sharing failed. Try downloading instead.');
                        });
                } else {
                    fetch(photoStripImage)
                        .then(res => res.blob())
                        .then(blob => {
                            const file = new File([blob], 'photo-strip.png', {
                                type: 'image/png'
                            });
                            navigator.share({
                                    title: 'My Photo Strip',
                                    text: 'Check out my photo strip!',
                                    files: [file]
                                })
                                .then(() => console.log('Shared successfully'))
                                .catch(err => {
                                    console.error('Error sharing:', err);
                                    alert('Sharing failed. Try downloading instead.');
                                });
                        });
                }
            } else {
                alert('Web Share API not supported or no image available. Please download instead.');
            }
        }

        function openPreviewModal() {
            const frameContainer = document.querySelector('.frame-container');
            if (!frameContainer) {
                console.error('Frame container not found');
                return;
            }

            html2canvas(frameContainer).then(canvas => {
                const imageData = canvas.toDataURL();
                savePhotos(imageData);

                if (modalPhotostrip) {
                    modalPhotostrip.innerHTML = '';
                    const img = document.createElement('img');
                    img.src = imageData;
                    img.style.width = '100%';
                    modalPhotostrip.appendChild(img);
                    photoStripImage = imageData;
                    if (modal) modal.style.display = 'flex';
                }
            });
        }

        function processUploadedPhoto(file, slotIndex) {
            console.log('Processing uploaded photo:', file ? file.name : 'none', 'Slot:', slotIndex);

            if (!file) {
                console.error('No file provided');
                return;
            }
            if (slotIndex === null || slotIndex < 0 || slotIndex >= photoSlots.length) {
                console.error('Invalid slot index:', slotIndex);
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    const uploadCanvas = document.createElement('canvas');
                    const uploadCtx = uploadCanvas.getContext('2d');
                    uploadCanvas.width = img.width;
                    uploadCanvas.height = img.height;
                    uploadCtx.filter = filterSelect ? filterSelect.value : 'none';
                    uploadCtx.drawImage(img, 0, 0, img.width, img.height);
                    const dataUrl = uploadCanvas.toDataURL('image/png');

                    const targetSlot = photoSlots[slotIndex];
                    if (targetSlot) {
                        targetSlot.src = dataUrl;
                        targetSlot.style.display = 'block';
                        targetSlot.style.width = '100%';
                        targetSlot.style.height = '100%';
                        targetSlot.style.objectFit = 'cover';
                        console.log('Photo set to slot', slotIndex);

                        if (retakeButtons[slotIndex]) {
                            retakeButtons[slotIndex].setAttribute('data-has-photo', 'true');
                            retakeButtons[slotIndex].parentElement.setAttribute('data-has-photo', 'true');
                        }
                        checkAllPhotosTaken();
                    } else {
                        console.error('Target slot not found for index:', slotIndex);
                    }
                };
                img.onerror = function() {
                    console.error('Failed to load image');
                };
                img.src = e.target.result;
            };
            reader.onerror = function() {
                console.error('Failed to read file');
            };
            reader.readAsDataURL(file);
        }

        function updateRetakeButtonsState() {
            retakeButtons = document.querySelectorAll('.retake-button');
            photoSlots = document.querySelectorAll('.photo-slot img');

            retakeButtons.forEach((button, index) => {
                if (index >= photoSlots.length) return;
                const hasPhoto = photoSlots[index] && photoSlots[index].src &&
                    photoSlots[index].src !== window.location.href &&
                    !photoSlots[index].src.endsWith('undefined') &&
                    photoSlots[index].src.length > 10;
                button.setAttribute('data-has-photo', hasPhoto ? 'true' : 'false');
                button.parentElement.setAttribute('data-has-photo', hasPhoto ? 'true' : 'false');
            });
            checkAllPhotosTaken();
        }

        function setupEventListeners() {
            console.log('Setting up event listeners...');
            if (captureButton) {
                captureButton.addEventListener('click', () => {
                    if (capturing) return;
                    const nextEmptySlot = findNextEmptySlot();
                    if (nextEmptySlot !== null) {
                        startCountdown(nextEmptySlot);
                    } else {
                        alert("All photo slots are filled. Please retake a photo or finish your session.");
                    }
                });
            }

            if (uploadButton && fileInput) {
                uploadButton.addEventListener('click', () => {
                    if (fileInput) {
                        fileInput.value = '';
                        fileInput.click();
                    }
                });
            }

            if (fileInput) {
                fileInput.addEventListener('change', (e) => {
                    console.log('File input change triggered:', e.target.files.length, Date.now());
                    if (e.target.files && e.target.files[0]) {
                        selectedFile = e.target.files[0];
                        console.log('File selected:', selectedFile.name);
                        if (uploadModal) {
                            uploadModal.style.display = 'flex';
                        }
                    } else {
                        console.log('No file selected');
                    }
                });
            }

            slotSelectButtons.forEach(button => {
                button.addEventListener('click', function() {
                    selectedSlotIndex = parseInt(this.getAttribute('data-slot'));
                    if (selectedFile && selectedSlotIndex !== null) {
                        processUploadedPhoto(selectedFile, selectedSlotIndex);
                        if (uploadModal) uploadModal.style.display = 'none';
                        if (fileInput) fileInput.value = '';
                        selectedFile = null;
                        selectedSlotIndex = null;
                    }
                });
            });

            if (uploadModalClose) {
                uploadModalClose.addEventListener('click', () => {
                    if (uploadModal) uploadModal.style.display = 'none';
                    if (fileInput) fileInput.value = '';
                    selectedFile = null;
                    selectedSlotIndex = null;
                });
            }

            document.querySelectorAll('.photo-slot-container').forEach((container, index) => {
                container.addEventListener('click', function() {
                    const hasPhoto = this.getAttribute('data-has-photo') === 'true';
                    if (hasPhoto && !capturing) {
                        const confirmRetake = confirm("Do you want to retake this photo?");
                        if (confirmRetake) {
                            if (photoSlots[index]) {
                                photoSlots[index].src = "";
                                photoSlots[index].removeAttribute('style');
                                if (retakeButtons[index]) {
                                    retakeButtons[index].setAttribute('data-has-photo', 'false');
                                    retakeButtons[index].parentElement.setAttribute('data-has-photo',
                                        'false');
                                }
                                checkAllPhotosTaken();
                                // Hapus startCountdown(index); agar tidak otomatis memulai countdown
                            }
                        }
                    }
                });
            });

            retakeButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation(); // Prevent triggering the container's click event
                    const index = parseInt(this.getAttribute('data-index'));
                    const hasPhoto = this.getAttribute('data-has-photo') === 'true';
                    if (hasPhoto && !capturing) {
                        const confirmRetake = confirm("Do you want to retake this photo?");
                        if (confirmRetake) {
                            if (photoSlots[index]) {
                                photoSlots[index].src = "";
                                photoSlots[index].removeAttribute('style');
                                this.setAttribute('data-has-photo', 'false');
                                this.parentElement.setAttribute('data-has-photo', 'false');
                                checkAllPhotosTaken();
                                // Hapus startCountdown(index); agar tidak otomatis memulai countdown
                            }
                        }
                    }
                });
            });

            if (finishButton) {
                finishButton.addEventListener('click', openPreviewModal);
            }

            if (modalClose) {
                modalClose.addEventListener('click', () => {
                    if (modal) modal.style.display = 'none';
                });
            }

            if (modalResetButton) modalResetButton.addEventListener('click', resetPhotos);
            if (modalDownloadButton) modalDownloadButton.addEventListener('click', downloadPhotoStrip);
            if (modalShareButton) modalShareButton.addEventListener('click', sharePhotoStrip);

            window.addEventListener('click', (e) => {
                if (modal && e.target === modal) {
                    modal.style.display = 'none';
                }
                if (uploadModal && e.target === uploadModal) {
                    uploadModal.style.display = 'none';
                    if (fileInput) fileInput.value = '';
                    selectedFile = null;
                    selectedSlotIndex = null;
                }
            });
        }

        function debugPhotoSlots() {
            photoSlots = document.querySelectorAll('.photo-slot img');
            console.log(`Debugging ${photoSlots.length} photo slots`);
            photoSlots.forEach((slot, index) => {
                console.log(`Slot ${index}:`, {
                    src: slot.src ? slot.src.substring(0, 50) + '...' : 'empty',
                    display: getComputedStyle(slot).display,
                    width: slot.width,
                    height: slot.height,
                    computed: {
                        width: getComputedStyle(slot).width,
                        height: getComputedStyle(slot).height
                    },
                    parentClasses: slot.parentElement ? slot.parentElement.className : 'no parent',
                    hasPhoto: retakeButtons[index] ? retakeButtons[index].getAttribute('data-has-photo') :
                        'no button'
                });
            });
        }

        // Perbarui fungsi initialize untuk menambahkan setup baru
        function initialize() {
            if (isInitialized) {
                console.log('Already initialized, skipping...');
                return;
            }
            isInitialized = true;

            console.log('Initializing photo booth...');
            photoSlots = document.querySelectorAll('.photo-slot img');
            retakeButtons = document.querySelectorAll('.retake-button');
            slotSelectButtons = document.querySelectorAll('.slot-select-button');

            initializeWebcam();
            setupFilterChange();
            setupMirrorToggle();
            setupCountdownSelect();
            setupEventListeners();
            updateRetakeButtonsState();
            updateCaptureButtonStyle(filterSelect.value); // Inisialisasi warna tombol
            debugPhotoSlots();
        }

        function updateCaptureButtonStyle(filterValue) {
            if (!captureButton) return;

            let borderColor, hoverBgColor;
            switch (filterValue) {
                case 'grayscale(100%)':
                    borderColor = 'border-gray-500';
                    hoverBgColor = 'hover:bg-gray-500';
                    break;
                case 'sepia(100%)':
                    borderColor = 'border-yellow-700';
                    hoverBgColor = 'hover:bg-yellow-700';
                    break;
                case 'contrast(150%)':
                    borderColor = 'border-red-500';
                    hoverBgColor = 'hover:bg-red-500';
                    break;
                case 'brightness(120%)':
                    borderColor = 'border-yellow-400';
                    hoverBgColor = 'hover:bg-yellow-400';
                    break;
                default:
                    borderColor = 'border-pink-300';
                    hoverBgColor = 'hover:bg-pink-300';
            }

            captureButton.className =
                `bg-white text-black border-2 ${borderColor} py-4 px-8 text-base font-semibold rounded-xl cursor-pointer transition-all duration-300 ease-in-out ${hoverBgColor} hover:scale-105`;
        }

        function setupFilterChange() {
            if (filterSelect) {
                filterSelect.addEventListener('change', () => {
                    if (video) {
                        video.style.filter = filterSelect.value;
                        updateCaptureButtonStyle(filterSelect.value);
                    }
                });
            }
        }

        // Fungsi untuk toggle mirror
        function setupMirrorToggle() {
            const mirrorToggle = document.getElementById('mirrorToggle');
            if (mirrorToggle) {
                mirrorToggle.addEventListener('click', () => {
                    isMirrored = !isMirrored;
                    video.style.transform = isMirrored ? 'scaleX(-1)' : 'scaleX(1)';
                    mirrorToggle.textContent = `Mirror: ${isMirrored ? 'On' : 'Off'}`;
                    mirrorToggle.classList.toggle('active', isMirrored);
                });
            }
        }

        // Fungsi untuk mengatur countdown
        function setupCountdownSelect() {
            const countdownSelect = document.getElementById('countdownSelect');
            if (countdownSelect) {
                countdownSelect.addEventListener('change', () => {
                    selectedCountdown = parseInt(countdownSelect.value);
                });
            }
        }

        document.addEventListener('DOMContentLoaded', initialize);
    </script>
</body>

</html>
