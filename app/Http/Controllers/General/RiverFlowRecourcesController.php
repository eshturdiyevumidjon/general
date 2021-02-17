<?php

namespace App\Http\Controllers\General;

use App\General\RiverFlowRecources;
use App\General\UiReserfs;
use App\General\Wateruse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class RiverFlowRecourcesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	    if(\Illuminate\Support\Facades\Auth::user()->org_name == 'gidromet' || \Illuminate\Support\Facades\Auth::user()->org_name == 'other'  )
	    {
		    $river_recourses = RiverFlowRecources::where('years',Input::get('year'))->count();
            $last_update_date = RiverFlowRecources::select('updated_at','user_id','is_approve','years')->where('years',Input::get('year'))->orderBy('updated_at','DESC')->first();


            if($river_recourses == 0)
		    {
			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Амударья";
			    $river_flow->place = "пост Бирата (Дарганата)";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Амударья";
			    $river_flow->place = "пост Бирата (Дарганата) - теснина Тюямуюн";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Амударья";
			    $river_flow->place = "теснина Тюямуюн - г.Кипчак)";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Амударья";
			    $river_flow->place = "г.Кипчак - кишл.Саманбай";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Амударья";
			    $river_flow->place = "кишл. Саманбай - кишл.Кызылджар";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();






			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Сурхандарья";
			    $river_flow->place = "исток - составляющие (р.Каратаг, р.Тупаланг)";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Сурхандарья";
			    $river_flow->place = "составляющие - кишл.Шурчи";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Сурхандарья";
			    $river_flow->place = "кишл. Шурчи - ниже Южносурханского вдхр";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Сурхандарья";
			    $river_flow->place = "ниже Южносурханского вдхр - акведук канала Галаба";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();







			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Кашкадарья";
			    $river_flow->place = "исток - кишл. Варганза";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Кашкадарья";
			    $river_flow->place = "кишл. Варганза - кишл.Чиракчи";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Кашкадарья";
			    $river_flow->place = "кишл. Чиракчи - н/б Чимкурганского вдхр";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();






			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Зарафшан";
			    $river_flow->place = "н/б Раватходжинской плотины";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Зарафшан";
			    $river_flow->place = "н/б Раватходжинской плотины - Ак-Карадарьинский вододелитель";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Зарафшан";
			    $river_flow->place = "Ак-Карадарьинский вододелитель - Хатырчинский";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Зарафшан";
			    $river_flow->place = "Хатырчинский - Зиатдинский";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Зарафшан";
			    $river_flow->place = "Зиатдинский - г.Навои";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();







			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Сырдарья";
			    $river_flow->place = "исток - составлящие (р.Нарын, Карадарья)";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Сырдарья";
			    $river_flow->place = "составлящие - кишл.Каль";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Сырдарья";
			    $river_flow->place = "кишл.Каль - ниже сброса КМК";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Сырдарья";
			    $river_flow->place = "ниже сброса КМК - пос.Надеждинский";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Сырдарья";
			    $river_flow->place = "пос.Надеждинский - г.Чинас";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Сырдарья";
			    $river_flow->place = "г.Чинас - выше устья р.Келес";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();







			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Ангрен";
			    $river_flow->place = "исток - учтье р.Ирташ";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Ангрен";
			    $river_flow->place = "учтье р.Ирташ - ниже Ахангаранской плотины";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Ангрен";
			    $river_flow->place = "ниже Ахангаранской плотины - дюкера Ташкентского канала";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Ангрен";
			    $river_flow->place = "дюкера Ташкентского канала - Тюяьугузского вдхр";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Ангрен";
			    $river_flow->place = "н/б Тюяьугузского вдхр - пгт Солдатское";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();







			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Чирчик";
			    $river_flow->place = "истек - составляющие (р.Пскем, р.Чаткал)";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Чирчик";
			    $river_flow->place = "составляющие плотина Чарвакской ГЭС";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Чирчик";
			    $river_flow->place = "плотина Чарвакской ГЭС - г.Газалкент";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

			    $river_flow = new \App\General\RiverFlowRecources();
			    $river_flow->region_name = "Чирчик";
			    $river_flow->place = "г.Газалкент - г.Чиназ";
			    $river_flow->years = Input::get('year');
                $river_flow->user_id = Auth::id();
                $river_flow->is_approve=false;
			    $river_flow->save();

                $river_recourses = RiverFlowRecources::where('years',Input::get('year'))->orderby('id','ASC')->get();
			    return view('general.pages.resources.river_flow_recources.river_flow_recources',[
				    'river_recourses'=>$river_recourses,
				    'year' => Input::get('year'),
                    'last_update' => $last_update_date


                ]);

		    }
		    else
		    {
			    $river_recourses = RiverFlowRecources::where('years',Input::get('year'))->orderby('id','ASC')->get();
			    return view('general.pages.resources.river_flow_recources.river_flow_recources',[
				    'river_recourses'=>$river_recourses,
				    'year' => Input::get('year'),
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
            case "average":
                RiverFlowRecources::where('id',Input::get('ids'))->update(['user_id'=>Auth::id(),'is_approve'=>false,'average'=>Input::get('param')]);
                break;
            case 'greatest':
                RiverFlowRecources::where('id',Input::get('ids'))->update(['user_id'=>Auth::id(),'is_approve'=>false,'greatest'=>Input::get('param')]);
                break;
            case 'least':
                RiverFlowRecources::where('id',Input::get('ids'))->update(['user_id'=>Auth::id(),'is_approve'=>false,'least'=>Input::get('param')]);
                break;
            case 'lower_target':
                RiverFlowRecources::where('id',Input::get('ids'))->update(['user_id'=>Auth::id(),'is_approve'=>false,'lower_target'=>Input::get('param')]);
                break;
            case 'location':
                RiverFlowRecources::where('id',Input::get('ids'))->update(['user_id'=>Auth::id(),'is_approve'=>false,'location'=>Input::get('param')]);
                break;
            case 'cumulative':
                RiverFlowRecources::where('id',Input::get('ids'))->update(['user_id'=>Auth::id(),'is_approve'=>false,'cumulative'=>Input::get('param')]);
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

                RiverFlowRecources::where('years',$request->get('year'))->update(['user_id'=>Auth::id(),'is_approve'=>true]);

        }

        return redirect()->back();

    }
}
