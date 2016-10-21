@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="pull-right">
                <a href="{{URL::to('bills/view/'.$entry->bill->id)}}" class="btn btn-primary">All {{$entry->bill->name}} Bill's</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            @if(count($errors->all()) > 0)
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        {{$error}}
                    @endforeach
                </div>
            @endif

            <form class="form-horizontal" method="POST" action="{{URL::to('billsEntries/'.$entry->id)}}">
                
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
                <div class="form-group">
                    <label for="due_date" class="col-md-3 control-label">Due Date</label>
                    
                    <div class="col-md-9 col-sm-12">
                        <p class="form-control-static">{{$entry->due_date}}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="amount" class="col-md-3 control-label">Amount</label>
                    
                    <div class="col-md-9 col-sm-12">
                        <p class="form-control-static">${{$entry->amount}}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="paid" class="col-md-3 control-label">Amount Paid</label>
                    
                    <div class="col-md-9 col-sm-12">
                        <p class="form-control-static">${{$entry->paid}}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="paid" class="col-md-3 control-label">Payment Amount</label>
                    
                    <div class="col-md-9 col-sm-12">
                        <input type="text" class="form-control" id="payment" name="payment"/>
                    </div>
                </div>
                
                <div class="text-right">
                    <a class="btn btn-default" href="{{URL::previous()}}">Cancel</a>
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
                
            </form>
        </div>
    </div>

    
@endsection