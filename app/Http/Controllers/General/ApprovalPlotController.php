<?php

namespace App\Http\Controllers\General;

use App\Exports\Gidrogeologiya\ApprovalPlotsExport;
use App\Exports\Gidrogeologiya\ApprovalPlotsTemplateExport;
use App\Exports\Gidrogeologiya\BirthPlaceExport;
use App\Gidrogeologiya\ApprovalPlot;
use App\Gidrogeologiya\ApprovalPlotAttr;
use App\Gidrogeologiya\HydrologicalRegion;
use App\Gidrogeologiya\PlaceBirth;
use App\Gidrogeologiya\PlaceBirthAttrs;
use App\Gidrogeologiya\TypeWaterUse;
use App\Imports\Gidrogeologiya\ApprovalPlotsImport;
use App\UzDistricts;
use App\UzRegions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ApprovalPlotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	$request->session()->remove('orderBy');
    	if ($request->per_page) $request->session()->put('perPage', json_decode($request->per_page));
    	if($request->orderBy) $request->session()->put('orderBy', $request->orderBy);
    	if($request->orderType) $request->session()->put('orderType', $request->orderType);
    	if ($request->checkedRows) ApprovalPlot::whereIn('id', $request->checkedRows)->update(['isDeleted' => true]);

    	$ap = ApprovalPlot::where('isDeleted', false)
            ->orderBy($request->session()->get('orderBy') ?? 'id', $request->session()->get('orderType') ?? 'ASC')
            ->with('ap_attr','type_water_uses','birth_place')
            ->paginate($request->session()->get('perPage') ?? 10);

    	$uz_regions = UzRegions::all();
    	$birth_places = PlaceBirth::where('isDeleted', false)->get();
    	$type_wateruse = TypeWaterUse::where('isDeleted', false)->get();

    	return view('gidrogeologiya.pages.reestr.aproval_plots.aproval_plots')
        	->with('reestrs', $ap)
        	->with('uz_regions', $uz_regions)
        	->with('birth_places', $birth_places)
        	->with('type_wateruses', $type_wateruse);
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
    	$request->validate([
    		'code' => 'required',
    		'name' => 'required',
    		'year' => 'required',
    	]);

    	$ap = new ApprovalPlot();
    	$ap->code = Input::get('code');
    	$ap->name = Input::get('name');
    	$ap->lat = Input::get('lat');
    	$ap->long = Input::get('long');
    	$ap->comment = Input::get('comment');
    	$ap->location = Input::get('location');
    	$ap->year = Input::get('year');
    	$ap->total_reserves = Input::get('total_reserves');
    	$ap->category_a = Input::get('category_a');
    	$ap->category_b = Input::get('category_b');
    	$ap->category_c = Input::get('category_c');
    	$ap->stock_a_authority = Input::get('stock_a_authority');
    	$ap->approval_protocol = Input::get('approval_protocol');
    	$ap->approval_date = Input::get('approval_date');
    	$ap->water_volume = Input::get('water_volume');
    	$ap->birth_place_id = Input::get('bp_id');
		$ap->mineralization_from = Input::get('mineralization_from');
        $ap->mineralization_to = Input::get('mineralization_to');
        $ap->water_chemical_composition = Input::get('water_chemical_composition');
    	$ap->is_approve = false;
    	$ap->user_id = Auth::id();
    	$ap->save();

        foreach ($request->type_water_uses as $item) {
            DB::table('approval_plot_type_water_use')
                ->insert(['approval_plot_id' => $ap->id, 'type_water_use_id' => $item]);
        }

    	if(Input::get('districts') != null || Input::get('regions') != null)
    	{
    		if(Input::get('districts') == null)
    		{
    			foreach (Input::get('regions') as $key=>$region)
    			{
    				$ap_attr = new ApprovalPlotAttr();
    				$ap_attr->approval_plots_id = $ap->id;
    				$ap_attr->region_id = $region;
    				$ap_attr->save();
    			}
    		}
    		else
    		{
    			foreach (Input::get('districts') as $key=>$region)
    			{
    				$ap_attr = new ApprovalPlotAttr();
    				$ap_attr->approval_plots_id = $ap->id;
    				$region_id = UzDistricts::select('regionid')->where('areaid','=',$region)->first();
    				$ap_attr->region_id = $region_id->regionid;
    				$ap_attr->district_id = $region;
    				$ap_attr->save();
    			}
    		}

    	}


    	return redirect(route('gg.reestr.ap.index'));
    }

    public function getSelectedRegions()
    {
    	$ap_attr = ApprovalPlotAttr::select('region_id','district_id')->where('approval_plots_id','=', Input::get('id'))->get();

    	return $ap_attr;

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
    public function edit(Request $request)
    {
    	if($request->has('id'))
    	{
    		$ap = ApprovalPlot::whereId($request->id)->with('users','birth_place', 'type_water_uses')->first();
    		return $ap;
    	}
    	elseif($request->has('code'))
    	{
    		$ap = ApprovalPlot::where('code',$request->get('code'))->where('isDeleted',false)->whereBetween('year',[Input::get('start'),Input::get('finish')])->with('ap_attr','type_water_uses','birth_place')->get();
            
            if(count($ap) > 0)
    			return $ap;
    		else
    			return "false";
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
    	$request->validate([
    		'code' => 'required',
    		'name' => 'required',
    	]);

    	$ap = ApprovalPlot::find(Input::get('id'));
    	$ap->code = Input::get('code');
    	$ap->name = Input::get('name');
    	$ap->lat = Input::get('lat');
    	$ap->long = Input::get('long');
    	$ap->location = Input::get('location');
    	$ap->total_reserves = Input::get('total_reserves');
    	$ap->mineralization_from = Input::get('mineralization_from');
        $ap->mineralization_to = Input::get('mineralization_to');
        $ap->water_chemical_composition = Input::get('water_chemical_composition');
        $ap->category_a = Input::get('category_a');
    	$ap->category_b = Input::get('category_b');
    	$ap->category_c = Input::get('category_c');
        $ap->birth_place_id = Input::get('bp_id');
        $ap->stock_a_authority = Input::get('stock_a_authority');
    	$ap->approval_protocol = Input::get('approval_protocol');
    	$ap->approval_date = Input::get('approval_date');
    	$ap->water_volume = Input::get('water_volume');
    	$ap->comment = Input::get('comment');
    	$ap->is_approve = false;
    	$ap->user_id = Auth::id();
    	$ap->save();

        if ($request->type_water_uses) {
            DB::table('approval_plot_type_water_use')->where('approval_plot_id', $ap->id)->whereNotIn('type_water_use_id', $request->type_water_uses)->delete();
            foreach ($request->type_water_uses as $item) {
                DB::table('approval_plot_type_water_use')
                    ->updateOrInsert(
                        [
                            'approval_plot_id' => $ap->id,
                            'type_water_use_id' => $item
                        ],
                        [
                            'approval_plot_id' => $ap->id,
                            'type_water_use_id' => $item
                        ]
                    );
            }
        }

        ApprovalPlotAttr::where('approval_plots_id',Input::get('id'))->delete();
    	if(Input::get('districts') != null || Input::get('regions') != null)
    	{
    		if(Input::get('districts') == null)
    		{
    			foreach (Input::get('regions') as $key=>$region)
    			{
    				$ap_attr = new ApprovalPlotAttr();
    				$ap_attr->approval_plots_id = Input::get('id');
    				$ap_attr->region_id = $region;
    				$ap_attr->save();
    			}
    		}
    		else
    		{
    			foreach (Input::get('districts') as $key=>$region)
    			{
    				$ap_attr = new ApprovalPlotAttr();
    				$ap_attr->approval_plots_id = Input::get('id');
    				$region_id = UzDistricts::select('regionid')->where('areaid','=',$region)->first();
    				$ap_attr->region_id = $region_id->regionid;
    				$ap_attr->district_id = $region;
    				$ap_attr->save();
    			}
    		}

    	}

    	// return redirect(route('gg.reestr.ap.index'));
        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    	$ap = ApprovalPlot::find($id);
    	$ap->isDeleted = true;
    	$ap->save();
    	// return redirect(route('gg.reestr.ap.index'));
        return redirect()->back();
        
    }

    public function Export()
    {
    	return Excel::download(new ApprovalPlotsExport(), 'Утвержденные участки_'.Carbon::now().'.xlsx');

    }

    public function ExportTemplate()
    {
    	return Excel::download(new ApprovalPlotsTemplateExport(), 'Шаблон-Утвержденные участки_'.Carbon::now().'.xlsx');

    }

    public function Import()
    {
    	Excel::import(new ApprovalPlotsImport(), request()->file('select_file'));
    	return redirect(route('gg.reestr.ap.index'));
    }


    public function Search(Request $request)
    {
    	$queries = $request->all();
    	$data = ApprovalPlot::where("isDeleted", false);

			// dd(array_filter($queries));
    	if (array_filter($queries)) {
    		foreach ($queries as $key => $value) {
				// dd($value);
    			if(!is_null($value)) {
    				if($key == 'is_approve')
    					if($value == "all") $data = $data;
    				else $data = $data->where($key, $value);
    				if($key == "region")
                    {
                        $data = $data->whereHas('ap_attr.uz_regions', function ($query) {
                            $query->where('nameRu', 'ilike', '%' . request()->region . '%');
                        });
                    }
                    if($key == "birth_place")
                    {
                        $data = $data->whereHas('birth_place', function ($query) {
                            $query->where('name', 'ilike', '%' . request()->birth_place . '%');
                        });

                    }
    				if($key == "district")
                    {
                        $data = $data->whereHas('ap_attr.uz_districts', function ($query) {
                            $query->where('nameRu', 'ilike', '%' . request()->district . '%');
                        });
                    }
    				if($key == 'user')
                    {
                        $data = $data->whereHas('users', function ($query) {
                            $query->where('email', 'ilike',  '%' . request()->user . '%');
                        });
                    }
                    if($key == 'page' )
                    {

                    }
    				if($key != 'user' && $key != 'page' && $key != 'district' && $key != 'birth_place' && $key != 'region' &&  $key != 'is_approve')
                    {
                        $data = $data->where($key, "ilike", "%" . $value . "%");
                    }
    			}

    		}
    	} else return redirect(route('gg.reestr.ap.index'));



    	$ap = $data->with('ap_attr', 'type_water_uses','birth_place')->paginate($request->session()->get('perPage') ?? 10);
  		$uz_regions = UzRegions::all();
  		$birth_places = PlaceBirth::where('isDeleted', false)->get();
  		$type_wateruse = TypeWaterUse::where('isDeleted', false)->get();

  		return view('gidrogeologiya.pages.reestr.aproval_plots.aproval_plots')
  		->with('reestrs', $ap)
  		->with('uz_regions', $uz_regions)
  		->with('birth_places', $birth_places)
  		->with('type_wateruses', $type_wateruse);

    	// if(
    	// 	Input::get('code') != null ||
    	// 	Input::get('name') != null ||
    	// 	Input::get('region') != null ||
    	// 	Input::get('district') != null ||
    	// 	Input::get('users') != null |
    	// 	Input::get('is_approve') != null
    	// )
    	// {
    	// 	$ap = ApprovalPlot::orderby('id','ASC')->
    	// 	where('isDeleted','=',false);
    	// 	foreach (Input::all() as $key=>$element)
    	// 	{
    	// 		if(!empty($element))
    	// 		{
    	// 			if(
    	// 				$key != 'region' &&
    	// 				$key != 'district' &
    	// 				$key != 'users'

    	// 			)
    	// 			{
    	// 				if($key == 'is_approve')
    	// 				{
    	// 					$ap = $ap->
    	// 					where($key,$element);
    	// 				}
    	// 				else
    	// 				{
    	// 					$ap = $ap->
    	// 					where($key,'ilike','%' .$element. '%');

    	// 				}

    	// 			}
    	// 			if($key == 'region')
    	// 			{
    	// 				$ap = $ap-> whereHas('ap_attr.uz_regions', function ($query) {
    	// 					$query->where('nameUz', 'ilike','%' . Input::get('region'). '%');});

    	// 			}
    	// 			if($key == 'district')
    	// 			{
    	// 				$ap = $ap->whereHas('ap_attr.uz_districts', function ($query) {
    	// 					$query->where('nameUz', 'ilike', '%' .Input::get('district'). '%');});

    	// 			}
    	// 			if($key == 'users')
    	// 			{
    	// 				$ap = $ap->whereHas('users', function ($query) {
    	// 					$query->where('email', 'ilike',  '%' .Input::get('users'). '%');});

    	// 			}


    	// 		}
    	// 		else
    	// 		{

    	// 		}
    	// 	}

    	// 	$ap  =  $ap->with('ap_attr','type_water_uses')->paginate(10);
    	// 	$uz_regions = UzRegions::all();
    	// 	$birth_places = PlaceBirth::where('isDeleted',false)->get();
    	// 	$type_wateruse = TypeWaterUse::where('isDeleted',false)->get();

    	// 	return view('gidrogeologiya.pages.reestr.aproval_plots.aproval_plots')
    	// 	->with('reestrs', $ap)
    	// 	->with('uz_regions', $uz_regions)
    	// 	->with('birth_places', $birth_places)
    	// 	->with('type_wateruses', $type_wateruse);


    	// }
    	// else
    	// {
    	// 	return redirect(route('gg.reestr.ap.index'));
    	// }

    }

    public function Accept(Request $request)
    {
    	if(Auth::user()->hasRole('Administrator'))
    	{

    		ApprovalPlot::where('id',$request->get('id'))->where('year',$request->get('year'))->update(['user_id'=>Auth::id(),'is_approve'=>true]);

    	}

    	return redirect()->back();
    }

    public function AcceptAll(Request $request)
    {
    	if(Auth::user()->hasRole('Administrator'))
    	{
    		ApprovalPlot::wherein('id',$request->get('checkedRows'))->update(['user_id'=>Auth::id(),'is_approve'=>true]);
    		return redirect()->back();
    	}
    }

  }
