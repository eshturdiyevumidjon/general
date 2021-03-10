<?php

namespace App\Http\Controllers;

use App\Canals_attr;
use App\capital_classes;
use App\Exports\CanalsTemplateExport;
use App\Exports\PumpStationExport;
use App\Exports\PumpStationsTempalteExport;
use App\Imports\CanalsImport;
use App\Imports\PumpStationImport;
use App\Pump_stations;
use App\Pump_stations_attr;
use App\pumpstation_functions;
use App\UzDistricts;
use App\UzRegions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;


class PumpStationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
	    $request->session()->remove( 'orderBy' );
	    if ( $request->orderBy ) {
		    $request->session()->put( 'orderBy', $request->orderBy );
	    }
	    if ( $request->orderType ) {
		    $request->session()->put( 'orderType', $request->orderType );
	    }
	    if ( $request->per_page ) {
		    $request->session()->put( 'perPage', json_decode( $request->per_page ) );
	    }
	    if ( $request->has( 'checkeds' ) ) {
		    Pump_stations::whereIn( 'id', array_map( 'intval', explode( ',', $request->checkeds ) ) )->update( [
			    'is_approve' => true,
			    'user_id'    => Auth::id()
		    ] );
	    }

	    if ( $request->has( 'year' ) ) {
		    Cookie::queue( Cookie::forever( 'year', $request->year ) );

	    } elseif ( ! $request->hasCookie( 'year' ) && ! $request->has( 'year' ) ) {
		    Cookie::queue( Cookie::forever( 'year', Carbon::now()->year ) );
	    }
	    if (
		    Input::get( 'code' ) != null ||
		    Input::get( 'name' ) != null ||
		    Input::get( 'region' ) != null ||
		    Input::get( 'district' ) != null ||
		    Input::get( 'water_source' ) != null ||
		    Input::get( 'max_wateruse' ) != null ||
		    Input::get( 'launch_date' ) != null ||
		    Input::get( 'year' ) != null ||
		    Input::get( 'location' ) != null ||
		    Input::get( 'class_ca' ) != null ||
		    Input::get( 'functions' ) != null ||
		    Input::get( 'bookvalue' ) != null ||
		    Input::get( 'comment' ) != null ||
		    Input::get( 'lift_height' ) != null ||
		    Input::get( 'wateruser_orgs' ) != null ||
		    Input::get( 'bookvalue' ) != null ||
		    Input::get( 'users' ) != null ||
		    Input::get( 'capacity' ) != null ||
		    Input::get( 'aggregates_n' ) != null ||
		    Input::get( 'is_approve' ) != null
	    ) {
		    $pump_stations = Pump_stations::orderby( 'id', 'ASC' )->
		    where( 'isDeleted', '=', false );
		    foreach ( Input::all() as $key => $element ) {
			    if ( ! empty( $element ) ) {
				    if (
					    $key != 'region' &&
					    $key != 'district' &&
					    $key != 'class_ca' &&
					    $key != 'year' &&
					    $key != 'page' &&
					    $key != 'functions' &&
					    $key != 'users'

				    ) {
					    if ( $key == 'is_approve' ) {
						    $pump_stations = $pump_stations->
						    where( $key, $element );
					    } else {
						    $pump_stations = $pump_stations->
						    where( $key, 'like', '%' . $element . '%' );

					    }

				    }
				    if ( $key == 'year' ) {
					    if ( $element != 'all' ) {
						    $pump_stations = $pump_stations->
						    where( $key, Input::get( 'year' ) );
					    } else {
						    $pump_stations = $pump_stations->
						    where( $key, '<>', null );
					    }


				    }
				    if ( $key == 'region' ) {
					    $pump_stations = $pump_stations->whereHas( 'pump_station_attr.uz_regions', function ( $query ) {
						    $query->where( 'nameUz', 'like', '%' . Input::get( 'region' ) . '%' );
					    } );

				    }
				    if ( $key == 'district' ) {
					    $pump_stations = $pump_stations->whereHas( 'pump_station_attr.uz_districts', function ( $query ) {
						    $query->where( 'nameUz', 'like', '%' . Input::get( 'district' ) . '%' );
					    } );

				    }
				    if ( $key == 'class_ca' ) {
					    $pump_stations = $pump_stations->whereHas( 'class', function ( $query ) {
						    $query->where( 'name', 'like', '%' . Input::get( 'class_ca' ) . '%' );
					    } );

				    }
				    if ( $key == 'functions' ) {
					    $pump_stations = $pump_stations->whereHas( 'function', function ( $query ) {
						    $query->where( 'name', 'like', '%' . Input::get( 'functions' ) . '%' );
					    } );

				    }
				    if ( $key == 'users' ) {
					    $pump_stations = $pump_stations->whereHas( 'users', function ( $query ) {
						    $query->where( 'email', 'ilike', '%' . Input::get( 'users' ) . '%' );
					    } );

				    }

			    } else {

			    }
		    }
		    $pump_stations  =  $pump_stations->where('isDeleted',false)->with('class','function','pump_station_attr','users')->paginate($request->session()->get('perPage') ?? 10);

	    } else {
		    if ( $request->hasCookie( 'year' ) ) {
			    if ( $request->cookie( 'year' ) == 'all' ) {
				    $pump_stations = Pump_stations::where( 'isDeleted', false )->orderBy( $request->session()->get( 'orderBy' ) ?? 'id', $request->session()->get( 'orderType' ) ?? 'ASC' )->where( 'year', '<>', null )->with( 'function', 'class', 'pump_station_attr', 'users' )->paginate( $request->session()->get( 'perPage' ) ?? 10 );

			    } else {
				    $pump_stations = Pump_stations::where( 'isDeleted', false )->orderBy( $request->session()->get( 'orderBy' ) ?? 'id', $request->session()->get( 'orderType' ) ?? 'ASC' )->where( 'year', $request->cookie( 'year' ) )->with( 'function', 'class', 'pump_station_attr', 'users' )->paginate( $request->session()->get( 'perPage' ) ?? 10 );

			    }


		    } else {
			    $pump_stations = Pump_stations::where( 'isDeleted', false )->orderBy( $request->session()->get( 'orderBy' ) ?? 'id', $request->session()->get( 'orderType' ) ?? 'ASC' )->where( 'year', Carbon::now()->year )->with( 'function', 'class', 'pump_station_attr', 'users' )->paginate( $request->session()->get( 'perPage' ) ?? 10 );

		    }
	    }



	    $years = Pump_stations::select('year')->where('isDeleted', false)->groupBy('year')->get();
	    $uz_regions = UzRegions::all();
	    $classes = capital_classes::where('isDeleted','=',false)->get();
	    $functions = pumpstation_functions::where('isDeleted','=',false)->get();
    	return view('pages.reestr.pump_stations.pump_stations')
	        ->with('pump_stations',$pump_stations)
		    ->with('uz_regions',$uz_regions)
            ->with('perPage',$pump_stations->perPage())
            ->with('currentPage',$pump_stations->currentPage())
		    ->with('classes',$classes)
		    ->with('functions',$functions)
		    ->with('years',$years);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
	    $uz_regions = UzRegions::all();
	    $classes = capital_classes::where('isDeleted','=',false)->get();
	    $functions = pumpstation_functions::where('isDeleted','=',false)->get();
	    return view('pages.reestr.pump_stations.pump_stations_add')
		    ->with('uz_regions',$uz_regions)
	         ->with('classes',$classes)
	         ->with('functions',$functions);
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

	    $pump_station = new Pump_stations();
	    $pump_station->code = Input::get('code');
	    $pump_station->name = Input::get('name');
	    $pump_station->location = Input::get('location');
	    $pump_station->water_source = Input::get('water_source');
	    $pump_station->class_id = Input::get('class_id');
	    $pump_station->pumpstation_functions_id = Input::get('function_id');
	    $pump_station->max_wateruse = floatval(str_replace(',','.',Input::get('max_wateruse')));
	    $pump_station->lift_height = floatval(str_replace(',','.',Input::get('lift_height')));
	    $pump_station->aggregates_n = floatval(str_replace(',','.',Input::get('aggregates_n')));
	    $pump_station->capacity = floatval(str_replace(',','.',Input::get('capacity')));
	    $pump_station->launch_date = Input::get('launch_date');
	    $pump_station->wateruser_orgs = Input::get('wateruser_orgs');
	    $pump_station->bookvalue = Input::get('book_value');
	    $pump_station->comment = Input::get('comment');
	    $pump_station->isDeleted = false;
	    $pump_station->year = Input::get('year');
        $pump_station->is_approve = false;
        $pump_station->user_id = Auth::id();
	    $pump_station->save();

	    if(Input::get('districts') != null || Input::get('regions') != null)
	    {
		    if(Input::get('districts') == null) {
			    foreach (Input::get('regions') as $key=>$region)
			    {
				    $pump_station_attr = new Pump_stations_attr();
				    $pump_station_attr->pump_stations_id = $pump_station->id;
				    $pump_station_attr->region_id = $region;
				    $pump_station_attr->save();
			    }
		    }
		    else
		    {
			    foreach (Input::get('districts') as $key=>$region)
			    {
				    $pump_station_attr = new Pump_stations_attr();
				    $pump_station_attr->pump_stations_id = $pump_station->id;
				    $region_id = UzDistricts::select('regionid')->where('areaid','=',$region)->first();
				    $pump_station_attr->region_id = $region_id->regionid;
				    $pump_station_attr->district_id = $region;
				    $pump_station_attr->save();
			    }
		    }
	    }



	    return redirect()->route('ps.index');

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

	public function getSelectedRegions()
	{
		$canals = Pump_stations_attr::select('region_id','district_id')->where('pump_stations_id','=', Input::get('id'))->get();

		return $canals;

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
		    $pumpstation = Pump_stations::where('id',Input::get('id'))->with('users')->first();
		    return $pumpstation;

	    }
	    $uz_regions = UzRegions::all();
	    $classes = capital_classes::where('isDeleted','=',false)->get();
	    $functions = pumpstation_functions::where('isDeleted','=',false)->get();


	    if($request->has('code'))
	    {
		    $canal = Pump_stations::where('code',$request->get('code'))->whereBetween('year',[Input::get('start'),Input::get('finish')])->with('class','function','pump_station_attr')->get();
		    if(isset($canal))
			    return $canal;
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

	    $pump_station = Pump_stations::find(Input::get('id'));
	    $pump_station->code = Input::get('code');
	    $pump_station->name = Input::get('name');
	    $pump_station->water_source = Input::get('water_source');
        $pump_station->location = Input::get('location');
	    $pump_station->class_id = Input::get('class_id');
	    $pump_station->pumpstation_functions_id = Input::get('function_id');
	    $pump_station->max_wateruse = floatval(str_replace(',','.',Input::get('max_wateruse')));
	    $pump_station->lift_height = floatval(str_replace(',','.',Input::get('lift_height')));
	    $pump_station->aggregates_n = floatval(str_replace(',','.',Input::get('aggregates_n')));
	    $pump_station->capacity = floatval(str_replace(',','.',Input::get('capacity')));
	    $pump_station->launch_date = Input::get('launch_date');
	    $pump_station->wateruser_orgs = Input::get('wateruser_orgs');
	    $pump_station->bookvalue = Input::get('book_value');
	    $pump_station->comment = Input::get('comment');
	    $pump_station->isDeleted = false;
        $pump_station->is_approve = false;
        $pump_station->user_id = Auth::id();
	    $pump_station->save();


	    Pump_stations_attr::where('pump_stations_id','=',Input::get('id'))->delete();
	    if(Input::get('districts') != null || Input::get('regions') != null)
	    {
		    if(Input::get('districts') == null) {
			    foreach (Input::get('regions') as $key=>$region)
			    {
				    $pump_station_attr = new Pump_stations_attr();
				    $pump_station_attr->pump_stations_id = $pump_station->id;
				    $pump_station_attr->region_id = $region;
				    $pump_station_attr->save();
			    }
		    }
		    else
		    {
			    foreach (Input::get('districts') as $key=>$region)
			    {
				    $pump_station_attr = new Pump_stations_attr();
				    $pump_station_attr->pump_stations_id = $pump_station->id;
				    $region_id = UzDistricts::select('regionid')->where('areaid','=',$region)->first();
				    $pump_station_attr->region_id = $region_id->regionid;
				    $pump_station_attr->district_id = $region;
				    $pump_station_attr->save();
			    }
		    }
	    }



	    return redirect()->route('ps.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
	    $pump_station = Pump_stations::find($id);
	    $pump_station->isDeleted = true;
	    $pump_station->save();
	    return redirect(route('ps.index'));
    }


    public function ExportTemplate()
    {
        return Excel::download(new PumpStationsTempalteExport(),'Насосная станция'.Carbon::now().'.xlsx');

    }

    public function Import()
    {

        Excel::import(new PumpStationImport(), request()->file('select_file'));
        return redirect(route('ps.index'));

    }
    public function Search(Request $request)
    {

    }

    public function Export()
    {
        return Excel::download(new PumpStationExport(), 'Насосная станция_'.Carbon::now().'.xlsx');

    }

    public function MultiSelect()
    {
        foreach (Input::get('checkeds') as $element)
        {
            Pump_stations::where('id',$element)->update(['isDeleted' => true]);
        }
    }

    public function Accept(Request $request)
    {
        if(Auth::user()->hasRole('Administrator'))
        {

            Pump_stations::where('id',$request->get('id'))->where('year',$request->get('year'))->update(['user_id'=>Auth::id(),'is_approve'=>true]);

        }

        return redirect()->back();
    }
}
