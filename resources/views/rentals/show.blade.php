@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow-lg border-0 mb-4">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="mb-3">
                        <h5 class="fw-bold mb-3">Baju</h5>
                        <div class="d-flex flex-wrap gap-3">
                            @php
                                $dresses = is_array($rental->dresses) ? $rental->dresses : json_decode($rental->dresses, true);
                            @endphp
                            @if(!empty($dresses) && is_array($dresses))
                                @foreach($dresses as $dress)
                                    <div class="card border-0 shadow-sm" style="width: 120px;">
                                        @if(!empty($dress['image_path']))
                                            <img src="{{ asset('storage/' . $dress['image_path']) }}" class="card-img-top rounded" alt="{{ $dress['name'] }}" style="height: 120px; object-fit: cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 120px;">
                                                <span class="text-muted">No Image</span>
                                            </div>
                                        @endif
                                        <div class="card-body p-2">
                                            <div class="text-center small fw-semibold">{{ $dress['name'] }}</div>
                                            <div class="text-center text-muted small">{{ $dress['category'] }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <span class="text-muted">Tidak ada dress</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <h3 class="fw-bold mb-3">Detail Penyewaan</h3>
                    <ul class="list-group list-group-flush mb-3">
                        <li class="list-group-item"><strong>Baju:</strong> @if(!empty($dresses) && is_array($dresses)) {{ collect($dresses)->pluck('name')->join(', ') }} @else - @endif</li>
                        <li class="list-group-item"><strong>User:</strong> {{ $rental->user_name }}</li>
                        <li class="list-group-item"><strong>Telepon:</strong> {{ $rental->user_phone }}</li>
                        <li class="list-group-item"><strong>Alamat:</strong> {{ $rental->user_address }}</li>
                        <li class="list-group-item"><strong>Tanggal Sewa:</strong> {{ $rental->rental_date }}</li>
                        <li class="list-group-item"><strong>Tanggal Kembali:</strong> {{ $rental->return_date ?? '-' }}</li>
                        <li class="list-group-item"><strong>Total Harga:</strong> <span class="text-success">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span></li>
                        <li class="list-group-item"><strong>Status:</strong> <span class="badge bg-primary">{{ ucfirst($rental->status) }}</span></li>
                    </ul>
                    <a href="{{ route('rentals.index') }}" class="btn btn-outline-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
