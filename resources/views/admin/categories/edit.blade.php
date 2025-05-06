@extends('layouts.app-admin')

@section('section')
    <div class="flex-1">
        <header class="bg-white shadow">
            <div class="py-4 px-6">
                <h1 class="text-2xl font-bold">Edit Kategori</h1>
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

            <div class="bg-white rounded-lg shadow p-6">
                <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama
                            Kategori</label>
                        <input type="text" name="name" id="name"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('name', $category->name) }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="icon" class="block text-gray-700 text-sm font-bold mb-2">Icon
                            (Emoji)</label>
                        <input type="text" name="icon" id="icon"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                            value="{{ old('icon', $category->icon) }}" required>
                        <p class="text-sm text-gray-500 mt-1">Masukkan emoji yang sesuai untuk kategori ini. Contoh:
                            📷, 🎉, 👑, dll.</p>
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Perbarui Kategori
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="text-gray-600 hover:text-gray-800">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </main>
    </div>
@endsection
