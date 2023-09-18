<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'class';
    protected $fillable = [
        'teacher_id',

    ];


    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getRecord()
    {
        $return = ClassModel::select('class.*', 'users.name as created_by_name')
            ->join('users', 'users.id', 'class.created_by')->where('class.is_delete', '=', 0)->orderBy('class.id', 'desc')->paginate(20);

        return $return;
    }

    static public function getClass()
    {
        $return = ClassModel::select('class.*')
            ->join('users', 'users.id', 'class.created_by')
            ->where('class.is_delete', '=', 0)
            ->where('class.status', '=', 0)
            ->orderBy('class.name', 'asc')
            ->get();

        return $return;
    }

    public function studentCourses()
    {
        return $this->hasMany(studentCourse::class, 'course_id', 'id');
    }
}
