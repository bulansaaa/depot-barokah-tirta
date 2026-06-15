<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\JadwalRutin;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.app', function ($view) {
            $hariIni = Carbon::now()->locale('id')->isoFormat('dddd');
            $hariBesok = Carbon::tomorrow()->locale('id')->isoFormat('dddd');

            $jadwalHariIniGlobal = JadwalRutin::with('pelanggan')
                ->aktif()
                ->hari($hariIni)
                ->whereDoesntHave('pelanggan.transaksi', function ($query) {
                    $query->whereDate('tanggal_transaksi', Carbon::today());
                })
                ->get();

            $jadwalBesokGlobal = JadwalRutin::with('pelanggan')
                ->aktif()
                ->hari($hariBesok)
                ->get();
            
            $view->with([
                'jadwalHariIniGlobal' => $jadwalHariIniGlobal,
                'jadwalBesokGlobal' => $jadwalBesokGlobal
            ]);
        });
    }
}
