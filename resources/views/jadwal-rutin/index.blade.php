@extends('layouts.app')
@section('title', 'Jadwal Rutin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-gray-800">📅 Jadwal Rutin Pengantaran</h2>
    <a href="{{ route('jadwal-rutin.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
        + Tambah Jadwal
    </a>
</div>

{{-- Jadwal Hari Ini --}}
@if($jadwalHariIni->isNotEmpty())
<div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-6">
    <h3 class="text-sm font-semibold text-blue-700 mb-3">
        📦 Pengantaran Hari Ini ({{ $hariIni }}) — {{ $jadwalHariIni->count() }} pelanggan
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
        @foreach($jadwalHariIni as $j)
        <div class="bg-white rounded-lg p-3 border border-blue-100 flex items-start gap-3">
            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-sm flex-shrink-0">💧</div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-800">{{ $j->pelanggan->nama }}</p>
                <p class="text-xs text-gray-500 truncate">{{ $j->alamat_pengiriman ?? $j->pelanggan->alamat }}</p>
                <p class="text-xs text-gray-400">{{ $j->pelanggan->no_hp ?? '-' }}</p>
            </div>
            <a href="{{ route('transaksi.create', ['pelanggan_id' => $j->pelanggan_id]) }}"
               class="text-xs bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700 whitespace-nowrap flex-shrink-0">
                + Trx
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Filter --}}
<form method="GET" class="flex gap-2 mb-4">
    <select name="hari" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        <option value="">Semua Hari</option>
        @foreach($hariList as $h)
            <option value="{{ $h }}" {{ request('hari') === $h ? 'selected' : '' }}>{{ $h }}</option>
        @endforeach
    </select>
    <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        <option value="">Semua Status</option>
        <option value="aktif" {{ request('status') === 'aktif' ? 'selected' : '' }}>Aktif</option>
        <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
    </select>
    <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-800">Filter</button>
    @if(request()->hasAny(['hari','status']))
        <a href="{{ route('jadwal-rutin.index') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm hover:bg-gray-300">Reset</a>
    @endif
</form>

{{-- Tabel --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Pelanggan</th>
                <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Hari Pengiriman</th>
                <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Alamat Pengiriman</th>
                <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Catatan</th>
                <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Status</th>
                <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($jadwal as $j)
            <tr class="hover:bg-gray-50 {{ !$j->status_aktif ? 'opacity-60' : '' }}">
                <td class="px-5 py-3">
                    <p class="font-medium text-gray-800">{{ $j->pelanggan->nama }}</p>
                    <p class="text-xs text-gray-400">{{ $j->pelanggan->no_hp }}</p>
                </td>
                <td class="px-5 py-3">
                    <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full font-medium">
                        {{ $j->hari_pengiriman }}
                    </span>
                </td>
                <td class="px-5 py-3 text-gray-600 max-w-xs truncate">
                    {{ $j->alamat_pengiriman ?? $j->pelanggan->alamat ?? '-' }}
                </td>
                <td class="px-5 py-3 text-gray-500 text-xs">{{ $j->catatan ?? '-' }}</td>
                <td class="px-5 py-3">
                    <span class="text-xs px-2 py-1 rounded-full font-medium
                        {{ $j->status_aktif ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $j->status_aktif ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="px-5 py-3">
                    <div class="flex gap-2">
                        <a href="{{ route('jadwal-rutin.edit', $j) }}"
                           class="text-xs text-yellow-600 hover:underline">Edit</a>
                        <form method="POST" action="{{ route('jadwal-rutin.toggle', $j) }}">
                            @csrf @method('PATCH')
                            <button class="text-xs {{ $j->status_aktif ? 'text-orange-500' : 'text-green-600' }} hover:underline">
                                {{ $j->status_aktif ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                        </form>
                        <form method="POST" action="{{ route('jadwal-rutin.destroy', $j) }}"
                              onsubmit="return confirm('Hapus jadwal ini?')">
                            @csrf @method('DELETE')
                            <button class="text-xs text-red-600 hover:underline">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-5 py-10 text-center text-gray-400">
                    Belum ada jadwal rutin.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-5 py-4 border-t">{{ $jadwal->links() }}</div>
</div>
@endsection