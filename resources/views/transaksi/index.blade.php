@extends('layouts.app')
@section('title', 'Data Transaksi')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-gray-800">🧾 Data Transaksi</h2>
    <a href="{{ route('transaksi.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
        + Buat Transaksi
    </a>
</div>

{{-- Filter --}}
<form method="GET" class="bg-white rounded-xl shadow p-4 mb-4">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari kode / pelanggan..."
               class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">

        <select name="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">Semua Status</option>
            @foreach(['pending','diproses','diantar','selesai','dibatalkan'] as $s)
                <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
            @endforeach
        </select>

        <select name="tipe" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">Semua Tipe</option>
            @foreach(['langsung','antar','langganan'] as $t)
                <option value="{{ $t }}" {{ request('tipe') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
            @endforeach
        </select>

        <div class="flex gap-2">
            <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                   class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-800">
                Filter
            </button>
        </div>
    </div>
    @if(request()->hasAny(['search','status','tipe','tanggal']))
        <div class="mt-2">
            <a href="{{ route('transaksi.index') }}" class="text-xs text-blue-500 hover:underline">Reset filter</a>
        </div>
    @endif
</form>

{{-- Tabel --}}
<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 border-b">
            <tr>
                <th class="px-4 py-3 text-left text-xs text-gray-500 font-medium">Kode</th>
                <th class="px-4 py-3 text-left text-xs text-gray-500 font-medium">Pelanggan</th>
                <th class="px-4 py-3 text-left text-xs text-gray-500 font-medium">Tipe</th>
                <th class="px-4 py-3 text-left text-xs text-gray-500 font-medium">Total</th>
                <th class="px-4 py-3 text-left text-xs text-gray-500 font-medium">Tanggal</th>
                <th class="px-4 py-3 text-left text-xs text-gray-500 font-medium">Status</th>
                <th class="px-4 py-3 text-left text-xs text-gray-500 font-medium">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($transaksi as $trx)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-mono text-xs text-gray-500">{{ $trx->kode_transaksi }}</td>
                <td class="px-4 py-3 font-medium text-gray-800">{{ $trx->pelanggan->nama ?? 'Umum' }}</td>
                <td class="px-4 py-3">
                    @php
                        $tipeColor = [
                            'langsung'   => 'bg-gray-100 text-gray-600',
                            'antar'      => 'bg-blue-100 text-blue-600',
                            'langganan'  => 'bg-purple-100 text-purple-600',
                        ][$trx->tipe_transaksi] ?? 'bg-gray-100 text-gray-600';
                    @endphp
                    <span class="text-xs px-2 py-1 rounded-full {{ $tipeColor }}">
                        {{ ucfirst($trx->tipe_transaksi) }}
                    </span>
                </td>
                <td class="px-4 py-3 font-semibold text-gray-800">
                    Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                </td>
                <td class="px-4 py-3 text-gray-500 text-xs">
                    {{ $trx->tanggal_transaksi->format('d M Y H:i') }}
                </td>
                <td class="px-4 py-3">
                    @php
                        $stColor = [
                            'pending'    => 'bg-yellow-100 text-yellow-700',
                            'diproses'   => 'bg-blue-100 text-blue-700',
                            'diantar'    => 'bg-orange-100 text-orange-700',
                            'selesai'    => 'bg-green-100 text-green-700',
                            'dibatalkan' => 'bg-red-100 text-red-700',
                        ][$trx->status_transaksi] ?? 'bg-gray-100 text-gray-600';
                    @endphp
                    <span class="text-xs px-2 py-1 rounded-full font-medium {{ $stColor }}">
                        {{ ucfirst($trx->status_transaksi) }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    <div class="flex gap-2">
                        <a href="{{ route('transaksi.show', $trx) }}"
                           class="text-xs text-blue-600 hover:underline">Detail</a>
                        <a href="{{ route('transaksi.nota', $trx) }}"
                           class="text-xs text-green-600 hover:underline">Nota</a>
                        
                        @if(!in_array($trx->status_transaksi, ['selesai', 'dibatalkan']))
                        <form method="POST" action="{{ route('transaksi.status.update', $trx) }}" class="inline">
                            @csrf @method('PATCH')
                            <input type="hidden" name="status_transaksi" value="selesai">
                            <button type="submit" class="text-xs text-orange-600 hover:underline" 
                                    onclick="return confirm('Tandai transaksi ini sebagai Selesai?')">
                                Selesai
                            </button>
                        </form>
                        @endif

                        @if($trx->status_transaksi !== 'selesai' && $trx->status_transaksi !== 'dibatalkan')
                        <form method="POST" action="{{ route('transaksi.destroy', $trx) }}"
                              onsubmit="return confirm('Hapus transaksi ini?')">
                            @csrf @method('DELETE')
                            <button class="text-xs text-red-600 hover:underline">Hapus</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="px-5 py-10 text-center text-gray-400">
                    Belum ada data transaksi.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-5 py-4 border-t">{{ $transaksi->links() }}</div>
</div>
@endsection