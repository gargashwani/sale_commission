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
                <h6 class="card-subtitle float-left">Export data to Copy, CSV, Excel, PDF & Print</h6>
                    <!-- sample modal content -->
                    <div class="button-box">
                        <button type="button" class="btn btn-warning float-right" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Add New Employee</button>
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
                                    <input type="submit" class="btn btn-primary" value="Add Empployee">
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.modal -->

                </div>
                <div class="table-responsive m-t-40">
                    <table id="saleTypeTable" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Actions</th>
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
                                    <td>
{{-- ********* EDIT STARTS HERE********** --}}
@if(!$saletype->trashed())
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#updatesaletype{{$saletype->id}}" data-whatever="@mdo">Edit</button>
                                <!-- sample modal content -->
@endif
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
                                    <input type="submit" class="btn btn-primary" value="Update saletype">
                                </div>
                                </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.modal -->
{{-- ********* EDIT ENDS HERE *********** --}}


@if($saletype->trashed())
{{$saletype->deleted_at}}
    {{-- Recover the employee --}}
    <a class="btn btn-info btn-sm" href="{{route('admin.saletype.recover',$saletype->id)}}">Restore</a>
@else

    {{--  this is for temprary delete  like trash in our localhost --}}
    <a class="btn btn-warning btn-sm" href="{{route('admin.saletype.remove',$saletype->id)}}">Trash</a>
    {{--  this is for permanant delete  --}}
    <a class="btn btn-danger btn-sm" href="javascript:;" onclick="confirmDelete('{{$saletype->id}}')">Delete</a>
        <form id="delete-saletype-{{$saletype->id}}"
            action="{{ route('admin.saletype.destroy', $saletype->id) }}"
            method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
</td>
@endif


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
    function confirmDelete(id){
    let choice = confirm("Are You sure, You want to Delete this record ?")
    if(choice){
    document.getElementById('delete-saletype-'+id).submit();
    }
    }
    </script>
@endsection
