@extends('layouts.app')
@section('title', 'Pusat Laporan')

@section('content')
<div class="mb-8">
    <h1 class="font-headline-lg text-headline-lg text-on-surface mb-1">Pusat Laporan</h1>
    <p class="font-body-md text-body-md text-on-surface-variant">Analisis performa bisnis Depot Barokah Tirta Anda.</p>
</div>

<!-- Report Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-gutter mb-8">
    <!-- Summary Today -->
    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/30 p-6 flex items-start gap-6 shadow-sm">
        <div class="w-16 h-16 rounded-2xl bg-primary-container/20 flex items-center justify-center text-primary shrink-0">
            <span class="material-symbols-outlined text-4xl icon-filled">today</span>
        </div>
        <div class="flex-1">
            <h3 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-2">Performa Hari Ini</h3>
            <div class="space-y-1">
                <div class="flex justify-between items-center">
                    <span class="text-xs text-on-surface-variant">Pendapatan:</span>
                    <span class="font-medium text-on-surface">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-on-surface-variant">Pengeluaran:</span>
                    <span class="font-medium text-error">Rp {{ number_format($pengeluaranHariIni, 0, ',', '.') }}</span>
                </div>
                <div class="pt-1 mt-1 border-t border-outline-variant/30 flex justify-between items-center">
                    <span class="text-xs font-bold text-on-surface">Laba Bersih:</span>
                    <span class="font-bold text-secondary">Rp {{ number_format($pendapatanHariIni - $pengeluaranHariIni, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Month -->
    <div class="bg-surface-container-lowest rounded-2xl border border-outline-variant/30 p-6 flex items-start gap-6 shadow-sm">
        <div class="w-16 h-16 rounded-2xl bg-secondary-container/20 flex items-center justify-center text-secondary shrink-0">
            <span class="material-symbols-outlined text-4xl icon-filled">calendar_month</span>
        </div>
        <div class="flex-1">
            <h3 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-2">Performa Bulan Ini</h3>
            <div class="space-y-1">
                <div class="flex justify-between items-center">
                    <span class="text-xs text-on-surface-variant">Pendapatan:</span>
                    <span class="font-medium text-on-surface">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-on-surface-variant">Pengeluaran:</span>
                    <span class="font-medium text-error">Rp {{ number_format($pengeluaranBulanIni, 0, ',', '.') }}</span>
                </div>
                <div class="pt-1 mt-1 border-t border-outline-variant/30 flex justify-between items-center">
                    <span class="text-xs font-bold text-on-surface">Laba Bersih:</span>
                    <span class="font-bold text-secondary">Rp {{ number_format($pendapatanBulanIni - $pengeluaranBulanIni, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Report Options -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-gutter">
    <!-- Harian Card -->
    <div class="group bg-surface-container-lowest rounded-2xl border border-outline-variant/30 shadow-sm hover:shadow-md transition-all overflow-hidden flex flex-col">
        <div class="p-8 flex-1">
            <div class="w-12 h-12 rounded-xl bg-tertiary-container/30 text-tertiary flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-3xl">event_note</span>
            </div>
            <h2 class="font-headline-sm text-headline-sm font-bold text-on-surface mb-2">Laporan Harian</h2>
            <p class="font-body-md text-body-md text-on-surface-variant mb-6">
                Lihat rincian transaksi, detail produk yang terjual, dan total pendapatan untuk hari tertentu secara mendalam.
            </p>
        </div>
        <div class="p-6 bg-surface-container-low/50 border-t border-outline-variant/30 flex justify-end">
            <a href="{{ route('laporan.harian') }}" class="flex items-center gap-2 text-primary font-label-md text-label-md hover:underline">
                Buka Laporan Harian
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>
    </div>

    <!-- Bulanan Card -->
    <div class="group bg-surface-container-lowest rounded-2xl border border-outline-variant/30 shadow-sm hover:shadow-md transition-all overflow-hidden flex flex-col">
        <div class="p-8 flex-1">
            <div class="w-12 h-12 rounded-xl bg-primary-container/30 text-primary flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-3xl">query_stats</span>
            </div>
            <h2 class="font-headline-sm text-headline-sm font-bold text-on-surface mb-2">Laporan Bulanan</h2>
            <p class="font-body-md text-body-md text-on-surface-variant mb-6">
                Pantau tren penjualan bulanan, rekap harian dalam satu bulan, dan ringkasan total pendapatan kotor Anda.
            </p>
        </div>
        <div class="p-6 bg-surface-container-low/50 border-t border-outline-variant/30 flex justify-end">
            <a href="{{ route('laporan.bulanan') }}" class="flex items-center gap-2 text-primary font-label-md text-label-md hover:underline">
                Buka Laporan Bulanan
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </a>
        </div>
    </div>
</div>
@endsection
