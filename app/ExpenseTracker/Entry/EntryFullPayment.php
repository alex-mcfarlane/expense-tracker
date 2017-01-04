<?php

namespace App\ExpenseTracker\Entry;

use App\ExpenseTracker\Validators\EntryFullPaymentValidator;
use App\ExpenseTracker\Repositories\BillEntryRepository;
use App\ExpenseTracker\Exceptions\EntryException;

/**
 * EntryFullPaymentService
 * Service class that holds logic for paying off the remaining balanace of a bill entry
 *
 * @author Alex McFarlane
 */
class EntryFullPayment implements IEntryPartialUpdater{
    
    protected $validator;
    protected $entryRepo;
    
    public function __construct(EntryFullPaymentValidator $entryValidator, BillEntryRepository $entryRepo)
    {
        $this->validator = $entryValidator;
        $this->entryRepo = $entryRepo;
    }
    
    public function update($id, $request)
    {
        $attributes = $request->only('action');
        //ensure action has been specified by client
        if(!$this->validator->isValid($attributes)) {
            throw new EntryException($this->validator->getErrors());
        }
        //check that entry exists
        if(!$entry = $this->entryRepo->get($id)) {
            throw new EntryNotFoundException('Entry not found for given id of '.$id);
        }
        
        //pay the entry in full
        try{
            $entry->payFull();
        } catch(AuthorizationException $e) {
        	throw new EntryException($e->getErrors());
        }
        
        $this->entryRepo->save($entry);
        
        return $entry;
    }
    
}
