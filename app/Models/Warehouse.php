<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Use this class instead of Model
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Warehouse extends Authenticatable // Change Model to Authenticatable
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'warehouse';

    // Define the fillable attributes
    protected $fillable = [
        'name',
        'email',
        'image',
        'status',
        'email_verified_at',
        'dummy_password',
        'password',
    ];

    // Define the hidden attributes (optional, for example, to hide the password from array or JSON output)
    protected $hidden = [
        'password',
    ];

    // Define the date attributes for automatic casting (for example, for the `email_verified_at`)
    protected $dates = [
        'email_verified_at',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'status' => 'string',
    ];
}
