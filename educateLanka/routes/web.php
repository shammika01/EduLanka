<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ClassModuleController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\TeachAssignmentController;
use App\Http\Controllers\CourseController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});
Route::get('/redirects', [HomeController::class, "index"]);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');



require __DIR__ . '/auth.php';

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
// Route for listing all users
Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');

// Route for displaying the user edit form
Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');

// Route for updating user details
Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');

// Route for deleting a user
Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');


//---------------------------------

// class con
Route::get('/admin/class', [ClassController::class, 'index'])->name('admin.class.index');
Route::get('/dropdown-menu', [UserController::class, 'dropdownMenu'])->name('dropdown');


// add class
Route::get('/admin/class/add', [ClassController::class, 'add'])->name('admin.class.add');
Route::post('/admin/class/add', [ClassController::class, 'insert']);

Route::get('/admin/course/index', [CourseController::class, 'classuser'])->name('admin.classuser.index');
Route::get('/admin/course/add', [CourseController::class, 'classuseradd'])->name('admin.classuser.add');
Route::post('/admin/course/add', [CourseController::class, 'classuserstore'])->name('admin.classuser.add');
Route::delete('/admin/courseusers/{id}', [CourseController::class, 'destroy'])->name('admin.courseuser.destroy');


Route::get('/admin/class-teacher/add', [CourseController::class, 'classteacheradd'])->name('admin.classteacher.add');
Route::post('/admin/class-teacher/add', [CourseController::class, 'classteacherstore'])->name('admin.classteacher.add');




// edit/delete class
Route::get('/admin/class/edit/{id}', [ClassController::class, 'edit']);
Route::post('/admin/class/edit/{id}', [ClassController::class, 'update']);
Route::get('/admin/class/delete/{id}', [ClassController::class, 'delete']);


//---------------------------------

// Module con
Route::get('/admin/module', [ModuleController::class, 'index'])->name('admin.module.index');

// add class
Route::get('/admin/module/add', [ModuleController::class, 'add'])->name('admin.module.add');
Route::post('/admin/module/add', [ModuleController::class, 'insert']);

// edit/delete class
Route::get('/admin/module/edit/{id}', [ModuleController::class, 'edit']);
Route::post('/admin/module/edit/{id}', [ModuleController::class, 'update']);
Route::get('/admin/module/delete/{id}', [ModuleController::class, 'delete']);


//---------------------------------

// Class_Module con
Route::get('/admin/cls_module', [ClassModuleController::class, 'index'])->name('admin.cls_module.index');

// add Class_Module
Route::get('/admin/cls_module/add', [ClassModuleController::class, 'add'])->name('admin.cls_module.add');
Route::post('/admin/cls_module/add', [ClassModuleController::class, 'insert']);

// edit/delete Class_Module
Route::get('/admin/cls_module/edit/{id}', [ClassModuleController::class, 'edit']);
Route::post('/admin/cls_module/edit/{id}', [ClassModuleController::class, 'update']);
Route::get('/admin/cls_module/delete/{id}', [ClassModuleController::class, 'delete']);

//-------------------------------------

//assignments
Route::get('/admin/assignment', [AssignmentController::class, 'index'])->name('admin.assignment.index');

Route::get('/admin/assignment/add', [AssignmentController::class, 'add'])->name('admin.assignment.add');
Route::post('/admin/assignment/add', [AssignmentController::class, 'insert']);
Route::get('/admin/assignment/delete/{id}', [AssignmentController::class, 'delete']);
Route::get('/admin/submissions/delete/{id}', [AssignmentController::class, 'deleteSub'])->name('submission.delete');
Route::get('/admin/submissions', [TeachAssignmentController::class, 'viewSubmissions5'])->name('admin.submissions');
Route::post('/admin/submissions', [TeachAssignmentController::class, 'viewSubmissions5'])->name('admin.submissions');


Route::get('/teacher/index', [TeachAssignmentController::class, 'index'])->name('teacher.index');
Route::get('/teacher/view', [ClassController::class, 'view'])->name('teacher.class.index');
Route::get('/teacher/modules', [ModuleController::class, 'view'])->name('teacher.module.index');
Route::get('/teacher/assignments', [TeachAssignmentController::class, 'viewassignment'])->name('teacher.assignment.index');
Route::get('/teacher/assignment/add', [TeachAssignmentController::class, 'add'])->name('teacher.assignment.add');
Route::post('/teacher/assignment/add', [TeachAssignmentController::class, 'insert']);
Route::get('/teacher/assignment/delete/{id}', [TeachAssignmentController::class, 'delete']);



Route::get('/student/course', [CourseController::class, 'course'])->name('student.course');;
Route::get('/student/index', [CourseController::class, 'G5_material'])->name('student.index');
Route::get('/student/modules', [ModuleController::class, 'viewstudent'])->name('student.module.index');
Route::get('/student/assignments', [TeachAssignmentController::class, 'viewassignmentstudent'])->name('student.assignment.index');
Route::post('/student/assignment/submit', [TeachAssignmentController::class, 'submit'])->name('student.assignment.submit');
Route::get('/progress', [TeachAssignmentController::class, 'viewSubmissions'])->name('progress.index');
Route::post('/progress', [TeachAssignmentController::class, 'viewSubmissions2'])->name('submissions.view');

Route::get('/teacher/submissions', [TeachAssignmentController::class, 'viewSubmissions3'])->name('teacher.submissions');
Route::post('/teacher/submissions', [TeachAssignmentController::class, 'viewSubmissions3'])->name('teacher.submissions');

Route::get('/student/submissions', [TeachAssignmentController::class, 'viewSubmissions4'])->name('student.submissions');
Route::post('/student/submissions', [TeachAssignmentController::class, 'viewSubmissions4'])->name('student.submissions');
