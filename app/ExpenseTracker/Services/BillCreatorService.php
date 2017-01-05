<?php

namespace App\ExpenseTracker\Services;

use App\ExpenseTracker\Repositories\BillRepository;
use App\ExpenseTracker\Validators\BillValidator;
use App\ExpenseTracker\Exceptions\EntryException;
use App\Models\Bill;

/**
 * BillCreatorService
 * Service class that holds the business logic for creating a bill
 * 
 * @author Alex McFarlane
 */
class BillCreatorService 
{
    protected $validator;
    protected $billRepo;
    
    public function __construct(BillValidator $validator, BillRepository $billRepo)
    {
        $this->validator = $validator;
        $this->billRepo = $billRepo;
    }
    
    public function make(array $attributes)
    {
        if(!$this->validator->isValid($attributes)) {
            throw new EntryException($this->validator->getErrors());
        }
        
        $bill = Bill::forCurrentUser($attributes['name']);
        
        $this->billRepo->save($bill);
        
        return $bill;
    }
}
