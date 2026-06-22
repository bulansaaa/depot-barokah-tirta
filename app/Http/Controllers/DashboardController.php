<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\JadwalRutin;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = today();
        $hariIni = Carbon::now()->locale('id')->isoFormat('dddd'); // Senin, Selasa, dst.

        // Statistik harian
        $transaksiHariIni = Transaksi::hariIni()->count();
        $pendapatanHariIni = Transaksi::hariIni()
            ->where('status_transaksi', 'selesai')
            ->sum('total_harga');

        // Statistik bulanan
        $transaksibulanIni = Transaksi::bulanIni()->count();
        $pendapatanBulanIni = Transaksi::bulanIni()
            ->where('status_transaksi', 'selesai')
            ->sum('total_harga');

        // Pengeluaran
        $pengeluaranHariIni = Pengeluaran::whereDate('tanggal', today())->sum('nominal');
        $pengeluaranBulanIni = Pengeluaran::bulanIni()->sum('nominal');

        // Laba Bersih
        $labaHariIni = $pendapatanHariIni - $pengeluaranHariIni;
        $labaBulanIni = $pendapatanBulanIni - $pengeluaranBulanIni;

        // Transaksi pending & diproses
        $transaksiPending = Transaksi::byStatus('pending')->count();
        $transaksiDiproses = Transaksi::byStatus('diproses')->count();

        // Jadwal pengantaran hari ini (hanya yang belum terkirim/gagal/terlewat)
        $jadwalHariIni = JadwalRutin::with(['pelanggan', 'pelanggan.transaksi' => function ($query) {
                $query->whereDate('tanggal_transaksi', Carbon::today());
            }])
            ->aktif()
            ->hari($hariIni)
            ->whereDoesntHave('pelanggan.transaksi', function ($query) {
                $query->whereDate('tanggal_transaksi', Carbon::today());
            })
            ->whereDoesntHave('logs', function ($query) {
                $query->whereDate('tanggal', Carbon::today());
            })
            ->get();

        // Jadwal pengantaran besok
        $hariBesok = Carbon::tomorrow()->locale('id')->isoFormat('dddd');
        $jadwalBesok = JadwalRutin::with('pelanggan')
            ->aktif()
            ->hari($hariBesok)
            ->get();

        // Transaksi terbaru (5 terakhir)
        $transaksiTerbaru = Transaksi::with('pelanggan')
            ->latest()
            ->limit(5)
            ->get();

        // Total pelanggan
        $totalPelanggan = Pelanggan::count();

        return view('dashboard', compact(
            'transaksiHariIni',
            'pendapatanHariIni',
            'transaksibulanIni',
            'pendapatanBulanIni',
            'pengeluaranHariIni',
            'pengeluaranBulanIni',
            'labaHariIni',
            'labaBulanIni',
            'transaksiPending',
            'transaksiDiproses',
            'jadwalHariIni',
            'jadwalBesok',
            'hariBesok',
            'transaksiTerbaru',
            'totalPelanggan'
        ));
    }
}