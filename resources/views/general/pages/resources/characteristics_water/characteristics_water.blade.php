@extends('general.layouts.layout')
@section('content')
    <main id="main" class="py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h4 class="ml-12 mb-12 font-weight-bold text-primary text-uppercase">
                        {{ trans('messages.Characteristics of the degree of pollution') }}
                    </h4>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="row justify-content-between">
                <div class="col-auto">
                    @if(isset($last_update))
                        <p class="small">
                            {{ $last_update->user_id ? trans('messages.Change'). $last_update->users->getFullname() .' |'  : '' }}   {{$last_update->updated_at}} | {{ trans('messages.Status') }}: 
                            {{$last_update->is_approve ? trans('messages.Approved') : trans('messages.Not approved') }}
                        </p>
                    @endif
                </div>
            </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            <div class="row justify-content-between align-items-end create-daily-form-row p-3">
                <div class="col-12">
                    <div class="form-row align-items-center">
                        <div class="form-group col-8 " >
                            <label>{{ trans('messages.Form') }}</label>
                            <select class="form-control" v-model="options" name="sort">
                                @if(in_array(\Auth::user()->org_name, ['gidromet', 'other']))
                                    <option selected value="1">{{ trans('messages.General Resource table 1') }}</option>
                                @endif
                                @if(in_array(\Auth::user()->org_name, ['gidrogeologiya', 'other']))
                                    <option value="2">{{ trans('messages.General Resource table 2') }}</option>
                                @endif
                                @if(in_array(\Auth::user()->org_name, ['gidromet', 'other']))
                                    <option value="3">{{ trans('messages.General Resource table 3') }}</option>
                                @endif
                                @if(in_array(\Auth::user()->org_name, ['gidromet', 'other']))
                                    <option value="4">{{ trans('messages.General Resource table 4') }}</option>
                                @endif
                                @if(in_array(\Auth::user()->org_name, ['gidrogeologiya', 'other']))
                                    <option value="5">{{ trans('messages.General Resource table 5') }}</option>
                                @endif
                                @if(in_array(\Auth::user()->org_name, ['minvodxoz', 'other']))
                                    <option value="6">{{ trans('messages.General Resource table 6') }}</option>
                                @endif
                                @if(in_array(\Auth::user()->org_name, ['minvodxoz', 'other']))
                                    <option value="7">{{ trans('messages.General Resource table 6_a') }}</option>
                                @endif
                                @if(in_array(\Auth::user()->org_name, ['gidromet', 'other']))
                                    <option value="8">{{ trans('messages.General Resource table 6_b') }}</option>
                                @endif
                                @if(in_array(\Auth::user()->org_name, ['gidromet', 'other']))
                                    <option value="9">{{ trans('messages.General Resource table 7') }}</option>
                                @endif
                                @if(in_array(\Auth::user()->org_name, ['gidromet', 'other']))
                                    <option value="10">{{ trans('messages.General Resource table 9') }}</option>
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-2 " >
                            <label>{{ trans('messages.Year') }}</label>
                            <select class="form-control" data-live-search='true' v-model="year" title='Выбрать..' name="year" >
                                @for($i = date('Y'); $i >= 1970; $i--)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-2">
                        <div class="form-row justify-content-end my-3">
                            <a @click="ChangeSelect"  href="#" class="btn btn-primary btn-sm ml-auto mr-1">{{ trans('messages.Open') }}</a>
                            <a href="#" class="btn btn-primary btn-sm ml-auto mr-1" data-toggle="modal" data-target="#add">{{ trans('messages.Add') }}</a>
                            @if(\Auth::user()->org_name == 'gidromet')
                                @if(\Auth::user()->role->name == 'Administrator' || \Auth::user()->role->name == 'Editor')
                                    <form action="{{route('general.resource.resource_regions.accept')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="year" value="{{$last_update ? $last_update->years : null}}">
                                        <input type="hidden" name="type" value="resource">
                                        <input type="submit" class="btn btn-primary btn-sm ml-auto mr-1" value="Одобрить">
                                    </form>
                                @endif
                            @endif
                        </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

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
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
@section('modal')
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form  method="post" action="{{route('general.resource.characteristics_water.store')}}" class="modal-content">
                @csrf
                <input type="hidden" name="id" id="hidden">
                <input type="hidden" name="year" value="{{ $year }}" id="hidden">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title" id="exampleModalLabel">{{ trans('messages.Adding form') }}</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="tab-pane fade show active" id="nav-ru" role="tabpanel" aria-labelledby="nav-ru-tab">
                        <table id="" class="table table-striped table-bordered adding-forms">
                            <tbody>
                            <tr>
                                <th scope="row">{{ trans('messages.List of posts on rivers and canals') }}</th>
                                <td class="form-group">
                                    <select class="selectpicker"  data-live-search='true' name="post_place"  title='Выбрать..' data-width='100%'>
                                        @foreach($posts_lists as $list)
                                            <option value="{{$list->id}}">{{$list->name}} - {{$list->post_place}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">{{ trans('messages.Chemistry list') }}</th>
                                <td class="form-group">
                                    <select class="selectpicker"   data-live-search='true' name="chemicils" title='Выбрать..' data-width='100%'>
                                        @foreach($chemicils as $list)
                                            <option value="{{$list->id}}">{!!  $list->name !!}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">{{ trans('messages.Average annual excess of PDK') }}</th>
                                <td>
                                    <input type="number" step="0.1"  name="average_excess" value="{{old('average_excess', $average_excess)}}" class="form-control" id="average_excess" placeholder="">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">{{ trans('messages.observation date') }}</th>
                                <td>
                                    <input type="date" step="0.1"  name="date_observation" value="{{old('date_observation', $date_observation)}}" class="form-control" id="date_observation" placeholder="">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">{{ trans('messages.multiplicity of excess of MPC') }}</th>
                                <td>
                                    <input type="number" step="0.1"  name="excess_ratio" value="{{old('excess_ratio', $excess_ratio)}}" class="form-control" id="excess_ratio" placeholder="">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary btn-sm px-5" data-dismiss="modal">{{ trans('messages.Close') }}</button>
                    <input type="submit" class="btn btn-primary px-5" value="Сохранить"></input>
                </div>
            </form>
        </div>
    </div>

@stop

@section('scripts')
    <script>
        let main = new Vue({
            el:'#main',
            data:{
                options:'{{$id}}',
                year:'{{$year}}',

            },
            methods:{
                Changes:function(func,param,ids) {

                    axios.post('{{route('general.resource.information_large_canals_irigation_system.update')}}', {
                        func: func,
                        param: param,
                        ids: ids,
                        _token: "{{ csrf_token() }}",

                    })
                        .then(function (response) {
                            console.log(response);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });



                },
                ChangeSelect:function () {

                    switch (main.options) {
                        case '1':
                            window.location.href = '{{route('general.resource.resource_regions_with')}}?id='+ main.options + '&year=' + main.year;
                            break;
                        case '2':
                            window.location.href = '{{route('general.resource.uw_reserf')}}?id='+ main.options + '&year=' + main.year;
                            break;
                        case '3':
                            window.location.href = '{{route('general.resource.water_uses')}}?id='+ main.options + '&year=' + main.year;
                            break;
                        case '4':
                            window.location.href = '{{route('general.resource.river_recources')}}?id='+ main.options + '&year=' + main.year;
                            break;
                        case '5':
                            window.location.href = '{{route('general.resource.ground_water')}}?id='+ main.options + '&year=' + main.year;
                            break;
                        case '6':
                            window.location.href = '{{route('general.resource.ground_water_use')}}?id='+ main.options + '&year=' + main.year;
                            break;
                        case '7':
                            window.location.href = '{{route('general.resource.water_use_various_needs')}}?id='+ main.options + '&year=' + main.year;
                            break;
                        case '8':
                            window.location.href = '{{route('general.resource.information_large_canals_irigation_system')}}?id='+ main.options + '&year=' + main.year;
                            break;
                        case '9':
                            window.location.href = '{{route('general.resource.change_water_reserves')}}?id='+ main.options + '&year=' + main.year;
                            break;
                        case '10':
                            window.location.href = '{{route('general.resource.characteristics_water')}}?id='+ main.options + '&year=' + main.year;
                            break;



                    }

                }
            }
        })
    </script>
@stop
