<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Bulanan - {{ $bulan->format('m-Y') }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; margin: 0; padding: 20px; }
        h1 { font-size: 18px; margin: 0; }
        .header { text-align: center; border-bottom: 2px solid #1e40af; padding-bottom: 12px; margin-bottom: 20px; }
        .subtitle { color: #6b7280; font-size: 11px; margin-top: 4px; }
        .stats { margin-bottom: 20px; width: 100%; }
        .stat-box { display: inline-block; width: 45%; border: 1px solid #e5e7eb; border-radius: 6px; padding: 12px; text-align: center; }
        .stat-label { font-size: 10px; color: #6b7280; text-transform: uppercase; }
        .stat-value { font-size: 16px; font-weight: bold; color: #1e40af; margin-top: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #f3f4f6; padding: 8px 10px; text-align: left; font-size: 10px; text-transform: uppercase; color: #6b7280; border-bottom: 1px solid #e5e7eb; }
        td { padding: 8px 10px; border-bottom: 1px solid #f3f4f6; }
        tr:last-child td { border-bottom: none; }
        .total-row td { font-weight: bold; background: #f3f4f6; color: #1e40af; }
        .text-right { text-align: right; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #9ca3af; }
        .section-title { font-size: 12px; font-weight: bold; color: #1e40af; margin: 20px 0 10px 0; border-left: 4px solid #1e40af; padding-left: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>💧 Barokah Tirta</h1>
        <p class="subtitle">Depot Air Minum Isi Ulang</p>
        <p style="font-size:13px; font-weight:bold; margin-top:8px;">
            LAPORAN BULANAN — {{ $bulan->locale('id')->isoFormat('MMMM Y') }}
        </p>
    </div>

    <div class="stats">
        <div class="stat-box">
            <div class="stat-label">Total Transaksi</div>
            <div class="stat-value">{{ $totalTransaksi }}</div>
        </div>
        <div class="stat-box" style="margin-left: 4%;">
            <div class="stat-label">Total Pendapatan</div>
            <div class="stat-value" style="color:#16a34a;">
                Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <div class="section-title">REKAPITULASI HARIAN</div>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th class="text-right">Total Transaksi</th>
                <th class="text-right">Total Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekapHarian as $tanggal => $data)
            <tr>
                <td>{{ \Carbon\Carbon::parse($tanggal)->locale('id')->isoFormat('dddd, D MMM Y') }}</td>
                <td class="text-right">{{ $data['total_transaksi'] }}</td>
                <td class="text-right">Rp {{ number_format($data['total_pendapatan'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td>GRAND TOTAL</td>
                <td class="text-right">{{ $totalTransaksi }}</td>
                <td class="text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i') }} oleh {{ auth()->user()->name }}
    </div>
</body>
</html>
