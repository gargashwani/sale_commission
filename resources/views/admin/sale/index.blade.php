@extends('layouts.admin')
@section('content')
<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Simple Toastr Alerts</h4>
                                <h6 class="card-subtitle">You can use four different alert <code>info, warning, success, and error</code> message.</h6>
                                <div class="button-box">
                                    <button class="tst1 btn btn-info">Info Message</button>
                                    <button class="tst2 btn btn-warning">Warning Message</button>
                                    <button class="tst3 btn btn-success">Success Message</button>
                                    <button class="tst4 btn btn-danger">Danger Message</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">New Sale</h4>
                {{-- <h6 class="card-subtitle">You can use four different alert <code>info, warning, success, and error</code> message.</h6> --}}
                <div class="button-box">
                    <form action="{{route('admin.sale.store')}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="">* Select Employee</label>
                                    <select name="employee_id" id="" class="form-control" required="TRUE">
                                        <option selected disabled>Select an employee</option>
                                        @foreach ($employees as $employee)
                                            <option value="{{$employee->id}}">{{$employee->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-2">
                                <label for="">* Sale Type</label>
                                <select name="saletype_id" id="saletype_id" class="form-control" required="TRUE">
                                    <option selected disabled>Select sale type</option>
                                    @foreach ($saletypes as $saletype)
                                        <option value="{{$saletype->id}}">{{$saletype->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-2">
                                <label for="">* Date of Sale</label>
                                <input type="text" name="dateofsale" class="form-control " placeholder="2019-01-16" id="mdate" data-dtp="dtp_GJMLm" required>
                            </div>

                            <div class="col-2">
                                <label for="">* Job Number</label>
                                <input type="number" name="jobnumber" class="form-control" required placeholder="#">
                            </div>
                            <div class="col-2">
                                <label for="">* Amount</label>
                                <input type="number" name="amount" class="form-control" required>
                            </div>
                            <div class="col-1">
                                <label for=""></label>
                                <input type="submit" value="Submit" class="btn btn-info">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Manage sales</h4>
                <h6 class="card-subtitle float-left">Export data to Copy, CSV, Excel, PDF & Print</h6>
                <div class="table-responsive m-t-40">
                    <table id="myTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Job Number</th>
                                <th>Employee</th>
                                <th>SaleType</th>
                                <th>DOS</th>
                                <th>Amount</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Job Number</th>
                                <th>Employee</th>
                                <th>SaleType</th>
                                <th>DOS</th>
                                <th>Amount</th>
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
                                    <td>{{ $sale->employee->name }}</td>
                                    <td>{{ $sale->saletype->name }}</td>
                                    {{-- Y-m-d Format --}}
                                    <td>{{ date('d-m-Y', strtotime($sale->dateofsale)) }}</td>
                                    <td>{{ $sale->amount }}</td>

                                    <td>
{{-- ********* EDIT STARTS HERE********** --}}

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
                                                <option value="{{$sale->employee->id}}" selected>{{$sale->employee->name}}</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{$employee->id}}">{{$employee->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <label for="">* Sale Type</label><br>
                                        <select name="saletype_id" id="saletype_id" class="form-control" required="TRUE">
                                            <option value="{{$sale->saletype->id}}" selected>{{$sale->saletype->name}}</option>
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
<script type="text/javascript">
function confirmDelete(id){
let choice = confirm("Are You sure, You want to Delete this record ?")
if(choice){
document.getElementById('delete-sale-'+id).submit();
}
}
</script>
@endsection
