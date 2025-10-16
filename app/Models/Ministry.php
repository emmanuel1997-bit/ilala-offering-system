<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ministry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'abbreviation',
        'category',
        'theme',
        'location',
        'mission_statement',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function members()
    {
        return $this->belongsToMany(Member::class, 'ministries_has_leader')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
}
