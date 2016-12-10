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
    
    public function returnWithErrors($errorsArr)
    {
        return redirect()->back()->withErrors($errorsArr)->withInput();
    }

    public function returnWithErrorsAndInput($errorsArr, $input)
    {
        return redirect()->back()->withErrors($errorsArr)->withInput($input);
    }

    public function returnJSON($data)
    {
        return response()->json($data);
    }
}
