<?php
namespace App\ExpenseTracker\Gateways;

use App\ExpenseTracker\Repositories\BillEntryRepository;
use App\ExpenseTracker\Repositories\BillRepository;
use Auth;
use Validator;
use Request;

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

    public function update($id, $data)
    {
        return $this->billEntryRepo->update($entry->id, $data);
    }

    public function partialUpdate($listener, $id, $data)
    {
        if(! $entry = $this->billEntryRepo->get($id)) {
            return $listener->returnWithErrors(['Bill entry not found']);
        }

        if(isset($data['payment'])) {
            //make an explicit payment
            if(! $entry->pay($data['payment'])) {
                return $listener->returnWithErrors(['Amount exceeds remaining balance']);
            }
        }

        if(isset($data['pay']) && $data['pay'] == true) {
            //pay bill in full
            $entry->payFull();
        }

        //TODO partial update of other fields
        $this->billEntryRepo->save($entry);

        if(Request::ajax())
        {
            return $listener->returnJSON($entry);
        }
        else{
            return $listener->returnParentItem($entry->bill_id);
        }
    }

    private function validate(array $input)
    {
        $isValid = true;

        $validator = Validator::make($input, [
            'due_date' => 'date',
            'amount' => 'required|numeric|min:0',
            'balance' => 'numeric|min:0',
            'paid' => 'numeric|min:0',
        ]);

        if($validator->fails()) {
            $this->errors = $validator->errors();
            $isValid = false;
        }
        else if($input['paid'] > $input['amount']) {
            $this->errors[] = 'Payment amount exceeds remaining balance.';
            $isValid = false;
        }

        return $isValid;
    }
}
