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
                    <tr data-entry="{{$entry->id}}">
                        <td>{{$key+1}}</td>
                        <td>{{$entry->due_date}}</td>
                        <td>{{$entry->amount}}</td>
                        <td class="balance">{{$entry->balance}}</td>
                        <td class="paid">{{$entry->paid}}</td>
                        <td>
                            <a href="" class="btn btn-sm btn-success"
                                data-toggle="modal" data-target="#payment-modal-{{$entry->id}}">
                                Pay In Full
                            <a>
                            <a href="{{URL::to('billEntries/'.$entry->id.'/pay')}}" class="btn btn-sm btn-primary">
                                Make A Payment
                            <a>
                            <a href="{{URL::to('billEntries/'.$entry->id.'/edit')}}" class="btn btn-sm btn-primary">
                                <i class="fa fa-pencil icon-white"></i>
                            </a>
                            <a href="" class="btn btn-sm btn-danger" 
                                data-toggle="modal" data-target="#delete-modal-{{$entry->id}}">
                                <i class="fa fa-trash icon-white"></i>
                            </a>
                        </td>
                    </tr>

                    <div id="payment-modal-{{$entry->id}}" class="modal fade" role="dialog">
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

                            <a class="btn btn-primary pay-bill" href="{{URL::to('billEntries/'.$entry->id)}}"
                                data-token="{{ csrf_token() }}" data-base-url="{{URL::to('billEntries/')}}" 
                                data-entry-id="{{$entry->id}}">
                                Pay
                            </a>

                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>

                        </div>

                      </div>
                    </div>

                    <div id="delete-modal-{{$entry->id}}" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">

                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Delete Bill</h4>
                          </div>

                          <div class="modal-body">
                            <h4>Are you sure you want to delete this bill?</h4>
                          </div>

                          <div class="modal-footer">
                            <input type="hidden" name="_token" value=>

                            <a class="btn btn-primary delete-bill" href="{{URL::to('billEntries/'.$entry->id)}}"
                                data-token="{{ csrf_token() }}" data-base-url="{{URL::to('billEntries/')}}" 
                                data-entry-id="{{$entry->id}}">
                                Yes
                            </a>

                            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                          </div>

                        </div>

                      </div>
                    </div>

                @endforeach
            </tbody>
        </table>
    </div>
@endsection