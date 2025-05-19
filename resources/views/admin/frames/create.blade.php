@extends('layouts.app-admin')

@section('section')
    <div class="flex-1">
        <header class="bg-white shadow">
            <div class="py-4 px-6">
                <h1 class="text-2xl font-bold">Tambah Frame Baru</h1>
            </div>
        </header>

        <main class="p-6">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <form method="POST" action="{{ route('admin.frames.store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="slug" class="block text-sm font-medium text-gray-700">Slug
                                        (opsional)</label>
                                    <input type="text" name="slug" id="slug" value="{{ old('slug') }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <p class="text-xs text-gray-500 mt-1">Biarkan kosong untuk generate otomatis dari nama
                                    </p>
                                    @error('slug')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="category_id"
                                        class="block text-sm font-medium text-gray-700">Kategori</label>
                                    <select name="category_id" id="category_id"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        <option value="">Pilih Kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="price" class="block text-sm font-medium text-gray-700">Harga
                                        (Rupiah)</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">Rp</span>
                                        </div>
                                        <input type="number" name="price" id="price" min="0"
                                            value="{{ old('price', 0) }}"
                                            class="pl-12 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                            placeholder="0">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Masukkan 0 untuk frame gratis</p>
                                    @error('price')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="frame_image" class="block text-sm font-medium text-gray-700">Gambar
                                        Frame</label>
                                    <input type="file" name="frame_image" id="frame_image"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300">
                                    @error('frame_image')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>


                                <div class="flex items-center justify-end mt-4">
                                    <a href="{{ route('admin.frames.index') }}"
                                        class="mr-4 text-sm text-gray-600 hover:text-gray-900">
                                        Kembali
                                    </a>
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        Simpan Frame
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function toggleImageFields() {
            const slotCount = parseInt(document.getElementById('slot_count').value);
            const containers = [
                document.getElementById('image_2_container'),
                document.getElementById('image_3_container'),
                document.getElementById('image_4_container')
            ];

            // Hide all containers first
            containers.forEach(container => {
                container.style.display = 'none';
            });

            // Show containers based on slot count
            for (let i = 0; i < slotCount - 1; i++) {
                containers[i].style.display = 'block';
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleImageFields();
        });
        // preview image
        const imageInputs = document.querySelectorAll('input[type="file"]');
        imageInputs.forEach(input => {
            input.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.classList.add('h-40', 'w-auto', 'object-contain', 'border',
                            'border-gray-300', 'p-2', 'rounded-md');
                        input.parentNode.insertBefore(img, input.nextSibling);
                    }
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection
