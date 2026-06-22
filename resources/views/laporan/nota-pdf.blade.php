<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota {{ $transaksi->kode_transaksi }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; width: 200px; margin: 0 auto; padding: 10px; }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .divider { border-top: 1px dashed #999; margin: 8px 0; }
        .row { display: flex; justify-content: space-between; margin: 3px 0; }
        .total-row { font-size: 13px; font-weight: bold; }
        .small { font-size: 10px; color: #555; }
    </style>
</head>
<body>
    <div class="center">
        <p class="bold" style="font-size:14px;">BAROKAH TIRTA</p>
        <p class="small">Depot Air Minum Isi Ulang</p>
    </div>
    <div class="divider"></div>
    <div class="row"><span>Kode</span><span class="bold">{{ $transaksi->kode_transaksi }}</span></div>
    <div class="row"><span>Tanggal</span><span>{{ $transaksi->tanggal_transaksi->format('d/m/Y H:i') }}</span></div>
    <div class="row"><span>Pelanggan</span><span>{{ $transaksi->pelanggan->nama ?? 'Umum' }}</span></div>
    <div class="row"><span>Tipe</span><span style="text-transform:capitalize;">{{ $transaksi->tipe_transaksi }}</span></div>
    <div class="divider"></div>
    {{-- Header Tabel Produk --}}
    <div style="display:flex; justify-content:space-between; font-weight:bold; font-size:10px; background:#f0f0f0; padding:4px 2px; margin-bottom:4px;">
        <span style="flex:1;">Produk</span>
        <span style="width:30px; text-align:center;">Qty</span>
        <span style="width:50px; text-align:right;">Harga</span>
        <span style="width:50px; text-align:right;">Subtotal</span>
    </div>
    {{-- Detail Produk --}}
    @foreach($transaksi->detail as $item)
    <div style="display:flex; justify-content:space-between; font-size:10px; padding:2px 0; border-bottom:1px dotted #ddd;">
        <span style="flex:1;">{{ $item->produk->nama_produk }}</span>
        <span style="width:30px; text-align:center;">{{ $item->qty }}</span>
        <span style="width:50px; text-align:right;">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
        <span style="width:50px; text-align:right; font-weight:bold;">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
    </div>
    @endforeach
    <div class="divider"></div>
    <div class="row total-row">
        <span>TOTAL</span>
        <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
    </div>
    <div class="divider"></div>
    <div class="center small">
        <p>Terima kasih atas kepercayaan Anda!</p>
        <p>Status: <b style="text-transform:capitalize;">{{ $transaksi->status_transaksi }}</b></p>
    </div>
</body>
</html>