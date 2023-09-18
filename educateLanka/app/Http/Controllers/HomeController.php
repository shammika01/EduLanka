<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    
    public function index()
    {

        
        $user = Auth::user();
        if ($user) {
            if ($user->account_type === 'Teacher') {
                return view('teacher.dashboard');

            } elseif ($user->account_type === 'Admin') {
                // If the user is an admin, call the dashboard method of AdminController
                return app(AdminController::class)->dashboard();

            } elseif ($user->account_type === 'Student') {
                return view('student.dashboard');

            } elseif ($user->account_type === 'Parent') {
                return view('parent.dashboard');
            } else {
                // Redirect to the default home page or login page if account type is not recognized.
                return redirect()->route('login');
            }
        }
        
        // Redirect to the login page if the user is not authenticated.
        return redirect()->route('login');
    }
}