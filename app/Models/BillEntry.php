<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BillEntry extends Model
{
    protected $fillable = ['due_date', 'amount', 'paid'];
    protected $appends = array('balance');

    public function bill()
    {
    	return $this->belongsTo('App\Models\Bill');
    }

    public function scopeForBill($query, $billId)
    {
    	$query->where('bill_id', $bill);
    }

    public function getBalanceAttribute()
    {
    	return $this->calcBalance();
    }
    
    public function calcBalance()
    {
		$balance = $this->amount - $this->paid;
		return $balance;
    }

    public function pay($amount)
    {
    	if(! $this->validatePayment($amount)) {
    		return false;
    	}

    	$this->paid += $amount;
    	return true;
    }

    public function payFull()
    {
        $this->pay($this->balance);
    }

    private function validatePayment($amount)
    {
    	return $amount <= $this->balance;
    }
}
