@extends('layouts.layout')

@section('title', 'Dashboard')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<!-- Custom CSS -->
<link href="{{ asset('css/style.css') }}" rel="stylesheet">

<div class="d-flex vh-100">
    <!-- Sidebar -->
    <div class="sidebar d-flex flex-column align-items-center">
        <a href="#" class="nav-link active">
            <i class="bi bi-card-image fs-5"></i>
            <span>Menu</span>
        </a>
        <a href="#" class="nav-link">
            <i class="bi bi-cursor fs-5"></i>
            <span>PO</span>
        </a>
        <a href="#" class="nav-link">
            <i class="bi bi-file-earmark-bar-graph fs-5"></i>
            <span>Laporan</span>
        </a>
        <a href="#" class="nav-link">
            <i class="bi bi-pie-chart fs-5"></i>
            <span>Barang</span>
        </a>
        <a href="{{ route('pengaturan') }}" class="nav-link">
            <i class="bi bi-gear fs-5"></i> Pengaturan
        </a>
        <a href="#" class="nav-link text-danger">
            <i class="bi bi-box-arrow-right fs-5"></i>
            <span>Logout</span>
        </a>
    </div>

    <!-- Main Content -->
    <div class="d-flex flex-grow-1">
        <!-- Left: Menu Content -->
        <div class="content-area">
            <div class="menu-header">
                <div class="menu-tabs">
                    <button onclick="filterMenu('makanan')">Makanan</button>
                    <button onclick="filterMenu('minuman')">Minuman</button>
                    <button onclick="filterMenu('snack')">Snack</button>
                </div>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tambahMenuModal" style="border: none; padding: 4px 10px; border-radius: 6px; background-color: #1E2431; color: #fff; font-size: 0.8rem;">
                    <i class="bi bi-plus"></i> Tambah Menu
                </button>
            </div>

            <div class="menu-grid" id="menuGrid">
                @foreach ($menus as $menu)
                <div class="menu-item" data-kategori="{{ $menu->jenis_menu }}" onclick="selectMenu('{{ $menu->nama_menu }}', '{{ $menu->harga }}')">
                    <img src="{{ asset('storage/' . $menu->gambar_produk) }}" alt="{{ $menu->nama_menu }}" style="width: 100%; height: 100px; border-radius: 6px;">
                    <h6 class="mt-2 text-center fw-bold" style="color: #1E2431;">{{ $menu->nama_menu }}</h6>
                    <p class="text-center">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Container Panel -->
        <div class="order-panel-container">

            <!-- Order Menu Panel -->
            <div id="orderPanel" class="order-panel ms-4">
                <div>
                    <h5>Order Menu</h5>
                    <div id="orderContent" class="mt-3 d-flex flex-column gap-2">
                        <small class="text-muted">Silahkan pilih menu</small>
                    </div>
                </div>
                <div class="order-footer">
                    <div class="total-info">
                        <small id="totalItemsLabel">0 items</small>
                        <div id="totalHargaLabel">Rp 0</div>
                    </div>
                    <button class="btn-order" onclick="goToPayment()">
                        <i class="bi bi-save-fill"></i> Order
                    </button>
                </div>
            </div>

            <div id="paymentPanel" class="order-panel ms-4 d-none">
                <div>
                    <h5>Payment</h5>
                    <div id="paymentOptions" class="mt-3 d-flex justify-content-between text-center">
                        <div class="payment-method" data-method="credit" onclick="selectPayment('credit')">
                            <i class="bi bi-credit-card-2-front fs-3"></i>
                            <div>Credit Card</div>
                        </div>
                        <div class="payment-method" data-method="cash" onclick="selectPayment('cash')">
                            <i class="bi bi-cash-coin fs-3"></i>
                            <div>Cash</div>
                        </div>
                        <div class="payment-method" data-method="qr" onclick="selectPayment('qr')">
                            <i class="bi bi-qr-code-scan fs-3"></i>
                            <div>Scanner</div>
                        </div>
                    </div>

                    <!-- Credit Card Form -->
                    <div id="creditCardForm" class="mt-4 d-none">
                        <h6>Credit Card Info</h6>
                        <div class="mb-2">
                            <label class="form-label">Nama Pemilik Kartu</label>
                            <input type="text" class="form-control" placeholder="Nama Lengkap">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Nomor Kartu</label>
                            <input type="text" class="form-control" placeholder="1234 5678 9012 3456">
                        </div>
                        <div class="d-flex gap-2 mb-3">
                            <div class="flex-fill">
                                <label class="form-label">Tgl Kedaluwarsa</label>
                                <input type="month" class="form-control">
                            </div>
                            <div class="flex-fill">
                                <label class="form-label">CVV</label>
                                <input type="text" class="form-control" placeholder="123" maxlength="3">
                            </div>
                        </div>
                    </div>

                    <!-- Cash Payment Form -->
                    <div id="cashForm" class="mt-4 d-none">
                        <h6>Cash Payment</h6>
                        <div class="mb-2">
                            <label class="form-label">Jumlah Bayar</label>
                            <input type="number" class="form-control" id="jumlahBayarInput" placeholder="Masukkan nominal" oninput="hitungKembalian()">
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Kembalian</label>
                            <input type="text" class="form-control" id="kembalianOutput" readonly>
                        </div>
                    </div>

                    <!-- QR Code Form -->
                    <div id="qrForm" class="mt-4 d-none text-center">
                        <h6>QR Code Payment</h6>
                        <p>Silakan scan QR di bawah untuk membayar</p>
                        <img src="https://api.qrserver.com/v1/create-qr-code/?data=BayarPOSOmahMU&size=150x150" alt="QR Code">
                        <p class="text-muted mt-2"><small>Setelah pembayaran berhasil, klik tombol di bawah</small></p>
                    </div>
                </div>

                <div class="order-footer mt-4">
                    <div class="total-info">
                        <small id="totalItemsLabelPayment">0 items</small>
                        <div id="totalHargaLabelPayment">Rp 0</div>
                    </div>
                    <button class="btn-order" onclick="submitPayment()">
                        <i class="bi bi-save-fill"></i> Bayar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Menu -->
