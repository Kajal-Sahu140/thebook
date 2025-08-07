<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    // Specify the table if it's not the plural form of the model name
    protected $table = 'product_images';
protected $primaryKey = 'image_id';
    // Define fillable fields for mass assignment
    protected $fillable = ['product_id', 'image_url'];

    /**
     * Define the relationship with the Product model.
     * Each product image belongs to one product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Accessor for the `image_url` attribute.
     * Automatically prepend the storage URL if the image exists, otherwise return a default placeholder.
     */
    public function getImageUrlAttribute($value)
    {
        if ($value) {
            return url('storage/app/public/' . $value); // Ensure the image is fetched from the correct storage location
        }

        // Return default image URL if no image is provided
        return "https://www.shutterstock.com/image-vector/default-avatar-profile-icon-vector-260nw-1706867365.jpg";
    }
   
}
