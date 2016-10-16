<?php
namespace App\ExpenseTracker\Gateways;

use App\ExpenseTracker\Repositories\BillRepository;
use Auth;

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

        $bill->user()->associate(Auth::user());
        $bill->save();

        return $listener->returnItem($bill);
    }
}
