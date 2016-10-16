@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="pull-right">
                <a href="{{URL::to('bills')}}" class="btn btn-primary">All Bills</a>
                <a href="{{URL::to('bills')}}" class="btn btn-primary">Add Entry</a>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table">
            
            <thead>
                <tr>
                    <th>Entry #</th>
                    <th>Date</th>
                    <th>Amount</th>
                    <th>Amount Paid</th>
                    <th>Amount Owing</th>
                    <th>Actions</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach($entries AS $key => $entry)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection