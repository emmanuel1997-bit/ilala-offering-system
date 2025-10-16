<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'source_name',
        'source_contact',
        'amount',
        'date_received',
        'payment_method',
        'transaction_reference',
        'receipt_number',
        'account_name',
        'account_number',
        'bank_name',
        'is_verified',
        'verified_by',
        'recorded_by',
    ];

    protected $casts = [
        'date_received' => 'date',
        'is_verified' => 'boolean',
    ];

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
