@extends('general.layouts.layout')
@section('content')
    <main id="main" class="py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h4 class="ml-12 mb-12 font-weight-bold text-primary text-uppercase">
                        {{ trans('messages.information about large canals') }}
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
            <div class="row justify-content-between align-items-end create-daily-form-row p-3">
                <div class="col-12">
                    <div class="form-row align-items-center  ">
                        <div class="form-group col-5 " >
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
                        <div class="col-5">

                            <div class="form-row justify-content-end my-3">
                                <a @click="ChangeSelect" href="#" class="btn btn-primary btn-sm ml-auto mr-1">Открыть</a>
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
                <div class=" create-daily-form-row col-md-12"></div>
                <div class="clearfix"></div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="table-responsive">
                    <table id="" class="table table-striped small reestr-tables">
                        <thead class="create-daily-form-row text-center">
                        <tr class="">
                            <th scope="col">{{ trans('messages.River') }}</th>
                            <th scope="col">{{ trans('messages.Distance from the river km') }}</th>
                            <th scope="col">{{ trans('messages.River') }}canale name</th>
                            <th scope="col">{{ trans('messages.Channel bandwidth') }}</th>
                            <th scope="col">{{ trans('messages.Average annual water') }}</th>
                            <th scope="col">{{ trans('messages.Water withdrawn') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($information_large_canals as $key=>$ground_water)
                            <tr class="create-daily-form-table text-center">
                                <td>{{$ground_water->river}}</td>
                                <td>{{$ground_water->distance_river}}</td>
                                <td>{{$ground_water->name_canal}}</td>
                                @if(\Auth::user()->role->name == 'Administrator' || \Auth::user()->role->name == 'Editor')
                                    @if($ground_water->is_approve)
                                        <td>
                                            <input class="form-control" step="0.01" type="number"  @change="Changes('canal_bandwidth',$event.target.value,{{$ground_water->id}})" value="{{$ground_water->canal_bandwidth}}">
                                        </td>
                                    @else
                                        <td>
                                            <input class="form-control alert-danger" step="0.01" type="number"  @change="Changes('canal_bandwidth',$event.target.value,{{$ground_water->id}})" value="{{$ground_water->canal_bandwidth}}">
                                        </td>
                                    @endif
                                    @if($ground_water->is_approve)
                                        <td>
                                            <input class="form-control" step="0.01" type="number"  @change="Changes('average_water',$event.target.value,{{$ground_water->id}})"   value="{{$ground_water->average_water}}">
                                        </td>
                                    @else
                                        <td>
                                            <input class="form-control alert-danger" step="0.01" type="number"  @change="Changes('average_water',$event.target.value,{{$ground_water->id}})"   value="{{$ground_water->average_water}}">
                                        </td>
                                    @endif
                                    @if($ground_water->is_approve)
                                        <td>
                                            <input class="form-control" step="0.01" type="number"  @change="Changes('canal_main_structures',$event.target.value,{{$ground_water->id}})"   value="{{$ground_water->canal_main_structures}}">
                                        </td>
                                    @else
                                        <td>
                                            <input class="form-control alert-danger" step="0.01" type="number"  @change="Changes('canal_main_structures',$event.target.value,{{$ground_water->id}})"   value="{{$ground_water->canal_main_structures}}">
                                        </td>
                                    @endif
                                @else
                                    @if($ground_water->is_approve)
                                        <td>
                                            <input disabled class="form-control" step="0.01" type="number"  @change="Changes('canal_bandwidth',$event.target.value,{{$ground_water->id}})" value="{{$ground_water->canal_bandwidth}}">
                                        </td>
                                    @else
                                        <td>
                                            <input disabled class="form-control alert-danger" step="0.01" type="number"  @change="Changes('canal_bandwidth',$event.target.value,{{$ground_water->id}})" value="{{$ground_water->canal_bandwidth}}">
                                        </td>
                                    @endif
                                    @if($ground_water->is_approve)
                                        <td>
                                            <input disabled class="form-control" step="0.01" type="number"  @change="Changes('average_water',$event.target.value,{{$ground_water->id}})"   value="{{$ground_water->average_water}}">
                                        </td>
                                    @else
                                        <td>
                                            <input disabled class="form-control alert-danger" step="0.01" type="number"  @change="Changes('average_water',$event.target.value,{{$ground_water->id}})"   value="{{$ground_water->average_water}}">
                                        </td>
                                    @endif
                                    @if($ground_water->is_approve)
                                        <td>
                                            <input disabled class="form-control" step="0.01" type="number"  @change="Changes('canal_main_structures',$event.target.value,{{$ground_water->id}})"   value="{{$ground_water->canal_main_structures}}">
                                        </td>
                                    @else
                                        <td>
                                            <input disabled class="form-control alert-danger" step="0.01" type="number"  @change="Changes('canal_main_structures',$event.target.value,{{$ground_water->id}})"   value="{{$ground_water->canal_main_structures}}">
                                        </td>
                                    @endif
                                @endif
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
        let main = new Vue({
            el:'#main',
            data:{
                options:'{{ $id }}',
                year:'{{ $year }}',
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
