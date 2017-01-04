<?php
namespace App\ExpenseTracker\Repositories;

use App\Models\BillEntry;
use App\ExpenseTracker\Exceptions\EntryNotFoundException;

class BillEntryRepository {
    protected $billEntry;
    protected $error;
    
    public function __construct()
    {
        $this->billEntry = new BillEntry();
    }
    
    public function all($billId)
    {
        $query = $this->billEntry->forBill($billId);
        
        return $query->get();
    }

    public function get($id)
    {
        if(! $entry = $this->billEntry->with('bill')->find($id)){
            throw new EntryNotFoundException('Entry not found for the given id of '.$id);
        }
        
        return $entry;
    }
    
    public function create($input)
    {
        $billEntry = $this->billEntry->create($input);
        
        return $billEntry;
    }

    public function update($id, array $data)
    {
        return $this->billEntry->where("id", $id)->update($data);
    }

    public function save($model)
    {
        return $model->save();
    }

    public function delete($id)
    {
        return $this->billEntry->destroy($id);
    }

    public function getError()
    {
        return $this->error;
    }
}
