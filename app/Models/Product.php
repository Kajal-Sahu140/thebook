<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    use HasFactory;
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'product_name',
        'product_name_ar',
        'product_name_cku', 
        'description', 
        'description_ar',
        'description_cku',
        'sku',
        'warehouse_id',
        'base_price', 
        'brand_id', 
        'category_id', 
        'sub_category_id',
        'quantity',       // New field
        'discount',  
        'status',
        'language',
        'type',
        'product_type'
        
        // New field
    ];
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
    
    public function variants()
{
    return $this->hasMany(ProductVariant::class, 'product_id', 'product_id');
}
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function subCategory()
    {
        return $this->belongsTo(Category::class, 'sub_category_id');
    }

    public function getImageUrlsAttribute()
    {
        return $this->images->pluck('image_url')->toArray();
    }
    public function getFirstImageUrlAttribute()
    {
        return $this->images()->exists()
            ? asset('storage/' . $this->images()->first()->image_url)
            : "https://dummyimage.com/16:9x1080/";
    }

    public function offers()
    {
        return $this->hasMany(ProductOffer::class, 'product_id', 'product_id');
    }
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'product_id', 'product_id');
    }
    public function cart()
    {
        return $this->hasMany(Cart::class, 'product_sku', 'product_sku');
    }
    public function cartOrderSummary(){
        return $this->hasMany(CartOrderSummary::class, 'product_sku', 'product_sku');
    }
   public function productReturnOrders(){
        return $this->hasMany(ProductReturnOrder::class, 'product_id', 'product_id');
    }
    public function productRatings(){
        return $this->hasMany(ProductRating::class, 'product_id', 'product_id');
    }
    public function reviews()
{
    return $this->hasMany(ProductRating::class, 'product_id', 'product_id');
}

}
