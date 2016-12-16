<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\ExpenseTracker\Gateways\BillGateway;
use App\ExpenseTracker\Gateways\BillEntryGateway;
use App\ExpenseTracker\Repositories\BillRepository;
use App\ExpenseTracker\Repositories\BillEntryRepository;

class BillEntryController extends BaseController
{
	protected $billGateway;
	protected $billRepo;
	protected $parentEntity = 'bills';

	public function __construct(BillGateway $billGateway, BillEntryGateway $billEntryGateway, BillRepository $billRepository, 
        BillEntryRepository $billEntryRepository)
	{
		$this->billGateway = $billGateway;
		$this->billEntryGateway = $billEntryGateway;
		$this->billRepo = $billRepository;
        $this->billEntryRepo = $billEntryRepository;
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

    public function update(Request $request, $id)
    {
        $data = $request->all();

        return $this->billEntryGateway->update($this, $id, $data);
    }

    public function partialUpdate(Request $request, $id)
    {
        $data = $request->all();
        return $this->billEntryGateway->partialUpdate($this, $id, $data);
    }

    public function getPay($id)
    {
        if(! $entry = $this->billEntryGateway->get($id))
        {
            return $this->returnWithErrors(['Bill entry not found']);
        }

        $data = [
            'entry' => $entry
        ];

        return view('billEntries.pay', $data);
    }

    public function destroy($id)
    {
        $this->billEntryRepo->delete($id);
    }
}
