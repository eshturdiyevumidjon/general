<?php

namespace App\Http\Controllers\General;

use App\General\ChangeWaterReserves;
use App\General\GroundwaterResources;
use App\General\GroundWaterUse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChangeWaterReservesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
	    if(Auth::user()->org_name == 'gidromet' || Auth::user()->org_name == 'other')
	    {
		    $change_waters = ChangeWaterReserves::where('years',$request->year)->count();
		    $last_update_date = ChangeWaterReserves::select('updated_at','user_id','is_approve','years')->where('years',$request->year)->orderBy('updated_at','DESC')->first();

		    if($change_waters == 0)
		    {
			    $change_water_reserv = new ChangeWaterReserves();
			    $change_water_reserv->lake = "Тюямуюнское";
			    $change_water_reserv->years = $request->year;
			    $change_water_reserv->user_id = Auth::id();
			    $change_water_reserv->is_approve=false;
			    $change_water_reserv->save();

			    $change_water_reserv = new ChangeWaterReserves();
			    $change_water_reserv->lake = "Капарас";
			    $change_water_reserv->years = $request->year;
			    $change_water_reserv->user_id = Auth::id();
			    $change_water_reserv->is_approve=false;
			    $change_water_reserv->save();

			    $change_water_reserv = new ChangeWaterReserves();
			    $change_water_reserv->lake = "Султансанджарское";
			    $change_water_reserv->years = $request->year;
			    $change_water_reserv->user_id = Auth::id();
			    $change_water_reserv->is_approve=false;
			    $change_water_reserv->save();


			    $change_water_reserv = new ChangeWaterReserves();
			    $change_water_reserv->lake = "Южносурханское";
			    $change_water_reserv->years = $request->year;
			    $change_water_reserv->user_id = Auth::id();
			    $change_water_reserv->is_approve=false;
			    $change_water_reserv->save();

			    $change_water_reserv = new ChangeWaterReserves();
			    $change_water_reserv->lake = "Чимкурганское";
			    $change_water_reserv->years = $request->year;
			    $change_water_reserv->user_id = Auth::id();
			    $change_water_reserv->is_approve=false;
			    $change_water_reserv->save();

			    $change_water_reserv = new ChangeWaterReserves();
			    $change_water_reserv->lake = "Пачкамарское";
			    $change_water_reserv->years = $request->year;
			    $change_water_reserv->user_id = Auth::id();
			    $change_water_reserv->is_approve=false;
			    $change_water_reserv->save();

			    $change_water_reserv = new ChangeWaterReserves();
			    $change_water_reserv->lake = "Каттакурганское";
			    $change_water_reserv->years = $request->year;
			    $change_water_reserv->user_id = Auth::id();
			    $change_water_reserv->is_approve=false;
			    $change_water_reserv->save();

			    $change_water_reserv = new ChangeWaterReserves();
			    $change_water_reserv->lake = "Чарвакское";
			    $change_water_reserv->years = $request->year;
			    $change_water_reserv->user_id = Auth::id();
			    $change_water_reserv->is_approve=false;
			    $change_water_reserv->save();

			    $change_water_reserv = new ChangeWaterReserves();
			    $change_water_reserv->lake = "Тюябугузское";
			    $change_water_reserv->years = $request->year;
			    $change_water_reserv->user_id = Auth::id();
			    $change_water_reserv->is_approve=false;
			    $change_water_reserv->save();

			    $change_water_reserv = new ChangeWaterReserves();
			    $change_water_reserv->lake = "Западный Арнасай";
			    $change_water_reserv->years = $request->year;
			    $change_water_reserv->user_id = Auth::id();
			    $change_water_reserv->is_approve=false;
			    $change_water_reserv->save();

			    $change_water_reserv = new ChangeWaterReserves();
			    $change_water_reserv->lake = "Аральское море";
			    $change_water_reserv->years = $request->year;
			    $change_water_reserv->user_id = Auth::id();
			    $change_water_reserv->is_approve=false;
			    $change_water_reserv->save();

			    $change_water_reserv = new ChangeWaterReserves();
			    $change_water_reserv->lake = "Андижанское";
			    $change_water_reserv->years = $request->year;
			    $change_water_reserv->user_id = Auth::id();
			    $change_water_reserv->is_approve=false;
			    $change_water_reserv->save();

			    $change_waters = ChangeWaterReserves::where('years',$request->year)->orderby('id','asc')->get();
			    return view('general.pages.resources.change_water_reserves.change_water_reserves',[
				    'change_waters'=>$change_waters,
				    'year' => $request->year,
				    'id' => $request->id,
				    'last_update' => $last_update_date
			    ]);
		    }
		    else
		    {
			    $change_waters = ChangeWaterReserves::where('years',$request->year)->orderby('id','asc')->get();
			    return view('general.pages.resources.change_water_reserves.change_water_reserves',[
				    'change_waters'=>$change_waters,
				    'year' => $request->year,
				    'id' => $request->id,
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        switch ($request->func)
        {
            case "average_water_volume":
                ChangeWaterReserves::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'average_water_volume'=>$request->param]);
                break;
            case 'average_long_term_level':
                ChangeWaterReserves::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'average_long_term_level'=>$request->param]);
                break;
            case 'water_supply':
                ChangeWaterReserves::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'water_supply'=>$request->param]);
                break;
            case 'annual_change':
                ChangeWaterReserves::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'annual_change'=>$request->param]);
                break;
            case 'water_level':
                ChangeWaterReserves::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'water_level'=>$request->param]);
                break;
            case 'change_for_year':
                ChangeWaterReserves::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'change_for_year'=>$request->param]);
                break;
        }
    }

	public function Accept(Request $request)
	{
		if(Auth::user()->org_name == 'gidromet')
		{
			$resources  = ChangeWaterReserves::where('years',$request->get('year'))->update(['user_id'=>Auth::id(),'is_approve'=>true]);
		}

		return redirect()->back();
	}
}
