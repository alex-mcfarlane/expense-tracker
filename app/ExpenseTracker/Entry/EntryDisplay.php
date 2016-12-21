<?php

namespace App\ExpenseTracker\Entry;

use App\ExpenseTracker\Repositories\BillEntryRepository;

class EntryDisplay
{
	protected $billEntryRepo;

	public function __construct(BillEntryRepository $billEntryRepo)
	{
		$this->repo = $billEntryRepo; 
	}

	public function make($id)
	{
		$entry = $this->repo->get($id);

        $data = [
            'bill' => $entry->bill,
            'entry' => $entry
        ];

        return $data;
	}
}