<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class ClassModuleModel extends Model
{
    use HasFactory;

    protected $table = 'class_module';

    static public function getSingle($id)
    {
        return self::find($id);
    }
    static public function getRecord()
    {
        return self::select('class_module.*', 'class.name as class_name', 'module.name as module_name', 'users.name as created_by_name')
        ->join('module', 'module.id', '=', 'class_module.module_id')
        ->join('class', 'class.id', '=', 'class_module.class_id')
        ->join('users', 'users.id', '=', 'class_module.created_by')
        ->where('class_module.is_delete', '=', 0)
        ->orderBy('class_module.id', 'desc')
        ->paginate(20);
    }

    static public function getAlreadyFirst($class_id, $module_id)
    {
        return self::where('class_id', '=', $class_id)->where('module_id', '=', $module_id)->first();
    }

    static public function getAssignedModuleID($class_id)
    {
        return self::where('class_id'. '=', $class_id)->where('is_delete', '=', 0)->get();
    }
}
