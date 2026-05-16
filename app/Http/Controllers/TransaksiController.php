<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with('pelanggan')->latest('tanggal_transaksi');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('kode_transaksi', 'like', "%$search%")
                  ->orWhereHas('pelanggan', fn($p) => $p->where('nama', 'like', "%$search%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status_transaksi', $request->status);
        }

        if ($request->filled('tipe')) {
            $query->where('tipe_transaksi', $request->tipe);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_transaksi', $request->tanggal);
        }

        $transaksi = $query->paginate(10)->withQueryString();

        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::orderBy('nama')->get();
        $produk    = Produk::aktif()->get();

        return view('transaksi.create', compact('pelanggan', 'produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pelanggan_id'      => 'nullable|exists:pelanggan,id',
            'tipe_transaksi'    => 'required|in:langsung,antar,langganan',
            'metode_pemesanan'  => 'required|in:langsung,whatsapp,telepon',
            'alamat_pengiriman' => 'required_if:tipe_transaksi,antar,langganan|nullable|string',
            'no_hp_pengiriman'  => 'required_if:tipe_transaksi,antar,langganan|nullable|string|max:20',
            'catatan'           => 'nullable|string',
            'produk'            => 'required|array|min:1',
            'produk.*.id'       => 'required|exists:produk,id',
            'produk.*.qty'      => 'required|integer|min:1',
        ], [
            'produk.required'            => 'Minimal satu produk harus dipilih.',
            'alamat_pengiriman.required_if' => 'Alamat pengiriman wajib diisi untuk tipe antar/langganan.',
            'no_hp_pengiriman.required_if'  => 'No HP pengiriman wajib diisi untuk tipe antar/langganan.',
        ]);

        DB::transaction(function () use ($request) {
            // Hitung total harga
            $total = 0;
            $items = [];

            foreach ($request->produk as $item) {
                $produk   = Produk::findOrFail($item['id']);
                $subtotal = $produk->harga * $item['qty'];
                $total   += $subtotal;

                $items[] = [
                    'produk_id' => $produk->id,
                    'qty'       => $item['qty'],
                    'harga'     => $produk->harga,
                    'subtotal'  => $subtotal,
                ];
            }

            // Tentukan status awal
            $status = $request->tipe_transaksi === 'langsung' ? 'selesai' : 'pending';

            // Buat header transaksi
            $transaksi = Transaksi::create([
                'kode_transaksi'    => Transaksi::generateKode(),
                'pelanggan_id'      => $request->pelanggan_id,
                'user_id'           => auth()->id(),
                'tipe_transaksi'    => $request->tipe_transaksi,
                'metode_pemesanan'  => $request->metode_pemesanan,
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'no_hp_pengiriman'  => $request->no_hp_pengiriman,
                'status_transaksi'  => $status,
                'tanggal_transaksi' => now(),
                'total_harga'       => $total,
                'catatan'           => $request->catatan,
            ]);

            // Buat detail transaksi
            foreach ($items as $item) {
                $transaksi->detail()->create($item);
            }
        });

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dibuat.');
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load('pelanggan', 'user', 'detail.produk');

        return view('transaksi.show', compact('transaksi'));
    }

    public function updateStatus(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'status_transaksi' => 'required|in:pending,diproses,diantar,selesai,dibatalkan',
        ]);

        $transaksi->update(['status_transaksi' => $request->status_transaksi]);

        return redirect()->back()
            ->with('success', 'Status transaksi berhasil diperbarui.');
    }

    public function destroy(Transaksi $transaksi)
    {
        if ($transaksi->status_transaksi === 'selesai') {
            return redirect()->back()
                ->with('error', 'Transaksi yang sudah selesai tidak dapat dihapus.');
        }

        $transaksi->delete();

        return redirect()->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    public function cetakNota(Transaksi $transaksi)
    {
        $transaksi->load('pelanggan', 'user', 'detail.produk');

        return view('transaksi.nota', compact('transaksi'));
    }
}