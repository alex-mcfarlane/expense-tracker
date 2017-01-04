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
        
        //check if user is authorized for this bill
        if($bill->user_id != \Auth::id()) {
            throw new \App\ExpenseTracker\Exceptions\AuthorizationException('Not authorized to access this bill');
        }
        
        $entry = Entry::fromForm($attributes);

        $entry->isValid();
        
        $bill->addEntry($entry);
    }
}
