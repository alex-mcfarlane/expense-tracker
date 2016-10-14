<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\ExpenseTracker\Repositories\BillRepository;

class BillsController extends BaseController
{
    protected $billRepo;
    
    
    public function __construct(BillRepository $billRepository)
    {
        $this->entity = 'bills';
        $this->billRepo = $billRepository;
    }
    
    public function index(BillRepository $billRepository)
    {
        $bills = $this->billRepo->all();
        
        $data = [
            'bills' => $bills
        ];
        
        return view('bills.index', $data);
    }

    public function create()
    {
    	return view('bills.edit');
    }
    
    public function store(Request $request)
    {
        $data = $request->input();
        return $this->billGateway->create($this, $data);
    }
}
