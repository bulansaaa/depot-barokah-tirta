<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - @yield('title', 'Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans">

    {{-- Sidebar + Main Layout --}}
    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        <aside class="w-64 bg-blue-900 text-white flex flex-col fixed h-full z-10">
            {{-- Logo --}}
            <div class="p-5 border-b border-blue-700">
                <h1 class="text-xl font-bold">💧 Barokah Tirta</h1>
                <p class="text-blue-300 text-xs mt-1">Depot Air Minum Isi Ulang</p>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                          {{ request()->routeIs('dashboard') ? 'bg-blue-700 text-white' : 'text-blue-200 hover:bg-blue-800' }}">
                    <span>🏠</span> Dashboard
                </a>

                <div class="pt-3 pb-1">
                    <p class="text-blue-400 text-xs uppercase tracking-wider px-3">Master Data</p>
                </div>

                <a href="{{ route('pelanggan.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                          {{ request()->routeIs('pelanggan.*') ? 'bg-blue-700 text-white' : 'text-blue-200 hover:bg-blue-800' }}">
                    <span>👥</span> Pelanggan
                </a>

                <a href="{{ route('produk.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                          {{ request()->routeIs('produk.*') ? 'bg-blue-700 text-white' : 'text-blue-200 hover:bg-blue-800' }}">
                    <span>🫙</span> Produk
                </a>

                <div class="pt-3 pb-1">
                    <p class="text-blue-400 text-xs uppercase tracking-wider px-3">Operasional</p>
                </div>

                <a href="{{ route('transaksi.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                          {{ request()->routeIs('transaksi.*') ? 'bg-blue-700 text-white' : 'text-blue-200 hover:bg-blue-800' }}">
                    <span>🧾</span> Transaksi
                </a>

                <a href="{{ route('jadwal-rutin.index') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                          {{ request()->routeIs('jadwal-rutin.*') ? 'bg-blue-700 text-white' : 'text-blue-200 hover:bg-blue-800' }}">
                    <span>📅</span> Jadwal Rutin
                </a>

                <div class="pt-3 pb-1">
                    <p class="text-blue-400 text-xs uppercase tracking-wider px-3">Laporan</p>
                </div>

                <a href="{{ route('laporan.harian') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                          {{ request()->routeIs('laporan.harian') ? 'bg-blue-700 text-white' : 'text-blue-200 hover:bg-blue-800' }}">
                    <span>📊</span> Laporan Harian
                </a>

                <a href="{{ route('laporan.bulanan') }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition
                          {{ request()->routeIs('laporan.bulanan') ? 'bg-blue-700 text-white' : 'text-blue-200 hover:bg-blue-800' }}">
                    <span>📈</span> Laporan Bulanan
                </a>
            </nav>

            {{-- User Info + Logout --}}
            <div class="p-4 border-t border-blue-700">
                <p class="text-sm text-blue-200">{{ auth()->user()->name }}</p>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button type="submit"
                            class="text-xs text-blue-400 hover:text-white transition">
                        Logout →
                    </button>
                </form>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="ml-64 flex-1 flex flex-col">
            {{-- Top Bar --}}
            <header class="bg-white shadow-sm px-6 py-4 flex justify-between items-center sticky top-0 z-10">
                <h2 class="text-lg font-semibold text-gray-700">@yield('title', 'Dashboard')</h2>
                <div class="text-sm text-gray-500">
                    {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </div>
            </header>

            {{-- Flash Messages --}}
            <div class="px-6 pt-4">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4 flex justify-between">
                        <span>✅ {{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">✕</button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4 flex justify-between">
                        <span>❌ {{ session('error') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">✕</button>
                    </div>
                @endif
            </div>

            {{-- Page Content --}}
            <div class="p-6 flex-1">
                @yield('content')
            </div>
        </main>
    </div>

</body>
</html>