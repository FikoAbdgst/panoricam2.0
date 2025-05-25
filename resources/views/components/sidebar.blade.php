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
                class="flex items-center py-3 px-4 text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.frames.*') ? 'bg-gray-700 text-white' : '' }}">
                <span>Kelola Testimoni</span>
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
