<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'rental_id',
        'dress_id',
        'name',
        'size',
        'category',
        'rental_price',
        'quantity',
        'status',
        'description',
        'image_path',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }

    public function dress()
    {
        return $this->belongsTo(Dress::class);
    }
}
