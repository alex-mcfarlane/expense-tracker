<?php
namespace App\ExpenseTracker\Gateways;

use App\ExpenseTracker\Repositories\BillEntryRepository;
use App\ExpenseTracker\Repositories\BillRepository;
use Auth;
use Validator;

class BillEntryGateway extends BaseGateway{
    protected $billEntryRepo;
    protected $billRepo;
    
    public function __construct(BillEntryRepository $billEntryRepository, BillRepository $billRepository)
    {
        $this->billEntryRepo = $billEntryRepository;
        $this->billRepo = $billRepository;
    }
    
    public function get($id)
    {
        $entry = $this->billEntryRepo->get($id);

        return $entry;
    }

    public function create($listener, $billId, $input)
    {
        $input['due_date'] = (string) $input['due_date'];
        
        if(!$this->validate($input)) {
            return $listener->returnWithErrors($this->errors);
        }

        $bill = $this->billRepo->get($billId);

        if(! $entry = $this->billEntryRepo->create($input)) {
            return $listener->returnWithErrors(['Unable to save bill']);
        }

        $entry->bill()->associate($bill);
        $entry->save();

        return $listener->returnParentItem($entry->bill_id);
    }

    public function update($listener, $id, $data)
    {
        if(! $entry = $this->get($id)) {
            return $listener->returnWithErrors(['Bill entry not found']);
        }

        if(!$entry = $this->billEntryRepo->update($entry, $data)) {
            return $listener->returnWithErrors([$this->billEntryRepo->getError()]);
        }

        return $listener->returnParentItem($entry->bill_id);
        
    }

    public function partialUpdate($listener, $id, $data)
    {
        if(! $entry = $this->billEntryRepo->get($id)) {
            return $listener->returnWithErrors(['Bill entry not found']);
        }

        if(isset($data['payment'])) {
            $entry->pay($data['payment']);
        }

        if(! $this->billEntryRepo->save($entry)) {
            return $listener->returnWithErrors([$this->billEntryRepo->getError()]);
        }

        return $listener->returnParentItem($entry->bill_id);
    }

    private function validate(array $input)
    {
        $validator = Validator::make($input, [
            'due_date' => 'date',
            'amount' => 'required|numeric|min:0',
            'balance' => 'numeric|min:0',
            'paid' => 'numeric|min:0',
        ]);

        if($validator->fails()) {
            $this->errors = $validator->errors();
            return false;
        }

        return true;
    }
}
