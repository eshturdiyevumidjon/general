<?php

namespace App\Http\Controllers;

use App\capital_classes;
use App\Collectors;
use App\Collectors_attr;
use App\Exports\CanalsTemplateExport;
use App\Exports\CollectorExport;
use App\Exports\CollectorsTempalte;
use App\Exports\ReservoirsExport;
use App\Imports\CanalsImport;
use App\Imports\CollectorsImport;
use App\UzRegions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\ColleсtorFunctions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Input;
use App\UzDistricts;
use Maatwebsite\Excel\Facades\Excel;


class CollectorsController extends Controller
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
            Collectors::whereIn('id', array_map('intval', explode(',', $request->checkeds)))->update(['is_approve' => true,'user_id'=>Auth::id()]);
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
		    Input::get('name') != null ||
		    Input::get('region') != null ||
		    Input::get('district') != null ||
		    Input::get('functions') != null ||
		    Input::get('year') != null ||

		    Input::get('length') != null ||
		    Input::get('wateruser_orgs') != null ||
		    Input::get('launch_date') != null ||
		    Input::get('bookvalue') != null ||
		    Input::get('comment') != null ||
		    Input::get('service_area') != null ||
		    Input::get('max_wateruse') != null ||
		    Input::get('class_ca') != null ||
		    Input::get('users') != null ||
		    Input::get('is_approve') != null
	    ) {

		    $collectors = Collectors::orderby( 'id', 'ASC' )->
		    where( 'isDeleted', '=', false );
		    foreach ( Input::all() as $key => $element ) {
			    if ( ! empty( $element ) ) {
				    if (
					    $key != 'region' &&
					    $key != 'district' &&
					    $key != 'functions' &&
					    $key != 'year' &&
					    $key != 'page' &&
					    $key != 'class_ca' &&
					    $key != 'users'

				    ) {
					    if ( $key == 'is_approve' ) {
						    $collectors = $collectors->
						    where( $key, $element );
					    } else {
						    $collectors = $collectors->
						    where( $key, 'like', '%' . $element . '%' );

					    }

				    }
				    if ( $key == 'year' ) {
					    if ( $element != 'all' ) {
						    $collectors = $collectors->
						    where( $key, '=', Input::get( 'year' ) );

					    }
					    else {
						    $collectors = $collectors->
						    where( $key, '<>', null );
					    }
				    }
				    if ( $key == 'region' ) {
					    $collectors = $collectors->whereHas( 'collector_attr.uz_regions', function ( $query ) {
						    $query->where( 'nameUz', 'like', '%' . Input::get( 'region' ) . '%' );
					    } );

				    }
				    if ( $key == 'district' ) {
					    $collectors = $collectors->whereHas( 'collector_attr.uz_districts', function ( $query ) {
						    $query->where( 'nameUz', 'like', '%' . Input::get( 'district' ) . '%' );
					    } );

				    }
				    if ( $key == 'functions' ) {
					    $collectors = $collectors->whereHas( 'collector_functions', function ( $query ) {
						    $query->where( 'name', 'like', '%' . Input::get( 'functions' ) . '%' );
					    } );

				    }
				    if ( $key == 'users' ) {
					    $collectors = $collectors->whereHas( 'users', function ( $query ) {
						    $query->where( 'email', 'ilike', '%' . Input::get( 'users' ) . '%' );
					    } );

				    }
				    if ( $key == 'class_ca' ) {
					    $collectors = $collectors->whereHas( 'class_capital', function ( $query ) {
						    $query->where( 'name', 'ilike', '%' . Input::get( 'class_ca' ) . '%' );
					    } );

				    }

			    } else {

			    }
		    }
		    $collectors  =  $collectors->with('collector_functions','collector_attr','users')->paginate($request->session()->get('perPage') ?? 10);

	    }
	    else {
		    if ( $request->hasCookie( 'year' ) ) {
			    if ( $request->cookie( 'year' ) == 'all' ) {
				    $collectors = Collectors::where('isDeleted', false)->orderBy($request->session()->get('orderBy') ?? 'id', $request->session()->get('orderType') ?? 'ASC')->where('year','<>',null)->with('collector_functions','collector_attr','users','class_capital')->paginate($request->session()->get('perPage') ?? 10);


			    } else {
				    $collectors = Collectors::where('isDeleted', false)->orderBy($request->session()->get('orderBy') ?? 'id', $request->session()->get('orderType') ?? 'ASC')->where('year',$request->cookie('year'))->with('collector_functions','collector_attr','users','class_capital')->paginate($request->session()->get('perPage') ?? 10);


			    }
		    } else {
			    $collectors = Collectors::where('isDeleted', false)->orderBy($request->session()->get('orderBy') ?? 'id', $request->session()->get('orderType') ?? 'ASC')->where('year',Carbon::now()->year)->with('collector_functions','collector_attr','users','class_capital')->paginate($request->session()->get('perPage') ?? 10);


		    }
	    }






        $year = Carbon::now()->year;
      $years = Collectors::select('year')->where('isDeleted','=',false)->GroupBy('year')->get();
      $uz_regions = UzRegions::all();
        $classes = capital_classes::where('isDeleted','=',false)->get();

        $collector_functions = ColleсtorFunctions::where('isDeleted','=',false)->get();

                  // return view('gidrogeologiya.pages.reestr.aproval_plots.aproval_plots')

      return view('pages.reestr.collectors.collectors')
        ->with('collectors', $collectors)
        ->with('uz_regions', $uz_regions)
          ->with('classes',$classes)
          ->with('perPage',$collectors->perPage())
          ->with('currentPage',$collectors->currentPage())
          ->with('collector_functions', $collector_functions)
        ->with('years', $years);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $uz_regions = UzRegions::all();
      $collector_functions = ColleсtorFunctions::where('isDeleted','=',false)->get();
      return view('pages.reestr.сolleсtors.сolleсtors_add')
      ->with('uz_regions',$uz_regions)
      ->with('collector_functions',$collector_functions);
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

      $collectors = new Collectors();
      $collectors->code  = Input::get('code');
      $collectors->name  = Input::get('name');
      $collectors->location  = Input::get('location');
      $collectors->max_wateruse  = Input::get('max_wateruse');
      $collectors->length  = Input::get('length');
      $collectors->service_area  = Input::get('service_area');
        $collectors->capital_classes_id = Input::get('class_id');

        $collectors->launch_date  = Input::get('launch_date');
      $collectors->wateruser_orgs  = Input::get('wateruser_orgs');
      $collectors->bookvalue  = Input::get('book_value');
      $collectors->comment  = Input::get('comment');
      $collectors->collactor_function_id  = Input::get('function_id');
      $collectors->isDeleted = false;
      $collectors->year = Input::get('year');
        $collectors->is_approve = false;
        $collectors->user_id = Auth::id();
      $collectors->save();

      if(Input::get('districts') != null || Input::get('regions') != null)
      {
        if(Input::get('districts') == null) {
          foreach (Input::get('regions') as $key=>$region)
          {
            $collector_atr = new Collectors_attr();
            $collector_atr->collector_id = $collectors->id;
            $collector_atr->region_id = $region;
            $collector_atr->save();
          }
        }
        else
        {
          foreach (Input::get('districts') as $key=>$region) {
            $collector_atr = new Collectors_attr();
            $collector_atr->collector_id = $collectors->id;
            $region_id = UzDistricts::select('regionid')->where('areaid','=',$region)->first();
            $collector_atr->region_id = $region_id->regionid;
            $collector_atr->district_id = $region;
            $collector_atr->save();
          }
        }
      }



      return redirect()->route('ct.index');

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
		    $collector = Collectors::where('id',Input::get('id'))->with('users','class_capital')->first();
		    return $collector;

	    }
    	elseif($request->has('code'))
	    {
		    $collector = Collectors::where('code',$request->get('code'))->whereBetween('year',[Input::get('start'),Input::get('finish')])->with('collector_attr','collector_functions','users','class_capital')->get();
		    if(count($collector) > 0)
			    return $collector;
		    else
			    return "false";
	    }

    }

    public function getSelectedRegions()
    {
      $collector = Collectors_attr::select('region_id','district_id')->where('collector_id','=', Input::get('id'))->get();

      return $collector;

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

      $collectors = Collectors::find(Input::get('id'));
      $collectors->code  = Input::get('code');
      $collectors->name  = Input::get('name');
      $collectors->location  = Input::get('location');
      $collectors->max_wateruse  = Input::get('max_wateruse');
      $collectors->length  = Input::get('length');
        $collectors->capital_classes_id = Input::get('class_id');

        $collectors->service_area  = Input::get('service_area');
      $collectors->launch_date  = Input::get('launch_date');
      $collectors->wateruser_orgs  = Input::get('wateruser_orgs');
      $collectors->bookvalue  = Input::get('book_value');
      $collectors->comment  = Input::get('comment');
      $collectors->collactor_function_id  = Input::get('function_id');
      $collectors->isDeleted = false;
      $collectors->is_approve = false;
      $collectors->user_id = Auth::id();
      $collectors->save();


      Collectors_attr::where('collector_id','=',Input::get('id'))->delete();
      if(Input::get('districts') != null || Input::get('regions') != null)
      {
        if(Input::get('districts') == null) {
          foreach (Input::get('regions') as $key=>$region)
          {
            $collector_atr = new Collectors_attr();
            $collector_atr->collector_id = $collectors->id;
            $collector_atr->region_id = $region;
            $collector_atr->save();
          }
        }
        else
        {
         foreach (Input::get('districts') as $key=>$region)
         {
          $collector_atr = new Collectors_attr();
          $collector_atr->collector_id = $collectors->id;
          $region_id = UzDistricts::select('regionid')->where('areaid','=',$region)->first();
          $collector_atr->region_id = $region_id->regionid;
          $collector_atr->district_id = $region;
          $collector_atr->save();
        }
      }
    }




    return redirect()->route('ct.index');
  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $collector = Collectors::find($id);
      $collector->isDeleted = true;
      $collector->save();
      return redirect(route('ct.index'));
    }

    public function ExportTemplate()
    {
      return Excel::download(new CollectorsTempalte(),'Коллектор'.Carbon::now().'.xlsx');

    }

    public function Import()
    {
      Excel::import(new CollectorsImport(), request()->file('select_file'));
      return redirect(route('ct.index'));
    }

    public function Search(Request $request)
    {
    }

    public function Export()
    {
      return Excel::download(new CollectorExport(), 'Коллектор_'.Carbon::now().'.xlsx');

    }

    public function MultiSelect()
    {
      foreach (Input::get('checkeds') as $element)
      {
        Collectors::where('id',$element)->update(['isDeleted' => true]);
      }
    }
    public function Accept(Request $request)
    {
        if(Auth::user()->hasRole('Administrator'))
        {

            Collectors::where('id',$request->get('id'))->where('year',$request->get('year'))->update(['user_id'=>Auth::id(),'is_approve'=>true]);

        }

        return redirect()->back();
    }
  }
