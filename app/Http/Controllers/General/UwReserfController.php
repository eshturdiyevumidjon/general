<?php

namespace App\Http\Controllers\General;

use App\General\RiverFlowRecources;
use App\General\UiReserfs;
use App\General\Wateruse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class UwReserfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

	    if(\Illuminate\Support\Facades\Auth::user()->org_name == 'gidrogeologiya' || \Illuminate\Support\Facades\Auth::user()->org_name == 'other')
	    {
		    $uw_resers  = UiReserfs::where('years',Input::get('year'))->count();
            $last_update_date = UiReserfs::select('updated_at','user_id','is_approve','years')->where('years',Input::get('year'))->orderBy('updated_at','DESC')->first();


            if($uw_resers == 0)
		    {
			    $uw_reserfs = new UiReserfs();
			    $uw_reserfs->region_name = "Республика Каракалпакистан";
			    $uw_reserfs->years = Input::get('year');
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $uw_reserfs->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->region_name = "Андижанский";
			    $resource_regions->years = Input::get('year');
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->years = Input::get('year');
			    $resource_regions->region_name = "Бухарский";
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->region_name = "Джизакский";
			    $resource_regions->years = Input::get('year');
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->region_name = "Кашкадарьинский";
			    $resource_regions->years = Input::get('year');
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->region_name = "Навоиский";
			    $resource_regions->years = Input::get('year');
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->region_name = "Наманганский";
			    $resource_regions->years = Input::get('year');
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->region_name = "Самаркандский";
			    $resource_regions->years = Input::get('year');
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->region_name = "Сурхандарьинский";
			    $resource_regions->years = Input::get('year');
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->region_name = "Сырдарьинский";
			    $resource_regions->years = Input::get('year');
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->region_name = "Ташкентский";
			    $resource_regions->years = Input::get('year');
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->region_name = "Ферганский";
			    $resource_regions->years = Input::get('year');
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->region_name = "Хорезмский";
			    $resource_regions->years = Input::get('year');
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->region_name = " Всего Республика Узбекистан";
			    $resource_regions->years = Input::get('year');
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

                $uw_resers = UiReserfs::where('years',Input::get('year'))->orderby('id','ASC')->get();


                return view('general.pages.resources.uw_reserfs.uw_reserf',[
				    'uw_reserfs'=>$uw_resers,
				    'year' => Input::get('year'),
                    'last_update' => $last_update_date


                ]);


		    }
		    else
		    {
			    $uw_resers = UiReserfs::where('years',Input::get('year'))->orderby('id','ASC')->get();
			    return view('general.pages.resources.uw_reserfs.uw_reserf',[
				    'uw_reserfs'=>$uw_resers,
				    'year' => Input::get('year'),
                    'last_update' => $last_update_date


                ]);

		    }

	    }
	    else
	    {
	    	abort(404);
	    }



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
        //
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
    public function edit($id)
    {
        //
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
	    switch (Input::get('func'))
	    {

		    case "total":
			    UiReserfs::where('id',Input::get('ids'))->update(['user_id'=>Auth::id(),'is_approve'=>false,'total'=>Input::get('param')]);
			    break;
		    case 'surface_water':
			    UiReserfs::where('id',Input::get('ids'))->update(['user_id'=>Auth::id(),'is_approve'=>false,'surface_water'=>Input::get('param')]);
			    break;
		    case 'ex_reserf':
			    UiReserfs::where('id',Input::get('ids'))->update(['user_id'=>Auth::id(),'is_approve'=>false,'ex_reserf'=>Input::get('param')]);
			    break;

	    }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function Accept(Request $request)
    {
        if(\Illuminate\Support\Facades\Auth::user()->org_name == 'gidromet')
        {

                $resources  = UiReserfs::where('years',$request->get('year'))->update(['user_id'=>Auth::id(),'is_approve'=>true]);

        }

        return redirect()->back();

    }
}
