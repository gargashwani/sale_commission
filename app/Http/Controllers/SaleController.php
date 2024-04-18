<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Employee;
use App\Models\Saletype;
use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
        // $sales = Sale::all();
        $sales =  Sale::whereYear('dateofsale',date('Y-m'))->get();
        $totalCommission = Sale::whereYear('dateofsale',date('Y'))->sum('commission');
        $totalSaleAmount = Sale::whereYear('dateofsale',date('Y'))->sum('amount');
        $totalSales = Sale::whereYear('dateofsale',date('Y'))->count();

        $employees = Employee::where(['status'=> 1,'deleted_at'=>NULL])
           ->orderBy('id', 'desc')
           ->get();
        $saletypes = Saletype::where(['deleted_at'=>NULL])
           ->orderBy('id', 'desc')
           ->get();

       // to get dynamic years from sales record to show years
        $salesds = Sale::orderBy('dateofsale', 'DESC')->get()
                                    ->groupBy(function($val) {
                                        return Carbon::parse($val->dateofsale)->format('Y');
                                    });
        $years = [];
        foreach ($salesds as $key => $year) {
            array_unshift($years, $key);
        }

        return view('admin.sale.index', compact(
            'sales',
            'pageTitle',
            'employees',
            'saletypes',
            'totalCommission',
            'totalSaleAmount',
            'totalSales',
            'years'
        ));
    }

    public function getrange(Request $request){
        // to get dynamic years from sales record to show years
        $salesds = Sale::orderBy('dateofsale', 'DESC')->get()->groupBy(function($val) {
            return Carbon::parse($val->dateofsale)->format('Y');
        });
        $years = [];
        foreach ($salesds as $key => $year) {
            array_unshift($years, $key);
        }

        $query = Sale::query();

        if($request->employee_id != null){
            $employee_id = $request->employee_id;
            $employeeName = Employee::where('id',$request->employee_id)->first();
        }
        $query->when(request('employee_id') != 'all', function ($q) {
            return $q->where('employee_id', request('employee_id'));
        });

        if($request->saletype_id != null){
            $saletype_id = $request->saletype_id;
            $saleTypeName = Saletype::where('id',$request->saletype_id)->first();
        }
        $query->when(request('saletype_id') != 'all', function ($q) {
            return $q->where('saletype_id', request('saletype_id'));
        });

        $selectedDataYear = '';
        $selectedDataQuarter = '';
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
        $showweekdata = 'off';
        $weektype = '';
        $selectedQuarter = 'off';
        if($request->showweekdata == 'on'  && $request->quarterselector != 'on'){
            $showweekdata = 'on';
            $weektype = $request->weekdata;
            $query->when(request('weekdata') == 'thisweek', function ($q) {
                return $q->whereYear('dateofsale',date('Y'))->where(\DB::raw("WEEKOFYEAR(dateofsale)"), Carbon::now()->weekOfYear);
            });
            $query->when(request('weekdata') == 'lastweek', function ($q) {
                return $q->whereYear('dateofsale',date('Y'))->where(\DB::raw("WEEKOFYEAR(dateofsale)"), Carbon::now()->weekOfYear-1);
            });

        }
        $rangeselector = 'off';
        $range = '';
        if($request->rangeselector  != 'on'){
            $rangeselector = $request->rangeselector;
            $range = $request->range;
            $rangeDataSelector = $request->rangeselector;
        }
        $fromDate = '';
        $toDate = '';
        if( $request->range != null && $request->showweekdata == null && $request->quarterselector != 'on'){
            $date = explode(" ", $request->range);
            $fromDate = date('Y-m-d', strtotime($date[0]));
            $toDate = date('Y-m-d', strtotime($date[2]));

            $query->when(request('rangeselector') != 'on', function ($q) {
                $date = explode(" ", request('range'));
                $date1 = date('Y-m-d', strtotime($date[0]));
                $date2 = date('Y-m-d', strtotime($date[2]));
                return $q->whereBetween('dateofsale', [ $date1, $date2]);
            });
        }

        $totalCommission = $query->sum('commission');
        $totalSaleAmount = $query->sum('amount');
        $totalSales = $query->count();

        $sales = $query->get();

        $pageTitle = 'Sales';
        $employees = Employee::where(['status'=> 1,'deleted_at'=>NULL])
           ->orderBy('id', 'desc')
           ->get();
        $saletypes = Saletype::where(['deleted_at'=>NULL])
           ->orderBy('id', 'desc')
           ->get();

           return view('admin.sale.index', compact(
            'sales',
            'pageTitle',
            'employees',
            'saletypes',
            'showweekdata',
            'weektype',
            'saletype_id',
            'employee_id',
            'rangeselector',
            'range',
            'selectedQuarter',
            'selectedDataYear',
            'selectedDataQuarter',
            'totalSaleAmount',
            'totalCommission',
            'totalSales',
            'years',
            'employeeName',
            'saleTypeName',
            'fromDate',
            'toDate',
            'range'
        ));

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

        $currentMonth = date('m');
        $currentYear = date('Y');
        $thisMonthAmount = Sale::whereMonth('dateofsale', $currentMonth)
                                ->whereYear('dateofsale', $currentYear)
                                ->sum('amount');
        $lastMonthAmount = Sale::whereMonth('dateofsale', ($currentMonth-1))
                                ->whereYear('dateofsale', $currentYear)
                                ->sum('amount');

        Session::put('thisMonthAmount',$thisMonthAmount);
        Session::put('lastMonthAmount',$lastMonthAmount);

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
        $validators = $request->validate([
            'amount'=>'required',
            'jobnumber'=>'integer|required|unique:sales',
            'dateofsale'=>'required'
        ]);

        $employee = Employee::where('id', $request->employee_id)->first();
        $sale = Sale::create([
            'amount' => $request->amount,
            'jobnumber'=>$request->jobnumber,
            'dateofsale'=>$request->dateofsale,
            'employee_id'=>$request->employee_id,
            'saletype_id'=>$request->saletype_id,
            'commission' => ($request->amount)/100*$employee->commission
        ]);

        if($sale){
            return back()->with('message','Record added successfully!');
        }else{
            return back()->withErrors($validators);
        }
    }

    public function update(Request $request, Sale $sale)
    {
        $validators = $request->validate([
            'amount'=>'required',
            'jobnumber' => 'required|unique:sales,jobnumber,'.$sale->jobnumber.',jobnumber',
            'dateofsale'=>'required'
        ]);

        $employee = Employee::where('id', $request->employee_id)->first();

        $sale->amount = $request->amount;
        $sale->jobnumber = $request->jobnumber;
        $sale->dateofsale = $request->dateofsale;
        $sale->employee_id = $request->employee_id;
        $sale->saletype_id = $request->saletype_id;
        $sale->commission = ($request->amount)/100*$employee->commission;

        if($sale->save())
            return redirect(route('admin.sale.index'))
            ->with(['sales','pageTitle','employees','saletypes'])
            ->with('message','Record Successfully Updated!');
        else
            return back()->with('message', 'Error Updating Category');
    }

    public function destroy(Sale $sale)
    {
        // this method deletes the record from the database permanently
        if($sale->forceDelete()){
            return redirect(route('admin.sale.index'))
            ->with(['sales','pageTitle','employees','saletypes'])
            ->with('message','Record Successfully Deleted!');
        }else{
            return back()->with('message','Error Deleting Record');
        }
    }
}
