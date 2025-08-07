<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReturnOrder extends Model
{
    use HasFactory;
    protected $table = 'product_return_orders';
    protected $fillable = [
        'order_id',
        'product_id',
        'user_id',
        'reason_id',
        'return_status',
        'return_comments',
    ];
    public function order()
    {
        return $this->belongsTo(CartOrderSummary::class, 'order_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function reason()
    {
        return $this->belongsTo(ReturnReason::class, 'reason_id');
    }
    public function refund()
    {
        return $this->hasOne(ProductRefund::class, 'product_return_order_id');
    }
}
