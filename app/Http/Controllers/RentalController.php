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
            'user_name' => 'required|string',
        ]);

        // Hitung jumlah hari sewa
        $rentalDate = Carbon::parse($validated['rental_date']);
        $returnDate = Carbon::parse($validated['return_date']);
        $days = $rentalDate->diffInDays($returnDate);
        $days = $days > 0 ? $days : 1; // minimal 1 hari sewa

        // Ambil semua dress yang dipilih dan quantity dari request
        $quantities = $request->input('quantities', []);
        $dresses = Dress::whereIn('id', $validated['dresses'])->get();

        // Hitung total harga
        $totalPrice = 0;
        foreach ($dresses as $dress) {
            $qty = isset($quantities[$dress->id]) ? (int)$quantities[$dress->id] : 1;
            $totalPrice += ($dress->rental_price * $days * $qty);
        }

        // Simpan data rental
        $rental = Rental::create([
            'rental_date' => $validated['rental_date'],
            'return_date' => $validated['return_date'],
            'total_price' => $totalPrice,
            'user_name' => $validated['user_name'],
            'user_phone' => $validated['user_phone'],
            'user_address' => $validated['user_address'],
            'status' => 'pengajuan',
        ]);

        // Simpan detail rental
        foreach ($dresses as $dress) {
            $qty = isset($quantities[$dress->id]) ? (int)$quantities[$dress->id] : 1;
            $rental->details()->create([
                'dress_id' => $dress->id,
                'name' => $dress->name,
                'size' => $dress->size,
                'category' => $dress->category,
                'rental_price' => $dress->rental_price,
                'quantity' => $qty,
                'status' => $dress->status,
                'description' => $dress->description,
                'image_path' => $dress->image_path,
            ]);
        }

        // Kurangi stok setiap dress sesuai quantity yang disewa
        foreach ($dresses as $dress) {
            $qty = isset($quantities[$dress->id]) ? (int)$quantities[$dress->id] : 1;
            $dress->decrement('stock', $qty);
        }

        // Redirect ke detail rental public setelah submit
        if (Auth::check()) {
            return redirect()->route('rentals.show', $rental->id)->with('success', 'Penyewaan berhasil dibuat.');
        } else {
            return redirect()->route('public.rental.show', $rental->id)->with('success', 'Penyewaan berhasil dibuat.');
        }
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
            'status' => 'required|in:disewa,selesai,batal,pengajuan',
        ]);

        $rental->update($validated);

        // Jika rental selesai atau dibatalkan, kembalikan stok dress sesuai quantity
        if (in_array($validated['status'], ['selesai', 'batal'])) {
            $dresses = is_array($rental->dresses) ? $rental->dresses : json_decode($rental->dresses, true);
            if (!empty($dresses) && is_array($dresses)) {
                foreach ($dresses as $dress) {
                    $qty = isset($dress['quantity']) ? (int)$dress['quantity'] : 1;
                    \App\Models\Dress::where('id', $dress['id'])->increment('stock', $qty);
                }
            }
        }

        return redirect()->route('rentals.index')->with('success', 'Penyewaan berhasil diupdate.');
    }

    public function destroy(Rental $rental)
    {
        $rental->delete();

        return redirect()->route('rentals.index')->with('success', 'Penyewaan berhasil dihapus.');
    }
}
