<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRating extends Model
{
    use HasFactory;

    // Define the table name (optional if it's the default plural of the model name)
    protected $table = 'product_ratings';

    // Define the primary key if it's not the default 'id'
    protected $primaryKey = 'id';

    // Define the fillable attributes to allow mass assignment
    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'review',
        'order_id'
    ];

    // Disable the timestamps if you do not have `created_at` and `updated_at` columns
    public $timestamps = true;

    // Define relationships (if applicable)

    /**
     * Relationship: A product rating belongs to a product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Relationship: A product rating belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
