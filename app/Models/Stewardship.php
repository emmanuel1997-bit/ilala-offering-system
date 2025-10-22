<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stewardship extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'amount',
        'payment_method',
        'transaction_reference',
        'total_amount',
        'attachment_image_url',
        'description',
        'is_verified',
        'verified_by',
        'recorded_by',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    // Relationships
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'stewardships_id');
    }
}
