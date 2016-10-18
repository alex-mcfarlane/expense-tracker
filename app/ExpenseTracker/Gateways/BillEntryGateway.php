<?php
namespace App\ExpenseTracker\Gateways;

use App\ExpenseTracker\Repositories\BillEntryRepository;
use App\ExpenseTracker\Repositories\BillRepository;
use Auth;
use Validator;

class BillEntryGateway {
    protected $billEntryRepo;
    protected $billRepo;
    protected $errors;
    
    public function __construct(BillEntryRepository $billEntryRepository, BillRepository $billRepository)
    {
        $this->billEntryRepo = $billEntryRepository;
        $this->billRepo = $billRepository;
    }
    
    public function create($listener, $billId, $input)
    {
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

    private function validate($input)
    {
        $validator = Validator::make($input, [
            'due_datae' => 'date',
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
