<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forget extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'messeng',
        'status'
    ];

    // Rent qaysi studentga tegishli
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
}
