<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class studentCourse extends Model
{
    use HasFactory;
    protected $table = 'student_course';

    protected $fillable = [
        'student_id',
        'course_id',


    ];

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'course_id', 'id');
    }
}
