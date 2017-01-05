<?php

namespace App\ExpenseTracker\Services;

use App\ExpenseTracker\Repositories\BillRepository;
use App\ExpenseTracker\Validators\BillValidator;
use App\ExpenseTracker\Exceptions\BillException;
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
            throw new BillException($this->validator->getErrors());
        }
        
        try{
            $bill = Bill::forCurrentUser($attributes['name']);
        } catch(\Illuminate\Database\QueryException $e) {
            if($e->errorInfo[1] == 1062) {
                throw new BillException(['A bill already exists with the name you have supplied']);
            }
            else{
                throw new BillException(['A database error occured']);
            }
        }
        
        $this->billRepo->save($bill);
        
        return $bill;
    }
}