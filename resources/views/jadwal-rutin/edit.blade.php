@extends('layouts.app')
@section('title', 'Edit Jadwal Rutin')

@section('content')
<div class="mb-6">
    <a href="{{ route('jadwal-rutin.index') }}" class="text-xs text-blue-500 hover:underline mb-1 block">← Kembali</a>
    <h2 class="text-xl font-bold text-gray-800">Edit Jadwal Rutin</h2>
</div>

<div class="bg-white rounded-xl shadow p-6 max-w-lg">
    <form method="POST" action="{{ route('jadwal-rutin.update', $jadwalRutin) }}">
        @csrf @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Pelanggan <span class="text-red-500">*</span></label>
            <select name="pelanggan_id"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">-- Pilih Pelanggan --</option>
                @foreach($pelanggan as $p)
                    <option value="{{ $p->id }}" {{ old('pelanggan_id', $jadwalRutin->pelanggan_id) == $p->id ? 'selected' : '' }}>
                        {{ $p->nama }} ({{ $p->no_hp }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Hari Pengiriman <span class="text-red-500">*</span></label>
            <select name="hari_pengiriman"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                @foreach($hariList as $h)
                    <option value="{{ $h }}" {{ old('hari_pengiriman', $jadwalRutin->hari_pengiriman) === $h ? 'selected' : '' }}>{{ $h }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Pengiriman</label>
            <textarea name="alamat_pengiriman" rows="2"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('alamat_pengiriman', $jadwalRutin->alamat_pengiriman) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
            <textarea name="catatan" rows="2"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('catatan', $jadwalRutin->catatan) }}</textarea>
        </div>

        <div class="mb-6">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="status_aktif" value="1"
                       {{ old('status_aktif', $jadwalRutin->status_aktif) ? 'checked' : '' }}
                       class="w-4 h-4 rounded">
                <span class="text-sm text-gray-700">Jadwal Aktif</span>
            </label>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm hover:bg-blue-700">Perbarui</button>
            <a href="{{ route('jadwal-rutin.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg text-sm hover:bg-gray-300">Batal</a>
        </div>
    </form>
</div>
@endsection