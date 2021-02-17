<?php

namespace App\Http\Controllers\General;

use App\General\ResourcesRegions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Validation\Rules\In;

class ResourcesRegionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		    $resource_regions = ResourcesRegions::orderBy('id','ASC')->get();
		    return view('general.pages.resources.resources',[
			    'resources' => $resource_regions
		    ]);


    }

	public function Indexwith()
	{
		if(\Illuminate\Support\Facades\Auth::user()->org_name == 'gidromet' || \Illuminate\Support\Facades\Auth::user()->org_name == 'other'  )
		{
			$resource_with_year = ResourcesRegions::where('years',Input::get('year'))->count();
			if($resource_with_year  == 0)
			{
				$resource_regions = new \App\General\ResourcesRegions();
				$resource_regions->region_name = "Республика Каракалпакистан";
				$resource_regions->years = Input::get('year');
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve=false;
				$resource_regions->save();

				$resource_regions = new \App\General\ResourcesRegions();
				$resource_regions->region_name = "Андижанский";
				$resource_regions->years = Input::get('year');
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve=false;
				$resource_regions->save();

				$resource_regions = new \App\General\ResourcesRegions();
				$resource_regions->years = Input::get('year');
				$resource_regions->region_name = "Бухарский";
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve=false;
				$resource_regions->save();

				$resource_regions = new \App\General\ResourcesRegions();
				$resource_regions->region_name = "Джизакский";
				$resource_regions->years = Input::get('year');
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve=false;
				$resource_regions->save();

				$resource_regions = new \App\General\ResourcesRegions();
				$resource_regions->region_name = "Кашкадарьинский";
				$resource_regions->years = Input::get('year');
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve=false;
				$resource_regions->save();

				$resource_regions = new \App\General\ResourcesRegions();
				$resource_regions->region_name = "Навоиский";
				$resource_regions->years = Input::get('year');
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve=false;
				$resource_regions->save();

				$resource_regions = new \App\General\ResourcesRegions();
				$resource_regions->region_name = "Наманганский";
				$resource_regions->years = Input::get('year');
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve=false;
				$resource_regions->save();

				$resource_regions = new \App\General\ResourcesRegions();
				$resource_regions->region_name = "Самаркандский";
				$resource_regions->years = Input::get('year');
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve=false;
				$resource_regions->save();

				$resource_regions = new \App\General\ResourcesRegions();
				$resource_regions->region_name = "Сурхандарьинский";
				$resource_regions->years = Input::get('year');
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve=false;
				$resource_regions->save();

				$resource_regions = new \App\General\ResourcesRegions();
				$resource_regions->region_name = "Сырдарьинский";
				$resource_regions->years = Input::get('year');
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve=false;
				$resource_regions->save();

				$resource_regions = new \App\General\ResourcesRegions();
				$resource_regions->region_name = "Ташкентский";
				$resource_regions->years = Input::get('year');
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve=false;
				$resource_regions->save();

				$resource_regions = new \App\General\ResourcesRegions();
				$resource_regions->region_name = "Ферганский";
				$resource_regions->years = Input::get('year');
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve=false;
				$resource_regions->save();

				$resource_regions = new \App\General\ResourcesRegions();
				$resource_regions->region_name = "Хорезмский";
				$resource_regions->years = Input::get('year');
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve=false;
				$resource_regions->save();

				$resource_regions = new \App\General\ResourcesRegions();
				$resource_regions->region_name = "Республика Узбекистан";
				$resource_regions->years = Input::get('year');
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve=false;
				$resource_regions->save();

				$resource_regions = ResourcesRegions::where('years',Input::get('year'))->orderBy('id','ASC')->get();
				$last_update_date = ResourcesRegions::select('updated_at','user_id','is_approve','years')->where('years',Input::get('year'))->orderBy('updated_at','DESC')->first();
				return view('general.pages.resources.resources_regions.resources_region',[
					'resources' => $resource_regions,
					'year' => Input::get('year'),
					'last_update' => $last_update_date
				]);

			}
			else
			{
				$resource_regions = ResourcesRegions::where('years',Input::get('year'))->orderBy('id','ASC')->get();
				$last_update_date = ResourcesRegions::select('updated_at','user_id','is_approve','years')->where('years',Input::get('year'))->orderBy('updated_at','DESC')->first();

				return view('general.pages.resources.resources_regions.resources_region',[
					'resources' => $resource_regions,
					'year' => Input::get('year'),
					'last_update' => $last_update_date

				]);
			}

		}
		else
		{
			abort(404);
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
	        case "average_values":
		        ResourcesRegions::where('id',Input::get('ids'))->update(['average_values'=>Input::get('param'),'user_id'=>Auth::id(),'is_approve'=>false]);
	        	break;
	        case 'highest_values':
		        ResourcesRegions::where('id',Input::get('ids'))->update(['highest_values'=>Input::get('param'),'user_id'=>Auth::id(),'is_approve'=>false]);
		        break;
	        case 'smallest_value':
		        ResourcesRegions::where('id',Input::get('ids'))->update(['smallest_value'=>Input::get('param'),'user_id'=>Auth::id(),'is_approve'=>false]);
		        break;
	        case 'local_rows':
		        ResourcesRegions::where('id',Input::get('ids'))->update(['local_rows'=>Input::get('param'),'user_id'=>Auth::id(),'is_approve'=>false]);
		        break;
	        case 'inflow':
		        ResourcesRegions::where('id',Input::get('ids'))->update(['inflow'=>Input::get('param'),'user_id'=>Auth::id(),'is_approve'=>false]);
		        break;
	        case 'outflow_outside':
		        ResourcesRegions::where('id',Input::get('ids'))->update(['outflow_outside'=>Input::get('param'),'user_id'=>Auth::id(),'is_approve'=>false]);
		        break;
	        case 'shared_resources':
		        ResourcesRegions::where('id',Input::get('ids'))->update(['shared_resources'=>Input::get('param'),'user_id'=>Auth::id(),'is_approve'=>false]);
	        	break;
	        case "total_row":
		        ResourcesRegions::where('id',Input::get('ids'))->update(['total_row'=>Input::get('param'),'user_id'=>Auth::id(),'is_approve'=>false]);
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

		    if($request->get('type') == 'resource')
			     ResourcesRegions::where('years',$request->get('year'))->update(['user_id'=>Auth::id(),'is_approve'=>true]);

	    }

    	return redirect()->back();

    }
}
