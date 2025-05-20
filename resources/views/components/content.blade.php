<!-- resources/views/content.blade.php -->
<style>
    #previewCountdownOverlay {
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        transition: opacity 0.3s ease, background-color 0.2s ease;
        font-size: 3rem;
        color: white;
        display: none;
    }

    #previewCountdownOverlay.show {
        display: flex;
    }

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

    #previewCaptureButton:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

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

    #previewWatermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none;
        z-index: 10;
        opacity: 0.4;
        transition: opacity 1.5s ease;
        display: none;
    }

    #previewWatermark.show {
        display: flex;
    }

    #previewWatermark .watermark-content {
        background-color: rgba(155, 155, 155, 0.5);
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

    .mobile-modal-container {
        transform: translateY(100%);
        transition: transform 0.3s ease-out;
    }

    .mobile-modal-container.show {
        transform: translateY(0);
    }

    .mobile-modal-container.hide {
        transform: translateY(100%);
    }

    body.modal-open {
        overflow: hidden;
        position: fixed;
        width: 100%;
    }

    .modal-backdrop {
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .modal-backdrop.show {
        opacity: 1;
    }

    #mobilePreviewCountdownOverlay {
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        transition: opacity 0.3s ease, background-color 0.2s ease;
        font-size: 3rem;
        color: white;
        display: none;
    }

    #mobilePreviewCountdownOverlay.show {
        display: flex;
    }

    #mobilePreviewCountdownOverlay.flash {
        background-color: rgba(255, 255, 255, 0.9);
        transition: background-color 0.2s ease;
    }

    #mobilePreviewWatermark {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        pointer-events: none;
        z-index: 10;
        opacity: 0.4;
        transition: opacity 1.5s ease;
        display: none;
    }

    #mobilePreviewWatermark.show {
        display: flex;
    }

    .frame-card {
        background: linear-gradient(145deg, #ffffff, #f0f0f0);
        border-radius: 16px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        overflow: hidden;
        position: relative;
        border: 1px solid rgba(0, 0, 0, 0.05);
    }

    .frame-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(191, 49, 49, 0.15);
        border-color: rgba(191, 49, 49, 0.1);
    }

    .frame-card .frame-image-container {
        position: relative;
        height: 220px;
        background: linear-gradient(to bottom right, #f7f7f7, #ffffff);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .frame-card:hover .frame-image-container {
        background: linear-gradient(to bottom right, #fff5f5, #fff0f0);
    }

    .frame-card .frame-image {
        max-height: 85%;
        max-width: 85%;
        object-fit: contain;
        transition: transform 0.5s ease;
        filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
    }

    .frame-card:hover .frame-image {
        transform: scale(1.05);
    }

    .frame-card .frame-overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(to bottom,
                rgba(191, 49, 49, 0.01),
                rgba(191, 49, 49, 0.7));
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .frame-card:hover .frame-overlay {
        opacity: 1;
    }

    .frame-card .preview-button {
        background-color: white;
        color: #BF3131;
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 50px;
        transform: translateY(20px);
        transition: all 0.3s ease;
        border: 2px solid transparent;
        display: flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .frame-card:hover .preview-button {
        transform: translateY(0);
    }

    .frame-card .preview-button:hover {
        background-color: #BF3131;
        color: white;
        box-shadow: 0 6px 16px rgba(191, 49, 49, 0.3);
    }

    .frame-card .card-content {
        padding: 20px;
    }

    .frame-card .frame-title {
        color: #1f2937;
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 12px;
        transition: color 0.3s ease;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .frame-card:hover .frame-title {
        color: #BF3131;
    }

    .frame-card .frame-details {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 10px;
    }

    .frame-card .category {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #4b5563;
        font-size: 0.875rem;
        background-color: #f3f4f6;
        padding: 4px 10px;
        border-radius: 20px;
        transition: all 0.3s ease;
    }

    .frame-card:hover .category {
        background-color: #fdecec;
        color: #BF3131;
    }

    .frame-card .usage-count {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #6b7280;
        font-size: 0.875rem;
    }

    .frame-card .badge {
        position: absolute;
        top: 12px;
        right: 12px;
        z-index: 10;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 4px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        animation: pulse-subtle 2s infinite;
    }

    .frame-card .badge-free {
        background: linear-gradient(135deg, #10b981, #059669);
        color: white;
    }

    .frame-card .badge-premium {
        background: linear-gradient(135deg, #f59e0b, #d97706);
        color: white;
    }

    @keyframes pulse-subtle {
        0% {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        50% {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        100% {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    }

    /* Skeleton Loading Animation */
    .frame-card-skeleton {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        position: relative;
    }

    .frame-card-skeleton .skeleton-image {
        height: 220px;
        background: linear-gradient(90deg, #f0f0f0 25%, #f8f8f8 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }

    .frame-card-skeleton .skeleton-content {
        padding: 20px;
    }

    .frame-card-skeleton .skeleton-title {
        height: 24px;
        width: 70%;
        background: linear-gradient(90deg, #f0f0f0 25%, #f8f8f8 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
        border-radius: 4px;
        margin-bottom: 12px;
    }

    .frame-card-skeleton .skeleton-details {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
    }

    .frame-card-skeleton .skeleton-category {
        height: 20px;
        width: 40%;
        background: linear-gradient(90deg, #f0f0f0 25%, #f8f8f8 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
        border-radius: 20px;
    }

    .frame-card-skeleton .skeleton-usage {
        height: 20px;
        width: 30%;
        background: linear-gradient(90deg, #f0f0f0 25%, #f8f8f8 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
        border-radius: 4px;
    }

    @keyframes shimmer {
        0% {
            background-position: 200% 0;
        }

        100% {
            background-position: -200% 0;
        }
    }
</style>

<div class="py-16 bg-[#FEF3E2] content_section">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Bagian Frame Unggulan -->
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 inline-block relative">
                <span class="bg-clip-text text-transparent bg-[#BF3131]">Frame Unggulan</span>
                <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-1/2 h-1 bg-[#BF3131] rounded-full">
                </div>
            </h2>
            <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Frame paling populer yang banyak digunakan untuk momen
                spesial Anda</p>
        </div>

        @if ($topFrames->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8 mb-16">
                @foreach ($topFrames as $frame)
                    <div class="frame-card" data-frame-id="{{ $frame->id }}">
                        <!-- Status Badge -->
                        <div class="badge {{ $frame->isFree() ? 'badge-free' : 'badge-premium' }}">
                            @if ($frame->isFree())
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                GRATIS
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                {{ number_format($frame->price, 0, ',', '.') }} IDR
                            @endif
                        </div>

                        <!-- Frame Image -->
                        <div class="frame-image-container">
                            @if ($frame->image_path)
                                <img src="{{ asset('storage/' . $frame->image_path) }}" alt="{{ $frame->name }}"
                                    class="frame-image">
                            @else
                                <div class="text-gray-400 text-5xl">🖼️</div>
                            @endif

                            <!-- Overlay with Preview Button -->
                            <div class="frame-overlay">
                                <button class="preview-button" data-frame-id="{{ $frame->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Preview
                                </button>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="card-content">
                            <h3 class="frame-title">{{ $frame->name }}</h3>

                            <div class="frame-details">
                                <div class="category">
                                    <span>{{ $frame->category->icon }}</span>
                                    <span>{{ $frame->category->name }}</span>
                                </div>

                                <div class="usage-count">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                    {{ $frame->used }}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Optional: Skeleton Loading Card (can be shown while frames are loading) -->
                <div class="frame-card-skeleton hidden">
                    <div class="skeleton-image"></div>
                    <div class="skeleton-content">
                        <div class="skeleton-title"></div>
                        <div class="skeleton-details">
                            <div class="skeleton-category"></div>
                            <div class="skeleton-usage"></div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-12 bg-gradient-to-r from-red-50 to-red-50 rounded-2xl shadow-inner mb-16">
                <div class="inline-block text-7xl mb-6 animate-pulse">🖼️</div>
                <p class="text-xl text-gray-600 font-light">Belum ada frame unggulan saat ini.</p>
                <p class="mt-3 text-gray-500">Coba lagi nanti atau jelajahi kategori lainnya.</p>
            </div>
        @endif

        <div class="mt-16 text-center">
            <a href="{{ route('frametemp') }}"
                class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-[#BF3131] hover:bg-[#F16767] transition duration-300 shadow-md hover:shadow-lg">
                Mulai Mencoba
                <svg class="ml-2 w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>

        <!-- Bagian Kategori dan Frame Utama -->

    </div>
</div>

<!-- Modal Preview Section -->
<div id="previewCameraModal" class="hidden fixed inset-0 z-50 flex items-center justify-center overflow-hidden">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm modal-backdrop"></div>

    <!-- Desktop Modal -->
    <div
        class="relative bg-white rounded-xl shadow-xl p-6 w-full max-w-4xl mx-4 hidden md:block animate-[modalFadeIn_0.3s]">
        <button
            class="modal-close absolute top-4 right-4 text-2xl text-gray-500 hover:text-black cursor-pointer">&times;</button>

        <h2 class="text-xl font-semibold mb-4 text-center">Frame Preview</h2>

        <div class="flex flex-row gap-6 justify-center items-center">
            <div class="w-3/5">
                <div class="relative bg-white rounded-lg overflow-hidden" style="aspect-ratio: 4/3;">
                    <video id="previewVideo" autoplay muted class="w-full h-full object-cover scale-x-[-1]"></video>
                    <div id="previewWatermark" class="hidden">
                        <div class="watermark-content">
                            <img src="{{ asset('logo.png') }}" alt="Logo" class="h-10">
                        </div>
                    </div>
                    <div id="previewCountdownOverlay"
                        class="absolute inset-0 flex items-center justify-center text-6xl font-bold text-white/90">
                    </div>
                </div>

                <button id="previewCaptureButton"
                    class="mt-4 w-full py-3 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition-colors">
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

    <!-- Mobile Modal -->
    <div
        class="relative bg-white rounded-t-xl shadow-xl w-full md:hidden mobile-modal-container max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 z-10 bg-white rounded-t-xl border-b border-gray-200">
            <div class="w-12 h-1.5 bg-gray-300 rounded-full mx-auto my-3"></div>
            <h2 class="text-xl font-semibold px-4 pb-3 text-center">Frame Preview</h2>
            <button
                class="modal-close absolute top-3 right-4 text-2xl text-gray-500 hover:text-black cursor-pointer">&times;</button>
        </div>

        <div class="p-4 flex flex-col gap-6">
            <div class="w-full">
                <div class="relative bg-white rounded-lg overflow-hidden" style="aspect-ratio: 4/3;">
                    <video id="mobilePreviewVideo" autoplay muted
                        class="w-full h-full object-cover scale-x-[-1]"></video>
                    <div id="mobilePreviewWatermark" class="hidden">
                        <div class="watermark-content">
                            <img src="{{ asset('logo.png') }}" alt="Logo" class="h-10">
                        </div>
                    </div>
                    <div id="mobilePreviewCountdownOverlay"
                        class="absolute inset-0 flex items-center justify-center text-6xl font-bold text-white/90">
                    </div>
                </div>

                <button id="mobilePreviewCaptureButton"
                    class="mt-4 w-full py-3 bg-red-500 hover:bg-red-600 text-white rounded-lg text-sm font-medium transition-colors">
                    📷 Start Session
                </button>
            </div>

            <div class="w-full flex justify-center items-center pb-4">
                <div class="w-[190px] h-[450px] relative">
                    <div id="mobilePreviewFrameContainer"
                        class="w-full h-full relative bg-transparent shadow-md overflow-hidden">
                        <div id="mobilePreviewFrameImage"
                            class="absolute inset-0 flex items-center justify-center bg-gray-100">
                            <p class="text-gray-400 text-center p-4">Frame akan muncul di sini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Script dengan Debug Log -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing frame cards...');
        setupFrameCards();

        // Category link handling
        document.querySelectorAll('.category-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const url = this.href;
                const scrollPosition = window.scrollY;

                console.log('Category link clicked:', url);

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
                            console.log('Content updated, frame cards re-initialized');
                        }
                    })
                    .catch(error => console.error('Error fetching category:', error));
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

        // Create html2canvas script if needed
        if (!window.html2canvas) {
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js';
            script.async = true;
            document.head.appendChild(script);
            console.log('Loading html2canvas script...');
        }
    });

    function setupFrameCards() {
        const frameCards = document.querySelectorAll('.frame-card');
        console.log(`Found ${frameCards.length} frame cards`);

        frameCards.forEach(card => {
            // Make the entire card clickable for preview
            card.addEventListener('click', function(e) {
                // Don't trigger if clicking on the button directly (it will handle its own click)
                if (e.target.closest('.preview-button')) return;

                const frameId = this.dataset.frameId;
                console.log('Frame card clicked for frame ID:', frameId);
                openPreviewCameraModal(e, frameId);
            });

            // For the preview button, we'll set up a specific click handler
            const previewBtn = card.querySelector('.preview-button');
            if (previewBtn) {
                previewBtn.removeEventListener('click', handlePreviewButtonClick);
                previewBtn.addEventListener('click', handlePreviewButtonClick);
            }
        });
    }

    function handlePreviewButtonClick(e) {
        e.preventDefault();
        e.stopPropagation();

        const frameId = this.dataset.frameId;
        console.log('Preview button clicked for frame ID:', frameId);
        openPreviewCameraModal(e, frameId);
    }

    function openPreviewCameraModal(e) {
        e.preventDefault();
        e.stopPropagation();

        // Save the current scroll position
        const scrollPosition = window.scrollY;
        console.log('openPreviewCameraModal called, scroll position saved:', scrollPosition);

        const modal = document.getElementById('previewCameraModal');
        if (!modal) {
            console.error('Modal element not found!');
            return;
        }

        // Reset state before opening modal
        resetModalState();

        const mobileModalContainer = modal.querySelector('.mobile-modal-container');
        const modalBackdrop = modal.querySelector('.modal-backdrop');
        const video = document.getElementById('previewVideo');
        const mobileVideo = document.getElementById('mobilePreviewVideo');
        const previewFrameContainer = document.getElementById('previewFrameContainer');
        const previewFrameImage = document.getElementById('previewFrameImage');
        const mobilePreviewFrameContainer = document.getElementById('mobilePreviewFrameContainer');
        const mobilePreviewFrameImage = document.getElementById('mobilePreviewFrameImage');
        const captureButton = document.getElementById('previewCaptureButton');
        const mobileCaptureButton = document.getElementById('mobilePreviewCaptureButton');
        const watermark = document.getElementById('previewWatermark');
        const mobileWatermark = document.getElementById('mobilePreviewWatermark');

        document.body.classList.add('modal-open');
        modal.style.display = 'flex';
        modalBackdrop.classList.add('show');

        console.log('Modal display set to flex');

        if (mobileModalContainer) {
            setTimeout(() => {
                mobileModalContainer.classList.add('show');
                console.log('Mobile modal container shown');
            }, 50);
        }

        const frameCard = e.target.closest('.frame-card');
        let frameId = null;

        if (frameCard) {
            frameId = frameCard.dataset.frameId || e.target.dataset.frameId;
            console.log('Frame ID from card or button:', frameId);
        }

        if (frameId) {
            modal.setAttribute('data-frame-id', frameId);
            window.currentFrameId = frameId;

            const loadingContent =
                '<div class="flex items-center justify-center w-full h-full"><div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-red-500"></div></div>';
            previewFrameImage.innerHTML = loadingContent;
            mobilePreviewFrameImage.innerHTML = loadingContent;

            fetchFrameDetails(frameId);

            fetch(`/get-frame-template/${frameId}`)
                .then(response => {
                    if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                    return response.text();
                })
                .then(html => {
                    previewFrameImage.innerHTML = html;
                    mobilePreviewFrameImage.innerHTML = html;
                    initializePhotoSlots(previewFrameImage);
                    initializePhotoSlots(mobilePreviewFrameImage, true);
                    console.log('Frame template loaded successfully');
                })
                .catch(error => {
                    console.error('Error loading frame template:', error);
                    const errorContent = `
                    <div class="flex flex-col items-center justify-center w-full h-full text-red-500">
                        <svg class="w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <p class="text-center">Failed to load frame template.</p>
                    </div>
                `;
                    previewFrameImage.innerHTML = errorContent;
                    mobilePreviewFrameImage.innerHTML = errorContent;
                    createDummySlots(previewFrameImage);
                    createDummySlots(mobilePreviewFrameImage, true);
                });
        } else {
            console.error('No frame ID found');
            const errorContent = `
            <div class="flex flex-col items-center justify-center w-full h-full text-red-500">
                <svg class="w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <p class="text-center">Cannot preview frame: No frame ID found.</p>
                <p class="text-center text-sm mt-2">Please try again or select a different frame.</p>
            </div>
        `;
            previewFrameImage.innerHTML = errorContent;
            mobilePreviewFrameImage.innerHTML = errorContent;
        }

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
                    mobileVideo.srcObject = stream;
                    window.stream = stream;
                    video.onloadedmetadata = function() {
                        video.play();
                    };
                    mobileVideo.onloadedmetadata = function() {
                        mobileVideo.play();
                    };
                    console.log('Webcam stream initialized');
                })
                .catch(err => {
                    console.error("Error accessing webcam: ", err);
                    handleCameraError(video, captureButton);
                    handleCameraError(mobileVideo, mobileCaptureButton);
                });
        } else {
            console.error("getUserMedia not supported");
            alert("Your browser doesn't support camera access. Please try a different browser.");
        }

        const modalCloseButtons = modal.querySelectorAll('.modal-close');
        modalCloseButtons.forEach(btn => {
            btn.removeEventListener('click', closePreviewCameraModal);
            btn.addEventListener('click', () => closePreviewCameraModal(scrollPosition));
        });

        window.removeEventListener('click', handleModalBackdropClick);
        window.addEventListener('click', (e) => handleModalBackdropClick(e, scrollPosition));

        // Add capture button listeners
        captureButton.addEventListener('click', () => startPhotoSession(false));
        mobileCaptureButton.addEventListener('click', () => startPhotoSession(true));

        enableDragToClose(mobileModalContainer);

        // Prevent default scroll behavior
        document.body.style.position = 'fixed';
        document.body.style.top = `-${scrollPosition}px`;
        document.body.style.width = '100%';
    }

    function handleModalBackdropClick(e, testers) {
        const modal = document.getElementById('previewCameraModal');
        if (e.target === modal || e.target.classList.contains('modal-backdrop')) {
            closePreviewCameraModal(scrollPosition);
        }
    }

    function enableDragToClose(element) {
        if (!element) return;
        let startY = 0;
        let currentY = 0;

        element.addEventListener('touchstart', function(e) {
            startY = e.touches[0].clientY;
        });

        element.addEventListener('touchmove', function(e) {
            currentY = e.touches[0].clientY;
            const dragDistance = currentY - startY;
            if (dragDistance > 0) {
                element.style.transform = `translateY(${dragDistance}px)`;
            }
        });

        element.addEventListener('touchend', function() {
            const dragDistance = currentY - startY;
            if (dragDistance > 100) {
                closePreviewCameraModal();
            } else {
                element.style.transform = '';
            }
        });
    }

    function closePreviewCameraModal(scrollPosition) {
        const modal = document.getElementById('previewCameraModal');
        const mobileModalContainer = modal.querySelector('.mobile-modal-container');
        const modalBackdrop = modal.querySelector('.modal-backdrop');
        const video = document.getElementById('previewVideo');
        const mobileVideo = document.getElementById('mobilePreviewVideo');
        const desktopModal = modal.querySelector('.md\\:block');

        if (mobileModalContainer) {
            mobileModalContainer.classList.remove('show');
            mobileModalContainer.classList.add('hide');
        }

        if (desktopModal) {
            desktopModal.style.opacity = '0';
            desktopModal.style.transform = 'translateY(-30px)';
            desktopModal.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
        }

        modalBackdrop.classList.remove('show');

        // Stop video stream
        if (window.stream) {
            const tracks = window.stream.getTracks();
            tracks.forEach(track => track.stop());
            if (video.srcObject) video.srcObject = null;
            if (mobileVideo.srcObject) mobileVideo.srcObject = null;
            window.stream = null;
        }

        // Remove event listeners
        const captureButton = document.getElementById('previewCaptureButton');
        const mobileCaptureButton = document.getElementById('mobilePreviewCaptureButton');
        if (captureButton) captureButton.removeEventListener('click', startPhotoSession);
        if (mobileCaptureButton) mobileCaptureButton.removeEventListener('click', startPhotoSession);
        window.removeEventListener('click', handleModalBackdropClick);

        // Reset modal state
        resetModalState();

        // Restore scroll position
        document.body.classList.remove('modal-open');
        document.body.style.position = '';
        document.body.style.top = '';
        window.scrollTo(0, scrollPosition);

        setTimeout(() => {
            modal.style.display = 'none';
            if (mobileModalContainer) {
                mobileModalContainer.classList.remove('hide');
            }
            if (desktopModal) {
                desktopModal.style.opacity = '';
                desktopModal.style.transform = '';
            }
            console.log('Modal closed and scroll position restored to:', scrollPosition);
        }, 300);
    }

    function resetModalState() {
        const countdownOverlay = document.getElementById('previewCountdownOverlay');
        const captureButton = document.getElementById('previewCaptureButton');
        const watermark = document.getElementById('previewWatermark');
        const mobileCountdownOverlay = document.getElementById('mobilePreviewCountdownOverlay');
        const mobileCaptureButton = document.getElementById('mobilePreviewCaptureButton');
        const mobileWatermark = document.getElementById('mobilePreviewWatermark');
        const previewFrameImage = document.getElementById('previewFrameImage');
        const mobilePreviewFrameImage = document.getElementById('mobilePreviewFrameImage');

        // Reset photo slots
        window.photoSlots = [];
        window.mobilePhotoSlots = [];

        // Clear existing photo slots content
        if (previewFrameImage) {
            const slots = previewFrameImage.querySelectorAll('.photo-slot');
            slots.forEach(slot => {
                const img = slot.querySelector('img');
                if (img) {
                    img.src = '';
                    img.style.display = 'none';
                }
                const slotWatermark = slot.querySelector('.slot-watermark');
                if (slotWatermark) slotWatermark.remove();
            });
        }
        if (mobilePreviewFrameImage) {
            const mobileSlots = mobilePreviewFrameImage.querySelectorAll('.photo-slot');
            mobileSlots.forEach(slot => {
                const img = slot.querySelector('img');
                if (img) {
                    img.src = '';
                    img.style.display = 'none';
                }
                const slotWatermark = slot.querySelector('.slot-watermark');
                if (slotWatermark) slotWatermark.remove();
            });
        }

        // Reset countdown, capture button, and watermark
        const resetElements = (countdown, capture, mark) => {
            if (countdown) {
                countdown.textContent = '';
                countdown.style.display = 'none';
                countdown.style.backgroundColor = 'transparent';
                countdown.classList.remove('show', 'flash');
            }
            if (capture) {
                capture.textContent = "📷 Start Session";
                capture.disabled = false;
                // Remove existing event listeners to prevent duplicate
                capture.removeEventListener('click', startPhotoSession);
            }
            if (mark) {
                mark.classList.add('hidden');
                mark.classList.remove('show');
            }
        };

        resetElements(countdownOverlay, captureButton, watermark);
        resetElements(mobileCountdownOverlay, mobileCaptureButton, mobileWatermark);

        // Stop any running timers
        if (window.timer) {
            clearInterval(window.timer);
            window.timer = null;
        }

        // Reset frame content
        if (previewFrameImage) {
            previewFrameImage.innerHTML = '<p class="text-gray-400 text-center p-4">Frame akan muncul di sini</p>';
        }
        if (mobilePreviewFrameImage) {
            mobilePreviewFrameImage.innerHTML =
                '<p class="text-gray-400 text-center p-4">Frame akan muncul di sini</p>';
        }

        console.log('Modal state reset');
    }

    function createDummySlots(container, isMobile = false) {
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
            container.appendChild(dummySlot);

            const img = document.createElement('img');
            dummySlot.appendChild(img);

            if (isMobile) {
                if (!window.mobilePhotoSlots) window.mobilePhotoSlots = [];
                window.mobilePhotoSlots.push(img);
            } else {
                if (!window.photoSlots) window.photoSlots = [];
                window.photoSlots.push(img);
            }
        }
    }

    function initializePhotoSlots(frameElement, isMobile = false) {
        console.log(`Initializing photo slots for ${isMobile ? 'mobile' : 'desktop'}`);
        if (isMobile) {
            window.mobilePhotoSlots = [];
        } else {
            window.photoSlots = [];
        }

        const existingSlots = frameElement.querySelectorAll('.photo-slot');
        existingSlots.forEach(slot => slot.remove());

        const slotPositions = [{
                top: '16%',
                left: '50%'
            },
            {
                top: '42%',
                left: '50%'
            },
            {
                top: '68%',
                left: '50%'
            },
        ];

        for (let i = 0; i < 3; i++) {
            const photoSlot = document.createElement('div');
            photoSlot.className = 'photo-slot';
            photoSlot.style.width = '160px';
            photoSlot.style.height = '110px';
            photoSlot.style.position = 'absolute';
            photoSlot.style.top = slotPositions[i].top;
            photoSlot.style.left = slotPositions[i].left;
            photoSlot.style.transform = 'translate(-50%, -50%)';
            photoSlot.style.backgroundColor = '#e6e6e6';

            const img = document.createElement('img');
            img.style.width = '100%';
            img.style.height = '100%';
            img.style.objectFit = 'cover';
            img.style.display = 'none';
            photoSlot.appendChild(img);

            frameElement.appendChild(photoSlot);

            if (isMobile) {
                if (!window.mobilePhotoSlots) window.mobilePhotoSlots = [];
                window.mobilePhotoSlots.push(img);
            } else {
                if (!window.photoSlots) window.photoSlots = [];
                window.photoSlots.push(img);
            }
        }
    }

    function startPhotoSession(isMobile = false) {
        const video = isMobile ? document.getElementById('mobilePreviewVideo') : document.getElementById(
            'previewVideo');
        const captureButton = isMobile ? document.getElementById('mobilePreviewCaptureButton') : document
            .getElementById('previewCaptureButton');
        const countdownOverlay = isMobile ? document.getElementById('mobilePreviewCountdownOverlay') : document
            .getElementById('previewCountdownOverlay');
        const photoSlots = isMobile ? window.mobilePhotoSlots : window.photoSlots;

        // Stop any existing timer
        if (window.timer) {
            clearInterval(window.timer);
            window.timer = null;
        }

        // Clear photo slots
        if (photoSlots) {
            photoSlots.forEach(img => {
                img.src = '';
                img.style.display = 'none';
                const slotParent = img.parentElement;
                const slotWatermark = slotParent.querySelector('.slot-watermark');
                if (slotWatermark) slotWatermark.remove();
            });
        }

        captureButton.disabled = true;
        captureButton.textContent = "Sedang mengambil foto...";

        let photosLeft = 3;
        let currentPhoto = 0;

        function startCountdown() {
            let countdown = 3;
            countdownOverlay.textContent = countdown;
            countdownOverlay.style.display = 'flex';
            countdownOverlay.classList.add('show');
            countdownOverlay.style.backgroundColor = 'transparent';

            window.timer = setInterval(() => {
                countdown--;

                if (countdown > 0) {
                    countdownOverlay.textContent = countdown;
                } else if (countdown === 0) {
                    countdownOverlay.textContent = 'Snap!';
                } else {
                    takePhoto(currentPhoto, isMobile);
                    currentPhoto++;
                    photosLeft--;

                    clearInterval(window.timer);
                    window.timer = null;

                    if (photosLeft > 0) {
                        setTimeout(startCountdown, 500);
                    } else {
                        countdownOverlay.style.display = 'none';
                        countdownOverlay.classList.remove('show');
                        captureButton.textContent = "Selesai! Klik untuk ulang";
                        captureButton.disabled = false;
                    }
                }
            }, 1000);
        }

        startCountdown();
    }

    function takePhoto(slotIndex, isMobile = false) {
        const video = isMobile ? document.getElementById('mobilePreviewVideo') : document.getElementById(
            'previewVideo');
        const countdownOverlay = isMobile ? document.getElementById('mobilePreviewCountdownOverlay') : document
            .getElementById('previewCountdownOverlay');
        const watermark = isMobile ? document.getElementById('mobilePreviewWatermark') : document.getElementById(
            'previewWatermark');
        const previewCameraModal = document.getElementById('previewCameraModal');
        const frameId = previewCameraModal.getAttribute('data-frame-id');
        const photoSlots = isMobile ? window.mobilePhotoSlots : window.photoSlots;

        countdownOverlay.style.backgroundColor = 'rgba(255, 255, 255, 0.9)';
        countdownOverlay.textContent = '';
        countdownOverlay.classList.add('flash');

        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        const ctx = canvas.getContext('2d');

        ctx.translate(canvas.width, 0);
        ctx.scale(-1, 1);
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        ctx.setTransform(1, 0, 0, 1, 0, 0);

        const addWatermark = () => {
            return new Promise((resolve) => {
                if (watermark && watermark.classList.contains('show')) {
                    ctx.save();
                    ctx.translate(canvas.width / 2, canvas.height / 2);
                    ctx.globalAlpha = 0.4;

                    const logo = new Image();
                    logo.src = '{{ asset('logo.png') }}';
                    logo.onload = () => {
                        ctx.drawImage(logo, -60, -20, 140, 80);
                        ctx.restore();
                        resolve();
                    };
                    logo.onerror = () => {
                        console.error('Failed to load watermark logo');
                        ctx.restore();
                        resolve();
                    };
                } else {
                    resolve();
                }
            });
        };

        addWatermark().then(() => {
            const photoDataUrl = canvas.toDataURL('image/jpeg');

            if (photoSlots && photoSlots[slotIndex]) {
                const img = photoSlots[slotIndex];
                img.src = photoDataUrl;
                img.style.display = 'block';

                if (watermark && watermark.classList.contains('show')) {
                    const slotParent = img.parentElement;
                    let watermarkElem = slotParent.querySelector('.slot-watermark');

                    if (!watermarkElem) {
                        watermarkElem = document.createElement('div');
                        watermarkElem.className = 'slot-watermark';
                        watermarkElem.style.position = 'absolute';
                        watermarkElem.style.top = '50%';
                        watermarkElem.style.left = '50%';
                        watermarkElem.style.transform = 'translate(-50%, -50%)';
                        watermarkElem.style.pointerEvents = 'none';
                        watermarkElem.style.zIndex = '10';
                        watermarkElem.style.opacity = '0.4';

                        const watermarkContent = document.createElement('div');
                        watermarkContent.style.display = 'flex';
                        watermarkContent.style.alignItems = 'center';
                        watermarkContent.style.justifyContent = 'center';
                        watermarkContent.style.backgroundColor = 'rgba(255, 255, 255, 0.5)';
                        watermarkContent.style.padding = '5px 10px';
                        watermarkContent.style.borderRadius = '8px';
                        watermarkContent.style.boxShadow = '0 1px 3px rgba(0,0,0,0.1)';

                        const watermarkImg = document.createElement('img');
                        watermarkImg.src = '{{ asset('logo.png') }}';
                        watermarkImg.style.height = '30px';
                        watermarkImg.style.width = 'auto';

                        watermarkContent.appendChild(watermarkImg);
                        watermarkElem.appendChild(watermarkContent);
                        slotParent.appendChild(watermarkElem);
                    } else {
                        watermarkElem.style.display = 'block';
                    }
                }
            }

            setTimeout(() => {
                countdownOverlay.style.backgroundColor = 'transparent';
                countdownOverlay.textContent = '';
            }, 200);
        });
    }

    function fetchFrameDetails(frameId) {
        console.log('Fetching frame details for ID:', frameId);
        return fetch(`/get-frame-status/${frameId}`)
            .then(response => {
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                return response.json();
            })
            .then(data => {
                const watermark = document.getElementById('previewWatermark');
                const mobileWatermark = document.getElementById('mobilePreviewWatermark');

                const applyWatermarkVisibility = (element) => {
                    if (element) {
                        if (data.price > 0) {
                            element.classList.add('show');
                            element.classList.remove('hidden');
                        } else {
                            element.classList.add('hidden');
                            element.classList.remove('show');
                        }
                    }
                };

                applyWatermarkVisibility(watermark);
                applyWatermarkVisibility(mobileWatermark);
                console.log('Frame status fetched:', data);

                return data;
            })
            .catch(error => {
                console.error('Error fetching frame status:', error);
                const watermark = document.getElementById('previewWatermark');
                const mobileWatermark = document.getElementById('mobilePreviewWatermark');

                if (watermark) {
                    watermark.classList.add('hidden');
                    watermark.classList.remove('show');
                }
                if (mobileWatermark) {
                    mobileWatermark.classList.add('hidden');
                    mobileWatermark.classList.remove('show');
                }
                return null;
            });
    }

    function handleCameraError(video, captureButton) {
        video.style.display = 'none';
        const errorMessage = document.createElement('div');
        errorMessage.className = 'flex flex-col items-center justify-center w-full h-full text-red-500';
        errorMessage.innerHTML = `
            <svg class="w-12 h-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <p>Gagal mengakses kamera. Silakan periksa izin kamera atau coba browser lain.</p>
        `;
        video.parentElement.appendChild(errorMessage);
        captureButton.disabled = true;
        captureButton.textContent = 'Kamera Tidak Tersedia';
    }
</script>
