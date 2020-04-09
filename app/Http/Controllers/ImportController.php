<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Import\Facades\Import;

class ImportController extends Controller
{
    public function create()
    {
    	return view('import.create');
    }

    public function store(Request $request)
    {
    	Import::start($request->only('file', 'password'));
    	
    	session()->flash('import_completed', true);

    	return redirect()->back();
    }
}
