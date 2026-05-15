@extends('layouts.app')
@section('title', 'Edit Pelanggan')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <a href="{{ route('pelanggan.index') }}" class="text-xs text-blue-500 hover:underline mb-1 block">← Kembali</a>
        <h2 class="text-xl font-bold text-gray-800">Edit Pelanggan</h2>
    </div>
</div>

<div class="bg-white rounded-xl shadow p-6 max-w-lg">
    <form method="POST" action="{{ route('pelanggan.update', $pelanggan) }}">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pelanggan <span class="text-red-500">*</span></label>
            <input type="text" name="nama" value="{{ old('nama', $pelanggan->nama) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 @error('nama') border-red-400 @enderror">
            @error('nama')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">No HP</label>
            <input type="text" name="no_hp" value="{{ old('no_hp', $pelanggan->no_hp) }}"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
            <textarea name="alamat" rows="3"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('alamat', $pelanggan->alamat) }}</textarea>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
            <textarea name="catatan" rows="2"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('catatan', $pelanggan->catatan) }}</textarea>
        </div>

        <div class="flex gap-3">
            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
                Perbarui
            </button>
            <a href="{{ route('pelanggan.index') }}"
               class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg text-sm hover:bg-gray-300 transition">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection