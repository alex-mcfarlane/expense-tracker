<?php
namespace App\ExpenseTracker\Gateways;

use App\ExpenseTracker\Repositories\BillEntryRepository;
use App\ExpenseTracker\Repositories\BillRepository;
use Auth;

class BillEntryGateway {
    protected $billEntryRepo;
    protected $billRepo;
    
    public function __construct(BillEntryRepository $billEntryRepository, BillRepository $billRepository)
    {
        $this->billEntryRepo = $billEntryRepository;
        $this->billRepo = $billRepository;
    }
    
    public function create($listener, $billId, $input)
    {
        $bill = $this->billRepo->get($billId);

        if(! $entry = $this->billEntryRepo->create($input)) {
            return $listener->returnWithError('Unable to save bill');
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
}
