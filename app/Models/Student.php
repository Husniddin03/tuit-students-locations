<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'first_name',
        'last_name',
        'middle_name',
        'faculty',
        'group',
        'phone',
        'coach',
        'father',
        'mather',
        'province',
        'region',
        'address',
        'father_phone',
        'mather_phone',
        'map_home',
        'latitude',
        'longitude',
    ];

    // Bitta studentga bitta dormitory yoki rent bo‘lishi mumkin
    public function dormitory()
    {
        return $this->hasOne(Dormitory::class, 'student_id', 'student_id');
    }

    public function rent()
    {
        return $this->hasOne(Rent::class, 'student_id', 'student_id');
    }

    public function student_password()
    {
        return $this->hasOne(StudentPassword::class, 'student_id', 'student_id');
    }
    public function forget()
    {
        return $this->hasOne(Forget::class, 'student_id', 'student_id');
    }
}
