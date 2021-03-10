<?php

namespace App\Http\Controllers\General;

use App\Exports\WaterbodiesExport;
use App\Exports\WaterbodiesTempplateExport;
use App\Exports\WaterworkTemplateExport;
use App\Imports\WaterbodiesImport;
use App\Imports\WaterworksImport;
use App\manipulation_type;
use App\UzDistricts;
use App\UzRegions;
use App\Waterbodies;
use App\Waterbodies_attr;
use App\WaterbodyTypes;
use App\waterwork_types;
use App\Waterworks_attr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;


class WaterbodiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->remove('orderBy');
        if ($request->orderBy) $request->session()->put('orderBy', $request->orderBy);
        if ($request->orderType) $request->session()->put('orderType', $request->orderType);

        $water_bodies = Waterbodies::where('isDeleted','=',false)->orderby($request->session()->get('orderBy') ?? 'id', $request->session()->get('orderType') ?? 'ASC')->with('waterbody_type','waterbody_attr')->paginate(10);
	    $wb_types = WaterbodyTypes::where('isDeleted','=',false)->get();
	    $uz_regions = UzRegions::all();




	    return view('pages.reestr.waterbodies.waterbodies')
		    ->with('uz_regions',$uz_regions)
		    ->with('water_bodies',$water_bodies)
		    ->with('wb_types',$wb_types);


