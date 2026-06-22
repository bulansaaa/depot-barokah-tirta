@extends('layouts.app')
@section('title', 'Laporan Bulanan')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-gray-800">📈 Laporan Bulanan</h2>
    <a href="{{ route('laporan.bulanan.pdf', ['bulan' => $bulan->format('Y-m')]) }}"
       class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700">
        📄 Export PDF
    </a>
</div>

{{-- Filter Bulan --}}
<form method="GET" class="bg-white rounded-xl shadow p-4 mb-6 flex gap-3 items-end">
    <div>
        <label class="block text-xs text-gray-500 mb-1">Pilih Bulan</label>
        <input type="month" name="bulan" value="{{ $bulan->format('Y-m') }}"
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
    </div>
    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">Tampilkan</button>
</form>

{{-- Statistik --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-xs text-gray-500 uppercase">Total Pendapatan</p>
        <p class="text-xl font-bold text-green-600 mt-1">
            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
        </p>
    </div>
    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-xs text-gray-500 uppercase">Total Pengeluaran</p>
        <p class="text-xl font-bold text-red-600 mt-1">
            Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}
        </p>
    </div>
    <div class="bg-white rounded-xl shadow p-5 border-2 border-blue-100">
        <p class="text-xs text-gray-500 uppercase">Laba Bersih</p>
        <p class="text-xl font-bold text-blue-600 mt-1">
            Rp {{ number_format($labaBersih, 0, ',', '.') }}
        </p>
    </div>
    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-xs text-gray-500 uppercase">Total Transaksi</p>
        <p class="text-xl font-bold text-gray-800 mt-1">{{ $totalTransaksi }}</p>
    </div>
</div>

{{-- Ringkasan Jadwal --}}
<div class="bg-white rounded-xl shadow overflow-hidden mb-6">
    <div class="p-5 border-b flex justify-between items-center">
        <h3 class="font-semibold text-gray-700">Ringkasan Pelaksanaan Jadwal</h3>
        <span class="text-xs text-gray-500">Periode: {{ $bulan->locale('id')->isoFormat('MMMM Y') }}</span>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 divide-y md:divide-y-0 md:divide-x">
        <div class="p-6 text-center">
            <p class="text-xs text-gray-500 uppercase mb-1">Berhasil Terkirim</p>
            <p class="text-3xl font-bold text-green-600">{{ $logSummary['terkirim'] ?? 0 }}</p>
        </div>
        <div class="p-6 text-center">
            <p class="text-xs text-gray-500 uppercase mb-1">Gagal (Dibatalkan)</p>
            <p class="text-3xl font-bold text-orange-500">{{ $logSummary['gagal'] ?? 0 }}</p>
        </div>
        <div class="p-6 text-center">
            <p class="text-xs text-gray-500 uppercase mb-1">Terlewat</p>
            <p class="text-3xl font-bold text-red-600">{{ $logSummary['terlewat'] ?? 0 }}</p>
        </div>
    </div>
</div>

{{-- Rekap Per Hari --}}
<div class="bg-white rounded-xl shadow overflow-hidden mb-6">
    <div class="p-5 border-b">
        <h3 class="font-semibold text-gray-700">Rekap Per Hari</h3>
    </div>
    <table class="w-full text-sm">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Tanggal</th>
                <th class="px-5 py-3 text-center text-xs text-gray-500 font-medium">Jumlah Transaksi</th>
                <th class="px-5 py-3 text-right text-xs text-gray-500 font-medium">Pendapatan</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($rekapHarian as $tgl => $rekap)
            <tr class="hover:bg-gray-50">
                <td class="px-5 py-3 font-medium text-gray-800">
                    {{ \Carbon\Carbon::parse($tgl)->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </td>
                <td class="px-5 py-3 text-center">
                    <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full">
                        {{ $rekap['total_transaksi'] }} transaksi
                    </span>
                </td>
                <td class="px-5 py-3 text-right font-semibold text-gray-800">
                    Rp {{ number_format($rekap['total_pendapatan'], 0, ',', '.') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="px-5 py-10 text-center text-gray-400">
                    Tidak ada transaksi bulan ini.
                </td>
            </tr>
            @endforelse
        </tbody>
        @if($totalTransaksi > 0)
        <tfoot class="bg-gray-50 font-bold border-t">
            <tr>
                <td colspan="2" class="px-5 py-3 text-right text-gray-700">TOTAL</td>
                <td class="px-5 py-3 text-right text-green-600 text-base">
                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>
@endsection