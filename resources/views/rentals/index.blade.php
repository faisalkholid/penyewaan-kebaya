@extends('layouts.app')

@section('title', 'Penyewaan Baju')

@section('content')
<div class="container mt-2">
    <div class="d-flex align-items-center gap-2 mb-3">
        <h1 class="m-0">Daftar Penyewaan</h1>
        <!-- <a href="{{ route('rentals.create') }}"
            class="btn btn-primary d-flex align-items-center justify-content-center"
            style="width: 36px; height: 36px;">
            <i class="bi bi-plus-lg"></i>
        </a> -->
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('rentals.create') }}"
        class="btn btn-primary d-flex align-items-center justify-content-center"
        style="width: 255px; margin-bottom: 15px;">
        <i class="bi bi-plus-lg" style="margin-right: 8px;"></i> Tambah Penyewaan
    </a>

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
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rentals as $rental)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <ul class="mb-0">
                            @foreach ($rental->details as $detail)
                                <li>{{ $detail->name }} ({{ $detail->size }}) - {{ $detail->quantity ?? 1 }} pcs</li>
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
                    <td>
                        <a href="{{ route('rentals.show', $rental) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('rentals.edit', $rental) }}" class="btn btn-warning btn-sm">Update Status</a>
                        <!-- <form action="{{ route('rentals.destroy', $rental) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                        </form> -->
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $rentals->links() }}
</div>
@endsection
