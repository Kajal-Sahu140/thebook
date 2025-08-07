<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    // Table name (optional, only if Laravel doesn't pluralize it correctly)
    protected $table = 'cart';

    // Attributes that can be mass-assigned
    protected $fillable = [
        'user_id',
        'order_id',
        'product_sku',
        'product_color',
        'product_size',
        'quantity',
        'price',
        'orderplace',
        'total_price',
        'coupon_code',
        'order_status'
    ];

    // Attributes that should be cast
    protected $casts = [
        'price' => 'decimal:2',        // Casts the price field as a decimal with 2 decimal places
        'total_price' => 'decimal:2', // Casts the total_price field as a decimal with 2 decimal places
        'order_status' => 'string',   // Casts the order_status field as a string
    ];

    // Define the relationship to the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define the relationship to the Product model
    public function product()
    {
        return $this->hasOne(Product::class, 'sku', 'product_sku');
    }
    public function cartOrderSummary()
{
    return $this->belongsTo(CartOrderSummary::class, 'order_id');
}
public function productReturn()
{
    return $this->belongsTo(ProductReturnOrder::class, 'order_id');
}
public function color()
{
    return $this->belongsTo(Color::class, 'product_color');
}
public function size()
{
    return $this->belongsTo(Size::class, 'product_size');
}
}

