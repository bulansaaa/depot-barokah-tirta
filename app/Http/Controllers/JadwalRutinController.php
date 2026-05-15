<?php

namespace App\Http\Controllers;

use App\Models\JadwalRutin;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JadwalRutinController extends Controller
{
    // Daftar hari dalam Bahasa Indonesia
    private array $hariList = [
        'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'
    ];

    public function index(Request $request)
    {
        $hariIni = Carbon::now()->locale('id')->isoFormat('dddd');

        $query = JadwalRutin::with('pelanggan');

        if ($request->filled('hari')) {
            $query->hari($request->hari);
        }

        if ($request->filled('status')) {
            $query->where('status_aktif', $request->status === 'aktif');
        }

        $jadwal   = $query->latest()->paginate(10)->withQueryString();
        $hariList = $this->hariList;

        // Jadwal aktif hari ini
        $jadwalHariIni = JadwalRutin::with('pelanggan')
            ->aktif()
            ->hari($hariIni)
            ->get();

        return view('jadwal-rutin.index', compact('jadwal', 'hariList', 'jadwalHariIni', 'hariIni'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::orderBy('nama')->get();
        $hariList  = $this->hariList;

        return view('jadwal-rutin.create', compact('pelanggan', 'hariList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelanggan_id'      => 'required|exists:pelanggan,id',
            'hari_pengiriman'   => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'alamat_pengiriman' => 'nullable|string',
            'status_aktif'      => 'boolean',
            'catatan'           => 'nullable|string',
        ], [
            'pelanggan_id.required'    => 'Pelanggan wajib dipilih.',
            'hari_pengiriman.required' => 'Hari pengiriman wajib dipilih.',
        ]);

        $validated['status_aktif'] = $request->boolean('status_aktif', true);

        JadwalRutin::create($validated);

        return redirect()->route('jadwal-rutin.index')
            ->with('success', 'Jadwal rutin berhasil ditambahkan.');
    }

    public function edit(JadwalRutin $jadwalRutin)
    {
        $pelanggan = Pelanggan::orderBy('nama')->get();
        $hariList  = $this->hariList;

        return view('jadwal-rutin.edit', compact('jadwalRutin', 'pelanggan', 'hariList'));
    }

    public function update(Request $request, JadwalRutin $jadwalRutin)
    {
        $validated = $request->validate([
            'pelanggan_id'      => 'required|exists:pelanggan,id',
            'hari_pengiriman'   => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu',
            'alamat_pengiriman' => 'nullable|string',
            'status_aktif'      => 'boolean',
            'catatan'           => 'nullable|string',
        ]);

        $validated['status_aktif'] = $request->boolean('status_aktif');

        $jadwalRutin->update($validated);

        return redirect()->route('jadwal-rutin.index')
            ->with('success', 'Jadwal rutin berhasil diperbarui.');
    }

    public function destroy(JadwalRutin $jadwalRutin)
    {
        $jadwalRutin->delete();

        return redirect()->route('jadwal-rutin.index')
            ->with('success', 'Jadwal rutin berhasil dihapus.');
    }

    public function toggleStatus(JadwalRutin $jadwalRutin)
    {
        $jadwalRutin->update(['status_aktif' => !$jadwalRutin->status_aktif]);

        $msg = $jadwalRutin->status_aktif ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->back()->with('success', "Jadwal rutin berhasil $msg.");
    }
}