<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'description',
        'amount',
        'date_incurred',
        'payment_method',
        'transaction_reference',
        'receipt_number',
        'account_name',
        'account_number',
        'bank_name',
        'is_verified',
        'ministry_id',
        'recorded_by',
    ];

    protected $casts = [
        'date_incurred' => 'date',
        'is_verified' => 'boolean',
    ];

    public function ministry()
    {
        return $this->belongsTo(Ministry::class);
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
