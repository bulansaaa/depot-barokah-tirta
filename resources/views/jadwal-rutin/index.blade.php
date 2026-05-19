@extends('layouts.app')
@section('title', 'Jadwal Rutin')

@section('content')
<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h2 class="font-headline-lg text-headline-lg text-on-surface">Jadwal Rutin Pengantaran</h2>
        <p class="font-body-md text-body-md text-on-surface-variant mt-1">Kelola pengiriman air rutin mingguan untuk pelanggan tetap.</p>
    </div>
    <a href="{{ route('jadwal-rutin.create') }}" class="bg-primary text-on-primary hover:bg-primary/90 active:scale-95 transition-all duration-200 px-6 py-3 rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 shadow-sm whitespace-nowrap">
        <span class="material-symbols-outlined text-[20px]">add</span>
        Tambah Jadwal
    </a>
</div>

{{-- Jadwal Hari Ini Section --}}
@if($jadwalHariIni->isNotEmpty())
<section class="mb-8">
    <div class="flex items-center gap-2 mb-4">
        <span class="material-symbols-outlined text-primary">local_shipping</span>
        <h3 class="font-headline-sm text-headline-sm font-semibold text-on-surface">Pengantaran Hari Ini ({{ $hariIni }})</h3>
        <span class="bg-primary-container text-on-primary-container font-label-sm text-label-sm px-2 py-0.5 rounded-full ml-2">{{ $jadwalHariIni->count() }} Pelanggan</span>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-gutter">
        @foreach($jadwalHariIni as $j)
        <div class="bg-surface-container-lowest border {{ $j->terkirim_hari_ini ? 'border-secondary/30 bg-secondary/5' : 'border-primary/20' }} rounded-xl p-4 shadow-sm flex items-start gap-4 hover:shadow-md transition-shadow relative overflow-hidden">
            @if($j->terkirim_hari_ini)
                <div class="absolute top-0 right-0 p-1 bg-secondary text-on-secondary rounded-bl-lg">
                    <span class="material-symbols-outlined text-[16px]">check</span>
                </div>
            @endif
            <div class="w-10 h-10 {{ $j->terkirim_hari_ini ? 'bg-secondary/20 text-secondary' : 'bg-primary-container/20 text-primary' }} rounded-full flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined">person</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-body-md text-body-md font-semibold text-on-surface {{ $j->terkirim_hari_ini ? 'line-through opacity-60' : '' }}">{{ $j->pelanggan->nama }}</p>
                <p class="font-label-sm text-label-sm text-on-surface-variant truncate">{{ $j->alamat_pengiriman ?? $j->pelanggan->alamat }}</p>
                <div class="flex items-center gap-2 mt-2">
                    <span class="material-symbols-outlined text-[14px] text-on-surface-variant">phone</span>
                    <span class="font-label-sm text-label-sm text-on-surface-variant">{{ $j->pelanggan->no_hp ?? '-' }}</span>
                </div>
            </div>
            @if(!$j->terkirim_hari_ini)
            <a href="{{ route('transaksi.create', ['pelanggan_id' => $j->pelanggan_id, 'tipe_transaksi' => 'antar']) }}"
               class="bg-primary text-on-primary p-2 rounded-lg hover:bg-surface-tint transition-colors flex-shrink-0" title="Buat Transaksi">
                <span class="material-symbols-outlined">add_shopping_cart</span>
            </a>
            @else
            <div class="text-secondary p-2 flex-shrink-0" title="Sudah Terkirim">
                <span class="material-symbols-outlined icon-filled">check_circle</span>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</section>
@endif

