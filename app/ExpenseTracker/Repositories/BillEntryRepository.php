<?php
namespace App\ExpenseTracker\Repositories;

use App\Models\BillEntry;

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
        return $this->billEntry->with('bill')->find($id);
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
