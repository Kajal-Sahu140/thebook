<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $table = 'templates'; // Specify table name if different

    protected $fillable = [
        'description',
        
    ];

   

    // Relationship with Order
  
    // Relationship with User

}
