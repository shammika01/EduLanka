<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClassModel;
use App\Models\ModuleModel;
use App\Models\AssignmentModel;
use App\Models\Submission;
use Auth;
use Str;

class TeachAssignmentController extends Controller
{
    public function index()
    {
        $data['getRecord'] = AssignmentModel::getRecord();
        return view('teacher.index', $data);
    }

    public function view()
    {
        $authenticatedUserId = Auth::user()->id;

        $assignments = AssignmentModel::where('teacher_id', $authenticatedUserId)->get();
        return view('teacher.class.index', ['assignments' => $assignments]);
    }

    public function add(Request $request)
    {
        $data['getClass'] = ClassModel::getClass();
        $data['getModule'] = ModuleModel::getModule();

        $authenticatedUserId = Auth::user()->id;
        $moduleID = $request->input('module_id');

        $assignments = AssignmentModel::where('module_id', $moduleID)->get();


        $value = ClassModel::where('teacher_id', $authenticatedUserId)->get();

        return view('teacher.assignment.add', $data, ['assignments' => $assignments]);
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
        }

        $assignment->save();

        return redirect('teacher/view')->with('success', "Assignment Successfully created!");
    }

    public function delete($id)
    {
        $assignment = AssignmentModel::getSingle($id);
        $assignment->is_delete = 1;
        $assignment->save();

        return redirect()->back()->with('success', "Assignment sucesfully deleted!");
    }

    public function viewassignment(Request $request)
    {
        $authenticatedUserId = Auth::user()->id;
        $moduleID = $request->input('module_id');

        $assignments = AssignmentModel::where('module_id', $moduleID)->get();


        $value = ClassModel::where('teacher_id', $authenticatedUserId)->get();
        return view('teacher.assignment.index',  ['assignments' => $assignments]);
    }

    public function viewassignmentstudent(Request $request)
    {
        $authenticatedUserId = Auth::user()->id;
        $moduleID = $request->input('module_id');

        $assignments = AssignmentModel::where('module_id', $moduleID)->get();


        $value = ClassModel::where('teacher_id', $authenticatedUserId)->get();
        return view('student.assignment.index',  ['assignments' => $assignments]);
    }


    public function submit(Request $request)

    {
        $authenticatedUserId = Auth::user()->id;

        $submission = new Submission();
        $submission->user_id = trim($authenticatedUserId);
        $submission->module_id = trim($request->module_id);
        $submission->assignment_id = trim($request->assignment_id);



        if (!empty($request->file('document_file'))) {
            $ext = $request->file('document_file')->getClientOriginalExtension();
            $file = $request->file('document_file');
            $randomStr = date('Ymdhis') . Str::random(20);
            $filename = strtolower($randomStr) . '.' . $ext;
            $file->move('C:/xampp/laravel/educateLanka/public', $filename);
            $submission->document_file = $filename;
        }

        $submission->save();

        return redirect()->back()->with('success', "Assignment Successfully submitted!");
    }


    public function viewSubmissions()
    {
        $authenticatedUserId = auth()->user()->id;

        $submissions = Submission::where('user_id', $authenticatedUserId)
            ->select('module_id', \DB::raw('COUNT(*) as submission_count'))
            ->groupBy('module_id')
            ->get();

        $assignmentCounts = AssignmentModel::select('module_id', \DB::raw('COUNT(*) as assignment_count'))
            ->groupBy('module_id')
            ->get();

        return view('progress.index', ['submissions' => $submissions], ['assignmentCounts' => $assignmentCounts]);
    }


    public function viewSubmissions2(Request $request)
    {
        $user_id = $request->input('user_id');

        // Retrieve the count of submissions for the entered user ID
        $submissions = Submission::where('user_id', $user_id)
            ->select('module_id', \DB::raw('COUNT(*) as submission_count'))
            ->groupBy('module_id')
            ->get();

        // Retrieve the count of entries from the assignment1 table for each module
        $assignmentCounts = AssignmentModel::select('module_id', \DB::raw('COUNT(*) as assignment_count'))
            ->groupBy('module_id')
            ->get();

        return view('progress.index', [
            'submissions' => $submissions,
            'assignmentCounts' => $assignmentCounts,
            'user_id' => $user_id, // Pass the user_id to the view
        ]);
    }


    public function viewSubmissions3(Request $request)
    {
        $module_id = $request->input('module_id');

        // Retrieve the count of submissions for the entered user ID
        $submissions = Submission::where('module_id', $module_id)
            ->get();


        // Retrieve the count of entries from the assignment1 table for each module
        $assignmentCounts = AssignmentModel::select('module_id', \DB::raw('COUNT(*) as assignment_count'))
            ->groupBy('module_id')
            ->get();

        return view('submissions.teacher', [
            'submissions' => $submissions,
            'assignmentCounts' => $assignmentCounts,
            'module_id' => $module_id, // Pass the user_id to the view
        ]);
    }

    public function viewSubmissions5(Request $request)
    {
        $module_id = $request->input('module_id');

        // Retrieve the count of submissions for the entered user ID
        $submissions = Submission::where('module_id', $module_id)
            ->get();


        // Retrieve the count of entries from the assignment1 table for each module
        $assignmentCounts = AssignmentModel::select('module_id', \DB::raw('COUNT(*) as assignment_count'))
            ->groupBy('module_id')
            ->get();

        return view('admin.submissions.admin', [
            'submissions' => $submissions,
            'assignmentCounts' => $assignmentCounts,
            'module_id' => $module_id, // Pass the user_id to the view
        ]);
    }

    public function viewSubmissions4(Request $request)
    {
        $user_id = auth()->user()->id;

        // Retrieve the count of submissions for the entered user ID
        $submissions = Submission::where('user_id', $user_id)
            ->get();


        // Retrieve the count of entries from the assignment1 table for each module

        return view('submissions.student', [
            'submissions' => $submissions,
            'user_id' => $user_id, // Pass the user_id to the view
        ]);
    }
}
