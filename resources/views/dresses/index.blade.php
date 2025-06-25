@extends('layouts.app')

@section('title', 'Daftar Baju')

@section('content')
<div class="container mt-2">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
            <h1 class="m-0">Daftar Baju</h1>
            <!-- <a href="{{ route('dresses.create') }}"
                class="btn btn-primary d-flex align-items-center justify-content-center"
                style="width: 36px; height: 36px; margin-left: 4px;">
                <i class="bi bi-plus-lg"></i>
            </a> -->
        </div>
        <div class="d-flex align-items-center gap-2">
            <div class="d-flex small text-muted" style="align-items: center;">
                <div style="margin-right: 8px">
                    Showing {{ $dresses->firstItem() }} to {{ $dresses->lastItem() }} of {{ $dresses->total() }} results
                </div>
                <div style="margin-top: 16px;">
                    {{ $dresses->onEachSide(1)->links('pagination::bootstrap-5') }}
                </div>
            </div>
            <div class="btn-group" role="group" aria-label="View Toggle">
                <button id="gridViewBtn" type="button" class="btn btn-outline-secondary active">
                    <i class="bi bi-grid"></i>
                </button>
                <button id="listViewBtn" type="button" class="btn btn-outline-secondary">
                    <i class="bi bi-list"></i>
                </button>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

     <a href="{{ route('dresses.create') }}"
        class="btn btn-primary d-flex align-items-center justify-content-center"
        style="width: 255px; margin-bottom: 15px;">
        <i class="bi bi-plus-lg" style="margin-right: 8px;"></i> Tambah Baju
    </a>

    @if ($dresses->isEmpty())
        <div class="alert alert-info">
            Belum ada data baju.
        </div>
    @else
        {{-- Table View --}}
        <div id="tableView" style="display: none;">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Ukuran</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Harga Sewa</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($dresses as $dress)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $dress->name }}</td>
                            <td>{{ $dress->size }}</td>
                            <td>{{ $dress->category }}</td>
                            <td>{{ $dress->stock }}</td>
                            <td>Rp {{ number_format($dress->rental_price, 2, ',', '.') }}</td>
                            <td>
                                <span class="badge
                                    @if ($dress->status == 'tersedia') bg-success
                                    @elseif($dress->status == 'perawatan') bg-warning text-dark
                                    @else bg-secondary @endif">
                                    {{ ucfirst($dress->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('dresses.show', $dress) }}" class="btn btn-sm btn-info">Show</a>
                                <a href="{{ route('dresses.edit', $dress) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('dresses.destroy', $dress) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus baju ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Card View --}}
        <div id="cardView" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3">
            @foreach ($dresses as $dress)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-img-wrapper" style="position: relative; width: 100%; padding-top: 100%; overflow: hidden;">
                            @if ($dress->image_path)
                                <img src="{{ asset('storage/' . $dress->image_path) }}" class="card-img-top" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; color: #3A3B3C;">No Image</div>
                            @endif
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $dress->name }}</h5>
                            <p class="card-text">
                                <strong>Ukuran:</strong> {{ $dress->size }}<br>
                                <strong>Kategori:</strong> {{ $dress->category }}<br>
                                <strong>Stok:</strong> {{ $dress->stock }}<br>
                                <strong>Harga:</strong> Rp{{ number_format($dress->rental_price, 0, ',', '.') }}<br>
                                <strong>Status:</strong>
                                <span class="badge
                                    @if ($dress->status == 'tersedia') bg-success
                                    @elseif($dress->status == 'perawatan') bg-warning text-dark
                                    @else bg-secondary @endif">
                                    {{ ucfirst($dress->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="card-footer text-center">
                            <a href="{{ route('dresses.show', $dress) }}" class="btn btn-sm btn-info">Detail</a>
                            <a href="{{ route('dresses.edit', $dress) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('dresses.destroy', $dress) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus baju ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    const gridViewBtn = document.getElementById('gridViewBtn');
    const listViewBtn = document.getElementById('listViewBtn');
    const tableView = document.getElementById('tableView');
    const cardView = document.getElementById('cardView');

    gridViewBtn.addEventListener('click', function() {
        tableView.style.display = 'none';
        cardView.style.display = 'flex';
        gridViewBtn.classList.add('active');
        listViewBtn.classList.remove('active');
    });

    listViewBtn.addEventListener('click', function() {
        tableView.style.display = 'block';
        cardView.style.display = 'none';
        listViewBtn.classList.add('active');
        gridViewBtn.classList.remove('active');
    });
</script>
@endpush
