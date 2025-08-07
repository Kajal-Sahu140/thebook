<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $table = 'banners';

    protected $fillable = [
        'title',
        'description',
        'web_banner_image',
        'app_banner_image',
        'discount',
        'category_id',
        'position',
        'banner_link',
        'status',
        'start_date',
        'end_date',
        'click_status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope to filter active banners.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Check if the banner is an image.
     */
    public function isImage()
    {
        return $this->type === 'image';
    }

    /**
     * Check if the banner is a video.
     */
    public function isVideo()
    {
        return $this->type === 'video';
    }

    /**
     * Accessor for Web Banner Image URL.
     */
    public function getWebBannerImageAttribute($value)
    {
        return $value ? url('storage/app/public/' . $value) : null;
    }

    /**
     * Accessor for App Banner Image URL.
     */
    public function getAppBannerImageAttribute($value)
    {
        return $value ? url('storage/app/public/' . $value) : null;
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
