<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    use HasFactory;

    // Specify the table name if it doesn't follow Laravel's naming convention
    protected $table = 'pages';

    // Specify the fields that can be mass-assigned
    protected $fillable = [
        'title',
        'title_ar',
        'title_cku',
        'slug',
        'description',
        'description_ar',
        'description_cku',
        'image',
        'status',
    ];
    // Optionally, you can specify the date fields for automatic handling by Eloquent
    protected $dates = ['created_at', 'updated_at'];
    // You can define any relationships here (if needed)
    // Example: One-to-many or many-to-many relationships, etc.
}
