@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0 mb-4" id="pdf-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <h3 class="fw-bold mb-3 text-center">Detail Penyewaan</h3>
                            <ul class="list-group list-group-flush mb-3">
                                <!-- <li class="list-group-item"><strong>Baju:</strong> @if(!empty($dresses) && is_array($dresses)) {{ collect($dresses)->pluck('name')->join(', ') }} @else - @endif</li> -->
                                <li class="list-group-item"><strong>Nama:</strong> {{ $rental->user_name }}</li>
                                <li class="list-group-item"><strong>Telepon:</strong> {{ $rental->user_phone }}</li>
                                <li class="list-group-item"><strong>Alamat:</strong> {{ $rental->user_address }}</li>
                                <li class="list-group-item"><strong>Tanggal Sewa:</strong> {{ $rental->rental_date }}</li>
                                <li class="list-group-item"><strong>Tanggal Kembali:</strong> {{ $rental->return_date ?? '-' }}</li>
                                <li class="list-group-item"><strong>Total Harga:</strong> <span class="text-success">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span></li>
                                <li class="list-group-item"><strong>Status:</strong> <span class="badge bg-primary">{{ ucfirst($rental->status) }}</span></li>
                            </ul>
                            <!-- <a href="{{ route('rentals.index') }}" class="btn btn-outline-secondary">Kembali</a> -->
                        </div>
                        <div class="col-md-12">
                            <div class="mb-3">
                                <h5 class="fw-bold mb-3 text-center">Daftar Baju</h5>
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
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <a style="width: 255px" href="#" class="btn btn-outline-danger mb-3" id="download-pdf-btn"><i class="bi bi-file-earmark-pdf"></i> Download PDF</a>
                <button type="button" class="btn btn-outline-primary mb-3 ms-2" id="share-link-btn"><i class="bi bi-share"></i> Share</button>
                <button type="button" class="btn btn-outline-secondary mb-3 ms-2" id="copy-link-btn"><i class="bi bi-clipboard"></i> Copy Link</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('download-pdf-btn');
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const card = document.getElementById('pdf-card');
            html2pdf().from(card).set({
                margin: 0.5,
                filename: 'detail-penyewaan.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
            }).save();
        });

        const shareBtn = document.getElementById('share-link-btn');
        shareBtn.addEventListener('click', function() {
            const url = window.location.href;
            if (navigator.share) {
                navigator.share({
                    title: document.title,
                    url: url
                });
            } else {
                navigator.clipboard.writeText(url);
                alert('Link disalin ke clipboard!');
            }
        });

        const copyBtn = document.getElementById('copy-link-btn');
        copyBtn.addEventListener('click', function() {
            const url = window.location.href;
            navigator.clipboard.writeText(url);
            alert('Link berhasil disalin ke clipboard!');
        });
    });
</script>
@endpush
