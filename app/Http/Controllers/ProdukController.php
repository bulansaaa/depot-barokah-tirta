<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::query();

        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('status_aktif', $request->status === 'aktif');
        }

        $produk = $query->latest()->paginate(10)->withQueryString();

        return view('produk.index', compact('produk'));
    }

    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk'  => 'required|string|max:100',
            'harga'        => 'required|numeric|min:0',
            'satuan'       => 'required|string|max:30',
            'status_aktif' => 'boolean',
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'harga.required'       => 'Harga produk wajib diisi.',
        ]);

        $validated['status_aktif'] = $request->boolean('status_aktif', true);

        Produk::create($validated);

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    public function edit(Produk $produk)
    {
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'nama_produk'  => 'required|string|max:100',
            'harga'        => 'required|numeric|min:0',
            'satuan'       => 'required|string|max:30',
            'status_aktif' => 'boolean',
        ]);

        $validated['status_aktif'] = $request->boolean('status_aktif');

        $produk->update($validated);

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        $produk->update(['status_aktif' => false]);

        return redirect()->route('produk.index')
            ->with('success', 'Produk berhasil dinonaktifkan.');
    }
}