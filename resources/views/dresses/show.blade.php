@extends('layouts.app')

@section('title', 'Detail Baju')

@section('content')
    <div class="container mt-2">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Detail Baju</h1>
            <a href="{{ route('dresses.index') }}" class="btn btn-secondary">Kembali</a>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="mb-4 text-center">
                    @if ($dress->image_path)
                        <img
                            src="{{ asset('storage/' . $dress->image_path) }}"
                            alt="{{ $dress->name }}"
                            class="img-fluid"
                            style="max-height: 300px; object-fit: cover;"
                        >
                    @else
                        <div class="bg-light d-flex align-items-center justify-content-center"
                            style="width: 100%; height: 300px; color: #6c757d; font-size: 20px;">
                            No Image
                        </div>
                    @endif
                </div>

                <h3 class="card-title">{{ $dress->name }}</h3>

                <ul class="list-group list-group-flush mt-3">
                    <li class="list-group-item"><strong>Ukuran:</strong> {{ $dress->size }}</li>
                    <li class="list-group-item"><strong>Kategori:</strong> {{ $dress->category }}</li>
                    <li class="list-group-item"><strong>Stok:</strong> {{ $dress->stock }}</li>
                    <li class="list-group-item"><strong>Harga Sewa:</strong> Rp{{ number_format($dress->rental_price, 0, ',', '.') }}</li>
                    <li class="list-group-item"><strong>Status:</strong> {{ ucfirst($dress->status) }}</li>
                    <li class="list-group-item"><strong>Deskripsi:</strong><br>{{ $dress->description ?? '-' }}</li>
                </ul>
            </div>
        </div>
    </div>
@endsection
