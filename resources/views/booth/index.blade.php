<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Photo Strip Booth</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: #ffe8f0;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        header {
            width: 90%;
            margin: 20px auto;
            padding: 20px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            border-radius: 16px;
        }

        nav a {
            margin-left: 30px;
            text-decoration: none;
            color: #444;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #e91e63;
        }

        h1 {
            margin-bottom: 20px;
            font-weight: 600;
            color: #333;
        }

        .main-box {
            width: 90%;
            max-width: 1200px;
            background: url("bg.png") center center/cover no-repeat;
            padding: 40px;
            margin-top: 5px;
            border-radius: 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
            align-items: flex-start;
            justify-content: center;
        }

        .video-container {
            position: relative;
            width: 660px;
            height: 500px;
        }

        video {
            width: 100%;
            height: 100%;
            background-color: #ddd;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: scaleX(-1);
        }

        .countdown-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 120px;
            font-weight: bold;
            color: white;
            text-shadow: 0 0 10px rgba(0, 0, 0, 0.7);
            pointer-events: none;
        }

        .photostrip {
            width: 190px;
            height: 500px;
            background-color: #fff;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 10px;
            align-items: center;
        }

        .photo-slot-container {
            position: relative;
            width: 100%;
            height: 130px;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .photo-slot {
            position: relative;
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
            /* Hide image by default */
        }

        .photo-slot img[src]:not([src=""]) {
            display: block;
            /* Only show image when src is not empty */
        }

        /* Hover effect for photo slots */
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

        .retake-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: transparent;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            font-size: 20px;
            cursor: pointer;
            z-index: 10;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        /* Only show retake button on hover when photo exists */
        .photo-slot-container:hover .retake-button[data-has-photo="true"] {
            opacity: 1;
        }

        /* Hide retake button when no photo */
        .retake-button[data-has-photo="false"] {
            display: none;
        }

        .footer {
            padding-top: 10px;
        }

        .footer img {
            width: 90px;
            object-fit: contain;
        }

        .controls {
            margin-top: 20px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: center;
        }

        button:not(.retake-button):not(.modal-close) {
            background-color: #f5d0dc;
            color: #000;
            border: none;
            padding: 15px 30px;
            font-size: 16px;
            font-family: 'Poppins', sans-serif;
            font-weight: bold;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:not(.retake-button):not(.modal-close):hover {
            background-color: #dd6a91;
            transform: scale(1.05);
        }

        #timer {
            font-size: 32px;
            font-weight: bold;
            color: #444;
            margin-top: 15px;
        }

        select {
            padding: 14px 12px;
            border-radius: 10px;
            background-color: #f5d0dc;
            border: none;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        select:hover {
            background-color: #dd6a91;
        }

        canvas {
            display: none;
        }

        .fun-text {
            font-size: 3rem;
            font-weight: bold;
            letter-spacing: 4px;
        }

        .fun-text span:nth-child(1) {
            color: #C93F3F;
        }

        .fun-text span:nth-child(2) {
            color: #F48FB1;
        }

        .fun-text span:nth-child(3) {
            color: #81C784;
        }

        .fun-text span:nth-child(4) {
            color: #FFD54F;
        }

        .fun-text span:nth-child(5) {
            color: #4FC3F7;
        }

        .fun-text span:nth-child(6) {
            color: #BA68C8;
        }

        .fun-text span:nth-child(7) {
            color: #FFD54F;
        }

        .fun-text span:nth-child(8) {
            color: #90CAF9;
        }

        .fun-text span:nth-child(9) {
            color: #A5D6A7;
        }

        .fun-text span:nth-child(10) {
            color: #FF8A65;
        }

        .fun-text span:nth-child(11) {
            color: #BA68C8;
        }

        .fun-text span:nth-child(12) {
            color: #F48FB1;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            overflow: auto;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fff;
            margin: auto;
            width: 80%;
            max-width: 800px;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            animation: modalFadeIn 0.4s;
            padding: 30px;
            position: relative;
            display: flex;
            flex-direction: column;
            align-items: center;
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

        .modal-close {
            position: absolute;
            top: 15px;
            right: 15px;
            font-size: 28px;
            font-weight: bold;
            color: #888;
            cursor: pointer;
            background: none;
            border: none;
            transition: color 0.3s;
        }

        .modal-close:hover {
            color: #000;
        }

        .preview-title {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .preview-container {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
        }

        .preview-photostrip {
            width: 300px;
            height: auto;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .modal-buttons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .share-button {
            background-color: #4267B2 !important;
            color: white !important;
        }

        .download-button {
            background-color: #28a745 !important;
            color: white !important;
        }

        .reset-button {
            background-color: #dc3545 !important;
            color: white !important;
        }

        /* For the finish button that will show only when 3 photos are taken */
        #finishButton {
            display: none;
            background-color: #28a745;
            color: white;
        }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <img src="logo4.png" alt="Logo" style="height: 50px;">
        </div>
        <nav>
            <a href="#">home</a>
            <a href="#">about</a>
            <a href="#layout-template">layout</a>
        </nav>
    </header>

    <div class="main-box">
        <h1 class="fun-text">
            <span>C</span><span>A</span><span>P</span><span>T</span><span>U</span><span>R</span><span>E</span>
            <span>T</span><span>I</span><span>M</span><span>E</span><span>!</span>
        </h1>

        <div class="container">
            <div class="video-container">
                <video id="video" autoplay></video>
                <div id="countdown-overlay" class="countdown-overlay"></div>
            </div>

            <div class="photostrip">
                <div class="photo-slot-container">
                    <div class="photo-slot">
                        <img id="photo1" src="">
                    </div>
                    <button class="retake-button" data-index="0">⟲</button>
                </div>

                <div class="photo-slot-container">
                    <div class="photo-slot">
                        <img id="photo2" src="">
                    </div>
                    <button class="retake-button" data-index="1">⟲</button>
                </div>

                <div class="photo-slot-container">
                    <div class="photo-slot">
                        <img id="photo3" src="">
                    </div>
                    <button class="retake-button" data-index="2">⟲</button>
                </div>

                <div class="footer">
                    <img src="logo4.png" alt="Logo">
                </div>
            </div>
        </div>

        <div id="timer"></div>

        <div class="controls">
            <button id="captureButton">📷 Take Photo</button>
            <select id="filterSelect">
                <option value="none">No Filter</option>
                <option value="grayscale(100%)">Grayscale</option>
                <option value="sepia(100%)">Sepia</option>
                <option value="contrast(150%)">High Contrast</option>
                <option value="brightness(120%)">Bright</option>
            </select>
            <button id="finishButton">✅ Selesai</button>
        </div>
    </div>

    <!-- Modal for photostrip preview -->
    <div id="previewModal" class="modal">
        <div class="modal-content">
            <button class="modal-close">&times;</button>
            <h2 class="preview-title">Preview Photo Strip</h2>

            <div class="preview-container">
                <div class="preview-photostrip" id="modalPhotostrip">
                    <!-- Photostrip will be cloned here by JS -->
                </div>
            </div>

            <div class="modal-buttons">
                <button id="modalResetButton" class="reset-button">🔁 Reset All</button>
                <button id="modalDownloadButton" class="download-button">⬇ Download</button>
                <button id="modalShareButton" class="share-button">📤 Share</button>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        const video = document.getElementById('video');
        const photo1 = document.getElementById('photo1');
        const photo2 = document.getElementById('photo2');
        const photo3 = document.getElementById('photo3');
        const captureButton = document.getElementById('captureButton');
        const finishButton = document.getElementById('finishButton');
        const filterSelect = document.getElementById('filterSelect');
        const timerDisplay = document.getElementById('timer');
        const countdownOverlay = document.getElementById('countdown-overlay');
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        const retakeButtons = document.querySelectorAll('.retake-button');

        // Modal elements
        const modal = document.getElementById('previewModal');
        const modalClose = document.querySelector('.modal-close');
        const modalPhotostrip = document.getElementById('modalPhotostrip');
        const modalResetButton = document.getElementById('modalResetButton');
        const modalDownloadButton = document.getElementById('modalDownloadButton');
        const modalShareButton = document.getElementById('modalShareButton');

        let currentPhotoIndex = null;
        const photos = [photo1, photo2, photo3];
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
                "Failed to access webcam. Please make sure your camera is connected and permissions are granted.");
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
            photos[currentPhotoIndex].src = dataUrl;

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
            for (let i = 0; i < photos.length; i++) {
                if (!photos[i].src || photos[i].src === window.location.href || photos[i].src.length < 10) {
                    allTaken = false;
                    break;
                }
            }

            // Show or hide the finish button based on whether all photos are taken
            finishButton.style.display = allTaken ? 'block' : 'none';
        }

        // Find next empty photo slot
        function findNextEmptySlot() {
            for (let i = 0; i < photos.length; i++) {
                if (!photos[i].src || photos[i].src === window.location.href || photos[i].src.length < 10) {
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
            photos.forEach(photo => photo.src = "");
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

        // Download photo strip
        function downloadPhotoStrip() {
            html2canvas(document.querySelector('.photostrip')).then(canvas => {
                photoStripImage = canvas.toDataURL();
                const a = document.createElement('a');
                a.href = photoStripImage;
                a.download = 'photo-strip.png';
                a.click();
            });
        }

        // Share photo strip
        function sharePhotoStrip() {
            if (navigator.share && photoStripImage) {
                // Get the blob from the data URL
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
            } else {
                alert('Web Share API not supported in your browser or no image available. Please download instead.');
            }
        }

        // Open modal with photostrip preview
        function openPreviewModal() {
            // Create a preview of the photostrip in the modal
            html2canvas(document.querySelector('.photostrip')).then(canvas => {
                photoStripImage = canvas.toDataURL();

                // Clear previous content
                modalPhotostrip.innerHTML = '';

                // Create an image element with the photostrip
                const img = document.createElement('img');
                img.src = photoStripImage;
                img.style.width = '100%';
                modalPhotostrip.appendChild(img);

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
                const hasPhoto = photos[index].src &&
                    photos[index].src !== window.location.href &&
                    !photos[index].src.endsWith('undefined') &&
                    photos[index].src.length > 10;

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
                photos[index].src = "";
                this.setAttribute('data-has-photo', 'false');

                // Check if all photos are still taken
                checkAllPhotosTaken();
            });
        });
    </script>
</body>

</html>
