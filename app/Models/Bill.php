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
    
    public static function createForUser($user, $name)
    {
        $bill = self::create([
            'name' => $name
        ]);
        
        $bill->user()->associate($user);
        
        return $bill;
    }
    
    public static function forCurrentUser($name)
    {
        return self::createForUser(Auth::user(), $name);
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
        /* needs performance check to see which algorithm is faster when a large number of instances are created
    	$totalBalance = 0;

    	foreach($this->entries as $entry)
    	{
    		$totalBalance += $entry->balance;
    	}*/

    	return $this->entries->sum('balance');
    }
}
