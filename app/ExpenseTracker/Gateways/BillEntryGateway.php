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

    public function get($id)
    {
        $bill = $this->billRepo->get($id);
        $entries = $bill->entries;

        return [
            'bill' => $bill,
            'entries' => $entries
        ];
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
