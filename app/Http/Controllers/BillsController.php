<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\ExpenseTracker\Repositories\BillRepository;
use App\ExpenseTracker\Gateways\BillGateway;
use App\ExpenseTracker\Services\BillCreatorService;

class BillsController extends BaseController
{
    protected $billGateway;
    protected $billRepo;
    protected $billCreatorService;
    
    public function __construct(BillGateway $billGateway, BillRepository $billRepository, 
            BillCreatorService $billCreatorService)
    {
        $this->entity = 'bills';
        $this->billRepo = $billRepository;
        $this->billGateway = $billGateway;
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

    public function view($id)
    {
        $data = $this->billGateway->get($id);

        return view('bills.view', $data);
    }

    public function create()
    {
    	return view('bills.edit');
    }
    
    public function store(Request $request)
    {
        $bill = $this->billCreatorService->make($request->only('name'));
        
        return $this->returnItem($bill);
    }
}
