<?php

namespace App\Http\Controllers\General;

use App\General\RiverFlowRecources;
use App\General\UiReserfs;
use App\General\Wateruse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UwReserfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
	    if(Auth::user()->org_name == 'gidrogeologiya' || Auth::user()->org_name == 'other')
	    {
		    $uw_resers  = UiReserfs::where('years',$request->year)->count();
            $last_update_date = UiReserfs::select('updated_at','user_id','is_approve','years')
                ->where('years',$request->year)
                ->orderBy('updated_at','DESC')
                ->first();

            if($uw_resers == 0)
		    {
			    $uw_reserfs = new UiReserfs();
			    $uw_reserfs->region_name = "Республика Каракалпакистан";
			    $uw_reserfs->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $uw_reserfs->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->region_name = "Андижанский";
			    $resource_regions->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->years = $request->year;
			    $resource_regions->region_name = "Бухарский";
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->region_name = "Джизакский";
			    $resource_regions->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->region_name = "Кашкадарьинский";
			    $resource_regions->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->region_name = "Навоиский";
			    $resource_regions->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->region_name = "Наманганский";
			    $resource_regions->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->region_name = "Самаркандский";
			    $resource_regions->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->region_name = "Сурхандарьинский";
			    $resource_regions->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->region_name = "Сырдарьинский";
			    $resource_regions->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->region_name = "Ташкентский";
			    $resource_regions->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->region_name = "Ферганский";
			    $resource_regions->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->region_name = "Хорезмский";
			    $resource_regions->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

			    $resource_regions = new UiReserfs();
			    $resource_regions->region_name = " Всего Республика Узбекистан";
			    $resource_regions->years = $request->year;
                $uw_reserfs->user_id = Auth::id();
                $uw_reserfs->is_approve=false;
			    $resource_regions->save();

                $uw_resers = UiReserfs::where('years',$request->year)->orderby('id','ASC')->get();

                return view('general.pages.resources.uw_reserfs.uw_reserf',[
				    'uw_reserfs'=>$uw_resers,
				    'year' => $request->year,
                    'id' => $request->id,
                    'last_update' => $last_update_date
                ]);
		    }
		    else
		    {
			    $uw_resers = UiReserfs::where('years',$request->year)->orderby('id','ASC')->get();
			    return view('general.pages.resources.uw_reserfs.uw_reserf',[
				    'uw_reserfs'=>$uw_resers,
				    'year' => $request->year,
                    'id' => $request->id,
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
	    switch ($request->func)
	    {
		    case "total":
			    UiReserfs::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'total'=>$request->param]);
			    break;
		    case 'surface_water':
			    UiReserfs::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'surface_water'=>$request->param]);
			    break;
		    case 'ex_reserf':
			    UiReserfs::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'ex_reserf'=>$request->param]);
			    break;
	    }
    }

    public function Accept(Request $request)
    {
        if(Auth::user()->org_name == 'gidromet')
        {
            $resources = UiReserfs::where('years', $request->get('year'))->update(['user_id' => Auth::id(), 'is_approve' => true]);
        }

        return redirect()->back();
    }
}
