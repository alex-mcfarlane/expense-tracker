<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class BillEntry extends Model
{
    protected $fillable = ['due_Date', 'amount', 'balance', 'paid'];

    public function bill()
    {
    	return $this->belongsTo('App\Models\Bill');
    }

    public function scopeForBill($query, $billId)
    {
    	$query->where('bill_id', $bill);
    }
}
