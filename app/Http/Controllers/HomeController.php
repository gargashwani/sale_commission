<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $pageTitle = 'Dashboard';
        // $employees = Employee::all();
        $totalEmployees = Employee::count();
        session(['totalEmployees' => $totalEmployees]);
        return view('admin.home', compact('employees','pageTitle'));

        // if (Auth::check()) {
        //     // The user is logged in...
        //     dd(Auth::user('user_role'));
        // }
    }
}
