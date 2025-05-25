@extends('layouts.app')

@section('hero_section')
    <style>
        /* Preview Modal Styles */
        #previewCameraModal {
            font-family: 'Poppins', sans-serif;
        }

        #previewVideo,
        #mobilePreviewVideo {
            background-color: #000;
        }

        #previewFrameContainer,
        #mobilePreviewFrameContainer {
            height: 100%;
            width: 100%;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #previewFrameImage,
        #mobilePreviewFrameImage {
            position: relative;
            height: 100%;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #previewFrameImage img,
        #previewFrameImage svg,
        #previewFrameImage>div,
        #mobilePreviewFrameImage img,
        #mobilePreviewFrameImage svg,
        #mobilePlusFrameImage>div {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
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

        #previewWatermark,
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

        #previewWatermark.show,
        #mobilePreviewWatermark.show {
            display: flex;
        }

        #previewWatermark .watermark-content,
        #mobilePreviewWatermark .watermark-content {
            background-color: rgba(155, 155, 155, 0.5);
            padding: 10px 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        #previewWatermark .watermark-content span,
        #mobilePreviewWatermark .watermark-content span {
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
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

        #previewCountdownOverlay,
        #mobilePreviewCountdownOverlay {
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            transition: opacity 0.3s ease, background-color 0.2s ease;
            font-size: 3rem;
            color: white;
            display: none;
        }

        #previewCountdownOverlay.show,
        #mobilePreviewCountdownOverlay.show {
            display: flex;
        }

        #previewCountdownOverlay.flash,
        #mobilePreviewCountdownOverlay.flash {
            background-color: rgba(255, 255, 255, 0.9);
            transition: background-color 0.2s ease;
        }

        #previewCaptureButton:disabled,
        #mobilePreviewCaptureButton:disabled {
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

        #previewCountdownOverlay,
        #mobilePreviewCountdownOverlay {
            animation: pulse 1s infinite;
        }

        /* Modal Animation */
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

        /* Category Button Styles (Desktop) - UPDATED */
        .category-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
            /* Increased from 8px */
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .category-btn:hover {
            transform: translateY(-2px);
        }

        .category-icon {
            width: 64px;
            /* Increased from 48px */
            height: 64px;
            /* Increased from 48px */
            border-radius: 16px;
            /* Increased from 12px */
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border: 2px solid transparent;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .category-icon:hover {
            background-color: #fff5f5;
            border-color: #fed7d7;
            transform: translateY(-2px);
        }

        .category-icon.active {
            background-color: #BF3131;
            border-color: #BF3131;
            color: white;
            width: 72px;
            /* Increased from 56px */
            height: 72px;
            /* Increased from 56px */
            transform: scale(1.1);
        }

        .category-icon.active span,
        .category-icon-mobile.active span {
            filter: none !important;
            text-shadow: 0 0 15px white;
            /* Ensures the original color is preserved */
        }

        .category-icon span {
            font-size: 24px;
            /* Increased from 18px */
        }

        .category-label {
            font-size: 14px;
            /* Increased from 12px */
            font-weight: 500;
            color: #6b7280;
            transition: color 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .category-btn:hover .category-label {
            color: #BF3131;
        }

        .category-btn .category-icon.active+.category-label {
            color: #BF3131;
            font-weight: 600;
            font-size: 15px;
            /* Increased from 13px */
        }

        .filter-btn,
        .rating-filter-btn,
        .popular-filter-btn,
        .default-filter-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e5e7eb;
            background-color: white;
            color: #6b7280;
        }

        .filter-btn:hover,
        .rating-filter-btn:hover,
        .popular-filter-btn:hover,
        .default-filter-btn:hover {
            background-color: #fff5f5;
            border-color: #fed7d7;
            color: #BF3131;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(191, 49, 49, 0.15);
        }

        .filter-btn.active,
        .rating-filter-btn.active,
        .popular-filter-btn.active,
        .default-filter-btn.active {
            background-color: #BF3131;
            border-color: #BF3131;
            color: white;
        }

        .filter-btn.active svg,
        .rating-filter-btn.active svg,
        .popular-filter-btn.active svg,
        .default-filter-btn.active svg {
            color: white;
        }

        /* Mobile Filter Button Styles */
        .mobile-filter-btn,
        .mobile-rating-filter-btn,
        .mobile-popular-filter-btn,
        .mobile-default-filter-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid #e5e7eb;
            background-color: white;
            color: #6b7280;
        }

        .mobile-filter-btn:hover,
        .mobile-rating-filter-btn:hover,
        .mobile-popular-filter-btn:hover,
        .mobile-default-filter-btn:hover {
            background-color: #fff5f5;
            border-color: #fed7d7;
            color: #BF3131;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(191, 49, 49, 0.15);
        }

        .mobile-filter-btn.active,
        .mobile-rating-filter-btn.active,
        .mobile-popular-filter-btn.active,
        .mobile-default-filter-btn.active {
            background-color: #BF3131;
            border-color: #BF3131;
            color: white;
        }

        .mobile-filter-btn.active svg,
        .mobile-rating-filter-btn.active svg,
        .mobile-popular-filter-btn.active svg,
        .mobile-default-filter-btn.active svg {
            color: white;
        }



        /* Category Scroll (Desktop) */
        .category-scroll-desktop {
            display: flex;
            overflow-x: auto;
            gap: 30px;
            padding: 20px 40px;
            scroll-behavior: smooth;
            -ms-overflow-style: none;
        }

        .category-scroll-desktop::-webkit-scrollbar {
            height: 8px;
        }

        .category-scroll-desktop::-webkit-scrollbar-track {
            background: transparent;
        }

        .category-scroll-desktop::-webkit-scrollbar-thumb {
            background-color: #BF3131;
            border-radius: 4px;
            border: 2px solid transparent;
            background-clip: content-box;
        }

        .category-scroll-desktop::-webkit-scrollbar-thumb:hover {
            background-color: #a12828;
        }

        /* Scrollbar Hide for Mobile */
        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
            scroll-behavior: smooth;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        /* Mobile Category Button Styles - UPDATED to match desktop theme */
        .category-btn-mobile {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            /* Reduced from desktop 12px */
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            min-width: 65px;
            padding: 6px 2px;
        }

        .category-btn-mobile:hover {
            transform: translateY(-2px);
        }

        .category-icon-mobile {
            width: 48px;
            /* Scaled down from desktop 64px */
            height: 48px;
            /* Scaled down from desktop 64px */
            border-radius: 12px;
            /* Scaled down from desktop 16px */
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f9fa;
            border: 2px solid transparent;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .category-icon-mobile:hover {
            background-color: #fff5f5;
            border-color: #fed7d7;
            transform: translateY(-2px);
        }

        .category-icon-mobile.active {
            background-color: #BF3131;
            border-color: #BF3131;
            color: white;
            width: 56px;
            /* Scaled down from desktop 72px */
            height: 56px;
            /* Scaled down from desktop 72px */
            transform: scale(1.1);
        }


        .category-icon-mobile span {
            font-size: 18px;
            /* Scaled down from desktop 24px */
        }

        .category-label-mobile {
            font-size: 12px;
            /* Scaled down from desktop 14px */
            font-weight: 500;
            color: #6b7280;
            transition: color 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .category-btn-mobile:hover .category-label-mobile {
            color: #BF3131;
        }

        .category-btn-mobile .category-icon-mobile.active+.category-label-mobile {
            color: #BF3131;
            font-weight: 600;
            font-size: 13px;
            /* Scaled down from desktop 15px */
        }

        /* Mobile Category Scroll Container - UPDATED to match desktop */
        .category-scroll-mobile {
            display: flex;
            overflow-x: auto;
            gap: 20px;
            /* Reduced from desktop 30px */
            padding: 16px 20px;
            /* Reduced from desktop 20px 40px */
            scroll-behavior: smooth;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .category-scroll-mobile::-webkit-scrollbar {
            height: 6px;
            /* Smaller than desktop 8px */
        }

        .category-scroll-mobile::-webkit-scrollbar-track {
            background: transparent;
        }

        .category-scroll-mobile::-webkit-scrollbar-thumb {
            background-color: #BF3131;
            border-radius: 3px;
            border: 1px solid transparent;
            background-clip: content-box;
        }

        .category-scroll-mobile::-webkit-scrollbar-thumb:hover {
            background-color: #a12828;
        }

        /* Responsive Adjustments - UPDATED */
        @media (max-width: 640px) {
            .category-btn-mobile {
                min-width: 65px;
                padding: 6px 2px;
                gap: 8px;
            }

            .category-icon-mobile {
                width: 48px;
                height: 48px;
                border-radius: 12px;
            }

            .category-icon-mobile.active {
                width: 56px;
                height: 56px;
            }

            .category-icon-mobile span {
                font-size: 18px;
            }

            .category-label-mobile {
                font-size: 12px;
            }

            .category-btn-mobile .category-icon-mobile.active+.category-label-mobile {
                font-size: 13px;
            }
        }

        @media (max-width: 480px) {
            .category-btn-mobile {
                min-width: 60px;
                gap: 6px;
            }

            .category-icon-mobile {
                width: 40px;
                height: 40px;
                border-radius: 10px;
            }

            .category-icon-mobile.active {
                width: 48px;
                height: 48px;
            }

            .category-icon-mobile span {
                font-size: 16px;
            }

            .category-label-mobile {
                font-size: 10px;
            }

            .category-btn-mobile .category-icon-mobile.active+.category-label-mobile {
                font-size: 11px;
            }

            .category-scroll-mobile {
                gap: 16px;
                padding: 12px 16px;
            }

        }
    </style>
    <div class="py-16 bg-[#FEF3E2] content_section pt-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 inline-block relative">
                    <span class="bg-clip-text text-transparent bg-[#BF3131]">Pilih Frame Terbaikmu</span>
                    <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-1/2 h-1 bg-[#BF3131] rounded-full">
                    </div>
                </h2>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto">Temukan koleksi frame eksklusif untuk menciptakan kenangan
                    yang tak terlupakan</p>
            </div>

            <!-- Category Selector Section -->
            <div class="mb-8 bg-transparent rounded-xl p-4 sm:p-6">
                <!-- Mobile: Horizontal Scrollable Categories - UPDATED -->
                <div class="block sm:hidden mb-4">
                    <div class="category-scroll-mobile" style="scroll-snap-type: x mandatory;">
                        <a href="{{ route('frametemp') }}" class="category-btn-mobile group flex-shrink-0"
                            style="scroll-snap-align: start;">
                            <div class="category-icon-mobile {{ !isset($selectedCategory) ? 'active' : '' }}">
                                <span>🏠</span>
                            </div>
                            <span class="category-label-mobile">Semua</span>
                        </a>
                        @foreach ($categories as $category)
                            <a href="{{ route('frametemp', ['category' => $category->id]) }}"
                                class="category-btn-mobile group flex-shrink-0" style="scroll-snap-align: start;">
                                <div
                                    class="category-icon-mobile {{ isset($selectedCategory) && $selectedCategory->id == $category->id ? 'active' : '' }}">
                                    <span>{{ $category->icon }}</span>
                                </div>
                                <span class="category-label-mobile">{{ $category->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Desktop: Grid Layout -->
                <div class="hidden sm:flex justify-center items-center">
                    <div class="w-4/5 category-scroll-desktop">
                        <a href="{{ route('frametemp') }}" class="category-btn group flex-shrink-0"
                            style="scroll-snap-align: start;">
                            <div class="category-icon {{ !isset($selectedCategory) ? 'active' : '' }}">
                                <span class="text-lg">🏠</span>
                            </div>
                            <span class="category-label">Semua</span>
                        </a>
                        @foreach ($categories as $category)
                            <a href="{{ route('frametemp', ['category' => $category->id]) }}"
                                class="category-btn group flex-shrink-0" style="scroll-snap-align: start;">
                                <div
                                    class="category-icon {{ isset($selectedCategory) && $selectedCategory->id == $category->id ? 'active' : '' }}">
                                    <span class="text-lg">{{ $category->icon }}</span>
                                </div>
                                <span class="category-label">{{ $category->name }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Mobile Filter Layout -->
            <div class="block sm:hidden">
                <button id="toggleFilter"
                    class="w-full relative flex items-center justify-between px-4 py-3 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 rounded-lg border border-gray-300 transition-all duration-300 text-sm font-medium text-gray-700 mb-3">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        <span>Filter & Urutkan</span>
                    </div>

                    <svg id="filterArrow" xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                    <div
                        class="w-3 h-3 bg-green-500 absolute -top-1 -right-1 z-50 rounded-full {{ !request('sort_rating') && !request('sort_popular') ? 'hidden' : '' }} ">
                    </div>
                </button>

                <div id="filterOptions" class="hidden space-y-2 animate-fade-in mb-4">
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700 block">Urutkan</label>
                        <div class="flex gap-2">
                            <a href="{{ route('frametemp', array_merge(request()->except(['sort_rating', 'sort_popular']), ['sort_rating' => request('sort_rating') == 'desc' ? 'asc' : 'desc'])) }}"
                                class="mobile-rating-filter-btn flex-1 flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-300 border {{ request('sort_rating') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ request('sort_rating') == 'desc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                </svg>
                                <span>Rating
                                    {{ request('sort_rating') == 'desc' ? 'Tinggi ke Rendah' : (request('sort_rating') == 'asc' ? 'Rendah ke Tinggi' : '') }}</span>
                            </a>
                            <a href="{{ route('frametemp', array_merge(request()->except(['sort_rating', 'sort_popular']), ['sort_popular' => request('sort_popular') == 'desc' ? 'asc' : 'desc'])) }}"
                                class="mobile-popular-filter-btn flex-1 flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-300 border {{ request('sort_popular') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ request('sort_popular') == 'desc' ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' }}" />
                                </svg>
                                <span>Popularitas
                                    {{ request('sort_popular') == 'desc' ? 'Tinggi ke Rendah' : (request('sort_popular') == 'asc' ? 'Rendah ke Tinggi' : '') }}</span>
                            </a>
                            <a href="{{ route('frametemp', request()->except(['sort_rating', 'sort_popular'])) }}"
                                class="mobile-default-filter-btn flex-1 flex items-center justify-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-300 border {{ !request('sort_rating') && !request('sort_popular') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                                <span>Default</span>
                            </a>
                        </div>
                    </div>
                </div>

                <div
                    class="flex items-center justify-center gap-2 bg-gradient-to-r from-[#FEF3E2] to-red-50 px-4 py-3 rounded-lg border border-red-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#BF3131]" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span class="text-sm font-medium text-gray-700">
                        <span class="font-bold text-[#BF3131]">{{ $frames->count() }}</span> Frame Tersedia
                    </span>
                </div>
            </div>

            <!-- Desktop Filter Layout -->
            <div class="hidden sm:flex sm:flex-row gap-4 justify-between items-center">
                <div class="flex items-center gap-4">
                    <button id="toggleFilter"
                        class="flex relative items-center gap-2 px-4 py-2 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 rounded-lg border border-gray-300 transition-all duration-300 text-sm font-medium text-gray-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                        </svg>
                        <span>Filter & Urutkan</span>
                        <svg id="filterArrow" xmlns="http://www.w3.org/2000/svg"
                            class="h-4 w-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                        <div
                            class="w-3 h-3 bg-green-500 absolute -top-1 -right-1 z-50 rounded-full {{ !request('sort_rating') && !request('sort_popular') ? 'hidden' : '' }} ">
                        </div>
                    </button>

                    <div id="filterOptions" class="hidden gap-3 animate-fade-in flex">
                        <div class="flex items-center gap-1">
                            <a href="{{ route('frametemp', array_merge(request()->except(['sort_rating', 'sort_popular']), ['sort_rating' => request('sort_rating') == 'desc' ? 'asc' : 'desc'])) }}"
                                class="rating-filter-btn flex items-center gap-1 px-2 py-1 rounded-md text-xs font-medium transition-all duration-300 border {{ request('sort_rating') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ request('sort_rating') == 'desc' ? 'M5 15l7-7 7 7' : 'M19 9l-7 7-7-7' }}" />
                                </svg>
                                <span>Rating
                                    {{ request('sort_rating') == 'desc' ? 'Tinggi ke Rendah' : (request('sort_rating') == 'asc' ? 'Rendah ke Tinggi' : '') }}</span>
                            </a>
                        </div>
                        <div class="w-px h-6 bg-gray-300"></div>
                        <div class="flex items-center gap-1">
                            <a href="{{ route('frametemp', array_merge(request()->except(['sort_rating', 'sort_popular']), ['sort_popular' => request('sort_popular') == 'desc' ? 'asc' : 'desc'])) }}"
                                class="popular-filter-btn flex items-center gap-1 px-2 py-1 rounded-md text-xs font-medium transition-all duration-300 border {{ request('sort_popular') ? 'active' : '' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="{{ request('sort_popular') == 'desc' ? 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6' : 'M13 17h8m0 0V9m0 8l-8-8-4 4-6-6' }}" />
                                </svg>
                                <span>Popularitas
                                    {{ request('sort_popular') == 'desc' ? 'Tinggi ke Rendah' : (request('sort_popular') == 'asc' ? 'Rendah ke Tinggi' : '') }}</span>
                            </a>
                        </div>
                        <div class="w-px h-6 bg-gray-300"></div>
                        <a href="{{ route('frametemp', request()->except(['sort_rating', 'sort_popular'])) }}"
                            class="default-filter-btn flex items-center gap-1 px-2 py-1 rounded-md text-xs font-medium transition-all duration-300 border {{ !request('sort_rating') && !request('sort_popular') ? 'active' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <span>Default</span>
                        </a>
                    </div>
                </div>

                <div
                    class="flex items-center gap-2 bg-gradient-to-r from-[#FEF3E2] to-red-50 px-4 py-2 rounded-lg border border-red-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#BF3131]" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <span class="text-sm font-medium text-gray-700">
                        <span class="font-bold text-[#BF3131]">{{ $frames->count() }}</span> Frame
                    </span>
                </div>
            </div>

            <div class="mt-12">
                @if ($frames->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                        @foreach ($frames as $frame)
                            <div class="group bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 frame-card relative"
                                data-frame-id="{{ $frame->id }}">
                                <div class="absolute top-3 right-3 z-10">
                                    @if ($frame->isFree())
                                        <span
                                            class="bg-gradient-to-r from-green-500 to-green-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            GRATIS
                                        </span>
                                    @else
                                        <span
                                            class="bg-gradient-to-r from-amber-500 to-yellow-400 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                            {{ number_format($frame->price, 0, ',', '.') }} IDR
                                        </span>
                                    @endif
                                </div>
                                <div class="relative h-60 bg-gradient-to-br from-gray-100 to-red-50 overflow-hidden">
                                    <div
                                        class="absolute inset-0 flex items-center justify-center p-4 transition-transform duration-500 group-hover:scale-105">
                                        @if ($frame->image_path)
                                            <img src="{{ asset('storage/' . $frame->image_path) }}"
                                                alt="{{ $frame->name }}" class="max-h-full max-w-full object-contain">
                                        @else
                                            <div class="text-gray-400 text-5xl">🖼️</div>
                                        @endif
                                    </div>
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/80 to-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 backdrop-blur-sm">
                                        <button
                                            class="px-5 py-2.5 bg-white/95 cursor-pointer text-gray-800 rounded-full font-medium hover:bg-red-50 transition-colors duration-300 transform hover:scale-105 preview-button shadow-md flex items-center gap-2"
                                            data-frame-id="{{ $frame->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                                fill="currentColor">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                                <path fill-rule="evenodd"
                                                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Preview
                                        </button>
                                    </div>
                                </div>

                                <div class="p-5 bg-white">
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-start">
                                            <h3
                                                class="text-lg font-semibold text-gray-900 group-hover:text-[#BF3131] transition-colors">
                                                {{ $frame->name }}</h3>
                                            <div class="flex items-center gap-1.5 px-2 py-1 bg-red-50 rounded-full">
                                                <span class="text-base">{{ $frame->category->icon }}</span>
                                                <span class="text-xs text-gray-700">{{ $frame->category->name }}</span>
                                            </div>
                                        </div>
                                        @if ($frame->testimonis_avg_rating)
                                            <div class="flex items-center justify-between">
                                                <div
                                                    class="flex items-center gap-2 bg-gradient-to-r from-yellow-50 to-orange-50 px-3 py-1.5 rounded-lg border border-yellow-200">
                                                    <div class="flex items-center">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= round($frame->testimonis_avg_rating))
                                                                <svg class="w-4 h-4 text-yellow-400 fill-current drop-shadow-sm"
                                                                    viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                                </svg>
                                                            @else
                                                                <svg class="w-4 h-4 text-gray-300 fill-current"
                                                                    viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                                </svg>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <span
                                                        class="text-sm font-semibold text-gray-800">{{ number_format($frame->testimonis_avg_rating, 1) }}</span>
                                                </div>
                                            </div>
                                        @else
                                            <div
                                                class="flex items-center gap-2 bg-gradient-to-r from-gray-50 to-gray-100 px-3 py-1.5 rounded-lg border border-gray-200">
                                                <div class="flex items-center">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <svg class="w-4 h-4 text-gray-300 fill-current"
                                                            viewBox="0 0 20 20">
                                                            <path
                                                                d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
                                                        </svg>
                                                    @endfor
                                                </div>
                                                <span class="text-sm text-gray-500 font-medium">Belum ada rating</span>
                                            </div>
                                        @endif
                                        <div class="border-t border-gray-100"></div>
                                        @if ($frame->isFree())
                                            <a href="{{ route('booth', ['frame_id' => $frame->id]) }}"
                                                class="mt-2 inline-flex items-center justify-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-full text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 w-full transition-all duration-300 shadow-sm hover:shadow-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122" />
                                                </svg>
                                                Gunakan Frame
                                            </a>
                                        @else
                                            <button
                                                onclick="showPremiumAlert('{{ number_format($frame->price, 0, ',', '.') }}')"
                                                class="mt-2 cursor-pointer inline-flex items-center justify-center px-4 py-2.5 border border-transparent text-sm font-medium rounded-full text-white bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 w-full transition-all duration-300 shadow-sm hover:shadow-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                                </svg>
                                                Gunakan Premium
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <div
                                    class="absolute inset-0 rounded-xl bg-gradient-to-r from-red-500/20 to-amber-500/20 opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity duration-300">
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-20 bg-[#FEF3E2]">
                        <div class="inline-block text-7xl mb-6">😥</div>
                        <p class="text-xl text-gray-600 font-light">
                            Tidak ada frame yang tersedia untuk kategori
                            {{ isset($selectedCategory) ? '"' . $selectedCategory->name . '"' : 'ini' }}.
                        </p>
                        <p class="mt-3 text-gray-500">Silakan pilih kategori lain atau kembali lagi nanti.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div id="previewCameraModal" class="hidden fixed inset-0 z-50 flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm modal-backdrop"></div>

        <!-- Desktop Modal -->
        <div
            class="relative bg-white rounded-xl shadow-xl p-6 w-full max-w-4xl mx-4 hidden md:block animate-[modalFadeIn_0.3s]">
            <button
                class="modal-close absolute top-4 right-4 text-2xl text-gray-500 hover:text-black cursor-pointer">×</button>

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
                    class="modal-close absolute top-3 right-4 text-2xl text-gray-500 hover:text-black cursor-pointer">×</button>
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

    <script>
        // Configure toastr options
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-center",
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };

        function showPremiumAlert(price) {
            toastr.warning(
                `Fitur ini masih maintenance`,
                'Fitur Premium', {
                    "timeOut": "5000",
                    "closeButton": true,
                    "positionClass": "toast-top-center",
                    "showMethod": "slideDown",
                    "hideMethod": "slideUp"
                }
            );
        }
    </script>

    <script>
        let isFilterOpen = false;

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize toggle filter functionality
            initializeToggleFilter();

            // Initialize all functionality
            setupFrameCards();
            attachAllListeners();

            // Browser back/forward navigation
            window.addEventListener('popstate', function() {
                location.reload();
            });

            // Load html2canvas if not already present
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
                const overlay = card.querySelector('.group-hover\\:opacity-100');
                const frameId = card.dataset.frameId;

                if (!overlay) {
                    console.warn('Overlay not found for frame card:', card);
                    return;
                }

                let previewBtn = overlay.querySelector('.preview-button');
                if (!previewBtn) {
                    previewBtn = document.createElement('button');
                    previewBtn.className =
                        'px-4 py-2 bg-white/90 text-gray-800 rounded-full font-medium hover:bg-red-50 transition-colors duration-300 transform hover:scale-105 preview-button';
                    previewBtn.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                </svg>
                Preview
            `;
                    previewBtn.dataset.frameId = frameId;
                    overlay.appendChild(previewBtn);
                    console.log('Created preview button for frame ID:', frameId);
                } else {
                    if (frameId && !previewBtn.dataset.frameId) {
                        previewBtn.dataset.frameId = frameId;
                        console.log('Updated preview button with frame ID:', frameId);
                    }
                }

                // Remove existing listeners to prevent duplicates
                previewBtn.removeEventListener('click', openPreviewCameraModal);
                previewBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Preview button clicked for frame ID:', frameId);
                    // Add your preview modal logic here
                    openPreviewCameraModal(e);
                });
            });
        }

        function openPreviewCameraModal(e) {
            e.preventDefault();
            e.stopPropagation();

            console.log('openPreviewCameraModal called');

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

                // Fetch frame template
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
                btn.addEventListener('click', closePreviewCameraModal);
            });

            window.removeEventListener('click', handleModalBackdropClick);
            window.addEventListener('click', handleModalBackdropClick);

            captureButton.addEventListener('click', () => startPhotoSession(false));
            mobileCaptureButton.addEventListener('click', () => startPhotoSession(true));

            enableDragToClose(mobileModalContainer);
        }

        function handleModalBackdropClick(e) {
            const modal = document.getElementById('previewCameraModal');
            if (e.target === modal || e.target.classList.contains('modal-backdrop')) {
                closePreviewCameraModal();
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

        function closePreviewCameraModal() {
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

            if (window.stream) {
                const tracks = window.stream.getTracks();
                tracks.forEach(track => track.stop());
                if (video.srcObject) video.srcObject = null;
                if (mobileVideo.srcObject) mobileVideo.srcObject = null;
                window.stream = null;
            }

            const captureButton = document.getElementById('previewCaptureButton');
            const mobileCaptureButton = document.getElementById('mobilePreviewCaptureButton');
            if (captureButton) captureButton.removeEventListener('click', startPhotoSession);
            if (mobileCaptureButton) mobileCaptureButton.removeEventListener('click', startPhotoSession);
            window.removeEventListener('click', handleModalBackdropClick);

            resetModalState();

            document.body.classList.remove('modal-open');

            setTimeout(() => {
                modal.style.display = 'none';
                if (mobileModalContainer) {
                    mobileModalContainer.classList.remove('hide');
                }
                if (desktopModal) {
                    desktopModal.style.opacity = '';
                    desktopModal.style.transform = '';
                }
            }, 300);

            console.log('Modal closed and state reset');
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

            window.photoSlots = [];
            window.mobilePhotoSlots = [];

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
                    capture.removeEventListener('click', startPhotoSession);
                }
                if (mark) {
                    mark.classList.add('hidden');
                    mark.classList.remove('show');
                }
            };

            resetElements(countdownOverlay, captureButton, watermark);
            resetElements(mobileCountdownOverlay, mobileCaptureButton, mobileWatermark);

            if (window.timer) {
                clearInterval(window.timer);
                window.timer = null;
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
            const photoslots = isMobile ? window.mobilePhotoSlots : window.photoSlots;

            if (window.timer) {
                clearInterval(window.timer);
                window.timer = null;
            }

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

                    // Show toastr notification for premium frames in preview
                    if (data.price > 0) {
                        const price = new Intl.NumberFormat('id-ID').format(data.price);
                        toastr.info(
                            `Frame ini memerlukan pembayaran sebesar ${price} IDR untuk penggunaan penuh.`,
                            'Frame Premium', {
                                "timeOut": "4000",
                                "positionClass": "toast-top-center"
                            }
                        );
                    }

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
            <p>GagalPrimero gagal mengakses kamera. Silakan periksa izin kamera atau coba browser lain.</p>
        `;
            video.parentElement.appendChild(errorMessage);
            captureButton.disabled = true;
            captureButton.textContent = 'Kamera Tidak Tersedia';
        }


        function initializeToggleFilter() {
            // Handle both mobile and desktop toggle buttons
            const toggleButtons = document.querySelectorAll('#toggleFilter');

            toggleButtons.forEach(toggleButton => {
                // Different logic for mobile vs desktop
                let filterOptions;

                // Check if this is mobile (block sm:hidden) or desktop (hidden sm:flex)
                const isMobile = toggleButton.closest('.block.sm\\:hidden') !== null;

                if (isMobile) {
                    // Mobile: filter options are sibling elements
                    filterOptions = toggleButton.closest('.block.sm\\:hidden').querySelector('#filterOptions');
                } else {
                    // Desktop: filter options are in the same flex container, next sibling of the button's parent
                    const buttonContainer = toggleButton.closest('.flex.items-center.gap-4');
                    filterOptions = buttonContainer ? buttonContainer.querySelector('#filterOptions') : null;
                }

                const filterArrow = toggleButton.querySelector('#filterArrow');

                // Check if all required elements exist
                if (!toggleButton || !filterOptions || !filterArrow) {
                    console.warn('Toggle filter elements not found for button:', {
                        toggleButton: !!toggleButton,
                        filterOptions: !!filterOptions,
                        filterArrow: !!filterArrow,
                        isMobile: isMobile
                    });
                    return; // Skip this button if elements are missing
                }

                console.log('Initializing toggle for:', isMobile ? 'Mobile' : 'Desktop', {
                    button: toggleButton,
                    options: filterOptions
                });

                if (isFilterOpen) {
                    showFilterOptions(filterOptions, filterArrow, toggleButton, isMobile);
                } else {
                    hideFilterOptions(filterOptions, filterArrow, toggleButton, isMobile);
                }

                const newToggleButton = toggleButton.cloneNode(true);
                toggleButton.parentNode.replaceChild(newToggleButton, toggleButton);

                newToggleButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation(); // Prevent event bubbling

                    const currentlyOpen = !filterOptions.classList.contains('hidden');
                    isFilterOpen = !currentlyOpen; // Toggle global state

                    const newFilterArrow = newToggleButton.querySelector('#filterArrow');

                    // Toggle visibility
                    if (!currentlyOpen) {
                        showFilterOptions(filterOptions, newFilterArrow, newToggleButton, isMobile);
                    } else {
                        hideFilterOptions(filterOptions, newFilterArrow, newToggleButton, isMobile);
                    }

                    console.log('Filter options toggled:', isFilterOpen ? 'shown' : 'hidden');
                });

                document.addEventListener('click', function(e) {
                    const isClickInsideFilter = newToggleButton.contains(e.target) ||
                        filterOptions.contains(e.target) ||
                        e.target.closest(
                            '.rating-filter-btn, .mobile-rating-filter-btn, .popular-filter-btn, .mobile-popular-filter-btn, .default-filter-btn, .mobile-default-filter-btn'
                        );

                    // Only close if click is completely outside the filter area AND not on a filter button
                    if (!isClickInsideFilter && !e.target.closest('[class*="filter-btn"]')) {
                        const newFilterArrow = newToggleButton.querySelector('#filterArrow');
                        isFilterOpen = false;
                        hideFilterOptions(filterOptions, newFilterArrow, newToggleButton, isMobile);
                        console.log('Filter options closed due to outside click');
                    }
                });

                console.log('Toggle filter initialized successfully for button');
            });
        }

        function showFilterOptions(filterOptions, filterArrow, toggleButton, isMobile) {
            filterOptions.classList.remove('hidden');

            // Add appropriate display class based on mobile/desktop
            if (isMobile) {
                filterOptions.classList.add('animate-fade-in');
            } else {
                filterOptions.classList.add('flex', 'animate-fade-in');
            }

            if (filterArrow) {
                filterArrow.style.transform = 'rotate(180deg)';
            }
            toggleButton.classList.add('bg-[#BF3131]', 'text-white', 'border-[#BF3131]');
            toggleButton.classList.remove('bg-gradient-to-r', 'from-gray-100', 'to-gray-200',
                'text-gray-700', 'border-gray-300');
        }

        function hideFilterOptions(filterOptions, filterArrow, toggleButton, isMobile) {
            filterOptions.classList.add('hidden');
            filterOptions.classList.remove('animate-fade-in');

            // Remove flex class for desktop
            if (!isMobile) {
                filterOptions.classList.remove('flex');
            }

            if (filterArrow) {
                filterArrow.style.transform = 'rotate(0deg)';
            }
            toggleButton.classList.remove('bg-[#BF3131]', 'text-white', 'border-[#BF3131]');
            toggleButton.classList.add('bg-gradient-to-r', 'from-gray-100', 'to-gray-200',
                'text-gray-700', 'border-gray-300');
        }

        function attachAllListeners() {
            console.log('Attaching all listeners...');

            // Attach category listeners
            const categoryLinks = document.querySelectorAll('.category-btn, .category-btn-mobile');
            categoryLinks.forEach(link => {
                const newLink = link.cloneNode(true);
                link.parentNode.replaceChild(newLink, link);

                newLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    const url = this.getAttribute('href');
                    console.log('Category filter clicked:', url);
                    handleFilterRequest(url, 'category');
                });
            });

            // UPDATED: Attach filter listeners - keep filter state
            const filterLinks = document.querySelectorAll(
                '.filter-btn, .mobile-filter-btn, ' +
                '.rating-filter-btn, .mobile-rating-filter-btn, ' +
                '.popular-filter-btn, .mobile-popular-filter-btn, ' +
                '.default-filter-btn, .mobile-default-filter-btn'
            );

            filterLinks.forEach(link => {
                const newLink = link.cloneNode(true);
                link.parentNode.replaceChild(newLink, link);

                newLink.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation(); // ADDED: Prevent event bubbling

                    const url = this.getAttribute('href');
                    console.log('Filter clicked:', url);

                    // Determine filter type based on class
                    let filterType = 'filter';
                    if (this.classList.contains('rating-filter-btn') || this.classList.contains(
                            'mobile-rating-filter-btn')) {
                        filterType = 'rating';
                    } else if (this.classList.contains('popular-filter-btn') || this.classList.contains(
                            'mobile-popular-filter-btn')) {
                        filterType = 'popularitas';
                    } else if (this.classList.contains('default-filter-btn') || this.classList.contains(
                            'mobile-default-filter-btn')) {
                        filterType = 'default';
                    }

                    isFilterOpen = true; // Ensure filter stays open
                    handleFilterRequest(url, filterType);
                });
            });

            // Re-initialize toggle filter after content update
            initializeToggleFilter();

            console.log('All listeners attached successfully');
        }

        function handleFilterRequest(url, filterType = 'filter') {
            if (!url) {
                console.error('No URL provided for filter request');
                return;
            }

            const scrollPosition = window.scrollY;
            console.log(`${filterType} filter clicked:`, url);

            // Show loading indicator with specific message
            showLoadingIndicator(filterType);

            fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                        'Cache-Control': 'no-cache'
                    }
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.text();
                })
                .then(html => {
                    // Add minimum delay for better UX
                    return new Promise(resolve => {
                        setTimeout(() => resolve(html), 300);
                    });
                })
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newContent = doc.querySelector('.content_section');

                    if (newContent) {
                        const currentContent = document.querySelector('.content_section');
                        if (currentContent) {
                            // Check if the response contains frames
                            const framesGrid = newContent.querySelector('.grid');
                            const noFramesMessage = newContent.querySelector('.text-center.py-20');

                            // Smooth transition
                            currentContent.style.transition = 'opacity 0.3s ease';
                            currentContent.style.opacity = '0';

                            setTimeout(() => {
                                currentContent.outerHTML = newContent.outerHTML;

                                // Update URL - PINDAHKAN KE SINI AGAR SELALU DIEKSEKUSI
                                window.history.pushState({}, '', url);

                                // Restore scroll position
                                window.scrollTo(0, scrollPosition);

                                // Reattach listeners
                                attachAllListeners();
                                if (typeof setupFrameCards === 'function') {
                                    setupFrameCards();
                                }

                                const updatedContent = document.querySelector('.content_section');
                                if (updatedContent) {
                                    updatedContent.style.opacity = '0';
                                    updatedContent.style.transition = 'opacity 0.3s ease';
                                    setTimeout(() => {
                                        updatedContent.style.opacity = '1';
                                    }, 50);
                                }

                                hideLoadingIndicator();
                                console.log('Content updated successfully, filter state maintained');
                            }, 300);
                        } else {
                            console.error('Current content_section not found');
                            hideLoadingIndicator();
                            // TETAP UPDATE URL MESKIPUN ERROR
                            window.history.pushState({}, '', url);
                            console.error('Failed to update content section');
                        }
                    } else {
                        console.error('New content_section not found in response');
                        hideLoadingIndicator();

                        // TETAP UPDATE URL DAN KATEGORI MESKIPUN TIDAK ADA FRAME
                        window.history.pushState({}, '', url);

                        updateCategorySelection(url);

                        displayNoFramesMessage(url);

                        console.log('Displayed no frames message');
                    }
                })
                .catch(error => {
                    console.error(`Error fetching ${filterType}:`, error);
                    hideLoadingIndicator();

                    // TETAP UPDATE URL MESKIPUN ERROR
                    window.history.pushState({}, '', url);

                    updateCategorySelection(url);

                    displayNoFramesMessage(url);

                    console.log('Displayed no frames message due to fetch error');
                });
        }

        function updateCategorySelection(url) {
            // Parse URL to get category parameter
            const urlObj = new URL(url, window.location.origin);
            const categoryId = urlObj.searchParams.get('category');

            console.log('Updating category selection for categoryId:', categoryId);

            // Remove active class from all category buttons
            const allCategoryBtns = document.querySelectorAll(
                '.category-btn .category-icon, .category-btn-mobile .category-icon-mobile');
            allCategoryBtns.forEach(btn => {
                btn.classList.remove('active');
            });

            if (categoryId) {
                // PERBAIKAN: Cari berdasarkan href yang berisi category parameter
                const selectedCategoryBtns = document.querySelectorAll(
                    `a[href*="category=${categoryId}"]`
                );

                selectedCategoryBtns.forEach(link => {
                    const categoryIcon = link.querySelector('.category-icon, .category-icon-mobile');
                    if (categoryIcon) {
                        categoryIcon.classList.add('active');
                        console.log('Added active class to category icon for categoryId:', categoryId);
                    }
                });
            } else {
                // PERBAIKAN: Cari link "Semua" yang tidak memiliki parameter category
                const allCategoryLinks = document.querySelectorAll('a[href*="frametemp"]');

                allCategoryLinks.forEach(link => {
                    const href = link.getAttribute('href');
                    // Pastikan ini adalah link "Semua" (tidak ada parameter category)
                    if (href && !href.includes('category=')) {
                        const categoryIcon = link.querySelector('.category-icon, .category-icon-mobile');
                        if (categoryIcon) {
                            categoryIcon.classList.add('active');
                            console.log('Added active class to "Semua" category icon');
                        }
                    }
                });
            }
        }

        function displayNoFramesMessage(url) {
            const framesSection = document.querySelector('.mt-12');
            if (!framesSection) return;

            // Parse URL to get category info
            const urlObj = new URL(url, window.location.origin);
            const categoryId = urlObj.searchParams.get('category');

            let categoryName = 'ini';
            if (categoryId) {
                // PERBAIKAN: Cari nama kategori dari link yang aktif
                const categoryLinks = document.querySelectorAll(`a[href*="category=${categoryId}"]`);

                for (let link of categoryLinks) {
                    const categoryLabel = link.querySelector('.category-label, .category-label-mobile');
                    if (categoryLabel) {
                        categoryName = `"${categoryLabel.textContent.trim()}"`;
                        console.log('Found category name:', categoryName);
                        break;
                    }
                }
            }

            framesSection.innerHTML = `
        <div class="text-center py-20 bg-[#FEF3E2] rounded-2xl">
            <div class="inline-block text-7xl mb-6">😥</div>
            <p class="text-xl text-gray-600 font-light">
                Tidak ada frame yang tersedia untuk kategori ${categoryName}.
            </p>
            <p class="mt-3 text-gray-500">Silakan pilih kategori lain atau kembali lagi nanti.</p>
        </div>
    `;
        }

        function showLoadingIndicator(filterType = 'filter') {
            const framesSection = document.querySelector('.mt-12');

            if (framesSection) {
                // Store original content
                framesSection.setAttribute('data-original-content', framesSection.innerHTML);

                // Determine loading message based on filter type
                let loadingMessage = 'Memuat Frame...';
                let loadingSubtext = 'Mohon tunggu sebentar';
                let loadingIcon = '🔄';

                // Get  category name from the DOM or URL
                const urlParams = new URLSearchParams(window.location.search);
                const categoryId = urlParams.get('category');
                let categoryName = 'ini';
                if (categoryId) {
                    const activeCategory = document.querySelector(
                        `.category-btn[data-category-id="${categoryId}"] .category-label, .category-btn-mobile[data-category-id="${categoryId}"] .category-label-mobile`
                    );
                    categoryName = activeCategory ? activeCategory.textContent : 'Unknown Category';
                }

                switch (filterType) {
                    case 'category':
                        loadingMessage = `Memuat Kategori "${categoryName}"...`;
                        break;
                    case 'rating':
                        loadingMessage = 'Mengurutkan Rating...';
                        break;
                    case 'popularitas':
                        loadingMessage = 'Mengurutkan Popularitas...';
                        break;
                    case 'default':
                        loadingMessage = 'Memuat Urutan Default...';
                        break;
                    default:
                        loadingMessage = 'Memuat Frame...';
                }

                // Create loading overlay that covers the entire frames area
                const loadingHTML = `
            <div id="frames-loading-overlay" class="relative">
                <!-- Loading backdrop -->
                <div class="absolute inset-0 bg-white/80 backdrop-blur-sm z-10 rounded-2xl"></div>
                
                <!-- Loading content -->
                <div class="relative z-20 text-center py-32 bg-[#FEF3E2] ">
                    <!-- Animated loader -->
                    <div class="flex justify-center mb-6">
                        <div class="relative">
                            <!-- Outer spinning ring -->
                            <div class="animate-spin rounded-full h-16 w-16 border-4 border-gray-200"></div>
                            <div class="animate-spin rounded-full h-16 w-16 border-4 border-[#BF3131] border-t-transparent absolute top-0 left-0"></div>
                        </div>
                    </div>
                    
                    <!-- Loading text with animation -->
                    <div class="space-y-2">
                        <h3 class="text-xl font-semibold text-gray-800 ">
                            ${loadingMessage}
                        </h3>
                    </div>
                </div>
            </div>
            
            <style>
                @keyframes loading-progress {
                    0% { width: 0%; }
                    50% { width: 100%; }
                    100% { width: 0%; }
                }
            </style>
        `;

                framesSection.innerHTML = loadingHTML;
                framesSection.style.transition = 'all 0.3s ease';
            }
        }

        function hideLoadingIndicator() {
            const loadingOverlay = document.getElementById('frames-loading-overlay');
            if (loadingOverlay) {
                loadingOverlay.remove();
            }
        }
    </script>

@endsection
