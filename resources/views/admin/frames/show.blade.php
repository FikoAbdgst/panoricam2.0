@extends('layouts.app-admin')

@section('section')
    <div class="flex-1">
        <header class="bg-white shadow">
            <div class="py-4 px-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold">Detail Frame</h1>
                <div>
                    <a href="{{ route('admin.frames.edit', $frame) }}"
                        class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded mr-2">
                        Edit
                    </a>
                    <a href="{{ route('admin.frames.index') }}"
                        class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                        Kembali
                    </a>
                </div>
            </div>
        </header>

        <main class="p-6">
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <div class="mb-6">
                                <h3 class="text-lg font-semibold mb-2">{{ $frame->name }}</h3>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <p class="text-gray-600 mb-2"><span class="font-medium">ID:</span>
                                            {{ $frame->id }}</p>
                                        <p class="text-gray-600 mb-2"><span class="font-medium">Slug:</span>
                                            {{ $frame->slug }}</p>
                                        <p class="text-gray-600 mb-2"><span class="font-medium">Kategori:</span>
                                            {{ $frame->category ? $frame->category->name : 'Tidak ada kategori' }}</p>
                                        <p class="text-gray-600 mb-2">
                                            <span class="font-medium">Harga:</span>
                                            @if ($frame->price == 0)
                                                <span
                                                    class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Gratis
                                                </span>
                                            @else
                                                <span
                                                    class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                    {{ $frame->formatted_price }}
                                                </span>
                                            @endif
                                        </p>
                                        <p class="text-gray-600 mb-2"><span class="font-medium">Dibuat:</span>
                                            {{ $frame->created_at->format('d M Y H:i') }}</p>
                                        <p class="text-gray-600 mb-2"><span class="font-medium">Terakhir diupdate:</span>
                                            {{ $frame->updated_at->format('d M Y H:i') }}</p>
                                        <p class="text-gray-600 mb-2">
                                            <span class="font-medium">Template:</span>
                                            @if ($frame->templateExists())
                                                <span class="text-green-600">Tersedia</span>
                                            @else
                                                <span class="text-red-600">Belum dibuat</span>
                                                <a href="{{ route('admin.frames.createTemplate', $frame) }}"
                                                    class="ml-2 text-blue-600 hover:text-blue-900">Buat Template</a>
                                            @endif
                                        </p>
                                    </div>

                                    <div>
                                        @if ($frame->image_path)
                                            <p class="text-gray-600  mb-2 font-medium">Preview Frame:</p>
                                            <img src="{{ Storage::url($frame->image_path) }}" alt="{{ $frame->name }}"
                                                class="max-w-1/4 h-auto rounded-lg shadow-md">
                                        @else
                                            <p class="text-gray-600 mb-2 font-medium">Tidak ada gambar frame</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center mt-6">
                                <a href="{{ route('admin.frames.index') }}"
                                    class="mr-4 text-sm text-gray-600 hover:text-gray-900">
                                    Kembali
                                </a>
                                <a href="{{ route('admin.frames.edit', $frame) }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    Edit Frame
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
@section('scripts')
    <script>
        // JavaScript untuk menampilkan gambar preview saat mengupload
        document.addEventListener('DOMContentLoaded', function() {
            const imageInputs = document.querySelectorAll('input[type="file"]');
            imageInputs.forEach(input => {
                input.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const imgPreview = document.createElement('img');
                            imgPreview.src = e.target.result;
                            imgPreview.classList.add('w-full', 'h-auto', 'object-contain',
                                'border', 'border-gray-300',
                                'rounded-md');
                            input.parentNode.appendChild(imgPreview);
                        }
                        reader.readAsDataURL(file);
                    }
                });
            });
        });
    </script>
@endsection
