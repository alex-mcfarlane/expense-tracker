<?php
namespace App\ExpenseTracker\Bills;

use \App\ExpenseTracker\Repositories\BillRepository;
/**
 * Description of BillDisplay
 *
 * @author AlexMc
 */
class BillDisplay {
    protected $billRepo;
    
    public function __construct(BillRepository $billRepo)
    {
        $this->billRepo = $billRepo;
    }
    
    public function make($billId)
    {
        $bill = $this->billRepo->get($billId);
        
        $entries = $bill->entries;

        return [
            'bill' => $bill,
            'entries' => $entries
        ];
    }
}
