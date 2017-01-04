<?php
namespace App\ExpenseTracker\Services;

interface IEntryPartialUpdater
{
	public function update($id, $request);
}