<!-- Filters & List -->
<div class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl shadow-sm overflow-hidden">
    <!-- Toolbar -->
    <div class="p-6 border-b border-outline-variant/30 bg-surface-container-low/50 flex flex-col md:flex-row justify-between items-center gap-4">
        <form method="GET" class="flex flex-wrap gap-3 w-full md:w-auto">
            <select name="hari" class="bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-2 font-body-md text-body-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                <option value="">Semua Hari</option>
                @foreach($hariList as $h)
                    <option value="{{ $h }}" {{ request('hari') === $h ? 'selected' : '' }}>{{ $h }}</option>
                @endforeach
            </select>
            <select name="status" class="bg-surface-container-lowest border border-outline-variant rounded-lg px-4 py-2 font-body-md text-body-md text-on-surface focus:border-primary focus:ring-1 focus:ring-primary outline-none transition-colors">
                <option value="">Semua Status</option>
                <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            <button type="submit" class="bg-surface-container-highest text-primary font-label-md text-label-md px-4 py-2 rounded-lg hover:bg-surface-container transition-colors">Filter</button>
            @if(request()->hasAny(['hari','status']))
                <a href="{{ route('jadwal-rutin.index') }}" class="flex items-center text-on-surface-variant hover:text-primary transition-colors">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </a>
            @endif
        </form>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container-low/30 border-b border-outline-variant/30 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">Pelanggan</th>
                    <th class="px-6 py-4 font-semibold">Hari Pengiriman</th>
                    <th class="px-6 py-4 font-semibold hidden md:table-cell">Alamat</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-md text-body-md text-on-surface divide-y divide-outline-variant/20">
                @forelse($jadwal as $j)
                <tr class="hover:bg-surface-container/50 transition-colors {{ !$j->status_aktif ? 'opacity-60 grayscale' : '' }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <p class="font-semibold text-on-surface">{{ $j->pelanggan->nama }}</p>
                            @if($j->terkirim_hari_ini)
                                <span class="material-symbols-outlined text-secondary text-[18px] icon-filled" title="Terkirim Hari Ini">check_circle</span>
                            @endif
                        </div>
                        <p class="font-label-sm text-label-sm text-on-surface-variant">{{ $j->pelanggan->no_hp }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-primary-container/30 text-primary font-label-md text-label-md px-2.5 py-1 rounded-full">{{ $j->hari_pengiriman }}</span>
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell max-w-xs truncate text-on-surface-variant">
                        {{ $j->alamat_pengiriman ?? $j->pelanggan->alamat ?? '-' }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col gap-1">
                            <span class="font-label-sm text-label-sm font-bold uppercase {{ $j->status_aktif ? 'text-secondary' : 'text-on-surface-variant' }}">
                                {{ $j->status_aktif ? 'Aktif' : 'Nonaktif' }}
                            </span>
                            @if($j->terkirim_hari_ini)
                                <span class="bg-secondary/10 text-secondary text-[10px] font-bold uppercase px-1.5 py-0.5 rounded w-fit">Terkirim</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2 text-on-surface-variant">
                            <a href="{{ route('jadwal-rutin.edit', $j) }}" class="hover:text-primary transition-colors p-1" title="Edit">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                            <form method="POST" action="{{ route('jadwal-rutin.toggle', $j) }}" class="inline">
                                @csrf @method('PATCH')
                                <button class="hover:text-primary transition-colors p-1" title="{{ $j->status_aktif ? 'Nonaktifkan' : 'Aktifkan' }}">
                                    <span class="material-symbols-outlined text-[20px]">{{ $j->status_aktif ? 'toggle_on' : 'toggle_off' }}</span>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('jadwal-rutin.destroy', $j) }}" class="inline" onsubmit="return confirm('Hapus jadwal ini?')">
                                @csrf @method('DELETE')
                                <button class="hover:text-error transition-colors p-1" title="Hapus">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-on-surface-variant opacity-50">
                        Belum ada jadwal rutin.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($jadwal->hasPages())
    <div class="px-6 py-4 border-t border-outline-variant/30 bg-surface-container-low/30">
        {{ $jadwal->links() }}
    </div>
    @endif
</div>
@endsection