<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'phone_number',
        'email',
        'membership_number',
        'dob',
        'gender',
        'membership_status',
        'baptism_status',
        'pin',
        'pin_status',
        'baptism_date',
        'marital_status',
        'address',
        'photo',
        'is_active',
    ];

    protected $casts = [
        'dob' => 'date',
        'baptism_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function ministries()
    {
        return $this->belongsToMany(Ministry::class, 'ministries_has_leader')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    public function sabbathSchools()
    {
        return $this->belongsToMany(SabbathSchool::class, 'sabbath_schools_has_members')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    public function stewardships()
    {
        return $this->hasMany(Stewardship::class);
    }
}
