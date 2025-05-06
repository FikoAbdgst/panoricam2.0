{{-- Frame Template: Vertical Frame --}}
<div class="vertical-frame absolute inset-0 pointer-events-none">
    {{-- Border frame --}}
    <div class="absolute inset-0 border-8 border-white rounded-lg shadow-inner z-10"></div>

    {{-- Background decorations --}}
    <div class="absolute top-0 left-0 w-full h-8 bg-gradient-to-r from-blue-500 to-purple-500 opacity-50 z-10"></div>
    <div class="absolute bottom-0 left-0 w-full h-8 bg-gradient-to-r from-purple-500 to-blue-500 opacity-50 z-10"></div>

    {{-- 3 Vertical Photo Slots with same aspect ratio as camera (4:3) --}}
    <div class="absolute inset-0 flex flex-col items-center justify-between py-10 px-8">
        {{-- Photo Slot 1 --}}
        <div class="photo-slot w-full h-[28%] border-4 border-white rounded-lg shadow-inner bg-gray-200 bg-opacity-20 overflow-hidden"
            data-slot="0">
            <!-- Photo will be displayed as background image by JavaScript -->
        </div>

        {{-- Photo Slot 2 --}}
        <div class="photo-slot w-full h-[28%] border-4 border-white rounded-lg shadow-inner bg-gray-200 bg-opacity-20 overflow-hidden"
            data-slot="1">
            <!-- Photo will be displayed as background image by JavaScript -->
        </div>

        {{-- Photo Slot 3 --}}
        <div class="photo-slot w-full h-[28%] border-4 border-white rounded-lg shadow-inner bg-gray-200 bg-opacity-20 overflow-hidden"
            data-slot="2">
            <!-- Photo will be displayed as background image by JavaScript -->
        </div>
    </div>

    {{-- Frame corner decorations --}}
    <div class="absolute top-0 left-0 w-16 h-16 border-t-4 border-l-4 border-blue-500 rounded-tl-lg z-20"></div>
    <div class="absolute top-0 right-0 w-16 h-16 border-t-4 border-r-4 border-blue-500 rounded-tr-lg z-20"></div>
    <div class="absolute bottom-0 left-0 w-16 h-16 border-b-4 border-l-4 border-blue-500 rounded-bl-lg z-20"></div>
    <div class="absolute bottom-0 right-0 w-16 h-16 border-b-4 border-r-4 border-blue-500 rounded-br-lg z-20"></div>
</div>
