@extends('layouts.admin')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Sale</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.sale.update', $sale->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="employee_id">Employee</label>
                            <select name="employee_id" id="employee_id" class="form-control @error('employee_id') is-invalid @enderror" required>
                                <option value="">Select Employee</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ $sale->employee_id == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('employee_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="saletype_id">Sale Type</label>
                            <select name="saletype_id" id="saletype_id" class="form-control @error('saletype_id') is-invalid @enderror" required>
                                <option value="">Select Sale Type</option>
                                @foreach($saletypes as $saletype)
                                    <option value="{{ $saletype->id }}" {{ $sale->saletype_id == $saletype->id ? 'selected' : '' }}>
                                        {{ $saletype->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('saletype_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount', $sale->amount) }}" required>
                            @error('amount')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="jobnumber">Job Number</label>
                            <input type="number" class="form-control @error('jobnumber') is-invalid @enderror" id="jobnumber" name="jobnumber" value="{{ old('jobnumber', $sale->jobnumber) }}" required>
                            @error('jobnumber')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="dateofsale">Date of Sale</label>
                            <input type="date" class="form-control @error('dateofsale') is-invalid @enderror" id="dateofsale" name="dateofsale" value="{{ old('dateofsale', is_string($sale->dateofsale) ? $sale->dateofsale : $sale->dateofsale->format('Y-m-d')) }}" required>
                            @error('dateofsale')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="commission_rate_id">Commission Rate</label>
                            <select name="commission_rate_id" id="commission_rate_id" class="form-control @error('commission_rate_id') is-invalid @enderror">
                                <option value="">Default Rate</option>
                                @if($sale->employee)
                                    @foreach($sale->employee->commissionRates as $rate)
                                        <option value="{{ $rate->id }}" {{ $sale->commission_rate_id == $rate->id ? 'selected' : '' }}>
                                            {{ $rate->name }} ({{ $rate->rate }}%)
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            @error('commission_rate_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update Sale</button>
                        <a href="{{ route('admin.sale.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
