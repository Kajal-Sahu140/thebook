<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanModule extends Model
{
    use HasFactory;

    protected $table = 'books_plane';

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'discount',
        'status',
        'security_amount',
        'minum_order',
        'days',
        'tbd_price'
    ];
}
