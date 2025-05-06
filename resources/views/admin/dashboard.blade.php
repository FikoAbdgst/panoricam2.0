@extends('layouts.app-admin')

@section('section')
    <!-- Content -->
    <div class="flex-1">
        <header class="bg-white shadow">
            <div class="py-4 px-6">
                <h1 class="text-2xl font-bold">Dashboard</h1>
            </div>
        </header>

        <main class="p-6">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-4">Selamat Datang di Dashboard Admin</h2>
                <p>Gunakan sidebar untuk menavigasi ke berbagai bagian panel admin.</p>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-purple-100 p-4 rounded-lg">
                        <h3 class="font-bold text-lg text-purple-800">Kelola Kategori</h3>
                        <p class="text-purple-600">Tambah, edit, dan hapus kategori untuk frame photobooth.</p>
                        <a href="{{ route('admin.categories.index') }}"
                            class="mt-2 inline-block text-purple-700 hover:text-purple-900">Kelola Sekarang →</a>
                    </div>

                    <div class="bg-blue-100 p-4 rounded-lg">
                        <h3 class="font-bold text-lg text-blue-800">Kelola Frame</h3>
                        <p class="text-blue-600">Tambah, edit, dan hapus frame untuk photobooth.</p>
                        <a href="{{ route('admin.frames.index') }}"
                            class="mt-2 inline-block text-blue-700 hover:text-blue-900">Kelola Sekarang →</a>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
