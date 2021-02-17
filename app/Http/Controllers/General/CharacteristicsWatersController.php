<?php

namespace App\Http\Controllers\General;

use App\General\ChangeWaterReserves;
use App\General\CharacteristicsWaters;
use App\General\Chemicals;
use App\General\ListPosts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class CharacteristicsWatersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    if(\Illuminate\Support\Facades\Auth::user()->org_name == 'gidromet' || \Illuminate\Support\Facades\Auth::user()->org_name == 'other'  )
	    {
		    $posts_lists = ListPosts::where('isDelete',false)->get();
		    $chemicils = Chemicals::where('isDelete',false)->get();
		    $last_update_date = CharacteristicsWaters::select('updated_at','user_id','is_approve','years')->where('years',Input::get('year'))->orderBy('updated_at','DESC')->first();


		    $character_waters = CharacteristicsWaters::where('years',Input::get('year'))->with('post_list','chimicil_list')->paginate(10);
		    return view('general.pages.resources.characteristics_water.characteristics_water',[
			    'character_waters'=>$character_waters,
			    'posts_lists'=>$posts_lists,
			    'chemicils'=>$chemicils,
			    'year'=>Input::get('year'),
			    'last_update' => $last_update_date

		    ]);
	    }
	    else
	    {
	    	return abort(404);
	    }



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
		    'post_place' => 'required',
		    'chemicils' => 'required',
		    'average_excess' => 'required',
		    'date_observation' => 'required',
		    'excess_ratio' => 'required',
		    'year' => 'required',
	    ]);

	    $characters = new CharacteristicsWaters();
	    $characters->list_posts_id = Input::get('post_place');
	    $characters->chemicals_id = Input::get('chemicils');
	    $characters->average_excess = Input::get('average_excess');
	    $characters->date_observation = Input::get('date_observation');
	    $characters->excess_ratio = Input::get('excess_ratio');
	    $characters->years = Input::get('year');
	    $characters->user_id = Auth::id();
	    $characters->is_approve=false;
	    $characters->save();

	    return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
