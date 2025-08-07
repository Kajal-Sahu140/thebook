<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;
    
    // Disable timestamps for this model
    public $timestamps = false;

    protected $table = 'otps';  // Explicitly define table name if needed

    protected $fillable = [
        'type',
        'value',
        'user_id',
        'models_type',
    ];

    // Relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with Admin model (if applicable)
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function isExpired()
    {
        // Compare the current time with the expires_at timestamp
        return now()->gt($this->expires_at);
    }
}
