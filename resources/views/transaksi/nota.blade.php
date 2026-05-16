<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota - {{ $transaksi->kode_transaksi }}</title>
    @vite(['resources/css/app.css'])
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

    {{-- Tombol Aksi --}}
    <div class="no-print fixed top-4 right-4 flex gap-2">
        <button onclick="window.print()"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
            🖨️ Print
        </button>
        <a href="{{ route('laporan.nota.pdf', $transaksi) }}"
           class="bg-red-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-red-700">
            📄 PDF
        </a>
        <a href="{{ route('transaksi.index', $transaksi) }}"
           class="bg-gray-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-700">
            ← Kembali
        </a>
    </div>

    {{-- Nota --}}
    <div class="bg-white w-80 rounded-xl shadow-lg p-6 font-mono text-sm">

        {{-- Header --}}
        <div class="text-center mb-4">
            <h1 class="text-lg font-bold">💧 Barokah Tirta</h1>
            <p class="text-xs text-gray-500">Depot Air Minum Isi Ulang</p>
            <div class="border-t border-dashed border-gray-300 mt-3"></div>
        </div>

        {{-- Info Transaksi --}}
        <div class="mb-3 text-xs space-y-1">
            <div class="flex justify-between">
                <span class="text-gray-500">Kode</span>
                <span class="font-bold">{{ $transaksi->kode_transaksi }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Tanggal</span>
                <span>{{ $transaksi->tanggal_transaksi->format('d/m/Y H:i') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Pelanggan</span>
                <span>{{ $transaksi->pelanggan->nama ?? 'Umum' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Tipe</span>
                <span class="capitalize">{{ $transaksi->tipe_transaksi }}</span>
            </div>
            @if($transaksi->tipe_transaksi !== 'langsung')
            <div class="mt-2 pt-2 border-t border-dotted border-gray-200">
                <p class="text-gray-500 mb-1">Pengiriman:</p>
                <p class="font-medium">{{ $transaksi->no_hp_pengiriman }}</p>
                <p class="leading-tight">{{ $transaksi->alamat_pengiriman }}</p>
            </div>
            @endif
        </div>

        <div class="border-t border-dashed border-gray-300 my-3"></div>

        {{-- Detail Produk --}}
        <div class="mb-3 space-y-2 text-xs">
            @foreach($transaksi->detail as $item)
            <div>
                <p class="font-medium">{{ $item->produk->nama_produk }}</p>
                <div class="flex justify-between text-gray-600">
                    <span>{{ $item->qty }} x Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                    <span class="font-medium text-gray-800">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
            </div>
            @endforeach
        </div>

        <div class="border-t border-dashed border-gray-300 my-3"></div>

        {{-- Total --}}
        <div class="flex justify-between font-bold text-base">
            <span>TOTAL</span>
            <span class="text-blue-600">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
        </div>

        <div class="border-t border-dashed border-gray-300 mt-3 mb-4"></div>

        {{-- Footer --}}
        <div class="text-center text-xs text-gray-400 space-y-1">
            <p>Status: <span class="font-medium capitalize">{{ $transaksi->status_transaksi }}</span></p>
            <p>Terima kasih atas kepercayaan Anda!</p>
            <p class="mt-2">Admin: {{ $transaksi->user->name }}</p>
        </div>

    </div>

</body>
</html>