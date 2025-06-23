<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dress;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'dresses',
        'rental_date',
        'return_date',
        'status',
        'total_price',
        'user_name',
        'user_phone',
        'user_address',
    ];
}
