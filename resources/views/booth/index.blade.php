<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
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

    video {
      width: 660px;
      height: 500px;
      background-color: #ddd;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      transform: scaleX(-1);
    }

    .photostrip {
      width: 190px;
      height: 500px;
      background-color: #fff;
      box-shadow: 0 6px 18px rgba(0,0,0,0.15);
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 10px;
      align-items: center;
    }

    .photo-slot {
      width: 100%;
      height: 130px;
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

    button {
      background-color: #f5d0dc;  /* Warna latar belakang lebih cerah */
      color: #000;
      border: none;
      padding: 15px 30px;  /* Lebih besar dari sebelumnya */
      font-size: 16px;
      font-family: 'Roboto Condensed', sans-serif;
      font-weight: bold;
      border-radius: 10px;  /* Sudut yang lebih membulat */
      cursor: pointer;
      transition: all 0.3s ease;  /* Efek transisi yang halus */
    }

    button:hover {
      background-color: #dd6a91;  /* Warna latar belakang saat hover */
      transform: scale(1.05);  /* Membesar sedikit saat hover */
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

    .fun-text span:nth-child(1) { color: #C93F3F; }
    .fun-text span:nth-child(2) { color: #F48FB1; }
    .fun-text span:nth-child(3) { color: #81C784; }
    .fun-text span:nth-child(4) { color: #FFD54F; }
    .fun-text span:nth-child(5) { color: #4FC3F7; }
    .fun-text span:nth-child(6) { color: #BA68C8; }
    .fun-text span:nth-child(7) { color: #FFD54F; }
    .fun-text span:nth-child(8) { color: #90CAF9; }
    .fun-text span:nth-child(9) { color: #A5D6A7; }
    .fun-text span:nth-child(10) { color: #FF8A65; }
    .fun-text span:nth-child(11) { color: #BA68C8; }
    .fun-text span:nth-child(12) { color: #F48FB1; }
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
      <video id="video" autoplay></video>
      <div class="relative w-4/5 flex-grow items-center   justify-center mx-auto">
        <div class="absolute inset-0 rounded-xl shadow-md bg-gray-100 overflow-hidden">
            <!-- Frame template will be loaded here -->
            <div id="frame-preview" class="absolute inset-0">
                @include($templatePath)
            </div>
        </div>
    </div>
    </div>

    <div id="timer"></div>

    <div class="controls">
      <button id="captureButton">📷 Capture</button>
      <button id="resetButton">🔁 Reset</button>
      <button id="downloadButton">⬇️ Download</button>

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
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');

    let photoIndex = 0;
    const photos = [photo1, photo2, photo3];
    let countdown = 3;
    let timer;
    let capturing = false;  // flag to prevent multiple clicks

    // Access webcam
    navigator.mediaDevices.getUserMedia({ video: true })
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
      if (photoIndex >= 3) return;
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;
      ctx.save();
      ctx.translate(canvas.width, 0); // flip horizontally
      ctx.scale(-1, 1); // mirror
      ctx.filter = getComputedStyle(video).filter;
      ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
      ctx.restore();
      const dataUrl = canvas.toDataURL();
      photos[photoIndex].src = dataUrl;
      photoIndex++;
    }

    // Timer countdown
    function startCountdown() {
      if (capturing) return; // Prevent starting again if already capturing
      capturing = true;

      photoIndex = 0;
      countdown = 3;
      timerDisplay.textContent = countdown;
      timer = setInterval(() => {
        countdown--;
        if (countdown > 0) {
          timerDisplay.textContent = countdown;
        } else {
          capturePhoto();
          if (photoIndex < 3) {
            countdown = 4;  // Reset countdown after photo taken
          } else {
            clearInterval(timer);
            timerDisplay.textContent = ""; // Hide timer after 3 photos
            capturing = false;
          }
        }
      }, 1000);
    }

    // Reset photos and countdown
    function resetPhotos() {
      clearInterval(timer);
      capturing = false;
      photoIndex = 0;
      photos.forEach(photo => photo.src = "");
      timerDisplay.textContent = "";
    }

    // Download photo strip
    downloadButton.addEventListener('click', () => {
      html2canvas(document.querySelector('.container')).then(canvas => {
        const dataUrl = canvas.toDataURL();
        const a = document.createElement('a');
        a.href = dataUrl;
        a.download = 'photo-strip.png';
        a.click();
      });
    });

    // Start capture process when capture button is clicked
    captureButton.addEventListener('click', startCountdown);

    // Reset photos when reset button is clicked
    resetButton.addEventListener('click', resetPhotos);
  </script>
</body>
</html>
