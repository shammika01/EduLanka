<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassModuleModel;
use App\Models\ClassModel;
use App\Models\ModuleModel;
use Auth;

class ClassModuleController extends Controller
{
    public function index(Request $request)
    {
        $data['getRecord'] = ClassModuleModel::getRecord();
        return view('admin.cls_module.index', $data);
    }

    public function add(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getModule'] = ModuleModel::getModule();
        return view('admin.cls_module.add',  $data);
    }

    public function insert(Request $request)
    {
        if (!empty($request->module_id)) {
            foreach ($request->module_id as $module_id) {
                $getAlreadyFirst = ClassModuleModel::getAlreadyFirst($request->class_id, $module_id);
                if (!empty($getAlreadyFirst)) {
                    $getAlreadyFirst->status = $request->status;
                    $getAlreadyFirst->save();
                } else {
                    $save = new ClassModuleModel;
                    $save->class_id = $request->class_id;
                    $save->module_id = $module_id;
                    $save->status = $request->status;
                    $save->created_by = Auth::user()->id;
                    $save->save();
                }
            }
            return redirect('admin/cls_module/add')->with('success', "Module Successfully selected!");
        } else {
            return redirect()->back()->with('error', 'Error Try again');
        }
    }

    public function edit($id) //error occuring need to check
    {
        $getRecord = ClassModuleModel::getSingle($id);
        if (!empty($getRecord)) {
            $data['getRecord'] = $getRecord;
            $data['getAssignedModuleID'] = ClassModuleModel::getAssignedModuleID($getRecord->class_id);
            $data['getClass'] = ClassModel::getClass();
            $data['getModule'] = ModuleModel::getModule();
            return view('admin.cls_module.edit',  $data);
        } else {
            abort(404);
        }
    }

    public function delete($id)
    {
        $save = ClassModuleModel::getSingle($id);
        $save->is_delete = 1;
        $save->save();

        return redirect()->back()->with('success', 'Set successfully Deleted!');
    }


    public function student(Request $request)
    {
        $data['getRecord'] = ClassModuleModel::getRecord();
        return view('student.index', $data);
    }
}
