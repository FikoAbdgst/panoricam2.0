@extends('layouts.app-admin')

@section('section')
    <!-- Wrapper untuk mengatur layout antara sidebar dan konten -->
    <div class="flex flex-col md:flex-row min-h-screen">
        <!-- Sidebar: sudah ditangani di layout utama -->

        <!-- Konten Utama -->
        <div class="flex-1">
            <header class="bg-white shadow">
                <div class="py-4 px-4 sm:px-6 lg:px-8">
                    <h1 class="text-2xl font-bold">Dashboard</h1>
                </div>
            </header>

            <main class="p-4 sm:p-6 lg:p-8">
                <div class="bg-white rounded-lg shadow p-4 sm:p-6">
                    <h2 class="text-xl font-semibold mb-4">Selamat Datang di Dashboard Admin</h2>
                    <p class="mb-6">Gunakan sidebar untuk menavigasi ke berbagai bagian panel admin.</p>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="bg-purple-100 p-4 rounded-lg">
                            <h3 class="font-bold text-lg text-purple-800">Kelola Kategori</h3>
                            <p class="text-purple-600 text-sm">Tambah, edit, dan hapus kategori untuk frame photobooth.</p>
                            <a href="{{ route('admin.categories.index') }}"
                                class="mt-2 inline-block text-purple-700 hover:text-purple-900 text-sm">Kelola Sekarang →</a>
                        </div>

                        <div class="bg-blue-100 p-4 rounded-lg">
                            <h3 class="font-bold text-lg text-blue-800">Kelola Frame</h3>
                            <p class="text-blue-600 text-sm">Tambah, edit, dan hapus frame untuk photobooth.</p>
                            <a href="{{ route('admin.frames.index') }}"
                                class="mt-2 inline-block text-blue-700 hover:text-blue-900 text-sm">Kelola Sekarang →</a>
                        </div>

                        <div class="bg-green-100 p-4 rounded-lg">
                            <h3 class="font-bold text-lg text-green-800">Kelola Testimoni</h3>
                            <p class="text-green-600 text-sm">Hapus testimoni dari pengguna.</p>
                            <a href="{{ route('admin.testimoni.index') }}"
                                class="mt-2 inline-block text-green-700 hover:text-green-900 text-sm">Kelola Sekarang →</a>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
