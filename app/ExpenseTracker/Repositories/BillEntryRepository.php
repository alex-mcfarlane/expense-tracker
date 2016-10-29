<?php
namespace App\ExpenseTracker\Repositories;

use App\Models\BillEntry;

class BillEntryRepository {
    protected $billEntry;
    protected $error;
    
    public function __construct(BillEntry $billEntry)
    {
        $this->billEntry = $billEntry;
    }
    
    public function all($billId)
    {
        $query = $this->billEntry->forBill($billId);
        
        return $query->get();
    }

    public function get($id)
    {
        return $this->billEntry->with('bill')->find($id);
    }
    
    public function create($input)
    {
        $billEntry = $this->billEntry->create($input);
        
        return $billEntry;
    }

    public function update($billEntry, array $data = null)
    {
        if(! $this->save($billEntry)) {
            $this->error = ('Unable to save bill entry.');
            return false;
        }

        return $billEntry;
    }

    public function save($model)
    {
        return $model->save();
    }

    public function getError()
    {
        return $this->error;
    }
}
