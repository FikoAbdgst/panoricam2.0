@extends('layouts.app-admin')

@section('section')
    <div class="flex-1">
        <header class="bg-white shadow">
            <div class="py-4 px-6 flex justify-between items-center">
                <h1 class="text-2xl font-bold">Kelola Testimoni</h1>
            </div>
        </header>

        <main class="p-6">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pesan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($testimonis as $testimoni)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $testimoni->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $testimoni->rating }} ⭐</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $testimoni->message }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">


                                    <form action="{{ route('admin.testimoni.destroy', $testimoni->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('Hapus testimoni ini?')">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"
                                    class="px-6 py-4 text-center text-sm text-gray-500">
                                    Belum ada testimoni ditambahkan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
@endsection
