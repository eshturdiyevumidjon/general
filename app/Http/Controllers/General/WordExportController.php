<?php

namespace App\Http\Controllers\General;

use App\General\ChangeWaterReserves;
use App\General\CharacteristicsWaters;
use App\General\GroundwaterResources;
use App\General\GroundWaterUse;
use App\General\ResourcesRegions;
use App\General\RiverFlowRecources;
use App\General\UiReserfs;
use App\General\Wateruse;
use App\General\WaterUseVariousNeeds;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\General\InformationLargeCanalsIrigationSystem;

class WordExportController extends Controller
{
	public function index()
	{
		return view('general.pages.resources.report');
	}

    public function GenereteWord(Request $request)
    {
	    $resource_regions = ResourcesRegions::where('years',$request->year)->orderBy('id','ASC')->get();
	    $uw_resers = UiReserfs::where('years',$request->year)->orderby('id','ASC')->get();
	    $water_uses = Wateruse::where('years',$request->year)->orderBy('id','ASC')->get();
	    $river_recourses = RiverFlowRecources::where('years',$request->year)->orderby('id','ASC')->get();
	    $ground_waters = GroundwaterResources::where('years',$request->year)->orderBy('id','ASC')->get();
	    $ground_water_uses = GroundWaterUse::where('years',$request->year)->orderby( 'id', 'ASC' )->get();
	    $water_use_needs = WaterUseVariousNeeds::where('years',$request->year)->orderby('id','ASC')->get();
	    $information_large_canals = InformationLargeCanalsIrigationSystem::where('years',$request->year)->orderby('id','ASC')->get();
	    $change_waters = ChangeWaterReserves::where('years',$request->year)->orderby('id','asc')->get();
	    $character_waters = CharacteristicsWaters::where('years',$request->year)->with('post_list','chimicil_list')->paginate(10);

	    return view('general.pages.resources.book',[
	    	'resource_regions'=>$resource_regions,
	    	'uw_resers'=>$uw_resers,
	    	'water_uses'=>$water_uses,
	    	'river_recourses'=>$river_recourses,
	    	'ground_waters'=>$ground_waters,
	    	'ground_water_uses'=>$ground_water_uses,
	    	'water_use_needs'=>$water_use_needs,
	    	'information_large_canals'=>$information_large_canals,
	    	'change_waters'=>$change_waters,
	    	'character_waters'=>$character_waters,
	    ]);
    }
}
