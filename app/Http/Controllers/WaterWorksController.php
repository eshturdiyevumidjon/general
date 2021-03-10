<?php

namespace App\Http\Controllers;

use App\capital_classes;
use App\Exports\ReservoirsTemplateExport;
use App\Exports\WaterworkExport;
use App\Exports\WaterworkTemplateExport;
use App\Imports\WaterworksImport;
use App\Reservoirs_attr;
use App\UzRegions;
use App\Waterbodies;
use App\waterwork_functions;
use App\waterwork_types;
use App\Waterworks;
use App\Waterworks_attr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;
use App\UzDistricts;
use Maatwebsite\Excel\Facades\Excel;


class WaterWorksController extends Controller
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
        if ($request->per_page) $request->session()->put('perPage', json_decode($request->per_page));
        if($request->has('checkeds'))
        {
            Waterworks::whereIn('id', array_map('intval', explode(',', $request->checkeds)))->update(['is_approve' => true,'user_id'=>Auth::id()]);
        }
	    if($request->has('year'))
	    {
		    Cookie::queue(Cookie::forever('year', $request->year));

	    }
	    elseif(!$request->hasCookie('year') && !$request->has('year'))
	    {
		    Cookie::queue(Cookie::forever('year', Carbon::now()->year));
	    }
	    $waterworks = Waterworks::orderby( 'id', 'ASC' )->
	    where( 'isDeleted', '=', false );
	    if(
		    Input::get('waterbody_id') != null ||
		    Input::get('region') != null ||
		    Input::get('district') != null ||
		    Input::get('code') != null ||
		    Input::get('name') != null ||
		    Input::get('water_source') != null ||
		    Input::get('water_users') != null ||
		    Input::get('class_capital') != null ||
		    Input::get('waterbody_type') != null ||
		    Input::get('dam_max_height') != null ||
		    Input::get('throughput_capacity') != null ||
		    Input::get('year') != null ||
		    Input::get('launch_date') != null ||
		    Input::get('wateruser_orgs') != null ||
		    Input::get('book_value') != null ||
		    Input::get('type') != null ||
		    Input::get('functions') != null||
		    Input::get('users') != null ||
		    Input::get('location') != null ||
		    Input::get('comment') != null ||
		    Input::get('is_approve') != null) {
		    $waterworks = Waterworks::orderby( 'id', 'ASC' )->
		    where( 'isDeleted', '=', false );
		    foreach ( Input::all() as $key => $element ) {
			    if ( ! empty( $element ) ) {
				    if (
					    $key != 'region' &&
					    $key != 'district' &&
					    $key != 'type' &&
					    $key != 'page' &&
					    $key != 'year' &&
					    $key != 'functions' &&
					    $key != 'class_capital' &&
					    $key != 'waterbody_type' &&
					    $key != 'users'

				    ) {
					    if ( $key == 'is_approve' ) {
						    $waterworks = $waterworks->
						    where( $key, $element );
					    } else {
						    $waterworks = $waterworks->
						    where( $key, 'like', '%' . $element . '%' );

					    }

				    }
				    if ( $key == 'year' ) {
					    if ( $element != 'all' ) {
						    $waterworks = $waterworks->
						    where( $key, '=', Input::get( 'year' ) );
					    } else {
						    $waterworks = $waterworks->
						    where( $key, '<>', null );
					    }


				    }


				    if ( $key == 'region' ) {
					    $waterworks = $waterworks->whereHas( 'waterwork_attr.uz_regions', function ( $query ) {
						    $query->where( 'nameUz', 'like', '%' . Input::get( 'region' ) . '%' );
					    } );

				    }
				    if ( $key == 'district' ) {
					    $waterworks = $waterworks->whereHas( 'waterwork_attr.uz_districts', function ( $query ) {
						    $query->where( 'nameUz', 'like', '%' . Input::get( 'district' ) . '%' );
					    } );

				    }
				    if ( $key == 'waterbody_type' ) {
					    $waterworks = $waterworks->whereHas( 'water_work_type', function ( $query ) {
						    $query->where( 'name', 'like', '%' . Input::get( 'waterbody_type' ) . '%' );
					    } );

				    }
				    if ( $key == 'functions' ) {
					    $waterworks = $waterworks->whereHas( 'waterwork_func', function ( $query ) {
						    $query->where( 'name', 'like', '%' . Input::get( 'functions' ) . '%' );
					    } );

				    }
				    if ( $key == 'users' ) {
					    $waterworks = $waterworks->whereHas( 'users', function ( $query ) {
						    $query->where( 'email', 'ilike', '%' . Input::get( 'users' ) . '%' );
					    } );

				    }
				    if ( $key == 'class_capital' ) {
					    $waterworks = $waterworks->whereHas( 'class_capital', function ( $query ) {
						    $query->where( 'name', 'ilike', '%' . Input::get( 'class_capital' ) . '%' );
					    } );

				    }

			    } else {

			    }
		    }
		    $waterworks = $waterworks->with('waterbodies','water_work_type','waterwork_func','waterwork_attr','users')->paginate($request->session()->get('perPage') ?? 10);

	    }
	    else
	    {
		    if($request->hasCookie('year')) {
			    if ( $request->cookie( 'year' ) == 'all' ) {
				    $waterworks = Waterworks::where('isDeleted','=',false)->orderBy($request->session()->get('orderBy') ?? 'id', $request->session()->get('orderType') ?? 'ASC')->where('year','<>',null)->with('water_work_type','waterwork_func','waterwork_attr','users')->paginate($request->session()->get('perPage') ?? 10);

			    }
			    else
			    {
				    $waterworks = Waterworks::where('isDeleted','=',false)->orderBy($request->session()->get('orderBy') ?? 'id', $request->session()->get('orderType') ?? 'ASC')->where('year',$request->cookie('year'))->with('water_work_type','waterwork_func','waterwork_attr','users')->paginate($request->session()->get('perPage') ?? 10);


			    }
		    }
		    else
		    {
			    $waterworks = Waterworks::where('isDeleted','=',false)->orderBy($request->session()->get('orderBy') ?? 'id', $request->session()->get('orderType') ?? 'ASC')->where('year',Carbon::now()->year)->with('water_work_type','waterwork_func','waterwork_attr','users')->paginate($request->session()->get('perPage') ?? 10);


		    }





	    }


	    $years = Waterworks::select('year')->where('isDeleted','=',false)->groupBy('year')->get();
	    $waterbodies = Waterbodies::where('isDeleted','=',false)->get();
	    $uz_regions = UzRegions::all();
	    $waterwork_function = waterwork_functions::where('isDeleted','=',false)->get();
	    $classes = capital_classes::where('isDeleted','=',false)->get();
	    $types = waterwork_types::where('isDeleted','=',false)->get();



        return view('pages.reestr.waterworks.waterworks')
            ->with('waterworks',$waterworks)
            ->with('perPage',$waterworks->perPage())
            ->with('currentPage',$waterworks->currentPage())
	        ->with('waterbodies',$waterbodies)
	        ->with('uz_regions',$uz_regions)
	        ->with('waterwork_function',$waterwork_function)
	        ->with('classes',$classes)
	        ->with('types',$types)
	        ->with('years',$years);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $waterbodies = Waterbodies::where('isDeleted','=',false)->get();
        $uz_regions = UzRegions::all();
        $waterwork_function = waterwork_functions::where('isDeleted','=',false)->get();
        $classes = capital_classes::where('isDeleted','=',false)->get();
        $types = waterwork_types::where('isDeleted','=',false)->get();
        return view('pages.reestr.waterworks.waterworks_add')
            ->with('waterbodies',$waterbodies)
            ->with('uz_regions',$uz_regions)
            ->with('waterwork_function',$waterwork_function)
            ->with('classes',$classes)
            ->with('types',$types);

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

        $waterworks = new Waterworks();
        $waterworks->code = Input::get('code');
        $waterworks->name = Input::get('name');
        $waterworks->waterbody_id = Input::get('waterbody_id');
        $waterworks->location = Input::get('location');
        $waterworks->water_source = Input::get('water_source');
        $waterworks->waterwork_functions_id = Input::get('function_id');
        $waterworks->water_users = Input::get('water_users');
        $waterworks->capital_classes_id = Input::get('class_id');
        $waterworks->waterwork_types_id = Input::get('ww_type_id');
        $waterworks->dam_max_height = Input::get('dam_max_height');
        $waterworks->throughput_capacity = Input::get('throughput_capacity');
        $waterworks->launch_date = Input::get('launch_date');
        $waterworks->wateruser_orgs = Input::get('wateruser_orgs');
        $waterworks->book_value = Input::get('book_value');
        $waterworks->comment = Input::get('comment');
        $waterworks->isDeleted = false;
        $waterworks->year = Input::get('year');
        $waterworks->is_approve = false;
        $waterworks->user_id = Auth::id();
        $waterworks->save();

        if(Input::get('districts') != null || Input::get('regions') != null) {
            if (Input::get('districts') == null) {
                foreach (Input::get('regions') as $key => $region) {
                    $reservoirs_attr = new Waterworks_attr();
                    $reservoirs_attr->waterworks_id = $waterworks->id;
                    $reservoirs_attr->region_id = $region;
                    $reservoirs_attr->save();
                }

            } else {
                foreach (Input::get('districts') as $key => $region) {
                    $waterworks_attr = new Waterworks_attr();
                    $waterworks_attr->waterworks_id = $waterworks->id;
                    $region_id = UzDistricts::select('regionid')->where('areaid', '=', $region)->first();
                    $waterworks_attr->region_id = $region_id->regionid;
                    $waterworks_attr->district_id = $region;
                    $waterworks_attr->save();
                }
            }
        }



        return redirect(route('ww.index'));
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
		    $waterbodies = Waterbodies::where('isDeleted','=',false)->get();
		    $uz_regions = UzRegions::all();
		    $waterwork_function = waterwork_functions::where('isDeleted','=',false)->get();
		    $classes = capital_classes::where('isDeleted','=',false)->get();
		    $types = waterwork_types::where('isDeleted','=',false)->get();
		    $waterwork = Waterworks::where('id',Input::get('id'))->with('users')->first();
		    return $waterwork;

	    }
    	elseif($request->has('code'))
	    {
		    $collector = Waterworks::where('code',$request->get('code'))->whereBetween('year',[Input::get('start'),Input::get('finish')])->with('waterbodies','water_work_type','waterwork_func','class_capital','waterwork_attr')->get();
		    if(count($collector) > 0)
			    return $collector;
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

        $waterworks = Waterworks::find(Input::get('id'));
        $waterworks->code = Input::get('code');
        $waterworks->name = Input::get('name');
        $waterworks->waterbody_id = Input::get('waterbody_id');
        $waterworks->location = Input::get('location');
        $waterworks->water_source = Input::get('water_source');
        $waterworks->waterwork_functions_id = Input::get('function_id');
        $waterworks->water_users = Input::get('water_users');
        $waterworks->capital_classes_id = Input::get('class_id');
        $waterworks->waterwork_types_id = Input::get('ww_type_id');
        $waterworks->dam_max_height = Input::get('dam_max_height');
        $waterworks->throughput_capacity = Input::get('throughput_capacity');
        $waterworks->launch_date = Input::get('launch_date');
        $waterworks->wateruser_orgs = Input::get('wateruser_orgs');
        $waterworks->book_value = Input::get('book_value');
        $waterworks->comment = Input::get('comment');
        $waterworks->isDeleted = false;
        $waterworks->is_approve = false;
        $waterworks->user_id = Auth::id();
        $waterworks->save();

        if(Input::get('districts') != null || Input::get('regions') != null )
        {
            Waterworks_attr::where('waterworks_id','=',Input::get('id'))->delete();

            if(Input::get('districts') == null)
            {
                foreach (Input::get('regions') as $key=>$region)
                {
                    $reservoirs_attr = new Waterworks_attr();
                    $reservoirs_attr->waterworks_id = $waterworks->id;
                    $reservoirs_attr->region_id = $region;
                    $reservoirs_attr->save();
                }
            }
            else
            {
                foreach (Input::get('districts') as $key=>$region)
                {
                    $reservoirs_attr = new Waterworks_attr();
                    $reservoirs_attr->waterworks_id = $waterworks->id;
                    $region_id = UzDistricts::select('regionid')->where('areaid','=',$region)->first();
                    $reservoirs_attr->region_id = $region_id->regionid;
                    $reservoirs_attr->district_id = $region;
                    $reservoirs_attr->save();
                }

            }

        }


        return redirect(route('ww.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

	public function getSelectedRegions()
	{
		$waterworks_attr = Waterworks_attr::select('region_id','district_id')->where('waterworks_id','=', Input::get('id'))->get();

		return $waterworks_attr;

	}

    public function destroy($id)
    {
        $waterworks = Waterworks::find($id);
        $waterworks->isDeleted = true;
        $waterworks->save();
        return redirect(route('ww.index'));
    }

    public function ExportTemplateWaterworks()
    {
	    return Excel::download(new WaterworkTemplateExport(),'Гидроузел_шаблон'.Carbon::now().'.xlsx');

    }

    public function Import()
    {
	    Excel::import(new WaterworksImport(), request()->file('select_file'));
	    return redirect(route('ww.index'));
    }

    public function  Search(Request $request)
    {


    }
    public function Export()
    {
        return Excel::download(new WaterworkExport(), 'Гидроузел_'.Carbon::now().'.xlsx');

    }
    public function MultiSelect()
    {
        foreach (Input::get('checkeds') as $element)
        {
            Waterworks::where('id',$element)->update(['isDeleted' => true]);
        }
    }

    public function Accept(Request $request)
    {
        if(Auth::user()->hasRole('Administrator'))
        {

            Waterworks::where('id',$request->get('id'))->where('year',$request->get('year'))->update(['user_id'=>Auth::id(),'is_approve'=>true]);

        }

        return redirect()->back();
    }
}
