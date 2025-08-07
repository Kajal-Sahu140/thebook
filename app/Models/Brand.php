<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'name_ar',
        'name_cku',
        'description',
        'description_ar',
        'description_cku',
        'image',
        'image_ar',

        'image_cku',
        'status',
    ];
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    // public function getImageAttribute($value)
    // {
    //     return $value ? url('/storage/app' . $value) : "https://www.shutterstock.com/image-vector/default-avatar-profile-icon-vector-260nw-1706867365.jpg";
    // }
    // public function getImageArAttribute($value)
    // {
    //     return $value ? url('/storage/' . $value) : "https://www.shutterstock.com/image-vector/default-avatar-profile-icon-vector-260nw-1706867365.jpg";
    // }
    // public function getImageCkuAttribute($value)
    // {
    //     return $value ? url('/storage/' . $value) : "https://www.shutterstock.com/image-vector/default-avatar-profile-icon-vector-260nw-1706867365.jpg";
    // }
}
