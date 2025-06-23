<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Dress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::latest()->paginate(10);
        return view('rentals.index', compact('rentals'));
    }

    public function create()
    {
        $dresses = Dress::where('status', 'tersedia')->get();
        return view('rentals.create', compact('dresses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dresses' => 'required|array|min:1',    // <-- validasi array dresses
            'dresses.*' => 'exists:dresses,id',      // <-- pastikan semua id dress valid
            'rental_date' => 'required|date',
            'return_date' => 'nullable|date|after_or_equal:rental_date',
            'user_phone' => 'required|string',
            'user_address' => 'required|string',
        ]);

        // Hitung jumlah hari sewa
        $rentalDate = Carbon::parse($validated['rental_date']);
        $returnDate = Carbon::parse($validated['return_date']);
        $days = $rentalDate->diffInDays($returnDate);
        $days = $days > 0 ? $days : 1; // minimal 1 hari sewa

        // Ambil semua dress yang dipilih
        $dresses = Dress::whereIn('id', $validated['dresses'])->get();

        // Ubah menjadi array data lengkap
        $dressData = $dresses->map(function ($dress) {
            return [
                'id' => $dress->id,
                'name' => $dress->name,
                'size' => $dress->size,
                'category' => $dress->category,
                'rental_price' => $dress->rental_price,
                'status' => $dress->status,
                'description' => $dress->description,
                'image_path' => $dress->image_path,
            ];
        })->toArray();

        // Hitung total harga
        $totalPrice = 0;
        foreach ($dresses as $dress) {
            $totalPrice += ($dress->rental_price * $days);
        }

        // Simpan data rental
        Rental::create([
            'dresses' => json_encode($dressData),
            'rental_date' => $validated['rental_date'],
            'return_date' => $validated['return_date'],
            'total_price' => $totalPrice,
            'user_name' => auth()->user()->name ?? 'Guest',
            'user_phone' => $validated['user_phone'],
            'user_address' => $validated['user_address'],
        ]);

        // Update semua dress menjadi unavailable
        // foreach ($dresses as $dress) {
        //     $dress->status = 'unavailable';
        //     $dress->save();
        // }

        return redirect()->route('rentals.index')->with('success', 'Penyewaan berhasil dibuat.');
    }

    public function show(Rental $rental)
    {
        return view('rentals.show', compact('rental'));
    }

    public function edit(Rental $rental)
    {
        return view('rentals.edit', compact('rental'));
    }

    public function update(Request $request, Rental $rental)
    {
        $validated = $request->validate([
            'return_date' => 'nullable|date|after_or_equal:rental_date',
            'status' => 'required|in:ongoing,completed,cancelled',
        ]);

        $rental->update($validated);

        // Jika rental selesai atau dibatalkan, kembalikan status dress
        if (in_array($validated['status'], ['completed', 'cancelled'])) {
            $rental->dress->update(['status' => 'available']);
        }

        return redirect()->route('rentals.index')->with('success', 'Penyewaan berhasil diupdate.');
    }

    public function destroy(Rental $rental)
    {
        $rental->delete();

        return redirect()->route('rentals.index')->with('success', 'Penyewaan berhasil dihapus.');
    }
}
