@extends('general.layouts.layout')
@section('content')
    <main id="main" class="py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h4 class="ml-12 mb-12 font-weight-bold text-primary text-uppercase">
                        {!! str_replace('{year}', $year, trans('messages.Operational groundwater reserves as of year')) !!}
                    </h4>
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
                            <select class="form-control" v-model="options" name="sort" >
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
                            <select class="form-control" data-live-search='true' v-model="year" title="{{ trans('messages.Select') }}" name="year" >
                                @for($i = date('Y'); $i >= 1970; $i--)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-5">
                            <div class="form-row justify-content-end my-3">
                                <a @click="ChangeSelect" href="#" class="btn btn-primary btn-sm ml-auto mr-1">{{ trans('messages.Open') }}</a>
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
                            <th rowspan="2" scope="col">{{ trans('messages.Region') }}</th>
                            <th scope="col" colspan="2">{{ trans('messages.Long-term runoff') }}</th>
                            <th scope="col" rowspan="2" colspan="2">{{ trans('messages.Total flow change') }}</th>
                        </tr>
                        <tr class="">
                            <th scope="col">{{ trans('messages.average value') }}</th>
                            <th scope="col">{{ trans('messages.maximal value') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($uw_reserfs as $key=>$uw_reserf)
                            <tr class="create-daily-form-table text-center">
                                <td>{{$uw_reserf->region_name}}</td>
                                @if(\Auth::user()->role->name == 'Administrator' || \Auth::user()->role->name == 'Editor')
                                    @if($uw_reserf->is_approve)
                                        <td>
                                            <input class="form-control" step="0.01" type="number"  @change="Changes('total',$event.target.value,{{$uw_reserf->id}})" value="{{$uw_reserf->total}}">
                                        </td>
                                    @else
                                        <td>
                                            <input class="form-control alert-danger" step="0.01" type="number"  @change="Changes('total',$event.target.value,{{$uw_reserf->id}})" value="{{$uw_reserf->total}}">
                                        </td>
                                    @endif
                                    @if($uw_reserf->is_approve)
                                        <td>
                                            <input class="form-control" step="0.01" type="number"  @change="Changes('surface_water',$event.target.value,{{$uw_reserf->id}})" value="{{$uw_reserf->surface_water}}">
                                        </td>
                                    @else
                                        <td>
                                            <input class="form-control alert-danger" step="0.01" type="number"  @change="Changes('surface_water',$event.target.value,{{$uw_reserf->id}})" value="{{$uw_reserf->surface_water}}">
                                        </td>
                                    @endif
                                    @if($uw_reserf->is_approve)
                                        <td>
                                            <input class="form-control" step="0.01" type="number"  @change="Changes('ex_reserf',$event.target.value,{{$uw_reserf->id}})"  value="{{$uw_reserf->ex_reserf}}">
                                        </td>
                                    @else
                                        <td>
                                            <input class="form-control alert-danger" step="0.01" type="number"  @change="Changes('ex_reserf',$event.target.value,{{$uw_reserf->id}})"  value="{{$uw_reserf->ex_reserf}}">
                                        </td>
                                    @endif
                                @else
                                    @if($uw_reserf->is_approve)
                                        <td>
                                            <input class="form-control" disabled step="0.01" type="number"  @change="Changes('total',$event.target.value,{{$uw_reserf->id}})" value="{{$uw_reserf->total}}">
                                        </td>
                                    @else
                                        <td>
                                            <input class="form-control alert-danger" disabled step="0.01" type="number"  @change="Changes('total',$event.target.value,{{$uw_reserf->id}})" value="{{$uw_reserf->total}}">
                                        </td>
                                    @endif
                                    @if($uw_reserf->is_approve)
                                        <td>
                                            <input class="form-control" disabled step="0.01" type="number"  @change="Changes('surface_water',$event.target.value,{{$uw_reserf->id}})" value="{{$uw_reserf->surface_water}}">
                                        </td>
                                    @else
                                        <td>
                                            <input class="form-control alert-danger" disabled step="0.01" type="number"  @change="Changes('surface_water',$event.target.value,{{$uw_reserf->id}})" value="{{$uw_reserf->surface_water}}">
                                        </td>
                                    @endif
                                    @if($uw_reserf->is_approve)
                                        <td>
                                            <input class="form-control" disabled step="0.01" type="number"  @change="Changes('ex_reserf',$event.target.value,{{$uw_reserf->id}})"  value="{{$uw_reserf->ex_reserf}}">
                                        </td>
                                    @else
                                        <td>
                                            <input class="form-control alert-danger" disabled step="0.01" type="number"  @change="Changes('ex_reserf',$event.target.value,{{$uw_reserf->id}})"  value="{{$uw_reserf->ex_reserf}}">
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

                    axios.post('{{route('general.resource.uw_reserf.update')}}', {
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