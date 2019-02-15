@extends('layouts.admin')
@section('content')
<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Manage Employees</h4>
                <div style="display: inline">
                <h6 class="card-subtitle float-left">Export data to Copy, Excel, PDF & Print</h6>

            @if(Auth::user()->user_role == 'admin')
            <!-- sample modal content -->
            <div class="button-box">
                <button type="button" class="btn btn-warning float-right" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Add New Employee</button>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                <div class="modal-dialog  modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel1">Add New Employee</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                    <form method="POST" action="{{route('admin.employee.store')}}">
                    @csrf
                        <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="control-label">* Name</label>
                                            <input type="text" class="form-control" id="name" name="name" required/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="control-label">* Email</label>
                                            <input type="email" class="form-control" id="email" name="email" required="True">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="phone" class="control-label">Phone</label>
                                            <input type="text" class="form-control" id="phone" name="phone">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="bgcolor" class="control-label">BG Graph</label>
                                            <div class="asColorPicker-wrap">
                                                <input type="text" name="bgcolor" class="gradient-colorpicker form-control asColorPicker-input"  value="rgba(224, 47, 132, 0.45)" required>
                                                <a href="#" class="asColorPicker-clear"></a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="bordercolor" class="control-label">Border Graph</label>
                                            <div class="asColorPicker-wrap">
                                                <input type="text" name="bordercolor" class="gradient-colorpicker form-control asColorPicker-input"   value="#e02f84" required>
                                                <a href="#" class="asColorPicker-clear"></a>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="address" class="control-label">Street Address:</label>
                                            <input type="text" class="form-control" id="address" name="address">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="city" class="control-label">City:</label>
                                            <input type="text" class="form-control" id="city" name="city">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="state" class="control-label">State:</label>
                                            <input type="text" class="form-control" id="state" name="state">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="zip" class="control-label">Zip:</label>
                                            <input type="text" class="form-control" id="zip" name="zip">
                                        </div>
                                    </div>
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
            @endif

                </div>
                <div class="table-responsive m-t-40">
                    <table id="manageEmployees" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>City</th>
                                <th>Status</th>
                                @if(Auth::user()->user_role == 'admin')
                                <th>Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>City</th>
                                <th>Status</th>
                                @if(Auth::user()->user_role == 'admin')
                                <th>Actions</th>
                                @endif
                            </tr>
                        </tfoot>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($employees as $employee)
                                <tr>
                                    <td style="background-color:{{$employee->bgcolor}}; color:white">{{ $i }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ $employee->phone }}</td>
                                    <td>{{ $employee->city }}</td>
                                    <td>
                                        @php
                                            if($employee->status == 1)
                                            { $status = '<span class="label label-inverse">Active</span>'; }
                                            else{$status = '<span class="label label-warning">Inactive</span>';}
                                        @endphp
                                        {!! $status !!}
                                    </td>
                                @if(Auth::user()->user_role == 'admin')
                                    <td>
{{-- ********* EDIT STARTS HERE********** --}}
@if(!$employee->trashed())
                                    <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#updateEmployee{{$employee->id}}" data-whatever="@mdo">Edit</button>
                                <!-- sample modal content -->
@endif
                                <div class="modal fade" id="updateEmployee{{$employee->id}}" tabindex="-1" role="dialog" aria-labelledby="updateEmployee{{$employee->id}}Label1">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="updateEmployee{{$employee->id}}Label1">Update Employee</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            </div>
                            <form method="POST" action="{{route('admin.employee.update', $employee)}}">
                            @csrf
                            @method('PUT')
                                <div class="modal-body">
                                    @php
                                        if($employee->status == 1){$checked = "checked"; }
                                        elseif($employee->status == 0){$checked = ""; }
                                    @endphp
                                    <div class="switch">
                                        <label>Inactive
                                            <input type="checkbox" {{$checked}} name="status">
                                            <span class="lever"></span>Active</label>
                                    </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="name" class="control-label">* Name:</label>
                                                    <br>
                                                    <input type="text" class="form-control" id="name" name="name" required/ value="{{ $employee->name }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email" class="control-label">* Email:</label><br>
                                                    <input type="email" class="form-control" id="email" disabled="TRUE" value="{{ $employee->email }}">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="phone" class="control-label">Phone:</label><br>
                                                    <input type="text" class="form-control" id="phone" name="phone" value="{{ $employee->phone }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="color" class="control-label">BG Graph</label><br>
                                                    <div class="asColorPicker-wrap">
                                                        <input type="text" name="bgcolor" class="gradient-colorpicker form-control asColorPicker-input"  value="{{ $employee->bgcolor }}">
                                                        <a href="#" class="asColorPicker-clear"></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="color" class="control-label">Border Graph</label><br>
                                                    <div class="asColorPicker-wrap">
                                                        <input type="text" name="bordercolor" class="gradient-colorpicker form-control asColorPicker-input"  value="{{ $employee->bordercolor }}">
                                                        <a href="#" class="asColorPicker-clear"></a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="address" class="control-label">Street Address:</label><br>
                                                    <input type="text" class="form-control" id="address" name="address" value="{{ $employee->address }}">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="city" class="control-label">City:</label><br>
                                                    <input type="text" class="form-control" id="city" name="city" value="{{ $employee->city }}">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="state" class="control-label">State:</label><br>
                                                    <input type="text" class="form-control" id="state" name="state" value="{{ $employee->state }}">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="zip" class="control-label">Zip:</label><br>
                                                    <input type="text" class="form-control" id="zip" name="zip" value="{{ $employee->zip }}">
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <input type="submit" class="btn btn-primary" value="Update Employee">
                                </div>
                                </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.modal -->
{{-- ********* EDIT ENDS HERE *********** --}}

        {{--  this is for permanant delete  --}}
        <a class="btn btn-danger btn-sm" href="javascript:;" onclick="confirmDelete('{{$employee->id}}')">Delete</a>
            <form id="delete-employee-{{$employee->id}}"
                action="{{ route('admin.employee.destroy', $employee->id) }}"
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
    document.getElementById('delete-employee-'+id).submit();
    }
    }
    </script>
@endsection
