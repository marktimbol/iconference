<?php

namespace App\Http\Controllers\Dashboard;

use App\Exhibitor;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JavaScript;

class ExhibitorsController extends Controller
{
    public function index()
    {
    	$exhibitors = Exhibitor::latest()->get();
    	return view('dashboard.exhibitors.index', compact('exhibitors'));
    }

    public function show($exhibitor)
    {
        JavaScript::put([
            'signedIn'  => Auth::check(),
            'exhibitor'  => $exhibitor,
        ]);
        return view('dashboard.exhibitors.show', compact('exhibitor'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required|min:2'
        ]);

        Exhibitor::create($request->all());

        flash()->success('Success: An Exhibitor has been successfully created.');
        return redirect()->route('dashboard.exhibitors.index');
    }

    public function edit($exhibitor)
    {
        $exhibitors = Exhibitor::latest()->get();
    	return view('dashboard.exhibitors.edit', compact('exhibitor', 'exhibitors'));
    }

    public function update(Request $request, $exhibitor)
    {
        $this->validate($request, [
            'name'  => 'required|min:2'
        ]);
        
        $exhibitor->update($request->all());

        flash()->success('Success: An Exhibitor has been successfully updated.');
        return redirect()->route('dashboard.exhibitors.index');
    }

    public function destroy($exhibitor)
    {
    	$exhibitor->delete();

        flash()->success('Success: An Exhibitors has been successfully deleted.');
        return redirect()->route('dashboard.exhibitors.index');
    }
}
