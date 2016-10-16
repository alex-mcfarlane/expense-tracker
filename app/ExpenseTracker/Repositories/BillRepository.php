<?php
namespace App\ExpenseTracker\Repositories;

use App\Models\Bill;

class BillRepository {
    protected $bill;
    
    public function __construct(Bill $bill)
    {
        $this->bill = $bill;
    }
    
    public function all()
    {
        $query = $this->bill->forUser();
        
        return $query->get();
    }

    public function get($id)
    {
        return $this->bill->with('entries')->find($id);
    }
    
    public function create($input)
    {
        $bill = $this->bill->create($input);
        
        return $bill;
    }
}
