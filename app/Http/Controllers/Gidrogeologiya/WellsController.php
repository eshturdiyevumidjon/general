<?php

namespace App\Http\Controllers\Gidrogeologiya;

use App\Exports\Gidrogeologiya\WellsExport;
use App\Gidrogeologiya\Intended;
use App\Gidrogeologiya\PlaceBirth;
use App\Gidrogeologiya\Wells;
use App\Gidrogeologiya\WellsAttr;
use App\Gidrogeologiya\WellsType;
use App\Imports\Gidrogeologiya\WellsImport;
use App\UzDistricts;
use App\UzRegions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;

class WellsController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $request->session()->remove('orderBy');
    if ($request->per_page) $request->session()->put('perPage', json_decode($request->per_page));
    if ($request->orderBy) $request->session()->put('orderBy', $request->orderBy);
    if ($request->orderType) $request->session()->put('orderType', $request->orderType);
    if ($request->checkedRows) Wells::whereIn('id', $request->checkedRows)->update(['isDeleted' => true]);

    if ($request->cadaster_number) {
      $reestr = Wells::where('isDeleted', false)
        ->orderBy($request->session()->get('orderBy') ?? 'id', $request->session()->get('orderType') ?? 'ASC')
        ->where("cadaster_number", $request->cadaster_number)
        ->with('wells_attr', 'pv_field', 'users')
        ->paginate($request->session()->get('perPage') ?? 20);
    } else $reestr = Wells::where('isDeleted', false)
      ->orderBy($request->session()->get('orderBy') ?? 'id', $request->session()->get('orderType') ?? 'ASC')
      ->with('wells_attr', 'pv_field')
      ->paginate($request->session()->get('perPage') ?? 20);

    $year = Carbon::now()->year;
    $well_types = WellsType::where('isDeleted', false)->get();
    $uz_regions = UzRegions::all();
    $uz_districts = UzDistricts::all();
    $intendeds = Intended::where('isDeleted', false)->get();
    $bp = PlaceBirth::where('isDeleted', false)->get();
    $cadaster_ids = Wells::where('isDeleted', false)->pluck('cadaster_number');

    return view('gidrogeologiya.pages.reestr.weels.weels')
      ->with('reestr', $reestr)
      ->with('uz_regions', $uz_regions)
      ->with('uz_districts', $uz_districts)
      ->with('intendeds', $intendeds)
      ->with('pv_fields', $bp)
      ->with('well_types', $well_types)
      ->with('cadaster_ids', $cadaster_ids)
      ->with('year', $year);
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
      'cadaster_number' => [
        'required',
        Rule::unique('wells')->where(function ($query) {
          return $query->where('isDeleted', false);
        })
      ],
      'year' => 'required',
    ]);

    $wells = new Wells();
    $wells->wells_type_id = Input::get('well_type_id');
    $wells->number_auther = Input::get('no_auther');
    $wells->cadaster_number = Input::get('cadaster_number');
    $wells->pv_field_id = Input::get('pv_fields_id');
    $wells->lat = Input::get('lat');
    $wells->long = Input::get('long');
    $wells->location = Input::get('location');
    $wells->absolute_mark = Input::get('absolute_mark');
    $wells->year_drilling = Input::get('year_drilling');
    $wells->casing_diameter = Input::get('casing_diametr');
    $wells->filter_interval_from = Input::get('filter_interval_from');
    $wells->filter_interval_up = Input::get('filter_interval_up');
    $wells->geologic_age = Input::get('geologic_age');
    $wells->age_lithology = Input::get('age_lithology');
    $wells->static_level = Input::get('static_level');
    $wells->intended_id = Input::get('intended_id');
    $wells->water_withdrawal_limit = Input::get('water_withdrawal_limit');
    $wells->dynamic_level = Input::get('dynamic_level');
    $wells->comsuption = Input::get('comsuption');
    $wells->lowering = Input::get('lowering');
    $wells->mineralization = Input::get('mineralization');
    $wells->rigidity = Input::get('rigidity');
    if ($request->filepath)
      $wells->path = $request->filepath;
    $wells->user_id = Auth::id();
    $wells->is_approve = false;
    $wells->year = Input::get('year');
    $wells->lithology_well_design = Input::get('lithology_well_design');
    $wells->comment = Input::get('comment');
    $wells->save();

    if (Input::get('districts') != null || Input::get('regions') != null) {
      if (Input::get('districts') == null) {
        foreach (Input::get('regions') as $key => $region) {
          $wells_attr = new WellsAttr();
          $wells_attr->wells_id = $wells->id;
          $wells_attr->region_id = $region;
          $wells_attr->save();
        }
      } else {
        foreach (Input::get('districts') as $key => $region) {
          $wells_attr = new WellsAttr();
          $wells_attr->wells_id = $wells->id;
          $region_id = UzDistricts::select('regionid')->where('areaid', '=', $region)->first();
          $wells_attr->region_id = $region_id->regionid;
          $wells_attr->district_id = $region;
          $wells_attr->save();
        }
      }
    }
    return redirect(route('gg.reestr.wells.index'));
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
    if ($request->has('id')) {
      $wells = Wells::where('id', Input::get('id'))->with('users')->first();
      return $wells;
    } elseif ($request->has('code')) {
      $wells = Wells::where('cadaster_number', $request->code)->where('isDeleted', false)->with('wells_attr', 'pv_field', 'well_type', 'intentent')->first();
      if ($wells)
        return $wells;
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
    $wells = Wells::find(Input::get('id'));
    $wells->wells_type_id = Input::get('well_type_id');
    $wells->number_auther = Input::get('no_auther');
    $wells->cadaster_number = Input::get('cadaster_number');
    $wells->pv_field_id = Input::get('pv_fields_id');
    $wells->lat = Input::get('lat');
    $wells->long = Input::get('long');
    $wells->absolute_mark = Input::get('absolute_mark');
    $wells->year_drilling = Input::get('year_drilling');
    $wells->casing_diameter = Input::get('casing_diametr');
    $wells->filter_interval_from = Input::get('filter_interval_from');
    $wells->filter_interval_up = Input::get('filter_interval_up');
    $wells->geologic_age = Input::get('geologic_age');
    $wells->age_lithology = Input::get('age_lithology');
    $wells->static_level = Input::get('static_level');
    $wells->intended_id = Input::get('intended_id');
    $wells->water_withdrawal_limit = Input::get('water_withdrawal_limit');
    $wells->dynamic_level = Input::get('dynamic_level');
    $wells->comsuption = Input::get('comsuption');
    $wells->lowering = Input::get('lowering');
    $wells->mineralization = Input::get('mineralization');
    $wells->rigidity = Input::get('rigidity');
    if ($request->lithology_well_design)
      $wells->path = $request->lithology_well_design;
    $wells->location = Input::get('location');
    $wells->user_id = Auth::id();
    $wells->lithology_well_design = Input::get('lithology_well_design');
    $wells->comment = Input::get('comment');
    $wells->is_approve = false;
    $wells->save();

    WellsAttr::where('wells_id', Input::get('id'))->delete();

    if (Input::get('districts') != null || Input::get('regions') != null) {
      if (Input::get('districts') == null) {
        foreach (Input::get('regions') as $key => $region) {
          $wells_attr = new WellsAttr();
          $wells_attr->wells_id = $wells->id;
          $wells_attr->region_id = $region;
          $wells_attr->save();
        }
      } else {
        foreach (Input::get('districts') as $key => $region) {
          $wells_attr = new WellsAttr();
          $wells_attr->wells_id = $wells->id;
          $region_id = UzDistricts::select('regionid')->where('areaid', '=', $region)->first();
          $wells_attr->region_id = $region_id->regionid;
          $wells_attr->district_id = $region;
          $wells_attr->save();
        }
      }
    }
    // return redirect(route('gg.reestr.wells.index'));
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
    $ap = Wells::find($id);
    $ap->isDeleted = true;
    $ap->save();

    return redirect()->back();
  }

  public function getSelectedRegions()
  {
    $bp = WellsAttr::select('region_id', 'district_id')->where('wells_id', '=', Input::get('id'))->get();

    return $bp;
  }

  public function Export()
  {
    $data = Wells::where('isDeleted', false)->with('wells_attr', 'pv_field', 'well_type', 'intentent');

    if (request()->regions) {
      $data = $data->whereHas('wells_attr.uz_regions', function ($query) {
        $query->where('regionid', request()->regions);
      })->get();
    } else $data = $data->get();

    return Excel::download(new WellsExport($data), 'СКВАЖИНЫ_' . Carbon::now() . '.xlsx');
  }

  public function ExportTemplate()
  {
    $data = [];
    return Excel::download(new WellsExport($data), 'СКВАЖИНЫ__шаблон' . Carbon::now() . '.xlsx');
  }

  public function Import()
  {
    Excel::import(new WellsImport(), request()->file('select_file'));
    return redirect(route('gg.reestr.wells.index'));
  }

  public function Search(Request $request)
  {
    if (
      Input::get('cadaster_number') != null ||
      Input::get('number_auther') != null ||
      Input::get('wells_type_s') != null ||
      Input::get('pv_fields') != null ||
      Input::get('regions') != null ||
      Input::get('district') != null ||
      Input::get('users') != null |
      Input::get('is_approve') != null
    ) {
      $wells = Wells::orderby('id', 'ASC')->where('isDeleted', '=', false);
      foreach (Input::all() as $key => $element) {
        if (!empty($element)) {
          if (
            $key != 'regions' &&
            $key != 'district' &&
            $key != 'pv_fields' &&
            $key != 'wells_type_s' &&
            $key != 'page' &&
            $key != 'users'

          ) {
            if ($key == 'is_approve') {
              $wells = $wells->where($key, $element);
            } else {
              $wells = $wells->where($key, 'like', '%' . $element . '%');
            }
          }
          if ($key == 'regions') {
            $wells = $wells->whereHas('wells_attr.uz_regions', function ($query) {
              $query->where('regionid', Input::get('regions'));
            });
          }
          if ($key == 'district') {
            $wells = $wells->whereHas('wells_attr.uz_districts', function ($query) {
              $query->where('areaid', Input::get('district'));
            });
          }
          if ($key == 'pv_fields') {
            $wells = $wells->whereHas('pv_field', function ($query) {
              $query->where('name', 'ilike',  '%' . Input::get('pv_fields') . '%');
            });
          }
          if ($key == 'wells_type_s') {
            $wells = $wells->whereHas('well_type', function ($query) {
              $query->whereId(Input::get('wells_type_s'));
            });
          }
          if ($key == 'users') {
            $wells = $wells->whereHas('users', function ($query) {
              $query->where('email', 'ilike',  '%' . Input::get('users') . '%');
            });
          }
        } else {
        }
      }

      $wells = $wells->with('wells_attr', 'pv_field', 'users')->paginate($request->session()->get('perPage') ?? 20);
      $year = Carbon::now()->year;
      $well_types = WellsType::where('isDeleted', false)->get();
      $uz_regions = UzRegions::all();
      $uz_districts = UzDistricts::all();
      $intendeds = Intended::where('isDeleted', false)->get();
      $bp = PlaceBirth::where('isDeleted', false)->get();
      $cadaster_ids = Wells::where('isDeleted', false)->pluck('cadaster_number');

      return view('gidrogeologiya.pages.reestr.weels.weels')
        ->with('reestr', $wells)
        ->with('uz_regions', $uz_regions)
        ->with('uz_districts', $uz_districts)
        ->with('intendeds', $intendeds)
        ->with('pv_fields', $bp)
        ->with('well_types', $well_types)
        ->with('cadaster_ids', $cadaster_ids)
        ->with('year', $year);
    } else {
      return redirect(route('gg.reestr.wells.index'));
    }
  }

  public function Accept(Request $request)
  {
    if (Auth::user()->hasRole('Administrator')) {

      Wells::where('id', $request->get('id'))->where('year', $request->get('year'))->update(['user_id' => Auth::id(), 'is_approve' => true]);
    }

    return redirect()->back();
  }

  public function AcceptAll(Request $request)
  {
    if (Auth::user()->hasRole('Administrator')) {
      Wells::wherein('id', $request->get('checkedRows'))->update(['user_id' => Auth::id(), 'is_approve' => true]);
      return redirect()->back();
    }
  }
}
