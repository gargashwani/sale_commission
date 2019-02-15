@extends('layouts.admin')
@section('content')

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
                            <input type="text" name="dateofsale" class="form-control " placeholder="{{date('Y-m-d')}}" id="mdate" data-dtp="dtp_GJMLm" required>
                            </div>

                            <div class="col-2">
                                <label for="">* Job Number</label>
                                <input type="number" name="jobnumber" class="form-control" required placeholder="#">
                            </div>
                            <div class="col-2">
                                <label for="">* Amount</label>
                                <input type="number" name="amount" class="form-control" step="any" required>
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
