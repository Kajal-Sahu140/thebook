<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'name_ar',
        'name_cku',
        'warehouse_id',
        'description',
        'description_ar',
        'description_cku',
        'category_id',
        'image',
        'image_ar',
        'image_cku',
        'status',
    ];
    public function parent()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function subcategories()
    {
        return $this->hasMany(Category::class, 'category_id');
    }
    public function getImageAttribute($value)
    {
        return $value ? url('/storage/app/public/' . $value) : "https://www.shutterstock.com/image-vector/default-avatar-profile-icon-vector-260nw-1706867365.jpg";
    }
    public function getImageArAttribute($value)
    {
        return $value ? url('/storage/app/public/' . $value) : "https://www.shutterstock.com/image-vector/default-avatar-profile-icon-vector-260nw-1706867365.jpg";
    }
    public function getImageCkuAttribute($value)
    {
        return $value ? url('/storage/app/public/' . $value) : "https://www.shutterstock.com/image-vector/default-avatar-profile-icon-vector-260nw-1706867365.jpg";
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }   
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
    ////////////////////////////////////////////////////
}
