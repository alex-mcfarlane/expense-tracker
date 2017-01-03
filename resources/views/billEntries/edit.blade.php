@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="pull-right">
                <a href="{{URL::to('bills/view/'.$bill->id)}}" class="btn btn-primary">All {{$bill->name}} Bill's</a>
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

            @if(isset($entry))
                @include('billEntries.forms.edit')
            @else
                @include('billEntries.forms.create')
            @endif
                
        </div>
    </div>

    
@endsection