@extends('layouts.app')

@section('content')
<div class="container mt-2">
    <h1>Edit Penyewaan</h1>

    <form action="{{ route('rentals.update', $rental) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="return_date" class="form-label">Tanggal Kembali</label>
            <input type="date" name="return_date" id="return_date" class="form-control" value="{{ $rental->return_date }}">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="pengajuan" {{ $rental->status == 'pengajuan' ? 'selected' : '' }}>Pengajuan</option>
                <option value="disewa" {{ $rental->status == 'disewa' ? 'selected' : '' }}>Disewa</option>
                <option value="selesai" {{ $rental->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="batal" {{ $rental->status == 'batal' ? 'selected' : '' }}>Batal</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection
