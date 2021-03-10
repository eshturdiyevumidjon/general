<?php

namespace App\Http\Controllers\General;

use App\General\GroundWaterUse;
use App\General\Wateruse;
use App\General\WaterUseVariousNeeds;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class WaterUseVariousController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	if(Auth::user()->org_name == 'minvodxoz' || Auth::user()->org_name == 'other')
	    {
		    $water_use_needs = WaterUseVariousNeeds::where('years',$request->year)->count();
		    $last_update_date = WaterUseVariousNeeds::select('updated_at','user_id','is_approve','years')->where('years',$request->year)->orderBy('updated_at','DESC')->first();

		    if($water_use_needs == 0)
		    {
			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = "Республика Каракалпакистан";
			    $resource_regions->years = $request->year;
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = "Андижанский";
			    $resource_regions->years = $request->year;
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->years = $request->year;
			    $resource_regions->region_name = "Бухарский";
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = "Джизакский";
			    $resource_regions->years = $request->year;
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = "Кашкадарьинский";
			    $resource_regions->years = $request->year;
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = "Навоиский";
			    $resource_regions->years = $request->year;
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = "Наманганский";
			    $resource_regions->years = $request->year;
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = "Самаркандский";
			    $resource_regions->years = $request->year;
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = "Сурхандарьинский";
			    $resource_regions->years = $request->year;
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = "Сырдарьинский";
			    $resource_regions->years = $request->year;
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = "Ташкентский";
			    $resource_regions->years = $request->year;
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = "Ферганский";
			    $resource_regions->years = $request->year;
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = "Хорезмский";
			    $resource_regions->years = $request->year;
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = " Республика Узбекистан";
			    $resource_regions->years = $request->year;
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $water_use_needs = WaterUseVariousNeeds::orderby('id','ASC')->get();
			    return  view('general.pages.resources.water_user_variouse_needs.water_user_variouse_needs',[
				    'water_use_needs'=>$water_use_needs,
				    'year' => $request->year,
				    'last_update' => $last_update_date,
				    'id' => $request->id,
			    ]);
		    }
		    else
		    {
			    $water_use_needs = WaterUseVariousNeeds::where('years',$request->year)->orderby('id','ASC')->get();
			    return  view('general.pages.resources.water_user_variouse_needs.water_user_variouse_needs',[
				    'water_use_needs'=>$water_use_needs,
				    'year' => $request->year,
				    'last_update' => $last_update_date,
				    'id' => $request->id,
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
            case "from_surface_sources":
                WaterUseVariousNeeds::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'from_surface_sources'=>$request->param]);
                break;
            case 'from_underground_sources':
                WaterUseVariousNeeds::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'from_underground_sources'=>$request->param]);
                break;
            case 'total':
                WaterUseVariousNeeds::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'total'=>$request->param]);
                break;
            case 'irrigation':
                WaterUseVariousNeeds::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'irrigation'=>$request->param]);
                break;
            case 'industry':
                WaterUseVariousNeeds::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'industry'=>$request->param]);
                break;
            case 'utilities':
                WaterUseVariousNeeds::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'utilities'=>$request->param]);
                break;
            case 'fisheries':
                WaterUseVariousNeeds::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'fisheries'=>$request->param]);
                break;
            case 'irrevocably_energy':
                WaterUseVariousNeeds::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'irrevocably_energy'=>$request->param]);
                break;
            case 'other':
                WaterUseVariousNeeds::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'other'=>$request->param]);
                break;
        }
    }

	public function Accept(Request $request)
	{
		if(Auth::user()->org_name == 'gidromet')
		{
			$resources = WaterUseVariousNeeds::where('years',$request->get('year'))->update(['user_id'=>Auth::id(),'is_approve'=>true]);
		}

		return redirect()->back();
	}
}
