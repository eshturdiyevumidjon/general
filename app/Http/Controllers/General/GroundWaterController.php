<?php

namespace App\Http\Controllers\General;

use App\General\GroundwaterResources;
use App\General\RiverFlowRecources;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class GroundWaterController extends Controller
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
		    $ground_water = GroundwaterResources::where('years',$request->year)->count();
            $last_update_date = GroundwaterResources::select('updated_at','user_id','is_approve','years')->where('years',$request->year)->orderBy('updated_at','DESC')->first();

            if($ground_water == 0)
		    {
			    $ground_water = new GroundwaterResources();
			    $ground_water->region_name = 'Ферганский';
			    $ground_water->pool_name = 'Бассейн реки Сырдарьи';
			    $ground_water->years = $request->year;
                $ground_water->user_id = Auth::id();
                $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water = new GroundwaterResources();
			    $ground_water->region_name = 'Приташкентский';
			    $ground_water->pool_name = 'Бассейн реки Сырдарьи';
			    $ground_water->years = $request->year;
                $ground_water->user_id = Auth::id();
                $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water = new GroundwaterResources();
			    $ground_water->region_name = 'Голодностепский';
			    $ground_water->pool_name = 'Бассейн реки Сырдарьи';
			    $ground_water->years = $request->year;
                $ground_water->user_id = Auth::id();
                $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water = new GroundwaterResources();
			    $ground_water->region_name = 'Восточно-Северо-Восточный Кызылкумский';
			    $ground_water->pool_name = 'Бассейн реки Сырдарьи';
			    $ground_water->years = $request->year;
                $ground_water->user_id = Auth::id();
                $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water = new GroundwaterResources();
			    $ground_water->region_name = 'Итого';
			    $ground_water->pool_name = 'Бассейн реки Сырдарьи';
			    $ground_water->years = $request->year;
                $ground_water->user_id = Auth::id();
                $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water = new GroundwaterResources();
			    $ground_water->region_name = 'Зарафшанский';
			    $ground_water->pool_name = 'Бассейн реки Амударьи';
			    $ground_water->years = $request->year;
                $ground_water->user_id = Auth::id();
                $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water = new GroundwaterResources();
			    $ground_water->region_name = 'Кашкадарьинкий';
			    $ground_water->pool_name = 'Бассейн реки Амударьи';
			    $ground_water->years = $request->year;
                $ground_water->user_id = Auth::id();
                $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water = new GroundwaterResources();
			    $ground_water->region_name = 'Сурхандарьинский';
			    $ground_water->pool_name = 'Бассейн реки Амударьи';
			    $ground_water->years = $request->year;
                $ground_water->user_id = Auth::id();
                $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water = new GroundwaterResources();
			    $ground_water->region_name = 'Бухара-Турткульский';
			    $ground_water->pool_name = 'Бассейн реки Амударьи';
			    $ground_water->years = $request->year;
                $ground_water->user_id = Auth::id();
                $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water = new GroundwaterResources();
			    $ground_water->region_name = 'Левобережье р. Амударьи';
			    $ground_water->pool_name = 'Бассейн реки Амударьи';
			    $ground_water->years = $request->year;
                $ground_water->user_id = Auth::id();
                $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water = new GroundwaterResources();
			    $ground_water->region_name = 'Приаральский';
			    $ground_water->pool_name = 'Бассейн реки Амударьи';
			    $ground_water->years = $request->year;
                $ground_water->user_id = Auth::id();
                $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water = new GroundwaterResources();
			    $ground_water->region_name = 'Итого';
			    $ground_water->pool_name = 'Бассейн реки Амударьи';
			    $ground_water->years = $request->year;
                $ground_water->user_id = Auth::id();
                $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water = new GroundwaterResources();
			    $ground_water->region_name = 'Нарата - Туркестанский';
			    $ground_water->pool_name = 'Бассейн реки Амударьи';
			    $ground_water->years = $request->year;
                $ground_water->user_id = Auth::id();
                $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water = new GroundwaterResources();
			    $ground_water->region_name = 'Нурата - Туркестанский';
			    $ground_water->pool_name = 'Бассейн реки Амударьи';
			    $ground_water->years = $request->year;
                $ground_water->user_id = Auth::id();
                $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water = new GroundwaterResources();
			    $ground_water->region_name = 'Центрально-Кызылкумский';
			    $ground_water->pool_name = 'Бассейн реки Амударьи';
			    $ground_water->years = $request->year;
                $ground_water->user_id = Auth::id();
                $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water = new GroundwaterResources();
			    $ground_water->region_name = 'Устюртский';
			    $ground_water->pool_name = 'Бассейн реки Амударьи';
			    $ground_water->years = $request->year;
                $ground_water->user_id = Auth::id();
                $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water = new GroundwaterResources();
			    $ground_water->region_name = 'Итого';
			    $ground_water->pool_name = 'Бассейн реки Амударьи';
			    $ground_water->years = $request->year;
                $ground_water->user_id = Auth::id();
                $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water = new GroundwaterResources();
			    $ground_water->region_name = 'Республика Узбекистан';
			    $ground_water->pool_name = 'Бассейн реки Амударьи';
			    $ground_water->years = $request->year;
                $ground_water->user_id = Auth::id();
                $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water = GroundwaterResources::where('years',$request->year)->orderBy('id','ASC')->get();
			    return view('general.pages.resources.ground_water.ground_water',[
				    'ground_waters'=>$ground_water,
				    'year' => $request->year,
                    'id' => $request->id,
                    'last_update' => $last_update_date
                ]);
		    }
		    else
		    {
			    $ground_water = GroundwaterResources::where('years',$request->year)->orderBy('id','ASC')->get();
			    return view('general.pages.resources.ground_water.ground_water',[
				    'ground_waters'=>$ground_water,
				    'year' => $request->year,
                    'id' => $request->id,
                    'last_update' => $last_update_date
                ]);
		    }
	    }
	    else
	    {
	    	return abort(404);
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
            case "natural_resources":
                GroundwaterResources::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'natural_resources'=>$request->param]);
                break;
            case 'region_total':
                GroundwaterResources::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'region_total'=>$request->param]);
                break;
            case 'including_surface_water':
                GroundwaterResources::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'including_surface_water'=>$request->param]);
                break;
            case 'approved_total':
                GroundwaterResources::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'approved_total'=>$request->param]);
                break;
        }
    }

    public function Accept(Request $request)
    {
        if(Auth::user()->org_name == 'gidromet')
        {
            $resources  = GroundwaterResources::where('years',$request->get('year'))->update(['user_id'=>Auth::id(),'is_approve'=>true]);
        }
        return redirect()->back();
    }
}
