@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="pull-right">
                <a href="{{URL::to('bills')}}" class="btn btn-primary">All Bills</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form class="form-horizontal" method="POST" action="{{URL::to('bills')}}">
                
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                
                <div class="form-group">
                    <label for="name" class="col-md-3 control-label">Name</label>
                    
                    <div class="col-md-9 col-sm-12">
                        <input type="text" class="form-control" id="name" name="name"/>
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