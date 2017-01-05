<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\ExpenseTracker\Repositories\BillRepository;
use App\ExpenseTracker\Services\BillCreatorService;
use App\ExpenseTracker\Bills\BillDisplay;
use App\ExpenseTracker\Exceptions\BillException;

class BillsController extends BaseController
{
    protected $billRepo;
    protected $billCreatorService;
    
    public function __construct(BillRepository $billRepository, 
            BillCreatorService $billCreatorService)
    {
        $this->entity = 'bills';
        $this->billRepo = $billRepository;
        $this->billCreatorService = $billCreatorService;
        
        parent::__construct();
    }
    
    public function index(BillRepository $billRepository)
    {
        $bills = $this->billRepo->all();
        
        $data = [
            'bills' => $bills
        ];
        
        return view('bills.index', $data);
    }

    public function view($id, BillDisplay $billDisplay)
    {
        $data = $billDisplay->make($id);

        return view('bills.view', $data);
    }

    public function create()
    {
    	return view('bills.edit');
    }
    
    public function store(Request $request)
    {
        try{
            $bill = $this->billCreatorService->make($request->only('name'));
        } catch(BillException $e) {
            return $this->returnWithErrors($e->getErrors());
        }
        
        return $this->returnItem($bill);
    }
}
