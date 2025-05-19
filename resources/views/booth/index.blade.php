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

    <body class="m-0 font-['Poppins'] bg-[#FEF3E2] flex flex-col items-center relative min-h-screen">


        <!-- Main Content -->
        <div class="w-full max-w-7xl py-10 px-4 sm:px-6 lg:px-8 flex flex-col items-center relative z-20">
            <h1 class="mb-5 font-extrabold text-gray-900 text-4xl sm:text-5xl lg:text-6xl">
                Capture Your Moments!
            </h1>

            <div class="flex flex-col md:flex-row gap-8 md:gap-20 items-start justify-center ">
                <!-- Camera Section with responsive sizing -->
                <div class="w-full md:w-auto">
                    <!-- Camera container with fixed aspect ratio -->
                    <div class="relative mx-auto" style="width: min(90vw, 660px); max-width: 660px; aspect-ratio: 4/3;">
                        <video id="video" autoplay
                            class="w-full h-full bg-gray-200 rounded-xl shadow-md scale-x-[-1] object-cover"></video>
                        <div id="countdown-overlay"
                            class="absolute top-0 left-0 w-full h-full flex justify-center items-center text-8xl font-bold text-white pointer-events-none"
                            style="text-shadow: 0 0 10px rgba(0, 0, 0, 0.7);"></div>
                    </div>
                    <div class=" flex justify-center items-center gap-4 mt-5">
                        <select id="filterSelect"
                            class="py-2 px-3 sm:py-2.5 sm:px-4 rounded-xl bg-white text-sm sm:text-base font-medium cursor-pointer border-2 border-[#BF3131] transition-all duration-300 ease-in-out hover:bg-[#F16767] hover:text-white w-auto">
                            <option value="none">No Filter</option>
                            <option value="grayscale(100%)">Grayscale</option>
                            <option value="sepia(100%)">Sepia</option>
                            <option value="contrast(150%)">High Contrast</option>
                            <option value="brightness(120%)">Bright</option>
                        </select>

                        <button id="mirrorToggle"
                            class="bg-[#BF3131] text-white border border-transparent py-2 px-3 sm:py-2.5 sm:px-4 text-sm sm:text-base font-semibold rounded-xl cursor-pointer transition-all duration-300 ease-in-out hover:bg-[#F16767] hover:scale-105 shadow-sm hover:shadow-lg w-auto">
                            Mirror: Off
                        </button>
                        <select id="countdownSelect"
                            class="py-2 px-3 sm:py-2.5 sm:px-4 rounded-xl bg-white text-sm sm:text-base font-medium cursor-pointer border-2 border-[#BF3131] transition-all duration-300 ease-in-out hover:bg-[#F16767] hover:text-white w-auto">
                            <option value="3">3 Seconds</option>
                            <option value="5">5 Seconds</option>
                            <option value="0">No Countdown</option>
                        </select>
                    </div>

                    <!-- Capture Buttons -->
                    <div class="w-full flex flex-wrap justify-center items-center gap-4 mt-5">
                        <button id="captureButton"
                            class="bg-[#BF3131] text-white border border-transparent py-3 px-6 text-base font-semibold rounded-xl cursor-pointer transition-all duration-300 ease-in-out hover:bg-[#F16767] hover:scale-105 shadow-sm hover:shadow-lg">
                            Start Capture
                        </button>

                        <button id="uploadButton"
                            class="bg-[#BF3131] text-white border border-transparent py-3 px-6 text-base font-semibold rounded-xl cursor-pointer transition-all duration-300 ease-in-out hover:bg-[#F16767] hover:scale-105 shadow-sm hover:shadow-lg">
                            Upload Photo
                        </button>

                        <input type="file" id="fileInput" accept="image/*" class="hidden">
                    </div>
                </div>

                <!-- Photo Strip Frame -->
                <div class="w-[190px] h-[500px] relative frame-container">
                    <div id="frameTemplate" class="w-full h-full relative bg-white rounded-lg shadow-lg">
                        @include($templatePath, ['frame' => $frame])
                    </div>
                    <div class="flex flex-col justify-center items-center gap-4 mt-5">
                        <button id="resetButton"
                            class="bg-[#BF3131] text-white border border-transparent py-2 px-3 sm:py-2.5 sm:px-4 text-sm sm:text-base font-semibold rounded-xl cursor-pointer transition-all duration-300 ease-in-out hover:bg-[#F16767] hover:scale-105 shadow-sm hover:shadow-lg w-full sm:w-auto">
                            🔁 Reset
                        </button>
                        <button id="finishButton"
                            class="hidden bg-[#BF3131] text-white border border-transparent py-2 px-3 sm:py-2.5 sm:px-4 text-sm sm:text-base font-semibold rounded-xl cursor-pointer transition-all duration-300 ease-in-out hover:bg-[#F16767] hover:scale-105 shadow-sm hover:shadow-lg w-full sm:w-auto">
                            Selesai
                        </button>
                    </div>
                </div>
            </div>

            <div id="timer" class="text-3xl font-bold text-gray-700 mt-4"></div>
        </div>

        <!-- Upload Modal -->
        <div id="uploadModal"
            class="hidden fixed z-50 left-0 top-0 w-full h-full bg-black bg-opacity-70 overflow-auto justify-center items-center">
            <div
                class="bg-[#FEF3E2] mx-auto w-4/5 max-w-[600px] rounded-3xl shadow-lg p-8 relative flex flex-col items-center animate-[modalFadeIn_0.4s]">
                <button
                    class="upload-modal-close absolute top-4 right-4 text-3xl font-bold text-gray-400 bg-transparent border-none cursor-pointer hover:text-black">×</button>
                <h2 class="text-2xl mb-5 text-gray-800 font-bold">Select Photo Slot</h2>
                <p class="mb-5 text-gray-600">Choose which slot to place your uploaded photo:</p>
                <div class="flex gap-4 justify-center mb-6">
                    <button
                        class="slot-select-button bg-[#BF3131] text-white border-none py-3 px-6 text-base font-medium rounded-xl cursor-pointer hover:bg-[#F16767] shadow-sm hover:shadow-lg"
                        data-slot="0">Slot 1</button>
                    <button
                        class="slot-select-button bg-[#BF3131] text-white border-none py-3 px-6 text-base font-medium rounded-xl cursor-pointer hover:bg-[#F16767] shadow-sm hover:shadow-lg"
                        data-slot="1">Slot 2</button>
                    <button
                        class="slot-select-button bg-[#BF3131] text-white border-none py-3 px-6 text-base font-medium rounded-xl cursor-pointer hover:bg-[#F16767] shadow-sm hover:shadow-lg"
                        data-slot="2">Slot 3</button>
                </div>
            </div>
        </div>

        <!-- Preview Modal -->
        <div id="previewModal"
            class="hidden fixed z-50 left-0 top-0 w-full h-full bg-black bg-opacity-70 overflow-auto justify-center items-center">
            <div
                class="bg-[#FEF3E2] mx-auto w-4/5 max-w-[800px] rounded-3xl shadow-lg p-8 relative flex flex-col items-center animate-[modalFadeIn_0.4s]">
                <button
                    class="modal-close absolute top-4 right-4 text-3xl font-bold text-gray-400 bg-transparent border-none cursor-pointer hover:text-black">×</button>
                <h2 class="text-2xl mb-5 text-gray-800 font-bold">Preview Photo Strip</h2>
                <div class="w-full flex justify-center mb-8">
                    <div class="w-[180px] shadow-md" id="modalPhotostrip"></div>
                </div>
                <div class="flex flex-wrap gap-4 mt-5 justify-center">
                    <button id="modalDownloadButton"
                        class="bg-[#BF3131] text-white border-none py-3 px-6 text-base font-medium rounded-xl cursor-pointer transition-all duration-300 ease-in-out hover:bg-[#F16767] hover:scale-105 shadow-sm hover:shadow-lg">⬇
                        Download</button>
                    <button id="modalShareButton"
                        class="bg-[#BF3131] text-white border-none py-3 px-6 text-base font-medium rounded-xl cursor-pointer transition-all duration-300 ease-in-out hover:bg-[#F16767] hover:scale-105 shadow-sm hover:shadow-lg">📤
                        Share</button>
                </div>
            </div>
        </div>

        <input type="hidden" id="frameId" value="{{ $frame->id }}">

        <style>
            /* Responsive adjustments for buttons and selects */
            @media (max-width: 640px) {

                #filterSelect,
                #countdownSelect,
                #mirrorToggle,
                #resetButton,
                #finishButton {
                    font-size: 0.875rem;
                    /* Smaller font size for mobile */
                    padding: 0.5rem 0.75rem;
                    /* Reduced padding for mobile */
                    width: 100%;
                    /* Full width on mobile */
                    margin-bottom: 0.5rem;
                    /* Space between stacked buttons */
                }
            }

            @media (min-width: 640px) {

                #filterSelect,
                #countdownSelect,
                #mirrorToggle,
                #resetButton,
                #finishButton {
                    min-width: 120px;
                    /* Minimum width for larger screens */
                }
            }

            /* Ensure controls stack nicely on smaller screens */
            .w-full.sm\:w-auto {
                width: 100%;
            }

            @media (min-width: 640px) {
                .w-full.sm\:w-auto {
                    width: auto;
                }
            }

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
                background-color: #F16767;
                border-color: #BF3131;
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
                background-color: rgba(191, 49, 49, 0.7);
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

            .photo-slot-container:hover .photo-slot::after {
                content: "";
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.4);
                pointer-events: none;
            }

            .retake-button:hover {
                background-color: rgba(191, 49, 49, 0.9);
                transform: translate(-50%, -50%) scale(1.1);
            }

            [data-photo-index]:hover img {
                filter: blur(2px);
                transform: scale(1.05);
                transition: all 0.3s ease;
            }

            /* Ensure the video maintains 4:3 aspect ratio */
            @media (max-width: 768px) {
                #video {
                    width: 100%;
                    height: 100%;
                    object-fit: cover;
                }
            }

            .frame-container {
                align-self: center;
                /* Center by default for mobile */
            }

            /* Mobile: Center the frame horizontally and vertically */
            @media (max-width: 767px) {
                .frame-container {
                    margin-left: auto;
                    margin-right: auto;
                }
            }

            /* Desktop: Align the frame to the top */
            @media (min-width: 768px) {
                .frame-container {
                    align-self: start;
                    /* Stick to the top in flex-row */
                    margin-top: 0 !important;
                    /* Remove any residual margin */
                }
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
            let resetButton = document.getElementById('resetButton');
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

            let isMirrored = true;
            let selectedCountdown = 3;

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
                        video: {
                            aspectRatio: 4 / 3,
                            facingMode: 'user'
                        }
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

            function startCountdown(photoIndex) {
                if (capturing) return;
                capturing = true;
                currentPhotoIndex = photoIndex;

                countdown = selectedCountdown;
                if (countdownOverlay) countdownOverlay.textContent = countdown;

                if (captureButton) {
                    captureButton.innerHTML = 'Capturing...';
                }

                if (selectedCountdown === 0) {
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
                    savePhotos(imageData); // This calls the /savePhoto endpoint

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
                            // Optional: Log or display the updated 'used' count
                            console.log('Frame used count:', data.frame_info.used);
                        } else {
                            console.error('Error saving photos');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
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
                                }
                            }
                        }
                    });
                });

                retakeButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.stopPropagation();
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

                if (resetButton) resetButton.addEventListener('click', resetPhotos);
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
                debugPhotoSlots();
            }

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
