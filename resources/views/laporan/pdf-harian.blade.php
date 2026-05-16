<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Harian - {{ $tanggal->format('d-m-Y') }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; margin: 0; padding: 20px; }
        h1 { font-size: 18px; margin: 0; }
        .header { text-align: center; border-bottom: 2px solid #1e40af; padding-bottom: 12px; margin-bottom: 20px; }
        .subtitle { color: #6b7280; font-size: 11px; margin-top: 4px; }
        .stats { display: flex; gap: 16px; margin-bottom: 20px; }
        .stat-box { flex: 1; border: 1px solid #e5e7eb; border-radius: 6px; padding: 12px; text-align: center; }
        .stat-label { font-size: 10px; color: #6b7280; text-transform: uppercase; }
        .stat-value { font-size: 16px; font-weight: bold; color: #1e40af; margin-top: 4px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f3f4f6; padding: 8px 10px; text-align: left; font-size: 10px; text-transform: uppercase; color: #6b7280; border-bottom: 1px solid #e5e7eb; }
        td { padding: 8px 10px; border-bottom: 1px solid #f3f4f6; }
        tr:last-child td { border-bottom: none; }
        .total-row td { font-weight: bold; background: #f3f4f6; color: #1e40af; }
        .text-right { text-align: right; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #9ca3af; }
    </style>
</head>
<body>
    <div class="header">
        <h1>💧 Barokah Tirta</h1>
        <p class="subtitle">Depot Air Minum Isi Ulang</p>
        <p style="font-size:13px; font-weight:bold; margin-top:8px;">
            LAPORAN HARIAN — {{ $tanggal->locale('id')->isoFormat('dddd, D MMMM Y') }}
        </p>
    </div>

    <div class="stats">
        <div class="stat-box">
            <div class="stat-label">Total Transaksi</div>
            <div class="stat-value">{{ $totalTransaksi }}</div>
        </div>
        <div class="stat-box">
            <div class="stat-label">Total Pendapatan</div>
            <div class="stat-value" style="color:#16a34a;">
                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Pelanggan</th>
                <th>Produk</th>
                <th>Tipe</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $i => $trx)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td style="font-family:monospace; font-size:10px;">{{ $trx->kode_transaksi }}</td>
                <td>{{ $trx->pelanggan->nama ?? 'Umum' }}</td>
                <td style="font-size:10px;">
                    @foreach($trx->detail as $d)
                        {{ $d->qty }}x {{ $d->produk->nama_produk }}@if(!$loop->last), @endif
                    @endforeach
                </td>
                <td style="text-transform:capitalize;">{{ $trx->tipe_transaksi }}</td>
                <td class="text-right">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr><td colspan="6" style="text-align:center; color:#9ca3af; padding:20px;">Tidak ada data.</td></tr>
            @endforelse
            @if($totalTransaksi > 0)
            <tr class="total-row">
                <td colspan="5" class="text-right">TOTAL PENDAPATAN</td>
                <td class="text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i') }} oleh {{ auth()->user()->name }}
    </div>
</body>
</html>