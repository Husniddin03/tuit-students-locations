<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentPassword extends Model
{
    use HasFactory;
    protected $table = 'student_passwrod';

    protected $fillable = [
        'student_id',
        'password',
    ];

   public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
}
