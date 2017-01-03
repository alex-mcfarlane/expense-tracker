<?php
namespace App\ExpenseTracker\Services;

use App\ExpenseTracker\Validators\EntryValidator;
use App\ExpenseTracker\Repositories\BillEntryRepository;
use App\ExpenseTracker\Exceptions\EntryNotFoundException;
use Auth;
use Validator;
use Request;

class EntryEditorService{
    protected $billEntryRepo;
    
    public function __construct(EntryValidator $validator, BillEntryRepository $billEntryRepository)
    {
    	$this->validator = $validator;
        $this->billEntryRepo = $billEntryRepository;
    }

    public function update($id, array $attributes)
    {
        // does the entry exist?
        if(!$entry = $this->billEntryRepo->get($id)) {
            throw new EntryNotFoundException('Entry not found', ['Entry not found with the given id of '.$id]);
        }

        // check if the user input is valid
    	if(!$this->validator->isValid($attributes)) {
            throw new \App\ExpenseTracker\Exceptions\ValidationException('Invalid user input', $this->validator->getErrors());
        }

        //fill model with new data
        $entry->fill($attributes);

        // ensure the model is in a valid state
        try{
            $entry->isValid();
        }
        catch(\App\ExpenseTracker\Exceptions\ValidationException $e){
            throw $e;
        }
 
        $this->billEntryRepo->save($entry);

        return $entry;
    }
}