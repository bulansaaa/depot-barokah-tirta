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
    @foreach($transaksi->detail as $item)
    <div>
        <p class="bold">{{ $item->produk->nama_produk }}</p>
        <div class="row small">
            <span>{{ $item->qty }} x Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
            <span class="bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
        </div>
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