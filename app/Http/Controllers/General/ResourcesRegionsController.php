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
			'resources' => $resource_regions,
			'year' => null,
			'id' => null,
		]);
    }

	public function Indexwith(Request $request)
	{
		if(in_array(\Auth::user()->org_name, ['gidromet', 'other']))
		{
			$id = $request->id;
			$resource_with_year = ResourcesRegions::where('years', $request->year)->count();
			if($resource_with_year == 0)
			{
				$resource_regions = new ResourcesRegions();
				$resource_regions->region_name = "Республика Каракалпакистан";
				$resource_regions->years = $request->year;
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve = false;
				$resource_regions->save();

				$resource_regions = new ResourcesRegions();
				$resource_regions->region_name = "Андижанский";
				$resource_regions->years = $request->year;
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve = false;
				$resource_regions->save();

				$resource_regions = new ResourcesRegions();
				$resource_regions->years = $request->year;
				$resource_regions->region_name = "Бухарский";
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve = false;
				$resource_regions->save();

				$resource_regions = new ResourcesRegions();
				$resource_regions->region_name = "Джизакский";
				$resource_regions->years = $request->year;
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve = false;
				$resource_regions->save();

				$resource_regions = new ResourcesRegions();
				$resource_regions->region_name = "Кашкадарьинский";
				$resource_regions->years = $request->year;
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve = false;
				$resource_regions->save();

				$resource_regions = new ResourcesRegions();
				$resource_regions->region_name = "Навоиский";
				$resource_regions->years = $request->year;
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve = false;
				$resource_regions->save();

				$resource_regions = new ResourcesRegions();
				$resource_regions->region_name = "Наманганский";
				$resource_regions->years = $request->year;
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve = false;
				$resource_regions->save();

				$resource_regions = new ResourcesRegions();
				$resource_regions->region_name = "Самаркандский";
				$resource_regions->years = $request->year;
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve = false;
				$resource_regions->save();

				$resource_regions = new ResourcesRegions();
				$resource_regions->region_name = "Сурхандарьинский";
				$resource_regions->years = $request->year;
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve = false;
				$resource_regions->save();

				$resource_regions = new ResourcesRegions();
				$resource_regions->region_name = "Сырдарьинский";
				$resource_regions->years = $request->year;
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve = false;
				$resource_regions->save();

				$resource_regions = new ResourcesRegions();
				$resource_regions->region_name = "Ташкентский";
				$resource_regions->years = $request->year;
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve = false;
				$resource_regions->save();

				$resource_regions = new ResourcesRegions();
				$resource_regions->region_name = "Ферганский";
				$resource_regions->years = $request->year;
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve = false;
				$resource_regions->save();

				$resource_regions = new ResourcesRegions();
				$resource_regions->region_name = "Хорезмский";
				$resource_regions->years = $request->year;
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve = false;
				$resource_regions->save();

				$resource_regions = new ResourcesRegions();
				$resource_regions->region_name = "Республика Узбекистан";
				$resource_regions->years = $request->year;
				$resource_regions->user_id = Auth::id();
				$resource_regions->is_approve = false;
				$resource_regions->save();

				$resource_regions = ResourcesRegions::where('years', $request->year)->orderBy('id','ASC')->get();
				$last_update_date = ResourcesRegions::select('updated_at','user_id','is_approve','years')
					->where('years', $request->year)
					->orderBy('updated_at','DESC')
					->first();

				return view('general.pages.resources.resources_regions.resources_region',[
					'resources' => $resource_regions,
					'year' => $request->year,
					'id' => $id,
					'last_update' => $last_update_date
				]);
			}
			else
			{
				$resource_regions = ResourcesRegions::where('years', $request->year)->orderBy('id','ASC')->get();
				$last_update_date = ResourcesRegions::select('updated_at','user_id','is_approve','years')
					->where('years', $request->year)
					->orderBy('updated_at','DESC')
					->first();

				return view('general.pages.resources.resources_regions.resources_region',[
					'resources' => $resource_regions,
					'year' => $request->year,
					'id' => $id,
					'last_update' => $last_update_date

				]);
			}
		}
		else{
			abort(404);
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
	        case "average_values":
		        ResourcesRegions::where('id',$request->ids)->update(['average_values'=>$request->param,'user_id'=>Auth::id(),'is_approve'=>false]);
	        	break;
	        case 'highest_values':
		        ResourcesRegions::where('id',$request->ids)->update(['highest_values'=>$request->param,'user_id'=>Auth::id(),'is_approve'=>false]);
		        break;
	        case 'smallest_value':
		        ResourcesRegions::where('id',$request->ids)->update(['smallest_value'=>$request->param,'user_id'=>Auth::id(),'is_approve'=>false]);
		        break;
	        case 'local_rows':
		        ResourcesRegions::where('id',$request->ids)->update(['local_rows'=>$request->param,'user_id'=>Auth::id(),'is_approve'=>false]);
		        break;
	        case 'inflow':
		        ResourcesRegions::where('id',$request->ids)->update(['inflow'=>$request->param,'user_id'=>Auth::id(),'is_approve'=>false]);
		        break;
	        case 'outflow_outside':
		        ResourcesRegions::where('id',$request->ids)->update(['outflow_outside'=>$request->param,'user_id'=>Auth::id(),'is_approve'=>false]);
		        break;
	        case 'shared_resources':
		        ResourcesRegions::where('id',$request->ids)->update(['shared_resources'=>$request->param,'user_id'=>Auth::id(),'is_approve'=>false]);
	        	break;
	        case "total_row":
		        ResourcesRegions::where('id',$request->ids)->update(['total_row'=>$request->param,'user_id'=>Auth::id(),'is_approve'=>false]);
	        	break;
        }
    }

    public function Accept(Request $request)
    {
	    if(\Illuminate\Support\Facades\Auth::user()->org_name == 'gidromet')
	    {
		    if($request->get('type') == 'resource'){
			    ResourcesRegions::where('years',$request->get('year'))->update(['user_id'=>Auth::id(),'is_approve'=>true]);
		    }
	    }

    	return redirect()->back();
    }
}
