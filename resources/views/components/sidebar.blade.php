<div class="w-64 bg-gray-800 text-white flex flex-col justify-between min-h-screen">
    <div>
        <div class="p-4">
            <h2 class="text-2xl font-bold">Photobooth Admin</h2>
            <p class="text-sm text-gray-400 mt-1">Selamat datang, {{ session('admin_name') }}</p>
        </div>
        <nav class="mt-6 flex flex-col space-y-2">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center py-3 px-4 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : '' }}">
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.categories.index') }}"
                class="flex items-center py-3 px-4 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.categories.*') ? 'bg-gray-700 text-white' : '' }}">
                <span>Kelola Kategori</span>
            </a>
            <a href="{{ route('admin.frames.index') }}"
                class="flex items-center py-3 px-4 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.frames.*') ? 'bg-gray-700 text-white' : '' }}">
                <span>Kelola Frame</span>
            </a>
            <a href="{{ route('admin.testimoni.index') }}"
                class="flex items-center py-3 px-4 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.testimoni.*') ? 'bg-gray-700 text-white' : '' }}">
                <span>Kelola Testimoni</span>
            </a>
            <a href="{{ route('admin.transactions.index') }}"
                class="flex items-center py-3 px-4 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.transactions.*') ? 'bg-gray-700 text-white' : '' }}">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Kelola Transaksi</span>
            </a>
        </nav>
    </div>

    <div class="mb-4">
        <a href="{{ route('admin.logout') }}"
            class="flex items-center bg-red-700 py-3 px-4 mx-4 mb-4 rounded text-gray-300 hover:bg-red-800 hover:text-white">
            <span>Logout</span>
        </a>
    </div>
</div>
