<?php

namespace App\Http\Controllers\General;

use App\General\ChangeWaterReserves;
use App\General\CharacteristicsWaters;
use App\General\Chemicals;
use App\General\ListPosts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CharacteristicsWatersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
	    if(Auth::user()->org_name == 'gidromet' || Auth::user()->org_name == 'other'  )
	    {
		    $posts_lists = ListPosts::where('isDelete',false)->get();
		    $chemicils = Chemicals::where('isDelete',false)->get();
		    $last_update_date = CharacteristicsWaters::select('updated_at','user_id','is_approve','years')->where('years',$request->year)->orderBy('updated_at','DESC')->first();


		    $character_waters = CharacteristicsWaters::where('years',$request->year)->with('post_list','chimicil_list')->paginate(10);
		    return view('general.pages.resources.characteristics_water.characteristics_water',[
			    'character_waters'=>$character_waters,
			    'posts_lists'=>$posts_lists,
			    'chemicils'=>$chemicils,
                'year'=>$request->year,
                'average_excess'=>$request->average_excess,
                'date_observation'=>$request->date_observation,
                'excess_ratio'=>$request->excess_ratio,
                'id'=>$request->id,
			    'last_update' => $last_update_date
		    ]);
	    }
	    else
	    {
	    	return abort(404);
	    }
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
	    $characters->list_posts_id = $request->post_place;
	    $characters->chemicals_id = $request->chemicils;
	    $characters->average_excess = $request->average_excess;
	    $characters->date_observation = $request->date_observation;
	    $characters->excess_ratio = $request->excess_ratio;
	    $characters->years = $request->year;
	    $characters->user_id = Auth::id();
	    $characters->is_approve=false;
	    $characters->save();

	    return redirect()->back();
    }
}
