@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="flex justify-between items-end mb-6">
    <div>
        <h1 class="font-headline-lg text-headline-lg text-on-surface mb-1 md:font-headline-lg md:text-headline-lg font-headline-lg-mobile text-headline-lg-mobile">Pusat Kendali</h1>
        <p class="font-body-md text-body-md text-on-surface-variant">Ringkasan operasional Depot Barokah Tirta hari ini.</p>
    </div>
    <a href="{{ route('transaksi.create') }}" class="hidden md:flex items-center gap-2 bg-primary text-on-primary px-4 py-2 rounded-lg font-label-md text-label-md hover:bg-surface-tint transition-colors shadow-sm">
        <i data-lucide="plus" class="w-4 h-4"></i>
        Transaksi Baru
    </a>
</div>

<!-- Quick Stats -->
<section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-gutter mb-6">
    <!-- Card 1 -->
    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/30 shadow-sm p-5 md:p-6 relative overflow-hidden flex flex-col justify-between min-h-[120px] md:h-32 hover:shadow-md transition-shadow">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-primary/5 rounded-full blur-xl"></div>
        <div class="flex justify-between items-start gap-2">
            <span class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider text-xs md:text-sm">Transaksi Hari Ini</span>
            <div class="p-2 bg-primary-container/30 rounded-lg text-primary shrink-0">
                <i data-lucide="truck" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">{{ $transaksiHariIni }}</div>
    </div>
    <!-- Card 2 -->
    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/30 shadow-sm p-5 md:p-6 relative overflow-hidden flex flex-col justify-between min-h-[120px] md:h-32 hover:shadow-md transition-shadow">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-secondary/5 rounded-full blur-xl"></div>
        <div class="flex justify-between items-start gap-2">
            <span class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider text-xs md:text-sm">Pendapatan Hari Ini</span>
            <div class="p-2 bg-secondary-container/30 rounded-lg text-secondary shrink-0">
                <i data-lucide="banknote" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</div>
    </div>
    <!-- Card 3 -->
    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/30 shadow-sm p-5 md:p-6 relative overflow-hidden flex flex-col justify-between min-h-[120px] md:h-32 hover:shadow-md transition-shadow">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-tertiary/5 rounded-full blur-xl"></div>
        <div class="flex justify-between items-start gap-2">
            <span class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider text-xs md:text-sm">Pendapatan Bulan Ini</span>
            <div class="p-2 bg-tertiary-container/30 rounded-lg text-tertiary shrink-0">
                <i data-lucide="wallet" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface truncate" title="Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}">
            Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}
        </div>
    </div>
    <!-- Card 4 -->
    <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/30 shadow-sm p-5 md:p-6 relative overflow-hidden flex flex-col justify-between min-h-[120px] md:h-32 hover:shadow-md transition-shadow">
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-primary/5 rounded-full blur-xl"></div>
        <div class="flex justify-between items-start gap-2">
            <span class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider text-xs md:text-sm">Total Pelanggan</span>
            <div class="p-2 bg-primary-container/30 rounded-lg text-primary shrink-0">
                <i data-lucide="users" class="w-5 h-5"></i>
            </div>
        </div>
        <div class="font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">{{ $totalPelanggan }}</div>
    </div>
</section>

