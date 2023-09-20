<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Count the number of users with 'account_type' as 'Teacher'
        $teacherCount = User::where('account_type', 'Teacher')->count();

        // Count the number of users with 'account_type' as 'Student'
        $studentCount = User::where('account_type', 'Student')->count();

        // Count the number of users with 'account_type' as 'Parent'
        $parentCount = User::where('account_type', 'Parent')->count();


        // Count the total number of users in the database
        $totalCount = User::count();

        // Pass the data to the 'admin.dashboard' view
        return view('admin.dashboard', compact('teacherCount', 'studentCount', 'parentCount', 'totalCount'));
    }
}

