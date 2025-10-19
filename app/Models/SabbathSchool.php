<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SabbathSchool extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'division',
        'description',
        'meeting_location',
        'meeting_time',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function members()
    {
        return $this->belongsToMany(Member::class, 'sabbath_schools_has_members')
                    ->withPivot('role')
                    ->withTimestamps();
    }
}
