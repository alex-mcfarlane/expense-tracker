<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\ExpenseTracker\Gateways\BillGateway;
use App\ExpenseTracker\Gateways\BillEntryGateway;
use App\ExpenseTracker\Repositories\BillRepository;

class BillEntryController extends BaseController
{
	protected $billGateway;
	protected $billRepo;
	protected $parentEntity = 'bills';

	public function __construct(BillGateway $billGateway, BillEntryGateway $billEntryGateway, BillRepository $billRepository)
	{
		$this->billGateway = $billGateway;
		$this->billEntryGateway = $billEntryGateway;
		$this->billRepo = $billRepository;
	}

    public function create($billId)
    {
    	$bill = $this->billRepo->get($billId);

    	$data = [
    		'bill' => $bill
    	];

    	return view('billEntries.edit', $data);
    }

    public function store(Request $request, $billId)
    {
    	$data = $request->input();
    	return $this->billEntryGateway->create($this, $billId, $data);
    }
}
