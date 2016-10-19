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
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection