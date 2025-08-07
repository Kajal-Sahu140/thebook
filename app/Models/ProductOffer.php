<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOffer extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'product_offers';

    // Define the fillable fields for mass assignment
   protected $fillable = [
    'offer_title', 'product_id', 'offer_type', 'discount_value', 
    'description', 'banner_link', 'image', 'status', 'start_date', 'end_date'
];
    // Define the relationship with Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    /**
     * Accessor for image URL
     * Returns a full URL for the stored image.
     */
    public function getImageAttribute($value)
    {
        return $value ? url('/storage/' . $value) : "https://www.shutterstock.com/image-vector/default-avatar-profile-icon-vector-260nw-1706867365.jpg";
    }
}
