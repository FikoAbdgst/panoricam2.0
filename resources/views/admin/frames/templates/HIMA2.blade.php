<div class="w-full h-full relative bg-black overflow-hidden shadow-[0_0_20px_rgba(0,0,0,0.3)]">
     <img src="{{ asset('pinkk.png') }}" 
         class="w-[190px] h-[500px] opacity-80 z-10" />
    <!-- First Photo Slot -->
    <div class="absolute top-[20px] left-[10px] w-[calc(100%-20px)] h-[120px]" data-photo-index="0">
        <div class="photo-slot">
            <img id="photo1" src="" class="w-full h-full object-cover">
        </div>
        <button class="retake-button absolute top-1 right-1 text-lg" data-index="0" data-has-photo="false">⟲</button>
    </div>

    <!-- Second Photo Slot -->
    <div class="absolute top-[150px] left-[10px] w-[calc(100%-20px)] h-[120px]" data-photo-index="1">
        <div class="photo-slot">
            <img id="photo2" src="" class="w-full h-full object-cover">
        </div>
        <button class="retake-button absolute top-1 right-1 text-lg" data-index="1" data-has-photo="false">⟲</button>
    </div>

    <!-- Third Photo Slot -->
    <div class="absolute top-[280px] left-[10px] w-[calc(100%-20px)] h-[120px]" data-photo-index="2">
        <div class="photo-slot">
            <img id="photo3" src="" class="w-full h-full object-cover">
        </div>
        <button class="retake-button absolute top-1 right-1 text-lg" data-index="2" data-has-photo="false">⟲</button>
    </div>

    <!-- Frame Footer -->
    <div class="absolute bottom-[-10px] left-0 w-full text-center">
        <img src="{{ asset('pink1.png') }}" alt="Logo" class="h-[100px] w-auto mx-auto">
    </div>
</div>
