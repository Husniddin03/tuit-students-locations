<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'province',
        'region',
        'address',
        'map_rent',
        'latitude',
        'longitude',
        'owner_name',
        'owner_phone',
        'category',
        'contract',
        'amount',
        'type',
    ];

    // Rent qaysi studentga tegishli
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
}