<div class="modal fade" id="tambahMenuModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Menu Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('stok_menu.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <!-- Upload Gambar -->
                    <div class="mb-3 text-center">
                        <div class="image-upload-container mb-2">
                            <img id="previewGambar" src="{{ asset('img/placeholder-image.jpg') }}"
                                class="img-thumbnail" style="width: 200px; height: 200px; object-fit: cover;">
                        </div>
                        <input type="file" class="form-control d-none" id="gambarMenu" name="gambar_produk" accept="image/*">
                        <button type="button" class="btn btn-sm btn-outline-secondary"
                            onclick="document.getElementById('gambarMenu').click()">
                            <i class="bi bi-image"></i> Pilih Gambar
                        </button>
                        <small class="text-muted d-block mt-1">Format: JPG/PNG (Maks. 2MB)</small>
                    </div>

                    <!-- Kategori -->
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select class="form-select" name="jenis_menu" required>
                            <option value="" selected disabled>Pilih Kategori</option>
                            <option value="makanan">Makanan</option>
                            <option value="minuman">Minuman</option>
                            <option value="snack">Snack</option>
                        </select>
                    </div>

                    <!-- Nama Menu -->
                    <div class="mb-3">
                        <label class="form-label">Nama Menu</label>
                        <input type="text" class="form-control" name="nama_menu" placeholder="Contoh: Nasi Goreng Spesial" required>
                    </div>

                    <!-- Kuantitas -->
                    <div class="mb-3">
                        <label class="form-label">Kuantitas</label>
                        <input type="number" class="form-control" name="kuantitas" min="1" placeholder="Contoh: 50" required>
                    </div>


                    <!-- Harga -->
                    <div class="mb-3">
                        <label class="form-label">Harga</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control" name="harga" min="1000" step="500" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Menu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JS -->
<script src="{{ asset('js/app.js') }}"></script>

@endsection