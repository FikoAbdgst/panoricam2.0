<!-- resources/views/about.blade.php -->
@extends('layouts.app')

@section('hero section')
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">About Photobooth App</h1>

                    <div class="prose max-w-none">
                        <p class="mb-4">
                            Photobooth App adalah aplikasi yang memungkinkan Anda mengambil foto dengan berbagai pilihan
                            frame menarik.
                            Aplikasi ini dibuat untuk membantu Anda mengabadikan momen spesial dengan tampilan yang lebih
                            keren.
                        </p>

                        <h2 class="text-2xl font-semibold mt-6 mb-4">Fitur Utama</h2>
                        <ul class="list-disc pl-6 mb-6">
                            <li>Akses kamera langsung dari browser</li>
                            <li>Berbagai pilihan frame menarik</li>
                            <li>Simpan foto dengan mudah ke perangkat Anda</li>
                            <li>Antarmuka yang sederhana dan mudah digunakan</li>
                        </ul>

                        <h2 class="text-2xl font-semibold mt-6 mb-4">Cara Penggunaan</h2>
                        <ol class="list-decimal pl-6 mb-6">
                            <li>Klik tombol "Mulai Sekarang" di halaman utama</li>
                            <li>Berikan izin untuk mengakses kamera perangkat Anda</li>
                            <li>Pilih frame yang Anda sukai</li>
                            <li>Klik tombol "Ambil Foto" untuk mengambil gambar</li>
                            <li>Klik tombol "Simpan Foto" untuk mengunduh hasil foto</li>
                        </ol>

                        <p class="mt-8 text-gray-600">
                            Untuk pertanyaan atau bantuan lebih lanjut, silakan hubungi kami melalui email di
                            support@photoboothapp.com
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
