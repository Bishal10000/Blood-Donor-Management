<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodAvailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'health_post',
        'province',
        'district',
        'municipality',
        'address',
        'blood_group',
        'available_units',
        'contact',
    ];
}
