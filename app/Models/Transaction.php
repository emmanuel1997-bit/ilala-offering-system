<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'stewardships_id',
        'contribution_type_id',
    ];


    public function stewardship()
    {
        return $this->belongsTo(Stewardship::class, 'stewardships_id');
    }


    public function contributionType()
    {
        return $this->belongsTo(ContributionType::class, 'contribution_type_id');
    }
}
