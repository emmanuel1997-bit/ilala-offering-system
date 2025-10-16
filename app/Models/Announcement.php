<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'category',
        'image_url',
        'publish_date',
        'expiry_date',
        'is_published',
        'created_by',
    ];

    protected $casts = [
        'publish_date' => 'datetime',
        'expiry_date' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
