@extends('layouts.app')
@section('title', 'Edit Pengeluaran')

@section('content')
<div class="max-w-2xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <a href="{{ route('pengeluaran.index') }}" class="inline-flex items-center text-primary hover:underline mb-4 font-label-md text-label-md">
            <span class="material-symbols-outlined text-[20px] mr-1">arrow_back</span>
            Kembali ke Daftar
        </a>
        <h2 class="font-headline-lg-mobile md:font-headline-lg text-headline-lg-mobile md:text-headline-lg text-on-surface">Edit Pengeluaran</h2>
        <p class="font-body-md text-body-md text-on-surface-variant mt-1">Perbarui data pengeluaran operasional.</p>
    </div>

    <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl p-6 shadow-sm">
        <form action="{{ route('pengeluaran.update', $pengeluaran) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Pengeluaran -->
            <div>
                <label for="nama_pengeluaran" class="block font-label-md text-label-md text-on-surface mb-2">Nama Pengeluaran <span class="text-error">*</span></label>
                <input type="text" name="nama_pengeluaran" id="nama_pengeluaran" value="{{ old('nama_pengeluaran', $pengeluaran->nama_pengeluaran) }}" 
                       class="w-full px-4 py-2 bg-surface rounded-lg border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface @error('nama_pengeluaran') border-error @enderror" 
                       placeholder="Contoh: Bensin Motor Pengantar" required>
                @error('nama_pengeluaran')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kategori -->
                <div>
                    <label for="kategori" class="block font-label-md text-label-md text-on-surface mb-2">Kategori <span class="text-error">*</span></label>
                    <select name="kategori" id="kategori" class="w-full px-4 py-2 bg-surface rounded-lg border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface @error('kategori') border-error @enderror" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoriList as $kat)
                            <option value="{{ $kat }}" {{ old('kategori', $pengeluaran->kategori) == $kat ? 'selected' : '' }}>{{ ucfirst($kat) }}</option>
                        @endforeach
                    </select>
                    @error('kategori')
                        <p class="text-error text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal -->
                <div>
                    <label for="tanggal" class="block font-label-md text-label-md text-on-surface mb-2">Tanggal <span class="text-error">*</span></label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal', $pengeluaran->tanggal->format('Y-m-d')) }}" 
                           class="w-full px-4 py-2 bg-surface rounded-lg border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface @error('tanggal') border-error @enderror" required>
                    @error('tanggal')
                        <p class="text-error text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Nominal -->
            <div>
                <label for="nominalDisplay" class="block font-label-md text-label-md text-on-surface mb-2">Nominal (Rp) <span class="text-error">*</span></label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant font-medium">Rp</span>
                    <input type="text" id="nominalDisplay" 
                           class="w-full pl-12 pr-4 py-2 bg-surface rounded-lg border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface @error('nominal') border-error @enderror" 
                           placeholder="0" required>
                    <input type="hidden" name="nominal" id="nominal" value="{{ old('nominal', (int)$pengeluaran->nominal) }}">
                </div>
                @error('nominal')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Keterangan -->
            <div>
                <label for="keterangan" class="block font-label-md text-label-md text-on-surface mb-2">Keterangan (Opsional)</label>
                <textarea name="keterangan" id="keterangan" rows="3" 
                          class="w-full px-4 py-2 bg-surface rounded-lg border border-outline-variant/50 focus:border-primary focus:ring-1 focus:ring-primary outline-none font-body-md text-body-md text-on-surface">{{ old('keterangan', $pengeluaran->keterangan) }}</textarea>
            </div>

            <!-- Foto Nota -->
            <div>
                <label for="foto_nota" class="block font-label-md text-label-md text-on-surface mb-2">Foto Nota/Struk (Opsional)</label>
                @if($pengeluaran->foto_nota)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $pengeluaran->foto_nota) }}" alt="Nota" class="w-32 h-32 object-cover rounded-lg border border-outline-variant/30">
                        <p class="text-xs text-on-surface-variant mt-1">Foto saat ini</p>
                    </div>
                @endif
                <input type="file" name="foto_nota" id="foto_nota" accept="image/*"
                       class="w-full text-sm text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-label-md file:font-semibold file:bg-primary-container/20 file:text-primary hover:file:bg-primary-container/30">
                <p class="text-xs text-on-surface-variant mt-1">Pilih file baru jika ingin mengganti. Maksimal 2MB.</p>
                @error('foto_nota')
                    <p class="text-error text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="pt-4 border-t border-outline-variant/30 flex justify-end gap-3">
                <a href="{{ route('pengeluaran.index') }}" class="px-6 py-2.5 rounded-lg border border-outline-variant text-on-surface font-label-md text-label-md hover:bg-surface-container transition-all">Batal</a>
                <button type="submit" class="px-6 py-2.5 rounded-lg bg-primary text-on-primary font-label-md text-label-md hover:bg-primary/90 shadow-sm transition-all">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    // Format currency input
    const nominalDisplay = document.getElementById('nominalDisplay');
    const nominalInput = document.getElementById('nominal');

    function formatCurrency(value) {
        // Remove non-digit characters
        const numbers = value.replace(/\D/g, '');
        // Format with thousand separator
        return numbers.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function unformatCurrency(value) {
        return value.replace(/\D/g, '');
    }

    nominalDisplay.addEventListener('input', function() {
        this.value = formatCurrency(this.value);
        nominalInput.value = unformatCurrency(this.value);
    });

    nominalDisplay.addEventListener('keypress', function(e) {
        // Only allow digits
        if (!/[0-9]/.test(e.key)) {
            e.preventDefault();
        }
    });

    // Set initial display value if editing
    if (nominalInput.value) {
        nominalDisplay.value = formatCurrency(nominalInput.value);
    }

    // Before submit, ensure nominal value is clean
    document.querySelector('form').addEventListener('submit', function() {
        nominalInput.value = unformatCurrency(nominalDisplay.value);
    });
</script>
@endsection
