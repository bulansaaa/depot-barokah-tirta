@extends('layouts.app')
@section('title', 'Manajemen Pelanggan')

@section('content')
<!-- Page Header -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h2 class="font-headline-lg text-headline-lg text-on-background">Manajemen Pelanggan</h2>
        <p class="font-body-md text-body-md text-on-surface-variant mt-1">Kelola database pelanggan, riwayat transaksi, dan detail kontak.</p>
    </div>
    <a href="{{ route('pelanggan.create') }}" class="bg-primary text-on-primary px-6 py-2.5 rounded-lg font-label-md text-label-md flex items-center gap-2 hover:bg-primary/90 transition-colors shadow-sm active:scale-95 duration-200">
        <span class="material-symbols-outlined text-[18px]">add</span>
        Tambah Pelanggan
    </a>
</div>

<!-- Content Card -->
<div class="bg-surface-container-lowest rounded-xl border border-outline-variant/30 shadow-[0_4px_6px_-1px_rgba(0,0,0,0.05)] overflow-hidden">
    <!-- Toolbar -->
    <div class="p-6 border-b border-outline-variant/30 flex flex-col md:flex-row justify-between items-center gap-4 bg-surface-container-low/50">
        <div class="w-full md:w-1/3 relative">
            <form action="{{ route('pelanggan.index') }}" method="GET">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                <input name="search" value="{{ request('search') }}" class="w-full pl-10 pr-4 py-2 bg-surface-container-lowest border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" placeholder="Cari pelanggan..." type="text"/>
            </form>
        </div>
        <div class="flex gap-3 w-full md:w-auto">
            <button class="flex-1 md:flex-none flex items-center justify-center gap-2 px-4 py-2 border border-outline-variant rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container transition-colors">
                <span class="material-symbols-outlined text-[18px]">filter_list</span>
                Filter
            </button>
            <button class="flex-1 md:flex-none flex items-center justify-center gap-2 px-4 py-2 border border-outline-variant rounded-lg font-label-md text-label-md text-on-surface-variant hover:bg-surface-container transition-colors">
                <span class="material-symbols-outlined text-[18px]">download</span>
                Export
            </button>
        </div>
    </div>

    <!-- Table Container -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container-low/30 border-b border-outline-variant/30">
                    <th class="p-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider font-semibold">Nama</th>
                    <th class="p-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider font-semibold">No. HP</th>
                    <th class="p-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider font-semibold hidden md:table-cell">Alamat</th>
                    <th class="p-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/20">
                @forelse($pelanggan as $p)
                <tr class="hover:bg-surface-container-lowest/50 transition-colors group">
                    <td class="p-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded bg-primary-container/30 flex items-center justify-center text-primary font-bold font-label-md">
                                {{ substr($p->nama, 0, 1) }}
                            </div>
                            <div class="font-body-md text-body-md text-on-surface font-medium">{{ $p->nama }}</div>
                        </div>
                    </td>
                    <td class="p-4 font-body-md text-body-md text-on-surface-variant">{{ $p->no_hp ?? '-' }}</td>
                    <td class="p-4 font-body-md text-body-md text-on-surface-variant hidden md:table-cell max-w-xs truncate">{{ $p->alamat ?? '-' }}</td>
                    <td class="p-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('pelanggan.show', $p) }}" class="p-1.5 text-on-surface-variant hover:text-primary hover:bg-primary-container/20 rounded transition-colors" title="Lihat Riwayat">
                                <span class="material-symbols-outlined text-[20px]">history</span>
                            </a>
                            <a href="{{ route('pelanggan.edit', $p) }}" class="p-1.5 text-on-surface-variant hover:text-primary hover:bg-primary-container/20 rounded transition-colors" title="Edit">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                            <form action="{{ route('pelanggan.destroy', $p) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pelanggan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-on-surface-variant hover:text-error hover:bg-error-container/20 rounded transition-colors" title="Hapus">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-12 text-center text-on-surface-variant opacity-50">
                        Belum ada data pelanggan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($pelanggan->hasPages())
    <div class="p-4 border-t border-outline-variant/30 bg-surface-container-low/30">
        {{ $pelanggan->links() }}
    </div>
    @endif
</div>
@endsection