//	    $water_bodies_attr = Waterbodies_attr::where('waterbody_id','=',$waterbodies->id)->get();
    }

	public function ajax()
	{
		$water_bodies = Waterbodies::orderby('id','ASC')->where('isDeleted','=',false)->get();




		return $water_bodies;


//	    $water_bodies_attr = Waterbodies_attr::where('waterbody_id','=',$waterbodies->id)->get();
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $wb_types = WaterbodyTypes::where('isDeleted','=',false)->get();
        $uz_regions = UzRegions::all();
        return view('pages.reestr.waterbodies.waterbodies_add')
            ->with('wb_types',$wb_types)
            ->with('uz_regions',$uz_regions);
    }

    public function getdistricts()
    {
        if(is_array(Input::get('regions')))
        {
            $uz_districts = UzDistricts::where('areacode','<>',400)->where('areacode','<>',260)->where('areacode','<>',200)->where('regionid','<',9999999)->wherein('regionid',Input::get('regions'))->get();

        }
        else
        {
            $uz_districts = UzDistricts::where('areacode','<>',400)->where('areacode','<>',260)->where('areacode','<>',200)->where('regionid','<',9999999)->where('regionid',Input::get('regions'))->get();

        }
        return $uz_districts;
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
            'code' => 'required|unique:waterbodies',
            'name' => 'required|max:255',
            'wb_type' => 'required|max:255'
        ]);

        $water_body = new Waterbodies();
        $water_body->code = Input::get('code');
        $water_body->name = Input::get('name');
        $water_body->waterbody_type_id = Input::get('wb_type');
        $water_body->exact_location = Input::get('target');
        $water_body->isDeleted = false;
        $water_body->save();
	    if(Input::get('districts') != null || Input::get('regions') != null)
	    {
		    if(Input::get('districts') == null) {
		        foreach (Input::get('regions') as $key=>$region)
		        {
		            $water_body_arr = new Waterbodies_attr();
		            $water_body_arr->waterbody_id = $water_body->id;
		            $water_body_arr->region_id = $region;
		            $water_body_arr->save();
		        }
		    }
		    else
		    {
			    foreach (Input::get('districts') as $key=>$region)
			    {
				    $water_body_arr = new Waterbodies_attr();
				    $water_body_arr->waterbody_id = $water_body->id;
				    $region_id = UzDistricts::select('regionid')->where('areaid','=',$region)->first();
				    $water_body_arr->region_id = $region_id->regionid;
				    $water_body_arr->district_id = $region;
				    $water_body_arr->save();
			    }
		    }
	    }




	    return  redirect()->route('wb.index');

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
    public function edit()
    {
        $waterbodies = Waterbodies::find(Input::get('id'));
        $wb_types = WaterbodyTypes::where('isDeleted','=',false)->get();
        $uz_regions = UzRegions::all();

        $water_bodies_attr = Waterbodies_attr::where('waterbody_id','=',$waterbodies->id)->get();
        return $waterbodies;
    }

    public function getSelectedRegions()
    {
        $water_bodies_attr = Waterbodies_attr::select('region_id','district_id')->where('waterbody_id','=', Input::get('id'))->get();

        return $water_bodies_attr;

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
            'name' => 'required|max:255',
            'wb_type' => 'required|max:255'


        ]);
        $waterbodies = Waterbodies::find(Input::get('id'));
        $waterbodies->code = Input::get('code');
        $waterbodies->name = Input::get('name');
        $waterbodies->waterbody_type_id = Input::get('wb_type');
	    $waterbodies->exact_location = Input::get('target');
	    $waterbodies->save();

	    Waterbodies_attr::where('waterbody_id','=',Input::get('id'))->delete();
	    if(Input::get('districts') != null || Input::get('regions') != null)
	    {
		    if(Input::get('districts') == null) {
			    foreach (Input::get('regions') as $key=>$region)
			    {
				    $water_body_arr = new Waterbodies_attr();
				    $water_body_arr->waterbody_id = Input::get('id');
				    $water_body_arr->region_id = $region;
				    $water_body_arr->save();
			    }
		    }
		    else
		    {
			    foreach (Input::get('districts') as $key=>$region)
			    {
				    $water_body_arr = new Waterbodies_attr();
				    $water_body_arr->waterbody_id = Input::get('id');
				    $region_id = UzDistricts::select('regionid')->where('areaid','=',$region)->first();
				    $water_body_arr->region_id = $region_id->regionid;
				    $water_body_arr->district_id = $region;
				    $water_body_arr->save();
			    }
		    }
	    }



	    return  redirect()->route('wb.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $watervodies = Waterbodies::find($id);
        $watervodies->isDeleted = true;
        $watervodies->save();
	    return  redirect()->route('wb.index');



    }

    public function ExportTemplate()
    {
        return Excel::download(new WaterbodiesTempplateExport(),'Природные водные объекты_'.Carbon::now().'.xlsx');

    }

    public function Import()
    {
        Excel::import(new WaterbodiesImport(), request()->file('select_file'));
        return redirect(route('wb.index'));
    }

    public function export()
    {
        return Excel::download(new WaterbodiesExport(), 'Природные водные объекты_'.Carbon::now().'.xlsx');
    }
    public function search()
    {
        if (Input::get('type') != null ||
            Input::get('code') != null ||
            Input::get('name') != null ||
            Input::get('regions') != null ||
            Input::get('districts') != null ||
            Input::get('lat') != null ||
            Input::get('long') != null ||
            Input::get('exact_location') != null
        ) {
            $waterbodies = Waterbodies::Orderby('id', 'ASC')
                ->where('isDeleted', false);
            foreach (Input::all() as $key => $element) {
                if (!empty($element)) {
                    if (
                        $key != 'regions' &&
                        $key != 'districts' &&
                        $key != 'type'

                    ) {
                        $waterbodies = $waterbodies->
                        where($key,'like','%' .$element. '%');
                    }
                    if ($key == 'regions') {
                        $waterbodies = $waterbodies->whereHas('waterbody_attr.uz_regions', function ($query) {
                            $query->where('nameUz', 'like', '%' .Input::get('regions'). '%');
                        });

                    }
                    if ($key == 'district') {
                        $waterbodies = $waterbodies->whereHas('waterbody_attr.uz_districts', function ($query) {
                            $query->where('nameUz', 'like', '%' .Input::get('districts'). '%');
                        });

                    }
                    if ($key == 'type') {
                        $waterbodies = $waterbodies->whereHas('waterbody_type', function ($query) {
                            $query->where('name', 'like', '%' .Input::get('type'). '%');
                        });

                    }


                } else {

                }


            }
            $water_bodies = $waterbodies->with('waterbody_type', 'waterbody_attr')->paginate(10);
            $wb_types = WaterbodyTypes::where('isDeleted', '=', false)->get();
            $uz_regions = UzRegions::all();


            return view('pages.reestr.waterbodies.waterbodies')
                ->with('uz_regions', $uz_regions)
                ->with('water_bodies', $water_bodies)
                ->with('wb_types', $wb_types);


        } else {
            return redirect(route('wb.index'));
        }
    }
    public function MultiSelect()
    {
        foreach (Input::get('checkeds') as $element)
        {
            Waterbodies::where('id',$element)->update(['isDeleted' => true]);
        }
    }

}
