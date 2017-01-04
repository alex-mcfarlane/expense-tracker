<form class="form-horizontal" method="POST" action="{{URL::to('bills/'.$bill->id.'/entries')}}">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <div class="form-group">
        <label for="due_date" class="col-md-3 control-label">Due Date</label>

        <div class="col-md-9 col-sm-12">
            {{Form::date('due_date', \Carbon\Carbon::now())}}
        </div>
    </div>

    <div class="form-group">
        <label for="amount" class="col-md-3 control-label">Amount</label>

        <div class="col-md-9 col-sm-12">
            <input type="text" class="form-control" id="amount" name="amount" 
                value="{{Input::old('amount')}}"/>
        </div>
    </div>

    <div class="form-group">
        <label for="paid" class="col-md-3 control-label">Amount Paid</label>

        <div class="col-md-9 col-sm-12">
            <input type="text" class="form-control" id="paid" name="paid"
                value="{{Input::old('paid')}}"/>
        </div>
    </div>

    <div class="text-right">
        <a class="btn btn-default" href="{{URL::previous()}}">Cancel</a>
        <button type="submit" class="btn btn-success">Save</button>
    </div>

</form>