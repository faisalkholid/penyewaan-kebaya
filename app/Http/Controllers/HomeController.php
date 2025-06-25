<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RentalsExport;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $start = $request->input('start_date');
        $end = $request->input('end_date');
        $status = $request->input('status');
        $query = Rental::query();
        if ($start && $end) {
            $query->whereDate('rental_date', '>=', $start)
                  ->whereDate('rental_date', '<=', $end);
        }
        if ($status) {
            $query->where('status', $status);
        }
        $rentals = $query->latest()->get();
        return view('home', compact('rentals', 'start', 'end', 'status'));
    }

    public function exportExcel(Request $request)
    {
        $start = $request->input('start_date');
        $end = $request->input('end_date');
        $status = $request->input('status');
        return Excel::download(new RentalsExport($start, $end, $status), 'laporan-penyewaan.xlsx');
    }
}
