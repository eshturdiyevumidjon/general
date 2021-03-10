<?php

namespace App\Http\Controllers\General;

use App\Exports\CanalsExport;
use App\Exports\Gidrogeologiya\BirthPlaceExport;
use App\Exports\Gidrogeologiya\BirthPlaceImportTemplate;
use App\Gidrogeologiya\HydrologicalRegion;
use App\Gidrogeologiya\PlaceBirth;
use App\Gidrogeologiya\PlaceBirthAttrs;
use App\Imports\CanalsImport;
use App\Imports\Girdoreologiya\BirthPlaceImport;
use App\UzDistricts;
use App\UzRegions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class PlaceBirthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->session()->remove('orderBy');
        $request->session()->remove('orderBy2');
        // dd($request->orderBy);
        if ($request->per_page) $request->session()->put('perPage', json_decode($request->per_page));
        if ($request->orderBy) $request->session()->put('orderBy', $request->orderBy);
        if ($request->orderBy2) $request->session()->put('orderBy2', $request->orderBy2);
        if ($request->orderType) $request->session()->put('orderType', $request->orderType);

        if($request->checkedRows) PlaceBirth::whereIn('id', $request->checkedRows)->update(['isDeleted' => true]);

        $reestrs = PlaceBirth::where('isDeleted',false)
            ->orderBy($request->session()->get('orderBy') ?? 'id', $request->session()->get('orderType') ?? 'ASC')
            ->with(['birth_place_attr' => function($q) {
                $q->orderBy(request()->session()->get('orderBy2') ?? 'id', request()->session()->get('orderType') ?? 'ASC');
            }])->paginate($request->session()->get('perPage') ?? 10);


        $uz_regions = UzRegions::all();
        $uz_districts = UzDistricts::all();
        $hydro_regions = HydrologicalRegion::where('isDeleted',false)->get();

        return view('gidrogeologiya.pages.reestr.birth_place.birth_place', compact('reestrs', 'uz_regions', 'uz_districts', 'hydro_regions'));
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
        $request->validate([
            'code' => 'required',
            'name' => 'required',
            'year' => 'required'
        ]);

        $birth_place =  new PlaceBirth();
        $birth_place->code = Input::get('code');
        $birth_place->name = Input::get('name');
        // $birth_place->location = Input::get('location');
        $birth_place->geol_index = Input::get('geol_index');
        $birth_place->favcolor = Input::get('favcolor');
        $birth_place->comment = Input::get('comment');
        $birth_place->year = Input::get('year');
        $birth_place->is_approve = false;
        $birth_place->user_id = Auth::id();
        $birth_place->groundwater_resource = Input::get('groundwater_resource');
        $birth_place->approved_groundwater_reserves = Input::get('approved_groundwater_reserves');
        $birth_place->selection_from_approved_groundwater_reserves = Input::get('selection_from_approved_groundwater_reserves');
        $birth_place->save();

        if(Input::get('districts') != null || Input::get('regions') != null)
        {
            if(Input::get('districts') == null)
            {
                foreach (Input::get('regions') as $key=>$region)
                {
                    $canals_attr = new PlaceBirthAttrs();
                    $canals_attr->place_birth_id = $birth_place->id;
                    $canals_attr->region_id = $region;
                    $canals_attr->save();
                }
            }
            else
            {
                foreach (Input::get('districts') as $key=>$region)
                {
                    $canals_attr = new PlaceBirthAttrs();
                    $canals_attr->canals_id = $birth_place->id;
                    $region_id = UzDistricts::select('regionid')->where('areaid','=',$region)->first();
                    $canals_attr->region_id = $region_id->regionid;
                    $canals_attr->district_id = $region;
                    $canals_attr->save();
                }
            }
        }

        return redirect(route('gg.reestr.bp.index'));
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
            $birth_place = PlaceBirth::Where('id',$request->get('id'))->with('users')->first();
            return $birth_place;
        }
        if($request->has('code'))
        {
            $birth_place = PlaceBirth::where('isDeleted',false)->where('code',$request->get('code'))->whereBetween('year',[$request->get('start'),$request->get('finish')])->get();
            if(count($birth_place)  > 0)
                return $birth_place;
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
            'name' => 'required'
        ]);

        $bp = PlaceBirth::find(Input::get('id'));
        $bp->code = Input::get('code');
        $bp->name = Input::get('name');
        // $bp->location = Input::get('location');
        $bp->geol_index = Input::get('geol_index');
        $bp->favcolor = Input::get('favcolor');
        $bp->comment = Input::get('comment');
        $bp->is_approve = false;
        $bp->user_id = Auth::id();
        $bp->groundwater_resource = Input::get('groundwater_resource');
        $bp->approved_groundwater_reserves = Input::get('approved_groundwater_reserves');
        $bp->selection_from_approved_groundwater_reserves = Input::get('selection_from_approved_groundwater_reserves');
        $bp->save();

        PlaceBirthAttrs::where('place_birth_id',Input::get('id'))->delete();

        if(Input::get('districts') != null || Input::get('regions') != null)
        {
            if(Input::get('districts') == null)
            {
                foreach (Input::get('regions') as $key=>$region)
                {
                    $birth_place_attr = new PlaceBirthAttrs();
                    $birth_place_attr->place_birth_id = Input::get('id');
                    $birth_place_attr->region_id = $region;
                    $birth_place_attr->save();
                }
            } else {
                foreach (Input::get('districts') as $key=>$region)
                {
                    $birth_place_attr = new PlaceBirthAttrs();
                    $birth_place_attr->place_birth_id = Input::get('id');
                    $region_id = UzDistricts::select('regionid')->where('areaid','=',$region)->first();
                    $birth_place_attr->region_id = $region_id->regionid;
                    $birth_place_attr->district_id = $region;
                    $birth_place_attr->save();
                }
            }

        }

        return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bp = PlaceBirth::find($id);
        $bp->isDeleted = true;
        $bp->save();
        // return redirect(route('gg.reestr.bp.index'));
        return redirect()->back();
    }

    public function getSelectedRegions()
    {
        $bp = PlaceBirthAttrs::select('region_id','district_id')->where('place_birth_id','=', Input::get('id'))->get();
        return $bp;
    }

    public function Export()
    {
        return Excel::download(new BirthPlaceExport(), 'Месторождения_'.Carbon::now().'.xlsx');

    }

    public function ExportTemplate()
    {
        return Excel::download(new BirthPlaceImportTemplate(), 'Шаблон-Месторождения_'.Carbon::now().'.xlsx');

    }

    public function Import()
    {
        Excel::import(new BirthPlaceImport(), request()->file('select_file'));
        return redirect(route('gg.reestr.bp.index'));
    }

    public function Search(Request $request)
    {
        $queries = array_filter($request->all());
        $data = PlaceBirth::where("isDeleted", false);

        // dd(array_filter($queries));
        if ($queries) {
            foreach ($queries as $key => $value) {
                if($key == 'code')
                    $data = $data->where($key, $value);
                elseif($key == 'name')
                    $data = $data->where('name', 'ilike', '%' . trim($value) . '%');
                elseif($key == 'is_approve') {
                    if($value == "all") $data = $data;
                    else $data = $data->where($key, $value);
                } elseif($key == "region")
                    $data = $data->whereHas('birth_place_attr.uz_regions', function ($query) {
                        $query->where('regionid', request()->region);
                    });
                elseif($key == "district")
                    $data = $data->whereHas('birth_place_attr.uz_districts', function ($query) {
                        $query->where('areaid', request()->district);
                    });
                elseif($key == 'users')
                    $data = $data->whereHas('users', function ($query) {
                        $query->where('email', 'ilike',  '%' . request()->user . '%');
                    });
                else return redirect(route('gg.reestr.bp.index'))->with('warning', 'Нет данных по этим критериям!');
            }
        } else return redirect(route('gg.reestr.bp.index'))->with('warning', 'Пустой запрос!');

        $reestrs = $data->with('birth_place_attr','users')->paginate($request->session()->get('perPage') ?? 10);
        $uz_regions = UzRegions::all();
        $uz_districts = UzDistricts::all();
        $hydro_regions = HydrologicalRegion::where('isDeleted', false)->get();

        return view('gidrogeologiya.pages.reestr.birth_place.birth_place', compact('reestrs', 'uz_regions', 'uz_districts', 'hydro_regions'));
    }

    public function Accept(Request $request)
    {
        if(Auth::user()->hasRole('Administrator'))
        {
            PlaceBirth::where('id',$request->get('id'))->where('year',$request->get('year'))->update(['user_id'=>Auth::id(),'is_approve'=>true]);
            return redirect()->back();
        }
    }

    public function AcceptAll(Request $request)
    {
        if(Auth::user()->hasRole('Administrator'))
        {
            PlaceBirth::wherein('id',$request->get('checkedRows'))->update(['user_id'=>Auth::id(),'is_approve'=>true]);
            return redirect()->back();
        }
    }

}
