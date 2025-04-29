@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="card-title">Profile</div>
                    <form action="{{route('admin.profile.update', $user)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="user_role" value="manager">
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="name" value="{{$user->name}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" name="email" value="{{$user->email}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Submit" class="btn btn-warning">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="card-title">Update Password</div>
                    <form action="{{route('admin.profile.updatepassword', $user)}}" method="POST">
                    @csrf
                    @method('PUT')
                     <input type="hidden" name="user_role" value="manager">
                    <div class="form-group">
                        <label for="">Old Password</label>
                        <input type="text" name="old_password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">New Password</label>
                        <input type="text" name="new_password" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="submit" value="Update" class="btn btn-warning">
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

@endsection
