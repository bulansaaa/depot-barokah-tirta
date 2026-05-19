@extends('layouts.app')
@section('title', 'Record Transaction')

@section('content')
<div class="mb-8">
    <h2 class="font-headline-lg text-headline-lg text-on-surface">Record Transaction</h2>
    <p class="font-body-md text-body-md text-on-surface-variant mt-2">Enter details for a new water refill sale or delivery.</p>
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
                    Customer Information
                </h3>
                <div class="flex flex-col gap-2">
                    <label class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Select Customer</label>
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
                    <p class="font-label-sm text-label-sm text-outline mt-1">Leave blank for walk-in guest customers.</p>
                </div>
            </div>

            <!-- Order Details Card -->
            <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl p-gutter shadow-sm">
                <h3 class="font-headline-sm text-headline-sm text-on-surface mb-6 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">local_shipping</span>
                    Order Details
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Transaction Type -->
                    <div>
                        <label class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-3 block">Transaction Type</label>
                        <div class="flex flex-col gap-3">
                            <label class="flex items-center p-3 border border-outline-variant rounded-lg cursor-pointer hover:bg-surface-container-low transition-colors has-[:checked]:border-primary has-[:checked]:bg-primary-fixed/20">
                                <input class="w-4 h-4 text-primary border-outline-variant focus:ring-primary" name="tipe_transaksi" type="radio" value="langsung" onchange="toggleDeliveryFields()" {{ old('tipe_transaksi', request('tipe_transaksi', 'langsung')) == 'langsung' ? 'checked' : '' }}/>
                                <span class="ml-3 font-body-md text-body-md text-on-surface">Langsung (Walk-in)</span>
                            </label>
                            <label class="flex items-center p-3 border border-outline-variant rounded-lg cursor-pointer hover:bg-surface-container-low transition-colors has-[:checked]:border-primary has-[:checked]:bg-primary-fixed/20">
                                <input class="w-4 h-4 text-primary border-outline-variant focus:ring-primary" name="tipe_transaksi" type="radio" value="antar" onchange="toggleDeliveryFields()" {{ old('tipe_transaksi', request('tipe_transaksi')) == 'antar' ? 'checked' : '' }}/>
                                <span class="ml-3 font-body-md text-body-md text-on-surface">Antar (Delivery)</span>
                            </label>
                        </div>
                    </div>
                    <!-- Ordering Method -->
                    <div>
                        <label class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-3 block">Ordering Method</label>
                        <div class="flex flex-col gap-3">
                            <label class="flex items-center p-3 border border-outline-variant rounded-lg cursor-pointer hover:bg-surface-container-low transition-colors has-[:checked]:border-primary has-[:checked]:bg-primary-fixed/20">
                                <input class="w-4 h-4 text-primary border-outline-variant focus:ring-primary" name="metode_pemesanan" type="radio" value="whatsapp" {{ old('metode_pemesanan', 'whatsapp') == 'whatsapp' ? 'checked' : '' }}/>
                                <span class="ml-3 font-body-md text-body-md text-on-surface flex items-center gap-2">
                                    <svg aria-hidden="true" class="w-5 h-5 text-[#25D366]" fill="currentColor" viewbox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"></path></svg>
                                    WhatsApp
                                </span>
                            </label>
                            <label class="flex items-center p-3 border border-outline-variant rounded-lg cursor-pointer hover:bg-surface-container-low transition-colors has-[:checked]:border-primary has-[:checked]:bg-primary-fixed/20">
                                <input class="w-4 h-4 text-primary border-outline-variant focus:ring-primary" name="metode_pemesanan" type="radio" value="telepon" {{ old('metode_pemesanan') == 'telepon' ? 'checked' : '' }}/>
                                <span class="ml-3 font-body-md text-body-md text-on-surface">Telepon</span>
                            </label>
                            <label class="flex items-center p-3 border border-outline-variant rounded-lg cursor-pointer hover:bg-surface-container-low transition-colors has-[:checked]:border-primary has-[:checked]:bg-primary-fixed/20">
                                <input class="w-4 h-4 text-primary border-outline-variant focus:ring-primary" name="metode_pemesanan" type="radio" value="langsung" {{ old('metode_pemesanan') == 'langsung' ? 'checked' : '' }}/>
                                <span class="ml-3 font-body-md text-body-md text-on-surface">Datang Langsung</span>
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
                            <label class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider mb-2 block">Delivery Address</label>
                            <textarea name="alamat_pengiriman" id="alamatPengiriman" class="w-full p-3 bg-surface-bright border border-outline-variant rounded-lg font-body-md text-body-md text-on-surface focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" placeholder="Enter complete delivery address..." rows="1">{{ old('alamat_pengiriman') }}</textarea>
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
                        Products
                    </h3>
                    <button type="button" onclick="tambahBarisProduk()" class="font-label-md text-label-md text-primary flex items-center gap-1 hover:underline">
                        <span class="material-symbols-outlined text-[18px]">add</span> Add Item
                    </button>
                </div>
                <div id="produkContainer" class="p-0">
                    @php $oldProduk = old('produk', [['id' => '', 'qty' => 1]]); @endphp
                    @foreach($oldProduk as $index => $item)
                        <div class="baris-produk flex flex-col md:flex-row items-start md:items-center justify-between p-gutter border-b border-outline-variant/30 hover:bg-surface-bright transition-colors gap-4">
                            <div class="flex items-center gap-4 flex-1 w-full">
                                <div class="w-12 h-12 rounded-lg bg-surface-container-highest flex items-center justify-center text-primary border border-outline-variant/20 shrink-0">
                                    <span class="material-symbols-outlined">water_bottle</span>
                                </div>
                                <div class="flex-1">
                                    <select name="produk[{{ $index }}][id]" onchange="updateRowInfo(this)"
                                            class="w-full bg-transparent border-none font-body-md text-body-md font-semibold text-on-surface focus:ring-0 p-0 appearance-none">
                                        <option value="">-- Pilih Produk --</option>
                                        @foreach($produk as $p)
                                            <option value="{{ $p->id }}" data-harga="{{ $p->harga }}" data-satuan="{{ $p->satuan }}"
                                                {{ $item['id'] == $p->id ? 'selected' : '' }}>
                                                {{ $p->nama_produk }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="font-label-sm text-label-sm text-on-surface-variant price-label">
                                        @if($item['id'])
                                            @php $p = $produk->find($item['id']); @endphp
                                            {{ $p->satuan }} • Rp {{ number_format($p->harga, 0, ',', '.') }}
                                        @else
                                            Pilih produk untuk melihat harga
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-6 w-full md:w-auto justify-between">
                                <div class="flex items-center border border-outline-variant rounded-lg bg-surface-container-lowest">
                                    <button type="button" onclick="changeQty(this, -1)" class="w-8 h-8 flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors rounded-l-lg hover:bg-surface-container-low">
                                        <span class="material-symbols-outlined text-[18px]">remove</span>
                                    </button>
                                    <input name="produk[{{ $index }}][qty]" value="{{ $item['qty'] }}" min="1" oninput="hitungTotal()"
                                           class="w-16 h-8 text-center bg-transparent border-x border-outline-variant/50 font-body-md text-body-md text-on-surface focus:outline-none" type="number"/>
                                    <button type="button" onclick="changeQty(this, 1)" class="w-8 h-8 flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors rounded-r-lg hover:bg-surface-container-low">
                                        <span class="material-symbols-outlined text-[18px]">add</span>
                                    </button>
                                </div>
                                <div class="w-24 text-right shrink-0">
                                    <p class="font-body-md text-body-md font-semibold text-on-surface subtotal">Rp 0</p>
                                </div>
                                <button type="button" onclick="hapusBaris(this)" class="text-error hover:bg-error-container p-1 rounded-md transition-colors" title="Remove item">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Right Column: Summary & Actions -->
        <div class="lg:col-span-4 flex flex-col gap-gutter lg:sticky lg:top-[104px]">
            <div class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl p-gutter shadow-sm relative overflow-hidden">
                <!-- Decorative top accent -->
                <div class="absolute top-0 left-0 w-full h-1 bg-primary"></div>
                <h3 class="font-headline-sm text-headline-sm text-on-surface mb-6">Order Summary</h3>
                <div class="flex flex-col gap-3 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="font-body-md text-body-md text-on-surface-variant">Subtotal</span>
                        <span id="subtotalLabel" class="font-body-md text-body-md text-on-surface font-medium">Rp 0</span>
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
let barisIndex = {{ count($oldProduk) }};

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

        // If customer has an address, auto-set to delivery if currently walk-in
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
        // Clear fields if Pelanggan Umum is selected
        document.getElementById('alamatPengiriman').value = '';
        document.getElementById('noHpPengiriman').value = '';
    }
}

