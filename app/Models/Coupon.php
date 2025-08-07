<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    // Specify the table name if different from the default 'coupons'
    protected $table = 'coupons';

    // Define the primary key if different from the default 'id'
    protected $primaryKey = 'coupon_id';

    // Define the attributes that are mass assignable
    protected $fillable = [
        'coupon_code',
        'code_format',
        'usage_limit_per_coupon',
        'usage_limit_per_customer',
        'start_date',
        'end_date',
        'discount_type',
        'discount_value',
        'min_purchase_amount',
        'max_discount_amount',
        'used_count',
    ];

    // Define date attributes for Carbon instances
    protected $dates = [
        'start_date',
        'end_date',
        'created_at',
        'updated_at',
    ];
}
