<?php

namespace App\Http\Controllers\Gidrogeologiya;

use App\Gidrogeologiya\MountainRanges;
use App\Gidrogeologiya\MountainRangesAttr;
use App\Gidrogeologiya\PlaceBirth;
use App\Gidrogeologiya\PlaceBirthAttrs;
use App\Gidrogeologiya\TypeWaterIntake;
use App\Gidrogeologiya\TypeWaterUse;
use App\UzDistricts;
use App\UzRegions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class MountainRangesController extends Controller
{
    public function index()
    {
    	$reestrs = MountainRanges::where('isDeleted',false)->with('MountainRangesAttr')->orderby('id','asc')->paginate(10);
	    $uz_regions = UzRegions::all();

    	return view('gidrogeologiya.pages.reestr.mountain_ranges.mountain_ranges',[
    		'reestrs'=>$reestrs,
		    'uz_regions'=>$uz_regions
	    ]);

    }

    public function store(Request $request)
    {
	    $request->validate([
		    'code' => 'required',
		    'name' => 'required|unique:mountain_ranges|min:3|max:40',
		    'year' => 'required'
	    ]);

	    $mr =  new MountainRanges();
	    $mr->code = Input::get('code');
	    $mr->name = Input::get('name');
	    $mr->comment = Input::get('comment');
	    $mr->year = Input::get('year');
	    $mr->save();




	    if(Input::get('districts') != null || Input::get('regions') != null)
	    {
		    if(Input::get('districts') == null)
		    {
			    foreach (Input::get('regions') as $key=>$region)
			    {
				    $mr_attr = new MountainRangesAttr();
				    $mr_attr->mountain_ranges_id = $mr->id;
				    $mr_attr->region_id = $region;
				    $mr_attr->save();
			    }
		    }
		    else
		    {
			    foreach (Input::get('districts') as $key=>$region)
			    {
				    $mr_attr = new MountainRangesAttr();
				    $mr_attr->mountain_ranges_id = $mr->id;
				    $region_id = UzDistricts::select('regionid')->where('areaid','=',$region)->first();
				    $mr_attr->region_id = $region_id->regionid;
				    $mr_attr->district_id = $region;
				    $mr_attr->save();
			    }
		    }
	    }


	    return redirect(route('gg.reestr.mr.index'));

    }

    public function edit(Request $request)
    {
    	if($request->has('id'))
	    {
		    $mr = MountainRanges::find($request->get('id'));
		    return $mr;
	    }
    	elseif($request->has('code'))
	    {
		    $mr = MountainRanges::where('isDeleted',false)->where('code',$request->get('code'))->whereBetween('year',[$request->get('start'),$request->get('finish')])->with('MountainRangesAttr')->get();
		    if(count($mr) > 0)
			    return $mr;
		    else
			    return "false";

	    }


    }

    public function update(Request $request)
    {
	    $request->validate([
		    'code' => 'required',
		    'name' => 'required|unique:mountain_ranges|min:3|max:40',
	    ]);

	    $mr = MountainRanges::find(Input::get('id'));
	    $mr->code = Input::get('code');
	    $mr->name = Input::get('name');
	    $mr->comment = Input::get('comment');
	    $mr->save();

	    MountainRangesAttr::where('mountain_ranges_id',Input::get('id'))->delete();
	    if(Input::get('districts') != null || Input::get('regions') != null)
	    {
		    if(Input::get('districts') == null)
		    {
			    foreach (Input::get('regions') as $key=>$region)
			    {
				    $mr_attr = new MountainRangesAttr();
				    $mr_attr->mountain_ranges_id = Input::get('id');
				    $mr_attr->region_id = $region;
				    $mr_attr->save();
			    }
		    }
		    else
		    {
			    foreach (Input::get('districts') as $key=>$region)
			    {
				    $mr_attr = new MountainRangesAttr();
				    $mr_attr->mountain_ranges_id = Input::get('id');
				    $region_id = UzDistricts::select('regionid')->where('areaid','=',$region)->first();
				    $mr_attr->region_id = $region_id->regionid;
				    $mr_attr->district_id = $region;
				    $mr_attr->save();
			    }
		    }

	    }

	    return redirect(route('gg.reestr.mr.index'));


    }

    public function destroy($id)
    {
	    $bp = MountainRanges::find($id);
	    $bp->isDeleted = true;
	    $bp->save();
	    return redirect(route('gg.reestr.mr.index'));

    }

    public function getSelectedRegions()
    {
	    $mr = MountainRangesAttr::select('region_id','district_id')->where('mountain_ranges_id','=', Input::get('id'))->get();

	    return $mr;

    }
}
