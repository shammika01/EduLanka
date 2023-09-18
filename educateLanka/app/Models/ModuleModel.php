<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuleModel extends Model
{
    use HasFactory;


    protected $table = 'module';
    protected $fillable = [
        'course_id',

    ];



    static public function getSingle($id)
    {
        return self::find($id);
    }

    static public function getRecord()
    {
        $return = ModuleModel::select('module.*', 'users.name as created_by_name')
            ->join('users', 'users.id', 'module.created_by')->where('module.is_delete', '=', 0)->orderBy('module.id', 'desc')->paginate(20);

        return $return;
    }
    static public function getModule()
    {
        $return = ModuleModel::select('Module.*')
            ->join('users', 'users.id', 'module.created_by')
            ->where('module.is_delete', '=', 0)
            ->where('module.status', '=', 0)
            ->orderBy('module.name', 'asc')
            ->get();

        return $return;
    }
}
