<?php
namespace App\ExpenseTracker\Services;

use App\ExpenseTracker\Validators\EntryValidator;
use App\ExpenseTracker\Repositories\BillRepository;
use App\ExpenseTracker\Exceptions\ValidationException;
use App\ExpenseTracker\Exceptions\EntryException;
use App\ExpenseTracker\Exceptions\AuthorizationException;
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
            throw new EntryException($this->validator->getErrors());
        }
        
        //try to retrieve bill object
        $bill = $this->billRepo->get($billID);
        
        try{
            $entry = Entry::fromForm($bill, $attributes);
        } catch(AuthorizationException $e) {
            throw new EntryException($e->getErrors());
        } catch(ValidationException $e) {
            throw new EntryException($e->getErrors());
        }
        
        $bill->addEntry($entry);
    }
}
