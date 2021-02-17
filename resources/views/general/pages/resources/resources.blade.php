
@extends('general.layouts.layout')
@section('content')
    <main id="main" class="py-3">
        <div class="container-fluid">
            <div class="row">

                <div class="col-8">
                    <h4 class="ml-3 mb-3 font-weight-bold text-primary text-uppercase">
                        РЕСУРСЫ ПОВЕРХНОСТНЫХ И ПОДЗЕМНЫХ ВОД, ИХ ИСПОЛЬЗОВАНИЕ
                    </h4>

                </div>


                <div class="clearfix"></div>

            </div>
            <div class="row justify-content-between">
{{--                <div class="col-auto">--}}
{{--                    --}}
{{--                    <p class="small">Изменение: Пак А.В. | 01.02.2019</p>--}}
{{--                    <p class="small">статус: одобрен</p>--}}
{{--                </div>--}}
            </div>
                <div class="row justify-content-between align-items-end create-daily-form-row p-3">
                    <div class="col-12">
                        <div class="form-row align-items-center  ">
                            <div class="form-group col-5 " >
                                <label>Форма</label>
                                <select class="form-control" v-model="options" name="sort" >
                                    <option value="0"></option>
                                    @if(\Illuminate\Support\Facades\Auth::user()->org_name == 'gidromet' || \Illuminate\Support\Facades\Auth::user()->org_name == 'other'  )
                                        <option value="1">таблица 1.Ресурсы Речного стока по вилоятам, км3/год</option>
                                    @endif
                                    @if(\Illuminate\Support\Facades\Auth::user()->org_name == 'gidrogeologiya' || \Illuminate\Support\Facades\Auth::user()->org_name == 'other'  )
                                        <option value="2">таблица 2.Эксплуационные запасы подземных вод по состоянию на 1 января 2018 г,км3/год</option>
                                    @endif
                                    @if(\Illuminate\Support\Facades\Auth::user()->org_name == 'gidromet' || \Illuminate\Support\Facades\Auth::user()->org_name == 'other'  )
                                        <option value="3">таблица 3.Сведения о заборах и сбросах воды, км3/год</option>
                                    @endif
                                    @if(\Illuminate\Support\Facades\Auth::user()->org_name == 'gidromet' || \Illuminate\Support\Facades\Auth::user()->org_name == 'other'  )
                                        <option value="4">таблица 4.Ресурсы речного стока, км3/год</option>
                                    @endif
                                    @if(\Illuminate\Support\Facades\Auth::user()->org_name == 'gidrogeologiya' || \Illuminate\Support\Facades\Auth::user()->org_name == 'other'  )
                                        <option value="5">таблица 5.Ресурсы подземных вод, по состоянию на 1 января 2018 г</option>
                                    @endif
                                    @if(\Illuminate\Support\Facades\Auth::user()->org_name == 'minvodxoz' || \Illuminate\Support\Facades\Auth::user()->org_name == 'other'  )
                                        <option value="6">таблица 6.Использование подземных вод, по состоянию на 1 января 2018 г</option>
                                    @endif
                                    @if(\Illuminate\Support\Facades\Auth::user()->org_name == 'minvodxoz' || \Illuminate\Support\Facades\Auth::user()->org_name == 'other'  )
                                        <option value="7">таблица 6а.Использование воды на различние нужды в вилоятах км3/год</option>
                                    @endif
                                    @if(\Illuminate\Support\Facades\Auth::user()->org_name == 'gidromet' || \Illuminate\Support\Facades\Auth::user()->org_name == 'other'  )
                                        <option value="8">таблица 6б.Сведения о крупных канал переброски стока и магестралных каналах ороситнльных систем</option>
                                    @endif
                                    @if(\Illuminate\Support\Facades\Auth::user()->org_name == 'gidromet' || \Illuminate\Support\Facades\Auth::user()->org_name == 'other'  )
                                        <option value="9">таблица 7.Изменение запасов воды уровней крупных озер и водахранилищ</option>
                                    @endif
                                    @if(\Illuminate\Support\Facades\Auth::user()->org_name == 'gidromet' || \Illuminate\Support\Facades\Auth::user()->org_name == 'other'  )
                                        <option value="10">таблица 9.Характиристика степени загрязенности поверхностных вод суши</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-2 " >
                                <label>Год</label>
                                <select class="form-control" data-live-search='true' title='Выбрать..' v-model="year" name="year" >
                                    @for($i = \Carbon\Carbon::now()->year; $i >= 1970; $i--)
                                        <option value="{{$i}}">{{$i}}</option>
                                     @endfor
                                </select>
                            </div>
                            <div class="col-5">
                                <div class="form-row justify-content-end my-3">
                                    <a @click="ChangeSelect" href="#" class="btn btn-primary btn-sm ml-auto mr-1">Открыть</a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>







                <div class="clearfix"></div>
                <div class=" create-daily-form-row col-md-12">
                </div>
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
        </div>

    </main>
@endsection

@section('scripts')
    <script>
        let main = new Vue({
            el:'#main',
            data:{
                options:'{{\Illuminate\Support\Facades\Input::get('id')}}',
                year:'{{\Illuminate\Support\Facades\Input::get('year')}}',

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
