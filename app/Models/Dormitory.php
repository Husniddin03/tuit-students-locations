<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dormitory extends Model
{
    use HasFactory;

    protected $table = 'dormitory';

    protected $fillable = [
        'student_id',
        'dormitory',
        'room',
        'privileged',
        'amount',
    ];

    // Dormitory qaysi studentga tegishli
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
}
