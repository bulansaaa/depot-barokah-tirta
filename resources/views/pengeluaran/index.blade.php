@extends('layouts.app')
@section('title', 'Manajemen Pengeluaran')

@section('content')
<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Manajemen Pengeluaran</h2>
        <p class="font-body-md text-body-md text-on-surface-variant mt-1">Catat dan pantau pengeluaran operasional depot Anda.</p>
    </div>
    <a href="{{ route('pengeluaran.create') }}" class="bg-primary text-on-primary hover:bg-primary/90 active:scale-95 transition-all duration-200 px-6 py-3 rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 shadow-sm whitespace-nowrap">
        <span class="material-symbols-outlined text-[20px]">add</span>
        Catat Pengeluaran Baru
    </a>
</div>

<!-- Filters -->
<div class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl p-4 shadow-sm mb-8">
    <form action="{{ route('pengeluaran.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
            <input name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2 bg-surface rounded-lg border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface placeholder:text-outline-variant transition-all" placeholder="Cari pengeluaran..." type="text"/>
        </div>
        <div>
            <select name="kategori" class="w-full px-4 py-2 bg-surface rounded-lg border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface transition-all">
                <option value="">Semua Kategori</option>
                @foreach($kategoriList as $kat)
                    <option value="{{ $kat }}" {{ request('kategori') == $kat ? 'selected' : '' }}>{{ ucfirst($kat) }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <input name="tanggal" value="{{ request('tanggal') }}" type="date" class="w-full px-4 py-2 bg-surface rounded-lg border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface transition-all">
        </div>
        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-secondary text-on-secondary py-2 rounded-lg font-label-md text-label-md hover:bg-secondary/90 transition-all">Filter</button>
            <a href="{{ route('pengeluaran.index') }}" class="px-4 py-2 border border-outline-variant text-on-surface-variant rounded-lg font-label-md text-label-md hover:bg-surface-container transition-all flex items-center justify-center">Reset</a>
        </div>
    </form>
</div>

<!-- Expenses Table -->
<div class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container-low border-b border-outline-variant/30 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">Tanggal</th>
                    <th class="px-6 py-4 font-semibold">Nama Pengeluaran</th>
                    <th class="px-6 py-4 font-semibold">Kategori</th>
                    <th class="px-6 py-4 font-semibold">Nominal</th>
                    <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-md text-body-md text-on-surface divide-y divide-outline-variant/20">
                @forelse($pengeluaran as $p)
                <tr class="hover:bg-surface-container/50 transition-colors">
                    <td class="px-6 py-4 text-on-surface-variant">{{ $p->tanggal->format('d/m/Y') }}</td>
                    <td class="px-6 py-4">
                        <p class="font-semibold text-on-surface">{{ $p->nama_pengeluaran }}</p>
                        @if($p->keterangan)
                            <p class="text-xs text-on-surface-variant truncate max-w-xs">{{ $p->keterangan }}</p>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-secondary-container/30 text-secondary uppercase tracking-wider">
                            {{ $p->kategori }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-medium text-error">Rp {{ number_format($p->nominal, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2 text-outline">
                            @if($p->foto_nota)
                                <a href="{{ asset('storage/' . $p->foto_nota) }}" target="_blank" class="hover:text-primary transition-colors p-1" title="Lihat Nota">
                                    <span class="material-symbols-outlined text-[20px]">image</span>
                                </a>
                            @endif
                            <a href="{{ route('pengeluaran.edit', $p) }}" class="hover:text-primary transition-colors p-1" title="Edit">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                            <form action="{{ route('pengeluaran.destroy', $p) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pengeluaran ini?')">
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
                        Belum ada data pengeluaran.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($pengeluaran->hasPages())
        <div class="p-4 border-t border-outline-variant/30">
            {{ $pengeluaran->links() }}
        </div>
    @endif
</div>
@endsection
