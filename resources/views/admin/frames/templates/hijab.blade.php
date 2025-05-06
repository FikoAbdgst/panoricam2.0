{{-- Frame Template: Cat Theme Vertical Frame --}}
<div class="cat-frame absolute inset-0 pointer-events-none font-[sans-serif]">
    {{-- Border frame --}}
    <div class="absolute inset-0 border-8 border-pink-200 rounded-xl shadow-inner z-10"></div>

    {{-- Background decorations --}}
    <div
        class="absolute top-0 left-0 w-full h-8 bg-gradient-to-r from-pink-300 via-yellow-200 to-pink-300 opacity-60 z-10">
    </div>
    <div
        class="absolute bottom-0 left-0 w-full h-8 bg-gradient-to-r from-pink-300 via-yellow-200 to-pink-300 opacity-60 z-10">
    </div>

    {{-- Paw print decoration (top left) --}}
    <img src="https://cdn-icons-png.flaticon.com/512/616/616408.png" alt="cat paw"
        class="absolute top-2 left-2 w-10 h-10 opacity-70 z-20 rotate-[-15deg]">

    {{-- Cat silhouette (bottom right) --}}
    <img src="https://cdn-icons-png.flaticon.com/512/616/616408.png" alt="cat silhouette"
        class="absolute bottom-2 right-2 w-10 h-10 opacity-70 z-20 rotate-[15deg]">

    {{-- 3 Vertical Photo Slots --}}
    <div class="absolute inset-0 flex flex-col items-center justify-between py-10 px-8">
        <div class="photo-slot w-full h-[28%] border-4 border-white rounded-lg shadow-inner bg-yellow-100 bg-opacity-30 overflow-hidden"
            data-slot="0"></div>
        <div class="photo-slot w-full h-[28%] border-4 border-white rounded-lg shadow-inner bg-yellow-100 bg-opacity-30 overflow-hidden"
            data-slot="1"></div>
        <div class="photo-slot w-full h-[28%] border-4 border-white rounded-lg shadow-inner bg-yellow-100 bg-opacity-30 overflow-hidden"
            data-slot="2"></div>
    </div>

    {{-- Paw-decorated corners --}}
    <div class="absolute top-0 left-0 w-14 h-14 border-t-4 border-l-4 border-pink-300 rounded-tl-xl z-20"></div>
    <div class="absolute top-0 right-0 w-14 h-14 border-t-4 border-r-4 border-pink-300 rounded-tr-xl z-20"></div>
    <div class="absolute bottom-0 left-0 w-14 h-14 border-b-4 border-l-4 border-pink-300 rounded-bl-xl z-20"></div>
    <div class="absolute bottom-0 right-0 w-14 h-14 border-b-4 border-r-4 border-pink-300 rounded-br-xl z-20"></div>
</div>
