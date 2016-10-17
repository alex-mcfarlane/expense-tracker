<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

class BaseController extends Controller
{
	protected $parentEntity;
    protected $entity;
    
    public function returnItem($model)
    {
        return redirect()->to($this->entity."/view/".$model->id);
    }

    public function returnparentItem($parentId)
    {
    	return redirect()->to($this->parentEntity."/view/".$parentId);
    }
    
    public function returnWithError($error)
    {
        return view();
    }
}
