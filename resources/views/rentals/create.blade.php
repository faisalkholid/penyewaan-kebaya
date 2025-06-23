@extends('layouts.app')

@section('content')
<div class="container mt-2">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Tambah Penyewaan</h1>
        <a href="{{ route('rentals.index') }}" class="btn btn-secondary">Kembali</a>
    </div>

    <form action="{{ route('rentals.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <div class="row">
                <div class="col">
                    <label for="rental_date" class="form-label">Tanggal Sewa</label>
                    <input type="date" name="rental_date" id="rental_date" class="form-control" required>
                </div>
                <div class="col">
                    <label for="return_date" class="form-label">Tanggal Kembali</label>
                    <input type="date" name="return_date" id="return_date" class="form-control">
                </div>
                <div class="col">
                    <label for="total_price" class="form-label">Total Harga</label>
                    <input type="number" name="total_price" id="total_price" class="form-control" disabled readonly value="0">
                </div>
            </div>
        </div>

        <div class="mb-3">
            <div class="row">
                <div class="col">
                    <label for="user_address" class="form-label">Alamat Penyewa</label>
                    <textarea name="user_address" id="user_address" class="form-control" rows="3" required></textarea>
                </div>
                <div class="col">
                    <label for="user_phone" class="form-label">Nomor Telepon (Whatsapp)</label>
                    <input type="text" name="user_phone" id="user_phone" class="form-control" required placeholder="081xxx">
                </div>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Pilih Dress</label>
            <div class="d-grid gap-3" style="max-height: 750px; overflow-y: auto; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); grid-gap: 15px;">
                @foreach ($dresses as $dress)
                    <div class="card card-selectable"
                        style="min-width: 180px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); cursor: pointer;"
                        data-checkbox-id="dress{{ $dress->id }}">

                        <div class="card-img-wrapper" style="position: relative; width: 100%; padding-top: 100%; overflow: hidden;">
                            @if ($dress->image_path)
                                <img src="{{ asset('storage/' . $dress->image_path) }}" class="card-img-top" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; color: #3A3B3C;">No Image</div>
                            @endif
                        </div>

                        <div class="card-body p-2">
                            <h6 class="card-title mb-1" style="font-size: 14px;">{{ $dress->name }}</h6>
                            <p class="mb-1" style="font-size: 12px;">Rp{{ number_format($dress->rental_price, 0, ',', '.') }}</p>
                            <div class="form-check">
                                <input class="form-check-input dress-checkbox"
                                    type="checkbox"
                                    name="dresses[]"
                                    value="{{ $dress->id }}"
                                    data-price="{{ $dress->rental_price }}"
                                    id="dress{{ $dress->id }}">
                                <label class="form-check-label" for="dress{{ $dress->id }}"></label>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rentalDateInput = document.getElementById('rental_date');
        const returnDateInput = document.getElementById('return_date');
        const totalPriceInput = document.getElementById('total_price');
        const dressCheckboxes = document.querySelectorAll('.dress-checkbox');

        function calculateTotal() {
            let total = 0;
            const rentalDate = new Date(rentalDateInput.value);
            const returnDate = new Date(returnDateInput.value);

            const dayDiff = (rentalDate && returnDate)
                ? Math.max(1, Math.ceil((returnDate - rentalDate) / (1000 * 3600 * 24)))
                : 1; // Minimal 1 hari kalau tanggal belum lengkap

            dressCheckboxes.forEach(cb => {
                if (cb.checked) {
                    const price = parseFloat(cb.dataset.price);
                    total += price * dayDiff;
                }
            });

            totalPriceInput.value = total;
        }

        dressCheckboxes.forEach(cb => cb.addEventListener('change', calculateTotal));
        rentalDateInput.addEventListener('change', calculateTotal);
        returnDateInput.addEventListener('change', calculateTotal);
    });

    document.querySelectorAll('.card-selectable').forEach(card => {
        card.addEventListener('click', function (e) {
            // Prevent toggling if clicking directly on checkbox
            if (e.target.type !== 'checkbox') {
                const checkboxId = this.getAttribute('data-checkbox-id');
                const checkbox = document.getElementById(checkboxId);
                if (checkbox) {
                    checkbox.checked = !checkbox.checked;
                    checkbox.dispatchEvent(new Event('change')); // Optional: to trigger change listeners
                }
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const rentalDateInput = document.getElementById('rental_date');
        const returnDateInput = document.getElementById('return_date');

        const today = new Date().toISOString().split('T')[0];
        rentalDateInput.setAttribute('min', today);
        returnDateInput.setAttribute('min', today);

        rentalDateInput.addEventListener('change', function () {
            if (rentalDateInput.value) {
                const rentalDate = new Date(rentalDateInput.value);
                rentalDate.setDate(rentalDate.getDate() + 1); // add 1 day
                const nextDay = rentalDate.toISOString().split('T')[0];

                returnDateInput.setAttribute('min', nextDay);

                // Optional: if return date is before new min, reset it
                if (returnDateInput.value < nextDay) {
                    returnDateInput.value = nextDay;
                }
            }
        });
    });
</script>
@endpush
