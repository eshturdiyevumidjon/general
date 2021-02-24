@extends('general.layouts.layout')

@section('content')
    <main id="main" class="py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-auto">
                    <h4 class="font-weight-bold text-primary text-uppercase mb-3">{{ trans('messages.Reports') }}</h4>
                </div>
                <div class="col-auto ml-auto">
                    @include('partials.alerts')
                </div>
            </div>
            <div class="row create-daily-form-row p-3">
                <div class="col-12">
                    <form action="{{route('general.word.export')}}"  method="post">
                        @csrf
                        <div class="form-row mb-3">
                            <div class="col-auto">
                                <label for="">{{ trans('messages.Year') }}</label>
                                <select class="custom-select custom-select-sm" name="year">
                                    @for ($i = date('Y'); $i >= 1970; $i--)
                                        <option {{ $year == $i ? "selected=''" : '' }} value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-auto ml-auto mt-auto">
                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fas fa-glass-martini-alt"></i> {{ trans('messages.To shape') }}
                                </button>
                                <button  id="btn_export" class="btn btn-sm btn-success" >
                                    <i class="fas fa-download"></i> {{ trans('messages.Export') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div id="export">
                <h4 id="titleOfForm" class="ml-3 font-weight-bold text-primary text-uppercase">
                    {{ trans('messages.SURFACE AND UNDERGROUND WATER RESOURCES AND THEIR USE') }}
                </h4>
                <div class="table-responsive">
                    <table id="" class="table table-striped small reestr-tables">
                        <thead class="create-daily-form-row text-center">
                        <tr class="">
                            <th scope="col" rowspan="2">{{ trans('messages.Region') }}</th>
                            <th scope="col" colspan="3">{{ trans('messages.Long-term runoff') }}</th>
                            <th scope="col" colspan="4" rowspan="1">
                                {{ str_replace('{year}', $year, trans('messages.Water resources year')) }}
                            </th>
                            <th scope="col" rowspan="2" colspan="2">{{ trans('messages.Total flow change') }}</th>
                        </tr>
                        <tr class="">
                            <th scope="col">{{ trans('messages.average value') }}</th>
                            <th scope="col">{{ trans('messages.maximal value') }}</th>
                            <th scope="col">{{ trans('messages.minimal value') }}</th>
                            <th scope="col">{{ trans('messages.Local runoff') }}</th>
                            <th scope="col">{{ trans('messages.inflow') }}</th>
                            <th scope="col">{{ trans('messages.ottosis outside the region') }}</th>
                            <th scope="col">{{ trans('messages.common resources') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="create-daily-form-row text-center">
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>5</th>
                            <th>6</th>
                            <th>7</th>
                            <th>8</th>
                            <th>9</th>
                        </tr>
                        @foreach ($resource_regions as $key=>$resource)
                            <tr class="create-daily-form-table text-center">
                                <td>{{$resource->region_name}}</td>
                                <td>{{$resource->average_values}}</td>
                                <td>{{$resource->highest_values}}</td>
                                <td>{{$resource->smallest_value}}</td>
                                <td>{{$resource->local_rows}}</td>
                                <td>{{$resource->inflow}}</td>
                                <td>{{$resource->outflow_outside}}</td>
                                <td>{{$resource->shared_resources}}</td>
                                <td>{{$resource->total_row}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <h4 id="titleOfForm" class="ml-3 font-weight-bold text-primary text-uppercase text-uppercase">
                    {!! str_replace('{year}', $year, trans('messages.Operational groundwater reserves as of year')) !!}
                </h4>
                <div class="table-responsive">
                    <table id="" class="table table-striped small reestr-tables">
                        <thead class="create-daily-form-row text-center">
                            <tr class="">
                                <th rowspan="2" scope="col">{{ trans('messages.Region') }}</th>
                                <th scope="col" colspan="2">{{ trans('messages.Long-term runoff') }}</th>
                                <th scope="col" rowspan="2" colspan="2">{{ trans('messages.Total flow change') }}</th>
                            </tr>
                            <tr class="">
                                <th scope="col">{{ trans('messages.average') }}</th>
                                <th scope="col">{{ trans('messages.maximal value') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($uw_resers as $key=>$uw_reserf)
                                <tr class="create-daily-form-table text-center">
                                    <td>{{$uw_reserf->region_name}}</td>
                                    <td>{{$uw_reserf->total}}</td>
                                    <td>{{$uw_reserf->surface_water}}</td>
                                    <td>{{$uw_reserf->ex_reserf}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <h4 id="titleOfForm" class="ml-3 font-weight-bold text-primary text-uppercase block">
                    {!! trans('messages.Information on water withdrawals and discharges, km3 / year') !!}
                </h4>
                <div class="table-responsive">
                    <table id="" class="table table-striped small reestr-tables">
                        <thead class="create-daily-form-row text-center">
                        <tr class="">
                            <th rowspan="2" scope="col">{{ trans('messages.Region') }}</th>
                            <th scope="col" colspan="5">{{ trans('messages.Water taken') }}</th>
                        </tr>
                        <tr class="">
                            <th scope="col">{{ trans('messages.total km') }}<sup>3</sup></th>
                            <th scope="col">{{ trans('messages.from the river network') }}</th>
                            <th scope="col">{{ trans('messages.from inland rivers') }}</th>
                            <th scope="col">{{ trans('messages.from underground sources') }}</th>
                            <th scope="col">{{ trans('messages.from collectors') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="create-daily-form-row text-center">
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>5</th>
                            <th>6</th>
                        </tr>
                        @foreach ($water_uses as $key=>$water_use)
                            <tr class="create-daily-form-table text-center">
                                <td>{{$water_use->region_name}}</td>
                                <td>{{$water_use->total_km}}</td>
                                <td>{{$water_use->river_network}}</td>
                                <td>{{$water_use->inland_rivers}}</td>
                                <td>{{$water_use->underground_sources}}</td>
                                <td>{{$water_use->from_collector}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <h4 id="titleOfForm" class="ml-3 font-weight-bold text-primary text-uppercase">
                    {!! trans('messages.River flow resources, km3 / year') !!}
                </h4>
                <div class="table-responsive">
                    <table id="" class="table table-striped small reestr-tables">
                        <thead class="create-daily-form-row text-center">
                        <tr class="">
                            <th scope="col" rowspan="2">{{ trans('messages.River') }}</th>
                            <th scope="col" rowspan="2">{{ trans('messages.Plot') }}</th>
                            <th scope="col" colspan="3" rowspan="1">{{ trans('messages.Characteristics of long-term runoff') }}</th>
                            <th scope="col" rowspan="2" colspan="1">{{ trans('messages.Observed runoff in the downstream section') }}</th>
                            <th scope="col" colspan="2">{{ trans('messages.Total flow change') }}</th>
                        </tr>
                        <tr class="">
                            <th scope="col">{{ trans('messages.average') }}</th>
                            <th scope="col">{{ trans('messages.maximal') }}</th>
                            <th scope="col">{{ trans('messages.minimal') }}</th>
                            <th scope="col">{{ trans('messages.location on') }}</th>
                            <th scope="col">{{ trans('messages.cumulative total') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($river_recourses as $key=>$river_recourse)
                            <tr class="create-daily-form-table text-center">
                                <td>{{$river_recourse->region_name}}</td>
                                <td>{{$river_recourse->place}}</td>
                                <td>{{$river_recourse->average}}</td>
                                <td>{{$river_recourse->greatest}}</td>
                                <td>{{$river_recourse->least}}</td>
                                <td>{{$river_recourse->lower_target}}</td>
                                <td>{{$river_recourse->location}}</td>
                                <td>{{$river_recourse->cumulative}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <h4 id="titleOfForm" class="ml-3 font-weight-bold text-primary text-uppercase">
                    {!! str_replace('{year}', $year, trans('messages.Groundwater resources km3 year')) !!}
                </h4>
                <div class="table-responsive">
                    <table id="" class="table table-striped small reestr-tables">
                        <thead class="create-daily-form-row text-center">
                        <tr class="">
                            <th scope="col" rowspan="3">{{ trans('messages.Hydrogeological areas') }}</th>
                            <th scope="col" rowspan="3">{{ trans('messages.Natural resources') }}</th>
                            <th scope="col" colspan="3">{{ trans('messages.Operational reserves') }}</th>
                        </tr>
                        <tr>
                            <th scope="col" colspan="2">{{ trans('messages.regional') }}</th>
                            <th scope="col">{{ trans('messages.approved') }}</th>
                        </tr>
                        <tr>
                            <th scope="col">{{ trans('messages.total') }}</th>
                            <th scope="col">{{ trans('messages.including due to surface water') }}</th>
                            <th scope="col">{{ trans('messages.total') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($ground_waters as $key=>$ground_water)
                            <tr class="create-daily-form-table text-center">
                                <td>{{$ground_water->pool_name}}, {{$ground_water->region_name}}</td>
                                <td>{{$ground_water->natural_resources}}</td>
                                <td>{{$ground_water->region_total}}</td>
                                <td>{{$ground_water->including_surface_water}}</td>
                                <td>{{$ground_water->approved_total}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <h4 id="titleOfForm" class="ml-3 font-weight-bold text-primary text-uppercase">
                    {!! str_replace('{year}', $year, trans('messages.groundwater use year')) !!}
                </h4>
                <div class="table-responsive">
                    <table id="" class="table table-striped small reestr-tables">
                        <thead class="create-daily-form-row text-center">
                        <tr class="">
                            <th rowspan="2">{{ trans('messages.Hydrogeological areas') }}</th>
                            <th colspan="2">{{ trans('messages.Water taken from underground sources') }}</th>
                        </tr>
                        <tr>
                            <th>{{ trans('messages.total') }}</th>
                            <th>{{ trans('messages.including due to damage to river flow') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($ground_water_uses as $key=>$ground_water)
                            <tr class="create-daily-form-table text-center">
                                <td >{{$ground_water->pool_name}}, {{$ground_water->region_name}}</td>
                                <td>{{$ground_water->total}}</td>
                                <td>{{$ground_water->river_flow}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <h4 id="titleOfForm" class="ml-3 font-weight-bold text-primary text-uppercase">
                    {!! trans('messages.water use for various needs in regions') !!}
                </h4>
                <div class="table-responsive">
                    <table id="" class="table table-striped small reestr-tables">
                        <thead class="create-daily-form-row text-center">
                        <tr class="">
                            <th scope="col" rowspan="3">{{ trans('messages.Region') }}</th>
                            <th scope="col" colspan="3">{{ trans('messages.Water taken') }}</th>
                            <th scope="col" colspan="6">{{ trans('messages.By industry sectors') }}</th>
                        </tr>
                        <tr>
                            <th scope="col">{{ trans('messages.from surface sources') }}</th>
                            <th scope="col">{{ trans('messages.from underground sources') }}</th>
                            <th scope="col">{{ trans('messages.total') }}</th>
                            <th scope="col">{{ trans('messages.irrigation') }}</th>
                            <th scope="col">{{ trans('messages.industry') }}</th>
                            <th scope="col">{{ trans('messages.communal services') }}</th>
                            <th scope="col">{{ trans('messages.fishery') }}</th>
                            <th scope="col">{{ trans('messages.irrevocably in energy') }}</th>
                            <th scope="col">{{ trans('messages.others') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($water_use_needs as $key=>$ground_water)
                            <tr class="create-daily-form-table text-center">
                                <td >{{$ground_water->region_name}}</td>
                                <td>{{$ground_water->from_surface_sources}}</td>
                                <td>{{$ground_water->from_underground_sources}}</td>
                                <td>{{$ground_water->total}}</td>
                                <td>{{$ground_water->irrigation}}</td>
                                <td>{{$ground_water->industry}}</td>
                                <td>{{$ground_water->utilities}}</td>
                                <td>{{$ground_water->fisheries}}</td>
                                <td>{{$ground_water->irrevocably_energy}}</td>
                                <td>{{$ground_water->other}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <h4 id="titleOfForm" class="ml-3 font-weight-bold text-primary text-uppercase">
                    {{ trans('messages.information about large canals') }}                    
                </h4>
                <div class="table-responsive">
                    <table id="" class="table table-striped small reestr-tables">
                        <thead class="create-daily-form-row text-center">
                        <tr class="">
                            <th scope="col">{{ trans('messages.River') }}</th>
                            <th scope="col">{{ trans('messages.Distance from the river km') }}</th>
                            <th scope="col">{{ trans('messages.canale name') }}</th>
                            <th scope="col">{!! trans('messages.Channel bandwidth') !!}</th>
                            <th scope="col">{!! trans('messages.Average annual water') !!}</th>
                            <th scope="col">{!! trans('messages.Water withdrawn') !!}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($information_large_canals as $key=>$ground_water)
                            <tr class="create-daily-form-table text-center">
                                <td>{{$ground_water->river}}</td>
                                <td>{{$ground_water->distance_river}}</td>
                                <td>{{$ground_water->name_canal}}</td>
                                <td>{{$ground_water->canal_bandwidth}}</td>
                                <td>{{$ground_water->average_water}}</td>
                                <td>{{$ground_water->canal_main_structures}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <h4 id="titleOfForm" class="ml-3 font-weight-bold text-primary text-uppercase">
                    {{ trans('messages.Changes in water reserves and levels') }}
                </h4>
                <div class="table-responsive">
                    <table id="" class="table table-striped small reestr-tables">
                        <thead class="create-daily-form-row text-center">
                        <tr class="">
                            <th scope="col" rowspan="2">№</th>
                            <th scope="col" rowspan="2">{{ trans('messages.Reservoir') }}</th>
                            <th scope="col" rowspan="2">{!! trans('messages.Average long-term water reserve of lakes') !!}</th>
                            <th scope="col" rowspan="2">{{ trans('messages.Average long-term level of lakes in the NPU') }}</th>
                            <th scope="col" colspan="3">{!! trans('messages.Water supply') !!}</th>
                            <th scope="col" colspan="3">{{ trans('messages.Water level') }}</th>
                        </tr>
                        <tr>
                            <th>{{ str_replace('{year}', "01.01." . $year, trans('messages.to year')) }}</th>
                            <th>{{ str_replace('{year}', "01.01." . ($year + 1), trans('messages.to year')) }}</th>
                            <th>{{ trans('messages.annual change') }}</th>
                            <th>{{ str_replace('{year}', "01.01." . $year, trans('messages.to year')) }}</th>
                            <th>{{ str_replace('{year}', "01.01." . ($year + 1), trans('messages.to year')) }}</th>
                            <th>{{ trans('messages.change per year') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($change_waters as $key=>$ground_water)
                            <tr class="create-daily-form-table text-center">
                                <td>{{$key+1}}</td>
                                <td >{{$ground_water->lake}}</td>
                                <td>{{$ground_water->average_water_volume}}</td>
                                <td>{{$ground_water->average_long_term_level}}</td>
                                <td></td>
                                <td>{{$ground_water->water_supply}}</td>
                                <td>{{$ground_water->annual_change}}</td>
                                <td></td>
                                <td>{{$ground_water->water_level}}</td>
                                <td>{{$ground_water->change_for_year}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <h4 id="titleOfForm" class="ml-3 font-weight-bold text-primary text-uppercase">
                    {{ trans('messages.Characteristics of the degree of pollution') }}
                </h4>
                <div class="table-responsive">
                    <table id="" class="table table-striped small reestr-tables">
                        <thead class="create-daily-form-row text-center">
                        <tr  class="">
                            <th scope="col" rowspan="2">{{ trans('messages.list of posts on rivers and canals') }}</th>
                            <th scope="col" rowspan="2">{{ trans('messages.Major pollutants') }}</th>
                            <th scope="col" rowspan="2">{{ trans('messages.Average annual excess of GDK') }}</th>
                            <th scope="col" colspan="2">{{ trans('messages.Maximum excess of MPC per year') }}</th>
                        </tr>
                        <tr>
                            <th scope="col">{{ trans('messages.observation date') }}</th>
                            <th scope="col">{{ trans('messages.multiplicity of excess of MPC') }}</th>
                        </tr>
                        <tr>
                            <th>0</th>
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($character_waters as $key=>$list)
                            <tr class="create-daily-form-table text-center">
                                <td >{{$list->post_list->name}} - {{$list->post_list->post_place}} </td>
                                <td >{!! $list->chimicil_list->name !!}</td>
                                <td >{{$list->average_excess}}</td>
                                <td>{{$list->date_observation}}</td>
                                <td>{{$list->excess_ratio}}</td>
                                {{--                                <td><input step="0.01" type="number"  @change="Changes('average_water',$event.target.value,{{$ground_water->id}})"   value="{{$ground_water->average_water}}"></td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

@endsection

@section('scripts')
    <script>
        window.btn_export.onclick = function() {

            if (!window.Blob) {
                alert('Your legacy browser does not support this action.');
                return;
            }

            var html, link, blob, url, css;

            // EU A4 use: size: 841.95pt 595.35pt;
            // US Letter use: size:11.0in 8.5in;

            css = (
                '<style>' +
                '@page WordSection1{size: 841.95pt 595.35pt;mso-page-orientation: landscape;}' +
                'div.WordSection1 {page: WordSection1;}' +
                'table{border-collapse:collapse;}td,th,tr{border:1px gray solid;width:5em;padding:2px;font-size: 10px}'+
                '</style>'
            );

            html = window.export.innerHTML;
            blob = new Blob(['\ufeff', css + html], {
                type: 'application/msword'
            });
            url = URL.createObjectURL(blob);
            link = document.createElement('A');
            link.href = url;
            // Set default file name.
            // Word will append file extension - do not add an extension here.
            link.download = 'Ежегодный ГВК';
            document.body.appendChild(link);
            if (navigator.msSaveOrOpenBlob ) navigator.msSaveOrOpenBlob( blob, 'Ежегодный ГВК.doc'); // IE10-11
            else link.click();  // other browsers
            document.body.removeChild(link);
        };
    </script>

@stop
