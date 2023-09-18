<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassModuleModel;
use App\Models\ClassModel;
use App\Models\ModuleModel;
use App\Models\AssignmentModel;
use App\Models\classUser;
use App\Models\studentCourse;
use App\Models\User;
use Auth;
use Str;

class CourseController extends Controller
{
    public function course(Request $request)
    {

        $loggedInUserId = auth()->user()->id;

        $user = User::with('classes')->find($loggedInUserId);
        $classes = $user->classes;

        return view('student.index', compact('classes'));
    }

    public function G5_Material(Request $request)
    {
        $data['getRecord'] = ClassModuleModel::getRecord();
        return view('student.index', $data);
    }

    public function classuser()
    {
        $classusers = classUser::all();
        $classteachers = ClassModel::all();

        return view('admin.courses.index', ['classusers' => $classusers], ['classteachers' => $classteachers]);
    }


    public function classuseradd()
    {
        $classes = ClassModel::all();
        $users = User::where('account_type', 'Student')->get();
        return view('admin.courses.add', ['users' => $users], ['classes' => $classes]);
    }

    public function classuserstore(Request $request)
    {
        $classusers = classUser::all();

        $save = new classUser;
        $save->user_id = $request->user_id;
        $save->class_id = $request->class_id;
        $save->save();


        return redirect()->route('admin.classuser.index')->with('success', 'Student Added successfully.');
    }

    public function classteacheradd()
    {
        $classes = ClassModel::all();
        $users = User::where('account_type', 'Teacher')->get();
        return view('admin.courses.teacher', ['users' => $users], ['classes' => $classes]);
    }


    public function classteacherstore(Request $request)
    {

        $validatedData = $request->validate([
            'teacher_id' => 'required|integer',
            'class_id' => 'required|integer',
        ]);

        // Find the class by its ID
        $class = ClassModel::find($validatedData['class_id']);

        if (!$class) {
            return redirect()->back()->with('error', 'Class not found');
        }

        // Update the teacher_id for the selected class
        $class->teacher_id = $validatedData['teacher_id'];
        $class->save();

        return redirect()->route('admin.classuser.index')->with('success', 'Teacher Added successfully.');
    }


    public function destroy($id)
    {
        $user = classUser::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.classuser.index')->with('success', 'Student removed successfully.');
    }
}
