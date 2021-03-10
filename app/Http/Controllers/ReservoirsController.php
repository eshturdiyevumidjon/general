<?php

namespace App\Http\Controllers;

use App\capital_classes;
use App\dam_types;
use App\Exports\ReservoirsExport;
use App\Exports\WaterbodiesExport;
use App\manipulation_type;
use App\reservior_functions;
use App\reservoir_type;
use App\Reservoirs;
use App\Reservoirs_attr;
use App\UzRegions;
use App\Waterbodies;
use App\Waterbodies_attr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;
use App\UzDistricts;
use Maatwebsite\Excel\Facades\Excel;


class ReservoirsController extends Controller
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
            Reservoirs::whereIn('id', array_map('intval', explode(',', $request->checkeds)))->update(['is_approve' => true,'user_id'=>Auth::id()]);
        }


	    if($request->has('year'))
	    {
		    Cookie::queue(Cookie::forever('year', $request->year));

	    }
	    elseif(!$request->hasCookie('year') && !$request->has('year'))
	    {
		    Cookie::queue(Cookie::forever('year', Carbon::now()->year));
	    }
	    $reservoirs = Reservoirs::orderby( 'id', 'ASC' )->
	    where( 'isDeleted', '=', false );

	    if(
		    Input::get('waterbody_id') != null ||
		    Input::get('region') != null ||
		    Input::get('year') != null ||
		    Input::get('district') != null ||
		    Input::get('location') != null ||
		    Input::get('code') != null ||
		    Input::get('name') != null ||
		    Input::get('water_source') != null ||
		    Input::get('water_users') != null ||
		    Input::get('type') != null ||
		    Input::get('functions') != null ||
		    Input::get('users') != null ||
		    Input::get('class_capital') != null ||
		    Input::get('dam_type') != null ||
		    Input::get('dam_max_height') != null ||
		    Input::get('total_area') != null ||
		    Input::get('total_volume') != null ||
		    Input::get('volume_q1') != null ||
		    Input::get('volume_q2') != null ||
		    Input::get('volume_q3') != null ||
		    Input::get('volume_q4') != null ||
		    Input::get('maxflow_below_dam') != null ||
		    Input::get('launch_date') != null ||
		    Input::get('wateruser_orgs') != null ||
		    Input::get('book_value') != null ||
		    Input::get('comment') != null ||
		    Input::get('is_approve') != null) {


		    foreach ( Input::all() as $key => $element ) {

			    if ( ! empty( $element ) ) {
				    if (
					    $key != 'region' &&
					    $key != 'district' &&
					    $key != 'type' &&
					    $key != 'class_capital' &&
					    $key != 'dam_type' &&
					    $key != 'functions' &&
					    $key != 'page' &&
					    $key != 'year' &&
					    $key != 'users'


				    ) {

					    if ( $key == 'is_approve' ) {
						    $reservoirs = $reservoirs->
						    where( $key, $element );
					    } else {
						    $reservoirs = $reservoirs->
						    where( $key, 'like', '%' . $element . '%' );

					    }
				    } else {

					    if ( $key == 'region' ) {
						    $reservoirs = $reservoirs->whereHas( 'Reservoirs_attr.uz_regions', function ( $query ) {
							    $query->where( 'nameUz', 'like', '%' . Input::get( 'region' ) . '%' );
						    } );

					    }
					    if ( $key == 'district' ) {
						    $reservoirs = $reservoirs->whereHas( 'Reservoirs_attr.uz_districts', function ( $query ) {
							    $query->where( 'nameUz', 'like', '%' . Input::get( 'district' ) . '%' );
						    } );

					    }
					    if ( $key == 'type' ) {
						    $reservoirs = $reservoirs->whereHas( 'reservoirs_type', function ( $query ) {
							    $query->where( 'name', 'like', '%' . Input::get( 'type' ) . '%' );
						    } );

					    }
					    if ( $key == 'functions' ) {
						    $reservoirs = $reservoirs->whereHas( 'reservoirs_function', function ( $query ) {
							    $query->where( 'name', 'like', '%' . Input::get( 'functions' ) . '%' );
						    } );

					    }
					    if ( $key == 'users' ) {
						    $reservoirs = $reservoirs->whereHas( 'users', function ( $query ) {
							    $query->where( 'email', 'ilike', '%' . Input::get( 'users' ) . '%' );
						    } );

					    }
					    if ( $key == 'class_capital' ) {
						    $reservoirs = $reservoirs->whereHas( 'class_capital', function ( $query ) {
							    $query->where( 'name', 'ilike', '%' . Input::get( 'class_capital' ) . '%' );
						    } );

					    }
					    if ( $key == 'dam_type' ) {
						    $reservoirs = $reservoirs->whereHas( 'dam_type', function ( $query ) {
							    $query->where( 'name', 'ilike', '%' . Input::get( 'dam_type' ) . '%' );
						    } );

					    }
					    if ( $key == 'year' ) {

						    if($element == 'all')
						    {

							    $reservoirs = $reservoirs->where('year','<>',null);

						    }
						    else
						    {

							    $reservoirs = $reservoirs->where('year',$element);


						    }

					    }

				    }

			    }
			    else {

			    }
		    }

		    $reservoirs = $reservoirs->where('isDeleted',false)->orderBy( $request->session()->get( 'orderBy' ) ?? 'id', $request->session()->get( 'orderType' ) ?? 'ASC' )->with('waterbodies','reservoirs_type','reservoirs_function','Reservoirs_attr','users')->paginate($request->session()->get('perPage') ?? 10);

	    }
	    else
	    {
	    	if($request->hasCookie('year'))
		    {
			    if($request->cookie('year') ==  'all')
			    {
				     $reservoirs = Reservoirs::where( 'isDeleted', false )->where('year','<>',null)->orderBy( $request->session()->get( 'orderBy' ) ?? 'id', $request->session()->get( 'orderType' ) ?? 'ASC' )->with( 'reservoirs_type', 'reservoirs_function', 'Reservoirs_attr', 'users' )->paginate( $request->session()->get( 'perPage' ) ?? 10 );


			    }
			    else
			    {

				    $reservoirs = Reservoirs::where( 'isDeleted', false )->where('year',$request->cookie('year'))->orderBy( $request->session()->get( 'orderBy' ) ?? 'id', $request->session()->get( 'orderType' ) ?? 'ASC' )->with( 'reservoirs_type', 'reservoirs_function', 'Reservoirs_attr', 'users' )->paginate( $request->session()->get( 'perPage' ) ?? 10 );



			    }


		    }
	    	else
		    {
			    $reservoirs = Reservoirs::where( 'isDeleted', false )->where('year',Carbon::now()->year)->orderBy( $request->session()->get( 'orderBy' ) ?? 'id', $request->session()->get( 'orderType' ) ?? 'ASC' )->with( 'reservoirs_type', 'reservoirs_function', 'Reservoirs_attr', 'users' )->paginate( $request->session()->get( 'perPage' ) ?? 10 );


		    }





	    }





		    $years      = Reservoirs::select( 'year' )->where( 'isDeleted', '=', false )->groupBy( 'year' )->get();


		    $water_bodies       = Waterbodies::where( 'isDeleted', '=', false )->get();
		    $uz_regions         = UzRegions::all();
		    $manipulation_types = manipulation_type::where( 'isDeleted', '=', false )->get();
		    $rv_types           = reservoir_type::where( 'isDeleted', '=', false )->get();
		    $funcs              = reservior_functions::where( 'isDeleted', '=', false )->get();
		    $class              = capital_classes::where( 'isDeleted', '=', false )->get();
		    $dam_types          = dam_types::where( 'isDeleted', '=', false )->get();


		    return view( 'pages.reestr.reservoirs.reservoirs' )
			    ->with( 'reservoirs', $reservoirs )
			    ->with( 'perPage', $reservoirs->perPage() )
			    ->with( 'currentPage', $reservoirs->currentPage() )
			    ->with( 'water_bodies', $water_bodies )
			    ->with( 'uz_regionss', $uz_regions )
			    ->with( 'manipulation_types', $manipulation_types )
			    ->with( 'rv_types', $rv_types )
			    ->with( 'funcs', $funcs )
			    ->with( 'classes', $class )
			    ->with( 'dam_types', $dam_types )
			    ->with( 'years', $years );

    }

    public function index_year(Request $request)
    {
    	if($request->get('year') != 'all')
	    {
		    $year = $request->input('year');
		    $reservoirs = Reservoirs::orderby('id','DESC')->where('isDeleted','=',false)->where('year',$year)->with('waterbodies','reservoirs_type','reservoirs_function','Reservoirs_attr')->paginate(10);

	    }
    	elseif($request->get('year') == 'all')
	    {
		    $reservoirs = Reservoirs::orderby('id','DESC')->where('isDeleted','=',false)->with('waterbodies','reservoirs_type','reservoirs_function','Reservoirs_attr')->paginate(10);

	    }

	    $years = Reservoirs::select('year')->where('isDeleted','=',false)->groupBy('year')->get();


	    $water_bodies = Waterbodies::where('isDeleted','=',false)->get();
	    $uz_regions = UzRegions::all();
	    $manipulation_types = manipulation_type::where('isDeleted','=',false)->get();
	    $rv_types = reservoir_type::where('isDeleted','=',false)->get();
	    $funcs = reservior_functions::where('isDeleted','=',false)->get();
	    $class = capital_classes::where('isDeleted','=',false)->get();
	    $dam_types = dam_types::where('isDeleted','=',false)->get();


	    return view('pages.reestr.reservoirs.reservoirs')
		    ->with('reservoirs',$reservoirs)
		    ->with('water_bodies',$water_bodies)
		    ->with('uz_regionss',$uz_regions)
		    ->with('manipulation_types',$manipulation_types)
		    ->with('rv_types',$rv_types)
		    ->with('funcs',$funcs)
		    ->with('classes',$class)
		    ->with('dam_types',$dam_types)
		    ->with('year',$year = null)
		    ->with('years',$years);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$water_bodies = Waterbodies::where('isDeleted','=',false)->get();
	    $uz_regions = UzRegions::all();
	    $manipulation_types = manipulation_type::where('isDeleted','=',false)->get();
	    $rv_types = reservoir_type::where('isDeleted','=',false)->get();
	    $funcs = reservior_functions::where('isDeleted','=',false)->get();
	    $class = capital_classes::where('isDeleted','=',false)->get();
	    $dam_types = dam_types::where('isDeleted','=',false)->get();


	    return view('pages.reestr.reservoirs.reservoirs_add')
		    ->with('water_bodies',$water_bodies)
		    ->with('uz_regions',$uz_regions)
		    ->with('manipulation_types',$manipulation_types)
		    ->with('rv_types',$rv_types)
		    ->with('funcs',$funcs)
		    ->with('classes',$class)
		    ->with('dam_types',$dam_types);


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

        if(!Reservoirs::where('code',$request->input('code'))->where('year',$request->input('year'))->first())
        {
	        $reservoirs = new Reservoirs();
	        $reservoirs->code = Input::get('code');
	        $reservoirs->name = Input::get('name');
	        $reservoirs->waterbody_id = Input::get('waterbodies_id');
	        $reservoirs->location = Input::get('location');
	        $reservoirs->water_source = Input::get('water_source');
	        $reservoirs->manipulation_type_id = Input::get('manipulation_type_id');
	        $reservoirs->reservoir_type_id = Input::get('type_id');
	        $reservoirs->reservior_functions_id = Input::get('func_id');
	        $reservoirs->water_users = Input::get('waterusers');
	        $reservoirs->capital_classes_id = Input::get('class_id');
	        $reservoirs->dam_type_id = Input::get('dam_type_id');
	        $reservoirs->dam_max_height = Input::get('dam_max_height');
	        $reservoirs->total_area = Input::get('total_area');
	        $reservoirs->total_volume = Input::get('total_volume');
	        $reservoirs->volume_q1 = Input::get('volume_q1');
	        $reservoirs->volume_q2 = Input::get('volume_q2');
	        $reservoirs->volume_q3 = Input::get('volume_q3');
	        $reservoirs->volume_q4 = Input::get('volume_q4');
	        $reservoirs->maxflow_below_dam = Input::get('maxflow_below_dam');
	        $reservoirs->launch_date = Input::get('launch_date');
	        $reservoirs->wateruser_orgs = Input::get('wateruser_orgs');
	        $reservoirs->book_value = Input::get('book_value');
	        $reservoirs->comment = Input::get('comment');
	        $reservoirs->isDeleted = false;
	        $reservoirs->is_approve = false;
            $reservoirs->user_id = Auth::id();
            $reservoirs->year = Input::get('year');
	        $reservoirs->save();

	        if(Input::get('districts') != null || Input::get('regions') != null)
	        {
		        if(Input::get('districts') == null) {
			        foreach (Input::get('regions') as $key=>$region)
			        {
				        $reservoirs_attr = new Reservoirs_attr();
				        $reservoirs_attr->reservoirs_id = $reservoirs->id;
				        $reservoirs_attr->region_id = $region;
				        $reservoirs_attr->save();
			        }
		        }
		        else
		        {
			        foreach (Input::get('districts') as $key=>$region)
			        {
				        $reservoirs_attr = new Reservoirs_attr();
				        $reservoirs_attr->reservoirs_id = $reservoirs->id;
				        $region_id = UzDistricts::select('regionid')->where('areaid','=',$region)->first();
				        $reservoirs_attr->region_id = $region_id->regionid;
				        $reservoirs_attr->district_id = $region;
				        $reservoirs_attr->save();
			        }
		        }
	        }

        }
        else
        {
        	return redirect()->back()->withErrors('Ушбу обект мавжуд!');
        }




        return redirect(route('rv.index'));
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
		    $reservoir = Reservoirs::where('id',Input::get('id'))->with('users')->first();
		    return $reservoir;

	    }
	    if($request->has('code'))
	    {

		    $canal = Reservoirs::where('code',Input::get('code'))->whereBetween('year',[Input::get('start'),Input::get('finish')])->with('waterbodies','class_capital','reservoirs_type','reservoirs_function','manipulation_type','dam_type','Reservoirs_attr')->get();
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
	    $reservoirs = Reservoirs::find(Input::get('id'));
	    $reservoirs->code = Input::get('code');
	    $reservoirs->name = Input::get('name');
	    $reservoirs->waterbody_id = Input::get('waterbodies_id');
	    $reservoirs->location = Input::get('location');
	    $reservoirs->water_source = Input::get('water_source');
	    $reservoirs->manipulation_type_id = Input::get('manipulation_type_id');
	    $reservoirs->reservoir_type_id = Input::get('type_id');
	    $reservoirs->reservior_functions_id = Input::get('func_id');
	    $reservoirs->water_users = Input::get('waterusers');
	    $reservoirs->capital_classes_id = Input::get('class_id');
	    $reservoirs->dam_type_id = Input::get('dam_type_id');
	    $reservoirs->dam_max_height = Input::get('dam_max_height');
	    $reservoirs->total_area = Input::get('total_area');
	    $reservoirs->total_volume = Input::get('total_volume');
	    $reservoirs->volume_q1 = Input::get('volume_q1');
	    $reservoirs->volume_q2 = Input::get('volume_q2');
	    $reservoirs->volume_q3 = Input::get('volume_q3');
	    $reservoirs->volume_q4 = Input::get('volume_q4');
	    $reservoirs->maxflow_below_dam = Input::get('maxflow_below_dam');
	    $reservoirs->launch_date = Input::get('launch_date');
	    $reservoirs->wateruser_orgs = Input::get('wateruser_orgs');
	    $reservoirs->book_value = Input::get('book_value');
	    $reservoirs->comment = Input::get('comment');
	    $reservoirs->isDeleted = false;
        $reservoirs->is_approve = false;
        $reservoirs->user_id = Auth::id();
	    $reservoirs->save();

	    Reservoirs_attr::where('reservoirs_id','=',Input::get('id'))->delete();

	    if(Input::get('districts') != null || Input::get('regions') != null)
	    {
		    if(Input::get('districts') == null) {
			    foreach (Input::get('regions') as $key=>$region)
			    {
				    $reservoirs_attr = new Reservoirs_attr();
				    $reservoirs_attr->reservoirs_id = $reservoirs->id;
				    $reservoirs_attr->region_id = $region;
				    $reservoirs_attr->save();
			    }
		    }
		    else
		    {
			    foreach (Input::get('districts') as $key=>$region)
			    {
				    $reservoirs_attr = new Reservoirs_attr();
				    $reservoirs_attr->reservoirs_id = $reservoirs->id;
				    $region_id = UzDistricts::select('regionid')->where('areaid','=',$region)->first();
				    $reservoirs_attr->region_id = $region_id->regionid;
				    $reservoirs_attr->district_id = $region;
				    $reservoirs_attr->save();
			    }
		    }
	    }



	    return redirect(route('rv.index'));
        $reservoirs = Reservoirs::find(Input::get('id'));

    }

    public function getSelectedRegions()
    {
        $reservoirs_attr = Reservoirs_attr::select('region_id','district_id')->where('reservoirs_id','=', Input::get('id'))->get();

        return $reservoirs_attr;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservoirs = Reservoirs::find($id);
        $reservoirs->isDeleted = true;
        $reservoirs->save();
	    return redirect(route('rv.index'));
    }

    public function  Search(Request $request)
    {




    }

    public function Export()
    {
        return Excel::download(new ReservoirsExport(), 'Водохранилище_'.Carbon::now().'.xlsx');

    }
    public function MultiSelect()
    {
        foreach (Input::get('checkeds') as $element)
        {
            Reservoirs::where('id',$element)->update(['isDeleted' => true]);
        }
    }

    public function Accept(Request $request)
    {
        if(Auth::user()->hasRole('Administrator'))
        {

            Reservoirs::where('id',$request->get('id'))->where('year',$request->get('year'))->update(['user_id'=>Auth::id(),'is_approve'=>true]);

        }

        return redirect()->back();
    }
}
