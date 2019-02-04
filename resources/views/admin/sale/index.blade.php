@extends('layouts.admin')
@section('content')


{{--  Sort Data Starts --}}
<div class="card card-body">
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
                                    <input type="number" name="amount" class="form-control" required >
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
                                <!-- /.modal -->
{{-- ********* ADD new sale ENDS HERE *********** --}}

    <br>
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
                            @for($i = 2010;$i<2099;$i++)
                                @if($i == @ $selectedDataYear)
                                    <option selected value="{{@ $selectedDataYear}}">
                                        {{@ $selectedDataYear}}
                                    </option>
                                @endif
                                <option value="{{$i}}" >{{$i}}</option>
                            @endfor
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
                    <select name="employee_id" id="" class="" required="TRUE">
                        <option value="all" >All</option>
                        @foreach ($employees as $employee)
                            @if(@$employee_id == $employee->id)
                                <option value="{{@$employee_id}}" selected>{{$employee->name}}</option>
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
                        @if(@$saletype_id == $saletype->id)
                            <option value="{{@$saletype_id}}" selected>{{$saletype->name}}</option>
                        @endif
                        <option value="{{$saletype->id}}">{{$saletype->name}}</option>
                    @endforeach
                </select>
            </div>


            <div class="col-2 form-group">
                <input type="submit" class="btn btn-warning btn-sm" value="Get Feed">
            </div>

        </div>
    </form>
</div>
{{-- Sort Data ends --}}

{{-- table starts here --}}
<div class="row">
    <div class="col-12">

        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Manage sales</h4>
                <h6 class="card-subtitle">Export data to Copy, CSV, Excel, PDF & Print</h6>

                <div class="table-responsive m-t-40">
                    <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Job Number</th>
                                <th>Employee</th>
                                <th>SaleType</th>
                                <th>DOS</th>
                                <th>Sale</th>
                                <th>Commission</th>
                                <th>Revenue</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Job Number</th>
                                <th>Employee</th>
                                <th>SaleType</th>
                                <th>DOS</th>
                                <th>Sale</th>
                                <th>Commission</th>
                                <th>Revenue</th>
                                <th>Actions</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($sales as $sale)
                                <tr>
                                    <td>{{ $sale->jobnumber }}</td>
                                    <td>{{ @$sale->employee->name }}</td>
                                    <td>{{ @$sale->saletype->name }}</td>
                                    {{-- Y-m-d Format --}}
                                    <td>{{ date('d-m-Y', strtotime($sale->dateofsale)) }}</td>
                                    <td>{{ number_format($sale->amount) }}</td>
                                    <td>{{ number_format($sale->commission) }}</td>
                                    <td>{{ number_format($sale->amount - $sale->commission) }}</td>

                                    <td>
{{-- ********* EDIT STARTS HERE********** --}}
<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#updatesale{{$sale->id}}" data-whatever="@mdo">Edit</button>
                                <div class="modal fade" id="updatesale{{$sale->id}}" tabindex="-1" role="dialog" aria-labelledby="updatesale{{$sale->id}}Label1">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="updatesale{{$sale->id}}Label1">Update sale</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <form method="POST" action="{{route('admin.sale.update', $sale)}}">
                            @csrf
                            @method('PUT')
                                <div class="modal-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="">* Select Employee</label><br>
                                            <select name="employee_id" id="" class="form-control" required="TRUE">
                                                <option value="{{@$sale->employee->id}}" selected>{{@$sale->employee->name}}</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{$employee->id}}">{{$employee->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label for="">* Sale Type</label><br>
                                        <select name="saletype_id" id="saletype_id" class="form-control" required="TRUE">
                                            <option value="{{@$sale->saletype->id}}"selected>
                                                {{@$sale->saletype->name}}</option>
                                            @foreach ($saletypes as $saletype)
                                                <option value="{{$saletype->id}}">{{$saletype->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <label for="">* Date of Sale</label><br>
                                        <input type="date" name="dateofsale" class="form-control"  value="{{$sale->dateofsale}}" id="mdate" data-dtp="dtp_GJMLm" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label for="">* Job Number</label><br>
                                        <input type="number" name="jobnumber" class="form-control" required  value="{{$sale->jobnumber}}">
                                    </div>
                                    <div class="col-6">
                                        <label for="">* Amount</label><br>
                                    <input type="number" name="amount" class="form-control" required value="{{$sale->amount}}">
                                    </div>
                                </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <input type="submit" class="btn btn-primary" value="Update sale">
                                </div>
                                </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.modal -->
{{-- ********* EDIT ENDS HERE *********** --}}

        {{--  this is for permanant delete  --}}
        <a class="btn btn-danger btn-sm" href="javascript:;" onclick="confirmDelete('{{$sale->id}}')">Delete</a>
            <form id="delete-sale-{{$sale->id}}"
                action="{{ route('admin.sale.destroy', $sale->id) }}"
                method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
    </td>



                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
