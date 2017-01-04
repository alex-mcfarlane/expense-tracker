<?php
namespace App\ExpenseTracker\Entry;

interface IEntryPartialUpdater
{
	public function update($id, $request);
}