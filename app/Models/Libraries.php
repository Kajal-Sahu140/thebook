<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libraries extends Model
{
    use HasFactory;
    protected $table = 'libraries';
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'unique_code',
        'description',
        'status',
        'image'
      
    ];
    
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
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
