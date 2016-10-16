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
}
