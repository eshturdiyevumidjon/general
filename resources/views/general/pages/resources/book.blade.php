@extends('general.layouts.layout')

@section('content')
    <style>

    </style>
    <main id="main" class="py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-auto">
                    <h4 class="font-weight-bold text-primary text-uppercase mb-3">General</h4>
                </div>
                <div class="col-auto ml-auto">
                    @include('gidromet.partials.alerts')
                </div>
            </div>
            <div class="row create-daily-form-row p-3">
                <div class="col-12">
                    <form action="{{route('general.word.export')}}"  method="post">
                        @csrf
                        <div class="form-row mb-3">
                            <div class="col-auto">
                                <label for="">Год</label>
                                <select class="custom-select custom-select-sm" name="year">
                                    @for ($i = date('Y'); $i >= 1970; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-auto ml-auto mt-auto">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-glass-martini-alt"></i> Сформировать</button>
                                <button  id="btn_export" class="btn btn-sm btn-success" ><i class="fas fa-download"></i> Экпорт</button>

                            </div>
                        </div>
                    </form>
                </div>
            </div>


            <div id="export">
                <h4 id="titleOfForm" class="ml-3 font-weight-bold text-primary text-uppercase">РЕСУРСЫ ПОВЕРХНОСТНЫХ И ПОДЗЕМНЫХ ВОД, ИХ ИСПОЛЬЗОВАНИЕ</h4>
                <div class="table-responsive">
                    <table id="" class="table table-striped small reestr-tables">
                        <thead class="create-daily-form-row text-center">
                        <tr  class="">
                            <th rowspan="2" scope="col">
                                Вилоят
                            </th>
                            <th scope="col" colspan="3">Многолнетний сток</th>
                            <th scope="col" colspan="4" rowspan="1">
                                Водные ресурсы за 2017 год
                            </th>
                            <th scope="col" rowspan="2" colspan="2">
                                Суммарное изменение стока
                            </th>
                        <tr class="">
                            <th scope="col">среднее значение</th>
                            <th scope="col">наибольшее значение</th>
                            <th scope="col">наименьшее значение</th>
                            <th scope="col">
                                Местный сток
                            </th>
                            <th scope="col">
                                приток
                            </th>
                            <th scope="col">
                                оттоз за пределы вилоята
                            </th>
                            <th scope="col">
                                обшие ресурсы
                            </th>

                        </tr>
                        </thead>
                        <tbody>
                        <tr class="create-daily-form-row text-center">
                            <th >1</th>
                            <th >2</th>
                            <th >3</th>
                            <th >4</th>
                            <th >5</th>
                            <th >6</th>
                            <th >7</th>
                            <th >8</th>
                            <th >9</th>
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

                <h4 id="titleOfForm" class="ml-3 font-weight-bold text-primary text-uppercase text-uppercase ">Эксплуационные запасы подземных вод по состоянию на 1 января 2018 г,км3/год</h4>
                <div class="table-responsive">
                    <table id="" class="table table-striped small reestr-tables">
                        <thead class="create-daily-form-row text-center">
                        <tr  class="">
                            <th rowspan="2" scope="col">
                                Вилоят
                            </th>
                            <th scope="col" colspan="2">Многолнетний сток</th>
                            <th scope="col" rowspan="2" colspan="2">
                                Суммарное изменение стока
                            </th>
                        <tr class="">
                            <th scope="col">среднее значение</th>
                            <th scope="col">наибольшее значение</th>
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

                <h4 id="titleOfForm" class="ml-3 font-weight-bold text-primary text-uppercase block">Сведения о заборах и сбросах воды, км3/год</h4>
                <div class="table-responsive">
                    <table id="" class="table table-striped small reestr-tables">
                        <thead class="create-daily-form-row text-center">
                        <tr  class="">
                            <th rowspan="2" scope="col">
                                Вилоят
                            </th>
                            <th scope="col" colspan="5">Забрано воды</th>

                        <tr class="">
                            <th scope="col">всего км<sup>3</sup></th>
                            <th scope="col">из речной сети</th>
                            <th scope="col">из внутненних рек</th>
                            <th scope="col">из подземных источнеков</th>
                            <th scope="col">из коллекторов</th>


                        </tr>
                        </thead>
                        <tbody>
                        <tr class="create-daily-form-row text-center">
                            <th >1</th>
                            <th >2</th>
                            <th >3</th>
                            <th >4</th>
                            <th >5</th>
                            <th >6</th>
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
                <h4 id="titleOfForm" class="ml-3 font-weight-bold text-primary text-uppercase">Ресурсы речного стока, км3/год</h4>
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

                <h4 id="titleOfForm" class="ml-3 font-weight-bold text-primary text-uppercase">Ресурсы подземных вод,  км <sup>3</sup>/по состоянию на 1 января 2018 г</h4>
                <div class="table-responsive">
                    <table id="" class="table table-striped small reestr-tables">
                        <thead class="create-daily-form-row text-center">
                        <tr  class="">
                            <th scope="col" rowspan="3" >
                                Гидрогеологические районы
                            </th>
                            <th scope="col" rowspan="3" >Естественные русурсы</th>
                            <th scope="col" colspan="3" >
                                Эксплуатационных запасы
                            </th>
                        </tr>
                        <tr>
                            <th scope="col"  colspan="2">региональные</th>
                            <th scope="col">утвержденные</th>
                        </tr>
                        <tr>
                            <th scope="col">всего</th>
                            <th scope="col">в том числе за счет поверхностных вод</th>
                            <th scope="col">всего</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($ground_waters as $key=>$ground_water)
                            <tr class="create-daily-form-table text-center">
                                <td >{{$ground_water->pool_name}} , {{$ground_water->region_name}}</td>
                                <td>{{$ground_water->natural_resources}}</td>
                                <td>{{$ground_water->region_total}}</td>
                                <td>{{$ground_water->including_surface_water}}</td>
                                <td>{{$ground_water->approved_total}}</td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                </div>

                <h4 id="titleOfForm" class="ml-3 font-weight-bold text-primary text-uppercase">использование подземных вод , км <sup>3</sup>/год по состоянию на 1 января 2018 г</h4>
                <div class="table-responsive">
                    <table id="" class="table table-striped small reestr-tables">
                        <thead class="create-daily-form-row text-center">
                        <tr  class="">
                            <th  rowspan="2" >
                                Гидрогеологические районы
                            </th>
                            <th  colspan="2" >Забрано воды из подземных источников</th>
                        </tr>
                        <tr>
                            <th>Всего</th>
                            <th>в том числе за счет ущерба речному стоку</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($ground_water_uses as $key=>$ground_water)
                            <tr class="create-daily-form-table text-center">
                                <td >{{$ground_water->pool_name}} , {{$ground_water->region_name}}</td>
                                <td>{{$ground_water->total}}</td>
                                <td>{{$ground_water->river_flow}}</td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                </div>

                <h4 id="titleOfForm" class="ml-3 font-weight-bold text-primary text-uppercase">использование воды на различеые нужды в вилоятах , км <sup>3</sup>/год</h4>
                <div class="table-responsive">
                    <table id="" class="table table-striped small reestr-tables">
                        <thead class="create-daily-form-row text-center">
                        <tr  class="">
                            <th scope="col" rowspan="3" >
                                Вилоят
                            </th>
                            <th scope="col" colspan="3" >Забрано воды</th>
                            <th scope="col" colspan="6" >По отреслям хозяйств</th>
                        </tr>
                        <tr>
                            <th scope="col">из поверхностных источников</th>
                            <th scope="col">из подземных источников</th>
                            <th scope="col">всего</th>
                            <th scope="col">орощение</th>
                            <th scope="col">промышленность</th>
                            <th scope="col">коммунальное хозяйство</th>
                            <th scope="col">рыбное хозяйство</th>
                            <th scope="col">безвозвратно в энергетике</th>
                            <th scope="col">прочие</th>
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
                <h4 id="titleOfForm" class="ml-3 font-weight-bold text-primary text-uppercase">сведение о крупных каналах переброски стока и магистральных каналах оросительных систем</h4>
                <div class="table-responsive">
                    <table id="" class="table table-striped small reestr-tables">
                        <thead class="create-daily-form-row text-center">
                        <tr  class="">
                            <th scope="col">
                                Река
                            </th>
                            <th scope="col">Расстояние от устья реки до головы канала, км</th>
                            <th scope="col">наименование канала</th>
                            <th scope="col">Пропускная способность канала м<sup>3</sup>/с</th>
                            <th scope="col">Средний годовой расход воды  м<sup>3</sup>/с </th>
                            <th scope="col">Забрано воды головными сооружениями канала  млн.м<sup>3</sup></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($information_large_canals as $key=>$ground_water)
                            <tr class="create-daily-form-table text-center">
                                <td >{{$ground_water->river}}</td>
                                <td >{{$ground_water->distance_river}}</td>
                                <td >{{$ground_water->name_canal}}</td>
                                <td>{{$ground_water->canal_bandwidth}}</td>
                                <td>{{$ground_water->average_water}}</td>
                                <td>{{$ground_water->canal_main_structures}}</td>
                            </tr>
                        @endforeach
                        </tbody>

                    </table>

                </div>

                <h4 id="titleOfForm" class="ml-3 font-weight-bold text-primary text-uppercase">Изменение запасов  воды и уровней крупных озер и водохранительнищ </h4>
                <div class="table-responsive">
                    <table id="" class="table table-striped small reestr-tables">
                        <thead class="create-daily-form-row text-center">
                        <tr  class="">
                            <th scope="col" rowspan="2">
                                №
                            </th>
                            <th scope="col" rowspan="2">
                                Озеро, водохранилище
                            </th>
                            <th scope="col" rowspan="2">Средний многолетный запас воды озер,обьем вдхр при НПУ , млн м<sup>3</sup></th>
                            <th scope="col" rowspan="2">Средний многолетный уровен озер НПУ водохранилищ м БС</th>
                            <th scope="col" colspan="3">Запас воды, млн м<sup>3</sup>/с</th>
                            <th scope="col" colspan="3">Уровень воды , м БС</th>
                        </tr>
                        <tr>
                            <th>на 01.01.2017 г</th>
                            <th>на 01.01.2018 г</th>
                            <th>годовое изменение</th>
                            <th>на 01.01.2017 г</th>
                            <th>на 01.01.2018 г</th>
                            <th>изменение за год</th>
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

                <h4 id="titleOfForm" class="ml-3 font-weight-bold text-primary text-uppercase">Характеристика степени загрязненности поверхностный вод суши </h4>
                <div class="table-responsive">
                    <table id="" class="table table-striped small reestr-tables">
                        <thead class="create-daily-form-row text-center">
                        <tr  class="">
                            <th scope="col" rowspan="2">список постов на реках и каналах</th>
                            <th scope="col" rowspan="2">Основные загрязняющие вещества</th>
                            <th scope="col" rowspan="2">Среднее годовое превышение ГДК</th>
                            <th scope="col" colspan="2">Максимальное в году превышение ПДК</th>
                        </tr>
                        <tr>
                            <th scope="col">дата наблюдения</th>
                            <th scope="col">кратность превышения ПДК</th>
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
