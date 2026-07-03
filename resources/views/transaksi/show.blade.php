@extends('layouts.app')
@section('title', 'Detail Transaksi')

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <a href="{{ route('transaksi.index') }}" class="text-xs text-blue-500 hover:underline mb-1 block">← Kembali</a>
        <h2 class="text-xl font-bold text-gray-800">Detail Transaksi</h2>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('transaksi.nota', $transaksi) }}"
           class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700">
            Cetak Nota
        </a>
        <a href="{{ route('laporan.nota.pdf', $transaksi) }}"
           class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700">
            Download PDF
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Detail Kiri --}}
    <div class="lg:col-span-2 space-y-4">

        {{-- Info Transaksi --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="font-semibold text-gray-700 mb-4">Informasi Transaksi</h3>
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-400">Kode Transaksi</p>
                    <p class="font-mono font-bold text-gray-800">{{ $transaksi->kode_transaksi }}</p>
                </div>
                <div>
                    <p class="text-gray-400">Tanggal</p>
                    <p class="font-medium text-gray-800">{{ $transaksi->tanggal_transaksi->translatedFormat('d M Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-400">Pelanggan</p>
                    <p class="font-medium text-gray-800">{{ $transaksi->pelanggan->nama ?? 'Umum' }}</p>
                </div>
                <div>
                    <p class="text-gray-400">No HP Pelanggan</p>
                    <p class="font-medium text-gray-800">{{ $transaksi->pelanggan->no_hp ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-gray-400">Tipe</p>
                    <p class="font-medium text-gray-800 capitalize">{{ $transaksi->tipe_transaksi === 'langsung' ? 'Langsung' : 'Antar' }}</p>
                </div>
                <div>
                    <p class="text-gray-400">Metode</p>
                    <p class="font-medium text-gray-800 capitalize">{{ $transaksi->metode_pemesanan }}</p>
                </div>
                @if($transaksi->catatan)
                <div class="col-span-2">
                    <p class="text-gray-400">Catatan</p>
                    <p class="font-medium text-gray-800">{{ $transaksi->catatan }}</p>
                </div>
                @endif
                <div>
                    <p class="text-gray-400">Dibuat oleh</p>
                    <p class="font-medium text-gray-800">{{ $transaksi->user->name }}</p>
                </div>
            </div>
        </div>

        {{-- Detail Produk --}}
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="p-5 border-b">
                <h3 class="font-semibold text-gray-700">Detail Produk</h3>
            </div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Produk</th>
                        <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Harga Satuan</th>
                        <th class="px-5 py-3 text-left text-xs text-gray-500 font-medium">Qty</th>
                        <th class="px-5 py-3 text-right text-xs text-gray-500 font-medium">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($transaksi->detail as $item)
                    <tr>
                        <td class="px-5 py-3 font-medium text-gray-800">{{ $item->produk->nama_produk }}</td>
                        <td class="px-5 py-3 text-gray-600">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="px-5 py-3 text-gray-600">{{ $item->qty }} {{ $item->produk->satuan }}</td>
                        <td class="px-5 py-3 text-right font-semibold text-gray-800">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50">
                    <tr>
                        <td colspan="3" class="px-5 py-3 text-right font-bold text-gray-700">Total</td>
                        <td class="px-5 py-3 text-right font-bold text-blue-600 text-lg">
                            Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </div>

    {{-- Sidebar Status --}}
    <div class="space-y-4">
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="font-semibold text-gray-700 mb-4">Update Status</h3>

            <div class="mb-4">
                <p class="text-xs text-gray-400 mb-2">Status Saat Ini</p>
                @php
                    $stColor = [
                        'pending'    => 'bg-yellow-100 text-yellow-700',
                        'diproses'   => 'bg-blue-100 text-blue-700',
                        'diantar'    => 'bg-orange-100 text-orange-700',
                        'selesai'    => 'bg-[#d1fae5] text-[#065f46]',
                        'dibatalkan' => 'bg-red-100 text-red-700',
                    ][$transaksi->status_transaksi] ?? 'bg-gray-100 text-gray-600';

                    $stLabel = [
                        'pending'    => 'Pending',
                        'diproses'   => 'Diproses',
                        'diantar'    => 'Diantar',
                        'selesai'    => 'Selesai',
                        'dibatalkan' => 'Dibatalkan',
                    ][$transaksi->status_transaksi] ?? ucfirst($transaksi->status_transaksi);
                @endphp
                <span class="text-sm px-3 py-1 rounded-full font-medium {{ $stColor }}">
                    {{ $stLabel }}
                </span>
            </div>

            @if(!in_array($transaksi->status_transaksi, ['selesai', 'dibatalkan']))
            <form method="POST" action="{{ route('transaksi.status.update', $transaksi) }}"
                  x-on:submit.prevent="
                    const form = $el;
                    const val = form.querySelector('select[name=status_transaksi]').value;
                    if(val === 'selesai' || val === 'dibatalkan') {
                        $dispatch('confirm', {
                            title: val === 'selesai' ? 'Selesaikan Transaksi?' : 'Batalkan Transaksi?',
                            message: val === 'selesai' ? 'Pastikan pesanan sudah diterima dan pembayaran telah lunas.' : 'Transaksi yang dibatalkan tidak dapat diubah statusnya lagi.',
                            onConfirm: () => form.submit(),
                            confirmText: val === 'selesai' ? 'Ya, Selesai' : 'Ya, Batalkan',
                            cancelText: 'Kembali'
                        });
                    } else {
                        form.submit();
                    }
                  ">
                @csrf @method('PATCH')
                <div class="mb-3">
                    <label class="block text-xs text-gray-500 mb-1">Ubah Status</label>
                    <select name="status_transaksi"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        @php
                            $stOptions = [
                                'pending'    => 'Pending',
                                'diproses'   => 'Diproses',
                                'diantar'    => 'Diantar',
                                'selesai'    => 'Selesai',
                                'dibatalkan' => 'Dibatalkan',
                            ];
                        @endphp
                        @foreach($stOptions as $val => $label)
                            <option value="{{ $val }}" {{ $transaksi->status_transaksi === $val ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 rounded-lg text-sm hover:bg-blue-700">
                    Update Status
                </button>
            </form>
            @endif
        </div>


    </div>

</div>
@endsection