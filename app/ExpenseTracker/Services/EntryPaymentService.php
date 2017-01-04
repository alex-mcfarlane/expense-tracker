<?php
namespace App\ExpenseTracker\Services;

use App\ExpenseTracker\Validators\EntryPaymentValidator;
use App\ExpenseTracker\Repositories\BillEntryRepository;
use App\ExpenseTracker\Exceptions\EntryException;
use App\ExpenseTracker\Exceptions\ValidationException;
use App\ExpenseTracker\Exceptions\AuthorizationException;

class EntryPaymentService implements IEntryPartialUpdater
{
	protected $entryValidator;
	protected $entryRepo;

	public function __construct(EntryPaymentValidator $entryValidator, BillEntryRepository $entryRepo)
	{
		$this->validator = $entryValidator;
		$this->entryRepo = $entryRepo;
	}

	public function update($id, $request)
	{
        $attributes = $request->only('payment');
        // check if the user input is valid
    	if(!$this->validator->isValid($attributes)) {
            throw new EntryException($this->validator->getErrors());
        } 
        // does the entry exist?
        if(!$entry = $this->entryRepo->get($id)) {
            throw new EntryNotFoundException('Entry not found for given id of '.$id);
        }

        try{
        	$entry->pay($attributes['payment']);
        } catch(ValidationException $e) {
        	throw new EntryException($e->getErrors());
        } catch(AuthorizationException $e) {
        	throw new EntryException($e->getErrors());
        }

        $this->entryRepo->save($entry);

        return $entry;
	}
}