<!-- Middle Layout: Monitoring & Jadwal -->
<section class="grid grid-cols-1 lg:grid-cols-12 gap-gutter mb-6">
    <!-- Monitoring Status (col 8) -->
    <div class="lg:col-span-8 flex flex-col gap-gutter">
        <h2 class="font-headline-sm text-headline-sm font-semibold text-on-surface">Monitoring Status</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
            <!-- Pending -->
            <div class="bg-surface-container-lowest border border-tertiary-container rounded-xl p-6 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-tertiary-container/20 flex items-center justify-center text-tertiary">
                    <i data-lucide="clock" class="w-6 h-6"></i>
                </div>
                <div class="flex-1">
                    <div class="font-label-md text-label-md text-tertiary uppercase mb-1">Transaksi Pending</div>
                    <div class="font-headline-md text-headline-md text-on-surface">{{ $transaksiPending }} Pesanan</div>
                </div>
                <a href="{{ route('transaksi.index', ['status' => 'pending']) }}" class="text-tertiary hover:bg-tertiary-container/10 p-2 rounded-full transition-colors">
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </a>
            </div>
            <!-- Dalam Proses -->
            <div class="bg-surface-container-lowest border border-primary-container rounded-xl p-6 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-primary-container/20 flex items-center justify-center text-primary">
                    <i data-lucide="refresh-cw" class="w-6 h-6"></i>
                </div>
                <div class="flex-1">
                    <div class="font-label-md text-label-md text-primary uppercase mb-1">Dalam Proses</div>
                    <div class="font-headline-md text-headline-md text-on-surface">{{ $transaksiDiproses }} Pengiriman</div>
                </div>
                <a href="{{ route('transaksi.index', ['status' => 'diproses']) }}" class="text-primary hover:bg-primary-container/10 p-2 rounded-full transition-colors">
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Jadwal Hari Ini & Besok (col 4) -->
    <div class="lg:col-span-4 bg-surface-container-lowest rounded-xl border border-outline-variant/30 shadow-sm flex flex-col h-[380px]" x-data="{ tab: 'hari-ini' }">
        <div class="p-4 border-b border-outline-variant/30 flex flex-col gap-4">
            <h2 class="font-headline-sm text-headline-sm font-semibold text-on-surface">Jadwal Pengiriman</h2>
            <div class="flex bg-surface-container-low p-1 rounded-lg">
                <button @click="tab = 'hari-ini'" 
                        :class="tab === 'hari-ini' ? 'bg-surface-container-lowest text-primary shadow-sm' : 'text-on-surface-variant'"
                        class="flex-1 py-1.5 px-2 rounded-md font-label-md text-label-md transition-all">
                    Hari Ini
                </button>
                <button @click="tab = 'besok'" 
                        :class="tab === 'besok' ? 'bg-surface-container-lowest text-primary shadow-sm' : 'text-on-surface-variant'"
                        class="flex-1 py-1.5 px-2 rounded-md font-label-md text-label-md transition-all">
                    Besok
                </button>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto p-2">
            <!-- Hari Ini Tab -->
            <div x-show="tab === 'hari-ini'" x-transition>
                @forelse($jadwalHariIni as $jadwal)
                    <div class="flex justify-between items-center p-4 hover:bg-surface-container-low rounded-lg transition-colors border-b border-outline-variant/10 last:border-0">
                        <div class="flex gap-3 items-center min-w-0">
                            <div class="w-8 h-8 rounded-full bg-primary-container/20 flex items-center justify-center text-primary font-bold text-xs shrink-0">
                                {{ substr($jadwal->pelanggan->nama, 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <div class="font-body-md text-body-md font-semibold text-on-surface truncate">{{ $jadwal->pelanggan->nama }}</div>
                                <div class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-1 mt-0.5">
                                    <i data-lucide="map-pin" class="w-3 h-3"></i>
                                    <span class="truncate">{{ $jadwal->alamat_pengiriman ?? $jadwal->pelanggan->alamat }}</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('transaksi.create', ['pelanggan_id' => $jadwal->pelanggan_id, 'tipe_transaksi' => 'antar']) }}" class="bg-primary/10 text-primary hover:bg-primary hover:text-on-primary p-2 rounded-lg transition-colors shrink-0" title="Buat Transaksi">
                            <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                        </a>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-12 text-on-surface-variant opacity-50">
                        <i data-lucide="calendar-check-2" class="w-10 h-10 mb-2"></i>
                        <p class="font-body-md">Tidak ada jadwal hari ini</p>
                    </div>
                @endforelse
            </div>

            <!-- Besok Tab -->
            <div x-show="tab === 'besok'" x-transition style="display: none;">
                @forelse($jadwalBesok as $jadwal)
                    <div class="flex justify-between items-center p-4 hover:bg-surface-container-low rounded-lg transition-colors border-b border-outline-variant/10 last:border-0">
                        <div class="flex gap-3 items-center min-w-0">
                            <div class="w-8 h-8 rounded-full bg-secondary-container/20 flex items-center justify-center text-secondary font-bold text-xs shrink-0">
                                {{ substr($jadwal->pelanggan->nama, 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <div class="font-body-md text-body-md font-semibold text-on-surface truncate">{{ $jadwal->pelanggan->nama }}</div>
                                <div class="font-label-sm text-label-sm text-on-surface-variant flex items-center gap-1 mt-0.5">
                                    <i data-lucide="map-pin" class="w-3 h-3"></i>
                                    <span class="truncate">{{ $jadwal->alamat_pengiriman ?? $jadwal->pelanggan->alamat }}</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('transaksi.create', ['pelanggan_id' => $jadwal->pelanggan_id, 'tipe_transaksi' => 'antar']) }}" class="border border-outline-variant text-on-surface-variant hover:bg-surface-container-high p-2 rounded-lg transition-colors shrink-0" title="Proses Lebih Awal">
                            <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                        </a>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-12 text-on-surface-variant opacity-50">
                        <i data-lucide="calendar-range" class="w-10 h-10 mb-2"></i>
                        <p class="font-body-md">Tidak ada jadwal untuk besok</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<!-- Transaksi Terbaru -->
<section class="bg-surface-container-lowest rounded-xl border border-outline-variant/30 shadow-sm overflow-hidden flex flex-col">
    <div class="p-6 border-b border-outline-variant/30 flex justify-between items-center bg-surface/50 backdrop-blur-sm">
        <h2 class="font-headline-sm text-headline-sm font-semibold text-on-surface">Transaksi Terbaru</h2>
        <a class="font-label-md text-label-md text-primary hover:underline" href="{{ route('transaksi.index') }}">Lihat Semua</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container-low border-b border-outline-variant/30">
                    <th class="p-4 font-label-md text-label-md text-on-surface-variant font-semibold">ID Transaksi</th>
                    <th class="p-4 font-label-md text-label-md text-on-surface-variant font-semibold">Pelanggan</th>
                    <th class="p-4 font-label-md text-label-md text-on-surface-variant font-semibold">Waktu</th>
                    <th class="p-4 font-label-md text-label-md text-on-surface-variant font-semibold">Total</th>
                    <th class="p-4 font-label-md text-label-md text-on-surface-variant font-semibold">Status</th>
                    <th class="p-4 font-label-md text-label-md text-on-surface-variant font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/10">
                @forelse($transaksiTerbaru as $trx)
                    <tr class="hover:bg-surface-container-low/50 transition-colors">
                        <td class="p-4 font-body-md text-body-md text-on-surface">#{{ $trx->kode_transaksi }}</td>
                        <td class="p-4 font-body-md text-body-md text-on-surface font-medium">{{ $trx->pelanggan->nama ?? 'Umum' }}</td>
                        <td class="p-4 font-body-md text-body-md text-on-surface-variant">{{ $trx->tanggal_transaksi->format('H:i') }} WIB</td>
                        <td class="p-4 font-body-md text-body-md text-on-surface font-semibold">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                        <td class="p-4">
                            @php
                                $statusClasses = [
                                    'pending'    => 'bg-tertiary-container/30 text-tertiary',
                                    'diproses'   => 'bg-primary-container/30 text-primary',
                                    'diantar'    => 'bg-secondary-fixed/30 text-on-secondary-fixed-variant',
                                    'selesai'    => 'bg-[#d1fae5] text-[#065f46]',
                                    'dibatalkan' => 'bg-error-container/30 text-error',
                                ][$trx->status_transaksi] ?? 'bg-surface-container text-on-surface-variant';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full font-label-sm text-label-sm font-bold uppercase {{ $statusClasses }}">
                                {{ $trx->status_transaksi }}
                            </span>
                        </td>
                        <td class="p-4 text-right">
                            <a href="{{ route('transaksi.show', $trx) }}" class="text-on-surface-variant hover:text-primary transition-colors p-1">
                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-on-surface-variant opacity-50">
                            Belum ada transaksi hari ini
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection