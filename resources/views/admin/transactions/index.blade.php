@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include('layouts.sidebar')
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('List Transactions') }}</div>

                    <div class="card-body">

                        @if(Session::has('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        <table class="table" id="transactions-table">
                            <thead>
                            <tr>
                                <th>{{__('Amount')}}</th>
                                <th>{{__('Customer')}}</th>
                                <th>{{__('VAT')}}</th>
                                <th>{{__('Due On')}}</th>
                                <th>{{__('Is VAT Inclusive')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Total Paid')}}</th>
                                <th>{{__('Action')}}</th>
                            </tr>
                            </thead>

                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->amount }}</td>
                                    <td>{{ $transaction->payer->name }}</td>
                                    <td>{{ $transaction->vat }} %</td>
                                    <td>{{ $transaction->due_on }}</td>
                                    <td> @if($transaction->is_vat_inclusive)
                                            {{ __('Yes') }}
                                        @else
                                            {{ __('No') }}
                                        @endif </td>
                                    <td>{{ $transaction->status }}</td>
                                    <td>{{ $transaction->payments->pluck('amount')->sum() }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#paymentModal{{$transaction->id}}">
                                            {{ __('Pay') }}
                                        </button>


                                        <div class="modal fade" id="paymentModal{{$transaction->id}}" tabindex="-1" role="dialog"
                                             aria-labelledby="paymentModalLabel{{$transaction->id}}" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="makePaymentModalLabel{{$transaction->id}}">{{ __('Record Payment') }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>

                                                    <div class="modal-body">

                                                        <div id="successMessageContainer1"></div>

                                                        <form id="paymentForm{{$transaction->id}}" action="{{ route('payment.store') }}" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">

                                                            <div class="form-group">
                                                                <label for="amount">{{ __('Amount') }}</label>
                                                                <input type="text" name="amount" id="amount" class="form-control" required>
                                                                <span class="text-danger" id="amountError"></span>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="pay_on">{{ __('Pay On') }}</label>
                                                                <input type="datetime-local" name="pay_on" id="pay_on" class="form-control" required>
                                                                <span class="text-danger" id="payOnError"></span>
                                                            </div>

                                                            <div class="form-group">
                                                                <label for="details">{{ __('Details') }}</label>
                                                                <textarea name="details" id="details" class="form-control" rows="3" required></textarea>
                                                                <span class="text-danger" id="detailsError"></span>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                                                <button type="button" class="btn btn-primary" onclick="submitForm('{{ $transaction->id }}')">{{ __('Submit Payment') }}</button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Make Payment Modal -->
                                    </td>
                                </tr>
                            @endforeach

                        </table>
                        <div class="d-flex justify-content-center">
                            {{ $transactions->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        function submitForm(transactionId) {
            let formData = $('#paymentForm' + transactionId).serialize();

            $.ajax({
                url: "{{ route('payment.store') }}",
                type: "POST",
                data: formData,
                success: function(response) {
                    updateModalContent(transactionId, response.message);
                    setTimeout(function() {
                        document.getElementById('paymentModal' + transactionId).style.display = 'none';
                        location.reload();
                    }, 1000);
                },

                error: function(xhr) {
                    let errors = xhr.responseJSON.errors;
                    displayErrors(errors);
                }
            });
        }

        function displayErrors(errors) {
            $('.text-danger').text('');

            $.each(errors, function(key, value) {
                $('#' + key + 'Error').text(value[0]);
            });
        }

        function updateModalContent(transactionId, successMessage) {
            $('#successMessageContainer' + transactionId).html('<div class="alert alert-success">' + successMessage + '</div>');
        }
    </script>
@endsection
