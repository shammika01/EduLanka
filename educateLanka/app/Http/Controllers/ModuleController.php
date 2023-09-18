<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use Illuminate\Http\Request;
use App\Models\ModuleModel;
use Auth;

class ModuleController extends Controller
{
    public function index()
    {
        $data['getRecord'] = ModuleModel::getRecord();
        return view('admin.module.index', $data);
    }
    public function add()
    {
        return view('admin.module.add');
    }
    public function insert(Request $request)
    {
        $save = new ModuleModel;
        $save->name = trim($request->name);
        $save->type = trim($request->type);
        $save->course_id = trim($request->course_id);
        $save->status = trim($request->status);
        $save->created_by = Auth::user()->id;
        $save->save();

        return redirect('admin/module')->with('success', "Module Successfully created!");
    }
    public function edit($id)
    {
        $data['getRecord'] = ModuleModel::getSingle($id);
        if (!empty($data['getRecord'])) {
            return view('admin.module.edit', $data);
        } else {
            abort(404);
        }
    }


    public function update($id, Request $request)
    {
        $save = ModuleModel::getSingle($id);
        $save->name = trim($request->name);
        $save->course_id = trim($request->course_id);

        $save->type = trim($request->type);
        $save->status = trim($request->status);
        $save->save();

        return redirect('admin/module')->with('success', 'Module Successfully updated!');
    }
    public function delete($id)
    {
        $save = ModuleModel::getSingle($id);
        $save->is_delete = 1;
        $save->save();

        return redirect()->back()->with('success', 'Module Successfully Disabled!');
    }

    public function view(Request $request)
    {
        $authenticatedUserId = Auth::user()->id;
        $courseId = $request->input('course_id');

        $modules = ModuleModel::where('course_id', $courseId)->get();


        $value = ClassModel::where('teacher_id', $authenticatedUserId)->get();
        return view('teacher.module.index',  ['modules' => $modules]);
    }

    public function viewstudent(Request $request)
    {
        $authenticatedUserId = Auth::user()->id;
        $courseId = $request->input('course_id');

        $modules = ModuleModel::where('course_id', $courseId)->get();


        $value = ClassModel::where('teacher_id', $authenticatedUserId)->get();
        return view('student.module.index',  ['modules' => $modules]);
    }
}
