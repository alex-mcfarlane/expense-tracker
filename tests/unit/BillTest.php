<?php

use App\Models\Bill;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BillTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function can_get_amount_owing()
    {
        $bill = factory(Bill::class)->create();

        $bill->addEntry(100, 0, Carbon::parse('2016-12-24'));
        $bill->addEntry(250.36, 0, Carbon::parse('2016-12-24'));

        $this->assertEquals(350.36, $bill->totalBalance);
    }
}
