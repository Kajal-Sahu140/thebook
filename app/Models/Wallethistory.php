<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallethistory extends Model
{
    use HasFactory;

    protected $table = 'wallet_historey'; // Assuming your sizes table is named 'sizes'

    protected $fillable = ['wallet_id','type','transaction_type']; // Adjust columns based on your table structure

    // Relationship with ProductVariant
 
}
