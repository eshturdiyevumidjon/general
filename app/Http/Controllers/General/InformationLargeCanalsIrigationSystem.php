<?php

namespace App\Http\Controllers\General;

use App\General\GroundWaterUse;
use App\General\WaterUseVariousNeeds;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\General\InformationLargeCanalsIrigationSystem as ModelName;

class InformationLargeCanalsIrigationSystem extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
	    if(Auth::user()->org_name == 'gidromet' || Auth::user()->org_name == 'other')
	    {
		    $information_large_canals = ModelName::where('years',$request->year)->count();
		    $last_update_date = ModelName::select('updated_at','user_id','is_approve','years')->where('years',$request->year)->orderBy('updated_at','DESC')->first();

		    if($information_large_canals == 0)
		    {
			    $information_canal = new ModelName();
			    $information_canal->river = "Амударья";
			    $information_canal->distance_river = 1291;
			    $information_canal->name_canal = "Аму-Занг";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Амударья";
			    $information_canal->distance_river = 1102;
			    $information_canal->name_canal = "Каракумский";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Амударья";
			    $information_canal->distance_river = 1062;
			    $information_canal->name_canal = "Каршинский";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Амударья";
			    $information_canal->distance_river = 877;
			    $information_canal->name_canal = "Аму-Бухарский";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Амударья";
			    $information_canal->distance_river = 442;
			    $information_canal->name_canal = "Ташсака";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Амударья";
			    $information_canal->distance_river = 456;
			    $information_canal->name_canal = "Тюямуюн (левобережный)";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Амударья";
			    $information_canal->distance_river = 423;
			    $information_canal->name_canal = "Байрамсака";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Амударья";
			    $information_canal->distance_river = 403;
			    $information_canal->name_canal = "Карамазысака";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Амударья";
			    $information_canal->distance_river = 434;
			    $information_canal->name_canal = "Пахтаарна";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Амударья";
			    $information_canal->distance_river = 434;
			    $information_canal->name_canal = "Пахтаарна (подпитка)";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Амударья";
			    $information_canal->distance_river = 358;
			    $information_canal->name_canal = "Клычниябай";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Амударья";
			    $information_canal->distance_river = 246;
			    $information_canal->name_canal = "Советьяб";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Амударья";
			    $information_canal->distance_river = 232;
			    $information_canal->name_canal = "Кызкеткен";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Амударья";
			    $information_canal->distance_river = 231;
			    $information_canal->name_canal = "Кызкетен (подпитка)";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Сурхандарья";
			    $information_canal->distance_river = 94;
			    $information_canal->name_canal = "Шерабадский";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Сурхандарья";
			    $information_canal->distance_river = 62;
			    $information_canal->name_canal = "Занг";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Кашкадарья";
			    $information_canal->distance_river = null;
			    $information_canal->name_canal = "Аксу-Яккабаг (соединительный)";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Заравшан";
			    $information_canal->distance_river = 562;
			    $information_canal->name_canal = "Правобережный";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Заравшан";
			    $information_canal->distance_river = 562;
			    $information_canal->name_canal = "Даргом";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Заравшан";
			    $information_canal->distance_river = 463;
			    $information_canal->name_canal = "Подводящий Каттакурганского вдхр.";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Заравшан";
			    $information_canal->distance_river = 451;
			    $information_canal->name_canal = "Нарпай";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Сырдарья";
			    $information_canal->distance_river = 2193;
			    $information_canal->name_canal = "им.Ахунбабаева";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Сырдарья";
			    $information_canal->distance_river = 1908;
			    $information_canal->name_canal = "Деривационный Фархадской ГЭС";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Сырдарья";
			    $information_canal->distance_river = 1902;
			    $information_canal->name_canal = "Верхний Дальверзин";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Сырдарья";
			    $information_canal->distance_river = 1877;
			    $information_canal->name_canal = "Дустлик (КМК)";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Сырдарья";
			    $information_canal->distance_river = null;
			    $information_canal->name_canal = "Южно-Голодностепский (ЮГК)";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Нарын";
			    $information_canal->distance_river = 46;
			    $information_canal->name_canal = "Большой Ферганский (БФК)";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Нарын";
			    $information_canal->distance_river = 36;
			    $information_canal->name_canal = "Северный Ферганский (СФК)";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Нарын";
			    $information_canal->distance_river = 36;
			    $information_canal->name_canal = "Дополнительный подпитывающий БФК (КДП)";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Кашкадарья";
			    $information_canal->distance_river = 140;
			    $information_canal->name_canal = "Шаариханскай";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Кашкадарья";
			    $information_canal->distance_river = 140;
			    $information_canal->name_canal = "Андижансай";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Чирчик";
			    $information_canal->distance_river = null;
			    $information_canal->name_canal = "Келес магистральный";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Чирчик";
			    $information_canal->distance_river = 133;
			    $information_canal->name_canal = "Верхний Деривационный (ВДК)";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Чирчик";
			    $information_canal->distance_river = null;
			    $information_canal->name_canal = "Паркентский";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_canal = new ModelName();
			    $information_canal->river = "Чирчик";
			    $information_canal->distance_river = 108;
			    $information_canal->name_canal = "Карасу (левобережный)";
			    $information_canal->years = $request->year;
			    $information_canal->user_id = Auth::id();
			    $information_canal->is_approve=false;
			    $information_canal->save();

			    $information_large_canals = ModelName::where('years',$request->year)->orderby('id','ASC')->get();
			    return view('general.pages.resources.information_large_canals_irigation_system.information_large_canals_irigation_system',[
				    'information_large_canals'=>$information_large_canals,
				    'year' => $request->year,
				    'id' => $request->id,
				    'last_update' => $last_update_date
			    ]);
		    }
		    else
		    {
			    $information_large_canals = ModelName::where('years',$request->year)->orderby('id','ASC')->get();
			    return view('general.pages.resources.information_large_canals_irigation_system.information_large_canals_irigation_system',[
				    'information_large_canals'=>$information_large_canals,
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
            case "canal_bandwidth":
                ModelName::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'canal_bandwidth'=>$request->param]);
                break;
            case 'average_water':
                ModelName::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'average_water'=>$request->param]);
                break;
            case 'canal_main_structures':
                ModelName::where('id',$request->ids)->update(['user_id'=>Auth::id(),'is_approve'=>false,'canal_main_structures'=>$request->param]);
                break;
        }
    }

	public function Accept(Request $request)
	{
		if(Auth::user()->org_name == 'gidromet')
		{
			$resources = ModelName::where('years',$request->get('year'))->update(['user_id'=>Auth::id(),'is_approve'=>true]);
		}

		return redirect()->back();
	}
}
