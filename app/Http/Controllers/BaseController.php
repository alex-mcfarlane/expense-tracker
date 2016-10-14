<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class BaseController extends Controller
{
    protected $entity;
    
    public function returnItem($model)
    {
        return view($this->entity.'.view', compact($model));
    }
    
    public function returnWithError($error)
    {
        return view();
    }
}
