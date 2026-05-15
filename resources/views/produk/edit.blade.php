@extends('layouts.app')
@section('title', 'Edit Produk')

@section('content')
<div class="mb-6">
    <a href="{{ route('produk.index') }}" class="text-xs text-blue-500 hover:underline mb-1 block">← Kembali</a>
    <h2 class="text-xl font-bold text-gray-800">Edit Produk</h2>
</div>

<div class="bg-white rounded-xl shadow p-6 max-w-lg">
    <form method="POST" action="{{ route('produk.update', $produk) }}">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
            <input type="text" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) <span class="text-red-500">*</span></label>
            <input type="number" name="harga" value="{{ old('harga', $produk->harga) }}" min="0"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Satuan</label>
            <input type="text" name="satuan" value="{{ old('satuan', $produk->satuan) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-6">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="status_aktif" value="1"
                       {{ old('status_aktif', $produk->status_aktif) ? 'checked' : '' }}
                       class="w-4 h-4 rounded">
                <span class="text-sm text-gray-700">Produk Aktif</span>
            </label>
        </div>

        <div class="flex gap-3">
            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700">
                Perbarui
            </button>
            <a href="{{ route('produk.index') }}"
               class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg text-sm hover:bg-gray-300">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection