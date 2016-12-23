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
    	$this->validator->make($attributes);

    	if(!$entry = $this->billEntryRepo->get($id)) {
            throw new EntryNotFoundException('Entry not found', ['Entry not found with the given id of '.$id]);
        }
 
        $this->billEntryRepo->update($id, $attributes);

        return $entry;
    }
}