<?php
namespace App\ExpenseTracker\Services;

use App\ExpenseTracker\Validators\EntryValidator;
use App\ExpenseTracker\Repositories\BillRepository;
use App\Models\Billentry as Entry;

class EntryCreatorService {
    protected $validator;
    protected $billRepo;
    
    public function __construct(EntryValidator $validator, BillRepository $billRepository)
    {
        $this->validator = $validator;
        $this->billRepo = $billRepository;
    }
    
    public function make($billID, array $attributes)
    {
        //user input validation
        if(! $this->validator->isValid($attributes)) {
            throw new \App\ExpenseTracker\Exceptions\ValidationException('Invalid user input', $this->validator->getErrors());
        }
        
        //try to retrieve bill object
        $bill = $this->billRepo->get($billID);
        
        $entry = Entry::fromForm($attributes);
        try{
            $entry->isValid();
        }
        catch(\App\ExpenseTracker\Exceptions\ValidationException $e){
            throw $e;
            return;
        }
        
        $bill->addEntry($entry);
    }
}
