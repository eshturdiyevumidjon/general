<?php

namespace App\Http\Controllers\General;

use App\General\Chemicals;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChemicilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	$chemicil = Chemicals::where('isDelete',false)->orderby('id','ASC')->paginate(10);
        return view('general.pages.directories.chemicils',[
        	'directories'=>$chemicil
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
	    $request->validate([
		    'name' => 'required|unique:chemicals',
	    ]);

	    $chemicils = new Chemicals();
	    $chemicils->name = $request->name;
	    $chemicils->save();

	    return redirect(route('general.directories.chimicil'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $chemicil = Chemicals::find($request->id);
        return $chemicil;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
	    $request->validate([
		    'name' => 'required|unique:chemicals',
	    ]);

	    $chemicil = Chemicals::find($request->id);
	    $chemicil->name = $request->name;
	    $chemicil->save();

	    return redirect(route('general.directories.chimicil'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $chemicil = Chemicals::find($id);
        $chemicil->isDelete = true;
        $chemicil->save();

        return redirect(route('general.directories.chimicil'));
    }
}
