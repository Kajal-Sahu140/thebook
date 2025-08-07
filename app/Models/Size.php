<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    use HasFactory;

    protected $table = 'sizes'; // Assuming your sizes table is named 'sizes'

    protected $fillable = ['name','name_ar','name_cku', 'value']; // Adjust columns based on your table structure

    // Relationship with ProductVariant
    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'size');
    }
}
