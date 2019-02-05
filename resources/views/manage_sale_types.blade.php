@extends('layouts.admin')
@section('content')
<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Manage Sale Types</h4>
                <div style="display: inline">
                    <h6 class="card-subtitle float-left">Export data to Copy, Excel, PDF & Print</h6>
                    @if(Auth::user()->user_role == 'admin')
                    <!-- sample modal content -->
                    <div class="button-box">
                        <button type="button" class="btn btn-warning float-right" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Add New Sale Type</button>
                    </div>
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                        <div class="modal-dialog  modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="exampleModalLabel1">Add New Sale Type</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                </div>
                                <form method="POST" action="{{route('admin.saletype.store')}}">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="name" class="control-label">* Name:</label>
                                            <input type="text" class="form-control" id="name" name="name" required/>
                                        </div>
                                        <div class="form-group">
                                            <label for="description" class="control-label">Short description[Max. 200 chars]:</label>
                                            <textarea name="description" id="description" cols="30" rows="5" class="form-control" maxlength="200"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <input type="submit" class="btn btn-primary" value="Add Sale Type">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.modal -->
                    @endif
                </div>
                <div class="table-responsive m-t-40">
                    <table id="saleTypeTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                @if(Auth::user()->user_role == 'admin')
                                    <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Description</th>
                            @if(Auth::user()->user_role == 'admin')
                                <th>Actions</th>
                            @endif
                        </tr>
                        </tfoot>
                        <tbody>
                            @php
                            $i = 1;
                            @endphp
                            @foreach ($saletypes as $saletype)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $saletype->name }}</td>
                                <td>{{ $saletype->description }}</td>

                                <td
                                @if(Auth::user()->user_role == 'manager')
                                style="display:none"
                                @endif
                                >
                                    {{-- ********* EDIT STARTS HERE********** --}}

                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#updatesaletype{{$saletype->id}}" data-whatever="@mdo">Edit</button>
                                <!-- sample modal content -->


                                    <div class="modal fade" id="updatesaletype{{$saletype->id}}" tabindex="-1" role="dialog" aria-labelledby="updatesaletype{{$saletype->id}}Label1">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="updatesaletype{{$saletype->id}}Label1">Update saletype</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                </div>
                                                <form method="POST" action="{{route('admin.saletype.update', $saletype)}}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="name" class="control-label">* Name:</label>
                                                            <br>
                                                            <input type="text" class="form-control" id="name" name="name" required/ value="{{ $saletype->name }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="description" class="control-label">Short Description:</label>
                                                            <br>
                                                            <textarea name="description" id="description" cols="30" rows="5" class="form-control">{{ $saletype->description }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <input type="submit" class="btn btn-primary" value="Update Sale Type">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.modal -->
                                    {{-- ********* EDIT ENDS HERE *********** --}}
                                    {{--  this is for permanant delete  --}}
                                    <a class="btn btn-danger btn-sm" href="javascript:;" onclick="confirmDelete('{{$saletype->id}}')">Delete</a>
                                    <form id="delete-saletype-{{$saletype->id}}"
                                        action="{{ route('admin.saletype.destroy', $saletype->id) }}"
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
<script type="text/javascript">
$(document).ready(()=>{
        $('#saleTypeTable').DataTable( {
            "columnDefs" : [{"targets":3, "type":"date-eu"}],
            "order": [[ 0, "desc" ]],
            dom: '<"top"Bf>rt<"bottom"lip><"clear">',
            // dom: 'Bfrtip',
            lengthMenu: [
                [ 10, 25, 50,100, -1 ],
                [ '10 rows', '25 rows', '50 rows','100 rows', 'Show all' ]
            ],
        buttons: [
            {
                extend: 'copyHtml5',
                exportOptions: {
                    // columns: [ 0, ':visible' ]
                    columns: [ 0, 1, 2]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    // columns: ':visible'
                    columns: [ 0, 1, 2]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2]
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2]
                }
            },
        ]
    } );
});

function confirmDelete(id){
let choice = confirm("Are You sure, You want to Delete this record ?")
if(choice){
document.getElementById('delete-saletype-'+id).submit();
}
}
</script>
@endsection
