<?php
namespace App\ExpenseTracker\Services;

use App\ExpenseTracker\Validators\EntryValidator;
use App\ExpenseTracker\Repositories\BillEntryRepository;
use App\ExpenseTracker\Exceptions\EntryNotFoundException;

class EntryPaymentService implements IEntryPartialUpdater
{
	protected $entryValidator;
	protected $entryRepo;

	public function __construct(EntryValidator $entryValidator, BillEntryRepository $entryRepo)
	{
		$this->validator = $entryValidator;
		$this->entryRepo = $entryRepo;
	}

	public function update($id, $attributes)
	{
        // does the entry exist?
        if(!$entry = $this->entryRepo->get($id)) {
            throw new EntryNotFoundException('Entry not found', ['Entry not found with the given id of '.$id]);
        }

        try{
        	$entry->pay($attributes['payment']);
        } catch(\App\ExpenseTracker\Exceptions\ValidationException $e) {
        	throw $e;
        }

        $this->entryRepo->save($entry);

        return $entry;
	}
}