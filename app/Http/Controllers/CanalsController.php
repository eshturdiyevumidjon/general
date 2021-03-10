<?php

namespace App\Http\Controllers;

use App\canal_functions;
use App\Canals;
use App\Canals_attr;
use App\capital_classes;
use App\cover_types;
use App\Exports\CanalsExport;
use App\Exports\CanalsTemplateExport;
use App\Imports\CanalsImport;
use App\UzRegions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;
use App\UzDistricts;
use Maatwebsite\Excel\Facades\Excel;

class CanalsController extends Controller
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
            Canals::whereIn('id', array_map('intval', explode(',', $request->checkeds)))->update(['is_approve' => true,'user_id'=>Auth::id()]);
        }
	    if($request->has('year'))
	    {
		    Cookie::queue(Cookie::forever('year', $request->year));

	    }
	    elseif(!$request->hasCookie('year') && !$request->has('year'))
	    {
		    Cookie::queue(Cookie::forever('year', Carbon::now()->year));
	    }

	    if(
		    Input::get('code') != null ||
		    Input::get('canal_name') != null ||
		    Input::get('region') != null ||
		    Input::get('district') != null ||
		    Input::get('water_source') != null ||
		    Input::get('year') != null ||

		    Input::get('capital_class') != null ||
		    Input::get('functions') != null ||
		    Input::get('max_wateruse') != null ||
		    Input::get('total_length') != null ||
		    Input::get('ctype1_len') != null ||
		    Input::get('ctype2_len') != null ||
		    Input::get('total_length') != null ||
		    Input::get('facilities_n') != null ||
		    Input::get('irrigation_area') != null ||
		    Input::get('launch_date') != null ||
		    Input::get('wateruser_orgs') != null ||
		    Input::get('bookvalue') != null ||
		    Input::get('comment') != null ||
		    Input::get('users') != null ||
		    Input::get('location') != null ||
		    Input::get('cover_type_id') != null ||
		    Input::get('cover_type_2_id') != null ||
		    Input::get('is_approve') != null
	    ) {
		    $canals = Canals::orderby( 'id', 'ASC' )->
		    where( 'isDeleted', '=', false );
		    foreach ( Input::all() as $key => $element ) {
			    if ( ! empty( $element ) ) {
				    if (
					    $key != 'region' &&
					    $key != 'district' &&
					    $key != 'capital_class' &&
					    $key != 'year' &&
					    $key != 'functions' &&
					    $key != 'cover_type_id' &&
					    $key != 'page' &&
					    $key != 'cover_type_2_id' &&
					    $key != 'users'

				    ) {
					    if ( $key == 'is_approve' ) {
						    $canals = $canals->
						    where( $key, $element );
					    } else {
						    $canals = $canals->
						    where( $key, 'like', '%' . $element . '%' );

					    }

				    }
				    if ( $key == 'year' ) {
					    if ( $element != 'all' ) {
						    $canals = $canals->
						    where( $key, '=', Input::get( 'year' ) );
					    } else {
						    $canals = $canals->
						    where( $key, '<>', null );
					    }


				    }
				    if ( $key == 'region' ) {
					    $canals = $canals->whereHas( 'Canals_attr.uz_regions', function ( $query ) {
						    $query->where( 'nameUz', 'like', '%' . Input::get( 'region' ) . '%' );
					    } );

				    }
				    if ( $key == 'district' ) {
					    $canals = $canals->whereHas( 'Canals_attr.uz_districts', function ( $query ) {
						    $query->where( 'nameUz', 'like', '%' . Input::get( 'district' ) . '%' );
					    } );

				    }
				    if ( $key == 'class_ca' ) {
					    $canals = $canals->whereHas( 'class_capital', function ( $query ) {
						    $query->where( 'name', 'like', '%' . Input::get( 'class_ca' ) . '%' );
					    } );

				    }
				    if ( $key == 'functions' ) {
					    $canals = $canals->whereHas( 'functions', function ( $query ) {
						    $query->where( 'name', 'like', '%' . Input::get( 'functions' ) . '%' );
					    } );

				    }
				    if ( $key == 'users' ) {
					    $canals = $canals->whereHas( 'users', function ( $query ) {
						    $query->where( 'email', 'ilike', '%' . Input::get( 'users' ) . '%' );
					    } );

				    }
				    if ( $key == 'cover_type_id' ) {
					    $canals = $canals->whereHas( 'cover_type_1', function ( $query ) {
						    $query->where( 'name', 'ilike', '%' . Input::get( 'cover_type_id' ) . '%' );
					    } );

				    }
				    if ( $key == 'cover_type_2_id' ) {
					    $canals = $canals->whereHas( 'cover_type_2', function ( $query ) {
						    $query->where( 'name', 'ilike', '%' . Input::get( 'cover_type_2_id' ) . '%' );
					    } );

				    }

			    } else {

			    }
		    }
		    $canals  =  $canals->with('class_capital','functions','cover_type_1','cover_type_2','Canals_attr','users')->paginate($request->session()->get('perPage') ?? 10);

	    }
	    else {
		    if ( $request->hasCookie( 'year' ) ) {
			    if ( $request->cookie( 'year' ) == 'all' ) {
				    $canals = Canals::where( 'isDeleted', false )->orderBy( $request->session()->get( 'orderBy' ) ?? 'id', $request->session()->get( 'orderType' ) ?? 'ASC' )->where( 'year', '<>', null )->with( 'class_capital', 'functions', 'cover_type_1', 'cover_type_2', 'Canals_attr', 'users' )->paginate( $request->session()->get( 'perPage' ) ?? 10 );

			    } else {
				    $canals = Canals::where( 'isDeleted', false )->orderBy( $request->session()->get( 'orderBy' ) ?? 'id', $request->session()->get( 'orderType' ) ?? 'ASC' )->where( 'year', $request->cookie( 'year' ) )->with( 'class_capital', 'functions', 'cover_type_1', 'cover_type_2', 'Canals_attr', 'users' )->paginate( $request->session()->get( 'perPage' ) ?? 10 );

			    }
		    }
	    }



