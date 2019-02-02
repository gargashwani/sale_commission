<?php

namespace App\Http\Controllers;

use App\Sale;
use App\Employee;
use App\Commission;
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
        $commission = Commission::first();
        // dd($commission);
        $totalEmployees = Employee::count();
        $totalSaleAmount = Sale::sum('amount');
        $totalCommission = Sale::sum('commission');
        $totalSales = Sale::count();
        session(['totalEmployees' => $totalEmployees]);
        return view('admin.home',
        compact('totalEmployees','pageTitle','commission','totalSaleAmount','totalSales','totalCommission'));

        // if (Auth::check()) {
        //     // The user is logged in...
        //     dd(Auth::user('user_role'));
        // }
    }

    public function store(Request $request){
        // dd($request);
        $validators = $request->validate([
            'commission'=> 'required'
        ]);

        $commission = Commission::create([
            'commission' => $request->commission
        ]);

        if ($commission) {
            return back()->with('message','Commission added successfully!');
        }else{
            return back()->withErrors($validators);
        }
    }

    public function update(Request $request, Commission $commission){
        // dd($commission);
        $validators = $request->validate([
            'commission'=> 'required'
        ]);
        $commission = Commission::first();
        $commission->commission = $request->commission;

        if ($commission->save()) {
            return back()->with('message','Commission updated successfully!');
        }else{
            return back()->withErrors($validators);
        }
    }
}
