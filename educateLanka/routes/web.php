<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

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



require __DIR__.'/auth.php';

Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
// Route for listing all users
Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');

// Route for displaying the user edit form
Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');

// Route for updating user details
Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');

// Route for deleting a user
Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');


