@extends('layouts.app-admin')

@section('section')
    <div class="flex-1">
        <header class="bg-white shadow">
            <div class="py-4 px-6">
                <h1 class="text-2xl font-bold">Edit Frame</h1>
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
                            <form method="POST" action="{{ route('admin.frames.update', $frame) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-4">
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nama</label>
                                    <input type="text" name="name" id="name"
                                        value="{{ old('name', $frame->name) }}"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="slug" class="block text-sm font-medium text-gray-700">Slug</label>
                                    <input type="text" name="slug" id="slug"
                                        value="{{ old('slug', $frame->slug) }}"
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
                                                {{ old('category_id', $frame->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select name="status" id="status"
                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        @foreach (App\Models\Frame::getStatusOptions() as $value => $label)
                                            <option value="{{ $value }}"
                                                {{ old('status', $frame->status) == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="frame_image" class="block text-sm font-medium text-gray-700">Gambar
                                        Frame</label>
                                    @if ($frame->image_path)
                                        <div class="mt-2 mb-2">
                                            <img src="{{ Storage::url($frame->image_path) }}" alt="{{ $frame->name }}"
                                                class="w-32 h-32 object-cover">
                                            <p class="text-xs text-gray-500">Frame saat ini</p>
                                        </div>
                                    @endif
                                    <input type="file" name="frame_image" id="frame_image"
                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300">
                                    <p class="text-xs text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah gambar
                                    </p>
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
                                        Update Frame
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
        // Auto-generate slug when name changes
        document.getElementById('name').addEventListener('blur', function() {
            const nameField = this.value;
            const slugField = document.getElementById('slug');

            if (!slugField.value) {
                // Simple slug generation
                slugField.value = nameField.toLowerCase()
                    .replace(/[^\w ]+/g, '')
                    .replace(/ +/g, '-');
            }
        });
    </script>
@endsection
</div>
