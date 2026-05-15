@extends('layouts.app')
@section('title', 'Data Produk')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-gray-800">🫙 Data Produk</h2>
    <a href="{{ route('produk.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
        + Tambah Produk
    </a>
</div>

{{-- Filter --}}
<form method="GET" class="flex gap-2 mb-4">
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Cari nama produk..."
           class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
    <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        <option value="">Semua Status</option>
        <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
        <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
    </select>
    <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-800">Filter</button>
</form>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">#</th>
                <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Nama Produk</th>
                <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Harga</th>
                <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Satuan</th>
                <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Status</th>
                <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($produk as $p)
            <tr class="hover:bg-gray-50 {{ !$p->status_aktif ? 'opacity-60' : '' }}">
                <td class="px-5 py-3 text-gray-400">{{ $produk->firstItem() + $loop->index }}</td>
                <td class="px-5 py-3 font-medium text-gray-800">{{ $p->nama_produk }}</td>
                <td class="px-5 py-3 text-gray-700 font-medium">
                    Rp {{ number_format($p->harga, 0, ',', '.') }}
                </td>
                <td class="px-5 py-3 text-gray-600">{{ $p->satuan }}</td>
                <td class="px-5 py-3">
                    <span class="text-xs px-2 py-1 rounded-full font-medium
                        {{ $p->status_aktif ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $p->status_aktif ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="px-5 py-3">
                    <div class="flex gap-2">
                        <a href="{{ route('produk.edit', $p) }}"
                           class="text-xs text-yellow-600 hover:underline">Edit</a>
                        <form method="POST" action="{{ route('produk.destroy', $p) }}"
                              onsubmit="return confirm('Nonaktifkan produk ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-xs text-red-600 hover:underline">
                                {{ $p->status_aktif ? 'Nonaktifkan' : 'Sudah nonaktif' }}
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-5 py-10 text-center text-gray-400">Belum ada produk.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-5 py-4 border-t">{{ $produk->links() }}</div>
</div>
@endsection