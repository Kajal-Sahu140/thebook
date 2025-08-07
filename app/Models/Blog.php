<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $table = 'blogs';
    protected $fillable = [
        'author',
        'title',
        'title_ar',
        'description_ar',
        'title_cku',
        'description_cku',
        'description',
        'image',
        'status',
    ];
    public function getImageAttribute($value)
    {
        // dd($value);
       return $value ? url('storage/app/public/' . $value) : null;
    }
}
