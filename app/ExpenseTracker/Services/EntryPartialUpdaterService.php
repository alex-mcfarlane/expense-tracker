<?php

namespace App\ExpenseTracker\Services;

use Illuminate\Http\Request;
use App\ExpenseTracker\Factories\EntryPartialUpdaterFactory;
use App\ExpenseTracker\Exceptions\EntryException;
use App\ExpenseTracker\Exceptions\EntryNotFoundException;
use App\ExpenseTracker\Exceptions\ValidationException;
use App\ExpenseTracker\Exceptions\AuthorizationException;

/**
 * EntryPartialUpdaterService class
 * Handles the updating of one field within a bill entry
 *
 * @author Alex McFarlane
 */

class EntryPartialUpdaterService {
    public static function update(Request $request, $id)
    {
        $action = $request->input('action', false);

        if(!$action) {
            throw new EntryException(['No action has been specified']);
        }

        $entryPartialUpdater = EntryPartialUpdaterFactory::make($action);

        try{
            $entry = $entryPartialUpdater->update($id, $request);
        } catch(EntryNotFoundException $e) {
            throw new EntryException($e->getErrors());
        } catch(ValidationException $e) {
            throw new EntryException($e->getErrors());
        } catch(AuthorizationException $e) {
            throw new EntryException($e->getErrors());
        }
        
        return $entry;
    }
}
