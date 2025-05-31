<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testimoni Pelanggan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .testimonial-card {
            min-width: 380px;
            max-width: 380px;
            min-height: 320px;
            transition: all 0.4s ease;
            backdrop-filter: blur(15px);
            border: 3px solid #BF3131;
            position: relative;
            overflow: hidden;
            white-space: normal; /* Allow text wrapping inside cards */
            display: flex;
            flex-direction: column;
        }

        .testimonial-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(191, 49, 49, 0.1), transparent);
            transition: left 0.5s;
        }

        .testimonial-card:hover::before {
            left: 100%;
        }

        .testimonial-card:hover {
            transform: translateY(-8px) scale(1.03);
            box-shadow: 0 25px 50px rgba(191, 49, 49, 0.25);
            border-color: #F16767;
        }

        .star-rating {
            color: #fbbf24;
            filter: drop-shadow(0 2px 4px rgba(251, 191, 36, 0.3));
        }

        .loading-spinner {
            border: 4px solid #FEF3E2;
            border-top: 4px solid #BF3131;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .marquee-container {
            overflow: hidden;
            white-space: nowrap;
            position: relative;
            padding: 3rem 0;
            background: linear-gradient(45deg, #FEF3E2 0%, #fff 50%, #FEF3E2 100%);
        }

        .marquee-content {
            display: inline-flex;
            gap: 2rem;
            animation: marquee 80s linear infinite;
        }

        .marquee-content:hover {
            animation-play-state: paused;
        }

        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .hero-bg {
            background: linear-gradient(135deg, #FEF3E2 0%, #fff 100%);
            position: relative;
        }

        .decorative-frame {
            position: absolute;
            background: white;
            border: 4px solid #BF3131;
            border-radius: 12px;
            padding: 1rem;
            box-shadow: 0 10px 30px rgba(191, 49, 49, 0.15);
        }

        .frame-left {
            left: -2rem;
            top: 20%;
            transform: rotate(-6deg);
            width: 120px;
            height: 160px;
        }

        .frame-right {
            right: -2rem;
            bottom: 20%;
            transform: rotate(6deg);
            width: 120px;
            height: 160px;
        }

        .floating-star {
            position: absolute;
            color: #BF3131;
            opacity: 0.2;
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(180deg);
            }
        }

        .profile-avatar {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #BF3131, #F16767);
            border: 3px solid white;
            box-shadow: 0 4px 12px rgba(191, 49, 49, 0.3);
        }

        .card-gradient {
            background: linear-gradient(135deg, #ffffff 0%, #fefefe 100%);
        }

        .emoji-badge {
            background: linear-gradient(135deg, #BF3131, #F16767);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            border: 3px solid white;
            box-shadow: 0 4px 12px rgba(191, 49, 49, 0.3);
        }

        .message-text {
            line-height: 1.7;
            color: #4a5568;
            position: relative;
            word-wrap: break-word; /* Allow long words to break */
            overflow-wrap: break-word; /* Ensure text wraps properly */
            white-space: normal; /* Override parent's nowrap */
            hyphens: auto; /* Add hyphenation for better text flow */
        }

        .frame-info-badge {
            background: linear-gradient(135deg, #FEF3E2, #fff);
            width: 100%;
            height: fit-content;
            border: 2px solid #BF3131;
            border-radius: 25px;
            padding: 0.5rem 1rem;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            display: inline-block;
            text-decoration: none;
        }

        .frame-info-badge::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(191, 49, 49, 0.1), transparent);
            transition: left 0.5s;
        }

        .frame-info-badge:hover {
            background: linear-gradient(135deg, #BF3131, #F16767);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(191, 49, 49, 0.3);
            border-color: #BF3131;
        }

        .frame-info-badge:hover .frame-icon {
            color: white;
        }

        .frame-info-badge:hover .frame-text {
            color: white;
        }

        .frame-info-badge:hover .frame-check {
            color: #10b981;
        }

        .frame-info-badge:active {
            transform: translateY(0px);
            box-shadow: 0 4px 12px rgba(191, 49, 49, 0.3);
        }

        /* Prevent testimonial card hover from affecting frame button when button is hovered */
        .testimonial-card:hover .frame-info-badge:not(:hover)::before {
            left: 100%;
        }
    </style>
</head>
<body>
<div class="hero-bg min-h-screen">

    <!-- Header -->
    <div class="text-center header-section bg-[#FEF3E2] py-20 relative">
        <div class="floating-elements">
            <i class="floating-star fas fa-star" style="top: 20%; left: 10%; animation-delay: 0s;"></i>
            <i class="floating-star fas fa-heart" style="top: 30%; right: 15%; animation-delay: 2s;"></i>
            <i class="floating-star fas fa-camera" style="bottom: 40%; left: 20%; animation-delay: 4s;"></i>
            <i class="floating-star fas fa-smile" style="top: 60%; right: 20%; animation-delay: 6s;"></i>
        </div>

        <h1 class="text-6xl font-extrabold text-gray-900 mb-8 tracking-tight">
            Apa Kata Mereka?
        </h1>
        <p class="text-gray-600 text-xl max-w-4xl mx-auto px-6 leading-relaxed">
            Kepuasan kamu adalah tujuan utama kami. Lihat cerita seru dari pengguna yang sudah mencoba PhotoBooth ini
            dan punya pengalaman seru yang nggak terlupakan!
        </p>
        <div class="mt-8">
            <div
                class="inline-flex items-center space-x-2 bg-white rounded-full px-6 py-3 shadow-lg border-2 border-[#BF3131]">
                <i class="fas fa-users text-[#BF3131]"></i>
                <span class="font-semibold text-gray-700">1000+ Pelanggan Puas</span>
                <i class="fas fa-heart text-red-500"></i>
            </div>
        </div>
    </div>

    <!-- Testimoni Marquee -->
    <div class="marquee-container relative bg-[#FEF3E2]">
        <div id="marqueeContent" class="marquee-content">
            <!-- Loading state -->
            <div class="flex justify-center items-center w-full">
                <div class="loading-spinner"></div>
                <p class="ml-4 text-[#BF3131] font-semibold">Memuat testimoni...</p>
            </div>
        </div>
    </div>

    <div class="text-center py-16 relative bg-[#FEF3E2] z-10">

        <div class="text-center footer-section py-20 relative">
            <div class="max-w-4xl mx-auto px-6">
                <h2 class="text-4xl font-bold text-gray-900 mb-6">
                    Siap Merasakan Pengalaman Serupa?
                </h2>
                <p class="text-gray-600 text-xl mb-10 leading-relaxed">
                    Bergabunglah dengan ribuan pelanggan yang telah merasakan keajaiban photobooth kami.
                    Ciptakan momen berharga yang tak terlupakan!
                </p>
                <div class="flex justify-center space-x-4">
                    <button
                        class="bg-[#BF3131] hover:bg-[#A02828] text-white font-bold py-4 px-8 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-camera mr-2"></i>
                        Coba Sekarang
                    </button>
                    <button
                        class="bg-white hover:bg-gray-50 border-2 border-[#BF3131] text-[#BF3131] font-bold py-4 px-8 rounded-full transition-all duration-300 transform hover:scale-105 shadow-lg">
                        <i class="fas fa-phone mr-2"></i>
                        Hubungi Kami
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    let allTestimonis = [];

    // Load initial data
    document.addEventListener('DOMContentLoaded', function() {
        loadTestimonis();
    });

    // Load testimonials
    async function loadTestimonis() {
        try {
            const response = await fetch('/api/testimonis?per_page=50');
            const result = await response.json();

            if (result.success && result.data.data) {
                allTestimonis = result.data.data;
                displayMarqueeTestimonis(allTestimonis);
            } else {
                loadMockData(); // Fallback to mock data
            }
        } catch (error) {
            console.error('Error loading testimonis:', error);
            loadMockData(); // Fallback to mock data
        }
    }

    // Display testimonials in marquee
    function displayMarqueeTestimonis(testimonis) {
        const container = document.getElementById('marqueeContent');

        if (testimonis.length === 0) {
            container.innerHTML = `
                    <div class="text-center py-12 w-full">
                        <div class="text-[#BF3131] mb-4">
                            <i class="fas fa-comments text-6xl opacity-50"></i>
                        </div>
                        <p class="text-gray-500 text-lg">Belum ada testimoni tersedia.</p>
                    </div>
                `;
            return;
        }

        // Duplicate testimonials for seamless infinite loop
        const duplicatedTestimonis = [...testimonis, ...testimonis];

        container.innerHTML = duplicatedTestimonis.map(testimoni => createTestimoniCard(testimoni)).join('');
    }

    // Create testimonial card
    function createTestimoniCard(testimoni) {
        const date = new Date(testimoni.created_at).toLocaleDateString('id-ID', {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        const stars = generateStars(testimoni.rating);
        const emoji = testimoni.emoji || getRandomEmoji(testimoni.rating);

        return `
                <div class="testimonial-card card-gradient rounded-2xl py-7 px-10 shadow-xl mx-3 relative">
                    <!-- Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center space-x-4">
                            <div class="profile-avatar rounded-full flex items-center justify-center">
                                <span class="text-white font-bold text-xl">${testimoni.name.charAt(0).toUpperCase()}</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-800 text-lg">${testimoni.name}</h4>
                                <p class="text-sm text-gray-500 font-medium">${date}</p>
                            </div>
                        </div>
                        <div class="emoji-badge">
                            ${emoji}
                        </div>
                    </div>
                    
                    <!-- Message (flexible content) -->
                    <div class="flex-grow mb-6">
                        <div class="relative">
                            <i class="fas fa-quote-left text-[#BF3131] text-2xl opacity-30 absolute -top-2 -left-1"></i>
                            <p class="message-text font-medium pl-6 pr-2 mt-4">${testimoni.message}</p>
                            <i class="fas fa-quote-right text-[#BF3131] text-2xl opacity-30 absolute -bottom-2 -right-1"></i>
                        </div>
                    </div>

                    <!-- Bottom section (fixed at bottom) -->
                    <div class="mt-auto">
                        <!-- Rating -->
                        <div class="flex justify-center items-center mb-4">
                            <div class="flex items-center bg-gradient-to-r from-yellow-50 to-orange-50 rounded-full px-4 py-2 border border-yellow-200 w-fit">
                                <div class="star-rating mr-3">${stars}</div>
                                <span class="text-sm font-semibold text-gray-700">(${testimoni.rating}/5)</span>
                            </div>
                        </div>
                        
                        <!-- Frame info -->
                        ${testimoni.frame ? `
                                        <a href="/booth?frame_id=${testimoni.frame.id}" class="frame-info-badge">
                                            <div class="flex items-center justify-center space-x-2">
                                                <i class="fas fa-image frame-icon text-[#BF3131] transition-colors duration-300"></i>
                                                <span class="text-sm font-semibold frame-text text-gray-700 transition-colors duration-300">
                                                    Frame: ${testimoni.frame.name}
                                                </span>
                                                <i class="fas fa-check-circle frame-check text-green-500 text-sm transition-colors duration-300"></i>
                                            </div>
                                        </a>
                                    ` : ''}
                    </div>

                </div>
            `;
    }

    // Generate stars
    function generateStars(rating) {
        let stars = '';
        for (let i = 1; i <= 5; i++) {
            if (i <= rating) {
                stars += '<i class="fas fa-star"></i>';
            } else {
                stars += '<i class="far fa-star text-gray-300"></i>';
            }
        }
        return stars;
    }

    // Get random emoji based on rating
    function getRandomEmoji(rating) {
        const emojisByRating = {
            5: ['😍', '🤩', '⭐', '🎉', '💖', '👏'],
            4: ['😊', '👍', '😄', '🙂', '💙'],
            3: ['😐', '👌', '🙂'],
            2: ['😕', '👎'],
            1: ['😞', '👎', '😔']
        };
        
        const emojis = emojisByRating[rating] || emojisByRating[5];
        return emojis[Math.floor(Math.random() * emojis.length)];
    }

    // Auto-load mock data for demo
    setTimeout(() => {
        if (allTestimonis.length === 0) {
            loadMockData();
        }
    }, 2000);
</script>
</body>
</html>