@extends('layouts.app')
@section('title', 'Manajemen Produk')

@section('content')
<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Manajemen Produk</h2>
        <p class="font-body-md text-body-md text-on-surface-variant mt-1">Kelola daftar layanan isi ulang dan barang fisik depot Anda.</p>
    </div>
    <a href="{{ route('produk.create') }}" class="bg-primary text-on-primary hover:bg-primary/90 active:scale-95 transition-all duration-200 px-6 py-3 rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 shadow-sm whitespace-nowrap">
        <span class="material-symbols-outlined text-[20px]">add</span>
        Tambah Produk Baru
    </a>
</div>

<!-- Metric Cards / Filters -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-gutter mb-8">
    <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl p-6 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-surface-container flex items-center justify-center text-primary">
            <span class="material-symbols-outlined">water_drop</span>
        </div>
        <div>
            <p class="font-label-sm text-label-sm text-on-surface-variant mb-1 uppercase tracking-wider">Total Produk</p>
            <p class="font-headline-md text-headline-md text-on-surface">{{ $produk->count() }}</p>
        </div>
    </div>
    <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl p-6 shadow-sm flex items-center gap-4">
        <div class="w-12 h-12 rounded-lg bg-secondary-container flex items-center justify-center text-secondary">
            <span class="material-symbols-outlined">check_circle</span>
        </div>
        <div>
            <p class="font-label-sm text-label-sm text-on-surface-variant mb-1 uppercase tracking-wider">Produk Aktif</p>
            <p class="font-headline-md text-headline-md text-on-surface">{{ $produk->where('status_aktif', true)->count() }}</p>
        </div>
    </div>
    <!-- Search bar acting as a filter -->
    <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl p-4 shadow-sm flex items-center">
        <div class="relative w-full">
            <form action="{{ route('produk.index') }}" method="GET">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                <input name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2 bg-surface rounded-lg border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface placeholder:text-outline-variant transition-all" placeholder="Cari produk..." type="text"/>
            </form>
        </div>
    </div>
</div>

<!-- Product Catalog Table -->
<div class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container-low border-b border-outline-variant/30 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">Nama Produk</th>
                    <th class="px-6 py-4 font-semibold">Harga</th>
                    <th class="px-6 py-4 font-semibold">Satuan</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-md text-body-md text-on-surface divide-y divide-outline-variant/20">
                @forelse($produk as $p)
                <tr class="hover:bg-surface-container/50 transition-colors {{ !$p->status_aktif ? 'bg-surface-container-low/30' : '' }}">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded bg-primary-container/20 text-primary flex items-center justify-center">
                                <span class="material-symbols-outlined">{{ $p->satuan == 'Galon' ? 'water_bottle' : 'inventory_2' }}</span>
                            </div>
                            <div>
                                <p class="font-semibold text-on-surface">{{ $p->nama_produk }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium">Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-on-surface-variant">{{ $p->satuan }}</td>
                    <td class="px-6 py-4">
                        <form action="{{ route('produk.update', $p) }}" method="POST">
                            @csrf @method('PUT')
                            <input type="hidden" name="nama_produk" value="{{ $p->nama_produk }}">
                            <input type="hidden" name="harga" value="{{ $p->harga }}">
                            <input type="hidden" name="satuan" value="{{ $p->satuan }}">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="status_aktif" value="1" {{ $p->status_aktif ? 'checked' : '' }} class="sr-only peer" onchange="this.form.submit()">
                                <div class="w-11 h-6 bg-outline-variant peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-primary after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                                <span class="ml-3 font-label-sm text-label-sm {{ $p->status_aktif ? 'text-secondary' : 'text-outline' }}">
                                    {{ $p->status_aktif ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </label>
                        </form>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2 text-outline">
                            <a href="{{ route('produk.edit', $p) }}" class="hover:text-primary transition-colors p-1" title="Edit">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                            <form action="{{ route('produk.destroy', $p) }}" method="POST" class="inline" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="hover:text-error transition-colors p-1" title="Hapus">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-on-surface-variant opacity-50">
                        Belum ada data produk.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection