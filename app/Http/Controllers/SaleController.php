<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Employee;
use App\Models\Saletype;
use App\Models\Commission;
use App\Models\CommissionRate;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

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
        $selectedReportYear = date('Y');
        $selectedReportMonth = date('m');
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
        $salesds = Sale::orderBy('dateofsale', 'DESC')
        ->get()
        ->groupBy(function($val) {
            return Carbon::parse($val->dateofsale)->format('Y');
        });

        $years = [];

        foreach ($salesds as $key => $year) {
            // array_unshift($years, $key);
            array_push($years, $key);
        }

        return view('admin.sale.index', compact(
            'sales',
            'pageTitle',
            'employees',
            'saletypes',
            'totalCommission',
            'totalSaleAmount',
            'totalSales',
            'years',
            'selectedReportMonth',
            'selectedReportYear'
        ));
    }

    public function report_filter(Request $request)
    {
        $data = $request->all();
        $selectedReportYear = $request->selectedReportYear;
        $selectedReportMonth = $request->selectedReportMonth;
        // dump($data);
        $pageTitle = 'Sales';
        $query =  Sale::query();
        if($selectedReportYear != null){
            $query->whereYear('dateofsale',$selectedReportYear);
        }
        else{
            $selectedReportYear = date('Y');
            $query->whereYear('dateofsale',date('Y'));
        }

        // Filter By Month
        if($selectedReportMonth != null && $selectedReportMonth != 'all'){
            $query->whereMonth('dateofsale',$selectedReportMonth);
        }else{
            $selectedReportMonth = date('m');
        }
        $sales = $query->get();
        // dd($sales);
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
        $salesds = Sale::orderBy('dateofsale', 'DESC')
        ->get()
        ->groupBy(function($val) {
            return Carbon::parse($val->dateofsale)->format('Y');
        });

        $years = [];

        foreach ($salesds as $key => $year) {
            // array_unshift($years, $key);
            array_push($years, $key);
        }

        return view('admin.sale.index', compact(
            'sales',
            'pageTitle',
            'employees',
            'saletypes',
            'totalCommission',
            'totalSaleAmount',
            'totalSales',
            'years',
            'selectedReportYear',
            'selectedReportMonth'
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

        // Get the base query results
        $sales = $query->get();

        // Get commission rate breakdowns
        $commissionBreakdowns = [];
        if ($request->employee_id != 'all') {
            $employee = Employee::find($request->employee_id);
            if ($employee) {
                // Get all commission rates for this employee
                $commissionRates = CommissionRate::where('employee_id', $employee->id)
                    ->whereNull('deleted_at')
                    ->get();

                // Calculate totals for each commission rate
                foreach ($commissionRates as $rate) {
                    $rateSales = $sales->where('commission_rate_id', $rate->id);
                    $commissionBreakdowns[$rate->name] = [
                        'rate' => $rate->rate,
                        'total_sales' => $rateSales->count(),
                        'total_amount' => $rateSales->sum('amount'),
                        'total_commission' => $rateSales->sum('commission')
                    ];
                }

                // Add default commission rate (from employee table)
                $defaultSales = $sales->whereNull('commission_rate_id');
                if ($defaultSales->count() > 0) {
                    $commissionBreakdowns['Default Rate'] = [
                        'rate' => $employee->commission,
                        'total_sales' => $defaultSales->count(),
                        'total_amount' => $defaultSales->sum('amount'),
                        'total_commission' => $defaultSales->sum('commission')
                    ];
                }
            }
        }

        $totalCommission = $query->sum('commission');
        $totalSaleAmount = $query->sum('amount');
        $totalSales = $query->count();

        $pageTitle = 'Sales';
        $employees = Employee::where(['status'=> 1,'deleted_at'=>NULL])
           ->orderBy('id', 'desc')
           ->get();
        $saletypes = Saletype::where(['deleted_at'=>NULL])
           ->orderBy('id', 'desc')
           ->get();

        $selectedReportYear = date('Y');
        $selectedReportMonth = date('m');
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
            'range',
            'selectedReportYear',
            'selectedReportMonth',
            'commissionBreakdowns'
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
        try {
            $validators = $request->validate([
                'amount' => 'required',
                'jobnumber' => 'integer|required|unique:sales',
                'dateofsale' => 'required',
                'employee_id' => 'required|exists:employees,id',
                'saletype_id' => 'required|exists:saletypes,id'
            ]);

            // Get the employee
            $employee = Employee::findOrFail($request->employee_id);
            // If commission_rate_id is provided, use it, otherwise fall back to employee's commission
            if ($request->commission_rate_id) {
                $commissionRate = CommissionRate::findOrFail($request->commission_rate_id);
                $commission = ($request->amount) / 100 * $commissionRate->rate;
                $commission_rate_id = $request->commission_rate_id;
            } else {
                // Use employee's default commission rate
                $commission = ($request->amount) / 100 * $employee->commission;
                $commission_rate_id = null;
            }

            $sale = Sale::create([
                'amount' => $request->amount,
                'jobnumber' => $request->jobnumber,
                'dateofsale' => $request->dateofsale,
                'employee_id' => $request->employee_id,
                'saletype_id' => $request->saletype_id,
                'commission_rate_id' => $commission_rate_id,
                'commission' => $commission
            ]);

            if($sale){
                return redirect()->route('admin.sale.index')->with('message','Record added successfully!');
            }else{
                return back()->withErrors($validators);
            }
        } catch (\Exception $e) {
            dd($e);
            Log::error('Error adding sale: ' . $e->getMessage());
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function edit(Sale $sale)
    {
        $pageTitle = 'Edit Sale';
        $employees = Employee::where(['status'=> 1,'deleted_at'=>NULL])
           ->orderBy('id', 'desc')
           ->get();
        $saletypes = Saletype::where(['deleted_at'=>NULL])
           ->orderBy('id', 'desc')
           ->get();

        return view('admin.sale.edit', compact('sale', 'pageTitle', 'employees', 'saletypes'));
    }

    public function update(Request $request, Sale $sale)
    {
        $validators = $request->validate([
            'amount' => 'required',
            'jobnumber' => 'required|unique:sales,jobnumber,' . $sale->jobnumber . ',jobnumber',
            'dateofsale' => 'required'
        ]);

        // If commission_rate_id is provided, use it, otherwise fall back to employee's commission
        if ($request->has('commission_rate_id')) {
            $commissionRate = CommissionRate::findOrFail($request->commission_rate_id);
            $commission = ($request->amount) / 100 * $commissionRate->rate;
            $commission_rate_id = $request->commission_rate_id;
        } else {
            $employee = Employee::where('id', $request->employee_id)->first();
            $commission = ($request->amount) / 100 * $employee->commission;
            $commission_rate_id = null;
        }

        $sale->amount = $request->amount;
        $sale->jobnumber = $request->jobnumber;
        $sale->dateofsale = $request->dateofsale;
        $sale->employee_id = $request->employee_id;
        $sale->saletype_id = $request->saletype_id;
        $sale->commission_rate_id = $commission_rate_id;
        $sale->commission = $commission;

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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\Http\Response
     */
    public function show(Sale $sale)
    {
        $pageTitle = 'Sale Details';
        return view('admin.sale.show', compact('sale', 'pageTitle'));
    }

    public function getCommissionRates(Request $request)
    {
        try {
            $employeeId = $request->employee_id;

            // Log the incoming employee ID
            Log::info('Fetching commission rates for employee ID: ' . $employeeId);

            if (!$employeeId) {
                return response()->json(['error' => 'Employee ID is required'], 400);
            }

            // Check if the employee exists
            $employee = Employee::find($employeeId);
            if (!$employee) {
                Log::warning('Employee not found for ID: ' . $employeeId);
                return response()->json(['error' => 'Employee not found'], 404);
            }

            $commissionRates = CommissionRate::where('employee_id', $employeeId)
                ->whereNull('deleted_at')
                ->select('id', 'name', 'rate')
                ->get();

            if ($commissionRates->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'data' => [],
                    'message' => 'No commission rates found for this employee'
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => $commissionRates
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching commission rates: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while fetching commission rates'
            ], 500);
        }
    }
}
