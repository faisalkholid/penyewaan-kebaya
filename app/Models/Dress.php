<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dress extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'size',
        'category',
        'stock',
        'rental_price',
        'status',
        'description',
        'image_path',
    ];

    /**
     * Cast attributes to specific types.
     */
    protected $casts = [
        'rental_price' => 'decimal:2',
        'stock' => 'integer',
    ];

    /**
     * Get the rental details for the dress.
     */
    public function rentalDetails()
    {
        return $this->hasMany(RentalDetail::class);
    }
}
