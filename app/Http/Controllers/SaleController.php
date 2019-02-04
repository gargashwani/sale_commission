<?php

namespace App\Http\Controllers;

use App\Sale;
use App\Employee;
use App\Saletype;
use App\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = 'Sales';
        $sales = Sale::all();
        $employees = Employee::where(['status'=> 1,'deleted_at'=>NULL])
           ->orderBy('id', 'desc')
           ->get();
        $saletypes = Saletype::where(['deleted_at'=>NULL])
           ->orderBy('id', 'desc')
           ->get();
        // dd($saletypes);
        return view('admin.sale.index', compact('sales','pageTitle','employees','saletypes'));
    }

    public function getrange(Request $request){
        // dump($request->range);
        // dump($request->rangeselector);


        $query = Sale::query();

        if($request->employee_id != null){
            $employee_id = $request->employee_id;
        }
        $query->when(request('employee_id') != 'all', function ($q) {
            return $q->where('employee_id', request('employee_id'));
        });

        if($request->saletype_id != null){
            $saletype_id = $request->saletype_id;
        }
        $query->when(request('saletype_id') != 'all', function ($q) {
            return $q->where('saletype_id', request('saletype_id'));
        });

        // dump($request->quarterselector);

        if($request->quarterselector == 'on'){
            $selectedQuarter = 'on';
            $selectedDataYear = $request->selectDataYear;
            $selectedDataQuarter = $request->selectDataQurater;
            $query->when(request('selectDataYear') != 'null', function ($q) {
                return $q->whereYear('dateofsale', request('selectDataYear'));
            });

            $query->when(request('selectDataQurater') == 'qAll', function ($q) {
                return $q->whereIn(DB::raw('MONTH(dateofsale)'), [1,2,3,4,5,6,7,8,9,10,11,12]);
            });

            $query->when(request('selectDataQurater') == 'q1', function ($q) {
                return $q->whereIn(DB::raw('MONTH(dateofsale)'), [1,2,3]);
            });
            $query->when(request('selectDataQurater') == 'q2', function ($q) {
                return $q->whereIn(DB::raw('MONTH(dateofsale)'), [4,5,6]);
            });

            $query->when(request('selectDataQurater') == 'q3', function ($q) {
                return $q->whereIn(DB::raw('MONTH(dateofsale)'), [7,8,9]);
            });

            $query->when(request('selectDataQurater') == 'q4', function ($q) {
                return $q->whereIn(DB::raw('MONTH(dateofsale)'), [10,11,12]);
            });
        }

        if($request->showweekdata == 'on'){
            $showweekdata = 'on';
            $weektype = $request->weekdata;
            $query->when(request('weekdata') == 'thisweek', function ($q) {
                return $q->where(\DB::raw("WEEKOFYEAR(dateofsale)"), Carbon::now()->weekOfYear);
                // return $q->whereBetween('dateofsale', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount');
            });
            $query->when(request('weekdata') == 'lastweek', function ($q) {
                return $q->where(\DB::raw("WEEKOFYEAR(dateofsale)"), Carbon::now()->weekOfYear-1);
                // return $q->whereBetween('dateofsale', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('amount');
            });

        }

        if($request->rangeselector  != 'on'){
            $rangeselector = $request->rangeselector;
            $range = $request->range;
        }
        // dump($range);
        // dd($rangeselector);
        if($request->showweekdata != null){
            // dump('range');
            $query->when(request('rangeselector') != 'on', function ($q) {
                $date = explode(" ", request('range'));
                $date1 = date('Y-m-d', strtotime($date[0]));
                $date2 = date('Y-m-d', strtotime($date[2]));
                return $q->whereBetween('dateofsale', [ $date1, $date2]);
            });
        }
        // $query->when(request('filter_by') == 'date', function ($q) {
        //     return $q->orderBy('created_at', request('ordering_rule', 'desc'));
        // });
        $sales = $query->get();
        // dd($sales);

        $pageTitle = 'Sales';
        $employees = Employee::where(['status'=> 1,'deleted_at'=>NULL])
           ->orderBy('id', 'desc')
           ->get();
        $saletypes = Saletype::where(['deleted_at'=>NULL])
           ->orderBy('id', 'desc')
           ->get();
        // dd($saletypes);
        return view('admin.sale.index', compact('sales','pageTitle'
                    ,'employees','saletypes','showweekdata','weektype'
                    ,'saletype_id', 'employee_id','rangeselector','range'
                    ,'selectedQuarter','selectedDataYear','selectedDataQuarter'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pageTitle = 'Create Sale';
        $employees = Employee::where(['status'=> 1,'deleted_at'=>NULL])
           ->orderBy('id', 'desc')
           ->get();
        $saletypes = Saletype::where(['deleted_at'=>NULL])
           ->orderBy('id', 'desc')
           ->get();

        return view('admin.sale.create',compact('pageTitle','employees','saletypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $validators = $request->validate([
            'amount'=>'integer|required',
            'jobnumber'=>'integer|required|unique:sales',
            'dateofsale'=>'required'
        ]);

        $commission = Commission::first();
        // dump($commission );

        if($commission == NULL){
            $comm = 0;
        }else{
            $comm = $commission->commission;
        }
        // dd($commission->commission);
        $sale = Sale::create([
            'amount' => $request->amount,
            'jobnumber'=>$request->jobnumber,
            'dateofsale'=>$request->dateofsale,
            'employee_id'=>$request->employee_id,
            'saletype_id'=>$request->saletype_id,
            'commission' => ($request->amount)/100*$comm
        ]);

        if($sale){
            return back()->with('message','Record added successfully!');
        }else{
            return back()->withErrors($validators);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sale $sale)
    {
        // dump($request);
        $validators = $request->validate([
            'amount'=>'integer|required',
            'jobnumber' => 'required|unique:sales,jobnumber,'.$sale->jobnumber.',jobnumber',
            'dateofsale'=>'required'
        ]);

        $commission = Commission::first();
        // dd($commission);
        if(!$commission){
            $comm = 0;
        }else{
            $comm = $commission->commission;
        }

        $sale->amount = $request->amount;
        $sale->jobnumber = $request->jobnumber;
        $sale->dateofsale = $request->dateofsale;
        $sale->employee_id = $request->employee_id;
        $sale->saletype_id = $request->saletype_id;
        $sale->commission = ($request->amount)/100*$comm;

        if($sale->save())
            return redirect(route('admin.sale.index'))
            ->with(['sales','pageTitle','employees','saletypes'])
            ->with('message','Record Successfully Updated!');

            // return back()->with('message','Record Successfully Updated!');
        else
            return back()->with('message', 'Error Updating Category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sale $sale)
    {
        // this method deletes the record from the database permanently
        if($sale->forceDelete()){
            return redirect(route('admin.sale.index'))
            ->with(['sales','pageTitle','employees','saletypes'])
            ->with('message','Record Successfully Deleted!');
            // return back()->with('message','Record Successfully Deleted!');
        }else{
            return back()->with('message','Error Deleting Record');
        }
    }
}
