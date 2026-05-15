<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggan::withCount('transaksi');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                  ->orWhere('no_hp', 'like', "%$search%")
                  ->orWhere('alamat', 'like', "%$search%");
            });
        }

        $pelanggan = $query->latest()->paginate(10)->withQueryString();

        return view('pelanggan.index', compact('pelanggan'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'    => 'required|string|max:100',
            'no_hp'   => 'nullable|string|max:20',
            'alamat'  => 'nullable|string',
            'catatan' => 'nullable|string',
        ], [
            'nama.required' => 'Nama pelanggan wajib diisi.',
        ]);

        Pelanggan::create($validated);

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil ditambahkan.');
    }

    public function show(Pelanggan $pelanggan)
    {
        $transaksi = $pelanggan->transaksi()
            ->with('detail.produk')
            ->latest()
            ->paginate(10);

        $jadwalRutin = $pelanggan->jadwalRutin()->get();

        $totalBelanja = $pelanggan->transaksi()
            ->where('status_transaksi', 'selesai')
            ->sum('total_harga');

        return view('pelanggan.show', compact('pelanggan', 'transaksi', 'jadwalRutin', 'totalBelanja'));
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $validated = $request->validate([
            'nama'    => 'required|string|max:100',
            'no_hp'   => 'nullable|string|max:20',
            'alamat'  => 'nullable|string',
            'catatan' => 'nullable|string',
        ]);

        $pelanggan->update($validated);

        return redirect()->route('pelanggan.index')
            ->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();

        return redirect()->route('pelanggan.index')
            ->with('success', 'Pelanggan berhasil dihapus.');
    }
}