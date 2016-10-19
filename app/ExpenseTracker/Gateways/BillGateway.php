<?php
namespace App\ExpenseTracker\Gateways;

use App\ExpenseTracker\Repositories\BillRepository;
use Auth;
use Validator;

class BillGateway extends BaseGateway{
    protected $billRepo;
    protected $errors;
    
    public function __construct(BillRepository $billRepository)
    {
        $this->billRepo = $billRepository;
    }
    
    public function create($listener, $input)
    {
        if(!$this->validate($input))
        {
            return $listener->returnWithErrors($this->errors);
        }

        if(! $bill = $this->billRepo->create($input)) {
            return $listener->returnWithErrors(['Unable to save bill']);
        }

        $bill->user()->associate(Auth::user());
        $bill->save();

        return $listener->returnItem($bill);
    }

    public function get($id)
    {
        $bill = $this->billRepo->get($id);
        $entries = $bill->entries;

        return [
            'bill' => $bill,
            'entries' => $entries
        ];
    }

    private function validate(array $input)
    {
        $validator = Validator::make($input, [
            'name' => 'required|max:255'
        ]);

        if($validator->fails()) {
            $this->errors = $validator->errors();
            return false;
        }

        return true;
    }
}
