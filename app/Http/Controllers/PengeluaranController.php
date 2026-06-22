<?php

namespace App\Http\Controllers;

use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengeluaran::latest('tanggal');

        if ($request->filled('search')) {
            $query->where('nama_pengeluaran', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal', $request->tanggal);
        }

        $pengeluaran = $query->paginate(10)->withQueryString();
        $kategoriList = ['operasional', 'pemeliharaan', 'bahan baku', 'gaji', 'lainnya'];

        return view('pengeluaran.index', compact('pengeluaran', 'kategoriList'));
    }

    public function create()
    {
        $kategoriList = ['operasional', 'pemeliharaan', 'bahan baku', 'gaji', 'lainnya'];
        return view('pengeluaran.create', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pengeluaran' => 'required|string|max:255',
            'kategori'         => 'required|string',
            'nominal'          => 'required|numeric|min:0',
            'tanggal'          => 'required|date',
            'keterangan'       => 'nullable|string',
            'foto_nota'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto_nota')) {
            $path = $request->file('foto_nota')->store('pengeluaran', 'public');
            $validated['foto_nota'] = $path;
        }

        Pengeluaran::create($validated);

        return redirect()->route('pengeluaran.index')
            ->with('success', 'Pengeluaran berhasil dicatat.');
    }

    public function edit(Pengeluaran $pengeluaran)
    {
        $kategoriList = ['operasional', 'pemeliharaan', 'bahan baku', 'gaji', 'lainnya'];
        return view('pengeluaran.edit', compact('pengeluaran', 'kategoriList'));
    }

    public function update(Request $request, Pengeluaran $pengeluaran)
    {
        $validated = $request->validate([
            'nama_pengeluaran' => 'required|string|max:255',
            'kategori'         => 'required|string',
            'nominal'          => 'required|numeric|min:0',
            'tanggal'          => 'required|date',
            'keterangan'       => 'nullable|string',
            'foto_nota'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto_nota')) {
            // Hapus foto lama jika ada
            if ($pengeluaran->foto_nota) {
                Storage::disk('public')->delete($pengeluaran->foto_nota);
            }
            $path = $request->file('foto_nota')->store('pengeluaran', 'public');
            $validated['foto_nota'] = $path;
        }

        $pengeluaran->update($validated);

        return redirect()->route('pengeluaran.index')
            ->with('success', 'Pengeluaran berhasil diperbarui.');
    }

    public function destroy(Pengeluaran $pengeluaran)
    {
        if ($pengeluaran->foto_nota) {
            Storage::disk('public')->delete($pengeluaran->foto_nota);
        }
        $pengeluaran->delete();

        return redirect()->route('pengeluaran.index')
            ->with('success', 'Pengeluaran berhasil dihapus.');
    }
}
