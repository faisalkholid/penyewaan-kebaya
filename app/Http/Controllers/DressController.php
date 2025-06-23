<?php

namespace App\Http\Controllers;

use App\Models\Dress;
use Illuminate\Http\Request;

class DressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dresses = Dress::paginate(10);
        return view('dresses.index', compact('dresses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dresses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'size' => 'required|string|max:10',
            'category' => 'required|string|max:100',
            'stock' => 'required|integer|min:0',
            'rental_price' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,tidak tersedia,perawatan',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png|max:2048',
        ]);

        // Upload file
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('dresses', 'public');
            $validated['image_path'] = $path;
        }

        Dress::create($validated);
        return redirect()->route('dresses.index')->with('success', 'Baju berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dress $dress)
    {
        return view('dresses.show', compact('dress'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dress $dress)
    {
        return view('dresses.edit', compact('dress'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dress $dress)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'size' => 'required|string|max:10',
            'category' => 'required|string|max:100',
            'stock' => 'required|integer|min:0',
            'rental_price' => 'required|numeric|min:0',
            'status' => 'required|in:tersedia,tidak tersedia,perawatan',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png|max:2048',
        ]);

        // Upload file
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('dresses', 'public');
            $validated['image_path'] = $path;
        }

        $dress->update($validated);
        return redirect()->route('dresses.index')->with('success', 'Baju berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dress $dress)
    {
        $dress->delete();
        return redirect()->route('dresses.index')->with('success', 'Baju berhasil dihapus.');
    }
}
