@extends('layouts.app')
@section('title', 'Detail Pelanggan')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <a href="{{ route('pelanggan.index') }}" class="text-xs text-blue-500 hover:underline mb-1 block">← Kembali</a>
        <h2 class="text-xl font-bold text-gray-800">Detail Pelanggan</h2>
    </div>
    <a href="{{ route('transaksi.create', ['pelanggan_id' => $pelanggan->id]) }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
        + Buat Transaksi
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    {{-- Info Pelanggan --}}
    <div class="bg-white rounded-xl shadow p-6">
        <h3 class="font-semibold text-gray-700 mb-4">📋 Informasi</h3>
        <div class="space-y-3 text-sm">
            <div>
                <p class="text-gray-400">Nama</p>
                <p class="font-medium text-gray-800">{{ $pelanggan->nama }}</p>
            </div>
            <div>
                <p class="text-gray-400">No HP</p>
                <p class="font-medium text-gray-800">{{ $pelanggan->no_hp ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-400">Alamat</p>
                <p class="font-medium text-gray-800">{{ $pelanggan->alamat ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-400">Catatan</p>
                <p class="font-medium text-gray-800">{{ $pelanggan->catatan ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-400">Total Belanja</p>
                <p class="font-bold text-green-600 text-lg">
                    Rp {{ number_format($totalBelanja, 0, ',', '.') }}
                </p>
            </div>
        </div>
        <div class="mt-4 pt-4 border-t">
            <a href="{{ route('pelanggan.edit', $pelanggan) }}"
               class="block text-center bg-yellow-400 text-white py-2 rounded-lg text-sm hover:bg-yellow-500">
                Edit Data
            </a>
        </div>
    </div>

    {{-- Jadwal Rutin --}}
    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-gray-700">📅 Jadwal Rutin</h3>
            <a href="{{ route('jadwal-rutin.create', ['pelanggan_id' => $pelanggan->id]) }}"
               class="text-xs text-blue-600 hover:underline">+ Tambah</a>
        </div>
        @forelse($jadwalRutin as $jadwal)
            <div class="mb-3 p-3 bg-gray-50 rounded-lg text-sm">
                <div class="flex justify-between items-center">
                    <span class="font-medium text-gray-700">{{ $jadwal->hari_pengiriman }}</span>
                    <span class="text-xs px-2 py-0.5 rounded-full
                        {{ $jadwal->status_aktif ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $jadwal->status_aktif ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>
                <p class="text-gray-500 text-xs mt-1">{{ $jadwal->alamat_pengiriman ?? $pelanggan->alamat }}</p>
            </div>
        @empty
            <p class="text-sm text-gray-400">Belum ada jadwal rutin.</p>
        @endforelse
    </div>

    {{-- Riwayat Transaksi --}}
    <div class="bg-white rounded-xl shadow p-6 lg:col-span-1">
        <h3 class="font-semibold text-gray-700 mb-4">🧾 Riwayat Transaksi</h3>
        @forelse($transaksi as $trx)
            <a href="{{ route('transaksi.show', $trx) }}"
               class="block mb-2 p-3 bg-gray-50 rounded-lg hover:bg-blue-50 transition">
                <div class="flex justify-between text-sm">
                    <span class="font-mono text-xs text-gray-500">{{ $trx->kode_transaksi }}</span>
                    <span class="font-medium text-gray-700">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between mt-1">
                    <span class="text-xs text-gray-400">{{ $trx->tanggal_transaksi->format('d M Y') }}</span>
                    <span class="text-xs px-2 py-0.5 rounded-full
                        {{ $trx->status_transaksi === 'selesai' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                        {{ ucfirst($trx->status_transaksi) }}
                    </span>
                </div>
            </a>
        @empty
            <p class="text-sm text-gray-400">Belum ada transaksi.</p>
        @endforelse
        <div class="mt-3">{{ $transaksi->links() }}</div>
    </div>
</div>
@endsection