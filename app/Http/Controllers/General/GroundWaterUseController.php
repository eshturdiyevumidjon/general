<?php

namespace App\Http\Controllers\General;

use App\General\GroundwaterResources;
use App\General\GroundWaterUse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class GroundWaterUseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
	    if(Auth::user()->org_name == 'minvodxoz' || Auth::user()->org_name == 'other')
	    {
		    $ground_water_uses = GroundWaterUse::where('years',$request->year)->count();
		    $last_update_date = GroundWaterUse::select('updated_at','user_id','is_approve','years')->where('years',$request->year)->orderBy('updated_at','DESC')->first();

		    if($ground_water_uses == 0) {
			    $ground_water              = new GroundWaterUse();
			    $ground_water->region_name = 'Ферганский';
			    $ground_water->pool_name   = 'Бассейн реки Сырдарьи';
			    $ground_water->years       = $request->year;
			    $ground_water->user_id = Auth::id();
			    $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water              = new GroundWaterUse();
			    $ground_water->region_name = 'Приташкентский';
			    $ground_water->pool_name   = 'Бассейн реки Сырдарьи';
			    $ground_water->years       = $request->year;
			    $ground_water->user_id = Auth::id();
			    $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water              = new GroundWaterUse();
			    $ground_water->region_name = 'Голодностепский';
			    $ground_water->pool_name   = 'Бассейн реки Сырдарьи';
			    $ground_water->years       = $request->year;
			    $ground_water->user_id = Auth::id();
			    $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water              = new GroundWaterUse();
			    $ground_water->region_name = 'Восточно-Северо-Восточный Кызылкумский';
			    $ground_water->pool_name   = 'Бассейн реки Сырдарьи';
			    $ground_water->years       = $request->year;
			    $ground_water->user_id = Auth::id();
			    $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water              = new GroundWaterUse();
			    $ground_water->region_name = 'Итого';
			    $ground_water->pool_name   = 'Бассейн реки Сырдарьи';
			    $ground_water->years       = $request->year;
			    $ground_water->user_id = Auth::id();
			    $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water              = new GroundWaterUse();
			    $ground_water->region_name = 'Зарафшанский';
			    $ground_water->pool_name   = 'Бассейн реки Амударьи';
			    $ground_water->years       = $request->year;
			    $ground_water->user_id = Auth::id();
			    $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water              = new GroundWaterUse();
			    $ground_water->region_name = 'Кашкадарьинкий';
			    $ground_water->pool_name   = 'Бассейн реки Амударьи';
			    $ground_water->years       = $request->year;
			    $ground_water->user_id = Auth::id();
			    $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water              = new GroundWaterUse();
			    $ground_water->region_name = 'Сурхандарьинский';
			    $ground_water->pool_name   = 'Бассейн реки Амударьи';
			    $ground_water->years       = $request->year;
			    $ground_water->user_id = Auth::id();
			    $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water              = new GroundWaterUse();
			    $ground_water->region_name = 'Бухара-Турткульский';
			    $ground_water->pool_name   = 'Бассейн реки Амударьи';
			    $ground_water->years       = $request->year;
			    $ground_water->user_id = Auth::id();
			    $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water              = new GroundWaterUse();
			    $ground_water->region_name = 'Левобережье р. Амударьи';
			    $ground_water->pool_name   = 'Бассейн реки Амударьи';
			    $ground_water->years       = $request->year;
			    $ground_water->user_id = Auth::id();
			    $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water              = new GroundWaterUse();
			    $ground_water->region_name = 'Приаральский';
			    $ground_water->pool_name   = 'Бассейн реки Амударьи';
			    $ground_water->years       = $request->year;
			    $ground_water->user_id = Auth::id();
			    $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water              = new GroundWaterUse();
			    $ground_water->region_name = 'Итого';
			    $ground_water->pool_name   = 'Бассейн реки Амударьи';
			    $ground_water->years       = $request->year;
			    $ground_water->user_id = Auth::id();
			    $ground_water->is_approve=false;
			    $ground_water->save();


			    $ground_water              = new GroundWaterUse();
			    $ground_water->region_name = 'Нарата - Туркестанский';
			    $ground_water->pool_name   = 'Бассейн реки Амударьи';
			    $ground_water->years       = $request->year;
			    $ground_water->user_id = Auth::id();
			    $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water              = new GroundWaterUse();
			    $ground_water->region_name = 'Нурата - Туркестанский';
			    $ground_water->pool_name   = 'Бассейн реки Амударьи';
			    $ground_water->years       = $request->year;
			    $ground_water->user_id = Auth::id();
			    $ground_water->is_approve=false;
			    $ground_water->save();


			    $ground_water              = new GroundWaterUse();
			    $ground_water->region_name = 'Центрально-Кызылкумский';
			    $ground_water->pool_name   = 'Бассейн реки Амударьи';
			    $ground_water->years       = $request->year;
			    $ground_water->user_id = Auth::id();
			    $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water              = new GroundWaterUse();
			    $ground_water->region_name = 'Устюртский';
			    $ground_water->pool_name   = 'Бассейн реки Амударьи';
			    $ground_water->years       = $request->year;
			    $ground_water->user_id = Auth::id();
			    $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water              = new GroundWaterUse();
			    $ground_water->region_name = 'Итого';
			    $ground_water->pool_name   = 'Бассейн реки Амударьи';
			    $ground_water->years       = $request->year;
			    $ground_water->user_id = Auth::id();
			    $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water              = new GroundWaterUse();
			    $ground_water->region_name = 'Республика Узбекистан';
			    $ground_water->pool_name   = 'Бассейн реки Амударьи';
			    $ground_water->years       = $request->year;
			    $ground_water->user_id = Auth::id();
			    $ground_water->is_approve=false;
			    $ground_water->save();

			    $ground_water_uses = GroundWaterUse::where('years',$request->year)->orderby( 'id', 'ASC' )->get();

			    return view( 'general.pages.resources.ground_water_use.ground_water_use', [
				    'ground_water_uses' => $ground_water_uses,
				    'year'              => $request->year,
				    'last_update' => $last_update_date,
				    'id'              => $request->id,
			    ] );
		    }
		    else
		    {
			    $ground_water_uses = GroundWaterUse::where('years',$request->year)->orderby( 'id', 'ASC' )->get();

			    return view( 'general.pages.resources.ground_water_use.ground_water_use', [
				    'ground_water_uses' => $ground_water_uses,
				    'year'              => $request->year,
				    'last_update' => $last_update_date,
				    'id'              => $request->id,
			    ] );
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
            case "total":
                GroundWaterUse::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'total'=>$request->param]);
                break;
            case 'river_flow':
                GroundWaterUse::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'river_flow'=>$request->param]);
                break;
        }
    }

	public function Accept(Request $request)
	{
		if(Auth::user()->org_name == 'gidromet')
		{
			$resources = GroundWaterUse::where('years',$request->get('year'))->update(['user_id'=>Auth::id(),'is_approve'=>true]);
		}

		return redirect()->back();
	}
}
