@extends('layouts.admin')
@section('content')
<!-- ============================================================== -->
<!-- Start Page Content -->
<!-- ============================================================== -->
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <form action="@if($commission){{{route('admin.home.update', $commission)}}}@else{{{route('admin.home.store')}}}@endif" method="POST">
                    @csrf
                    @if($commission)
                       @method('PUT')
                    @endif
                    <label for="">Commission (%)</label>
                        <div class="form-group">
                            <input type="number" name="commission" class='form-control' value="{{@$commission->commission}}">
                        </div>
                        <input type="submit" value="Submit" class="btn btn-warning">
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="input-group mb-3">
            <div class="input-group-append">
                <span class="input-group-text">
                        <span class="ti-calendar"></span>
                </span>
            </div>
        </div>
    </div>

</div>


<!-- ============================================================== -->
<div class="row">
    <!-- Column -->
    <div class="col-lg-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="round round-lg align-self-center round-info"><i class="ti-wallet"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-light">{{$totalEmployees}}</h3>
                        <h5 class="text-muted m-b-0">Total Employees</h5></div>
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
                    <div class="round round-lg align-self-center round-warning"><i class="mdi mdi-cellphone-link"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">$ {{$totalSaleAmount}}</h3>
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
                    <div class="round round-lg align-self-center round-primary"><i class="mdi mdi-cart-outline"></i></div>
                    <div class="m-l-10 align-self-center">
                        <h3 class="m-b-0 font-lgiht">{{$totalSales}}</h3>
                        <h5 class="text-muted m-b-0">Total Sales</h5></div>
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
                        <h3 class="m-b-0 font-lgiht">{{$totalCommission}}</h3>
                        <h5 class="text-muted m-b-0">Total Commission</h5></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
</div>
<!-- Row -->
                <div class="row">
                    <!-- column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Monthly Report</h4>
                                <div id="bar-chart" style="width:100%; height:400px;"></div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                    <!-- column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Line chart</h4>
                                <div id="main" style="width:100%; height:400px;"></div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                    <!-- column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Monthly Salary Chart</h4>
                                <div id="pie-chart" style="width:100%; height:400px;"></div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                    <!-- column -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Radar Chart</h4>
                                <div id="radar-chart" style="width:100%; height:400px;"></div>
                            </div>
                        </div>
                    </div>
                    <!-- column -->
                    <!-- column -->
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Doughnut Chart</h4>
                                <div id="doughnut-chart" style="width:100%; height:400px;"></div>
                            </div>
                        </div>
                    </div>

                </div>
@endsection


@section('scripts')
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!-- Chart JS -->
    <script src="{{asset('assets/plugins/echarts/echarts-all.js')}}"></script>
    <script src="{{asset('assets/plugins/echarts/echarts-init.js')}}"></script>
@endsection