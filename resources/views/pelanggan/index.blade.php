@extends('layouts.app')
@section('title', 'Data Pelanggan')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-gray-800">👥 Data Pelanggan</h2>
    <a href="{{ route('pelanggan.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
        + Tambah Pelanggan
    </a>
</div>

{{-- Search --}}
<form method="GET" class="mb-4">
    <div class="flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari nama, no HP, alamat..."
               class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        <button type="submit"
                class="bg-gray-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-800">
            Cari
        </button>
        @if(request('search'))
            <a href="{{ route('pelanggan.index') }}"
               class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-300">
                Reset
            </a>
        @endif
    </div>
</form>

{{-- Tabel --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">#</th>
                <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Nama</th>
                <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">No HP</th>
                <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Alamat</th>
                <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Transaksi</th>
                <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($pelanggan as $p)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3 text-gray-400">{{ $pelanggan->firstItem() + $loop->index }}</td>
                <td class="px-5 py-3 font-medium text-gray-800">{{ $p->nama }}</td>
                <td class="px-5 py-3 text-gray-600">{{ $p->no_hp ?? '-' }}</td>
                <td class="px-5 py-3 text-gray-600 max-w-xs truncate">{{ $p->alamat ?? '-' }}</td>
                <td class="px-5 py-3">
                    <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full font-medium">
                        {{ $p->transaksi_count }} transaksi
                    </span>
                </td>
                <td class="px-5 py-3">
                    <div class="flex gap-2">
                        <a href="{{ route('pelanggan.show', $p) }}"
                           class="text-xs text-blue-600 hover:underline">Detail</a>
                        <a href="{{ route('pelanggan.edit', $p) }}"
                           class="text-xs text-yellow-600 hover:underline">Edit</a>
                        <form method="POST" action="{{ route('pelanggan.destroy', $p) }}"
                              onsubmit="return confirm('Hapus pelanggan {{ $p->nama }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-600 hover:underline">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-5 py-10 text-center text-gray-400">
                    Belum ada data pelanggan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-5 py-4 border-t">
        {{ $pelanggan->links() }}
    </div>
</div>
@endsection