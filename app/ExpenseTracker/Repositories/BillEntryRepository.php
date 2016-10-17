<?php
namespace App\ExpenseTracker\Repositories;

use App\Models\BillEntry;

class BillEntryRepository {
    protected $billEntry;
    
    public function __construct(BillEntry $billEntry)
    {
        $this->billEntry = $billEntry;
    }
    
    public function all($billId)
    {
        $query = $this->billEntry->forBill($billId);
        
        return $query->get();
    }

    public function get($id)
    {
        return $this->billEntry->with('bill')->find($id);
    }
    
    public function create($input)
    {
        $billEntry = $this->billEntry->create($input);
        
        return $billEntry;
    }
}
