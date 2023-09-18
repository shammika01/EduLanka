<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Str;

class AssignmentModel extends Model
{
    use HasFactory;

    protected $table = 'assignment1';


    static public function getSingle($id)
    {
        return self::find($id);
    }
    static public function getRecord()
    {
        $return = AssignmentModel::select('assignment1.*', 'class.name as class_name', 'module.name as module_name')
            ->join('users', 'users.id', '=', 'assignment1.created_by')
            ->join('class', 'class.id', '=', 'assignment1.class_id')
            ->join('module', 'module.id', '=', 'assignment1.module_id')
            ->orderBy('assignment1.id', 'desc')
            ->paginate(20);

        return $return;
    }

    public function getDocument()
    {
        if (!empty($this->document_file) && file_exists('D:/educateLanka/upload/assignment/' . $this->document_file)) {
            return url('D:/educateLanka/upload/assignment/' . $this->document_file);
        } else {
            return "";
        }
    }

    public function assignmentClass()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function assignmentModule()
    {
        return $this->belongsTo(ModuleModel::class, 'module_id');
    }
}
