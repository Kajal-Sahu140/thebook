<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;
    protected $table = 'contactus';
    protected $fillable = [
        'user_id',
        'name',
        'subject',
        'email',
        'description',
        'replay',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
