@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="pull-right">
                <a href="{{URL::to('bills')}}" class="btn btn-primary">All Bills</a>
                <a href="{{URL::to('bills/'.$bill->id.'/entries/create')}}" class="btn btn-primary">Add Entry</a>
            </div>
        </div>
    </div>

    <h2>{{$bill->name}} Bill's</h2>

    <div class="table-responsive">
        <table class="table">
            
            <thead>
                <tr>
                    <th>Entry #</th>
                    <th>Due Date</th>
                    <th>Amount</th>
                    <th>Balance</th>
                    <th>Amount Paid</th>
                    <th>Actions</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach($entries AS $key => $entry)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$entry->due_date}}</td>
                        <td>{{$entry->amount}}</td>
                        <td>{{$entry->balance}}</td>
                        <td>{{$entry->paid}}</td>
                        <td>
                            <a href="{{URL::to('billEntries/'.$entry->id.'/pay')}}" class="btn btn-sm btn-primary">Make Payment<a>
                            <a href="" class="btn btn-sm btn-success"
                                data-toggle="modal" data-target="#payment-modal">Pay In Full<a>
                        </td>
                    </tr>

                    <div id="payment-modal" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">

                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Pay Full Bill</h4>
                          </div>

                          <div class="modal-body">
                            <h4>Are you sure you want to pay the bill in full?</h4>
                          </div>

                          <div class="modal-footer">
                            <input type="hidden" name="_token" value=>

                            <a id="pay-bill" class="btn btn-primary" href="{{URL::to('billEntries/'.$entry->id)}}"
                                data-token="{{ csrf_token() }}" data-base-url="{{URL::to('billEntries/')}}" 
                                data-entry-id="{{$entry->id}}">
                                Pay
                            </a>

                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>

                        </div>

                      </div>
                    </div>

                @endforeach
            </tbody>
        </table>
    </div>
@endsection