//        dd($per_page);



        $year = Carbon::now()->year;
	    $years  = Canals::select('year')->where('isDeleted','=',false)->groupBy('year')->get();
        $uz_regions = UzRegions::all();
        $classes = capital_classes::where('isDeleted','=',false)->get();
        $functions = canal_functions::where('isDeleted','=',false)->get();
        $cover_types = cover_types::where('isDeleted','=',false)->get();


        return view('pages.reestr.canals.canals')
	        ->with('canals',$canals)
	        ->with('perPage',$canals->perPage())
	        ->with('currentPage',$canals->currentPage())
	        ->with('uz_regions',$uz_regions)
	        ->with('classes',$classes)
	        ->with('functions',$functions)
	        ->with('cover_types',$cover_types)
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
    	$functions = canal_functions::where('isDeleted','=',false)->get();
    	$cover_types = cover_types::where('isDeleted','=',false)->get();
        return view('pages.reestr.canals.canals_add')
	        ->with('uz_regions',$uz_regions)
	        ->with('classes',$classes)
	        ->with('functions',$functions)
	        ->with('cover_types',$cover_types);

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


	    $canals = new Canals();
	    $canals->code = Input::get('code');
	    $canals->canal_name = Input::get('name');
	    $canals->location = Input::get('location');
	    $canals->water_source = Input::get('water_source');
	    $canals->capital_classes_id = Input::get('class_id');
	    $canals->canal_functions_id = Input::get('function_id');
	    $canals->max_wateruse = Input::get('maxflow_below_dam');
	    $canals->cover_type_1_id = Input::get('cover_type_id');
	    $canals->ctype1_len = Input::get('ctype1_len');
	    $canals->cover_type_2_id = Input::get('cover_type_2_id');
	    $canals->ctype2_len = Input::get('ctype2_len');
	    $canals->total_length = Input::get('total_length');
	    $canals->facilities_n = Input::get('facilities_n');
	    $canals->irrigation_area = Input::get('irrigation_area');
	    $canals->launch_date = Input::get('launch_date');
	    $canals->wateruser_orgs = Input::get('wateruser_orgs');
	    $canals->bookvalue = Input::get('book_value');
	    $canals->comment = Input::get('comment');
	    $canals->isDeleted = false;
	    $canals->year = Input::get('year');
        $canals->is_approve = false;
        $canals->user_id = Auth::id();
	    $canals->save();
	    if(Input::get('districts') != null || Input::get('regions') != null)
		    {
		    	 if(Input::get('districts') == null)
			     {
				     foreach (Input::get('regions') as $key=>$region)
				     {
					     $canals_attr = new Canals_attr();
					     $canals_attr->canals_id = $canals->id;
					     $canals_attr->region_id = $region;
					     $canals_attr->save();
				     }
			     }
			     else
			     {
				     foreach (Input::get('districts') as $key=>$region)
				     {
					     $canals_attr = new Canals_attr();
					     $canals_attr->canals_id = $canals->id;
					     $region_id = UzDistricts::select('regionid')->where('areaid','=',$region)->first();
					     $canals_attr->region_id = $region_id->regionid;
					     $canals_attr->district_id = $region;
					     $canals_attr->save();
				     }
			     }

            }




	    return redirect()->route('c.index');



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
	    $uz_regions = UzRegions::all();
	    $classes = capital_classes::where('isDeleted','=',false)->get();
	    $functions = canal_functions::where('isDeleted','=',false)->get();
	    $cover_types = cover_types::where('isDeleted','=',false)->get();
	    if($request->has('id'))
	    {
		    $canal = Canals::where('id',Input::get('id'))->with('users')->first();
		    return $canal;

	    }
	    if($request->has('code'))
	    {
		    $canal = Canals::where('code',$request->get('code'))->whereBetween('year',[Input::get('start'),Input::get('finish')])->with('class_capital','functions','cover_type_1','cover_type_2','Canals_attr')->get();
		    if(isset($canal))
		    return $canal;
		    else
		    	return "false";

	    }


