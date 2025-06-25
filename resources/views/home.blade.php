@extends('layouts.app')

@section('content')
<div class="container-fluid min-vh-100 bg-light">
    <div class="row">
        <!-- Main Content -->
        <main class="ms-sm-auto px-md-5 py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Laporan</h2>
            </div>
            <form method="GET" action="{{ route('home') }}" class="mb-4 row g-3 align-items-end">
                <div class="col-auto">
                    <label for="start_date" class="form-label mb-0">Dari Tanggal</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date', $start ?? '') }}">
                </div>
                <div class="col-auto">
                    <label for="end_date" class="form-label mb-0">Sampai Tanggal</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date', $end ?? '') }}">
                </div>
                <div class="col-auto">
                    <label for="status" class="form-label mb-0">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pengajuan" {{ request('status') == 'pengajuan' ? 'selected' : '' }}>Pengajuan</option>
                        <option value="disewa" {{ request('status') == 'disewa' ? 'selected' : '' }}>Disewa</option>
                        <option value="batal" {{ request('status') == 'batal' ? 'selected' : '' }}>Batal</option>
                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary">Tampilkan</button>
                </div>
                @if(($start ?? false) && ($end ?? false))
                <div class="col-auto">
                    <a href="{{ route('laporan.excel', ['start_date' => $start, 'end_date' => $end, 'status' => request('status')]) }}" class="btn btn-success">
                        <i class="bi bi-file-earmark-excel"></i> Download Excel
                    </a>
                </div>
                @endif
            </form>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Baju</th>
                            <th>Nama Penyewa</th>
                            <th>Nomor Telepon Penyewa</th>
                            <th>Alamat Penyewa</th>
                            <th>Tanggal Sewa</th>
                            <th>Tanggal Kembali</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rentals as $rental)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <ul class="mb-0">
                                        @foreach (json_decode($rental->dresses) as $dress)
                                            <li>{{ $dress->name }} ({{ $dress->size }}) - {{ $dress->quantity ?? 1 }} pcs</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ $rental->user_name }}</td>
                                <td>{{ $rental->user_phone }}</td>
                                <td>{{ $rental->user_address }}</td>
                                <td>{{ $rental->rental_date }}</td>
                                <td>{{ $rental->return_date ?? '-' }}</td>
                                <td>Rp {{ number_format($rental->total_price, 0, ',', '.') }}</td>
                                <td>{{ ucfirst($rental->status) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">Tidak ada data penyewaan untuk filter ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</div>
@endsection
