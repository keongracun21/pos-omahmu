@extends('layouts.layout')

@section('title', 'Pengaturan Profil')

@section('content')

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">

<div class="d-flex vh-100">
    <!-- Sidebar Utama -->
    <div class="sidebar d-flex flex-column align-items-center">
        <a href="{{ route('dashboard') }}" class="nav-link">
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
        <a href="{{ route('pengaturan') }}" class="nav-link active">
            <i class="bi bi-gear fs-5"></i>
            <span>Pengaturan</span>
        </a>
        <a href="#" class="nav-link text-danger">
            <i class="bi bi-box-arrow-right fs-5"></i>
            <span>Logout</span>
        </a>
    </div>

    <!-- Main Content -->
    <div class="d-flex flex-grow-1">
        <!-- Sidebar Pengaturan Minimalis -->
        <div class="settings-sidebar bg-white" style="width: 180px; border-right: 1px solid #e5e7eb;">
            <div class="p-2">
                <ul class="nav flex-column settings-nav gap-1">
                    <li class="nav-item">
                        <a class="nav-link active" href="#profile" data-bs-toggle="tab">
                            Profil Saya
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#access" data-bs-toggle="tab">
                            Management Akses
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Content Area dengan padding kiri lebih besar -->
        <div class="content-area ps-5 pe-4 py-4 flex-grow-1" style="margin-left: 15px;">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <div class="tab-content">
                <!-- Tab Profil Saya -->
                <div class="tab-pane fade show active" id="profile">
                    <div class="card shadow-sm p-4">
                        <!-- Profile Header -->
                        <div class="d-flex align-items-center mb-4">
                            <div class="position-relative">
                                <img src="{{ asset('img/profile-picture.jpg') }}"
                                    class="rounded-circle"
                                    style="width: 80px; height: 80px; object-fit: cover;"
                                    alt="Profile Picture">
                                <button class="btn btn-sm btn-secondary position-absolute bottom-0 end-0 rounded-circle p-1">
                                    <i class="bi bi-camera-fill"></i>
                                </button>
                            </div>
                            <div class="ms-4">
                                <h4 class="mb-1">{{ $user->name }}</h4>
                                <span class="badge bg-primary">{{ $user->role ?? 'User' }}</span>
                            </div>
                        </div>

                        <h4 class="mb-4">Informasi Personal</h4>

                        <form action="{{ route('pengaturan.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Nama -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" name="name" class="form-control input-custom"
                                    value="{{ old('name', $user->name) }}" required>
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat Email</label>
                                <input type="email" name="email" class="form-control input-custom"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>

                            <!-- Password Baru dan Konfirmasi Password (Bersampingan) -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <input type="password" name="password" class="form-control input-custom">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control input-custom">
                                </div>
                            </div>
                            <small class="text-muted d-block mb-4">Kosongkan jika tidak ingin mengubah password.</small>

                            <!-- Tombol Aksi -->
                            <div class="d-flex justify-content-end gap-3">
                                <a href="{{ route('dashboard') }}" class="btn btn-cancel">
                                    <i class="bi bi-x-lg me-2"></i> Batal
                                </a>
                                <button type="submit" class="btn btn-save">
                                    <i class="bi bi-save-fill me-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Tab Management Akses -->
                <div class="tab-pane fade" id="access">
                    <div class="card shadow-sm p-4">
                        <h4 class="mb-4">Management Akses</h4>
                        <div class="text-center py-5">
                            <i class="bi bi-shield-lock fs-1 text-muted"></i>
                            <p class="text-muted mt-3">Fitur Management Akses akan segera tersedia</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS -->
<script src="{{ asset('js/app.js') }}"></script>

@endsection