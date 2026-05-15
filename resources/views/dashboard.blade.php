@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

{{-- Statistik Cards --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Transaksi Hari Ini</p>
        <p class="text-3xl font-bold text-blue-600 mt-1">{{ $transaksiHariIni }}</p>
        <p class="text-xs text-gray-400 mt-1">transaksi</p>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Pendapatan Hari Ini</p>
        <p class="text-2xl font-bold text-green-600 mt-1">
            Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}
        </p>
        <p class="text-xs text-gray-400 mt-1">dari transaksi selesai</p>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Pendapatan Bulan Ini</p>
        <p class="text-2xl font-bold text-purple-600 mt-1">
            Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}
        </p>
        <p class="text-xs text-gray-400 mt-1">{{ $transaksibulanIni }} transaksi</p>
    </div>

    <div class="bg-white rounded-xl shadow p-5">
        <p class="text-xs text-gray-500 uppercase tracking-wide">Total Pelanggan</p>
        <p class="text-3xl font-bold text-orange-500 mt-1">{{ $totalPelanggan }}</p>
        <p class="text-xs text-gray-400 mt-1">pelanggan terdaftar</p>
    </div>

</div>

{{-- Status Transaksi + Jadwal Hari Ini --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

    {{-- Status Pending --}}
    <div class="bg-white rounded-xl shadow p-5">
        <h3 class="text-sm font-semibold text-gray-600 mb-3">⏳ Status Transaksi</h3>
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-500">Pending</span>
                <span class="bg-yellow-100 text-yellow-700 text-xs font-bold px-2 py-1 rounded-full">
                    {{ $transaksiPending }}
                </span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-500">Diproses</span>
                <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-1 rounded-full">
                    {{ $transaksiDiproses }}
                </span>
            </div>
        </div>
        <a href="{{ route('transaksi.index', ['status' => 'pending']) }}"
           class="block mt-4 text-center text-xs text-blue-600 hover:underline">
            Lihat semua →
        </a>
    </div>

    {{-- Jadwal Pengantaran Hari Ini --}}
    <div class="bg-white rounded-xl shadow p-5 lg:col-span-2">
        <div class="flex justify-between items-center mb-3">
            <h3 class="text-sm font-semibold text-gray-600">📅 Jadwal Antar Hari Ini</h3>
            <span class="text-xs text-gray-400">{{ $jadwalHariIni->count() }} pelanggan</span>
        </div>

        @if($jadwalHariIni->isEmpty())
            <p class="text-sm text-gray-400 text-center py-4">Tidak ada jadwal pengantaran hari ini.</p>
        @else
            <div class="space-y-2">
                @foreach($jadwalHariIni as $jadwal)
                    <div class="flex items-start gap-3 p-2 bg-gray-50 rounded-lg">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center text-sm">
                            💧
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-700">{{ $jadwal->pelanggan->nama }}</p>
                            <p class="text-xs text-gray-400 truncate">{{ $jadwal->alamat_pengiriman ?? $jadwal->pelanggan->alamat }}</p>
                        </div>
                        <a href="{{ route('transaksi.create', ['pelanggan_id' => $jadwal->pelanggan_id]) }}"
                           class="text-xs bg-blue-600 text-white px-2 py-1 rounded hover:bg-blue-700 whitespace-nowrap">
                            + Transaksi
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</div>

{{-- Transaksi Terbaru --}}
<div class="bg-white rounded-xl shadow">
    <div class="flex justify-between items-center p-5 border-b">
        <h3 class="text-sm font-semibold text-gray-600">🧾 Transaksi Terbaru</h3>
        <a href="{{ route('transaksi.index') }}" class="text-xs text-blue-600 hover:underline">Lihat semua →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Kode</th>
                    <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Pelanggan</th>
                    <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Tipe</th>
                    <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Total</th>
                    <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($transaksiTerbaru as $trx)
                <tr class="hover:bg-gray-50">
                    <td class="px-5 py-3 font-mono text-xs text-gray-600">{{ $trx->kode_transaksi }}</td>
                    <td class="px-5 py-3 text-gray-700">{{ $trx->pelanggan->nama ?? 'Umum' }}</td>
                    <td class="px-5 py-3">
                        <span class="text-xs px-2 py-1 rounded-full
                            {{ $trx->tipe_transaksi === 'langsung' ? 'bg-gray-100 text-gray-600' : '' }}
                            {{ $trx->tipe_transaksi === 'antar' ? 'bg-blue-100 text-blue-600' : '' }}
                            {{ $trx->tipe_transaksi === 'langganan' ? 'bg-purple-100 text-purple-600' : '' }}">
                            {{ ucfirst($trx->tipe_transaksi) }}
                        </span>
                    </td>
                    <td class="px-5 py-3 font-medium text-gray-700">
                        Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                    </td>
                    <td class="px-5 py-3">
                        @php
                            $statusColor = [
                                'pending'    => 'bg-yellow-100 text-yellow-700',
                                'diproses'   => 'bg-blue-100 text-blue-700',
                                'diantar'    => 'bg-orange-100 text-orange-700',
                                'selesai'    => 'bg-green-100 text-green-700',
                                'dibatalkan' => 'bg-red-100 text-red-700',
                            ][$trx->status_transaksi] ?? 'bg-gray-100 text-gray-600';
                        @endphp
                        <span class="text-xs px-2 py-1 rounded-full {{ $statusColor }}">
                            {{ ucfirst($trx->status_transaksi) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-5 py-8 text-center text-gray-400 text-sm">
                        Belum ada transaksi hari ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection