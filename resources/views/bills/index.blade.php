@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="pull-right">
                <a href="{{URL::to('bills/create')}}" class="btn btn-primary">New Bill</a>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table">
            
            <thead>
                <tr>
                    <th>Bill</th>
                    <th>Category</th>
                    <th>Amount Owing</th>
                    <th>Actions</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach($bills AS $bill)
                    <tr>
                        <td><a href="{{URL::to('bills/view/'.$bill->id)}}">{{$bill->name}}</a></td>
                        <td></td>
                        <td>{{$bill->totalBalance}}</td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection