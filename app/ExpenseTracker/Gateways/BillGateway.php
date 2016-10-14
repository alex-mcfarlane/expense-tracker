<?php

use App\ExpenseTracker\Repositories\BillRepository;

class BillGateway {
    protected $billRepo;
    
    
    public function __construct(BillRepository $billRepository)
    {
        $this->billRepo = $billRepository;
    }
    
    public function create($listener, $input)
    {
        if(! $bill = $this->billRepo->create($input)) {
            return $listener->returnWithError('Unable to save bill');
        }
        
        return $listener->returnItem($bill);
    }
}
