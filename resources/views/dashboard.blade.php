@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="flex justify-between items-end mb-8">
    <div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Pusat Kendali</h1>
        <p class="text-gray-600">Pantau ringkasan operasional Depot Barokah Tirta secara real-time</p>
    </div>
    <a href="{{ route('transaksi.create') }}" class="hidden md:flex items-center gap-2 bg-blue-600 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition-all shadow-sm hover:shadow-md active:scale-95">
        <i data-lucide="plus" class="w-5 h-5"></i>
        Transaksi Baru
    </a>
</div>

<!-- Hari Ini Summary -->
<div class="mb-8">
    <h2 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Hari Ini</h2>
    <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <!-- Pendapatan Hari Ini -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition-all duration-200">
            <div class="flex justify-between items-start gap-3 mb-4">
                <div class="p-3 bg-blue-50 rounded-lg">
                    <i data-lucide="trending-up" class="w-5 h-5 text-blue-600"></i>
                </div>
            </div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pendapatan</p>
            <div class="text-2xl font-bold text-gray-900 mb-2">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</div>
            <p class="text-xs text-gray-600">{{ $transaksiHariIni }} transaksi hari ini</p>
        </div>

        <!-- Pengeluaran Hari Ini -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition-all duration-200">
            <div class="flex justify-between items-start gap-3 mb-4">
                <div class="p-3 bg-red-50 rounded-lg">
                    <i data-lucide="trending-down" class="w-5 h-5 text-red-600"></i>
                </div>
            </div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pengeluaran</p>
            <div class="text-2xl font-bold text-gray-900 mb-2">Rp {{ number_format($pengeluaranHariIni, 0, ',', '.') }}</div>
            <p class="text-xs text-gray-600">Beban operasional</p>
        </div>

        <!-- Laba Bersih Hari Ini -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition-all duration-200">
            <div class="flex justify-between items-start gap-3 mb-4">
                <div class="p-3 bg-green-50 rounded-lg">
                    <i data-lucide="zap" class="w-5 h-5 text-green-600"></i>
                </div>
            </div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Laba Bersih</p>
            <div class="text-2xl font-bold text-gray-900 mb-2">Rp {{ number_format($labaHariIni, 0, ',', '.') }}</div>
            <p class="text-xs text-gray-600">Keuntungan hari ini</p>
        </div>

        <!-- Total Pelanggan -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition-all duration-200">
            <div class="flex justify-between items-start gap-3 mb-4">
                <div class="p-3 bg-indigo-50 rounded-lg">
                    <i data-lucide="users" class="w-5 h-5 text-indigo-600"></i>
                </div>
            </div>
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Total Pelanggan</p>
            <div class="text-2xl font-bold text-gray-900 mb-2">{{ $totalPelanggan }}</div>
            <p class="text-xs text-gray-600">Pelanggan terdaftar</p>
        </div>
    </section>
</div>

<!-- Perbandingan dengan Bulan Lalu -->
<div class="mb-8">
    <h2 class="text-lg font-bold text-gray-900 mb-4">Perbandingan Bulan Lalu</h2>
    <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition-all duration-200">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pendapatan Bulan Lalu</p>
            <p class="text-2xl font-bold text-gray-900 mb-3">Rp {{ number_format($pendapatanBulanLalu, 0, ',', '.') }}</p>
            @php
                $selisihPendapatan = $pendapatanBulanIni - $pendapatanBulanLalu;
                $persenSelisihPendapatan = $pendapatanBulanLalu > 0 ? (($selisihPendapatan / $pendapatanBulanLalu) * 100) : 0;
            @endphp
            <div class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-md {{ $selisihPendapatan >= 0 ? 'bg-green-100' : 'bg-red-100' }} text-xs font-semibold">
                <i data-lucide="{{ $selisihPendapatan >= 0 ? 'arrow-up' : 'arrow-down' }}" class="w-3.5 h-3.5 {{ $selisihPendapatan >= 0 ? 'text-green-600' : 'text-red-600' }}"></i>
                <span class="{{ $selisihPendapatan >= 0 ? 'text-green-700' : 'text-red-700' }}">{{ number_format($persenSelisihPendapatan, 1) }}%</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition-all duration-200">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Pengeluaran Bulan Lalu</p>
            <p class="text-2xl font-bold text-gray-900 mb-3">Rp {{ number_format($pengeluaranBulanLalu, 0, ',', '.') }}</p>
            @php
                $selisihPengeluaran = $pengeluaranBulanIni - $pengeluaranBulanLalu;
                $persenSelisihPengeluaran = $pengeluaranBulanLalu > 0 ? (($selisihPengeluaran / $pengeluaranBulanLalu) * 100) : 0;
            @endphp
            <div class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-md {{ $selisihPengeluaran <= 0 ? 'bg-green-100' : 'bg-red-100' }} text-xs font-semibold">
                <i data-lucide="{{ $selisihPengeluaran <= 0 ? 'arrow-down' : 'arrow-up' }}" class="w-3.5 h-3.5 {{ $selisihPengeluaran <= 0 ? 'text-green-600' : 'text-red-600' }}"></i>
                <span class="{{ $selisihPengeluaran <= 0 ? 'text-green-700' : 'text-red-700' }}">{{ number_format(abs($persenSelisihPengeluaran), 1) }}%</span>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition-all duration-200">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Laba Bersih Bulan Lalu</p>
            <p class="text-2xl font-bold text-gray-900 mb-3">Rp {{ number_format($labaBulanLalu, 0, ',', '.') }}</p>
            @php
                $selisihLaba = $labaBulanIni - $labaBulanLalu;
                $persenSelisihLaba = $labaBulanLalu > 0 ? (($selisihLaba / $labaBulanLalu) * 100) : 0;
            @endphp
            <div class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-md {{ $selisihLaba >= 0 ? 'bg-green-100' : 'bg-red-100' }} text-xs font-semibold">
                <i data-lucide="{{ $selisihLaba >= 0 ? 'arrow-up' : 'arrow-down' }}" class="w-3.5 h-3.5 {{ $selisihLaba >= 0 ? 'text-green-600' : 'text-red-600' }}"></i>
                <span class="{{ $selisihLaba >= 0 ? 'text-green-700' : 'text-red-700' }}">{{ number_format($persenSelisihLaba, 1) }}%</span>
            </div>
        </div>
    </section>
