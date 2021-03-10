<?php

namespace App\Http\Controllers\Gidrogeologiya;

use App\Exports\Gidrogeologiya\ApprovalPlotsExport;
use App\Exports\Gidrogeologiya\WaterCollactionExport;
use App\Exports\Gidrogeologiya\WaterCollactionImportTemplate;
use App\Gidrogeologiya\ApprovalPlot;
use App\Gidrogeologiya\ApprovalPlotAttr;
use App\Gidrogeologiya\PlaceBirth;
use App\Gidrogeologiya\TypeWaterIntake;
use App\Gidrogeologiya\TypeWaterUse;
use App\Gidrogeologiya\WaterCollecctions;
use App\Gidrogeologiya\WaterCollecctionsAttr;
use App\Imports\Gidrogeologiya\ApprovalPlotsImport;
use App\Imports\Gidrogeologiya\WaterCollactionImport;
use App\UzRegions;
use App\UzDistricts;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class WaterCollactionController extends Controller
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
    	if($request->checkedRows) WaterCollecctions::whereIn('id', $request->checkedRows)->update(['isDeleted' => true]);

		$reestrs = WaterCollecctions::where('isDeleted',false)
			->orderBy($request->session()->get('orderBy') ?? 'id', $request->session()->get('orderType') ?? 'ASC')
			->with('water_collaction_attr', 'birth_place', 'water_use_type', 'water_intakes')
			->paginate($request->session()->get('perPage') ?? 20);
	    $uz_regions = UzRegions::all();
	    $uz_districts = UzDistricts::all();
	    $type_wateruses = TypeWaterUse::where('isDeleted',false)->get();
	    $type_water_intakes = TypeWaterIntake::where('isDeleted',false)->get();
        $birth_places = PlaceBirth::where('isDeleted',false)->get();
	
		return view('gidrogeologiya.pages.reestr.water_collactions.water_collactions', compact('reestrs', 'uz_regions', 'uz_districts', 'type_wateruses', 'type_water_intakes', 'birth_places'));
		
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
	    ]);

	    $wc =  new WaterCollecctions();
	    $wc->code = Input::get('code');
	    $wc->name = Input::get('name');
	    $wc->lat = Input::get('lat');
	    $wc->long = Input::get('long');
	    $wc->location = Input::get('location');
	    $wc->birth_place_id = Input::get('bp_id');
	    $wc->total_reserves = Input::get('total_reserves');
	    $wc->stock_a_authority = Input::get('stock_a_authority');
	    $wc->year_construction = Input::get('year_construction');
	    $wc->water_user = Input::get('water_use');
	    $wc->type_water_use_id = Input::get('type_water_use_id');
	    $wc->type_water_intakes_id = Input::get('type_water_intakes_id');
	    $wc->number_wells = Input::get('number_wells');
	    $wc->number_active_wells = Input::get('number_active_wells');
	    $wc->amount_water_received = Input::get('amount_water_received');
	    $wc->water_quality = Input::get('water_quality');
	    $wc->mineralization = Input::get('mineralization');
	    $wc->rigidity = Input::get('rigidity');
        if($request->filepath)
            $wc->path = $request->filepath;
	    $wc->year = Input::get('year');
	    $wc->is_approve = false;
	    $wc->user_id = Auth::id();
	    $wc->save();


	    if(Input::get('districts') != null || Input::get('regions') != null)
	    {
		    if(Input::get('districts') == null)
		    {
			    foreach (Input::get('regions') as $key=>$region)
			    {
				    $wc_attr = new WaterCollecctionsAttr();
				    $wc_attr->water_collections_id = $wc->id;
				    $wc_attr->region_id = $region;
				    $wc_attr->save();
			    }
		    }
		    else
		    {
			    foreach (Input::get('districts') as $key=>$region)
			    {
				    $wc_attr = new WaterCollecctionsAttr();
				    $wc_attr->water_collections_id = $wc->id;
				    $region_id = UzDistricts::select('regionid')->where('areaid','=',$region)->first();
				    $wc_attr->region_id = $region_id->regionid;
				    $wc_attr->district_id = $region;
				    $wc_attr->save();
			    }
		    }

	    }
	    return redirect(route('gg.reestr.wc.index'));

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
            $wells = WaterCollecctions::where('id',Input::get('id'))->with('users')->first();
            return $wells;
        }
        elseif($request->has('code'))
        {
            $wells = WaterCollecctions::where('code',$request->get('code'))->where('isDeleted',false)->whereBetween('year',[Input::get('start'),Input::get('finish')])->with('water_collaction_attr','water_use_type','water_intakes','users','birth_place')->get();
            if(count($wells)  > 0)
                return $wells;
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
	    $wc = WaterCollecctions::find(Input::get('id'));
	    $wc->code = Input::get('code');
	    $wc->name = Input::get('name');
	    $wc->lat = Input::get('lat');
	    $wc->long = Input::get('long');
        $wc->birth_place_id = Input::get('bp_id');
        $wc->location = Input::get('location');
	    $wc->total_reserves = Input::get('total_reserves');
	    $wc->stock_a_authority = Input::get('stock_a_authority');
	    $wc->year_construction = Input::get('year_construction');
	    $wc->water_user = Input::get('water_use');
	    $wc->type_water_use_id = Input::get('type_water_use_id');
	    $wc->type_water_intakes_id = Input::get('type_water_intakes_id');
	    $wc->number_wells = Input::get('number_wells');
	    $wc->number_active_wells = Input::get('number_active_wells');
	    $wc->amount_water_received = Input::get('amount_water_received');
	    $wc->water_quality = Input::get('water_quality');
	    $wc->mineralization = Input::get('mineralization');
	    $wc->rigidity = Input::get('rigidity');
        if($request->lithology_well_design)
            $wc->path = $request->lithology_well_design;
	    $wc->is_approve = false;
	    $wc->user_id = Auth::id();
	    $wc->save();

	    WaterCollecctionsAttr::where('water_collections_id',Input::get('id'))->delete();
	    if(Input::get('districts') != null || Input::get('regions') != null)
	    {
		    if(Input::get('districts') == null)
		    {
			    foreach (Input::get('regions') as $key=>$region)
			    {
				    $wc_attr = new WaterCollecctionsAttr();
				    $wc_attr->water_collections_id = Input::get('id');
				    $wc_attr->region_id = $region;
				    $wc_attr->save();
			    }
		    }
		    else
		    {
			    foreach (Input::get('districts') as $key=>$region)
			    {
				    $wc_attr = new WaterCollecctionsAttr();
				    $wc_attr->water_collections_id = Input::get('id');
				    $region_id = UzDistricts::select('regionid')->where('areaid','=',$region)->first();
				    $wc_attr->region_id = $region_id->regionid;
				    $wc_attr->district_id = $region;
				    $wc_attr->save();
			    }
		    }

	    }

	    // return redirect(route('gg.reestr.wc.index'));
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
	    $wc = WaterCollecctions::find($id);
	    $wc->isDeleted = true;
	    $wc->save();
	    // return redirect(route('gg.reestr.wc.index'));
        return redirect()->back();    
	    
    }

	public function getSelectedRegions()
	{
		$ap_attr = WaterCollecctionsAttr::select('region_id','district_id')->where('water_collections_id','=', Input::get('id'))->get();
		return $ap_attr;
	}

	public function Export()
	{
		return Excel::download(new WaterCollactionExport(), 'ВОДОЗАБОРЫ_'.Carbon::now().'.xlsx');
	}

	public function ExportTemplate()
	{
		return Excel::download(new WaterCollactionImportTemplate(), 'Шаблон-ВОДОЗАБОРЫ__'.Carbon::now().'.xlsx');
	}

	public function Import()
	{
		Excel::import(new WaterCollactionImport(), request()->file('select_file'));
		return redirect(route('gg.reestr.wc.index'));
	}

	public function Search(Request $request)
	{
//		 dd($request->all());
        $filtered_requests = array_filter($request->all());
		if($filtered_requests) {
			$wc = WaterCollecctions::orderby('id','ASC')->where('isDeleted', false);
			foreach ($filtered_requests as $key => $element) {
				if(!empty($element)) {
					if(
						$key != 'region' &&
						$key != 'district' &&
						$key != 'birth_place' &&
						$key != 'users'
					) {
						if($key == 'is_approve')
							$wc = $wc->where($key, $element);
						else
							$wc = $wc->where($key, 'ilike', '%' . $element . '%');
					}

					if($key == 'region')
						$wc = $wc-> whereHas('water_collaction_attr.uz_regions', function ($query) use($element) {
							$query->where('regionid', $element);
						});

					if($key == 'district')
						$wc = $wc->whereHas('water_collaction_attr.uz_districts', function ($query) use($element) {
                            $query->where('areaid', $element);
						});

                    if($key == "birth_place")
                        $wc = $wc->whereHas('birth_place', function ($query) use($element) {
                            $query->where('name', 'ilike', '%' . $element . '%');
                        });

					if($key == 'users')
						$wc = $wc->whereHas('users', function ($query) use($element) {
							$query->where('email', 'ilike',  '%' . $element . '%');
					    });

				}
			}

            $reestrs = $wc->with('water_collaction_attr', 'birth_place', 'water_use_type', 'water_intakes')
                ->paginate($request->session()->get('perPage') ?? 20);
            $uz_regions = UzRegions::all();
            $uz_districts = UzDistricts::all();
            $type_wateruses = TypeWaterUse::where('isDeleted',false)->get();
            $type_water_intakes = TypeWaterIntake::where('isDeleted',false)->get();
            $birth_places = PlaceBirth::where('isDeleted',false)->get();
        
            return view('gidrogeologiya.pages.reestr.water_collactions.water_collactions', compact('reestrs', 'uz_regions', 'uz_districts', 'type_wateruses', 'type_water_intakes', 'birth_places'));
		} else
            return redirect(route('gg.reestr.wc.index'));

	}

	public function Accept(Request $request)
	{
		if(Auth::user()->hasRole('Administrator'))
		{

			WaterCollecctions::where('id',$request->get('id'))->where('year',$request->get('year'))->update(['user_id'=>Auth::id(),'is_approve'=>true]);

		}

		return redirect()->back();
	}

	public function AcceptAll(Request $request)
	{
		if(Auth::user()->hasRole('Administrator'))
		{
			WaterCollecctions::wherein('id',$request->get('checkedRows'))->update(['user_id'=>Auth::id(),'is_approve'=>true]);
			return redirect()->back();
		}
	}


}
