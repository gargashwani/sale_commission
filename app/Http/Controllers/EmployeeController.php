<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user_role = $request->user()->user_role;
        $pageTitle = 'Employee Management';
        $employees = Employee::all();
        $totalEmployees = Employee::count();
        session(['totalEmployees' => $totalEmployees]);
        return view('manage_employees', compact('employees','pageTitle'));

        // if (Auth::check()) {
        //     // The user is logged in...
        //     dd(Auth::user('user_role'));
        // }
    }

    /**
     * Display Trashed listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $pageTitle = 'Trashed Employees';
        $employees = Employee::onlyTrashed()->get();
        return view('manage_employees', compact('employees','pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validators = $request->validate([
            'name'=>'required|min:2',
            'email'=>'required|min:5|unique:employees|email',
            'bgcolor'=>'required',
            'bordercolor'=>'required'
        ]);

        // dd($request);

       if($request){
        $employee = Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'zip' => $request->zip,
            'city' => $request->city,
            'state' => $request->state,
            'bgcolor' => $request->bgcolor,
            'bordercolor' => $request->bordercolor,
            'address' => $request->address,
            'status' => '1'
        ]);
       }
    //    dd($employee);
       if($employee)
            return back()->with('message','Employee added successfully!');
        else
            return back()->withErrors($validators);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name'=>'required|min:2',
        ]);
        $employee->name = $request->name;
        $employee->phone = $request->phone;
        $employee->zip = $request->zip;
        $employee->city = $request->city;
        $employee->state = $request->state;
        $employee->address = $request->address;
        $employee->bgcolor = $request->bgcolor;
        $employee->bordercolor = $request->bordercolor;
        if ($request->status == 'on') {
            $employee->status = '1';
        }else{
            $employee->status = '0';
        }
        //save current record into database
        $saved = $employee->save();
        //return back to the /add/edit form
        if($saved)
            return back()->with('message','Record Successfully Updated!');
        else
            return back()->with('message', 'Error Updating Category');
    }

    public function recoverEmp($id)
    {
        // Include trashed records when retrieving results...
        // $orders = App\Order::withTrashed()->search('Star Trek')->get();
        // Only include trashed records when retrieving results...
        // $orders = App\Order::onlyTrashed()->search('Star Trek')->get();
        $employee = Employee::onlyTrashed()->findOrFail($id);
        if($employee->restore())
            return back()->with('message','Record Successfully Restored!');
        else
            return back()->with('message','Error Restoring!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        // this method deletes the record from the database permanently
        if($employee->forceDelete()){
            return back()->with('message','Record Successfully Deleted!');
        }else{
            return back()->with('message','Error Deleting Record');
        }
    }


    public function remove(Employee $employee)
    {
        // this method trashes the record from the database
        $employee->status = '0';
        $employee->save();

        if($employee->delete()){
            return back()->with('message','Record Successfully Trashed!');
        }else{
            return back()->with('message','Error Deleting Record');
        }
    }
}
