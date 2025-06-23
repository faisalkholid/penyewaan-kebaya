@extends('layouts.app')

@section('title', 'Tambah Baju')

@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Tambah Baju</h1>
            <a href="{{ route('dresses.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Terjadi kesalahan!</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('dresses.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nama Baju</label>
                <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
            </div>

            <div class="mb-3">
                <label for="size" class="form-label">Ukuran</label>
                <select name="size" id="size" class="form-select" required>
                    <option value="" disabled selected>Pilih</option>
                    <option value="XL" {{ old('size') === 'XL' ? 'selected' : '' }}>XL</option>
                    <option value="L" {{ old('size') === 'L' ? 'selected' : '' }}>L</option>
                    <option value="M" {{ old('size') === 'M' ? 'selected' : '' }}>M</option>
                    <option value="S" {{ old('size') === 'S' ? 'selected' : '' }}>S</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Kategori</label>
                <input type="text" class="form-control" id="category" name="category" required
                    value="{{ old('category') }}">
            </div>

            <div class="mb-3">
                <label for="stock" class="form-label">Stok</label>
                <input type="number" class="form-control" id="stock" name="stock" min="0" required
                    value="{{ old('stock') }}">
            </div>

            <div class="mb-3">
                <label for="rental_price" class="form-label">Harga Sewa (Rp)</label>
                <input type="number" class="form-control" id="rental_price" name="rental_price" step="0.01" min="0" required
                    value="{{ old('rental_price') }}">
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="" disabled selected>Pilih</option>
                    <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="tidak tersedia" {{ old('status') == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                    <option value="perawatan" {{ old('status') == 'perawatan' ? 'selected' : '' }}>Perawatan</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea name="description" id="description" class="form-control"
                    rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Foto Baju (JPG/PNG)</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/png" required>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
@endsection
