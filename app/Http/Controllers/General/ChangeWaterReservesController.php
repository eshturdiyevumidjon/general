<?php

namespace App\Http\Controllers\General;

use App\General\ChangeWaterReserves;
use App\General\GroundwaterResources;
use App\General\GroundWaterUse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class ChangeWaterReservesController extends Controller
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
		    $change_waters = ChangeWaterReserves::where('years',Input::get('year'))->count();
		    $last_update_date = ChangeWaterReserves::select('updated_at','user_id','is_approve','years')->where('years',Input::get('year'))->orderBy('updated_at','DESC')->first();


		    if($change_waters == 0)
		    {
			    $change_water_reserv = new \App\General\ChangeWaterReserves();
			    $change_water_reserv->lake = "Тюямуюнское";
			    $change_water_reserv->years = Input::get('year');
			    $change_water_reserv->user_id = Auth::id();
			    $change_water_reserv->is_approve=false;
			    $change_water_reserv->save();

			    $change_water_reserv = new \App\General\ChangeWaterReserves();
			    $change_water_reserv->lake = "Капарас";
			    $change_water_reserv->years = Input::get('year');
			    $change_water_reserv->user_id = Auth::id();
			    $change_water_reserv->is_approve=false;
			    $change_water_reserv->save();

			    $change_water_reserv = new \App\General\ChangeWaterReserves();
			    $change_water_reserv->lake = "Султансанджарское";
			    $change_water_reserv->years = Input::get('year');
			    $change_water_reserv->user_id = Auth::id();
			    $change_water_reserv->is_approve=false;
			    $change_water_reserv->save();


			    $change_water_reserv = new \App\General\ChangeWaterReserves();
			    $change_water_reserv->lake = "Южносурханское";
			    $change_water_reserv->years = Input::get('year');
			    $change_water_reserv->user_id = Auth::id();
			    $change_water_reserv->is_approve=false;
			    $change_water_reserv->save();

			    $change_water_reserv = new \App\General\ChangeWaterReserves();
			    $change_water_reserv->lake = "Чимкурганское";
			    $change_water_reserv->years = Input::get('year');
			    $change_water_reserv->user_id = Auth::id();
			    $change_water_reserv->is_approve=false;
			    $change_water_reserv->save();

			    $change_water_reserv = new \App\General\ChangeWaterReserves();
			    $change_water_reserv->lake = "Пачкамарское";
			    $change_water_reserv->years = Input::get('year');
			    $change_water_reserv->user_id = Auth::id();
			    $change_water_reserv->is_approve=false;
			    $change_water_reserv->save();

			    $change_water_reserv = new \App\General\ChangeWaterReserves();
			    $change_water_reserv->lake = "Каттакурганское";
			    $change_water_reserv->years = Input::get('year');
			    $change_water_reserv->user_id = Auth::id();
			    $change_water_reserv->is_approve=false;
			    $change_water_reserv->save();

			    $change_water_reserv = new \App\General\ChangeWaterReserves();
			    $change_water_reserv->lake = "Чарвакское";
			    $change_water_reserv->years = Input::get('year');
			    $change_water_reserv->user_id = Auth::id();
			    $change_water_reserv->is_approve=false;
			    $change_water_reserv->save();

			    $change_water_reserv = new \App\General\ChangeWaterReserves();
			    $change_water_reserv->lake = "Тюябугузское";
			    $change_water_reserv->years = Input::get('year');
			    $change_water_reserv->user_id = Auth::id();
			    $change_water_reserv->is_approve=false;
			    $change_water_reserv->save();

			    $change_water_reserv = new \App\General\ChangeWaterReserves();
			    $change_water_reserv->lake = "Западный Арнасай";
			    $change_water_reserv->years = Input::get('year');
			    $change_water_reserv->user_id = Auth::id();
			    $change_water_reserv->is_approve=false;
			    $change_water_reserv->save();

			    $change_water_reserv = new \App\General\ChangeWaterReserves();
			    $change_water_reserv->lake = "Аральское море";
			    $change_water_reserv->years = Input::get('year');
			    $change_water_reserv->user_id = Auth::id();
			    $change_water_reserv->is_approve=false;
			    $change_water_reserv->save();

			    $change_water_reserv = new \App\General\ChangeWaterReserves();
			    $change_water_reserv->lake = "Андижанское";
			    $change_water_reserv->years = Input::get('year');
			    $change_water_reserv->user_id = Auth::id();
			    $change_water_reserv->is_approve=false;
			    $change_water_reserv->save();

			    $change_waters = ChangeWaterReserves::where('years',Input::get('year'))->orderby('id','asc')->get();
			    return view('general.pages.resources.change_water_reserves.change_water_reserves',[
				    'change_waters'=>$change_waters,
				    'year' => Input::get('year'),
				    'last_update' => $last_update_date


			    ]);

		    }
		    else
		    {
			    $change_waters = ChangeWaterReserves::where('years',Input::get('year'))->orderby('id','asc')->get();
			    return view('general.pages.resources.change_water_reserves.change_water_reserves',[
				    'change_waters'=>$change_waters,
				    'year' => Input::get('year'),
				    'last_update' => $last_update_date


			    ]);

		    }
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
        //
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
    public function update(Request $request)
    {
        switch (Input::get('func'))
        {
            case "average_water_volume":
                ChangeWaterReserves::where('id',Input::get('ids'))->update(['user_id'=>Auth::id(),'is_approve'=>false,'average_water_volume'=>Input::get('param')]);
                break;
            case 'average_long_term_level':
                ChangeWaterReserves::where('id',Input::get('ids'))->update(['user_id'=>Auth::id(),'is_approve'=>false,'average_long_term_level'=>Input::get('param')]);
                break;
            case 'water_supply':
                ChangeWaterReserves::where('id',Input::get('ids'))->update(['user_id'=>Auth::id(),'is_approve'=>false,'water_supply'=>Input::get('param')]);
                break;
            case 'annual_change':
                ChangeWaterReserves::where('id',Input::get('ids'))->update(['user_id'=>Auth::id(),'is_approve'=>false,'annual_change'=>Input::get('param')]);
                break;
            case 'water_level':
                ChangeWaterReserves::where('id',Input::get('ids'))->update(['user_id'=>Auth::id(),'is_approve'=>false,'water_level'=>Input::get('param')]);
                break;
            case 'change_for_year':
                ChangeWaterReserves::where('id',Input::get('ids'))->update(['user_id'=>Auth::id(),'is_approve'=>false,'change_for_year'=>Input::get('param')]);
                break;

        }
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

	public function Accept(Request $request)
	{
		if(\Illuminate\Support\Facades\Auth::user()->org_name == 'gidromet')
		{

			$resources  = ChangeWaterReserves::where('years',$request->get('year'))->update(['user_id'=>Auth::id(),'is_approve'=>true]);

		}

		return redirect()->back();

	}
}
