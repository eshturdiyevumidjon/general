<?php

namespace App\Http\Controllers\General;

use App\General\UiReserfs;
use App\General\Wateruse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WaterUsesController extends Controller
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
	    	$id = $request->id;
		    $water_uses   = Wateruse::where('years',$request->year)->count();
            $last_update_date = Wateruse::select('updated_at','user_id','is_approve','years')->where('years',$request->year)->orderBy('updated_at','DESC')->first();

		    if($water_uses == 0)
		    {
			    $uw_reserfs = new Wateruse();
			    $uw_reserfs->region_name = "Республика Каракалпакистан";
			    $uw_reserfs->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $uw_reserfs->save();

			    $resource_regions = new Wateruse();
			    $resource_regions->region_name = "Андижанский";
			    $resource_regions->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new Wateruse();
			    $resource_regions->years = $request->year;
			    $resource_regions->region_name = "Бухарский";
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new Wateruse();
			    $resource_regions->region_name = "Джизакский";
			    $resource_regions->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new Wateruse();
			    $resource_regions->region_name = "Кашкадарьинский";
			    $resource_regions->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new Wateruse();
			    $resource_regions->region_name = "Навоиский";
			    $resource_regions->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new Wateruse();
			    $resource_regions->region_name = "Наманганский";
			    $resource_regions->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new Wateruse();
			    $resource_regions->region_name = "Самаркандский";
			    $resource_regions->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new Wateruse();
			    $resource_regions->region_name = "Сурхандарьинский";
			    $resource_regions->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new Wateruse();
			    $resource_regions->region_name = "Сырдарьинский";
			    $resource_regions->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new Wateruse();
			    $resource_regions->region_name = "Ташкентский";
			    $resource_regions->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new Wateruse();
			    $resource_regions->region_name = "Ферганский";
			    $resource_regions->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new Wateruse();
			    $resource_regions->region_name = "Хорезмский";
			    $resource_regions->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new Wateruse();
			    $resource_regions->region_name = "Республика Узбекистан";
			    $resource_regions->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

                $water_uses = Wateruse::where('years',$request->year)->orderBy('id','ASC')->get();
			    return view('general.pages.resources.water_uses.water_uses',[
				    'water_uses'=>$water_uses,
				    'year' => $request->year,
				    'id' => $request->id,
                    'last_update' => $last_update_date
                ]);
		    }
		    else
		    {
			    $water_uses = Wateruse::where('years',$request->year)->orderBy('id','ASC')->get();
			    return view('general.pages.resources.water_uses.water_uses',[
				    'water_uses'=>$water_uses,
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
		    case "total_km":
			    Wateruse::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'total_km'=>$request->param]);
			    break;
		    case 'river_network':
			    Wateruse::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'river_network'=>$request->param]);
			    break;
		    case 'inland_rivers':
			    Wateruse::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'inland_rivers'=>$request->param]);
			    break;
		    case 'underground_sources':
			    Wateruse::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'underground_sources'=>$request->param]);
			    break;
		    case 'from_collector':
			    Wateruse::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'from_collector'=>$request->param]);
			    break;
	    }
    }

    public function Accept(Request $request)
    {
        if(Auth::user()->org_name == 'gidromet')
        {
            Wateruse::where('years',$request->get('year'))->update(['user_id'=>Auth::id(),'is_approve'=>true]);
        }

        return redirect()->back();
    }
}
