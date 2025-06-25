@extends('layouts.app')

@section('content')
<div class="container mt-2">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Edit Baju</h1>
        <a href="{{ route('dresses.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <form action="{{ route('dresses.update', $dress->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama Baju</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $dress->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="size" class="form-label">Ukuran</label>
            <select name="size" id="size" class="form-select" required>
                <option value="" disabled selected>Pilih</option>
                <option value="XL" {{ old('size', $dress->size) == 'XL' ? 'selected' : '' }}>XL</option>
                <option value="L" {{ old('size', $dress->size) == 'L' ? 'selected' : '' }}>L</option>
                <option value="M" {{ old('size', $dress->size) == 'M' ? 'selected' : '' }}>M</option>
                <option value="S" {{ old('size', $dress->size) == 'S' ? 'selected' : '' }}>S</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label">Kategori</label>
            <input type="text" name="category" class="form-control" value="{{ old('category', $dress->category) }}" required>
        </div>

        <div class="mb-3">
            <label for="stock" class="form-label">Stok</label>
            <input type="number" name="stock" class="form-control" value="{{ old('stock', $dress->stock) }}" required>
        </div>

        <div class="mb-3">
            <label for="rental_price" class="form-label">Harga Sewa</label>
            <input type="number" name="rental_price" step="0.01" class="form-control" value="{{ old('rental_price', $dress->rental_price) }}" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select" required>
                <option value="" disabled selected>Pilih</option>
                <option value="tersedia" {{ old('status', $dress->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                <option value="tidak tersedia" {{ old('status', $dress->status) == 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                <option value="perawatan" {{ old('status', $dress->status) == 'perawatan' ? 'selected' : '' }}>Perawatan</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="4">{{ old('description', $dress->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Foto Baju (JPG/PNG)</label>
            <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/png">
            @if ($dress->image_path)
                <img src="{{ asset('storage/' . $dress->image_path) }}" alt="Current Image" class="img-thumbnail mt-2" width="150">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Baju</button>
    </form>
</div>
@endsection
