<?php

use App\Models\Bill;
use App\Models\BillEntry;
use App\ExpenseTracker\Repositories\BillEntryRepository;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BillEntryTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	function can_delete_bill_entry_from_bill()
	{
		$bill = factory(Bill::class)->create();

        $billEntry = $bill->addEntry(100, 0, Carbon::parse('2016-12-24'));

        $billEntryRepository = new BillEntryRepository(new BillEntry);
        $billEntryRepository->delete($billEntry->id);

        $this->assertEquals(0, $bill->entries()->count());
	}

	/** @test */
	function can_edit_a_bill_entry()
	{
		
	}
}