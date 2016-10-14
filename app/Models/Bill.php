<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Bill extends Model
{
    public function scopeForUser($query)
    {
        $id = Auth::user()->id;
        $query->where('user_id', $id);
    }
}
