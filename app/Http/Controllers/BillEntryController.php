<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\ExpenseTracker\Entry\EntryDisplay;
use App\ExpenseTracker\Gateways\BillGateway;
use App\ExpenseTracker\Gateways\BillEntryGateway;
use App\ExpenseTracker\Repositories\BillRepository;
use App\ExpenseTracker\Repositories\BillEntryRepository;
use App\ExpenseTracker\Services\EntryCreatorService;
use App\ExpenseTracker\Services\EntryEditorService;

class BillEntryController extends BaseController
{
	protected $billGateway;
	protected $billRepo;
    protected $entryEditorService;
	protected $parentEntity = 'bills';

	public function __construct(BillGateway $billGateway, BillEntryGateway $billEntryGateway, BillRepository $billRepository, 
        BillEntryRepository $billEntryRepository, EntryEditorService $entryEditorService)
	{
		$this->billGateway = $billGateway;
		$this->billEntryGateway = $billEntryGateway;
		$this->billRepo = $billRepository;
        $this->billEntryRepo = $billEntryRepository;
        $this->entryEditorService = $entryEditorService;
        $this->validator = $validator;
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
        $entryCreator = new EntryCreator();
        
        try{
            $entryCreator->make($request->only('due_date', 'amount', 'paid'));
        } catch(\App\ExpenseTracker\Exceptions\ValidationException $e) {
            return $this->returnWithErrors($e->getErrors());
        }
        catch(\App\ExpenseTracker\Exceptions\ValidationException $e){
            return $this->returnWithErrors([$e->getErrors()]);
        }
        
        return $this->returnparentItem($billId);
    }

    public function edit($id, EntryDisplay $entryDisplay)
    {
        return view('billEntries.edit', $entryDisplay->make($id));
    }

    public function update(Request $request, $id)
    {
        $data = $request->only('amount', 'paid');

        try{
            $entry = $this->entryEditorService->update($id, $data);
        } catch(\App\ExpenseTracker\Exceptions\EntryNotFoundException $e){
            return $this->returnWithErrors([$e->getErrors()]);
        }

        return $this->returnParentItem($entry->bill_id);
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
