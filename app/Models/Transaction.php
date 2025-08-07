<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions'; // Specify table name if different

    protected $fillable = [
        'order_id',
        'user_id',
        'transaction_id',
        'payment_method',
        'amount',
        'currency',
        'payment_status',
        'transaction_date',
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
    ];

    // Relationship with Order
    public function order()
    {
        return $this->belongsTo(CartOrderSummary::class, 'order_id', 'order_id');
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
