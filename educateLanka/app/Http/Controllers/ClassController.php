<?php

namespace App\Http\Controllers;

use App\Models\AssignmentModel;
use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\User;
use Auth;

class ClassController extends Controller
{

    public function index()
    {
        $data['getRecord'] = ClassModel::getRecord();
        return view('admin.class.index', $data);
    }
    public function add()
    {
        return view('admin.class.add');
    }
    public function insert(Request $request)
    {
        $save = new ClassModel;
        $save->name = $request->name;
        $save->teacher_id = $request->teacher_id;
        $save->status = $request->status;
        $save->created_by = Auth::user()->id;
        $save->save();

        return redirect('admin/class')->with('success', "Class Successfully created!");
    }

    public function edit($id)
    {
        $data['getRecord'] = ClassModel::getSingle($id);
        if (!empty($data['getRecord'])) {
            return view('admin.class.edit', $data);
        } else {
            abort(404);
        }
    }

    public function update($id, Request $request)
    {
        $save = ClassModel::getSingle($id);
        $save->name = $request->name;
        $save->teacher_id = $request->teacher_id;
        $save->status = $request->status;
        $save->save();

        return redirect('admin/class')->with('success', 'Class Successfully updated!');
    }

    public function delete($id)
    {
        $save = ClassModel::getSingle($id);
        $save->is_delete = 1;
        $save->save();

        return redirect()->back()->with('success', 'Class Successfully Disabled!');
    }

    public function view()
    {
        $authenticatedUserId = Auth::user()->id;

        $value = ClassModel::where('teacher_id', $authenticatedUserId)->get();
        return view('teacher.class.index', ['value' => $value]);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'class_user', 'class_id', 'user_id');
    }
}