//	        view('pages.reestr.canals.canals_edit')
//	        ->with('canal',$canal)
//	        ->with('uz_regions',$uz_regions)
//	        ->with('classes',$classes)
//	        ->with('functions',$functions)
//	        ->with('cover_types',$cover_types);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

	public function getSelectedRegions()
	{
			$canals = Canals_attr::select('region_id','district_id')->where('canals_id','=', Input::get('id'))->get();

			return $canals;

	}
    public function update(Request $request)
    {
	    $request->validate([
		    'code' => 'required',
		    'name' => 'required',
        ]);


//	    dd(Input::all());
	    $canals = Canals::find(Input::get('id'));
	    $canals->code = Input::get('code');
	    $canals->canal_name = Input::get('name');
	    $canals->location = Input::get('location');
	    $canals->water_source = Input::get('water_source');
	    $canals->capital_classes_id = Input::get('class_id');
	    $canals->canal_functions_id = Input::get('function_id');
	    $canals->max_wateruse = Input::get('maxflow_below_dam');
	    $canals->cover_type_1_id = Input::get('cover_type_id');
	    $canals->ctype1_len = Input::get('ctype1_len');
	    $canals->cover_type_2_id = Input::get('cover_type_2_id');
	    $canals->ctype2_len = Input::get('ctype2_len');
	    $canals->total_length = Input::get('total_length');
	    $canals->facilities_n = Input::get('facilities_n');
	    $canals->irrigation_area = Input::get('irrigation_area');
	    $canals->launch_date = Input::get('launch_date');
	    $canals->wateruser_orgs = Input::get('wateruser_orgs');
	    $canals->bookvalue = Input::get('book_value');
	    $canals->comment = Input::get('comment');
	    $canals->isDeleted = false;
        $canals->is_approve = false;
        $canals->user_id = Auth::id();
	    $canals->save();

	    Canals_attr::where('canals_id','=',Input::get('id'))->delete();
	    if(Input::get('districts') != null || Input::get('regions') != null)
	    {
		    if(Input::get('districts') == null)
		    {
			      foreach (Input::get('regions') as $key=>$region)
			    {
				    $canals_attr = new Canals_attr();
				    $canals_attr->canals_id = $canals->id;
				    $canals_attr->region_id = $region;
				    $canals_attr->save();
			    }
		    }
		    else
		    {
			    foreach (Input::get('districts') as $key=>$region)
			    {
				    $canals_attr = new Canals_attr();
				    $canals_attr->canals_id = $canals->id;
				    $region_id = UzDistricts::select('regionid')->where('areaid','=',$region)->first();
				    $canals_attr->region_id = $region_id->regionid;
				    $canals_attr->district_id = $region;
				    $canals_attr->save();
			    }

		    }
	    }




	    return redirect()->route('c.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
	    $reservoirs = Canals::find($id);
	    $reservoirs->isDeleted = true;
	    $reservoirs->save();
	    return redirect(route('c.index'));
    }

    public function ExportTemplate()
    {
	    return Excel::download(new CanalsTemplateExport(),'Каналы_шаблон'.Carbon::now().'.xlsx');

    }

    public function Import()
    {
	    Excel::import(new CanalsImport(), request()->file('select_file'));
	    return redirect(route('c.index'));
    }

    public function Search(Request $request)
    {
//

    }

    public function Export()
    {
        return Excel::download(new CanalsExport(), 'Каналы_'.Carbon::now().'.xlsx');

    }

    public function MultiSelect()
    {
        foreach (Input::get('checkeds') as $element)
        {
           Canals::where('id',$element)->update(['isDeleted' => true]);
        }
    }

    public function Accept(Request $request)
    {
        if(Auth::user()->hasRole('Administrator'))
        {

            Canals::where('id',$request->get('id'))->where('year',$request->get('year'))->update(['user_id'=>Auth::id(),'is_approve'=>true]);

        }

        return redirect()->back();
    }

}
