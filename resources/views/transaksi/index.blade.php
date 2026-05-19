@extends('layouts.app')
@section('title', 'Data Transaksi')

@section('content')
<!-- Page Header -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h2 class="font-headline-lg text-headline-lg text-on-surface">Data Transaksi</h2>
        <p class="font-body-md text-body-md text-on-surface-variant mt-1">Pantau dan kelola semua transaksi penjualan depot Anda.</p>
    </div>
    <a href="{{ route('transaksi.create') }}" class="bg-primary text-on-primary hover:bg-primary/90 active:scale-95 transition-all duration-200 px-6 py-3 rounded-lg font-label-md text-label-md flex items-center justify-center gap-2 shadow-sm whitespace-nowrap">
        <span class="material-symbols-outlined text-[20px]">add</span>
        Buat Transaksi Baru
    </a>
</div>

{{-- Filter Section --}}
<section class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl p-6 shadow-sm mb-8">
    <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-end">
        <div class="flex flex-col gap-2">
            <label class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Cari</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline text-[20px]">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Kode / Pelanggan..." 
                       class="w-full pl-10 pr-4 py-2 bg-surface rounded-lg border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface transition-all">
            </div>
        </div>

        <div class="flex flex-col gap-2">
            <label class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Status</label>
            <select name="status" class="w-full px-4 py-2 bg-surface rounded-lg border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface transition-all">
                <option value="">Semua Status</option>
                @foreach(['pending','diproses','diantar','selesai','dibatalkan'] as $s)
                    <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-col gap-2">
            <label class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Tipe</label>
            <select name="tipe" class="w-full px-4 py-2 bg-surface rounded-lg border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface transition-all">
                <option value="">Semua Tipe</option>
                @foreach(['langsung','antar'] as $t)
                    <option value="{{ $t }}" {{ request('tipe') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex flex-col gap-2">
            <label class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Tanggal</label>
            <input type="date" name="tanggal" value="{{ request('tanggal') }}" 
                   class="w-full px-4 py-2 bg-surface rounded-lg border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface transition-all">
        </div>

        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-surface-container-highest text-primary font-label-md text-label-md py-2.5 rounded-lg hover:bg-surface-container transition-colors">
                Filter
            </button>
            @if(request()->hasAny(['search','status','tipe','tanggal']))
                <a href="{{ route('transaksi.index') }}" class="bg-surface-container-low text-on-surface-variant p-2.5 rounded-lg hover:bg-surface-container transition-colors" title="Reset">
                    <span class="material-symbols-outlined text-[20px]">close</span>
                </a>
            @endif
        </div>
    </form>
</section>

{{-- Transaction List --}}
<div class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-surface-container-low border-b border-outline-variant/30 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">Kode</th>
                    <th class="px-6 py-4 font-semibold">Pelanggan</th>
                    <th class="px-6 py-4 font-semibold">Tipe</th>
                    <th class="px-6 py-4 font-semibold">Total</th>
                    <th class="px-6 py-4 font-semibold">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="font-body-md text-body-md text-on-surface divide-y divide-outline-variant/20">
                @forelse($transaksi as $trx)
                <tr class="hover:bg-surface-container/50 transition-colors">
                    <td class="px-6 py-4 font-mono text-xs text-on-surface-variant">#{{ $trx->kode_transaksi }}</td>
                    <td class="px-6 py-4">
                        <p class="font-semibold text-on-surface">{{ $trx->pelanggan->nama ?? 'Umum' }}</p>
                        <p class="font-label-sm text-label-sm text-on-surface-variant">{{ $trx->tanggal_transaksi->format('d M Y, H:i') }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-label-sm text-label-sm font-bold uppercase {{ $trx->tipe_transaksi === 'antar' ? 'text-primary' : 'text-on-surface-variant' }}">
                            {{ $trx->tipe_transaksi }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-semibold text-on-surface">
                        Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        @if(in_array($trx->status_transaksi, ['selesai', 'dibatalkan']))
                            @php
                                $statusClasses = [
                                    'selesai'    => 'bg-[#d1fae5] text-[#065f46]',
                                    'dibatalkan' => 'bg-error-container/30 text-error',
                                ][$trx->status_transaksi];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full font-label-sm text-label-sm font-bold uppercase {{ $statusClasses }}">
                                {{ $trx->status_transaksi }}
                            </span>
                        @else
                            <form method="POST" action="{{ route('transaksi.status.update', $trx) }}" class="inline-block">
                                @csrf @method('PATCH')
                                <select name="status_transaksi" 
                                    x-on:change="
                                        const select = $el;
                                        const form = $el.form;
                                        const newVal = select.value;
                                        const oldVal = '{{ $trx->status_transaksi }}';
                                        
                                        if(newVal === 'selesai' || newVal === 'dibatalkan') {
                                            // Reset dropdown selection immediately so it doesn't look changed yet
                                            select.value = oldVal;
                                            
                                            $dispatch('confirm', {
                                                title: newVal === 'selesai' ? 'Selesaikan Transaksi?' : 'Batalkan Transaksi?',
                                                message: newVal === 'selesai' ? 'Pastikan pesanan sudah diterima dan pembayaran telah lunas.' : 'Transaksi yang dibatalkan tidak dapat diubah statusnya lagi.',
                                                onConfirm: () => {
                                                    // Set intended value back right before submit
                                                    select.value = newVal;
                                                    form.submit();
                                                },
                                                confirmText: newVal === 'selesai' ? 'Ya, Selesai' : 'Ya, Batalkan',
                                                cancelText: 'Kembali'
                                            });
                                        } else {
                                            form.submit();
                                        }
                                    "
                                    class="font-label-sm text-label-sm font-bold uppercase py-1 px-3 rounded-full border border-outline-variant/50 outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-all cursor-pointer bg-surface-container-low
                                    {{ $trx->status_transaksi === 'pending' ? 'text-tertiary' : '' }}
                                    {{ $trx->status_transaksi === 'diproses' ? 'text-primary' : '' }}
                                    {{ $trx->status_transaksi === 'diantar' ? 'text-on-secondary-fixed-variant' : '' }}">
                                    @foreach(['pending','diproses','diantar','selesai','dibatalkan'] as $s)
                                        <option value="{{ $s }}" {{ $trx->status_transaksi === $s ? 'selected' : '' }}>
                                            {{ ucfirst($s) }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end gap-2 text-on-surface-variant">
                            <a href="{{ route('transaksi.show', $trx) }}" class="hover:text-primary transition-colors p-1" title="Detail">
                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                            </a>
                            <a href="{{ route('transaksi.nota', $trx) }}" class="hover:text-primary transition-colors p-1" title="Nota">
                                <span class="material-symbols-outlined text-[20px]">receipt_long</span>
                            </a>
                            
                            @if($trx->status_transaksi !== 'selesai' && $trx->status_transaksi !== 'dibatalkan')
                            <form method="POST" action="{{ route('transaksi.destroy', $trx) }}" class="inline" 
                                  x-on:submit.prevent="
                                    const currentForm = $el;
                                    $dispatch('confirm', {
                                        title: 'Hapus Transaksi?',
                                        message: 'Data yang dihapus tidak dapat dikembalikan.',
                                        onConfirm: () => currentForm.submit(),
                                        confirmText: 'Ya, Hapus',
                                        cancelText: 'Batal'
                                    })
                                  ">
                                @csrf @method('DELETE')
                                <button type="submit" class="hover:text-error transition-colors p-1" title="Hapus">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-on-surface-variant opacity-50">
                        Belum ada data transaksi.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($transaksi->hasPages())
    <div class="px-6 py-4 border-t border-outline-variant/30 bg-surface-container-low/30">
        {{ $transaksi->links() }}
    </div>
    @endif
</div>
@endsection