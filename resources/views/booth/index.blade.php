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

        .buttons {
            margin-top: 25px;
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
        }

        button:not(.retake-button) {
            background-color: #f5d0dc;
            color: #000;
            border: none;
            padding: 15px 30px;
            font-size: 16px;
            font-family: 'Roboto Condensed', sans-serif;
            font-weight: bold;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        button:not(.retake-button):hover {
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
            padding: 8px 12px;
            border-radius: 6px;
            background-color: #f5d0dc;
            border: 1px solid #ccc;
            font-family: 'Poppins', sans-serif;
        }

        .controls {
            margin-top: 20px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            justify-content: center;
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
            <button id="resetButton">🔁 Reset All</button>
            <button id="downloadButton">⬇ Download</button>

            <select id="filterSelect">
                <option value="none">No Filter</option>
                <option value="grayscale(100%)">Grayscale</option>
                <option value="sepia(100%)">Sepia</option>
                <option value="contrast(150%)">High Contrast</option>
                <option value="brightness(120%)">Bright</option>
            </select>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script>
        const video = document.getElementById('video');
        const photo1 = document.getElementById('photo1');
        const photo2 = document.getElementById('photo2');
        const photo3 = document.getElementById('photo3');
        const captureButton = document.getElementById('captureButton');
        const resetButton = document.getElementById('resetButton');
        const downloadButton = document.getElementById('downloadButton');
        const filterSelect = document.getElementById('filterSelect');
        const timerDisplay = document.getElementById('timer');
        const countdownOverlay = document.getElementById('countdown-overlay');
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        const retakeButtons = document.querySelectorAll('.retake-button');

        let currentPhotoIndex = null;
        const photos = [photo1, photo2, photo3];
        let countdown = 3;
        let timer;
        let capturing = false; // flag to prevent multiple clicks

        // Access webcam
        navigator.mediaDevices.getUserMedia({
                video: true
            })
            .then(stream => {
                video.srcObject = stream;
            })
            .catch(err => {
                console.error("Error accessing webcam: " + err);
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
        }

        // Find next empty photo slot
        function findNextEmptySlot() {
            for (let i = 0; i < photos.length; i++) {
                if (!photos[i].src || photos[i].src === window.location.href) {
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

            // Reset retake buttons state
            retakeButtons.forEach(button => {
                button.setAttribute('data-has-photo', 'false');
            });
        }

        // Download photo strip
        downloadButton.addEventListener('click', () => {
            html2canvas(document.querySelector('.photostrip')).then(canvas => {
                const dataUrl = canvas.toDataURL();
                const a = document.createElement('a');
                a.href = dataUrl;
                a.download = 'photo-strip.png';
                a.click();
            });
        });

        // Start capture process when capture button is clicked
        captureButton.addEventListener('click', () => {
            if (capturing) return; // Prevent clicks during countdown

            const nextEmptySlot = findNextEmptySlot();
            if (nextEmptySlot !== null) {
                startCountdown(nextEmptySlot);
            } else {
                alert("All photo slots are filled. Please retake a photo or reset all photos.");
            }
        });

        // Reset photos when reset button is clicked
        resetButton.addEventListener('click', resetPhotos);

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
        }

        // Add event listeners for retake buttons
        retakeButtons.forEach(button => {
            button.addEventListener('click', function() {
                const index = parseInt(this.getAttribute('data-index'));
                photos[index].src = "";
                this.setAttribute('data-has-photo', 'false');
            });
        });
    </script>
</body>

</html>
