<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Employee;
use App\Models\Saletype;
use App\Models\Commission;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $salesYearMonthComparisonChart = SELF::SalesYearMonthComparisonChart();
        $pageTitle = 'Dashboard';

        $salesds = Sale::orderBy('dateofsale', 'DESC')->get()
                                    ->groupBy(function($val) {
                                        return Carbon::parse($val->dateofsale)->format('Y');
                                    });
        $years = [];
        foreach ($salesds as $key => $year) {
            array_push($years, $key);
        }

        // dd($years);
        $sales = Sale::all();
        $employees = Employee::where(['status'=> 1,'deleted_at'=>NULL])
           ->orderBy('id', 'asc')
           ->get();

        $saletypes = Saletype::where(['deleted_at'=>NULL])
           ->orderBy('id', 'desc')
           ->get();
        $commission = Commission::first();
        // dd($commission);
        $totalEmployees = Employee::where(['status'=> 1,'deleted_at'=>NULL])->count();
        $alltimeSaleAmount = Sale::whereYear('dateofsale',date('Y'))->sum('amount');
        $alltimeCommission = Sale::whereYear('dateofsale',date('Y'))->sum('commission');
        $alltimeSales = Sale::whereYear('dateofsale',date('Y'))->count();

        // Carbon::setWeekStartsAt(Carbon::SUNDAY);
        // Carbon::setWeekEndsAt(Carbon::SATURDAY);
        $sunday = Carbon::now()->startOfWeek(\Carbon\WeekDay::Sunday);
        $saturday = Carbon::now()->endOfWeek(\Carbon\WeekDay::Saturday);
        $thisweeksale = Sale::whereBetween('dateofsale', [$sunday, $saturday])->sum('amount');
        $query = Sale::query();

        $selectedEmployee = null;
        $selectedempname = null;
        if($request->employee_id != null){
            $selectedEmployee = $request->employee_id;
            $selectedempname = Employee::where('id',$request->employee_id)->first();
            $query->when(request('employee_id') != 'all', function ($q) {
                return $q->where('employee_id', request('employee_id'));
            });
        }

        $selectedSaletype = null;
        $saleTypeName = null;
        if($request->saletype_id != null){
            $selectedSaletype = $request->saletype_id;
            $saleTypeName = Saletype::where('id',$request->saletype_id)->first();

            $query->when(request('saletype_id') != 'all', function ($q) {
                return $q->where('saletype_id', request('saletype_id'));
            });
        }

        $allTime = 'on';
        $alltimeselector = $request->alltimeselector;
        if($request->alltimeselector == 'on'){
            $allTime = 'on';
        }elseif($request->alltimeselector == 0){
            $allTime = null;
        }
        if($request->alltimeselector != 'on'){
            if($request->rangeselector != 'on'){
                if($request->selectDataYear != null){
                    $selectedDataYear = $request->selectDataYear;
                    $query->when(request('selectDataYear') != 'null', function ($q) {
                        return $q->whereYear('dateofsale', request('selectDataYear'));
                    });
                }
                else{
                    $selectedDataYear = date('Y');
                    $query->when(request('selectDataYear') != 'all', function ($q) {
                        return $q->whereYear('dateofsale', date('Y'));
                    });
                }

                $selectedQuarter = null;
                if($request->quarterselector != 'on'){
                    $selectedQuarter = $request->selectDataQurater;
                    $selectQurater = $request->selectDataQurater;
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
            }

            $rangeDataSelector = null;
            $fromDate = null;
            $toDate = null;
            $dateRange = null;
            if($request->rangeselector == 'on'){
                $rangeDataSelector = $request->rangeselector;
                    $dateRange = $request->range;
                    $date = explode(" ", $request->range);
                    $fromDate = date('Y-m-d', strtotime($date[0]));
                    $toDate = date('Y-m-d', strtotime($date[2]));


                $query->when(request('rangeselector') == 'on', function ($q) {
                    $date = explode(" ", request('range'));
                    $date1 = date('Y-m-d', strtotime($date[0]));
                    $date2 = date('Y-m-d', strtotime($date[2]));
                    return $q->whereBetween('dateofsale', [ $date1, $date2]);
                });
            }

        }

        // For default selection of current quarter
        if($request->quarterselector != 'on' && $request->alltimeselector != 'on'
            && $request->selectDataQurater == null
        ){
            $defaultdata = 'set';
            if(date('m') >= '01' && date('m') <= '03'){
                $query->when(request('selectDataQurater') == 'q1', function ($q) {
                    return $q->whereIn(DB::raw('MONTH(dateofsale)'), [1,2,3]);
                });
            }
            if(date('m') >= '04' && date('m') <= '06'){
                $query->when(request('selectDataQurater') == 'q1', function ($q) {
                    return $q->whereIn(DB::raw('MONTH(dateofsale)'), [4,5,6]);
                });
            }
            if(date('m') >= '07' && date('m') <= '09'){
                $query->when(request('selectDataQurater') == 'q1', function ($q) {
                    return $q->whereIn(DB::raw('MONTH(dateofsale)'), [7,8,9]);
                });
            }
            if(date('m') >= '10' && date('m') <= '12'){
                $query->when(request('selectDataQurater') == 'q1', function ($q) {
                    return $q->whereIn(DB::raw('MONTH(dateofsale)'), [10,11,12]);
                });
            }
        }

        $totalCommission = $query->sum('commission');
        $totalSaleAmount = $query->sum('amount');
        $totalSales = $query->count();

        session(['totalEmployees' => $totalEmployees]);

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

        // Get each employee sale data monthly
        $salePerMonth= [[]];
        $datasets = [];

        if($request->selectYear == null){
            $selectedYear = date('Y');
        }else{
            $selectedYear = $request->selectYear;
        }
        $total_Employees = Employee::where(['status'=> 1,'deleted_at'=>NULL])->count();

        for($j=0; $j<$total_Employees; $j++){
            for ($i=0; $i<=11; $i++){
                $salePerMonth[$j][$i] = Sale::whereYear('dateofsale',$selectedYear )
                ->whereMonth('dateofsale', $i+1)
                ->where('employee_id', $employees[$j]->id)
                ->sum('amount');
            }

            $dataset = [
                "label" => $employees[$j]->name,
                'backgroundColor' => $employees[$j]->bgcolor,
                'borderColor' => $employees[$j]->bordercolor,
                'borderWidth' => 1,
                'data' => $salePerMonth[$j],
            ];
            array_push($datasets, $dataset);
        }
        // dd($datasets);
        $chartjs = app()->chartjs
        ->name('lineChartTest')
        ->type('bar')
        ->size(['width' => 600, 'height' => 200])
        ->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July'
                , 'August', 'September', 'October', 'November', 'December'])

        ->datasets($datasets)
        ->optionsRaw([
            'legend' => [
                'display' => true,
                'labels' => [
                    'fontColor' => '#000'
                ]
            ],
            'scales' => [
                'xAxes' => [
                    [
                        'stacked' => false,
                        'gridLines' => [
                            'display' => true
                        ]
                    ]
                ]
            ]
        ]);

        return view('admin.home',
        compact(
            'totalEmployees',
            'pageTitle',
            'commission',
            'totalSaleAmount',
            'totalSales',
            'totalCommission',
            'employees',
            'saletypes',
            'salePerMonth',
            'chartjs',
            'selectedYear',
            'selectedDataYear',
            'selectedEmployee',
            'selectedQuarter' ?? null,
            'selectedSaletype',
            'rangeDataSelector',
            'fromDate',
            'toDate',
            'dateRange',
            'alltimeselector',
            'allTime',
            'alltimeSaleAmount',
            'alltimeCommission',
            'alltimeSales',
            'years',
            'selectedempname',
            'saleTypeName',
            'defaultdata',
            'salesYearMonthComparisonChart'
        ));
    }

    public function SalesYearMonthComparisonChart()
    {
        // Fetch data from the database
        $salesData = Sale::selectRaw('YEAR(dateofsale) as year, MONTH(dateofsale) as month, SUM(amount) as total_amount')
                         ->groupBy('year', 'month')
                         ->orderBy('year')
                         ->orderBy('month')
                         ->get();
    
        // Extracting data for the chart
        $years = [];
        $months = range(1, 12); // All months from 1 to 12
        $datasets = [];
    
        foreach ($salesData as $sale) {
            $year = $sale->year;
            $month = $sale->month;
            $totalAmount = round($sale->total_amount, 2); // Round total amount to 2 decimal places
    
            // If the year is not yet recorded, add it to the years array
            if (!in_array($year, $years)) {
                $years[] = $year;
                // Initialize dataset for this year with 0 values for each month
                $datasets[$year] = array_fill(0, 12, 0);
            }
    
            // Update the sales amount for the corresponding month in the dataset
            $datasets[$year][$month - 1] = $totalAmount; // Month is 1-indexed, so subtract 1 to make it 0-indexed
        }
    
        // Convert datasets array into the format expected by the Chart.js library
        $chartDatasets = [];
        $colors = ['#FF5733', '#33FF57', '#5733FF', '#FF33C8', '#33FFC8', '#C8FF33', '#FFC833', '#C833FF', '#33C8FF', '#33FF57', '#57FF33', '#3357FF'];
        foreach ($years as $index => $year) {
            $highlight = ($year == date('Y')) ? true : false; // Check if it's the current year
            $chartDatasets[] = [
                'label' => 'Year ' . $year,
                'data' => $datasets[$year],
                'borderColor' => $highlight ? '#FF5733' : $colors[$index % count($colors)], // Highlight color for the current year, else cycle through colors
                'backgroundColor' => 'transparent', // No background color
                'borderWidth' => $highlight ? 3 : 1, // Increase border width for the current year
            ];
        }
    
        return app()->chartjs
            ->name('salesYearMonthComparisonChart')
            ->type('line')
            ->size(['width' => 600, 'height' => 200])
            ->labels(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'])
            ->datasets($chartDatasets)
            ->optionsRaw([
                'legend' => [
                    'display' => true,
                    'labels' => [
                        'fontColor' => '#000'
                    ]
                ],
                'scales' => [
                    'xAxes' => [
                        [
                            'stacked' => false,
                            'gridLines' => [
                                'display' => true
                            ]
                        ]
                    ]
                ]
            ]);
    }
    

    

    public function getrange(Request $request){

        $query = Sale::query();

        $query->when(request('employee_id') != 'all', function ($q) {
            return $q->where('employee_id', request('employee_id'));
        });

        $query->when(request('saletype_id') != 'all', function ($q) {
            return $q->where('saletype_id', request('saletype_id'));
        });


        $query->when(request('rangeselector') != 'on', function ($q) {
            $date = explode(" ", request('range'));
            $date1 = date('Y-m-d', strtotime($date[0]));
            $date2 = date('Y-m-d', strtotime($date[2]));
            return $q->whereBetween('dateofsale', [ $date1, $date2]);
        });

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
        return view('admin.home.index', compact('sales','pageTitle','employees','saletypes'));

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
            return redirect(route('admin.home.index'))->with('message','Commission added successfully!');
        }else{
            return back()->withErrors($validators);
        }
    }

    public function update(Request $request){
        $validators = $request->validate([
            'commission'=> 'required'
        ]);
        // dump($request);
        $commission = Commission::first();
        // dd($commission);
        $commission->commission = $request->commission;

        if ($commission->save()) {
            return redirect(route('admin.home.index'))->with('message','Commission updated successfully!');
        }else{
            return back()->withErrors($validators);
        }
    }
}
