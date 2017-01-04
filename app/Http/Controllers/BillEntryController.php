<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\ExpenseTracker\Entry\EntryDisplay;
use App\ExpenseTracker\Repositories\BillRepository;
use App\ExpenseTracker\Repositories\BillEntryRepository;
use App\ExpenseTracker\Services\EntryCreatorService;
use App\ExpenseTracker\Services\EntryEditorService;
use App\ExpenseTracker\Factories\EntryPartialUpdaterFactory;
use App\ExpenseTracker\Exceptions\EntryException;

class BillEntryController extends BaseController
{
	protected $billRepo;
    protected $entryEditorService;
	protected $parentEntity = 'bills';

	public function __construct(BillRepository $billRepository, BillEntryRepository $billEntryRepository, 
            EntryCreatorService $entryCreatorService, EntryEditorService $entryEditorService)
	{   
		$this->billRepo = $billRepository;
        $this->billEntryRepo = $billEntryRepository;
        $this->entryCreatorService = $entryCreatorService;
        $this->entryEditorService = $entryEditorService;
        
        parent::__construct();
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
        try{
            $this->entryCreatorService->make($billId, $request->only('due_date', 'amount', 'paid'));
        } catch(EntryException $e) {
            return $this->returnWithErrors($e->getErrors());
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
        } catch(EntryException $e){
            return $this->returnWithErrors($e->getErrors());
        }

        return $this->returnParentItem($entry->bill_id);
    }

    public function partialUpdate(Request $request, $id)
    {
        $action = $request->input('action', false);

        if(!$action) {
            return $this->returnWithErrors(['No action has been specified']);
        }

        try{
            $entryPartialUpdater = EntryPartialUpdaterFactory::make($action);
        } catch(EntryException $e) {
            return $this->returnWithErrors($e->getErrors());
        }

        try{
            $entry = $entryPartialUpdater->update($id, $request);
        } catch(EntryException $e) {
            return $this->returnWithErrors($e->getErrors());
        }
        
        if($request->ajax())
        {
            return $this->returnJSON($entry);
        }
        else{
            return $this->returnParentItem($entry->bill_id);
        }
    }

    public function getPay($id, EntryDisplay $entryDisplay)
    {   
        $data = $entryDisplay->make($id);

        return view('billEntries.pay', $data);
    }

    public function destroy($id)
    {
        $this->billEntryRepo->delete($id);
    }
}
