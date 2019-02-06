<?php

namespace App\Http\Controllers;

use App\Sale;
use App\Employee;
use App\Saletype;
use App\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
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
        $pageTitle = 'Dashboard';

        $salesds = Sale::orderBy('dateofsale', 'DESC')->get()
                                    ->groupBy(function($val) {
                                        return Carbon::parse($val->dateofsale)->format('Y');
                                    });
        $years = [];
        foreach ($salesds as $key => $year) {
            array_unshift($years, $key);
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

        Carbon::setWeekStartsAt(Carbon::SUNDAY);
        Carbon::setWeekEndsAt(Carbon::SATURDAY);
        $sunday = Carbon::now()->startOfWeek();
        $saturday = Carbon::now()->endOfWeek();
        $thisweeksale = Sale::whereBetween('dateofsale', [$sunday, $saturday])->sum('amount');
        // dump($thisweeksale);

        $query = Sale::query();

        // dump($request->employee_id);
        if($request->employee_id != null){
            $selectedEmployee = $request->employee_id;
            $selectedempname = Employee::where('id',$request->employee_id)->first();
            // dump($selectedempname->name);
            $query->when(request('employee_id') != 'all', function ($q) {
                return $q->where('employee_id', request('employee_id'));
            });
        }

        // dump($request->saletype_id);
        if($request->saletype_id != null){
            $selectedSaletype = $request->saletype_id;
            $saleTypeName = Saletype::where('id',$request->saletype_id)->first();

            $query->when(request('saletype_id') != 'all', function ($q) {
                return $q->where('saletype_id', request('saletype_id'));
            });
        }

        // if(@$request->alltimeselector == 'on'){
        //     $alltimeselector = 'on';
        // }

        $allTime = 'on';
        // dump($request->alltimeselector);
        $alltimeselector = $request->alltimeselector;
        if($request->alltimeselector == 'on'){
            $allTime = 'on';
            // dump($allTime);
        }elseif($request->alltimeselector == 0){
            $allTime = null;
        }
        // dump($allTime);
        if($request->alltimeselector != 'on'){
            // dump($request->rangeselector);
            if($request->rangeselector != 'on'){
                // dump($request->selectDataYear);
                if($request->selectDataYear != null){
                    $selectedDataYear = $request->selectDataYear;
                    // dump($selectedDataYear);
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

                // dump($request->quarterselector);
                if($request->quarterselector != 'on'){
                    $selectedQuarter = $request->selectDataQurater;
                    // dump($selectedQuarter);
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
                // dd('ok');
            }


            if($request->rangeselector == 'on'){
                // dump($request->rangeselector);
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
                // dump($rangeDataSelector);
            }

        }
        // $query->when(request('filter_by') == 'date', function ($q) {
        //     return $q->orderBy('created_at', request('ordering_rule', 'desc'));
        // });

        // dump(date('m'));

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

        // $totalSales = $query->get();
        // foreach ($totalSales as $key => $value) {
        //     dump($value->dateofsale);
        // }
        // dd('ok');

        session(['totalEmployees' => $totalEmployees]);

        // dump(Config::get('constants.ADMIN_NAME'));

        $currentMonth = date('m');
        $currentYear = date('Y');
        $thisMonthAmount = Sale::whereMonth('dateofsale', $currentMonth)
                                ->whereYear('dateofsale', $currentYear)
                                ->sum('amount');
        $lastMonthAmount = Sale::whereMonth('dateofsale', ($currentMonth-1))
                                ->whereYear('dateofsale', $currentYear)
                                ->sum('amount');

        // dd($lastMonthAmount);
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
        // dump($selectedYear);
        $total_Employees = Employee::where(['status'=> 1,'deleted_at'=>NULL])->count();

        for($j=0; $j<$total_Employees; $j++){
            // dump($employees[$j]->id);
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
        // dump($datasets);
        // dump($salePerMonth[0]);
        // dd('ok');

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
        compact('totalEmployees','pageTitle','commission','totalSaleAmount'
                ,'totalSales','totalCommission','employees','saletypes'
                ,'salePerMonth','chartjs','selectedYear','selectedDataYear',
            'selectedEmployee','selectedQuarter','selectedSaletype','rangeDataSelector'
            ,'fromDate','toDate','dateRange','alltimeselector','allTime',
            'alltimeSaleAmount','alltimeCommission','alltimeSales','years'
            ,'selectedempname','saleTypeName','defaultdata'));
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
