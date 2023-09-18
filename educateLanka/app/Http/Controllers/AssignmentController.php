<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\ModuleModel;
use App\Models\AssignmentModel;
use App\Models\Submission;
use Auth;
use Str;

class AssignmentController extends Controller
{
    public function index()
    {
        $data['getRecord'] = AssignmentModel::getRecord();
        return view('admin.assignment.index', $data);
    }

    public function add()
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getModule'] = ModuleModel::getModule();
        return view('admin.assignment.add', $data);
    }

    public function insert(Request $request)

    {
        $assignment = new AssignmentModel;
        $assignment->class_id = trim($request->class_id);
        $assignment->module_id = trim($request->module_id);
        $assignment->issue_date = trim($request->issue_date);
        $assignment->submission_date = trim($request->submission_date);
        $assignment->created_by = Auth::user()->id;


        if (!empty($request->file('document_file'))) {
            $ext = $request->file('document_file')->getClientOriginalExtension();
            $file = $request->file('document_file');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('C:/xampp/laravel/educateLanka/public', $filename);
            $assignment->document_file = $filename;

            $file_path = 'C:/xampp/laravel/educateLanka/public/' . $filename;
        }

        $assignment->save();

        return redirect('admin/assignment')->with('success', "Assignment Successfully created!");
    }

    public function delete($id)
    {
        $assignment = AssignmentModel::getSingle($id);
        $assignment->is_delete = 1;
        $assignment->save();

        return redirect()->back()->with('success', "Assignment sucesfully deleted!");
    }

    public function deleteSub($id)
    {
        $submission = Submission::find($id);

        if (!$submission) {
            return redirect()->back()->with('error', "Submission not found!");
        }

        // Check if the file exists and delete it from storage
        if (!empty($submission->document_file)) {
            $file_path = public_path($submission->document_file);

            if (file_exists($file_path)) {
                unlink($file_path); // Delete the file from the public directory
            }
        }

        $submission->delete();


        return redirect()->back()->with('success', "submission successfully deleted!");
    }
}
