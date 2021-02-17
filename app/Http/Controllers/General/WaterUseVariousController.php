<?php

namespace App\Http\Controllers\General;

use App\General\GroundWaterUse;
use App\General\Wateruse;
use App\General\WaterUseVariousNeeds;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class WaterUseVariousController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    if(\Illuminate\Support\Facades\Auth::user()->org_name == 'minvodxoz' || \Illuminate\Support\Facades\Auth::user()->org_name == 'other'  )
	    {
		    $water_use_needs   = WaterUseVariousNeeds::where('years',Input::get('year'))->count();
		    $last_update_date = WaterUseVariousNeeds::select('updated_at','user_id','is_approve','years')->where('years',Input::get('year'))->orderBy('updated_at','DESC')->first();


		    if($water_use_needs == 0)
		    {
			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = "Республика Каракалпакистан";
			    $resource_regions->years = Input::get('year');
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = "Андижанский";
			    $resource_regions->years = Input::get('year');
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->years = Input::get('year');
			    $resource_regions->region_name = "Бухарский";
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = "Джизакский";
			    $resource_regions->years = Input::get('year');
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = "Кашкадарьинский";
			    $resource_regions->years = Input::get('year');
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = "Навоиский";
			    $resource_regions->years = Input::get('year');
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = "Наманганский";
			    $resource_regions->years = Input::get('year');
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = "Самаркандский";
			    $resource_regions->years = Input::get('year');
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = "Сурхандарьинский";
			    $resource_regions->years = Input::get('year');
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = "Сырдарьинский";
			    $resource_regions->years = Input::get('year');
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = "Ташкентский";
			    $resource_regions->years = Input::get('year');
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = "Ферганский";
			    $resource_regions->years = Input::get('year');
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = "Хорезмский";
			    $resource_regions->years = Input::get('year');
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new WaterUseVariousNeeds();
			    $resource_regions->region_name = " Республика Узбекистан";
			    $resource_regions->years = Input::get('year');
			    $resource_regions->user_id = Auth::id();
			    $resource_regions->is_approve=false;
			    $resource_regions->save();

			    $water_use_needs = WaterUseVariousNeeds::orderby('id','ASC')->get();
			    return  view('general.pages.resources.water_user_variouse_needs.water_user_variouse_needs',[
				    'water_use_needs'=>$water_use_needs,
				    'year' => Input::get('year'),
				    'last_update' => $last_update_date

			    ]);
		    }
		    else
		    {
			    $water_use_needs = WaterUseVariousNeeds::where('years',Input::get('year'))->orderby('id','ASC')->get();
			    return  view('general.pages.resources.water_user_variouse_needs.water_user_variouse_needs',[
				    'water_use_needs'=>$water_use_needs,
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
            case "from_surface_sources":
                WaterUseVariousNeeds::where('id',Input::get('ids'))->update(['user_id'=>Auth::id(),'is_approve'=>false,'from_surface_sources'=>Input::get('param')]);
                break;
            case 'from_underground_sources':
                WaterUseVariousNeeds::where('id',Input::get('ids'))->update(['user_id'=>Auth::id(),'is_approve'=>false,'from_underground_sources'=>Input::get('param')]);
                break;
            case 'total':
                WaterUseVariousNeeds::where('id',Input::get('ids'))->update(['user_id'=>Auth::id(),'is_approve'=>false,'total'=>Input::get('param')]);
                break;
            case 'irrigation':
                WaterUseVariousNeeds::where('id',Input::get('ids'))->update(['user_id'=>Auth::id(),'is_approve'=>false,'irrigation'=>Input::get('param')]);
                break;
            case 'industry':
                WaterUseVariousNeeds::where('id',Input::get('ids'))->update(['user_id'=>Auth::id(),'is_approve'=>false,'industry'=>Input::get('param')]);
                break;
            case 'utilities':
                WaterUseVariousNeeds::where('id',Input::get('ids'))->update(['user_id'=>Auth::id(),'is_approve'=>false,'utilities'=>Input::get('param')]);
                break;
            case 'fisheries':
                WaterUseVariousNeeds::where('id',Input::get('ids'))->update(['user_id'=>Auth::id(),'is_approve'=>false,'fisheries'=>Input::get('param')]);
                break;
            case 'irrevocably_energy':
                WaterUseVariousNeeds::where('id',Input::get('ids'))->update(['user_id'=>Auth::id(),'is_approve'=>false,'irrevocably_energy'=>Input::get('param')]);
                break;
            case 'other':
                WaterUseVariousNeeds::where('id',Input::get('ids'))->update(['user_id'=>Auth::id(),'is_approve'=>false,'other'=>Input::get('param')]);
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

			$resources  = WaterUseVariousNeeds::where('years',$request->get('year'))->update(['user_id'=>Auth::id(),'is_approve'=>true]);

		}

		return redirect()->back();

	}
}
