<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ExhibitorContactsController extends Controller
{
    public function store(Request $request, $exhibitor)
    {
    	return $exhibitor->addContact($request->contact_id);
    }

    public function destroy($exhibitor, $contact)
    {
    	return $exhibitor->removeContact($contact->id);
    }
}
