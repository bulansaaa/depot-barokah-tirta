<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>{{ config('app.name') }} - @yield('title', 'Dashboard')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script src="https://unpkg.com/lucide@latest"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .icon-filled {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .lucide {
            width: 20px;
            height: 20px;
            stroke-width: 2;
        }
    </style>
    </head>
    <body class="bg-slate-50 font-body-md text-body-md text-gray-900 antialiased" 
      x-init="lucide.createIcons()"
      x-data="{ 
        mobileMenuOpen: false,
        confirmModal: {
            show: false,
            title: '',
            message: '',
            onConfirm: null,
            confirmText: 'Ya, Lanjutkan',
            cancelText: 'Batal'
        },
        confirm(title, message, onConfirm, confirmText = 'Ya, Lanjutkan', cancelText = 'Batal') {
            this.confirmModal.title = title;
            this.confirmModal.message = message;
            this.confirmModal.onConfirm = onConfirm;
            this.confirmModal.confirmText = confirmText;
            this.confirmModal.cancelText = cancelText;
            this.confirmModal.show = true;
        }
      }"
      @confirm.window="confirm($event.detail.title, $event.detail.message, $event.detail.onConfirm, $event.detail.confirmText, $event.detail.cancelText)">

<div class="flex min-h-screen">
    <!-- SideNavBar -->
    <aside class="fixed left-0 top-0 h-screen w-[260px] border-r border-gray-200 bg-white hidden lg:flex flex-col py-8 z-50">
        <div class="px-6 mb-8 flex flex-col gap-2">
            <div>
                <h2 class="font-headline-sm text-headline-sm font-bold text-blue-600">Barokah Tirta</h2>
                <p class="text-xs text-gray-500 mt-1">Depot Air Isi Ulang</p>
            </div>
        </div>
        <nav class="flex-1 flex flex-col gap-0.5">
            <!-- Dashboard -->
            <a class="flex items-center gap-3 px-4 py-3 transition-all duration-200 cursor-pointer {{ request()->routeIs('dashboard') ? 'border-l-4 border-blue-600 text-blue-600 font-semibold bg-blue-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
               href="{{ route('dashboard') }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-blue-600' : '' }}"></i>
                <span class="font-label-md text-label-md">Dashboard</span>
            </a>

            <!-- Pelanggan -->
            <a class="flex items-center gap-3 px-4 py-3 transition-all duration-200 cursor-pointer {{ request()->routeIs('pelanggan.*') ? 'border-l-4 border-blue-600 text-blue-600 font-semibold bg-blue-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
               href="{{ route('pelanggan.index') }}">
                <i data-lucide="users" class="w-5 h-5 {{ request()->routeIs('pelanggan.*') ? 'text-blue-600' : '' }}"></i>
                <span class="font-label-md text-label-md">Pelanggan</span>
            </a>

            <!-- Produk -->
            <a class="flex items-center gap-3 px-4 py-3 transition-all duration-200 cursor-pointer {{ request()->routeIs('produk.*') ? 'border-l-4 border-blue-600 text-blue-600 font-semibold bg-blue-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
               href="{{ route('produk.index') }}">
                <i data-lucide="package" class="w-5 h-5 {{ request()->routeIs('produk.*') ? 'text-blue-600' : '' }}"></i>
                <span class="font-label-md text-label-md">Produk</span>
            </a>

            <!-- Transaksi -->
            <a class="flex items-center gap-3 px-4 py-3 transition-all duration-200 cursor-pointer {{ request()->routeIs('transaksi.*') ? 'border-l-4 border-blue-600 text-blue-600 font-semibold bg-blue-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
               href="{{ route('transaksi.index') }}">
                <i data-lucide="receipt" class="w-5 h-5 {{ request()->routeIs('transaksi.*') ? 'text-blue-600' : '' }}"></i>
                <span class="font-label-md text-label-md">Transaksi</span>
            </a>

            <!-- Pengeluaran -->
            <a class="flex items-center gap-3 px-4 py-3 transition-all duration-200 cursor-pointer {{ request()->routeIs('pengeluaran.*') ? 'border-l-4 border-blue-600 text-blue-600 font-semibold bg-blue-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
               href="{{ route('pengeluaran.index') }}">
                <i data-lucide="wallet" class="w-5 h-5 {{ request()->routeIs('pengeluaran.*') ? 'text-blue-600' : '' }}"></i>
                <span class="font-label-md text-label-md">Pengeluaran</span>
            </a>

            <!-- Jadwal Rutin -->
            <a class="flex items-center gap-3 px-4 py-3 transition-all duration-200 cursor-pointer {{ request()->routeIs('jadwal-rutin.*') ? 'border-l-4 border-blue-600 text-blue-600 font-semibold bg-blue-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
               href="{{ route('jadwal-rutin.index') }}">
                <i data-lucide="calendar" class="w-5 h-5 {{ request()->routeIs('jadwal-rutin.*') ? 'text-blue-600' : '' }}"></i>
                <span class="font-label-md text-label-md">Jadwal Rutin</span>
            </a>

            <!-- Laporan -->
            <a class="flex items-center gap-3 px-4 py-3 transition-all duration-200 cursor-pointer {{ request()->routeIs('laporan.*') ? 'border-l-4 border-blue-600 text-blue-600 font-semibold bg-blue-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}"
               href="{{ route('laporan.index') }}">
                <i data-lucide="bar-chart-3" class="w-5 h-5 {{ request()->routeIs('laporan.*') ? 'text-blue-600' : '' }}"></i>
                <span class="font-label-md text-label-md">Laporan</span>
            </a>
        </nav>
        <div class="mt-auto flex flex-col gap-0.5 border-t border-gray-200 pt-4 px-0">
            <!-- Pengaturan -->
            <a class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:text-gray-900 hover:bg-gray-50 transition-all duration-200 cursor-pointer {{ request()->routeIs('profile.*') ? 'border-l-4 border-blue-600 text-blue-600 font-semibold bg-blue-50' : '' }}"
               href="{{ route('profile.edit') }}">
                <i data-lucide="settings" class="w-5 h-5"></i>
                <span class="font-label-md text-label-md">Pengaturan</span>
            </a>
            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-gray-600 hover:text-red-600 hover:bg-red-50 transition-all duration-200 cursor-pointer">
                    <i data-lucide="log-out" class="w-5 h-5"></i>
                    <span class="font-label-md text-label-md">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Mobile Navigation Menu -->
    <div x-show="mobileMenuOpen"
         class="fixed inset-0 z-[60] lg:hidden"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/50" @click="mobileMenuOpen = false"></div>

        <!-- Sidebar -->
        <div class="fixed left-0 top-0 bottom-0 w-[260px] bg-white flex flex-col py-8"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full">
            <div class="px-6 mb-8 flex flex-col gap-2">
                <div class="h-10 w-10 rounded-full bg-primary-container flex items-center justify-center text-on-primary-container font-headline-sm text-headline-sm font-bold">
                    BT
                </div>
                <div>
                    <h2 class="font-headline-sm text-headline-sm font-bold text-primary">Barokah Tirta</h2>
                </div>
            </div>
            <nav class="flex-1 flex flex-col gap-1 overflow-y-auto">
                <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('dashboard') ? 'border-l-4 border-blue-600 text-blue-600 font-semibold bg-blue-50' : 'text-gray-600' }}" href="{{ route('dashboard') }}">
                    <i data-lucide="layout-dashboard"></i>
                    <span class="font-label-md text-label-md">Dashboard</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('pelanggan.*') ? 'border-l-4 border-blue-600 text-blue-600 font-semibold bg-blue-50' : 'text-gray-600' }}" href="{{ route('pelanggan.index') }}">
                    <i data-lucide="users"></i>
                    <span class="font-label-md text-label-md">Pelanggan</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('produk.*') ? 'border-l-4 border-blue-600 text-blue-600 font-semibold bg-blue-50' : 'text-gray-600' }}" href="{{ route('produk.index') }}">
                    <i data-lucide="package"></i>
                    <span class="font-label-md text-label-md">Produk</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('transaksi.*') ? 'border-l-4 border-blue-600 text-blue-600 font-semibold bg-blue-50' : 'text-gray-600' }}" href="{{ route('transaksi.index') }}">
                    <i data-lucide="receipt"></i>
                    <span class="font-label-md text-label-md">Transaksi</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('pengeluaran.*') ? 'border-l-4 border-blue-600 text-blue-600 font-semibold bg-blue-50' : 'text-gray-600' }}" href="{{ route('pengeluaran.index') }}">
                    <i data-lucide="wallet"></i>
                    <span class="font-label-md text-label-md">Pengeluaran</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('jadwal-rutin.*') ? 'border-l-4 border-blue-600 text-blue-600 font-semibold bg-blue-50' : 'text-gray-600' }}" href="{{ route('jadwal-rutin.index') }}">
                    <i data-lucide="calendar"></i>
                    <span class="font-label-md text-label-md">Jadwal Rutin</span>
                </a>
                <a class="flex items-center gap-3 px-4 py-3 {{ request()->routeIs('laporan.*') ? 'border-l-4 border-blue-600 text-blue-600 font-semibold bg-blue-50' : 'text-gray-600' }}" href="{{ route('laporan.index') }}">
                    <i data-lucide="bar-chart-3"></i>
                    <span class="font-label-md text-label-md">Laporan</span>
                </a>
            </nav>
        </div>
    </div>

    <!-- Main Content Wrapper -->
    <div class="flex-1 lg:ml-[260px] flex flex-col min-h-screen">
        <!-- TopNavBar -->
        <header class="sticky top-0 z-40 flex justify-between items-center px-margin-desktop h-16 w-full bg-surface/80 backdrop-blur-md border-b border-outline-variant/30 shadow-sm">
            <div class="flex items-center gap-4 lg:hidden">
                <i data-lucide="menu" class="text-primary cursor-pointer" @click="mobileMenuOpen = true"></i>
                <span class="font-headline-sm text-headline-sm font-bold text-primary">Depot Barokah Tirta</span>
            </div>
            <div class="hidden lg:flex items-center w-96">
                <form action="{{ route('pelanggan.index') }}" method="GET" class="w-full relative">
                    <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant"></i>
                    <input name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2 bg-surface-container-low border border-outline-variant/30 rounded-full focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary font-body-md text-body-md text-on-surface transition-colors" placeholder="Cari pelanggan..." type="text"/>
                </form>
            </div>
            <div class="flex items-center gap-4">
                <!-- User Profile Summary -->
                <div class="hidden sm:flex items-center gap-3 pr-4 border-r border-outline-variant/30">
                    <div class="text-right">
                        <p class="font-label-md text-label-md font-bold text-on-surface">{{ auth()->user()->name }}</p>
                        <p class="font-label-sm text-label-sm text-on-surface-variant">Administrator</p>
                    </div>
                    @if(auth()->user()->foto)
                        <img src="{{ asset('storage/' . auth()->user()->foto) }}" alt="Profile" class="w-10 h-10 rounded-full object-cover border border-outline-variant/30">
                    @else
                        <div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center text-on-primary-container font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    @endif
                </div>

                <!-- Notification Dropdown -->
                <div class="relative" x-data="{ open: false, tab: 'hari-ini' }">
                    <button @click="open = !open" 
                            class="relative p-2 rounded-full text-on-surface-variant hover:bg-surface-container-low transition-colors cursor-pointer active:scale-95 duration-200">
                        <i data-lucide="bell" :class="open ? 'fill-current' : ''"></i>
                        @php
                            $totalNotif = ($jadwalHariIniGlobal ?? collect())->count() + ($jadwalBesokGlobal ?? collect())->count();
                        @endphp
                        @if($totalNotif > 0)
                            <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-error"></span>
                        @endif
                    </button>
                    
                    <div x-show="open" @click.away="open = false" x-transition
                         class="absolute right-0 mt-2 w-[340px] bg-surface-container-lowest border border-outline-variant/30 rounded-xl shadow-xl z-50 overflow-hidden flex flex-col">
                        
                        <!-- Tabs Header -->
                        <div class="flex border-b border-outline-variant/30 bg-surface-container-low/50">
                            <button @click="tab = 'hari-ini'" 
                                    :class="tab === 'hari-ini' ? 'border-primary text-primary' : 'border-transparent text-on-surface-variant'"
                                    class="flex-1 py-3 px-2 font-label-sm text-label-sm font-bold uppercase border-b-2 transition-colors">
                                Hari Ini ({{ ($jadwalHariIniGlobal ?? collect())->count() }})
                            </button>
                            <button @click="tab = 'besok'" 
                                    :class="tab === 'besok' ? 'border-primary text-primary' : 'border-transparent text-on-surface-variant'"
                                    class="flex-1 py-3 px-2 font-label-sm text-label-sm font-bold uppercase border-b-2 transition-colors">
                                Besok ({{ ($jadwalBesokGlobal ?? collect())->count() }})
                            </button>
                        </div>

                        <!-- Content -->
                        <div class="max-h-[400px] overflow-y-auto">
                            <!-- Hari Ini Tab Content -->
                            <template x-if="tab === 'hari-ini'">
                                <div>
                                    @if(isset($jadwalHariIniGlobal) && $jadwalHariIniGlobal->count() > 0)
                                        @foreach($jadwalHariIniGlobal as $jdwl)
                                            <div class="p-4 border-b border-outline-variant/10 hover:bg-surface-container-low transition-colors">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-primary-container/20 flex items-center justify-center text-primary font-bold text-xs">
                                                        {{ substr($jdwl->pelanggan->nama, 0, 1) }}
                                                    </div>
                                                    <div class="flex-1">
                                                        <p class="font-body-md text-body-md font-semibold text-on-surface">{{ $jdwl->pelanggan->nama }}</p>
                                                        <p class="font-label-sm text-label-sm text-on-surface-variant truncate">{{ $jdwl->alamat_pengiriman ?? $jdwl->pelanggan->alamat }}</p>
                                                    </div>
                                                    <a href="{{ route('transaksi.create', ['pelanggan_id' => $jdwl->pelanggan_id, 'tipe_transaksi' => 'antar']) }}" 
                                                       class="p-1.5 bg-primary/10 text-primary rounded-lg hover:bg-primary hover:text-on-primary transition-colors">
                                                        <i data-lucide="shopping-cart"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="p-8 text-center text-on-surface-variant opacity-50 flex flex-col items-center gap-2">
                                            <i data-lucide="calendar-check-2" class="w-10 h-10"></i>
                                            <p class="font-body-md">Tidak ada jadwal pengiriman hari ini.</p>
                                        </div>
                                    @endif
                                </div>
                            </template>

                            <!-- Besok Tab Content -->
                            <template x-if="tab === 'besok'">
                                <div>
                                    @if(isset($jadwalBesokGlobal) && $jadwalBesokGlobal->count() > 0)
                                        @foreach($jadwalBesokGlobal as $jdwl)
                                            <div class="p-4 border-b border-outline-variant/10 hover:bg-surface-container-low transition-colors">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-8 h-8 rounded-full bg-secondary-container/20 flex items-center justify-center text-secondary font-bold text-xs">
                                                        {{ substr($jdwl->pelanggan->nama, 0, 1) }}
                                                    </div>
                                                    <div class="flex-1">
                                                        <p class="font-body-md text-body-md font-semibold text-on-surface">{{ $jdwl->pelanggan->nama }}</p>
                                                        <p class="font-label-sm text-label-sm text-on-surface-variant truncate">{{ $jdwl->alamat_pengiriman ?? $jdwl->pelanggan->alamat }}</p>
                                                    </div>
                                                    <a href="{{ route('transaksi.create', ['pelanggan_id' => $jdwl->pelanggan_id, 'tipe_transaksi' => 'antar']) }}" 
                                                       class="p-1.5 border border-outline-variant text-on-surface-variant rounded-lg hover:bg-surface-container transition-colors">
                                                        <i data-lucide="shopping-cart"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="p-8 text-center text-on-surface-variant opacity-50 flex flex-col items-center gap-2">
                                            <i data-lucide="calendar-range" class="w-10 h-10"></i>
                                            <p class="font-body-md">Tidak ada jadwal pengiriman untuk besok.</p>
                                        </div>
                                    @endif
                                </div>
                            </template>
                        </div>
                        <a href="{{ route('jadwal-rutin.index') }}" class="block p-3 text-center font-label-md text-label-md text-primary bg-surface-container-low hover:bg-surface-container transition-colors">
                            Lihat Semua Jadwal
                        </a>
                    </div>
                </div>

                <!-- <div class="font-label-md text-label-md text-on-surface-variant ml-2 hidden sm:block">
                    {{ auth()->user()->name }}
                </div> -->
            </div>
        </header>

        <!-- Main Canvas -->
        <main class="flex-1 p-margin-tablet md:p-margin-desktop flex flex-col gap-gutter bg-slate-50">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="bg-secondary-container/20 border border-secondary text-on-secondary-container p-4 rounded-xl flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-secondary">check_circle</span>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-on-surface-variant">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-error-container/20 border border-error text-on-error-container p-4 rounded-xl flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-error">error</span>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-on-surface-variant">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<!-- Global Themed Confirmation Modal -->
