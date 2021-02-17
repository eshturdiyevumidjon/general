@extends('general.layouts.layout')
@section('content')
    <main id="main" class="py-3">
        <div class="container-fluid">
            <div class="row">

                <div class="col-12">
                    <h4 class="ml-12 mb-12 font-weight-bold text-primary text-uppercase">
                        Ресурсы речного стока, км3/год
                    </h4>
                </div>

                <div class="clearfix"></div>

            </div>
            <div class="row justify-content-between">
                <div class="col-auto">
                @if(isset($last_update))
                    <p class="small">{{$last_update->user_id ? 'Изменение: '. $last_update->users->getFullname() .' |'  : '' }}   {{$last_update->updated_at}} | статус: {{$last_update->is_approve ? 'Одобрен' : 'Неодобрен' }}</p>
                @endif
                </div>
            </div>
            <div class="row justify-content-between align-items-end create-daily-form-row p-3">
                <div class="col-12">
                    <div class="form-row align-items-center  ">
                        <div class="form-group col-5 " >
                            <label>Форма</label>
                            <select class="form-control" v-model="options" name="sort">
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
                                    <option selected value="4">таблица 4.Ресурсы речного стока, км3/год</option>
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
                            <select class="form-control" data-live-search='true' v-model="year" title='Выбрать..' name="year" >
                                @for($i = 1970; $i <= \Carbon\Carbon::now()->year;$i++)
                                    <option value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-5">

                            <div class="form-row justify-content-end my-3">
                                <a @click="ChangeSelect" href="#" class="btn btn-primary btn-sm ml-auto mr-1">Открыть</a>
                                @if(\Illuminate\Support\Facades\Auth::user()->org_name == 'gidromet')
                                    @hasanyrole('Administrator|Editor')
                                    <form action="{{route('general.resource.river_recources.accept')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="year" value="{{$last_update->years}}">
                                        <input type="hidden" name="type" value="resource">
                                        <input type="submit"  class="btn btn-primary btn-sm ml-auto mr-1" value="Одобрить"></input>

                                    </form>
                                    @endhasanyrole
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
                        <tr  class="">
                            <th rowspan="2" scope="col">
                                Река
                            </th>
                            <th scope="col" rowspan="2">Участок</th>
                            <th scope="col" colspan="3" rowspan="1">
                                Характеристика многолетнего стока в нижнем створе
                            </th>
                            <th scope="col" rowspan="2" colspan="1">
                                Наблюденный сток в нижнем створе
                            </th>
                            <th scope="col"  colspan="2">
                                Суммарное изменение стока
                            </th>
                        <tr class="">
                            <th scope="col">средний</th>
                            <th scope="col">наибольший</th>
                            <th scope="col">наименьший</th>
                            <th scope="col">
                                на участке
                            </th>
                            <th scope="col">
                                нарастающим итогом
                            </th>


                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($river_recourses as $key=>$river_recourse)
                            <tr class="create-daily-form-table text-center">
                                <td >{{$river_recourse->region_name}}</td>
                                <td>{{$river_recourse->place}}</td>
                                @hasanyrole('Administrator|Editor')
                                @if($river_recourse->is_approve)
                                <td><input class="form-control" step="0.01" type="number"  @change="Changes('average',$event.target.value,{{$river_recourse->id}})" value="{{$river_recourse->average}}"></td>
                                @else
                               <td><input class="form-control alert-danger" step="0.01" type="number"  @change="Changes('average',$event.target.value,{{$river_recourse->id}})" value="{{$river_recourse->average}}"></td>
                                @endif
                                @if($river_recourse->is_approve)
                                <td><input class="form-control" step="0.01" type="number"  @change="Changes('greatest',$event.target.value,{{$river_recourse->id}})"   value="{{$river_recourse->greatest}}"></td>
                                @else
                               <td><input class="form-control alert-danger" step="0.01" type="number"  @change="Changes('greatest',$event.target.value,{{$river_recourse->id}})"   value="{{$river_recourse->greatest}}"></td>
                                @endif
                                @if($river_recourse->is_approve)
                                <td><input class="form-control " step="0.01" type="number"  @change="Changes('least',$event.target.value,{{$river_recourse->id}})" value="{{$river_recourse->least}}"></td>
                                @else
                                <td><input class="form-control alert-danger" step="0.01" type="number"  @change="Changes('least',$event.target.value,{{$river_recourse->id}})" value="{{$river_recourse->least}}"></td>
                                @endif
                                @if($river_recourse->is_approve)
                                <td><input class="form-control" step="0.01" type="number"  @change="Changes('lower_target',$event.target.value,{{$river_recourse->id}})" value="{{$river_recourse->lower_target}}"></td>
                                @else
                                <td><input class="form-control alert-danger" step="0.01" type="number"  @change="Changes('lower_target',$event.target.value,{{$river_recourse->id}})" value="{{$river_recourse->lower_target}}"></td>
                                @endif
                                @if($river_recourse->is_approve)
                                <td><input class="form-control" step="0.01" type="number"  @change="Changes('location',$event.target.value,{{$river_recourse->id}})" value="{{$river_recourse->location}}"></td>
                                @else
                                <td><input class="form-control alert-danger" step="0.01" type="number"  @change="Changes('location',$event.target.value,{{$river_recourse->id}})" value="{{$river_recourse->location}}"></td>
                                @endif
                                @if($river_recourse->is_approve)
                                <td><input class="form-control" step="0.01" type="number"  @change="Changes('cumulative',$event.target.value,{{$river_recourse->id}})" value="{{$river_recourse->cumulative}}"></td>
                                @else
                                <td><input class="form-control alert-danger" step="0.01" type="number"  @change="Changes('cumulative',$event.target.value,{{$river_recourse->id}})" value="{{$river_recourse->cumulative}}"></td>
                                @endif
                                @else
                                    @if($river_recourse->is_approve)
                                    <td><input class="form-control" disabled step="0.01" type="number"  @change="Changes('average',$event.target.value,{{$river_recourse->id}})" value="{{$river_recourse->average}}"></td>
                                    @else
                                    <td><input class="form-control alert-danger" disabled step="0.01" type="number"  @change="Changes('average',$event.target.value,{{$river_recourse->id}})" value="{{$river_recourse->average}}"></td>
                                    @endif

                                    @if($river_recourse->is_approve)
                                    <td><input class="form-control" disabled step="0.01" type="number"  @change="Changes('greatest',$event.target.value,{{$river_recourse->id}})"   value="{{$river_recourse->greatest}}"></td>
                                    @else
                                    <td><input class="form-control alert-danger" disabled step="0.01" type="number"  @change="Changes('greatest',$event.target.value,{{$river_recourse->id}})"   value="{{$river_recourse->greatest}}"></td>
                                    @endif

                                    @if($river_recourse->is_approve)
                                    <td><input class="form-control" disabled step="0.01" type="number"  @change="Changes('least',$event.target.value,{{$river_recourse->id}})" value="{{$river_recourse->least}}"></td>
                                    @else
                                    <td><input class="form-control alert-danger" disabled step="0.01" type="number"  @change="Changes('least',$event.target.value,{{$river_recourse->id}})" value="{{$river_recourse->least}}"></td>
                                    @endif

                                   @if($river_recourse->is_approve)
                                   <td><input class="form-control" disabled step="0.01" type="number"  @change="Changes('lower_target',$event.target.value,{{$river_recourse->id}})" value="{{$river_recourse->lower_target}}"></td>
                                    @else
                                  <td><input class="form-control alert-danger" disabled step="0.01" type="number"  @change="Changes('lower_target',$event.target.value,{{$river_recourse->id}})" value="{{$river_recourse->lower_target}}"></td>
                                   @endif

                                                    @if($river_recourse->is_approve)
                                    <td><input class="form-control" disabled step="0.01" type="number"  @change="Changes('location',$event.target.value,{{$river_recourse->id}})" value="{{$river_recourse->location}}"></td>
                                    @else
                                            <td><input class="form-control alert-danger" disabled step="0.01" type="number"  @change="Changes('location',$event.target.value,{{$river_recourse->id}})" value="{{$river_recourse->location}}"></td>
                                        @endif

                                                        @if($river_recourse->is_approve)
                                    <td><input class="form-control" disabled step="0.01" type="number"  @change="Changes('cumulative',$event.target.value,{{$river_recourse->id}})" value="{{$river_recourse->cumulative}}"></td>
                                    @else
                                            <td><input class="form-control alert-danger" disabled step="0.01" type="number"  @change="Changes('cumulative',$event.target.value,{{$river_recourse->id}})" value="{{$river_recourse->cumulative}}"></td>
                                    @endif
                                            @endhasanyrole

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
                options:'{{\Illuminate\Support\Facades\Input::get('id')}}',
                year:'{{\Illuminate\Support\Facades\Input::get('year')}}',
            },
            methods:{
                Changes:function(func,param,ids) {

                    axios.post('{{route('general.resource.river_recources.update')}}', {
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
