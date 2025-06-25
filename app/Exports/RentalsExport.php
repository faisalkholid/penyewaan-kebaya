<?php

namespace App\Exports;

use App\Models\Rental;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RentalsExport implements FromCollection, WithHeadings
{
    protected $start;
    protected $end;
    protected $status;

    public function __construct($start, $end, $status = null)
    {
        $this->start = $start;
        $this->end = $end;
        $this->status = $status;
    }

    public function collection()
    {
        $query = Rental::query();
        if ($this->start && $this->end) {
            $query->whereDate('rental_date', '>=', $this->start)
                  ->whereDate('rental_date', '<=', $this->end);
        }
        if ($this->status) {
            $query->where('status', $this->status);
        }
        $rentals = $query->latest()->get();
        // Format for export
        return $rentals->map(function ($rental) {
            $dressList = collect(json_decode($rental->dresses))->map(function($d) {
                return $d->name.' ('.$d->size.') x'.($d->quantity ?? 1);
            })->implode(", ");
            return [
                'Baju' => $dressList,
                'Nama Penyewa' => $rental->user_name,
                'Nomor Telepon' => $rental->user_phone,
                'Alamat' => $rental->user_address,
                'Tanggal Sewa' => $rental->rental_date,
                'Tanggal Kembali' => $rental->return_date,
                'Total Harga' => $rental->total_price,
                'Status' => ucfirst($rental->status),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Baju',
            'Nama Penyewa',
            'Nomor Telepon',
            'Alamat',
            'Tanggal Sewa',
            'Tanggal Kembali',
            'Total Harga',
            'Status',
        ];
    }
}
