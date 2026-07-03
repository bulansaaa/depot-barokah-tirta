@extends('layouts.app')
@section('title', 'Catat Transaksi')

@section('content')
<div class="mb-8">
    <h2 class="font-headline-lg text-headline-lg text-on-surface">Catat Transaksi</h2>
    <p class="font-body-md text-body-md text-on-surface-variant mt-2">Masukkan detail untuk penjualan isi ulang atau pengantaran air baru.</p>
</div>

@if ($errors->any())
    <div class="bg-error-container/20 border border-error text-on-error-container p-4 rounded-xl mb-6">
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('transaksi.store') }}" id="formTransaksi">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-gutter items-start">
        <!-- Left Column: Form Areas -->
        <div class="lg:col-span-8 flex flex-col gap-gutter">
            
            <!-- Customer Information Card -->
            <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl p-gutter shadow-sm">
                <h3 class="font-headline-sm text-headline-sm text-on-surface mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">person</span>
                    Informasi Pelanggan
                </h3>
                <div class="flex flex-col gap-2">
                    <label class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Pilih Pelanggan</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                        <select name="pelanggan_id" id="pelangganId" onchange="updateCustomerDetails()"
                                class="w-full pl-10 pr-4 py-3 bg-surface-bright border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors appearance-none">
                            <option value="">-- Pelanggan Umum --</option>
                            @foreach($pelanggan as $p)
                                <option value="{{ $p->id }}"
                                    data-alamat="{{ $p->alamat }}"
                                    data-nohp="{{ $p->no_hp }}"
                                    {{ old('pelanggan_id', request('pelanggan_id')) == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama }} ({{ $p->no_hp }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <p class="font-label-sm text-label-sm text-outline mt-1">Kosongkan jika pelanggan umum (bukan pelanggan tetap).</p>
                </div>
            </div>

            <!-- Order Details Card -->
            <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl p-gutter shadow-sm">
                <h3 class="font-headline-sm text-headline-sm text-on-surface mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">local_shipping</span>
                    Detail Pesanan
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Transaction Date -->
                    <div class="col-span-1 md:col-span-2">
                        <label class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-2 block">Tanggal Transaksi</label>
                        <input type="date" name="tanggal_transaksi" id="tanggalTransaksi" value="{{ old('tanggal_transaksi', date('Y-m-d')) }}"
                               class="w-full md:w-1/2 p-3 bg-surface-bright border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                        <p class="font-label-sm text-label-sm text-outline mt-1">Ubah jika ingin mencatat transaksi untuk tanggal yang sudah lewat (misal: kemarin).</p>
                    </div>

                    <!-- Transaction Type -->
                    <div>
                        <label class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-3 block">Tipe Transaksi</label>
                        <div class="flex flex-col gap-3">
                            <label class="flex items-center p-3 border border-outline-variant rounded-lg cursor-pointer hover:bg-surface-container-low transition-colors has-[:checked]:border-primary has-[:checked]:bg-primary-fixed/20">
                                <input class="w-4 h-4 text-primary border-outline-variant focus:ring-primary" name="tipe_transaksi" type="radio" value="langsung" onchange="toggleDeliveryFields()" {{ old('tipe_transaksi', request('tipe_transaksi', 'langsung')) == 'langsung' ? 'checked' : '' }}/>
                                <span class="ml-3 font-body-md text-body-md text-on-surface">Langsung (Di Tempat)</span>
                            </label>
                            <label class="flex items-center p-3 border border-outline-variant rounded-lg cursor-pointer hover:bg-surface-container-low transition-colors has-[:checked]:border-primary has-[:checked]:bg-primary-fixed/20">
                                <input class="w-4 h-4 text-primary border-outline-variant focus:ring-primary" name="tipe_transaksi" type="radio" value="antar" onchange="toggleDeliveryFields()" {{ old('tipe_transaksi', request('tipe_transaksi')) == 'antar' ? 'checked' : '' }}/>
                                <span class="ml-3 font-body-md text-body-md text-on-surface">Antar (Delivery)</span>
                            </label>
                        </div>
                    </div>

                </div>

                <!-- Conditional Address & Info Field -->
                <div id="deliveryFields" class="mt-6 pt-6 border-t border-outline-variant/30 {{ old('tipe_transaksi', request('tipe_transaksi')) === 'antar' ? '' : 'hidden' }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="col-span-1">
                            <label class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-2 block">No HP Penerima</label>
                            <input type="text" name="no_hp_pengiriman" id="noHpPengiriman" value="{{ old('no_hp_pengiriman') }}"
                                   class="w-full p-3 bg-surface-bright border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" placeholder="0812...">
                        </div>
                        <div class="col-span-1">
                            <label class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-2 block">Alamat Pengiriman</label>
                            <textarea name="alamat_pengiriman" id="alamatPengiriman" class="w-full p-3 bg-surface-bright border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" placeholder="Masukkan alamat pengiriman lengkap..." rows="1">{{ old('alamat_pengiriman') }}</textarea>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <label class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-2 block">Catatan Tambahan</label>
                    <input type="text" name="catatan" value="{{ old('catatan') }}"
                           class="w-full p-3 bg-surface-bright border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                           placeholder="Catatan tambahan (opsional)">
                </div>
            </div>

            <!-- Products Card -->
            <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl shadow-sm overflow-hidden">
                <div class="p-gutter border-b border-outline-variant/30 flex justify-between items-center bg-surface-container-low/50">
                    <h3 class="font-headline-sm text-headline-sm text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">inventory_2</span>
                        Pilih Produk
                    </h3>
                </div>

                <div class="p-gutter">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6" id="productGrid">
                        @foreach($produk as $p)
                            @php
                                $oldQty = 0;
                                $oldInput = old('produk');
                                if (is_array($oldInput)) {
                                    foreach ($oldInput as $item) {
                                        if (isset($item['id']) && $item['id'] == $p->id) {
                                            $oldQty = intval($item['qty'] ?? 0);
                                            break;
                                        }
                                    }
                                }
                                $isSelected = $oldQty > 0;
                                
                                // Menentukan ikon berdasarkan nama produk agar visual lebih menarik
                                $icon = 'water_drop';
                                $iconColor = 'text-primary bg-primary-fixed/30';
                                $lowercaseName = strtolower($p->nama_produk);
                                if (strpos($lowercaseName, 'galon') !== false) {
                                    $icon = 'water_bottle';
                                    $iconColor = 'text-[#0f52ba] bg-[#0f52ba]/10';
                                } elseif (strpos($lowercaseName, 'isi ulang') !== false || strpos($lowercaseName, 'refill') !== false) {
                                    $icon = 'local_drink';
                                    $iconColor = 'text-secondary bg-secondary-fixed/20';
                                } elseif (strpos($lowercaseName, 'baru') !== false) {
                                    $icon = 'new_releases';
                                    $iconColor = 'text-tertiary bg-tertiary-fixed/40';
                                }
                            @endphp
                            
                            <div class="product-card cursor-pointer border rounded-xl p-5 flex flex-col justify-between transition-all duration-200 select-none relative {{ $isSelected ? 'border-primary bg-primary/5 shadow-sm shadow-primary/10 ring-1 ring-primary' : 'border-outline-variant/40 bg-surface-container-lowest hover:border-primary/50 hover:bg-surface-container-low/20' }}"
                                 id="product-card-{{ $p->id }}"
                                 data-id="{{ $p->id }}"
                                 data-nama="{{ $p->nama_produk }}"
                                 data-harga="{{ $p->harga }}"
                                 data-satuan="{{ $p->satuan }}"
                                 onclick="handleCardClick({{ $p->id }}, event)">
                                
                                <div class="flex items-start gap-4 mb-5">
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 border border-outline-variant/10 {{ $iconColor }}">
                                        <span class="material-symbols-outlined text-[24px]">{{ $icon }}</span>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="font-title-md text-on-surface font-semibold leading-snug break-words pr-2">{{ $p->nama_produk }}</h4>
                                        <p class="font-label-md text-on-surface-variant font-medium mt-1">
                                             Rp {{ number_format($p->harga, 0, ',', '.') }} <span class="text-outline">/ {{ $p->satuan }}</span>
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-auto">
                                    <div class="flex items-center border border-outline-variant/80 rounded-lg bg-surface-bright w-full justify-between overflow-hidden shadow-sm">
                                        <button type="button" 
                                                onclick="changeProductQty({{ $p->id }}, -1, event)" 
                                                class="w-10 h-10 flex items-center justify-center text-on-surface-variant hover:text-primary hover:bg-surface-container-low transition-colors focus:outline-none">
                                            <span class="material-symbols-outlined text-[18px]">remove</span>
                                        </button>
                                        
                                        <input type="number" 
                                               id="qty-input-{{ $p->id }}" 
                                               value="{{ $oldQty }}" 
                                               min="0" 
                                               oninput="manualQtyInput({{ $p->id }}, this, event)"
                                               class="qty-field w-12 text-center bg-transparent border-none font-body-md text-body-md text-on-surface font-bold focus:ring-0 focus:outline-none p-0 [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none" />
                                        
                                        <button type="button" 
                                                onclick="changeProductQty({{ $p->id }}, 1, event)" 
                                                class="w-10 h-10 flex items-center justify-center text-on-surface-variant hover:text-primary hover:bg-surface-container-low transition-colors focus:outline-none">
                                            <span class="material-symbols-outlined text-[18px]">add</span>
                                        </button>
                                    </div>
                                </div>

                                <!-- Input Tersembunyi untuk Form POST -->
                                <input type="hidden" 
                                       id="hidden-id-{{ $p->id }}" 
                                       name="produk[{{ $p->id }}][id]" 
                                       value="{{ $p->id }}" 
                                       {{ $isSelected ? '' : 'disabled' }} />
                                
                                <input type="hidden" 
                                       id="hidden-qty-{{ $p->id }}" 
                                       name="produk[{{ $p->id }}][qty]" 
                                       value="{{ $oldQty }}" 
                                       {{ $isSelected ? '' : 'disabled' }} />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Summary & Actions -->
        <div class="lg:col-span-4 flex flex-col gap-gutter lg:sticky lg:top-[104px]">
            <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl p-gutter shadow-sm relative overflow-hidden">
                <!-- Decorative top accent -->
                <div class="absolute top-0 left-0 w-full h-1 bg-primary"></div>
                <h3 class="font-headline-sm text-headline-sm text-on-surface mb-6">Ringkasan Pesanan</h3>
                
                <div class="border-b border-outline-variant/30 pb-4 mb-4">
                    <h4 class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-3">Item Terpilih</h4>
                    <div id="selectedItemsList" class="flex flex-col gap-3 max-h-[220px] overflow-y-auto pr-1">
                        <!-- Item dinamis akan dimasukkan di sini melalui JS -->
                        <p class="font-body-md text-body-md text-outline italic" id="emptyItemsPlaceholder">Belum ada produk terpilih.</p>
                    </div>
                </div>

                <div class="flex flex-col gap-3 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="font-body-md text-body-md text-on-surface-variant font-medium">Subtotal</span>
                        <span id="subtotalLabel" class="font-body-md text-body-md text-on-surface font-bold">Rp 0</span>
                    </div>
                </div>
                <div class="border-t border-outline-variant/30 pt-4 mb-8">
                    <div class="flex justify-between items-center">
                        <span class="font-headline-md text-headline-md text-on-surface">Total</span>
                        <span id="totalHarga" class="font-headline-md text-headline-md text-primary">Rp 0</span>
                    </div>
                </div>
                <div class="flex flex-col gap-3">
                    <button type="submit" class="w-full bg-primary text-on-primary font-label-md text-label-md uppercase tracking-wider py-3 rounded-lg hover:bg-surface-tint transition-colors shadow-sm flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">check_circle</span>
                        Proses Transaksi
                    </button>
                    <a href="{{ route('transaksi.index') }}" class="w-full bg-transparent border border-outline-variant text-on-surface font-label-md text-label-md uppercase tracking-wider py-3 rounded-lg hover:bg-surface-container-low transition-colors flex items-center justify-center gap-2">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
function toggleDeliveryFields() {
    const radioChecked = document.querySelector('input[name="tipe_transaksi"]:checked');
    if (!radioChecked) return;
    
    const tipe = radioChecked.value;
    const fields = document.getElementById('deliveryFields');
    if (tipe === 'antar') {
        fields.classList.remove('hidden');
    } else {
        fields.classList.add('hidden');
    }
}

function updateCustomerDetails() {
    const select = document.getElementById('pelangganId');
    const selectedOption = select.options[select.selectedIndex];
    
    if (selectedOption && selectedOption.value !== "") {
        const alamat = selectedOption.dataset.alamat;
        const nohp = selectedOption.dataset.nohp;
        
        document.getElementById('alamatPengiriman').value = alamat || '';
        document.getElementById('noHpPengiriman').value = nohp || '';

        // Jika pelanggan memiliki alamat, set tipe transaksi otomatis ke Antar
        if (alamat && alamat.trim() !== "") {
            const currentTipe = document.querySelector('input[name="tipe_transaksi"]:checked');
            if (currentTipe && currentTipe.value === 'langsung') {
                const antarRadio = document.querySelector('input[name="tipe_transaksi"][value="antar"]');
                if (antarRadio) {
                    antarRadio.checked = true;
                    toggleDeliveryFields();
                }
            }
        }
    } else {
        // Kosongkan kolom jika Pelanggan Umum dipilih
        document.getElementById('alamatPengiriman').value = '';
        document.getElementById('noHpPengiriman').value = '';
    }
}

function handleCardClick(productId, event) {
    // Jika klik terjadi pada tombol minus/plus atau input, jangan lakukan apa-apa
    if (event.target.closest('button') || event.target.closest('input')) {
        return;
    }
    
    // Klik pada area kartu lainnya akan menambah kuantitas produk sebanyak 1
    changeProductQty(productId, 1, event);
}

function changeProductQty(productId, delta, event) {
    if (event) {
        event.stopPropagation();
    }
    const qtyInput = document.getElementById(`qty-input-${productId}`);
    let qty = (parseInt(qtyInput.value) || 0) + delta;
    if (qty < 0) qty = 0;
    qtyInput.value = qty;
    
    updateProductCardState(productId, qty);
    hitungTotal();
}

function manualQtyInput(productId, input, event) {
    if (event) {
        event.stopPropagation();
    }
    let qty = parseInt(input.value);
    if (isNaN(qty) || qty < 0) {
        qty = 0;
    }
    input.value = qty;
    updateProductCardState(productId, qty);
    hitungTotal();
}

function updateProductCardState(productId, qty) {
    const card = document.getElementById(`product-card-${productId}`);
    const hiddenId = document.getElementById(`hidden-id-${productId}`);
    const hiddenQty = document.getElementById(`hidden-qty-${productId}`);
    
    if (qty > 0) {
        // Tambahkan gaya aktif pada kartu
        card.classList.remove('border-outline-variant/40', 'bg-surface-container-lowest', 'hover:border-primary/50', 'hover:bg-surface-container-low/20');
        card.classList.add('border-primary', 'bg-primary/5', 'shadow-sm', 'shadow-primary/10', 'ring-1', 'ring-primary');
        
        // Aktifkan hidden inputs untuk dikirim dalam request POST
        hiddenId.disabled = false;
        hiddenQty.disabled = false;
        hiddenQty.value = qty;
    } else {
        // Hapus gaya aktif pada kartu
        card.classList.remove('border-primary', 'bg-primary/5', 'shadow-sm', 'shadow-primary/10', 'ring-1', 'ring-primary');
        card.classList.add('border-outline-variant/40', 'bg-surface-container-lowest', 'hover:border-primary/50', 'hover:bg-surface-container-low/20');
        
        // Nonaktifkan hidden inputs agar tidak terkirim saat qty = 0
        hiddenId.disabled = true;
        hiddenQty.disabled = true;
        hiddenQty.value = 0;
    }
}

function hitungTotal() {
    let total = 0;
    const selectedListEl = document.getElementById('selectedItemsList');
    const placeholderEl = document.getElementById('emptyItemsPlaceholder');
    
    // Hapus item lama dalam ringkasan pesanan
    if (selectedListEl) {
        selectedListEl.querySelectorAll('.dynamic-item').forEach(el => el.remove());
    }
    
    let hasItems = false;
    
    document.querySelectorAll('.product-card').forEach(card => {
        const id = card.dataset.id;
        const nama = card.dataset.nama;
        const harga = parseFloat(card.dataset.harga || 0);
        const satuan = card.dataset.satuan;
        
        const qtyInput = document.getElementById(`qty-input-${id}`);
        const qty = parseInt(qtyInput?.value || 0);
        
        if (qty > 0) {
            hasItems = true;
            const subtotal = harga * qty;
            total += subtotal;
            
            // Tambahkan ke ringkasan pesanan di kolom kanan (sebelum placeholder agar urutan benar)
            if (selectedListEl) {
                const itemDiv = document.createElement('div');
                itemDiv.className = 'dynamic-item flex justify-between items-start text-sm border-b border-outline-variant/10 pb-2 last:border-b-0 last:pb-0';
                itemDiv.innerHTML = `
                    <div class="flex-1 min-w-0 pr-2">
                        <p class="font-body-md text-on-surface font-semibold truncate">${nama}</p>
                        <p class="font-label-sm text-outline mt-0.5">${qty} ${satuan} @ Rp ${harga.toLocaleString('id-ID')}</p>
                    </div>
                    <span class="font-body-md text-on-surface font-semibold shrink-0">Rp ${subtotal.toLocaleString('id-ID')}</span>
                `;
                // Insert sebelum placeholder agar placeholder selalu di bawah, tidak menimpa item
                selectedListEl.insertBefore(itemDiv, placeholderEl);
            }
        }
    });
    
    // Tampilkan/sembunyikan placeholder berdasarkan ada tidaknya item
    if (placeholderEl) {
        placeholderEl.classList.toggle('hidden', hasItems);
    }
    
    const totalFormatted = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('subtotalLabel').textContent = totalFormatted;
    document.getElementById('totalHarga').textContent = totalFormatted;
}

document.addEventListener('DOMContentLoaded', function() {
    updateCustomerDetails();
    toggleDeliveryFields();
    
    // Inisialisasi status kartu produk berdasarkan nilai awal (misalnya input lama setelah validasi gagal)
    document.querySelectorAll('.product-card').forEach(card => {
        const id = card.dataset.id;
        const qtyInput = document.getElementById(`qty-input-${id}`);
        const qty = parseInt(qtyInput?.value || 0);
        updateProductCardState(id, qty);
    });
    
    hitungTotal();
});
</script>
@endsection