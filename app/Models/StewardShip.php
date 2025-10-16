<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stewardship extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'type',
        'other_description',
        'amount',
        'date_given',
        'payment_method',
        'transaction_reference',
        'receipt_number',
        'tithe_amount',
        'iof_offering_amount',
        'campmeeting_amount',
        'total_conference_amount',
        'church_offering_amount',
        'church_construction_amount',
        'mission_offering_amount',
        'other_amount',
        'total_church_amount',
        'total_amount',
        'notes',
        'is_verified',
        'verified_by',
        'recorded_by',
    ];

    protected $casts = [
        'date_given' => 'date',
        'is_verified' => 'boolean',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
