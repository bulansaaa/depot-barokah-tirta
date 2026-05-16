@extends('layouts.app')
@section('title', 'Buat Transaksi')

@section('content')
<div class="mb-6">
    <a href="{{ route('transaksi.index') }}" class="text-xs text-blue-500 hover:underline mb-1 block">← Kembali</a>
    <h2 class="text-xl font-bold text-gray-800">Buat Transaksi Baru</h2>
</div>

@if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('transaksi.store') }}" id="formTransaksi">
@csrf

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Form Utama --}}
    <div class="lg:col-span-2 space-y-4">

        {{-- Info Transaksi --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="font-semibold text-gray-700 mb-4">📋 Informasi Transaksi</h3>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pelanggan</label>
                    <select name="pelanggan_id" id="pelangganId" onchange="updateCustomerDetails()"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
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

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipe Transaksi <span class="text-red-500">*</span></label>
                    <select name="tipe_transaksi" id="tipeTransaksi" onchange="toggleDeliveryFields()"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="langsung" {{ old('tipe_transaksi') == 'langsung' ? 'selected' : '' }}>Langsung</option>
                        <option value="antar" {{ old('tipe_transaksi') == 'antar' ? 'selected' : '' }}>Antar</option>
                        <option value="langganan" {{ old('tipe_transaksi') == 'langganan' ? 'selected' : '' }}>Langganan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Metode Pemesanan <span class="text-red-500">*</span></label>
                    <select name="metode_pemesanan"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <option value="langsung" {{ old('metode_pemesanan') == 'langsung' ? 'selected' : '' }}>Langsung</option>
                        <option value="whatsapp" {{ old('metode_pemesanan') == 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                        <option value="telepon" {{ old('metode_pemesanan') == 'telepon' ? 'selected' : '' }}>Telepon</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan</label>
                    <input type="text" name="catatan" value="{{ old('catatan') }}"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                           placeholder="Catatan tambahan (opsional)">
                </div>

                {{-- Delivery Fields --}}
                <div id="deliveryFields" class="{{ in_array(old('tipe_transaksi'), ['antar', 'langganan']) ? '' : 'hidden' }} col-span-2 grid grid-cols-2 gap-4 border-t pt-4 mt-2">
                    <div class="col-span-2">
                        <h4 class="text-sm font-bold text-blue-600 mb-2">📍 Informasi Pengiriman</h4>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No HP Penerima <span class="text-red-500">*</span></label>
                        <input type="text" name="no_hp_pengiriman" id="noHpPengiriman" value="{{ old('no_hp_pengiriman') }}"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                               placeholder="0812...">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name="alamat_pengiriman" id="alamatPengiriman" rows="2"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                                  placeholder="Nama jalan, nomor rumah, RT/RW...">{{ old('alamat_pengiriman') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pilih Produk --}}
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold text-gray-700">🫙 Produk</h3>
                <button type="button" onclick="tambahBarisProduk()"
                        class="bg-blue-50 text-blue-600 border border-blue-200 px-3 py-1 rounded-lg text-sm hover:bg-blue-100">
                    + Tambah Produk
                </button>
            </div>

            <div id="produkContainer" class="space-y-3">
                {{-- Baris produk default --}}
                @php $oldProduk = old('produk', [['id' => '', 'qty' => 1]]); @endphp
                @foreach($oldProduk as $index => $item)
                <div class="baris-produk grid grid-cols-12 gap-2 items-end">
                    <div class="col-span-6">
                        <label class="block text-xs text-gray-500 mb-1">Produk</label>
                        <select name="produk[{{ $index }}][id]" onchange="updateHarga(this)"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="">-- Pilih Produk --</option>
                            @foreach($produk as $p)
                                <option value="{{ $p->id }}" data-harga="{{ $p->harga }}"
                                    {{ $item['id'] == $p->id ? 'selected' : '' }}>
                                    {{ $p->nama_produk }} - Rp {{ number_format($p->harga, 0, ',', '.') }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-3">
                        <label class="block text-xs text-gray-500 mb-1">Qty</label>
                        <input type="number" name="produk[{{ $index }}][qty]" value="{{ $item['qty'] }}" min="1"
                               onchange="hitungTotal()"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs text-gray-500 mb-1">Subtotal</label>
                        <p class="subtotal text-sm font-medium text-gray-700 py-2">Rp 0</p>
                    </div>
                    <div class="col-span-1">
                        <button type="button" onclick="hapusBaris(this)"
                                class="w-full bg-red-50 text-red-500 border border-red-200 rounded-lg py-2 text-xs hover:bg-red-100">
                            ✕
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            @error('produk')
                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
            @enderror
        </div>

    </div>

    {{-- Ringkasan --}}
    <div class="space-y-4">
        <div class="bg-white rounded-xl shadow p-6 sticky top-24">
            <h3 class="font-semibold text-gray-700 mb-4">💰 Ringkasan</h3>

            <div class="border-t pt-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600">Total Pembayaran</span>
                    <span id="totalHarga" class="text-2xl font-bold text-blue-600">Rp 0</span>
                </div>
            </div>

            <button type="submit"
                    class="w-full mt-6 bg-blue-600 text-white py-3 rounded-lg font-medium hover:bg-blue-700 transition">
                Simpan Transaksi
            </button>
            <a href="{{ route('transaksi.index') }}"
               class="block w-full mt-2 text-center bg-gray-100 text-gray-600 py-3 rounded-lg text-sm hover:bg-gray-200 transition">
                Batal
            </a>
        </div>
    </div>

</div>
</form>

<script>
// Data produk dari server
const produkData = @json($produk->keyBy('id'));
let barisIndex = {{ count($oldProduk) }};

function toggleDeliveryFields() {
    const tipe = document.getElementById('tipeTransaksi').value;
    const fields = document.getElementById('deliveryFields');
    if (tipe === 'antar' || tipe === 'langganan') {
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
    }
}

function tambahBarisProduk() {
    const container = document.getElementById('produkContainer');
    const firstSelect = document.querySelector('select[name^="produk[0][id]"]') || document.querySelector('select[name$="[id]"]');
    const optionsProduk = Array.from(firstSelect.options)
        .map(o => `<option value="${o.value}" data-harga="${o.dataset.harga || 0}">${o.text}</option>`)
        .join('');

    const div = document.createElement('div');
    div.className = 'baris-produk grid grid-cols-12 gap-2 items-end';
    div.innerHTML = `
        <div class="col-span-6">
            <label class="block text-xs text-gray-500 mb-1">Produk</label>
            <select name="produk[${barisIndex}][id]" onchange="updateHarga(this)"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none">
                ${optionsProduk}
            </select>
        </div>
        <div class="col-span-3">
            <label class="block text-xs text-gray-500 mb-1">Qty</label>
            <input type="number" name="produk[${barisIndex}][qty]" value="1" min="1"
                   onchange="hitungTotal()"
                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none">
        </div>
        <div class="col-span-2">
            <label class="block text-xs text-gray-500 mb-1">Subtotal</label>
            <p class="subtotal text-sm font-medium text-gray-700 py-2">Rp 0</p>
        </div>
        <div class="col-span-1">
            <button type="button" onclick="hapusBaris(this)"
                    class="w-full bg-red-50 text-red-500 border border-red-200 rounded-lg py-2 text-xs hover:bg-red-100">
                ✕
            </button>
        </div>
    `;
    container.appendChild(div);
    barisIndex++;
}

function hapusBaris(btn) {
    const baris = btn.closest('.baris-produk');
    const semua = document.querySelectorAll('.baris-produk');
    if (semua.length > 1) {
        baris.remove();
        hitungTotal();
    }
}

function updateHarga(select) {
    hitungTotal();
}

function hitungTotal() {
    let total = 0;
    document.querySelectorAll('.baris-produk').forEach(baris => {
        const select = baris.querySelector('select');
        const qtyInput = baris.querySelector('input[type="number"]');
        const subtotalEl = baris.querySelector('.subtotal');
        const selectedOption = select.options[select.selectedIndex];
        const harga = parseFloat(selectedOption?.dataset?.harga || 0);
        const qty = parseInt(qtyInput?.value || 1);
        const subtotal = harga * qty;
        total += subtotal;
        if (subtotalEl) {
            subtotalEl.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
        }
    });
    document.getElementById('totalHarga').textContent =
        'Rp ' + total.toLocaleString('id-ID');
}

// Initial calculation and toggle
document.addEventListener('DOMContentLoaded', function() {
    hitungTotal();
    toggleDeliveryFields();
});
</script>
@endsection