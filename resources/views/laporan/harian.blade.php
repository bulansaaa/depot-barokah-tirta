@extends('layouts.app')
@section('title', 'Laporan Harian')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-gray-800">📊 Laporan Harian</h2>
    <a href="{{ route('laporan.harian.pdf', ['tanggal' => $tanggal->format('Y-m-d')]) }}"
       class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700">
        📄 Export PDF
    </a>
</div>

{{-- Filter Tanggal --}}
<form method="GET" class="bg-white rounded-xl shadow p-4 mb-6 flex gap-3 items-end">
    <div>
        <label class="block text-xs text-gray-500 mb-1">Pilih Tanggal</label>
        <input type="date" name="tanggal" value="{{ $tanggal->format('Y-m-d') }}"
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">Tampilkan</button>
</form>

{{-- Statistik --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-xs text-gray-500 uppercase">Tanggal</p>
        <p class="text-xl font-bold text-gray-800 mt-1">
            {{ $tanggal->locale('id')->isoFormat('dddd, D MMMM Y') }}
        </p>
    </div>
    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-xs text-gray-500 uppercase">Total Transaksi</p>
        <p class="text-3xl font-bold text-blue-600 mt-1">{{ $totalTransaksi }}</p>
    </div>
    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-xs text-gray-500 uppercase">Total Pendapatan</p>
        <p class="text-2xl font-bold text-green-600 mt-1">
            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
        </p>
    </div>
</div>

{{-- Tabel Transaksi --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="p-5 border-b">
        <h3 class="font-semibold text-gray-700">Daftar Transaksi</h3>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Kode</th>
                <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Pelanggan</th>
                <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Produk</th>
                <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Tipe</th>
                <th class="px-5 py-3 text-right text-xs text-gray-500 font-medium">Total</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($transaksi as $trx)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3 font-mono text-xs text-gray-500">{{ $trx->kode_transaksi }}</td>
                <td class="px-5 py-3 font-medium text-gray-800">{{ $trx->pelanggan->nama ?? 'Umum' }}</td>
                <td class="px-5 py-3 text-gray-600 text-xs">
                    @foreach($trx->detail as $d)
                        <span>{{ $d->qty }}x {{ $d->produk->nama_produk }}</span>@if(!$loop->last), @endif
                    @endforeach
                </td>
                <td class="px-5 py-3 capitalize text-gray-600">{{ $trx->tipe_transaksi }}</td>
                <td class="px-5 py-3 text-right font-semibold text-gray-800">
                    Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-10 text-center text-gray-400">
                    Tidak ada transaksi pada tanggal ini.
                </td>
            </tr>
            @endforelse
        </tbody>
        @if($totalTransaksi > 0)
        <tfoot class="bg-gray-50 font-bold border-t">
            <tr>
                <td colspan="4" class="px-5 py-3 text-right text-gray-700">TOTAL PENDAPATAN</td>
                <td class="px-5 py-3 text-right text-green-600 text-base">
                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>
@endsection