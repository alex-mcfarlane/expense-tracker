<?php

namespace App\ExpenseTracker\Factories;

use App\ExpenseTracker\Services\EntryPaymentService;
use App\ExpenseTracker\Services\EntryFullPaymentService;
use App\ExpenseTracker\Validators\EntryFullPaymentValidator;
use App\ExpenseTracker\Validators\EntryPaymentValidator;
use App\ExpenseTracker\Repositories\BillEntryRepository;

class EntryPartialUpdaterFactory
{
	public static function make($action)
	{
		switch($action) {
			case 'payment':
				return new EntryPaymentService(new EntryPaymentValidator, new BillEntryRepository);
			case 'full_payment':
				return new EntryFullPaymentService(new EntryFullPaymentValidator, new BillEntryRepository);
            default:
                throw new \App\ExpenseTracker\Exceptions\EntryException(['An invalid action has been supplied']);
		}
	}
}