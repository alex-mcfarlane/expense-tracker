<?php
namespace App\ExpenseTracker\Services;

use App\ExpenseTracker\Validators\EntryValidator;
use App\ExpenseTracker\Repositories\BillEntryRepository;
use App\ExpenseTracker\Exceptions\EntryNotFoundException;
use App\ExpenseTracker\Exceptions\ValidationException;
use App\ExpenseTracker\Exceptions\EntryException;
use App\ExpenseTracker\Exceptions\AuthorizationException;
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
        try{
            $entry = $this->billEntryRepo->get($id);
        } catch(EntryNotFoundException $e) {
            throw new EntryException([$e->getErrors()]);
        }



        // check if the user input is valid
    	if(!$this->validator->isValid($attributes)) {
            throw new EntryException($this->validator->getErrors());
        }

        try{
            $entry->edit($attributes);
        } catch(AuthorizationException $e) {
            throw new EntryException($e->getErrors());
        } catch(ValidationException $e) {
            throw new EntryException($e->getErrors());
        }

        $this->billEntryRepo->save($entry);

        return $entry;
    }
}