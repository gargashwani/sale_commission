@extends('layouts.admin')
@section('content')
<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
{{-- Total data --}}
<div class="row">
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="round round-lg align-self-center round-warning"><i class="mdi mdi-cellphone-link"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">$ {{ number_format($alltimeSaleAmount)}}</h3>
                        <h5 class="text-muted m-b-0">Total Sale Amount</h5></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->

    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="round round-lg align-self-center round-info"><i class="ti-wallet"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-light">$ {{number_format($alltimeSaleAmount - $alltimeCommission)}}</h3>
                        <h5 class="text-muted m-b-0">Total Revenue</h5></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->

    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="round round-lg align-self-center round-danger"><i class="mdi mdi-bullseye"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">$ {{number_format($alltimeCommission)}}</h3>
                        <h5 class="text-muted m-b-0">Total Commission</h5></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->

    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="round round-lg align-self-center round-primary"><i class="mdi mdi-cart-outline"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">{{number_format($alltimeSales)}}</h3>
                        <h5 class="text-muted m-b-0"># Total Sales</h5></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->

</div>
{{-- total data ends****************************** --}}
<div class="row">
<div class="col-12">
{{--  Sort Data Starts --}}
<div class="card card-body">
<div class="card">
<div class="card-body">
    <form action="{{route('admin.home.getrange')}}" method="POST">
        @csrf
        {{-- <div class="row">
            <div class="col-12">
                {{$allTime}}
                <div class="switch">
                    <label><b>All Time</b> ->
                        <input type="checkbox" name="alltimeselector" id="alltimeselector"
                        @if($allTime == 'on')
                        checked
                        @endif
                        >
                        Off<span class="lever"></span>On</label>
                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="col-3">
                <div class="form-group" >
                    <div class="switch">
                        {{-- {{@$rangeDataSelector}} --}}
                        <label>Select Date Range -
                            <input type="checkbox" name="rangeselector" id="rangeselector"
                            @if(@$rangeDataSelector == 'on')
                                checked
                            @endif
                            >
                            Off<span class="lever"></span>On</label>
                    </div>
                    <input type="text" id="showRangeSelector" class="form-control daterange float-right"
                    name="range" style="display:none;"
                    @if(@$rangeDataSelector == 'on')
                    value="{{@ $dateRange}}"
                    @endif
                    >

                </div>
            </div>


            <div class="col-3">

                <div class="form-group" id="yearQuarter" >
                    <div class="switch">
                        <label>Select Quarters
                            <input type="checkbox" id="quarterselector" name="quarterselector"
                            @if(@$selectedQuarter == null)
                                checked
                            @endif
                            >
                            <span class="lever"></span>Full Year
                        </label>
                    </div>

                    <select name="selectDataYear" id="selectYear" >
                        @for($i = 2010;$i<2099;$i++)
                            @if($i == @ $selectedDataYear)
                                <option selected value="{{@ $selectedDataYear}}">
                                    {{@ $selectedDataYear}}
                                </option>
                            @endif
                            <option value="{{$i}}" >{{$i}}</option>
                        @endfor
                    </select>
                    <select name="selectDataQurater" id="showQuraters"
                    @if(@$selectedQuarter == null)
                        style="display:none"
                    @endif
                    >

                        <option value="q1" @if(@$selectedQuarter == 'q1')selected @endif>Quarter 1</option>
                        <option value="q2" @if(@$selectedQuarter == 'q2')selected @endif>Quarter 2</option>
                        <option value="q3" @if(@$selectedQuarter == 'q3')selected @endif>Quarter 3</option>
                        <option value="q4" @if(@$selectedQuarter == 'q4')selected @endif>Quarter 4</option>
                    </select>
                </div>
            </div>

            <div class="col-3">
                <div class="form-group" style="margin-right:5px;">
                    <label for="">Select Employee</label>
                    <select name="employee_id" id="" class="" required="TRUE">
                        <option value="all" selected>All selected</option>
                        @foreach ($employees as $employee)
                            @if(@$selectedEmployee == $employee->id)
                                <option value="{{@$selectedEmployee}}" selected>{{@$employee->name}}</option>
                            @endif
                            <option value="{{$employee->id}}">{{$employee->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-2">
                <label for="">Sale Type</label>
                <select name="saletype_id" id="saletype_id" class="" required="TRUE">
                    <option value="all" selected>All selected</option>
                    @foreach ($saletypes as $saletype)
                        @if(@$selectedSaletype == $saletype->id)
                            <option value="{{@$selectedSaletype}}" selected>{{@$saletype->name}}</option>
                        @endif
                        <option value="{{$saletype->id}}">{{$saletype->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-1">
                <label for="">Sort</label><br>
                <input type="submit" class="btn btn-info btn-sm" value="Get Feed">
            </div>
        </div>
    </form>
</div>
</div>

<!-- ==================== TOTAL DATA STARTS ============================ -->
<br>

@if(@$rangeDataSelector == 'on')
For: {{ date('d-m-Y', strtotime(@$fromDate))}} To {{ date('d-m-Y', strtotime(@$toDate))}}
@endif
<span><b>Default data</b > - For current year, for all employees and for all sale types, You can off it for sorting!</span>
<div class="row">
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="round round-lg align-self-center round-warning"><i class="mdi mdi-cellphone-link"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">$ {{number_format($totalSaleAmount)}}</h3>
                        <h5 class="text-muted m-b-0">Sale Amount</h5></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->

    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="round round-lg align-self-center round-info"><i class="ti-wallet"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-light">$ {{number_format($totalSaleAmount - $totalCommission)}}</h3>
                        <h5 class="text-muted m-b-0">Revenue</h5></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->

    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="round round-lg align-self-center round-danger"><i class="mdi mdi-bullseye"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">$ {{number_format($totalCommission)}}</h3>
                        <h5 class="text-muted m-b-0">Commission</h5></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->

    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="round round-lg align-self-center round-primary"><i class="mdi mdi-cart-outline"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">{{number_format($totalSales)}}</h3>
                        <h5 class="text-muted m-b-0"># Sales</h5></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->

</div>
<!-- ==================== TOTAL DATA ENDS ============================ -->

</div>
{{-- Sort Data ends --}}
</div>
</div>



<!-- ============================================================== -->
<div class="row">

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            <div class="card-title float-left">Employee - Sale Monthly Graph - {{@ $selectedYear}}</div>
            <div class="float-right">
                <div class="row">
                    <form action="{{route('admin.home.getdatabyyear')}}" method="POST">
                        @csrf
                        <div class="col-md-3">
                            <select name="selectYear" id="selectYear" onchange="this.form.submit()">
                                {{-- <option selected disabled>Select an year</option> --}}
                                @for($i = 2010;$i<2099;$i++)
                                    @if($i == @ $selectedYear)
                                        <option selected value="{{@ $selectedYear}}">
                                            {{@ $selectedYear}}
                                        </option>
                                    @endif
                                   <option value="{{$i}}" >{{$i}}</option>
                                @endfor
                            </select>
                        </div>

                    </form>
                </div>
            </div>
            <div style="width:100%;">
                {!! $chartjs->render() !!}
            </div>
        </div>
    </div>
</div>


</div>

<div class="row">
    <div class="col-4">
        <div class="card card-body">
            <form action="@if($commission){{{route('admin.home.update', $commission)}}}@else{{{route('admin.home.store')}}}@endif" method="POST">
                @csrf
                @if($commission)
                    @method('PUT')
                @endif
                <div class="form-group">
                        <label for="">Commission</label>
                        <input type="number" name="commission" class='form-control'
                        value="{{@$commission->commission}}">
                    </div>
                    <input type="submit" value="Submit" class="btn btn-warning btn-sm">
            </form>
        </div>
    </div>
</div>
<!-- ============================================================== -->



@endsection


@section('scripts')

<script>


    $(document).ready( function () {
        $('#rangeselector').change(function(){
            $('#showRangeSelector').toggle();
            $('#yearQuarter').toggle();
        });

        // from previous selection
        @if(@$rangeDataSelector == 'on')
            $('#showRangeSelector').show();
            $('#yearQuarter').hide();
        @endif

        $('#alltimeselector').change(()=>{
            $('#dateRangeCol').toggle();
            $('#yearQuarter').toggle();
        })

    });

    $(document).ready(function(){
        $('#quarterselector').change(()=> {
            $('#showQuraters').toggle();
        });
    });
</script>

<!-- This page plugins -->
<!-- ============================================================== -->

    <!-- Chart JS -->
    <script src="{{asset('assets/plugins/Chart.js/Chart.min.js')}}"></script>
    {{-- <script src="{{asset('assets/plugins/Chart.js/chartjs.init.js')}}"></script> --}}
    @include('api.chartjs.sale-init')
    {{-- <script src="{{asset('assets/plugins/echarts/echarts-init.js')}}"></script> --}}


@endsection