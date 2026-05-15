<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    public function harian(Request $request)
    {
        $tanggal = $request->filled('tanggal')
            ? Carbon::parse($request->tanggal)
            : today();

        $transaksi = Transaksi::with('pelanggan', 'detail.produk')
            ->whereDate('tanggal_transaksi', $tanggal)
            ->where('status_transaksi', 'selesai')
            ->latest()
            ->get();

        $totalPendapatan = $transaksi->sum('total_harga');
        $totalTransaksi  = $transaksi->count();

        return view('laporan.harian', compact(
            'transaksi',
            'totalPendapatan',
            'totalTransaksi',
            'tanggal'
        ));
    }

    public function bulanan(Request $request)
    {
        $bulan = $request->filled('bulan')
            ? Carbon::parse($request->bulan . '-01')
            : now()->startOfMonth();

        $transaksi = Transaksi::with('pelanggan', 'detail.produk')
            ->whereMonth('tanggal_transaksi', $bulan->month)
            ->whereYear('tanggal_transaksi', $bulan->year)
            ->where('status_transaksi', 'selesai')
            ->latest()
            ->get();

        // Rekap per hari dalam bulan ini
        $rekapHarian = $transaksi->groupBy(function ($item) {
            return $item->tanggal_transaksi->format('Y-m-d');
        })->map(function ($group) {
            return [
                'total_transaksi' => $group->count(),
                'total_pendapatan'=> $group->sum('total_harga'),
            ];
        });

        $totalPendapatan = $transaksi->sum('total_harga');
        $totalTransaksi  = $transaksi->count();

        return view('laporan.bulanan', compact(
            'transaksi',
            'rekapHarian',
            'totalPendapatan',
            'totalTransaksi',
            'bulan'
        ));
    }

    public function exportHarianPdf(Request $request)
    {
        $tanggal = $request->filled('tanggal')
            ? Carbon::parse($request->tanggal)
            : today();

        $transaksi = Transaksi::with('pelanggan', 'detail.produk')
            ->whereDate('tanggal_transaksi', $tanggal)
            ->where('status_transaksi', 'selesai')
            ->latest()
            ->get();

        $totalPendapatan = $transaksi->sum('total_harga');
        $totalTransaksi  = $transaksi->count();

        $pdf = Pdf::loadView('laporan.pdf-harian', compact(
            'transaksi',
            'totalPendapatan',
            'totalTransaksi',
            'tanggal'
        ))->setPaper('a4');

        $filename = 'laporan-harian-' . $tanggal->format('Y-m-d') . '.pdf';

        return $pdf->download($filename);
    }

    public function exportBulananPdf(Request $request)
    {
        $bulan = $request->filled('bulan')
            ? Carbon::parse($request->bulan . '-01')
            : now()->startOfMonth();

        $transaksi = Transaksi::with('pelanggan', 'detail.produk')
            ->whereMonth('tanggal_transaksi', $bulan->month)
            ->whereYear('tanggal_transaksi', $bulan->year)
            ->where('status_transaksi', 'selesai')
            ->latest()
            ->get();

        $rekapHarian     = $transaksi->groupBy(fn($i) => $i->tanggal_transaksi->format('Y-m-d'))
            ->map(fn($g) => ['total_transaksi' => $g->count(), 'total_pendapatan' => $g->sum('total_harga')]);
        $totalPendapatan = $transaksi->sum('total_harga');
        $totalTransaksi  = $transaksi->count();

        $pdf = Pdf::loadView('laporan.pdf-bulanan', compact(
            'transaksi',
            'rekapHarian',
            'totalPendapatan',
            'totalTransaksi',
            'bulan'
        ))->setPaper('a4');

        $filename = 'laporan-bulanan-' . $bulan->format('Y-m') . '.pdf';

        return $pdf->download($filename);
    }

    public function exportNotaPdf(Transaksi $transaksi)
    {
        $transaksi->load('pelanggan', 'user', 'detail.produk');

        $pdf = Pdf::loadView('transaksi.nota-pdf', compact('transaksi'))
            ->setPaper([0, 0, 226, 400]); // Ukuran kertas struk kecil

        $filename = 'nota-' . $transaksi->kode_transaksi . '.pdf';

        return $pdf->download($filename);
    }
}