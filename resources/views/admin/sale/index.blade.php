@extends('layouts.admin')
@section('content')


{{--  Sort Data Starts --}}
<div class="card card-body">
@if(Auth::user()->user_role == 'admin1')
    {{-- ********* Add New Sale STARTS HERE********** --}}
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addsale" data-whatever="@mdo">Create Sale</button>
        <div class="modal fade" id="addsale" tabindex="-1" role="dialog" aria-labelledby="addsaleLabel1">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" id="addsaleLabel1">Create sale</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    </div>
    <form method="POST" action="{{route('admin.sale.store')}}">
        @csrf
        <div class="modal-body">
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label for="">* Select Employee</label><br>
                    <select name="employee_id" id="" class="form-control" required="TRUE">
                        @foreach ($employees as $employee)
                            <option value="{{$employee->id}}">{{$employee->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-4">
                <label for="">* Sale Type</label><br>
                <select name="saletype_id" id="saletype_id" class="form-control" required="TRUE">
                    @foreach ($saletypes as $saletype)
                        <option value="{{$saletype->id}}">{{$saletype->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-4">
                <label for="">* Date of Sale</label><br>
                <input type="date" name="dateofsale" class="form-control"   id="mdate" data-dtp="dtp_GJMLm" required>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <label for="">* Job Number</label><br>
                <input type="number" name="jobnumber" class="form-control" required >
            </div>
            <div class="col-6">
                <label for="">* Amount</label><br>
            <input type="number" name="amount" class="form-control" step="any" required >
            </div>
        </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <input type="submit" class="btn btn-primary" value="Add New Sale">
        </div>
    </form>
                </div>
            </div>
        </div>
        <br>
@endif

    <form action="{{route('admin.sale.getrange')}}" method="POST">
        @csrf
        <div class="row">
            <div class="col-2">
                <div class="form-group" id="showRange">
                    <div class="switch">
                        <label>Range
                            <input type="checkbox" name="rangeselector" id="rangeselector"
                            @if(@$rangeselector != 'on')

                            @else
                            checked
                            @endif
                            >
                            <span class="lever"></span>All</label>
                    </div>
                    <input type="text" id="showRangeSelector" class="form-control daterange float-right" name="range"
                    @if(@$range != 'on')
                        style="display:block;"
                        value="{{@$range}}"
                    @endif
                    style="display:none;">
                </div>
            </div>
            <div class="col-2">
                <div class="form-group" id="weekly">
                    <div class="switch">
                        <label>Weekly
                            <input type="checkbox" name="showweekdata" id="weekdata"
                            @if(@$showweekdata == 'on')
                                checked
                            @endif
                            >
                            Off<span class="lever"></span>On</label>
                    </div>
                    <select name="weekdata" id="showweekdata"
                    @if(@$showweekdata == 'on')
                        style="display:block;"
                    @else
                        style="display:none;"
                    @endif
                    >
                        <option  @if(@$weektype == null) selected @endif>Select Week</option>
                        <option value="thisweek" @if(@$weektype == 'thisweek') selected @endif>This Week</option>
                        <option value="lastweek" @if(@$weektype == 'lastweek') selected @endif>Last Week</option>
                    </select>
                </div>
            </div>
            <div class="col-3">

                <div class="form-group" id="yearQuarter" >
                    <div class="switch">
                        <label>Quarterly
                            <input type="checkbox" id="quarterselector" name="quarterselector"
                            @if(@$selectedQuarter == 'on')
                                checked
                            @endif
                            >
                            Off<span class="lever"></span>On
                        </label>
                    </div>

                    <div id="showQuarterly"
                        @if(@$selectedQuarter == 'on')
                            style="display:block;"
                        @endif
                        style="display:none;"
                    >
                        <select name="selectDataYear" id="selectYear" >
                        @foreach ($years as $year)
                            <option value="{{$year}}">{{$year}}</option>
                        @endforeach
                        </select>
                        <select name="selectDataQurater" id="showQuraters">
                            <option value="qAll" @if(@$selectedDataQuarter == 'qAll')selected @endif>All Quarters </option>
                            <option value="q1" @if(@$selectedDataQuarter == 'q1')selected @endif>Quarter 1</option>
                            <option value="q2" @if(@$selectedDataQuarter == 'q2')selected @endif>Quarter 2</option>
                            <option value="q3" @if(@$selectedDataQuarter == 'q3')selected @endif>Quarter 3</option>
                            <option value="q4" @if(@$selectedDataQuarter == 'q4')selected @endif>Quarter 4</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="">Select Employee</label>
                    <select name="employee_id" id="" class="form-control" required="TRUE">
                        <option value="all" >All</option>
                        @foreach ($employees as $employee)
                            {{-- @if(@$employee_id == $employee->id)
                                <option value="{{@$employee_id}}" selected>{{$employee->name}}</option>
                            @endif --}}
                            <option value="{{$employee->id}}">{{$employee->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-2">
                <label for="">Sale Type</label>
                <select name="saletype_id" id="saletype_id" class="form-control" required="TRUE">
                    <option value="all" selected>All selected</option>
                    @foreach ($saletypes as $saletype)
                        {{-- @if(@$saletype_id == $saletype->id)
                            <option value="{{@$saletype_id}}" selected>{{$saletype->name}}</option>
                        @endif --}}
                        <option value="{{$saletype->id}}">{{$saletype->name}}</option>
                    @endforeach
                </select>
            </div>


            <div class="col-2 form-group">
                <input type="submit" class="btn btn-warning btn-sm" value="Run Report">
            </div>

        </div>
    </form>
</div>
{{-- Sort Data ends --}}
<b>Report for</b>
@if(@$selectedDataYear != null && @$showweekdata != 'on'){{ @$selectedDataYear}}@endif

@if(@$range != null && @$showweekdata != 'on' && @$selectedQuarter != 'on')
{{$range}}
@endif

@if(@$selectedDataQuarter == 'q1') {!! ', Quarter 1 ,'; !!} @endif
@if(@$selectedDataQuarter == 'q2') {!! ', Quarter 2 ,'; !!} @endif
@if(@$selectedDataQuarter == 'q3') {!! ', Quarter 3 ,'; !!} @endif
@if(@$selectedDataQuarter == 'q4') {!! ', Quarter 4 ,'; !!} @endif
<b>
    @if(@$employeeName != null) {{@$employeeName->name.', '}} @else {!! ' all employees, ' !!} @endif
</b>
Saletype - @if(@$saleTypeName != null) {{@$saleTypeName->name}} @else {!! 'all sale types' !!} @endif
</span>
<div class="row">
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="round round-lg align-self-center round-warning"><i class="mdi mdi-cellphone-link"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">${{number_format($totalSaleAmount,2)}}</h3>
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
                        <h3 class="m-b-0 font-light">${{number_format($totalSaleAmount - $totalCommission,2)}}</h3>
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
                        <h3 class="m-b-0 font-lgiht">${{number_format($totalCommission,2)}}</h3>
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
{{-- table starts here --}}
<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Reports sales</h4>
                <h6 class="card-subtitle">Export data to Copy, Excel, PDF & Print</h6>
                <form action="{{route('admin.sale.report_filter')}}" method="post">
                    @csrf
                    <select name="selectedReportYear">

                        @foreach ($years as $year)
                            @if ($selectedReportYear == $year)
                                <option value="{{$year}}" selected>{{$year}}</option>
                            @else
                                <option value="{{$year}}">{{$year}}</option>
                            @endif
                        @endforeach


                        </select>
                        <select name="selectedReportMonth">
                            <option value="all" @if(@$selectedReportMonth == 'all')selected @endif>Full Year</option>
                            <option value="1" @if(@$selectedReportMonth == '1')selected @endif>January</option>
                            <option value="2" @if(@$selectedReportMonth == '2')selected @endif>February</option>
                            <option value="3" @if(@$selectedReportMonth == '3')selected @endif>March</option>
                            <option value="4" @if(@$selectedReportMonth == '4')selected @endif>April</option>
                            <option value="5" @if(@$selectedReportMonth == '5')selected @endif>May</option>
                            <option value="6" @if(@$selectedReportMonth == '6')selected @endif>June</option>
                            <option value="7" @if(@$selectedReportMonth == '7')selected @endif>July</option>
                            <option value="8" @if(@$selectedReportMonth == '8')selected @endif>August</option>
                            <option value="9" @if(@$selectedReportMonth == '9')selected @endif>September</option>
                            <option value="10" @if(@$selectedReportMonth == '10')selected @endif>October</option>
                            <option value="11" @if(@$selectedReportMonth == '11')selected @endif>November</option>
                            <option value="12" @if(@$selectedReportMonth == '12')selected @endif>December</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                </form>
                <div class="table-responsive m-t-40">
                    <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Job Number</th>
                                <th>Date</th>
                                <th>Employee</th>
                                {{-- <th>Customer</th> --}}
                                <th>Amount</th>
                                <th>Comm Rate Name</th>
                                <th>Comm Rate %</th>
                                <th>Comm</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="font-weight-bold">
                                <td colspan="3">Totals</td>
                                <td>${{ number_format($totalSaleAmount, 2) }}</td>
                                <td colspan="2"></td>
                                <td>${{ number_format($totalCommission, 2) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($sales as $sale)
                                <tr>
                                    <td>{{ $sale->jobnumber }}</td>
                                    <td>{{ date('Y-m-d', strtotime($sale->dateofsale)) }}</td>
                                    <td>{{ $sale->employee->name }}</td>
                                    {{-- <td>{{ $sale->customer->name ?? 'N/A' }}</td> --}}
                                    <td>${{ number_format($sale->amount, 2) }}</td>
                                    <td>{{ $sale->commission_rate_id ? $sale->commissionRate->name : 'Default Rate' }}</td>
                                    <td>{{ $sale->commission_rate_id ? number_format($sale->commissionRate->rate, 2) : number_format($sale->employee->commission, 2) }}%</td>
                                    <td>${{ number_format($sale->commission, 2) }}</td>
                                    <td>
                                        <a href="{{ route('admin.sale.edit', $sale->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('admin.sale.destroy', $sale->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this sale?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if(isset($commissionBreakdowns) && !empty($commissionBreakdowns))
                <div class="mt-4">
                    <h4>Commission Rate Breakdown</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Commission Rate Name</th>
                                    <th>Rate</th>
                                    <th>Total Sales</th>
                                    <th>Total Amount</th>
                                    <th>Total Commission</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($commissionBreakdowns as $name => $breakdown)
                                <tr>
                                    <td>{{ $name }}</td>
                                    <td>{{ number_format($breakdown['rate'], 2) }}%</td>
                                    <td>{{ number_format($breakdown['total_sales']) }}</td>
                                    <td>${{ number_format($breakdown['total_amount'], 2) }}</td>
                                    <td>${{ number_format($breakdown['total_commission'], 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>

    </div>
</div>
<!-- ============================================================== -->
<!-- End PAge Content -->
<!-- ============================================================== -->
@endsection

@section('scripts')

@include('api.datatable-init')

<script>
    $(document).ready( function () {
        $('#rangeselector').change(function(){
            $('#showRangeSelector').toggle();
        });

        $('#weekdata').change(()=>{
            $('#showweekdata').toggle();
            $('#showRange').toggle();
            $('#yearQuarter').toggle();
        });

        $('#quarterselector').change(() =>{
            $('#showRange').toggle();
            $('#weekly').toggle();
            $('#showQuarterly').toggle();
        });

        @if(@$showweekdata == 'on')
            $('#showweekdata').show();
            $('#showRange').hide();
            $('#yearQuarter').hide();
        @endif

        @if(@$selectedQuarter == 'on')
            $('#weekly').hide();
            $('#showRange').hide();
        @endif
    });
</script>

<script type="text/javascript">
function confirmDelete(id){
    let choice = confirm("Are You sure, You want to Delete this record ?")
    if(choice){
        document.getElementById('delete-sale-'+id).submit();
    }
}
</script>

@endsection
