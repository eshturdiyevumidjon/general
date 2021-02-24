@extends('general.layouts.layout')
@section('content')
<main id="main" class="py-3">
    <div class="container-fluid">
        <div class="row">
            <div class="col-8">
                <h4 class="ml-3 mb-3 font-weight-bold text-primary text-uppercase">
                    {{ trans('messages.SURFACE AND UNDERGROUND WATER RESOURCES AND THEIR USE') }}
                </h4>
            </div>
        </div>
        <div class="row justify-content-between align-items-end create-daily-form-row p-3">
            <div class="col-12">
                <div class="form-row align-items-center">
                    <div class="form-group col-5 " >
                        <label>{{ trans('messages.Form') }}</label>
                        <select class="form-control" v-model="options" name="sort" >
                            <option value="0">{{ trans('messages.Select') }}</option>
                            @if(in_array(\Auth::user()->org_name, ['gidromet', 'other']))
                                <option value="1">{{ trans('messages.General Resource table 1') }}</option>
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
                    <div class="form-group col-2">
                        <label>{{ trans('messages.Year') }}</label>
                        <select class="form-control" data-live-search='true' title="{{ trans('messages.Select') }}" v-model="year" name="year" >
                            @for($i = date('Y'); $i >= 1970; $i--)
                                <option value="{{$i}}">{{$i}}</option>
                             @endfor
                        </select>
                    </div>
                    <div class="col-5">
                        <div class="form-row justify-content-end my-3">
                            <a @click="ChangeSelect" href="#" class="btn btn-primary btn-sm ml-auto mr-1">{{ trans('messages.Open') }}</a>
                        </div>
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

                    axios.post('{{route('general.resource.resource_regions.update')}}', {
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
            },
            created(){
            }
        })
    </script>
@stop