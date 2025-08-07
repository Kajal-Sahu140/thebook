<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'house_number',
        'street_name',
        'landmark',
        'city',
        'address',
        'name',
        'country_code',
        'country',
        'zip_code',
        'mobile_number',
        'make_as_default',
    ];

    /**
     * Relationships.
     */

    // Each address belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
