@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('layouts.sidebar')
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create New Transaction') }}</div>
                    <div class="card-body">
                        {{-- Display validation errors if any --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('transactions.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="amount">{{ __('Amount') }}</label>
                                <input type="text" name="amount" id="amount" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="payer">{{ __('Payer') }}</label>
                                <select name="payer" id="payer" class="form-control" required>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="due_on">{{ __('Due on') }}</label>
                                <input type="date" name="due_on" id="due_on" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="vat">{{ __('VAT') }}</label>
                                <input type="text" name="vat" id="vat" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="is_vat_inclusive">{{ __('Is VAT inclusive') }}</label>
                                <select name="is_vat_inclusive" id="is_vat_inclusive" class="form-control" required>
                                    <option value="1">{{ __('Yes') }}</option>
                                    <option value="0">{{ __('No') }}</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('Create Transaction') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
