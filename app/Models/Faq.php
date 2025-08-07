<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    protected $table = 'faqs';
    protected $fillable = [
        'question',
        'question_ar',
        'question_cku',
        'answer',
        'answer_ar',
        'answer_cku',
        'status',
        'category',
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