</div>
<section class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8">
    <!-- Monitoring Status (col 8) -->
    <div class="lg:col-span-8 flex flex-col">
        <h2 class="text-lg font-bold text-gray-900 mb-4">Monitoring Status</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Pending -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition-all duration-200 flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600 shrink-0">
                    <i data-lucide="clock" class="w-7 h-7"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Transaksi Pending</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $transaksiPending }}</div>
                    <p class="text-xs text-gray-600 mt-1">Menunggu proses</p>
                </div>
                <a href="{{ route('transaksi.index', ['status' => 'pending']) }}" class="text-gray-400 hover:text-amber-600 hover:bg-amber-50 p-2.5 rounded-lg transition-colors shrink-0">
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </a>
            </div>
            <!-- Dalam Proses -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 hover:shadow-md transition-all duration-200 flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0">
                    <i data-lucide="refresh-cw" class="w-7 h-7"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Dalam Proses</div>
                    <div class="text-2xl font-bold text-gray-900">{{ $transaksiDiproses }}</div>
                    <p class="text-xs text-gray-600 mt-1">Sedang dikirim</p>
                </div>
                <a href="{{ route('transaksi.index', ['status' => 'diproses']) }}" class="text-gray-400 hover:text-blue-600 hover:bg-blue-50 p-2.5 rounded-lg transition-colors shrink-0">
                    <i data-lucide="arrow-right" class="w-5 h-5"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Jadwal Hari Ini & Besok (col 4) -->
    <div class="lg:col-span-4 bg-white rounded-2xl border border-gray-200 shadow-sm flex flex-col h-fit" 
         x-data="{ 
            tab: 'hari-ini', 
            showGagalModal: false, 
            selectedJadwalNama: '', 
            actionUrl: '' 
         }">
        <div class="p-6 border-b border-gray-200 flex flex-col gap-4">
            <h2 class="text-lg font-bold text-gray-900">Jadwal Pengiriman</h2>
            <div class="flex bg-gray-100 p-1 rounded-lg">
                <button @click="tab = 'hari-ini'" 
                        :class="tab === 'hari-ini' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-600'"
                        class="flex-1 py-2 px-3 rounded-md font-medium text-sm transition-all">
                    Hari Ini
                </button>
                <button @click="tab = 'besok'" 
                        :class="tab === 'besok' ? 'bg-white text-blue-600 shadow-sm' : 'text-gray-600'"
                        class="flex-1 py-2 px-3 rounded-md font-medium text-sm transition-all">
                    Besok
                </button>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto p-4">
            <!-- Hari Ini Tab -->
            <div x-show="tab === 'hari-ini'" x-transition>
                @forelse($jadwalHariIni as $jadwal)
                    <div class="flex justify-between items-center p-3 hover:bg-blue-50 rounded-lg transition-colors border-b border-gray-100 last:border-0">
                        <div class="flex gap-3 items-center min-w-0">
                            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xs shrink-0">
                                {{ substr($jadwal->pelanggan->nama, 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-gray-900 truncate">{{ $jadwal->pelanggan->nama }}</div>
                                <div class="text-xs text-gray-600 flex items-center gap-1 mt-0.5">
                                    <i data-lucide="map-pin" class="w-3 h-3"></i>
                                    <span class="truncate">{{ $jadwal->alamat_pengiriman ?? $jadwal->pelanggan->alamat }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-1.5 shrink-0">
                            <button @click="showGagalModal = true; selectedJadwalNama = '{{ $jadwal->pelanggan->nama }}'; actionUrl = '{{ route('jadwal-rutin.gagal', $jadwal) }}'" 
                                    class="text-red-600 hover:bg-red-50 p-2 rounded transition-colors" 
                                    title="Tandai Gagal">
                                <i data-lucide="x-circle" class="w-4 h-4"></i>
                            </button>
                            <a href="{{ route('transaksi.create', ['pelanggan_id' => $jadwal->pelanggan_id, 'tipe_transaksi' => 'antar']) }}" class="text-blue-600 hover:bg-blue-50 p-2 rounded transition-colors shrink-0" title="Buat Transaksi">
                                <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-8 text-gray-400">
                        <i data-lucide="calendar-check-2" class="w-8 h-8 mb-2"></i>
                        <p class="text-sm font-medium">Tidak ada jadwal</p>
                    </div>
                @endforelse
            </div>

            <!-- Besok Tab -->
            <div x-show="tab === 'besok'" x-transition style="display: none;">
                @forelse($jadwalBesok as $jadwal)
                    <div class="flex justify-between items-center p-3 hover:bg-blue-50 rounded-lg transition-colors border-b border-gray-100 last:border-0">
                        <div class="flex gap-3 items-center min-w-0">
                            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 font-bold text-xs shrink-0">
                                {{ substr($jadwal->pelanggan->nama, 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <div class="text-sm font-semibold text-gray-900 truncate">{{ $jadwal->pelanggan->nama }}</div>
                                <div class="text-xs text-gray-600 flex items-center gap-1 mt-0.5">
                                    <i data-lucide="map-pin" class="w-3 h-3"></i>
                                    <span class="truncate">{{ $jadwal->alamat_pengiriman ?? $jadwal->pelanggan->alamat }}</span>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('transaksi.create', ['pelanggan_id' => $jadwal->pelanggan_id, 'tipe_transaksi' => 'antar']) }}" class="border border-gray-300 text-gray-600 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-300 p-2 rounded transition-colors shrink-0" title="Proses Lebih Awal">
                            <i data-lucide="shopping-cart" class="w-4 h-4"></i>
                        </a>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-8 text-gray-400">
                        <i data-lucide="calendar-range" class="w-8 h-8 mb-2"></i>
                        <p class="text-sm font-medium">Tidak ada jadwal</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Modal Gagal -->
        <div x-show="showGagalModal" 
             class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50"
             x-cloak
             @keydown.escape.window="showGagalModal = false">
            <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden" @click.away="showGagalModal = false">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900">Tandai Gagal Pengiriman</h3>
                    <p class="text-sm text-gray-600 mt-1" x-text="'Pelanggan: ' + selectedJadwalNama"></p>
                </div>
                <form :action="actionUrl" method="POST" class="p-6">
                    @csrf
                    <div class="mb-4">
                        <label for="catatan_gagal" class="block text-sm font-medium text-gray-700 mb-2">Alasan Gagal (Opsional)</label>
                        <textarea name="catatan" id="catatan_gagal" rows="3" 
                                  class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                  placeholder="Contoh: Rumah kosong, Pelanggan membatalkan, dsb."></textarea>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" @click="showGagalModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors shadow-sm">
                            Simpan Status Gagal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Transaksi Terbaru -->
<section class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex flex-col">
    <div class="p-6 border-b border-gray-200 flex justify-between items-center">
        <h2 class="text-lg font-bold text-gray-900">Transaksi Terbaru</h2>
        <a class="text-sm font-medium text-blue-600 hover:text-blue-700" href="{{ route('transaksi.index') }}">Lihat Semua →</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">ID Transaksi</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Pelanggan</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Waktu</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($transaksiTerbaru as $trx)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-900 font-medium">#{{ $trx->kode_transaksi }}</td>
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $trx->pelanggan->nama ?? 'Umum' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $trx->tanggal_transaksi->format('H:i') }} WIB</td>
                        <td class="px-6 py-4 text-sm text-gray-900 font-semibold">Rp {{ number_format($trx->total_harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusClasses = [
                                    'pending'    => 'bg-amber-100 text-amber-800',
                                    'diproses'   => 'bg-blue-100 text-blue-800',
                                    'diantar'    => 'bg-purple-100 text-purple-800',
                                    'selesai'    => 'bg-green-100 text-green-800',
                                    'dibatalkan' => 'bg-red-100 text-red-800',
                                ][$trx->status_transaksi] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold uppercase {{ $statusClasses }}">
                                {{ $trx->status_transaksi }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('transaksi.show', $trx) }}" class="text-gray-400 hover:text-blue-600 transition-colors inline-flex items-center justify-center p-2 hover:bg-blue-50 rounded">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            Belum ada transaksi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection