<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Bill extends Model
{
	protected $fillable = ['name'];

	public function entries()
	{
		return $this->hasMany('App\Models\BillEntry');
	}

	public function user()
	{
		return $this->belongsto('App\User');
	}

    public function scopeForUser($query)
    {
        $id = Auth::user()->id;
        $query->where('user_id', $id);
    }

    public function addEntry(BillEntry $entry)
    {
    	return $this->entries()->save($entry);
    }

    public function getTotalBalanceAttribute()
    {
    	return $this->calcTotalBalance();
    }

    private function calcTotalBalance()
    {
    	$totalBalance = 0;

    	foreach($this->entries as $entry)
    	{
    		$totalBalance += $entry->balance;
    	}

    	return $this->entries->sum('balance');
    }
}
