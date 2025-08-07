<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRefund extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'product_refunds';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_return_order_id',
        'refund_status',
        'refund_amount',
        'refund_comments',
    ];

    /**
     * Get the associated product return order.
     */
    public function productReturnOrder()
    {
        return $this->belongsTo(ProductReturnOrder::class, 'product_return_order_id');
    }
}
