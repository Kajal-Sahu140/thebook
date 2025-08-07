<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;

    protected $table = 'colors'; // Assuming your colors table is named 'colors'

    protected $fillable = ['name', 'code']; // Adjust columns based on your table structure

    // Relationship with ProductVariant
    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'color');
    }
}
