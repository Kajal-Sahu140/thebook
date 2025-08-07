<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // For soft deletes (if needed)
use Laravel\Sanctum\HasApiTokens; // Import the trait


class User extends Authenticatable
{
    use HasFactory, SoftDeletes, HasApiTokens; // Add HasApiTokens here

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone',
        'name',
        'whatsapp',
        'email',
        'phone_verified_at',
        'country_code',
        'whatsapp_country_code',
        'fcm_token',
        'remember_token',
        'status',
        'device_type',
        'deleted_at',
        'lang',
          'password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
      protected $hidden = [
        'password',
        'remember_token',
    ];
    
    protected $casts = [
        'deleted_at' => 'date',
        'status' => 'string',
        'device_type' => 'string',
        'password' => 'hashed',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
   protected $dates = ['deleted_at', 'phone_verified_at'];

    /**
     * Get the profile associated with the user.
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
    
}
