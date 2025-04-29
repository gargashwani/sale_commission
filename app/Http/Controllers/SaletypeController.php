<?php

namespace App\Http\Controllers;

use App\Models\Saletype;
use Illuminate\Http\Request;

class SaletypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Sale Type Management';
        $saletypes = Saletype::all();
        // dd($saletypes);
        return view('manage_sale_types', compact('saletypes','pageTitle'));
    }
    /**
     * Display Trashed listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        $pageTitle = 'Trashed Sale Types';
        $saletypes = Saletype::onlyTrashed()->get();
        return view('manage_sale_types', compact('saletypes','pageTitle'));
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
            'name'=> 'required|min:2|unique:saletypes',
            'description'=> 'max:200'
        ]);

        if($request){
            $saletype = Saletype::create([
                'name' => $request->name,
                'description' => $request->description
            ]);
        }
        $saletype->save();
        if($saletype){
            return redirect(route('admin.saletype.index'))->with('message','Record successfully added!');
        }else{
            return back()->withErrors($validators);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Saletype  $saletype
     * @return \Illuminate\Http\Response
     */
    public function show(Saletype $saletype)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Saletype  $saletype
     * @return \Illuminate\Http\Response
     */
    public function edit(Saletype $saletype)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Saletype  $saletype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Saletype $saletype)
    {
        $request->validate([
            'name'=>'required|min:2',
        ]);
        $saletype->name = $request->name;
        $saletype->description = $request->description;

        //save current record into database
        $saved = $saletype->save();
        //return back to the /add/edit form
        if($saved)
            return back()->with('message','Record Successfully Updated!');
        else
            return back()->with('message', 'Error Updating Category');
    }
    public function recoverSaletype($id)
    {
        // Include trashed records when retrieving results...
        // $orders = App\Order::withTrashed()->search('Star Trek')->get();
        // Only include trashed records when retrieving results...
        // $orders = App\Order::onlyTrashed()->search('Star Trek')->get();
        $saletype = Saletype::onlyTrashed()->findOrFail($id);
        if($saletype->restore())
            return back()->with('message','Record Successfully Restored!');
        else
            return back()->with('message','Error Restoring!!!');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Saletype  $saletype
     * @return \Illuminate\Http\Response
     */
    public function destroy(Saletype $saletype)
    {
        // this method deletes the record from the database permanently
        if($saletype->forceDelete()){
            return back()->with('message','Record Successfully Deleted!');
        }else{
            return back()->with('message','Error Deleting Record');
        }
    }
    public function remove(Saletype $saletype)
    {
        // this method trashes the record from the database
        if($saletype->delete()){
            return back()->with('message','Record Successfully Trashed!');
        }else{
            return back()->with('message','Error Deleting Record');
        }
    }

}