function changeQty(btn, delta) {
    const input = btn.parentElement.querySelector('input');
    let val = parseInt(input.value) + delta;
    if (isNaN(val) || val < 1) val = 1;
    input.value = val;
    hitungTotal();
}

function updateRowInfo(select) {
    const row = select.closest('.baris-produk');
    const priceLabel = row.querySelector('.price-label');
    const selectedOption = select.options[select.selectedIndex];
    
    if (selectedOption && selectedOption.value !== "") {
        const harga = parseFloat(selectedOption.dataset.harga);
        const satuan = selectedOption.dataset.satuan;
        priceLabel.textContent = `\${satuan} • Rp \${harga.toLocaleString('id-ID')}`;
        
        // Auto-focus quantity input
        const qtyInput = row.querySelector('input[name*="[qty]"]');
        if (qtyInput) qtyInput.focus();
    } else {
        priceLabel.textContent = 'Pilih produk untuk melihat harga';
    }
    hitungTotal();
}

function tambahBarisProduk() {
    const container = document.getElementById('produkContainer');
    const firstSelect = document.querySelector('select[name^="produk[0][id]"]') || document.querySelector('select[name$="[id]"]');
    const optionsProduk = Array.from(firstSelect.options)
        .map(o => `<option value="\${o.value}" data-harga="\${o.dataset.harga || 0}" data-satuan="\${o.dataset.satuan || ''}">\${o.text}</option>`)
        .join('');

    const div = document.createElement('div');
    div.className = 'baris-produk flex flex-col md:flex-row items-start md:items-center justify-between p-gutter border-b border-outline-variant/30 hover:bg-surface-bright transition-colors gap-4';
    div.innerHTML = `
        <div class="flex items-center gap-4 flex-1 w-full">
            <div class="w-12 h-12 rounded-lg bg-surface-container-highest flex items-center justify-center text-primary border border-outline-variant/20 shrink-0">
                <span class="material-symbols-outlined">water_bottle</span>
            </div>
            <div class="flex-1">
                <select name="produk[\${barisIndex}][id]" onchange="updateRowInfo(this)"
                        class="w-full bg-transparent border-none font-body-md text-body-md font-semibold text-on-surface focus:ring-0 p-0 appearance-none">
                    \${optionsProduk}
                </select>
                <p class="font-label-sm text-label-sm text-on-surface-variant price-label">Pilih produk untuk melihat harga</p>
            </div>
        </div>
        <div class="flex items-center gap-6 w-full md:w-auto justify-between">
            <div class="flex items-center border border-outline-variant rounded-lg bg-surface-container-lowest">
                <button type="button" onclick="changeQty(this, -1)" class="w-8 h-8 flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors rounded-l-lg hover:bg-surface-container-low">
                    <span class="material-symbols-outlined text-[18px]">remove</span>
                </button>
                <input name="produk[\${barisIndex}][qty]" value="1" min="1" oninput="hitungTotal()"
                       class="w-16 h-8 text-center bg-transparent border-x border-outline-variant/50 font-body-md text-body-md text-on-surface focus:outline-none" type="number"/>
                <button type="button" onclick="changeQty(this, 1)" class="w-8 h-8 flex items-center justify-center text-on-surface-variant hover:text-primary transition-colors rounded-r-lg hover:bg-surface-container-low">
                    <span class="material-symbols-outlined text-[18px]">add</span>
                </button>
            </div>
            <div class="w-24 text-right shrink-0">
                <p class="font-body-md text-body-md font-semibold text-on-surface subtotal">Rp 0</p>
            </div>
            <button type="button" onclick="hapusBaris(this)" class="text-error hover:bg-error-container p-1 rounded-md transition-colors" title="Remove item">
                <span class="material-symbols-outlined text-[20px]">delete</span>
            </button>
        </div>
    `;
    container.appendChild(div);
    barisIndex++;
    hitungTotal();
}

function hapusBaris(btn) {
    const baris = btn.closest('.baris-produk');
    const semua = document.querySelectorAll('.baris-produk');
    if (semua.length > 1) {
        baris.remove();
        hitungTotal();
    }
}

function hitungTotal() {
    let total = 0;
    document.querySelectorAll('.baris-produk').forEach(baris => {
        const select = baris.querySelector('select');
        const qtyInput = baris.querySelector('input[name*="[qty]"]');
        const subtotalEl = baris.querySelector('.subtotal');
        const selectedOption = select.options[select.selectedIndex];
        const harga = parseFloat(selectedOption?.dataset?.harga || 0);
        let qty = parseInt(qtyInput?.value || 0);
        if (qty < 0) qty = 0;
        const subtotal = harga * qty;
        total += subtotal;
        if (subtotalEl) {
            subtotalEl.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        }
    });
    document.getElementById('subtotalLabel').textContent = 'Rp ' + total.toLocaleString('id-ID');
    document.getElementById('totalHarga').textContent = 'Rp ' + total.toLocaleString('id-ID');
}

document.addEventListener('DOMContentLoaded', function() {
    updateCustomerDetails();
    toggleDeliveryFields();
    hitungTotal();
});
</script>
@endsection
