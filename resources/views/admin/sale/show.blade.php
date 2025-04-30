@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Sale Details</h4>
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Job Number</th>
                                <td>{{ $sale->jobnumber }}</td>
                            </tr>
                            <tr>
                                <th>Employee</th>
                                <td>{{ $sale->employee->name }}</td>
                            </tr>
                            <tr>
                                <th>Sale Type</th>
                                <td>{{ $sale->saletype->name }}</td>
                            </tr>
                            <tr>
                                <th>Amount</th>
                                <td>${{ number_format($sale->amount, 2) }}</td>
                            </tr>
                            <tr>
                                <th>Commission</th>
                                <td>${{ number_format($sale->commission, 2) }}</td>
                            </tr>
                            @if($sale->commission_rate_id)
                            <tr>
                                <th>Commission Rate</th>
                                <td>{{ $sale->commissionRate->name }} ({{ $sale->commissionRate->rate }}%)</td>
                            </tr>
                            @endif
                            <tr>
                                <th>Date of Sale</th>
                                <td>{{ $sale->dateofsale }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    <a href="{{ route('admin.sale.index') }}" class="btn btn-info">Back to List</a>
                    <a href="{{ route('admin.sale.edit', $sale->id) }}" class="btn btn-primary">Edit</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
