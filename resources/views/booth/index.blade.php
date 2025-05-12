{{-- index.blade.php --}}

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
    <header class="w-[90%] mx-auto my-5 p-5 px-12 flex justify-between items-center bg-white shadow-lg rounded-2xl">
        <div class="logo">
            <img src="/img/logo4.png" alt="Logo" class="h-12">
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
        <h1 class="mb-5 font-semibold text-gray-800 text-5xl">
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
            {{-- frame right side --}}
            <div class="w-[190px] h-[500px] relative frame-container">
                <div id="frameTemplate" class="w-full h-full relative">
                    <!-- This is where the frame template will be included -->
                    @include($templatePath, ['frame' => $frame])
                </div>
            </div>
        </div>

        <div id="timer" class="text-3xl font-bold text-gray-700 mt-4"></div>

        <div class="mt-5 flex gap-3 flex-wrap justify-center">
            <button id="captureButton"
                class="bg-pink-200 text-black border-none py-4 px-8 text-base font-bold rounded-xl cursor-pointer transition-all duration-300 ease-in-out hover:bg-pink-400 hover:scale-105">📷
                Take Photo</button>
            <select id="filterSelect"
                class="py-3.5 px-3 rounded-xl bg-pink-200 border-none text-base font-bold cursor-pointer transition-all duration-300 ease-in-out hover:bg-pink-400">
                <option value="none">No Filter</option>
                <option value="grayscale(100%)">Grayscale</option>
                <option value="sepia(100%)">Sepia</option>
                <option value="contrast(150%)">High Contrast</option>
                <option value="brightness(120%)">Bright</option>
            </select>
            <button id="finishButton"
                class="hidden bg-green-600 text-white border-none py-4 px-8 text-base font-bold rounded-xl cursor-pointer transition-all duration-300 ease-in-out hover:bg-green-700 hover:scale-105">✅
                Selesai</button>
        </div>
    </div>

    <!-- Modal for photostrip preview -->
    <div id="previewModal"
        class="hidden fixed z-50 left-0 top-0 w-full h-full bg-black bg-opacity-70 overflow-auto justify-center items-center">
        <div
            class="bg-white mx-auto w-4/5 max-w-[800px] rounded-3xl shadow-lg p-8 relative flex flex-col items-center animate-[modalFadeIn_0.4s]">
            <button
                class="modal-close absolute top-4 right-4 text-3xl font-bold text-gray-400 bg-transparent border-none cursor-pointer hover:text-black">&times;</button>
            <h2 class="text-2xl mb-5 text-gray-800">Preview Photo Strip</h2>

            <div class="w-full flex justify-center mb-8">
                <div class="w-[180px] shadow-md" id="modalPhotostrip">
                    <!-- Photostrip will be cloned here by JS -->
                </div>
            </div>

            <div class="flex gap-4 mt-5">
                <button id="modalResetButton"
                    class="bg-red-600 text-white border-none py-4 px-8 text-base font-bold rounded-xl cursor-pointer transition-all duration-300 ease-in-out hover:bg-red-700 hover:scale-105">🔁
                    Reset All</button>
                <button id="modalDownloadButton"
                    class="bg-green-600 text-white border-none py-4 px-8 text-base font-bold rounded-xl cursor-pointer transition-all duration-300 ease-in-out hover:bg-green-700 hover:scale-105">⬇
                    Download</button>
                <button id="modalShareButton"
                    class="bg-blue-600 text-white border-none py-4 px-8 text-base font-bold rounded-xl cursor-pointer transition-all duration-300 ease-in-out hover:bg-blue-700 hover:scale-105">📤
                    Share</button>
            </div>
        </div>
    </div>

    <!-- Hidden field to store frame ID -->
    <input type="hidden" id="frameId" value="{{ $frame->id }}">

    <style>
        /* Adding keyframes animation for modal since Tailwind doesn't have it built-in */
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

        .photo-slot-container:hover .photo-slot::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.2);
            pointer-events: none;
        }

        .photo-slot:hover .retake-button {
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
            background-color: transparent;
            /* kontras! */
            color: white;
            border: none;
            padding: 10px 12px;
            border-radius: 50%;
            font-size: 20px;
            z-index: 10;
            cursor: pointer;
        }

        [data-photo-index]:hover img {
            filter: blur(2px);
            transform: scale(1.05);
            transition: all 0.3s ease;
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        const video = document.getElementById('video');
        const captureButton = document.getElementById('captureButton');
        const finishButton = document.getElementById('finishButton');
        const filterSelect = document.getElementById('filterSelect');
        const timerDisplay = document.getElementById('timer');
        const countdownOverlay = document.getElementById('countdown-overlay');
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');

        // Get all photo slots and retake buttons
        const photoSlots = document.querySelectorAll('.photo-slot img');
        const retakeButtons = document.querySelectorAll('.retake-button');
        const frameId = document.getElementById('frameId').value;

        // Modal elements
        const modal = document.getElementById('previewModal');
        const modalClose = document.querySelector('.modal-close');
        const modalPhotostrip = document.getElementById('modalPhotostrip');
        const modalResetButton = document.getElementById('modalResetButton');
        const modalDownloadButton = document.getElementById('modalDownloadButton');
        const modalShareButton = document.getElementById('modalShareButton');

        let currentPhotoIndex = null;
        let countdown = 3;
        let timer;
        let capturing = false; // flag to prevent multiple clicks
        let photoStripImage = null; // to store the photostrip image for sharing

        // Access webcam
        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(err => {
                console.error("Error accessing webcam: " + err);
                alert(
                    "Failed to access webcam. Please make sure your camera is connected and permissions are granted."
                );
            });

        // Apply filter
        filterSelect.addEventListener('change', () => {
            video.style.filter = filterSelect.value;
        });

        // Capture photo
        function capturePhoto() {
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            ctx.save();
            ctx.translate(canvas.width, 0); // flip horizontally
            ctx.scale(-1, 1); // mirror
            ctx.filter = getComputedStyle(video).filter;
            ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
            ctx.restore();
            const dataUrl = canvas.toDataURL();
            photoSlots[currentPhotoIndex].src = dataUrl;

            // Update retake button state
            retakeButtons[currentPhotoIndex].setAttribute('data-has-photo', 'true');

            // Change button text back
            captureButton.textContent = "📷 Take Photo";
            capturing = false;

            // Check if all photos are taken
            checkAllPhotosTaken();
        }

        // Check if all photos are taken and show finish button
        function checkAllPhotosTaken() {
            let allTaken = true;
            for (let i = 0; i < photoSlots.length; i++) {
                if (!photoSlots[i].src || photoSlots[i].src === window.location.href || photoSlots[i].src.length < 10) {
                    allTaken = false;
                    break;
                }
            }

            // Show or hide the finish button based on whether all photos are taken
            finishButton.style.display = allTaken ? 'block' : 'none';
        }

        // Find next empty photo slot
        function findNextEmptySlot() {
            for (let i = 0; i < photoSlots.length; i++) {
                if (!photoSlots[i].src || photoSlots[i].src === window.location.href || photoSlots[i].src.length < 10) {
                    return i;
                }
            }
            return null; // All slots filled
        }

        // Timer countdown
        function startCountdown(photoIndex) {
            if (capturing) return; // Prevent starting again if already capturing
            capturing = true;
            currentPhotoIndex = photoIndex;

            countdown = 3;
            countdownOverlay.textContent = countdown;
            captureButton.textContent = "Capturing...";

            timer = setInterval(() => {
                countdown--;
                if (countdown > 0) {
                    countdownOverlay.textContent = countdown;
                } else {
                    clearInterval(timer);
                    countdownOverlay.textContent = "";
                    capturePhoto();
                }
            }, 1000);
        }

        // Reset photos and countdown
        function resetPhotos() {
            clearInterval(timer);
            capturing = false;
            countdownOverlay.textContent = "";
            photoSlots.forEach(photo => photo.src = "");
            timerDisplay.textContent = "";
            captureButton.textContent = "📷 Take Photo";
            finishButton.style.display = 'none';

            // Reset retake buttons state
            retakeButtons.forEach(button => {
                button.setAttribute('data-has-photo', 'false');
            });

            // Close modal if open
            modal.style.display = 'none';
        }

        // Helper function to get all photo data
        function getAllPhotoData() {
            const photos = [];
            photoSlots.forEach(slot => {
                if (slot.src && slot.src !== window.location.href && slot.src.length > 10) {
                    photos.push(slot.src);
                }
            });
            return photos;
        }

        // Save photos to server
        function savePhotos(finalImage) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('{{ route('savePhoto') }}', {
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
                        // Set download URL to the one provided by the server
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

        // Download photo strip
        function downloadPhotoStrip() {
            if (photoStripImage && photoStripImage.startsWith('http')) {
                // If we have a URL from the server, use it directly
                const a = document.createElement('a');
                a.href = photoStripImage;
                a.download = 'photo-strip.png';
                a.click();
            } else {
                // Otherwise generate a new image
                html2canvas(document.querySelector('.frame-container')).then(canvas => {
                    photoStripImage = canvas.toDataURL();
                    const a = document.createElement('a');
                    a.href = photoStripImage;
                    a.download = 'photo-strip.png';
                    a.click();
                });
            }
        }

        // Share photo strip
        function sharePhotoStrip() {
            if (navigator.share && photoStripImage) {
                // If it's a URL from the server
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
                    // If it's a Data URL
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
                alert('Web Share API not supported in your browser or no image available. Please download instead.');
            }
        }

        // Open modal with photostrip preview
        function openPreviewModal() {
            // Create a preview of the photostrip in the modal
            html2canvas(document.querySelector('.frame-container')).then(canvas => {
                const imageData = canvas.toDataURL();

                // Save photos to server
                savePhotos(imageData);

                // Clear previous content
                modalPhotostrip.innerHTML = '';

                // Create an image element with the photostrip
                const img = document.createElement('img');
                img.src = imageData;
                img.style.width = '100%';
                modalPhotostrip.appendChild(img);

                // Set the photostrip image for download/share
                photoStripImage = imageData;

                // Show the modal
                modal.style.display = 'flex';
            });
        }

        // Start capture process when capture button is clicked
        captureButton.addEventListener('click', () => {
            if (capturing) return; // Prevent clicks during countdown

            const nextEmptySlot = findNextEmptySlot();
            if (nextEmptySlot !== null) {
                startCountdown(nextEmptySlot);
            } else {
                alert("All photo slots are filled. Please retake a photo or finish your session.");
            }
        });

        // Open modal when finish button is clicked
        finishButton.addEventListener('click', openPreviewModal);

        // Modal close button
        modalClose.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        // Close modal when clicking outside of it
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Modal buttons event listeners
        modalResetButton.addEventListener('click', resetPhotos);
        modalDownloadButton.addEventListener('click', downloadPhotoStrip);
        modalShareButton.addEventListener('click', sharePhotoStrip);

        // Initialize retake buttons state
        updateRetakeButtonsState();

        // Function to update retake buttons visibility
        function updateRetakeButtonsState() {
            retakeButtons.forEach((button, index) => {
                // Check if image has valid src
                const hasPhoto = photoSlots[index].src &&
                    photoSlots[index].src !== window.location.href &&
                    !photoSlots[index].src.endsWith('undefined') &&
                    photoSlots[index].src.length > 10;

                if (hasPhoto) {
                    button.setAttribute('data-has-photo', 'true');
                } else {
                    button.setAttribute('data-has-photo', 'false');
                }
            });

            // Also check if all photos are taken
            checkAllPhotosTaken();
        }

        // Add event listeners for retake buttons
        retakeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const index = parseInt(this.getAttribute('data-index'));
                photoSlots[index].src = "";
                this.setAttribute('data-has-photo', 'false');

                // Check if all photos are still taken
                checkAllPhotosTaken();
            });
        });
    </script>
</body>

</html>
