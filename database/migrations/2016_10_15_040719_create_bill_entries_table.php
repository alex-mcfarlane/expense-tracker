<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_entries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bill_id');
            $table->decimal('amount', 10, 2);
            $table->decimal('balance', 10, 2);
            $table->decimal('paid', 10, 2);
            $table->date('due_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('billEntries');
    }
}
