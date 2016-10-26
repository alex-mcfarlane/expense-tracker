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
    	$this->paid += $amount;
    }
}
