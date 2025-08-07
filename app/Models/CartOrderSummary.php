<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartOrderSummary extends Model
{
    use HasFactory;
    protected $table = 'cart_order_summary';
    // Mass-assignable fields
    protected $fillable = [
        'user_id',
        'order_id',
        'total_items',
        'subtotal_price',
        'total_discount',
        'coupon_discount',
        'tax_amount',
        'order_address',
        'delivery_fee',
        'grand_total',
        'payment_status',
        'order_status',
        'coupon_code',
        'delivery_date',
        'tracking_id',
    ];

    protected $casts = [
    'delivery_date' => 'datetime',
];
    // Relationships

    /**
     * Get the user who owns this order summary.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the cart associated with this order summary.
     */
   public function cartItems()
        {
            return $this->hasMany(Cart::class, 'order_id'); // 'order_id' links this to the Cart table
        }
        public function productreturnorders()
        {
            return $this->hasMany(ProductReturnOrder::class, 'order_id'); // 'order_id' links this to the ProductReturn table
        }
        
}