<div x-show="confirmModal.show" 
     class="fixed inset-0 z-[100] flex items-center justify-center p-4 overflow-x-hidden overflow-y-auto outline-none"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     style="display: none;">
    
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="confirmModal.show = false"></div>
    
    <div class="relative w-full max-w-md bg-surface-container-lowest rounded-3xl shadow-2xl p-6 md:p-8"
         x-transition:enter="transition ease-out duration-300 transform"
         x-transition:enter-start="scale-95 translate-y-4"
         x-transition:enter-end="scale-100 translate-y-0">
        
        <div class="flex flex-col items-center text-center">
            <div class="w-16 h-16 rounded-full bg-primary-container/20 text-primary flex items-center justify-center mb-6">
                <span class="material-symbols-outlined text-4xl">help_outline</span>
            </div>
            
            <h3 class="font-headline-sm text-headline-sm font-bold text-on-surface mb-2" x-text="confirmModal.title"></h3>
            <p class="font-body-md text-body-md text-on-surface-variant mb-8" x-text="confirmModal.message"></p>
            
            <div class="flex flex-col sm:flex-row gap-3 w-full">
                <button @click="confirmModal.show = false" 
                        class="flex-1 px-6 py-3 rounded-full border border-outline-variant text-on-surface-variant font-label-md text-label-md hover:bg-surface-container transition-colors"
                        x-text="confirmModal.cancelText"></button>
                <button @click="if(confirmModal.onConfirm) confirmModal.onConfirm(); confirmModal.show = false" 
                        class="flex-1 px-6 py-3 rounded-full bg-primary text-on-primary font-label-md text-label-md hover:bg-primary/90 transition-colors shadow-sm"
                        x-text="confirmModal.confirmText"></button>
            </div>
        </div>
    </div>
</div>

</body>
</html>