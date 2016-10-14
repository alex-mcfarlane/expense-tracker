@extends('layouts.app')

@section('content')
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
                        <td>{{$bill->name}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection