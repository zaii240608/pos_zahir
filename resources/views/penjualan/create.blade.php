@extends('layouts.app')

@section('title', 'Transaksi Baru - Toko Kelontong Zahir')

@section('content')
    @include('layouts.navbar')

    <div class="min-h-screen bg-stone-100/70 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Header Halaman -->
            <div class="mb-6">
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 text-[10px] font-black uppercase bg-teal-100 text-teal-900 rounded-full border border-teal-200">
                        Kasir Utama
                    </span>
                    <h1 class="text-2xl font-extrabold text-teal-950">Transaksi Penjualan Baru</h1>
                </div>
                <p class="text-xs text-stone-500 mt-1">Pilih produk di katalog untuk ditambahkan ke keranjang belanja.</p>
            </div>

            <!-- Layout Grid 2 Bagian -->
            <div class="grid grid-cols-1 xl:grid-cols-3 gap-8 items-start">
                
                <!-- KIRI: Katalog Produk -->
                <div class="xl:col-span-2 bg-white rounded-3xl p-6 border border-amber-200/60 shadow-sm transition-all duration-300 hover:shadow-md">
                    <!-- Pencarian & Sub-header -->
                    <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-amber-100">
                        <h2 class="text-base font-extrabold text-teal-950 flex items-center gap-2">
                            <svg class="w-5 h-5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                            </svg>
                            Katalog Produk
                        </h2>
                        
                        <div class="relative w-full sm:w-64">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-stone-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </span>
                            <input type="text" id="search-input" placeholder="Cari nama produk..." 
                                   class="w-full border border-stone-200 rounded-2xl pl-10 pr-4 py-2.5 text-xs bg-stone-50/50 text-stone-800 placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-600 focus:bg-white transition shadow-inner">
                        </div>

                        <select id="jenis-filter" aria-label="Filter jenis produk"
                                class="w-full sm:w-48 border border-stone-200 rounded-2xl px-3 py-2.5 text-xs bg-stone-50/50 text-stone-800 focus:outline-none focus:ring-2 focus:ring-teal-500/20 focus:border-teal-600 focus:bg-white transition shadow-inner">
                            <option value="">Semua jenis</option>
                            @foreach($produks->pluck('jenis')->filter()->unique('id')->sortBy('nama_jenis') as $jenis)
                                <option value="{{ $jenis->id }}">{{ $jenis->nama_jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Grid Produk -->
                    <div id="product-grid" class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
                        @forelse($produks as $produk)
                            <div class="product-card group bg-stone-50/40 border border-amber-200/60 rounded-3xl p-5 flex items-center gap-4 hover:border-teal-300 hover:bg-teal-50/30 transition-all duration-300 shadow-sm hover:shadow-md"
                                 data-id="{{ $produk->id }}" 
                                 data-nama="{{ $produk->nama }}" 
                                 data-jenis="{{ $produk->jenis_id }}"
                                 data-harga="{{ $produk->harga_jual }}" 
                                 data-stok="{{ $produk->stok }}">
                                
                                <div class="shrink-0 w-16 h-16 bg-amber-100/60 rounded-2xl flex items-center justify-center border border-amber-200/80 text-teal-800 group-hover:scale-105 transition-transform duration-300 shadow-inner">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                
                                <div class="grow min-w-0 space-y-1">
                                    <h4 class="product-name font-extrabold text-stone-900 text-xs truncate group-hover:text-teal-950 transition-colors">
                                        {{ $produk->nama }}
                                    </h4>
                                    <p class="text-base font-black text-teal-900">
                                        Rp {{ number_format($produk->harga_jual, 0, ',', '.') }}
                                    </p>
                                    <span class="inline-block text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-stone-200/60 text-stone-700 border border-stone-300/50">
                                        Stok: <span id="stok-katalog-{{ $produk->id }}" class="font-black text-stone-900">{{ $produk->stok }}</span>
                                    </span>
                                </div>
                                
                                <!-- Input Qty + Tombol Tambah -->
                                <div class="shrink-0 flex items-center gap-1.5 payment-method-container p-1.5 rounded-full bg-white border border-stone-200 shadow-inner">
                                    <input type="number" 
                                           id="input-qty-katalog-{{ $produk->id }}" 
                                           value="1" min="1" max="{{ $produk->stok }}"
                                           class="w-12 text-center text-xs font-bold py-2 rounded-full focus:outline-none focus:ring-2 focus:ring-teal-500/20 transition-all
                                                  {{ $produk->stok > 0 ? 'bg-stone-100 text-stone-800 border border-stone-200' : 'bg-stone-50 text-stone-400 border border-stone-100 cursor-not-allowed' }}"
                                           {{ $produk->stok > 0 ? '' : 'disabled' }}>
                                    
                                    <button type="button" 
                                            onclick="tambahKeKeranjang({{ $produk->id }})"
                                            class="w-9 h-9 text-white rounded-full flex items-center justify-center shadow transition-all duration-200 active:scale-90
                                                   {{ $produk->stok > 0 ? 'bg-teal-600 hover:bg-teal-700' : 'bg-stone-300 cursor-not-allowed' }}"
                                            {{ $produk->stok > 0 ? '' : 'disabled' }}>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-2 text-center py-16 bg-amber-50/20 rounded-3xl border border-dashed border-amber-200/80">
                                <svg class="w-12 h-12 mx-auto text-amber-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                <p class="text-sm text-stone-500 font-semibold">Belum ada produk yang tersedia dalam katalog.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- KANAN: Keranjang Belanja (Sticky) -->
                <div class="bg-white rounded-3xl p-6 border border-amber-200/60 shadow-lg flex flex-col xl:sticky xl:top-6 max-h-none xl:max-h-[calc(100vh-48px)] xl:overflow-y-auto transition-all duration-300 hover:shadow-xl">
                    
                    <!-- Header Keranjang -->
                    <div class="flex items-center justify-between pb-4 border-b border-amber-100 mb-4 gap-2">
                        <div class="flex items-center gap-2.5">
                            <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <h2 class="text-lg font-extrabold text-teal-950 tracking-tight">Keranjang</h2>
                        </div>
                        <span id="total-items-badge" class="bg-rose-100 text-rose-800 text-[11px] font-black px-3 py-1 rounded-full border border-rose-200 shadow-inner">
                            0 Item
                        </span>
                    </div>

                    <!-- List Item Keranjang -->
                    <div id="keranjang-list" class="grow overflow-y-auto pr-2 space-y-3 mb-5 custom-scrollbar min-h-[150px]">
                        <!-- Template Kosong -->
                        <div id="keranjang-kosong" class="text-center py-12 text-stone-400 bg-stone-50/50 rounded-2xl border border-dashed border-stone-200">
                            <svg class="w-10 h-10 mx-auto mb-3 text-amber-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"></path>
                            </svg>
                            <p class="text-xs font-semibold">Keranjang masih kosong.</p>
                        </div>
                    </div>

                    <!-- Ringkasan & Form Pembayaran -->
                    <div class="mt-auto border-t border-amber-100 pt-5 space-y-4 bg-white">
                        
                        <!-- Total -->
                        <div class="flex items-center justify-between bg-teal-950 text-white p-4 rounded-2xl shadow-inner border border-teal-900">
                            <span class="text-xs font-bold text-amber-100 uppercase tracking-wider">Total</span>
                            <span id="total-pembayaran-text" class="text-2xl font-black text-white">
                                Rp 0
                            </span>
                        </div>

                        <!-- Form Simpan / Checkout -->
                        <form action="{{ route('penjualan.store') }}" method="POST" id="checkout-form" class="space-y-3">
                            @csrf
                            <input type="hidden" name="items" id="items-json">
                            <!-- Input Hidden untuk menangkap status yang dipilih -->
                            <input type="hidden" name="status" id="status-penjualan" value="completed">

                            <!-- METODE PEMBAYARAN -->
                            <div class="bg-stone-50 border border-stone-200/80 rounded-2xl p-3 focus-within:border-teal-500 focus-within:ring-2 focus-within:ring-teal-500/10 transition-all">
                                <label class="block text-[10px] font-black text-stone-500 uppercase tracking-wider mb-1">
                                    Metode Pembayaran
                                </label>
                                <select name="metode_pembayaran" id="metode-pembayaran" required
                                        class="w-full bg-transparent text-xs text-stone-800 font-bold focus:outline-none cursor-pointer border-none p-0 pr-2">
                                    <option value="Cash">Tunai (Cash)</option>
                                    <option value="QRIS">QRIS</option>
                                    <option value="Transfer">Transfer Bank</option>
                                </select>
                            </div>

                            <!-- Nominal Tunai & Uang Kembalian -->
                            <div id="cash-payment-section" class="space-y-3 rounded-2xl border border-amber-200/70 bg-amber-50/50 p-3">
                                <div>
                                    <label for="uang-dibayar" class="block text-[10px] font-black uppercase tracking-wider text-stone-500 mb-1">
                                        Uang Dibayar
                                    </label>
                                    <div class="relative">
                                        <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-xs font-bold text-stone-400">Rp</span>
                                        <input type="number" name="uang_dibayar" id="uang-dibayar" min="0" step="100" inputmode="numeric" placeholder="0"
                                               class="w-full rounded-xl border border-stone-200 bg-white py-2.5 pl-9 pr-3 text-sm font-black text-stone-800 outline-none transition focus:border-amber-500 focus:ring-2 focus:ring-amber-500/20">
                                    </div>
                                    <p id="cash-payment-error" class="mt-1 hidden text-[10px] font-bold text-rose-600">Uang dibayar masih kurang dari total transaksi.</p>
                                </div>
                                <div class="flex items-center justify-between border-t border-amber-200/70 pt-3">
                                    <span class="text-[10px] font-black uppercase tracking-wider text-stone-500">Uang Kembalian</span>
                                    <span id="uang-kembalian-text" class="text-lg font-black text-teal-700">Rp 0</span>
                                </div>
                            </div>

                            <!-- DUA TOMBOL AKSI: Simpan (Open) vs Proses Selesai -->
                            <div class="grid grid-cols-2 gap-3">
                                <!-- Tombol Simpan Ke Keranjang / Draft (Status: Open) -->
                                <button type="button" 
                                        onclick="submitForm('open')" 
                                        id="btn-simpan-open" 
                                        disabled
                                        class="w-full bg-amber-500 hover:bg-amber-600 text-white font-black py-3.5 px-3 rounded-2xl transition-all duration-200 text-xs flex items-center justify-center gap-1.5 shadow active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                    </svg>
                                    Simpan (Open)
                                </button>

                                <!-- Tombol Proses Selesai (Status: Completed) -->
                                <button type="button" 
                                        onclick="submitForm('completed')" 
                                        id="btn-bayar" 
                                        disabled
                                        class="w-full bg-teal-600 hover:bg-teal-700 text-white font-black py-3.5 px-3 rounded-2xl transition-all duration-200 text-xs flex items-center justify-center gap-1.5 shadow active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Proses Selesai
                                </button>
                            </div>

                            <!-- TOMBOL KEMBALI DI BWAH TOMBOL SIMPAN & PROSES SELESAI -->
                                     <a href="{{ route('penjualan.index') }}" 
                                         onclick="if (document.referrer && new URL(document.referrer).origin === window.location.origin) { event.preventDefault(); window.history.back(); }"
                               class="w-full bg-stone-100 hover:bg-stone-200 text-stone-700 font-bold py-3 px-4 rounded-2xl border border-stone-200/80 transition-all duration-200 text-xs flex items-center justify-center gap-2 active:scale-95">
                                Kembali 
                            </a>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #fbd38d;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #319795;
        }
        
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none; 
            margin: 0; 
        }
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

    <script>
        let keranjang = [];

        document.addEventListener('DOMContentLoaded', function () {
            initLiveSearch();
            initInputValidation();
            initCashPayment();
            updateDOM();
        });

        function initCashPayment() {
            const selectMetode = document.getElementById('metode-pembayaran');
            const cashInput = document.getElementById('uang-dibayar');

            selectMetode.addEventListener('change', toggleCashPayment);
            cashInput.addEventListener('input', updateCashChange);
            toggleCashPayment();
        }

        function toggleCashPayment() {
            const selectMetode = document.getElementById('metode-pembayaran');
            const cashSection = document.getElementById('cash-payment-section');
            const cashInput = document.getElementById('uang-dibayar');
            const isCash = selectMetode.value === 'Cash';

            cashSection.classList.toggle('hidden', !isCash);
            cashInput.required = isCash;

            if (!isCash) {
                cashInput.setCustomValidity('');
                document.getElementById('cash-payment-error').classList.add('hidden');
            }

            updateCashChange();
        }

        function updateCashChange() {
            const cashInput = document.getElementById('uang-dibayar');
            const changeText = document.getElementById('uang-kembalian-text');
            const totalText = document.getElementById('total-pembayaran-text').textContent.replace(/[^0-9]/g, '');
            const total = parseInt(totalText, 10) || 0;
            const paid = parseInt(cashInput.value, 10) || 0;
            const change = Math.max(paid - total, 0);
            const cashError = document.getElementById('cash-payment-error');

            changeText.textContent = `Rp ${formatRupiah(change)}`;
            changeText.classList.toggle('text-rose-600', paid < total && paid > 0);
            changeText.classList.toggle('text-teal-700', paid >= total || paid === 0);
            if (paid >= total) {
                cashInput.setCustomValidity('');
                cashError.classList.add('hidden');
            }
        }

        function initLiveSearch() {
            const searchInput = document.getElementById('search-input');
            const jenisFilter = document.getElementById('jenis-filter');
            const productCards = document.querySelectorAll('.product-card');

            function filterProducts() {
                const searchTerm = (searchInput?.value || '').toLowerCase().trim();
                const selectedJenis = jenisFilter?.value || '';

                productCards.forEach(card => {
                    const productName = (card.getAttribute('data-nama') || '').toLowerCase();
                    const productJenis = card.getAttribute('data-jenis') || '';
                    const matchesSearch = productName.includes(searchTerm);
                    const matchesJenis = !selectedJenis || productJenis === selectedJenis;
                    card.style.display = matchesSearch && matchesJenis ? 'flex' : 'none';
                });
            }

            searchInput?.addEventListener('input', filterProducts);
            jenisFilter?.addEventListener('change', filterProducts);
        }

        function initInputValidation() {
            const productCards = document.querySelectorAll('.product-card');
            productCards.forEach(card => {
                const pId = card.getAttribute('data-id');
                const stokInput = document.getElementById(`input-qty-katalog-${pId}`);
                
                if (stokInput) {
                    stokInput.addEventListener('input', function() {
                        const stokTersedia = parseInt(card.getAttribute('data-stok'));
                        let val = parseInt(this.value);

                        if (isNaN(val) || val < 1) {
                            this.value = 1;
                            return;
                        }

                        if (val > stokTersedia) {
                            showToast(`Maaf, stok yang tersedia hanya ${stokTersedia} Pcs.`, 'warning');
                            this.value = stokTersedia;
                        }
                    });
                }
            });
        }

        function tambahKeKeranjang(produkId) {
            const cardProduk = document.querySelector(`.product-card[data-id="${produkId}"]`);
            if (!cardProduk) return;

            const inputQtyKatalog = document.getElementById(`input-qty-katalog-${produkId}`);
            const qtyAkanDitambahkan = parseInt(inputQtyKatalog.value);
            const stokFisik = parseInt(cardProduk.getAttribute('data-stok'));
            const namaProduk = cardProduk.getAttribute('data-nama');
            const hargaProduk = parseInt(cardProduk.getAttribute('data-harga'));

            if (isNaN(qtyAkanDitambahkan) || qtyAkanDitambahkan < 1) {
                inputQtyKatalog.value = 1;
                return;
            }

            const indexExisting = keranjang.findIndex(item => item.id === produkId);
            const qtyDiKeranjangSaatIni = indexExisting !== -1 ? keranjang[indexExisting].qty : 0;
            const totalPermintaan = qtyDiKeranjangSaatIni + qtyAkanDitambahkan;

            if (totalPermintaan > stokFisik) {
                const sisaBisaDiminta = stokFisik - qtyDiKeranjangSaatIni;
                let pesanError = qtyDiKeranjangSaatIni > 0 
                    ? `Di keranjang sudah ada ${qtyDiKeranjangSaatIni} Pcs. Anda hanya bisa menambah ${sisaBisaDiminta} Pcs lagi.` 
                    : `Permintaan melebihi stok yang tersedia (${stokFisik} Pcs).`;

                showToast(pesanError, 'error');

                inputQtyKatalog.value = sisaBisaDiminta > 0 ? sisaBisaDiminta : 1;
                return;
            }

            if (indexExisting !== -1) {
                keranjang[indexExisting].qty = totalPermintaan;
                keranjang[indexExisting].subtotal = keranjang[indexExisting].qty * keranjang[indexExisting].harga;
            } else {
                keranjang.push({
                    id: produkId,
                    nama: namaProduk,
                    harga: hargaProduk,
                    qty: qtyAkanDitambahkan,
                    subtotal: hargaProduk * qtyAkanDitambahkan,
                    stok_max: stokFisik
                });
            }

            inputQtyKatalog.value = 1;
            updateDOM();

            showToast(`${namaProduk} ditambahkan`, 'success');
        }

        function updateQtyKeranjang(produkId, inputElement) {
            let newQty = parseInt(inputElement.value);
            const index = keranjang.findIndex(item => item.id === produkId);
            
            if (index === -1) return;
            
            const item = keranjang[index];
            const stokMax = item.stok_max;

            if (isNaN(newQty) || newQty < 1) {
                inputElement.value = 1;
                newQty = 1;
            }

            if (newQty > stokMax) {
                showToast(`Stok maksimal produk ini adalah ${stokMax} Pcs.`, 'warning');
                newQty = stokMax;
                inputElement.value = stokMax;
            }

            keranjang[index].qty = newQty;
            keranjang[index].subtotal = newQty * item.harga;
            updateGrandTotal();
        }

        function hapusItem(produkId) {
            const targetId = Number(produkId);

            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Hapus Item?',
                    text: "Produk akan dikeluarkan dari keranjang.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e53e3e',
                    cancelButtonColor: '#718096',
                    confirmButtonText: 'Ya, Hapus',
                    cancelButtonText: 'Batal',
                    customClass: { 
                        popup: 'rounded-3xl', 
                        confirmButton: 'rounded-full text-xs px-5 py-2.5', 
                        cancelButton: 'rounded-full text-xs px-5 py-2.5' 
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        prosesPenghapusan(targetId);
                    }
                });
            } else {
                if (confirm('Hapus produk ini dari keranjang?')) {
                    prosesPenghapusan(targetId);
                }
            }
        }

        function prosesPenghapusan(targetId) {
            keranjang = keranjang.filter(item => Number(item.id) !== targetId);
            updateDOM();

            showToast('Item berhasil dihapus', 'success');
        }

        function updateDOM() {
            const listContainer = document.getElementById('keranjang-list');
            const kosongContainer = document.getElementById('keranjang-kosong');
            const itemsBadge = document.getElementById('total-items-badge');
            const btnBayar = document.getElementById('btn-bayar');
            const btnSimpanOpen = document.getElementById('btn-simpan-open');
            
            const itemsNodeList = listContainer.querySelectorAll('.cart-item');
            itemsNodeList.forEach(node => node.remove());

            if (keranjang.length === 0) {
                kosongContainer.style.display = 'block';
                itemsBadge.textContent = '0 Item';
                if (btnBayar) btnBayar.disabled = true;
                if (btnSimpanOpen) btnSimpanOpen.disabled = true;
            } else {
                kosongContainer.style.display = 'none';
                
                keranjang.forEach(item => {
                    const itemHtml = `
                        <div class="cart-item flex items-center justify-between gap-2 bg-amber-50/40 p-3 rounded-2xl border border-amber-200/50 hover:border-amber-300 transition duration-300">
                            <div class="min-w-0 grow space-y-0.5">
                                <p class="font-bold text-stone-800 text-xs truncate">${item.nama}</p>
                                <p class="font-extrabold text-teal-950 text-xs">
                                    Rp ${formatRupiah(item.harga)}
                                </p>
                            </div>
                            
                            <div class="shrink-0 flex items-center gap-1 payment-method-container p-1 rounded-full bg-stone-100 border border-stone-200">
                                <input type="number" 
                                       value="${item.qty}" 
                                       min="1" 
                                       max="${item.stok_max}"
                                       oninput="updateQtyKeranjang(${item.id}, this)"
                                       class="w-10 text-center text-xs font-black py-1 bg-transparent text-teal-950 focus:outline-none transition">
                                <span class="text-[10px] font-bold text-stone-500 pr-2">Pcs</span>
                            </div>

                            <button type="button" 
                                    onclick="hapusItem(${item.id})" 
                                    title="Hapus dari keranjang"
                                    class="shrink-0 w-8 h-8 flex items-center justify-center rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white border border-rose-200/60 transition-all duration-200 active:scale-90 cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    `;
                    listContainer.insertAdjacentHTML('beforeend', itemHtml);
                });

                itemsBadge.textContent = `${keranjang.length} Item`;
                if (btnBayar) btnBayar.disabled = false;
                if (btnSimpanOpen) btnSimpanOpen.disabled = false;
            }

            updateGrandTotal();
        }

        function updateGrandTotal() {
            const totalText = document.getElementById('total-pembayaran-text');
            const jsonInput = document.getElementById('items-json');

            const grandTotal = keranjang.reduce((sum, item) => sum + item.subtotal, 0);
            totalText.textContent = `Rp ${formatRupiah(grandTotal)}`;
            updateCashChange();

            const dataToSubmit = keranjang.map(item => ({
                id: item.id,
                qty: item.qty
            }));
            jsonInput.value = JSON.stringify(dataToSubmit);
        }

        function submitForm(status) {
            if (keranjang.length === 0) return;

            const form = document.getElementById('checkout-form');
            document.getElementById('status-penjualan').value = status;
            const grandTotal = keranjang.reduce((sum, item) => sum + item.subtotal, 0);
            
            const selectMetode = document.getElementById('metode-pembayaran');
            if (status === 'open') {
                selectMetode.removeAttribute('required');
            } else {
                selectMetode.setAttribute('required', 'required');
                if (!selectMetode.value) {
                    selectMetode.reportValidity();
                    return;
                }

                if (selectMetode.value === 'Cash') {
                    const cashInput = document.getElementById('uang-dibayar');
                    const cashPaid = parseInt(cashInput.value, 10) || 0;

                    if (cashPaid < grandTotal) {
                        cashInput.setCustomValidity('Uang dibayar harus sama atau lebih besar dari total transaksi.');
                        cashInput.reportValidity();
                        document.getElementById('cash-payment-error').classList.remove('hidden');
                        cashInput.focus();
                        return;
                    }

                    cashInput.setCustomValidity('');
                    document.getElementById('cash-payment-error').classList.add('hidden');
                }
            }

            form.submit();
        }

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID').format(angka);
        }
    </script>
@endsection 