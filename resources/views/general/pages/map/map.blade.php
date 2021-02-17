@extends('general.layouts.layout')
@section('css')
    <link rel="shortcut icon" type="image/x-icon" href="docs/images/favicon.ico" />

    <link rel="stylesheet" href="{{asset('css/leaflet.css')}}"/>
    {{--    <script src="{{asset('js/leaflet.js')}}" ></script>--}}
@endsection
@section('content')


    <main id="main" class="">
        <div class="modal fade" id="bindPupUp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><b>Канал</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding: 0!important;">
                        <table class="table table-bordered">
                            <thead class="thead-dark" >
                            <tr>
                                <th>Параметры</th>
                                <th v-for="(item, index) in canal_ajax">@{{ item.year }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Кадастер рақами</td>
                                <td v-for="item in canal_ajax">@{{ item.code }}</td>
                            </tr>
                            <tr>
                                <td>Номи</td>
                                <td v-for="(item, index) in canal_ajax">@{{ item.name }}</td>
                            </tr>
                            <tr>
                                <td>Гидрогеологический индекс	</td>
                                <td v-for="(item, index) in canal_ajax">@{{ item.geol_index }}</td>
                            </tr>
                            <tr>
                                <td >Местоположение</td>
                                <td v-for="(item, index) in canal_ajax">@{{ item.location }}</td>
                            </tr>
                            <tr>
                                <td>Примечание</td>
                                <td v-for="(item, index) in canal_ajax">@{{ item.comment }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="Mountain" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><b>Горные массивы</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding: 0!important;">
                        <table class="table table-bordered">
                            <thead class="thead-dark" >
                            <tr>
                                <th>Параметры</th>
                                <th v-for="(item, index) in mountain_ranges_ajax">@{{ item.year }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Кадастер рақами</td>
                                <td v-for="item in mountain_ranges_ajax">@{{ item.code }}</td>
                            </tr>
                            <tr>
                                <td>Номи</td>
                                <td v-for="(item, index) in mountain_ranges_ajax">@{{ item.name }}</td>
                            </tr>
                            <tr>
                                <td>Гидрогеологический индекс	</td>
                                <td v-for="(item, index) in mountain_ranges_ajax">@{{ item.geol_index }}</td>
                            </tr>
                            <tr>
                                <td >Местоположение</td>
                                <td v-for="(item, index) in mountain_ranges_ajax">@{{ item.location }}</td>
                            </tr>
                            <tr>
                                <td>Примечание</td>
                                <td v-for="(item, index) in mountain_ranges_ajax">@{{ item.comment }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="WellsPopUp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><b>Скважины</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding: 0!important;">
                        <table class="table table-bordered">
                            <thead class="thead-dark" >
                            <tr>
                                <th>Параметры</th>
                                <th v-for="(item, index) in wells_ajax">@{{ item.year }}</th>
                            </tr>
                            </thead>
                            <tbody>
{{--                            <tr>--}}
{{--                                <td>Тип Скважины</td>--}}
{{--                                <td v-for="item in wells_ajax">@{{ item.well_type.name }}</td>--}}
{{--                            </tr>--}}
                            <tr>
                                <td>№ Авторский	</td>
                                <td v-for="item in wells_ajax">@{{ item.number_auther }}</td>
                            </tr>
                            <tr>
                                <td>№ Кадастровий</td>
                                <td v-for="item in wells_ajax">@{{ item.cadaster_number }}</td>
                            </tr>
                            <tr>
                                <td>Месторождение ПВ</td>
                                <td v-for="item in wells_ajax">@{{ item.pv_field.name }}</td>
                            </tr>
                            <tr>
                                <td>Северная широта</td>
                                <td v-for="item in wells_ajax">@{{ item.lat }}</td>
                            </tr>
                            <tr>
                                <td>Восточная долгота	</td>
                                <td v-for="item in wells_ajax">@{{ item.long }}</td>
                            </tr>
                            <tr>
                                <td>Местоположение</td>
                                <td v-for="item in wells_ajax">@{{ item.location }}</td>
                            </tr>
                            <tr>
                                <td>Абсолютная отметка</td>
                                <td v-for="item in wells_ajax">@{{ item.absolute_mark }}</td>
                            </tr>
                            <tr>
                                <td>Год бурения</td>
                                <td v-for="item in wells_ajax">@{{ item.year_drilling }}</td>
                            </tr>
                            <tr>
                                <td>Диаметр обсадки	</td>
                                <td v-for="item in wells_ajax">@{{ item.casing_diametr }}</td>
                            </tr>
                            <tr>
                                <td>Интервал установки фильтра от</td>
                                <td v-for="item in wells_ajax">@{{ item.filter_interval_from }}</td>
                            </tr>
                            <tr>
                                <td>Интервал установки фильтра до</td>
                                <td v-for="item in wells_ajax">@{{ item.filter_interval_to }}</td>
                            </tr>
                            <tr>
                                <td>Возраст и литология	</td>
                                <td v-for="item in wells_ajax">@{{ item.age_lithology }}</td>
                            </tr>
                            <tr>
                                <td>Статический уровень	</td>
                                <td v-for="item in wells_ajax">@{{ item.static_level }}</td>
                            </tr>
                            <tr>
                                <td>Целевое использование</td>
                                <td v-for="item in wells_ajax">@{{ item.intentent.name }}</td>
                            </tr>
                            <tr>
                                <td>Лимит водоотбора</td>
                                <td v-for="item in wells_ajax">@{{ item.water_withdrawal_limit.name }}</td>
                            </tr>
                            <tr>
                                <td>Примечание</td>
                                <td v-for="(item, index) in wells_ajax">@{{ item.comment }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ApprovalPlotsPopUp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><b>Утверж. участки</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding: 0!important;">
                        <table class="table table-bordered">
                            <thead class="thead-dark" >
                            <tr>
                                <th>Параметры</th>
                                <th v-for="(item, index) in approval_plots_ajax">@{{ item.year }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Кадастровый номер</td>
                                <td v-for="item in approval_plots_ajax">@{{ item.code }}</td>
                            </tr>
                            <tr>
                                <td>Название участки</td>
                                <td v-for="item in approval_plots_ajax">@{{ item.name }}</td>
                            </tr>
{{--                            <tr>--}}
{{--                                <td>Вид использования воды</td>--}}
{{--                                <td v-for="item in approval_plots_ajax" v-if="item.type_water_use.name">@{{ item.type_water_use.name }}</td>--}}
{{--                            </tr>--}}
                            <tr>
                                <td>Местоположение</td>
                                <td v-for="item in approval_plots_ajax">@{{ item.location }}</td>
                            </tr>
                            <tr>
                                <td>Северная широта	</td>
                                <td v-for="item in approval_plots_ajax">@{{ item.lat }}</td>
                            </tr>
                            <tr>
                                <td>Восточная долгота</td>
                                <td v-for="item in approval_plots_ajax">@{{ item.long }}</td>
                            </tr>
                            <tr>
                                <td>Общие запасы, тыс.м³	</td>
                                <td v-for="item in approval_plots_ajax">@{{ item.total_reserves }}</td>
                            </tr>
                            <tr>
                                <td>Категория А, В, С	</td>
                                <td v-for="item in approval_plots_ajax">@{{ item.category_abc }}</td>
                            </tr>
                            <tr>
                                <td>Орган, утвердивший запасы	</td>
                                <td v-for="item in approval_plots_ajax">@{{ item.stock_a_authority }}</td>
                            </tr>
                            <tr>
                                <td>Протокол утверждения	</td>
                                <td v-for="item in approval_plots_ajax">@{{ item.approval_protocol }}</td>
                            </tr>
                            <tr>
                                <td>Дата утверждения	</td>
                                <td v-for="item in approval_plots_ajax">@{{ item.approval_date }}</td>
                            </tr>
                            <tr>
                                <td>Объем воды	</td>
                                <td v-for="item in approval_plots_ajax">@{{ item.water_volume }}</td>
                            </tr>
                            <tr>
                                <td>Примечание</td>
                                <td v-for="item in approval_plots_ajax">@{{ item.comment }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="arc1PopUp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><b>Водозаборы</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding: 0!important;">
                        <table class="table table-bordered">
                            <thead class="thead-dark" >
                            <tr>
                                <th>Параметры</th>
                                <th v-for="(item, index) in arc1_ajax">@{{ item.year }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Кадастровый номер</td>
                                <td v-for="item in arc1_ajax">@{{ item.code }}</td>
                            </tr>
                            <tr>
                                <td>Название водозабора</td>
                                <td v-for="item in arc1_ajax">@{{ item.name }}</td>
                            </tr>
{{--                            <tr>--}}
{{--                                <td>Вид использования воды</td>--}}
{{--                                <td v-for="item in approval_plots_ajax" v-if="item.type_water_use.name">@{{ item.type_water_use.name }}</td>--}}
{{--                            </tr>--}}
                            <tr>
                                <td>Местоположение</td>
                                <td v-for="item in arc1_ajax">@{{ item.location }}</td>
                            </tr>
                            <tr>
                                <td>Северная широта	</td>
                                <td v-for="item in arc1_ajax">@{{ item.lat }}</td>
                            </tr>
                            <tr>
                                <td>Восточная долгота</td>
                                <td v-for="item in arc1_ajax">@{{ item.long }}</td>
                            </tr>
                            <tr>
                                <td>Общие запасы, м³	</td>
                                <td v-for="item in arc1_ajax">@{{ item.total_reserves }}</td>
                            </tr>
                            <tr>
                                <td>Орган, утвердивший запасы</td>
                                <td v-for="item in arc1_ajax">@{{ item.stock_a_authority }}</td>
                            </tr>
                            <tr>
                                <td>Год строительства	</td>
                                <td v-for="item in arc1_ajax">@{{ item.year_construction }}</td>
                            </tr>
                            <tr>
                                <td>Дата утверждения</td>
                                <td v-for="item in arc1_ajax">@{{ item.approval_date }}</td>
                            </tr>
                            <tr>
                                <td>Кол-во скважин	</td>
                                <td v-for="item in arc1_ajax">@{{ item.number_wells }}</td>
                            </tr>
                            <tr>
                                <td>Кол-во действующих скважин	</td>
                                <td v-for="item in arc1_ajax">@{{ item.number_active_wells }}</td>
                            </tr>
                            <tr>
                                <td>Объем полученной воды, м³ сут	</td>
                                <td v-for="item in arc1_ajax">@{{ item.amount_water_received }}</td>
                            </tr>
                            <tr>
                                <td>Качество полученной воды, г/л	</td>
                                <td v-for="item in arc1_ajax">@{{ item.water_quality }}</td>
                            </tr>
                            <tr>
                                <td>Примечание</td>
                                <td v-for="(item, index) in arc1_ajax">@{{ item.comment }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="bindPupUp4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><b>Канал</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding: 0!important;">
                        <table class="table table-bordered">
                            <thead class="thead-dark" >
                            <tr>
                                <th>Параметры</th>
                                <th v-for="(item, index) in canal_ajax">@{{ item.year }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Кадастер рақами</td>
                                <td v-for="item in canal_ajax">@{{ item.code }}</td>
                            </tr>
                            <tr>
                                <td>Номи</td>
                                <td v-for="(item, index) in canal_ajax">@{{ item.canal_name }}</td>
                            </tr>
                            <tr>
                                <td >Местоположение</td>
                                <td v-for="(item, index) in canal_ajax">@{{ item.location }}</td>
                            </tr>
                            <tr>
                                <td>Источник воды</td>
                                <td v-for="(item, index) in canal_ajax">@{{ item.water_source }}</td>
                            </tr>
                            <tr>
                                <td>Класс капитализации</td>
                                <td v-for="(item, index) in canal_ajax">@{{ item.class_capital.name }}</td>
                            </tr>
                            <tr>
                                <td>Основная функция</td>
                                <td v-for="(item, index) in canal_ajax">@{{ item.functions.name }}</td>
                            </tr>
                            <tr>
                                <td>Максимальный расход воды (м3/с)</td>
                                <td v-for="(item, index) in canal_ajax">@{{ item.max_wateruse }}</td>
                            </tr>
                            <tr>
                                <td>Покрытие 1-типа</td>
                                <td v-for="(item, index) in canal_ajax">@{{ item.cover_type_1.name }}</td>
                            </tr>
                            <tr>
                                <td>Длина покрытия 2-типа (км)</td>
                                <td v-for="(item, index) in canal_ajax">@{{ item.ctype1_len }}</td>
                            </tr>
                            <tr>
                                <td>Покрытие 2-типа</td>
                                <td v-for="(item, index) in canal_ajax">@{{ item.cover_type_2.name }}</td>
                            </tr>
                            <tr>
                                <td>Длина покрытия 2-типа (км)</td>
                                <td v-for="(item, index) in canal_ajax">@{{ item.ctype2_len }}</td>
                            </tr>
                            <tr>
                                <td>Общая длина канала (км)</td>
                                <td v-for="(item, index) in canal_ajax">@{{ item.total_length }}</td>
                            </tr>
                            <tr>
                                <td>Количество сооружений (шт)</td>
                                <td v-for="(item, index) in canal_ajax">@{{ item.facilities_n }}</td>
                            </tr>
                            <tr>
                                <td>Площадь орошения (тыс. га)</td>
                                <td v-for="item in canal_ajax">@{{ item.irrigation_area }}</td>
                            </tr>
                            <tr>
                                <td>Дата начало эксплуатации</td>
                                <td v-for="(item, index) in canal_ajax">@{{ item.launch_date }}</td>
                            </tr>
                            <tr>
                                <td>Пользователь - организация</td>
                                <td v-for="(item, index) in canal_ajax">@{{ item.wateruser_orgs }}</td>
                            </tr>
                            <tr>
                                <td>Балансовый стоимость (тыс.сум)</td>
                                <td v-for="(item, index) in canal_ajax">@{{ item.bookvalue }}</td>
                            </tr>
                            <tr>
                                <td>Примечание</td>
                                <td v-for="(item, index) in canal_ajax">@{{ item.comment }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalPumpStation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><b>НАСОСНАЯ СТАНЦИЯ</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding: 0!important;">
                        <table class="table table-bordered">
                            <thead class="thead-dark" >
                            <tr>
                                <th>Параметры</th>
                                <th v-for="(item, index) in pump_station_ajax">@{{ item.year }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Кадастровый номер</td>
                                <td v-for="item in pump_station_ajax">@{{ item.code }}</td>
                            </tr>
                            <tr>
                                <td>Название</td>
                                <td v-for="(item, index) in pump_station_ajax">@{{ item.name }}</td>
                            </tr>
                            <tr>
                                <td>Местоположение</td>
                                <td v-for="(item, index) in pump_station_ajax">@{{ item.location }}</td>
                            </tr>
                            <tr>
                                <td>Источник воды</td>
                                <td v-for="(item, index) in pump_station_ajax">@{{ item.water_source }}</td>
                            </tr>
                            <tr>
                                <td>Класс капитализации</td>
                                <td v-for="(item, index) in pump_station_ajax">@{{ item.class.name }}</td>
                            </tr>
                            <tr>
                                <td>Основная функция</td>
                                <td v-for="(item, index) in pump_station_ajax">@{{ item.function.name }}</td>
                            </tr>
                            <tr>
                                <td>Максимальный расход воды (м3/с)	</td>
                                <td v-for="(item, index) in pump_station_ajax">@{{ item.max_wateruse }}</td>
                            </tr>
                            <tr>
                                <td>Высота подъема (м)	</td>
                                <td v-for="(item, index) in pump_station_ajax">@{{ item.lift_height }}</td>
                            </tr>
                            <tr>
                                <td>Количество агрегатов (шт)</td>
                                <td v-for="(item, index) in pump_station_ajax">@{{ item.aggregates_n }}</td>
                            </tr>
                            <tr>
                                <td>Установленная мощность (кВт)</td>
                                <td v-for="(item, index) in pump_station_ajax">@{{ item.capacity }}</td>
                            </tr>
                            <tr>
                                <td>Дата начало эксплуатации</td>
                                <td v-for="(item, index) in pump_station_ajax">@{{ item.launch_date }}</td>
                            </tr>
                            <tr>
                                <td>Пользователь - организация	</td>
                                <td v-for="(item, index) in pump_station_ajax">@{{ item.wateruser_orgs }}</td>
                            </tr>
                            <tr>
                                <td>Балансовый стоимость (тыс.сум)	</td>
                                <td v-for="(item, index) in pump_station_ajax">@{{ item.book_value }}</td>
                            </tr>
                            <tr>
                                <td>Примечание</td>
                                <td v-for="(item, index) in pump_station_ajax">@{{ item.comment }}</td>
                            </tr>

                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalReservoirs" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><b>ВОДОХРАНИЛИЩЕ</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding: 0!important;">
                        <table class="table table-bordered">
                            <thead class="thead-dark" >
                            <tr>
                                <th>Параметры</th>
                                <th v-for="(item, index) in reservoirs_ajax">@{{ item.year }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Кадастер рақами</td>
                                <td v-for="item in reservoirs_ajax">@{{ item.code }}</td>
                            </tr>
                            <tr>
                                <td>Номи</td>
                                <td v-for="(item, index) in reservoirs_ajax">@{{ item.name }}</td>
                            </tr>
                            <tr>
                                <td>Русло реки	</td>
                                <td v-for="(item, index) in reservoirs_ajax">@{{ item.waterbodies.name }}</td>
                            </tr>
                            <tr>
                                <td>Местоположение</td>
                                <td v-for="(item, index) in reservoirs_ajax">@{{ item.location }}</td>
                            </tr>
                            <tr>
                                <td>Источник воды	</td>
                                <td v-for="(item, index) in reservoirs_ajax">@{{ item.water_source }}</td>
                            </tr>
                            <tr>
                                <td>Метод управления водой</td>
                                <td v-for="(item, index) in reservoirs_ajax">@{{ item.manipulation_type.name }}</td>
                            </tr>
                            <tr>
                                <td>Тип водохранилища</td>
                                <td v-for="(item, index) in reservoirs_ajax">@{{ item.reservoirs_type.name }}</td>
                            </tr>
                            <tr>
                                <td>Функция в/х	</td>
                                <td v-for="(item, index) in reservoirs_ajax">@{{ item.reservoirs_function.name }}</td>
                            </tr>
                            <tr>
                                <td>Водопользователи</td>
                                <td v-for="(item, index) in reservoirs_ajax">@{{ item.water_users }}</td>
                            </tr>
                            <tr>
                                <td>Тип плотины	</td>
                                <td v-for="(item, index) in reservoirs_ajax">@{{ item.class_capital.name }}</td>
                            </tr>
                            <tr>
                                <td>Класс капитализации	</td>
                                <td v-for="(item, index) in reservoirs_ajax">@{{ item.dam_type.name }}</td>
                            </tr>
                            <tr>
                                <td>Максимальная высота плотины (м)	</td>
                                <td v-for="(item, index) in reservoirs_ajax">@{{ item.dam_max_height }}</td>
                            </tr>
                            <tr>
                                <td>Занимаемая площадь, км2	(м)	</td>
                                <td v-for="(item, index) in reservoirs_ajax">@{{ item.total_area }}</td>
                            </tr>
                            <tr>
                                <td>Объем в/х (млн. м3)	</td>
                                <td v-for="(item, index) in reservoirs_ajax">@{{ item.total_volume }}</td>
                            </tr>
                            <tr>
                                <td>Объем на I кв (млн. м3)</td>
                                <td v-for="(item, index) in reservoirs_ajax">@{{ item.volume_q1 }}</td>
                            </tr>
                            <tr>
                                <td>Объем на II кв (млн. м3)	</td>
                                <td v-for="(item, index) in reservoirs_ajax">@{{ item.volume_q2 }}</td>
                            </tr>
                            <tr>
                                <td>Объем на III кв (млн. м3)	</td>
                                <td v-for="(item, index) in reservoirs_ajax">@{{ item.volume_q3 }}</td>
                            </tr>
                            <tr>
                                <td>Объем на IV кв (млн. м3)	</td>
                                <td v-for="(item, index) in reservoirs_ajax">@{{ item.volume_q4 }}</td>
                            </tr>
                            <tr>
                                <td>Максимальный расход ниже плотины (м3/с)	</td>
                                <td v-for="(item, index) in reservoirs_ajax">@{{ item.maxflow_below_dam }}</td>
                            </tr>
                            <tr>
                                <td>Дата начало эксплуатации</td>
                                <td v-for="(item, index) in reservoirs_ajax">@{{ item.launch_date }}</td>
                            </tr>
                            <tr>
                                <td>Пользователь - организация</td>
                                <td v-for="(item, index) in reservoirs_ajax">@{{ item.wateruser_orgs }}</td>
                            </tr>
                            <tr>
                                <td>Балансовый стоимость (тыс.сум)	</td>
                                <td v-for="(item, index) in reservoirs_ajax">@{{ item.book_value }}</td>
                            </tr>
                            <tr>
                                <td>Примечание</td>
                                <td v-for="(item, index) in reservoirs_ajax">@{{ item.comment }}</td>
                            </tr>


                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalCollector" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><b>КОЛЛЕКТОР</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding: 0!important;">
                        <table class="table table-bordered">
                            <thead class="thead-dark" >
                            <tr>
                                <th>Параметры</th>
                                <th v-for="(item, index) in collectors_ajax">@{{ item.year }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Кадастровый номер	</td>
                                <td v-for="item in collectors_ajax">@{{ item.code }}</td>
                            </tr>
                            <tr>
                                <td>Название</td>
                                <td v-for="(item, index) in collectors_ajax">@{{ item.name }}</td>
                            </tr>
                            <tr>
                                <td>Северная широта	</td>
                                <td v-for="(item, index) in collectors_ajax">@{{ item.lat }}</td>
                            </tr>
                            <tr>
                                <td>Восточная долгота</td>
                                <td v-for="(item, index) in collectors_ajax">@{{ item.long }}</td>
                            </tr>
                            <tr>
                                <td>Источник воды</td>
                                <td v-for="(item, index) in collectors_ajax">@{{ item.water_source }}</td>
                            </tr>
                            <tr>
                                <td>Основная функция</td>
                                <td v-for="(item, index) in collectors_ajax">@{{ item.collector_functions.name }}</td>
                            </tr>
                            <tr>
                                <td>Максимальный расход воды в конце коллектора (м3/с)	</td>
                                <td v-for="(item, index) in collectors_ajax">@{{ item.max_wateruse }}</td>
                            </tr>
                            <tr>
                                <td>Длина (км)</td>
                                <td v-for="(item, index) in collectors_ajax">@{{ item.length }}</td>
                            </tr>
                            <tr>
                                <td>Длина (км)</td>
                                <td v-for="(item, index) in collectors_ajax">@{{ item.length }}</td>
                            </tr>
                            <tr>
                                <td>Дата начало эксплуатации</td>
                                <td v-for="(item, index) in collectors_ajax">@{{ item.launch_date }}</td>
                            </tr>
                            <tr>
                                <td>Пользователь - организация</td>
                                <td v-for="(item, index) in collectors_ajax">@{{ item.wateruser_orgs }}</td>
                            </tr>
                            <tr>
                                <td>Балансовый стоимость (тыс.сум)	</td>
                                <td v-for="(item, index) in collectors_ajax">@{{ item.book_value }}</td>
                            </tr>
                            <tr>
                                <td>Примечание</td>
                                <td v-for="(item, index) in collectors_ajax">@{{ item.comment }}</td>
                            </tr>


                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modalWaterwork" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"><b>Гидроузел</b></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding: 0!important;">
                        <table class="table table-bordered">
                            <thead class="thead-dark" >
                            <tr>
                                <th>Параметры</th>
                                <th v-for="(item, index) in waterwork_ajax">@{{ item.year }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Кадастровый номер</td>
                                <td v-for="item in waterwork_ajax">@{{ item.code }}</td>
                            </tr>
                            <tr>
                                <td>Название</td>
                                <td v-for="(item, index) in waterwork_ajax">@{{ item.name }}</td>
                            </tr>
                            <tr>
                                <td>Русло реки</td>
                                <td v-for="(item, index) in waterwork_ajax">@{{ item.waterbodies.name }}</td>
                            </tr>
                            <tr>
                                <td>Местоположение	</td>
                                <td v-for="(item, index) in waterwork_ajax">@{{ item.location }}</td>
                            </tr>
                            <tr>
                                <td>Источник воды</td>
                                <td v-for="(item, index) in waterwork_ajax">@{{ item.water_source }}</td>
                            </tr>
                            <tr>
                                <td>Функция</td>
                                <td v-for="(item, index) in waterwork_ajax">@{{ item.waterwork_func.name }}</td>
                            </tr>
                            <tr>
                                <td>Водопользователи</td>
                                <td v-for="(item, index) in waterwork_ajax">@{{ item.water_users }}</td>
                            </tr>
                            <tr>
                                <td>Класс капитализации	</td>
                                <td v-for="(item, index) in waterwork_ajax">@{{ item.class_capital.name }}</td>
                            </tr>
                            <tr>
                                <td>Тип гидроузела	</td>
                                <td v-for="(item, index) in waterwork_ajax">@{{ item.water_work_type.name }}</td>
                            </tr>
                            <tr>
                                <td>Максимальная высота плотины (м)	</td>
                                <td v-for="(item, index) in waterwork_ajax">@{{ item.dam_max_height }}</td>
                            </tr>
                            <tr>
                                <td>Пропускной способность (м3/с)</td>
                                <td v-for="(item, index) in waterwork_ajax">@{{ item.throughput_capacity }}</td>
                            </tr>
                            <tr>
                                <td>Дата начало эксплуатации</td>
                                <td v-for="(item, index) in waterwork_ajax">@{{ item.launch_date }}</td>
                            </tr>
                            <tr>
                                <td>Пользователь - организация</td>
                                <td v-for="(item, index) in waterwork_ajax">@{{ item.wateruser_orgs }}</td>
                            </tr>
                            <tr>
                                <td>Балансовый стоимость (тыс.сум)	</td>
                                <td v-for="(item, index) in waterwork_ajax">@{{ item.book_value }}</td>
                            </tr>
                            <tr>
                                <td>Примечание</td>
                                <td v-for="(item, index) in waterwork_ajax">@{{ item.comment }}</td>
                            </tr>


                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                    </div>
                </div>
            </div>
        </div>











        <div class="container-fluid">
            <div class="row">
                <!-- there will be a map -->
                <div id="mapid" style="width: 75%; height: auto; margin: 0 auto"></div>

                <div  v-show="isShow" class="col-3 bg-light text-primary py-3">
                    <p class="small">Наименования водного объекта</p>
                    <input type="text" v-model="input_value" id="input_element" class="form-control form-control-sm" />
                    <!-- accordion -->
                    <div class="accordion mt-3" id="accordionExample">
                        <div class="card">
                            <div class="card-header p-0" id="headingOne">
                                <button onclick="togglePlusMinus(event)" class="p-2 btn btn-block btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    <span class="float-left small">Типы водных объектов</span><span class="float-right  "><i class="fas fa-minus"></i></span>
                                </button>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="">
                                <div class="card-body">
                                    <p class="bold">Минводхоз</p>

                                    <div class="form-check mb-2">
                                        <input class="form-check-input" v-model="canals" type="checkbox"  id="defaultMapCheck1">
                                        <label class="form-check-label small" for="defaultMapCheck1">Каналы</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" v-model="pump_station"  id="defaultMapCheck3">
                                        <label class="form-check-label small"  for="defaultMapCheck3">Насосные станции</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox"  v-model="reservoirs"   id="defaultMapCheck4">
                                        <label class="form-check-label small" for="defaultMapCheck4">Водохранилища</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" v-model="waterwork"   id="defaultMapCheck5">
                                        <label class="form-check-label small"  for="defaultMapCheck5">Гидроузели</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" v-model="collector"  id="defaultMapCheck7">
                                        <label class="form-check-label small"  for="defaultMapCheck7">Коллекторы</label>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <p class="bold">Гидрогеология</p>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" v-model="birth_regions" type="checkbox" id="defaultMapCheck8">
                                        <label class="form-check-label small" for="defaultMapCheck8">Месторождения</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" v-model="approval_plots"  id="defaultMapCheck9">
                                        <label class="form-check-label small"  for="defaultMapCheck9">Утверж. участки</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox"  v-model="mountain_ranges"   id="defaultMapCheck10">
                                        <label class="form-check-label small" for="defaultMapCheck10">Горные массивы</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox"  v-model="wells"   id="defaultMapCheck11">
                                        <label class="form-check-label small" for="defaultMapCheck11">Скважины</label>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox"  v-model="acr1"   id="defaultMapCheck12">
                                        <label class="form-check-label small2" for="defaultMapCheck12">Водозаборы</label>
                                    </div>

                                </div>
                                <div class="card-body">
                                    <p class="bold">Гидромет</p>

                                    <div class="form-check mb-2">
                                        <input class="form-check-input" v-model="stations_m" type="checkbox" id="defaultMapCheck13">
                                        <label class="form-check-label small" for="defaultMapCheck13">Гидро постов</label>
                                    </div>
                                    {{--                                    <div class="form-check mb-2">--}}
                                    {{--                                        <input class="form-check-input" type="checkbox" v-model="waterbodies_m"  id="defaultMapCheck3">--}}
                                    {{--                                        <label class="form-check-label small"  for="defaultMapCheck3">Природные водные объекты</label>--}}
                                    {{--                                    </div>--}}
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header p-0" id="headingThree">
                                <button onclick="togglePlusMinus(event)" class="p-2 btn btn-block btn-link collapsed" data-toggle="collapse" data-target="#collapseThree2" aria-expanded="true" aria-controls="collapseThree">
                                    <span class="float-left small">Представление данных</span><span class="float-right"><i class="fas fa-minus"></i></span>
                                </button>
                            </div>
                            <div id="collapseThree2" class="collapse show" aria-labelledby="headingOne" >
                                <div class="card-body">
                                    <form>
                                        <div class="form-row">
                                            <select disabled class="custom-select custom-select-sm mb-2 col-12">
                                                <option selected value="1">Паспортные данные</option>
                                                <option value="2">Two</option>
                                                <option value="3">Three</option>
                                            </select>
                                            <div class="form-group">
                                                <input class="form-control" type="number" v-model="year_star">
                                                <input class="form-control" type="number" v-model="year_finish">
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
{{--                        <div class="card">--}}
{{--                            <div class="card-header p-0" id="headingTwo">--}}
{{--                                <button onclick="togglePlusMinus(event)" class="p-2 btn btn-block btn-link" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">--}}
{{--                                    <span class="float-left small">Параметры</span><span class="float-right"><i class="fas fa-minus"></i></span>--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                            <div id="collapseTwo" class="collapse show" aria-labelledby="headingOne" data-parent="">--}}
{{--                                <div class="card-body">--}}
{{--                                    <select class="custom-select custom-select-sm mb-2">--}}
{{--                                        <option selected>Объем использования воды</option>--}}
{{--                                        <option value="1">One</option>--}}
{{--                                        <option value="2">Two</option>--}}
{{--                                        <option value="3">Three</option>--}}
{{--                                    </select>--}}
{{--                                    <select class="custom-select custom-select-sm mb-2">--}}
{{--                                        <option selected>></option>--}}
{{--                                        <option value="1">One</option>--}}
{{--                                        <option value="2">Two</option>--}}
{{--                                        <option value="3">Three</option>--}}
{{--                                    </select>--}}
{{--                                    <input class="form-control form-control-sm mb-2" type="text" name="" value="" placeholder="20 млн м3/с">--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="card">--}}
{{--                            <div class="card-header p-0" id="headingThree">--}}
{{--                                <button onclick="togglePlusMinus(event)" class="p-2 btn btn-block btn-link" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">--}}
{{--                                    <span class="float-left small">Представление данных</span><span class="float-right"><i class="fas fa-minus"></i></span>--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                            <div id="collapseThree" class="collapse show" aria-labelledby="headingOne" data-parent="">--}}
{{--                                <div class="card-body">--}}
{{--                                    <form>--}}
{{--                                        <div class="form-row">--}}
{{--                                            <select class="custom-select custom-select-sm mb-2 col-12">--}}
{{--                                                <option value="1">Ежегодные</option>--}}
{{--                                                <option value="2">Two</option>--}}
{{--                                                <option value="3">Three</option>--}}
{{--                                            </select>--}}
{{--                                            <select class="custom-select custom-select-sm mb-2 col-6">--}}
{{--                                                <option value="1">2010</option>--}}
{{--                                                <option value="2">2011</option>--}}
{{--                                                <option value="3">2012</option>--}}
{{--                                            </select>--}}
{{--                                            <select class="custom-select custom-select-sm mb-2 col-6">--}}
{{--                                                <option value="1">2019</option>--}}
{{--                                                <option value="2">2018</option>--}}
{{--                                                <option value="3">2017</option>--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="card">--}}
{{--                            <div class="card-header p-0" id="headingFour">--}}
{{--                                <button onclick="togglePlusMinus(event)" class="p-2 btn btn-block btn-link" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">--}}
{{--                                    <span class="float-left small">Области</span><span class="float-right"><i class="fas fa-minus"></i></span>--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                            <div id="collapseFour" class="collapse show" aria-labelledby="headingFour" data-parent="">--}}
{{--                                <div class="card-body">--}}
{{--                                    <form>--}}
{{--                                        <div class="form-row">--}}
{{--                                            <select class="custom-select custom-select-sm mb-2 col-12" v-model="regions" @change="getDistrict" >--}}
{{--                                                @foreach($uz_regions as $uz_region)--}}
{{--                                                    <option value="{{$uz_region->regionid}}">{{$uz_region->nameUz}}</option>--}}
{{--                                                @endforeach--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="card">--}}
{{--                            <div class="card-header p-0" id="headingFive">--}}
{{--                                <button onclick="togglePlusMinus(event)" class="p-2 btn btn-block btn-link" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">--}}
{{--                                    <span class="float-left small">Районы</span><span class="float-right"><i class="fas fa-minus"></i></span>--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                            <div id="collapseFive" class="collapse show" aria-labelledby="headingOne" data-parent="">--}}
{{--                                <div class="card-body">--}}
{{--                                    <form>--}}
{{--                                        <div class="form-row">--}}
{{--                                            <select class="custom-select custom-select-sm mb-2 col-12" v-model="selectedDistricts" name="districts[]">--}}
{{--                                                <option    v-for="item in districts" :value="item.areaid">@{{ item.nameUz }}</option>--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </form>                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <form class="form-group text-center mt-3">
                            <button class="btn btn-primary btn-sm" @keypress.enter="search" @click="search" type="button" name="button"><i class="fas fa-glass-martini-alt"></i> Применять</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>


@endsection

@section('scripts')
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="{{asset('js/leaflet.js')}}"
            integrity=""
            crossorigin="">


    </script>
    <script src="{{asset('js/KML.js')}}"></script>
    <script src="{{asset('js/leaflet.textpath.js')}}" ></script>
    <script src="{{asset('js/leaflet-svg-shape-markers.min.js')}}"></script>


    <script>



        // mymap.on('click', onMapClick);



    </script>

    <script>
        var results = [];
        var map = '';
        var all_regions = '';
        let main = new Vue({
            el:'#main',
            data:{
                regions:[],
                districts:[],
                selectedDistricts:[],
                name:'',
                canals:'',
                pump_station:'',
                reservoirs:'',
                waterwork:'',
                collector:'',
                mymap:'',
                greenIcon:'',
                markee:'',
                canal_map:[],
                canal_map_all:[],
                polygonPoints:[],
                canals_el:'',
                canals_el_one:'',
                waterworks_el:'',
                collectors_el:'',
                collectorPoints:'',
                pumpstation_el:'',
                pumpstation_el_one:'',
                reservoirs_el_one:'',
                group:[],
                canal_data:[],
                class_capital:'',
                canal_function:'',
                isShow:true,
                cover_type_1:'',
                cover_type_2:'',
                input_value:'',
                pump_station_map:[],
                reservoirs_map:[],
                waterbodies:'',
                manipulation_type:'',
                reservoirs_type:'',
                dam_type:'',
                canal_el_properties:[],
                waterwork_map:[],
                waterwork_type:'',
                collector_map:[],
                mountain_ranges:'',
                birth_regions:'',
                approval_plots:'',
                wells:'',
                canal_ajax:[],
                approval_plots_ajax:[],
                mountain_ranges_ajax:[],
                wells_ajax:[],
                year_star:'{{\Carbon\Carbon::now()->subYear()->year}}',
                year_finish:'{{\Carbon\Carbon::now()->year}}',
                acr1:'',
                arc2:'',
                arc3:'',
                arc4:'',
                arc5:'',
                arc6:'',
                arc7:'',
                arc1_ajax:'',
                stations_m:'',
                pump_station_ajax : '',
                reservoirs_ajax:'',
                collectors_ajax:'',
                waterwork_ajax:'',

            },
            methods:{
                InitialMap:function () {

                    map =   L.map('mapid').setView([41.315514, 69.246097], 13);
                    map.createPane("pane250").style.zIndex = 400; // z-index for points
                    map.createPane("pane200").style.zIndex = 200; // z-index for  polygons


                    var kmlLayer = new L.KML("{{asset('js/--1984.KML')}}", { async: false });
                    map.addLayer(kmlLayer);

                    var osmUrl = 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
                        osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> маълумотлари',
                        osm = L.tileLayer(osmUrl, { maxZoom: 18, attribution: osmAttrib, scale: true,edit: false
                        }),
                        drawnItems = L.featureGroup().addTo(map);
                    L.control.scale({
                        imperial: true
                    }).addTo(map);
                    L.control.layers({
                        'OpenStreetMap': osm.addTo(map),
                        "Google харита": L.tileLayer('http://www.google.cn/maps/vt?lyrs=s@189&gl=cn&x={x}&y={y}&z={z}', {
                            attribution: 'google'
                        })
                    }, { 'Қатлам чизиш': drawnItems }, { position: 'topleft', collapsed: false }).addTo(map);
                    map.attributionControl.setPrefix(''); // Don't show the 'Powered by Leaflet' text.


                    map.on('moveend', function(e) {

                        map.eachLayer(function(layer) {
                            if(layer.options.pane === "tooltipPane") layer.removeFrom(map);
                        });

                        for(i in map._layers) {
                            if(map._layers[i]._path != undefined) {

                                try {
                                    map.removeLayer(map._layers[i]);
                                }
                                catch(e) {
                                    console.log("problem with " + e + map._layers[i]);
                                }


                            }
                        }

                        var kmlLayer = new L.KML("{{asset('js/--1984.KML')}}", { async: false });
                        map.addLayer(kmlLayer);
                        let map_bounds = map.getBounds();

                        let north_east_x = map_bounds._northEast.lat;
                        let north_east_y = map_bounds._northEast.lng;
                        let south_west_x = map_bounds._southWest.lat;
                        let south_west_y = map_bounds._southWest.lng;

                        if(main.approval_plots)
                            main.getAllObjects('approval_plots',north_east_y,north_east_x,south_west_y,south_west_x);
                        if(main.wells)
                            main.getAllObjects('wells',north_east_y,north_east_x,south_west_y,south_west_x);
                        if(main.acr1)
                            main.getAllObjects('acr1',north_east_y,north_east_x,south_west_y,south_west_x);

                        if(main.birth_regions)
                            main.getAllObjects('birth_regions',north_east_y,north_east_x,south_west_y,south_west_x);
                        if(main.mountain_ranges)
                            main.getAllObjects('mountain_ranges',north_east_y,north_east_x,south_west_y,south_west_x);
                        if(main.canals)
                            main.getAllObjects('canals',north_east_y,north_east_x,south_west_y,south_west_x);
                        if(main.pump_station)
                            main.getAllObjects('pump_station',north_east_y,north_east_x,south_west_y,south_west_x);
                        if(main.reservoirs)
                            main.getAllObjects('reservoirs',north_east_y,north_east_x,south_west_y,south_west_x);
                        if(main.waterwork)
                            main.getAllObjects('waterwork',north_east_y,north_east_x,south_west_y,south_west_x);
                        if(main.collector)
                            main.getAllObjects('collector',north_east_y,north_east_x,south_west_y,south_west_x);



                    });


                    // axios.get('http://83.221.160.76:6080/arcgis/rest/services/Service1/MapServer/3/query', {
                    //     params: {
                    //         where: "'FID'<>''",
                    //         outFields:'*',
                    //         outSR:4326,
                    //         f:'geojson',
                    //
                    //
                    //     }
                    // })
                    //     .then(function (response) {
                    //
                    //
                    //         all_regions = L.geoJson(response.data, {
                    //
                    //
                    //
                    //
                    //             // style: function (feature) {
                    //             //     if(feature.properties.Кадастр_рақами == main.input_value)
                    //             //     {
                    //             //         return {
                    //             //             color: 'red',
                    //             //             weight: 4,
                    //             //             fillColor: '#9B9A9A',
                    //             //             fillOpacity: 0.7
                    //             //         }
                    //             //     }
                    //             //     else
                    //             //     {
                    //             //         return {
                    //             //             color: 'blue',
                    //             //             weight: 4,
                    //             //             fillColor: '#9B9A9A',
                    //             //             fillOpacity: 0.7
                    //             //         }
                    //             //     }
                    //             //
                    //             // },
                    //
                    //             // onEachFeature: function (feature, layer) {
                    //             //     if(map.getZoom() >= 13)
                    //             //     {
                    //             //         layer.setText(feature.properties.Канал_номи, {
                    //             //             repeat: false, center: true,
                    //             //             offset: 10,
                    //             //             attributes: {
                    //             //                 fill: '#FF363A',
                    //             //                 'font-weight': 'bold',
                    //             //                 'font-size': '12'
                    //             //             }
                    //             //         });
                    //             //     }
                    //             //     else {
                    //             //         layer.setText('', {
                    //             //             repeat: false, center: true,
                    //             //             offset: 10,
                    //             //             attributes: {
                    //             //                 fill: '#FF363A',
                    //             //                 'font-weight': 'bold',
                    //             //                 'font-size': '12'
                    //             //             }
                    //             //         });
                    //             //     }
                    //             //
                    //             // }
                    //
                    //
                    //         }).addTo(map);
                    //
                    //
                    //     })
                    //     .catch(function (error) {
                    //         console.log(error);
                    //     })
                    //     .then(function () {
                    //         // always executed
                    //     });


                },
                getDistrict:function(){
                    let theVue = this;
                    _this = this;
                    axios.get('{{route('wb.getdistricts')}}', {
                        params: {
                            regions: _this.regions
                        }
                    })
                        .then(function (response) {
                            // handle success

                            _this.districts = response.data;
                            theVue.$nextTick(function(){ $('.selectpicker').selectpicker('refresh'); });
                        })
                        .catch(function (error) {
                            // handle error
                            console.log(error);
                        })

                },
                search:function () {


                    if(main.approval_plots == true && main.input_value != '')
                    {
                        main.getOneObjectRest('approval_plots',main.input_value);
                    }
                    if(main.birth_regions == true && main.input_value != '')
                    {
                        main.getOneObjectRest('birth_regions',main.input_value);

                    }
                    if(main.mountain_ranges == true && main.input_value != '')
                    {
                        main.getOneObjectRest('mountain_ranges',main.input_value);
                    }
                    if(main.wells == true && main.input_value != '')
                    {
                        main.getOneObjectRest('wells',main.input_value);
                    }
                    if(main.acr1 == true && main.input_value != '')
                    {
                        main.getOneObjectRest('acr1',main.input_value);
                    }
                    if(main.arc2 == true && main.input_value != '')
                    {
                        main.getOneObjectRest('arc2',main.input_value);
                    }
                    if(main.arc3 == true && main.input_value != '')
                    {
                        main.getOneObjectRest('arc3',main.input_value);
                    }
                    if(main.arc4 == true && main.input_value != '')
                    {
                        main.getOneObjectRest('arc4',main.input_value);
                    }
                    if(main.arc5 == true && main.input_value != '')
                    {
                        main.getOneObjectRest('arc5',main.input_value);
                    }
                    if(main.arc6 == true && main.input_value != '')
                    {
                        main.getOneObjectRest('arc6',main.input_value);
                    }
                    if(main.arc7 == true && main.input_value != '')
                    {
                        main.getOneObjectRest('arc7',main.input_value);
                    }


                },
                onEachFeature:function (feature, layer) {
                    main.canals_el.on({
                        click: main.clickCanal
                    });
                },
                getAllObjects:function (param,n_x,n_y,w_x,w_y) {
                    if(param == 'approval_plots')
                    {
                        axios.get('http://83.221.160.76:6080/arcgis/rest/services/GVKWebservice/MapServer/1/query', {
                            params: {
                                where: '',
                                text: '',
                                objectIds:'',
                                time:'',
                                geometry:{
                                    XMin:w_x,
                                    YMin:w_y,
                                    XMax:n_x,
                                    YMax:n_y
                                },
                                geometryType:'esriGeometryEnvelope',
                                inSR:4326,
                                spatialRel:'esriSpatialRelEnvelopeIntersects',
                                outFields:'*',
                                outSR:4326,
                                f:'geojson',


                            }
                        })
                            .then(function (response) {
                                // for(i in map._layers) {
                                //     if(map._layers[i]._path != undefined) {
                                //
                                //         try {
                                //             map.removeLayer(map._layers[i]);
                                //         }
                                //         catch(e) {
                                //             console.log("problem with " + e + map._layers[i]);
                                //         }
                                //
                                //
                                //     }
                                // }

                                geoojson = L.geoJson(response.data, {

                                    pane: "pane200",

                                    pointToLayer: function(feature, latlng) {
                                        if(map.getZoom() >= 11)
                                        {
                                            var name_of_obj = feature.properties.id_raqam;
                                            var square = L.shapeMarker(latlng, {
                                                shape: "circle",
                                                radius: 4,
                                                fillOpacity:0.7,
                                                color:'#9e0000',
                                                pane: "pane250",

                                            }).bindTooltip(feature.properties.id_raqam.toString(),{  permanent: true,direction: 'right'}).addTo(map).on('click', function () {
                                                axios.get('{{route('gg.reestr.ap.edit')}}', {
                                                    params: {
                                                        code: feature.properties.id_raqam,
                                                        start: main.year_star,
                                                        finish: main.year_finish
                                                    }
                                                })
                                                    .then(function (response) {
                                                        if (response != null) {
                                                            main.approval_plots_ajax = response.data;
                                                            $('#ApprovalPlotsPopUp').modal('show');

                                                        }

                                                    }).catch(function (error) {
                                                    console.log(error);
                                                })
                                            });



                                        }
                                        else
                                        {
                                            var square = L.shapeMarker(latlng, {
                                                shape: "circle",
                                                radius: 4,
                                                fillOpacity:0.7,
                                                color:'#9e0000',
                                                pane: "pane250",

                                            }).addTo(map).on('click', function () {
                                                axios.get('{{route('gg.reestr.ap.edit')}}', {
                                                    params: {
                                                        code: feature.properties.id_raqam,
                                                        start: main.year_star,
                                                        finish: main.year_finish
                                                    }
                                                })
                                                    .then(function (response) {
                                                        if (response != null) {
                                                            main.approval_plots_ajax = response.data;
                                                            $('#ApprovalPlotsPopUp').modal('show');

                                                        }

                                                    }).catch(function (error) {
                                                    console.log(error);
                                                })
                                            });


                                        }

                                    }
                                }).addTo(map);


                                {{--geoojson.on('click', function (e) {--}}


                                {{--    axios.get('{{route('c.edit')}}', {--}}
                                {{--        params: {--}}
                                {{--            code: e.layer.feature.properties.Кадастр_рақами,--}}
                                {{--            start: main.year_star,--}}
                                {{--            finish: main.year_finish--}}
                                {{--        }--}}
                                {{--    })--}}
                                {{--        .then(function (response) {--}}
                                {{--            if (response != null) {--}}
                                {{--                // main.canal_ajax = response.data;--}}
                                {{--                // canal_ajax = response.data;--}}
                                {{--                // $('#bindPupUp').modal('show');--}}


                                {{--            }--}}

                                {{--        }).catch(function (error) {--}}
                                {{--        console.log(error);--}}
                                {{--    })--}}
                                {{--});--}}
                            })
                            .catch(function (error) {
                                console.log(error);
                            });

                    }
                    else if(param == 'birth_regions')
                    {
                        axios.get('http://83.221.160.76:6080/arcgis/rest/services/GVKWebservice/MapServer/3/query', {
                            params: {
                                where: '',
                                text: '',
                                objectIds:'',
                                time:'',
                                geometry:{
                                    XMin:w_x,
                                    YMin:w_y,
                                    XMax:n_x,
                                    YMax:n_y
                                },
                                geometryType:'esriGeometryEnvelope',
                                inSR:4326,
                                spatialRel:'esriSpatialRelEnvelopeIntersects',
                                outFields:'*',
                                outSR:4326,
                                returnIdsOnly:false,
                                returnCountOnly:false,
                                returnZ:false,
                                returnM:false,
                                returnDistinctValues:false,
                                returnExtentsOnly:false,
                                f:'geojson',


                            }
                        })
                            .then(function (response) {
                                // for(i in map._layers) {
                                //     if(map._layers[i]._path != undefined) {
                                //
                                //         try {
                                //             map.removeLayer(map._layers[i]);
                                //         }
                                //         catch(e) {
                                //             console.log("problem with " + e + map._layers[i]);
                                //         }
                                //
                                //
                                //     }
                                // }



                                geoojson = L.geoJson(response.data, {
                                    pane: "pane200",



                                    style: function (feature) {
                                        if(feature.properties.NAME == main.input_value || feature.properties.Kadastr_nu == main.input_value)
                                        {
                                            return {
                                                color: '#6e6e6e',
                                                weight: 2,
                                                fillColor: '#EF9A9A',
                                                fillOpacity: 0.7
                                            }
                                        }
                                        else
                                        {
                                            return {
                                                color: '#6e6e6e',
                                                weight: 2,
                                                fillColor: '#EF9A9A',
                                                fillOpacity: 0.7
                                            }
                                        }

                                    },

                                    // layer.feature.properties.NAME


                                }).addTo(map);

                                if(map.getZoom() >= 11) {
                                    geoojson = L.geoJson(response.data, {

                                    }).addTo(map).bindTooltip(function (layer) {
                                            return layer.feature.properties.NAME; //merely sets the tooltip text
                                        }, {permanent: true,direction: 'center'}  //then add your options
                                    );
                                }
                                else
                                {
                                    geoojson = L.geoJson(response.data, {

                                    }).addTo(map);
                                }


                                geoojson.on('click', function (e) {


                                    axios.get('{{route('gg.reestr.bp.edit')}}', {
                                        params: {
                                            code: e.layer.feature.properties.Kadastr_nu,
                                            start: main.year_star,
                                            finish: main.year_finish
                                        }
                                    })
                                        .then(function (response) {
                                            if (response != null) {
                                                // main.canal_ajax = response.data;
                                                // canal_ajax = response.data;
                                                // $('#bindPupUp').modal('show');
                                                main.canal_ajax = response.data;
                                                $('#bindPupUp4').modal('show');


                                            }

                                        }).catch(function (error) {
                                        console.log(error);
                                    })
                                });
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    }
                    else if(param == 'mountain_ranges')
                    {
                        axios.get('http://83.221.160.76:6080/arcgis/rest/services/GVKWebservice/MapServer/4/query', {
                            params: {
                                where: '',
                                text: '',
                                objectIds:'',
                                time:'',
                                geometry:{
                                    XMin:w_x,
                                    YMin:w_y,
                                    XMax:n_x,
                                    YMax:n_y
                                },
                                geometryType:'esriGeometryEnvelope',
                                inSR:4326,
                                spatialRel:'esriSpatialRelEnvelopeIntersects',
                                outFields:'*',
                                outSR:4326,
                                returnIdsOnly:false,
                                returnCountOnly:false,
                                returnZ:false,
                                returnM:false,
                                returnDistinctValues:false,
                                returnExtentsOnly:false,
                                f:'geojson',


                            }
                        })
                            .then(function (response) {
                                // for(i in map._layers) {
                                //     if(map._layers[i]._path != undefined) {
                                //
                                //         try {
                                //             map.removeLayer(map._layers[i]);
                                //         }
                                //         catch(e) {
                                //             console.log("problem with " + e + map._layers[i]);
                                //         }
                                //
                                //
                                //     }
                                // }

                                geoojson = L.geoJson(response.data, {



                                    style: function (feature) {
                                        if(feature.properties.NAME == main.input_value || feature.properties.Kadastr_nu == main.input_value)
                                        {
                                            return {
                                                color: '#ff1a1a',
                                                weight: 2,
                                                fillColor: '#ebf7d0',
                                                fillOpacity: 0.7
                                            }
                                        }
                                        else
                                        {
                                            return {
                                                color: '#6e6e6e',
                                                weight: 2,
                                                fillColor: '#ebf7d0',
                                                fillOpacity: 0.7
                                            }
                                        }

                                    },

                                    // onEachFeature: function (feature, layer) {
                                    //     if(map.getZoom() >= 11)
                                    //     {
                                    //         layer.setText(feature.properties.Канал_номи, {
                                    //             repeat: false, center: true,
                                    //             offset: 10,
                                    //             attributes: {
                                    //                 fill: 'blue',
                                    //                 'font-weight': 'bold',
                                    //                 'font-size': '12'
                                    //             }
                                    //         });
                                    //     }
                                    //     else {
                                    //         layer.setText('', {
                                    //             repeat: false, center: true,
                                    //             offset: 10,
                                    //             attributes: {
                                    //                 fill: 'blue',
                                    //                 'font-weight': 'bold',
                                    //                 'font-size': '12'
                                    //             }
                                    //         });
                                    //     }
                                    //
                                    // }


                                }).addTo(map);

                                if(map.getZoom() >= 11) {
                                    geoojson = L.geoJson(response.data, {

                                    }).bindTooltip(function (layer) {
                                            return layer.feature.properties.NAME; //merely sets the tooltip text
                                        }, {permanent: true,direction: 'center'}  //then add your options
                                    ).addTo(map);
                                }

                                geoojson.on('click', function (e) {


                                    axios.get('{{route('gg.reestr.mr.edit')}}', {
                                        params: {
                                            code: e.layer.feature.properties.Kadastr_nu,
                                            start: main.year_star,
                                            finish: main.year_finish
                                        }
                                    })
                                        .then(function (response) {
                                            if (response != null) {
                                                main.mountain_ranges_ajax = response.data;
                                                $('#Mountain').modal('show');


                                            }

                                        }).catch(function (error) {
                                        console.log(error);
                                    })
                                });
                            })
                            .catch(function (error) {
                                console.log(error);
                            });
                    }
                    else if(param == 'wells')
                    {
                        axios.get('http://83.221.160.76:6080/arcgis/rest/services/GVKWebservice/MapServer/0/query', {
                            params: {
                                where: '',
                                text: '',
                                objectIds:'',
                                time:'',
                                geometry:{
                                    XMin:w_x,
                                    YMin:w_y,
                                    XMax:n_x,
                                    YMax:n_y
                                },
                                geometryType:'esriGeometryEnvelope',
                                inSR:4326,
                                spatialRel:'esriSpatialRelEnvelopeIntersects',
                                outFields:'*',
                                outSR:4326,
                                returnIdsOnly:false,
                                returnCountOnly:false,
                                returnZ:false,
                                returnM:false,
                                returnDistinctValues:false,
                                returnExtentsOnly:false,
                                f:'geojson',


                            }
                        })
                            .then(function (response) {
                                // for(i in map._layers) {
                                //     if(map._layers[i]._path != undefined) {
                                //
                                //         try {
                                //             map.removeLayer(map._layers[i]);
                                //         }
                                //         catch(e) {
                                //             console.log("problem with " + e + map._layers[i]);
                                //         }
                                //
                                //
                                //     }
                                // }

                                geoojson = L.geoJson(response.data, {
                                    pane: "pane250",

                                    pointToLayer: function(feature, latlng) {
                                        if(map.getZoom() >= 11)
                                        {
                                            var square = L.shapeMarker(latlng, {
                                                shape: "circle",
                                                radius: 4,
                                                fillOpacity:0.7,
                                                color:'#0025ab',
                                                pane: "pane250",

                                            }).bindTooltip(feature.properties.kadasrt_uz,{  permanent: true,direction: 'right'}).addTo(map).on('click', function () {
                                                axios.get('{{route('gg.reestr.wells.edit')}}', {
                                                    params: {
                                                        code: feature.properties.назв,
                                                        start: main.year_star,
                                                        finish: main.year_finish
                                                    }
                                                })
                                                    .then(function (response) {
                                                        if (response != null) {
                                                            main.wells_ajax = response.data;
                                                            $('#WellsPopUp').modal('show');

                                                        }

                                                    }).catch(function (error) {
                                                    console.log(error);
                                                })
                                            });


                                        }
                                        else
                                        {
                                            var square = L.shapeMarker(latlng, {
                                                shape: "circle",
                                                radius: 4,
                                                fillOpacity:0.7,
                                                color:'#0025ab',
                                                pane: "pane250",

                                            }).addTo(map).on('click', function () {
                                                axios.get('{{route('gg.reestr.wells.edit')}}', {
                                                    params: {
                                                        code: feature.properties.kadasrt_uz,
                                                        start: main.year_star,
                                                        finish: main.year_finish
                                                    }
                                                })
                                                    .then(function (response) {
                                                        if (response != null) {
                                                            main.wells_ajax = response.data;
                                                            $('#WellsPopUp').modal('show');

                                                        }

                                                    }).catch(function (error) {
                                                    console.log(error);
                                                })
                                            });


                                        }

                                    }
                                }).addTo(map);

                            })
                            .catch(function (error) {
                                console.log(error);
                            });

                    }
                    else if(param == 'acr1')
                    {
                        axios.get('http://83.221.160.76:6080/arcgis/rest/services/GVKWebservice/MapServer/2/query', {
                            params: {
                                where: '',
                                text: '',
                                objectIds:'',
                                time:'',
                                geometry:{
                                    XMin:w_x,
                                    YMin:w_y,
                                    XMax:n_x,
                                    YMax:n_y
                                },
                                geometryType:'esriGeometryEnvelope',
                                inSR:4326,
                                spatialRel:'esriSpatialRelEnvelopeIntersects',
                                outFields:'*',
                                outSR:4326,
                                returnIdsOnly:false,
                                returnCountOnly:false,
                                returnZ:false,
                                returnM:false,
                                returnDistinctValues:false,
                                returnExtentsOnly:false,
                                f:'geojson',


                            }
                        })
                            .then(function (response) {
                                // for(i in map._layers) {
                                //     if(map._layers[i]._path != undefined) {
                                //
                                //         try {
                                //             map.removeLayer(map._layers[i]);
                                //         }
                                //         catch(e) {
                                //             console.log("problem with " + e + map._layers[i]);
                                //         }
                                //
                                //
                                //     }
                                // }

                                geoojson = L.geoJson(response.data, {
                                    pane: "pane250",

                                    pointToLayer: function(feature, latlng) {
                                        if(map.getZoom() >= 11)
                                        {
                                            var square = L.shapeMarker(latlng, {
                                                shape: "circle",
                                                radius: 4,
                                                fillOpacity:0.7,
                                                color:'#00BCD4',
                                                pane: "pane250",

                                            }).bindTooltip(feature.properties.obj_nomi,{  permanent: true,direction: 'right'}).addTo(map).on('click', function () {
                                                axios.get('{{route('gg.reestr.wc.edit')}}', {
                                                    params: {
                                                        code: feature.properties.kad_raqam,
                                                        start: main.year_star,
                                                        finish: main.year_finish
                                                    }
                                                })
                                                    .then(function (response) {
                                                        if (response != null) {
                                                            main.arc1_ajax = response.data;
                                                            $('#arc1PopUp').modal('show');

                                                        }

                                                    }).catch(function (error) {
                                                    console.log(error);
                                                })
                                            });


                                        }
                                        else
                                        {
                                            var square = L.shapeMarker(latlng, {
                                                shape: "circle",
                                                radius: 4,
                                                fillOpacity:0.7,
                                                color:'#00BCD4',
                                                pane: "pane250",

                                            }).addTo(map).on('click', function () {
                                                axios.get('{{route('gg.reestr.wc.edit')}}', {
                                                    params: {
                                                        code: feature.properties.kad_raqam,
                                                        start: main.year_star,
                                                        finish: main.year_finish
                                                    }
                                                })
                                                    .then(function (response) {
                                                        if (response != null) {
                                                            main.arc1_ajax = response.data;
                                                            $('#arc1PopUp').modal('show');

                                                        }

                                                    }).catch(function (error) {
                                                    console.log(error);
                                                })
                                            });
                                        }



                                    }
                                }).addTo(map);

                            })
                            .catch(function (error) {
                                console.log(error);
                            });

                    }
                    else if(param == 'canals')
                    {

                        axios.get('http://213.230.126.118:6080/arcgis/rest/services/GVKWebService/MapServer/3/query', {
                            params: {
                                where: '',
                                text: '',
                                objectIds:'',
                                time:'',
                                geometry:{
                                    XMin:w_x,
                                    YMin:w_y,
                                    XMax:n_x,
                                    YMax:n_y
                                },
                                geometryType:'esriGeometryEnvelope',
                                inSR:4326,
                                spatialRel:'esriSpatialRelEnvelopeIntersects',
                                outFields:'*',
                                outSR:4326,
                                returnIdsOnly:false,
                                returnCountOnly:false,
                                returnZ:false,
                                returnM:false,
                                returnDistinctValues:false,
                                returnExtentsOnly:false,
                                f:'geojson',


                            }
                        })
                            .then(function (response) {

                                geoojson = L.geoJson(response.data, {
                                    pane: "pane250",


                                    style: function (feature) {
                                        if(feature.properties.Кадастр_рақами == main.input_value && main.input_value != '' )
                                        {
                                            return {
                                                color: 'red',
                                                weight: 4,
                                                fillColor: '#9B9A9A',
                                                fillOpacity: 0.7
                                            }
                                        }
                                        else
                                        {
                                            return {
                                                color: 'blue',
                                                weight: 4,
                                                fillColor: '#9B9A9A',
                                                fillOpacity: 0.7
                                            }
                                        }
                                    },

                                    onEachFeature: function (feature, layer) {
                                        if(map.getZoom() >= 11)
                                        {
                                            layer.setText(feature.properties.Канал_номи, {
                                                repeat: false, center: true,
                                                offset: 10,
                                                attributes: {
                                                    fill: 'blue',
                                                    'font-weight': 'bold',
                                                    'font-size': '12'
                                                }
                                            });
                                        }
                                        else {
                                            layer.setText('', {
                                                repeat: false, center: true,
                                                offset: 10,
                                                attributes: {
                                                    fill: 'blue',
                                                    'font-weight': 'bold',
                                                    'font-size': '12'
                                                }
                                            });
                                        }

                                    }


                                }).addTo(map);

                                geoojson.on('click', function (e) {


                                    axios.get('{{route('c.edit')}}', {
                                        params: {
                                            code: e.layer.feature.properties.Кадастр_рақами,
                                            start: main.year_star,
                                            finish: main.year_finish
                                        }
                                    })
                                        .then(function (response) {
                                            if (response != null) {
                                                main.canal_ajax = response.data;
                                                canal_ajax = response.data;
                                                $('#bindPupUp').modal('show');


                                            }

                                        }).catch(function (error) {
                                        console.log(error);
                                    })
                                });



                            });
                    }
                    else if(param == 'pump_station')
                    {

                        axios.get('http://213.230.126.118:6080/arcgis/rest/services/GVKWebService/MapServer/1/query', {
                            params: {
                                where: '',
                                text: '',
                                objectIds:'',
                                time:'',
                                geometry:{
                                    XMin:w_x,
                                    YMin:w_y,
                                    XMax:n_x,
                                    YMax:n_y
                                },
                                geometryType:'esriGeometryEnvelope',
                                inSR:4326,
                                spatialRel:'esriSpatialRelEnvelopeIntersects',
                                outFields:'*',
                                outSR:4326,
                                returnIdsOnly:false,
                                returnCountOnly:false,
                                returnZ:false,
                                returnM:false,
                                returnDistinctValues:false,
                                returnExtentsOnly:false,
                                f:'geojson',


                            }
                        })
                            .then(function (response) {



                                geoojson = L.geoJson(response.data, {
                                    pane: "pane250",

                                    pointToLayer: function(feature, latlng) {
                                        if(map.getZoom() >= 11)
                                        {
                                            var square = L.shapeMarker(latlng, {
                                                shape: "triangle",
                                                radius: 8,
                                                fillOpacity:1,
                                                color:'#FFA500'
                                            }).bindTooltip(feature.properties.Насос_станция_номи,{  permanent: true,direction: 'right'}).addTo(map).on('click',function () {
                                                axios.get('{{route('ps.edit')}}', {
                                                    params: {
                                                        code: feature.properties.Кадастр_рақами,
                                                        start: main.year_star,
                                                        finish: main.year_finish
                                                    }
                                                })
                                                    .then(function (response) {
                                                        if (response != null) {
                                                            main.pump_station_ajax = response.data;
                                                            $('#modalPumpStation').modal('show');

                                                        }

                                                    }).catch(function (error) {
                                                    console.log(error);
                                                })
                                            });


                                        }
                                        else
                                        {
                                            var square = L.shapeMarker(latlng, {
                                                shape: "triangle",
                                                radius: 8,
                                                fillOpacity:1,
                                                color:'#FFA500'
                                            }).addTo(map).on('click',function () {
                                                axios.get('{{route('ps.edit')}}', {
                                                    params: {
                                                        code: feature.properties.Кадастр_рақами,
                                                        start: main.year_star,
                                                        finish: main.year_finish
                                                    }
                                                })
                                                    .then(function (response) {
                                                        if (response != null) {
                                                            main.pump_station_ajax = response.data;
                                                            $('#modalPumpStation').modal('show');

                                                        }

                                                    }).catch(function (error) {
                                                    console.log(error);
                                                })
                                            });


                                        }

                                    }
                                }).addTo(map);

                                geoojson.on('click', function (e) {
                                    axios.get('{{route('c.edit')}}', {
                                        params: {
                                            code: e.layer.feature.properties.Кадастр_рақами,
                                            start: main.year_star,
                                            finish: main.year_finish
                                        }
                                    })
                                        .then(function (response) {
                                            console.log('clicked');
                                            if (response != null) {
                                                main.pump_station_ajax = response.data;
                                                $('#modalPumpStation').modal('show');


                                            }

                                        }).catch(function (error) {
                                        console.log(error);
                                    })
                                });
                            });

                    }
                    else if(param == 'reservoirs')
                    {

                        axios.get('http://213.230.126.118:6080/arcgis/rest/services/GVKWebService/MapServer/1/query', {
                            params: {
                                where: '',
                                text: '',
                                objectIds:'',
                                time:'',
                                geometry:{
                                    XMin:w_x,
                                    YMin:w_y,
                                    XMax:n_x,
                                    YMax:n_y
                                },
                                geometryType:'esriGeometryEnvelope',
                                inSR:4326,
                                spatialRel:'esriSpatialRelEnvelopeIntersects',
                                outFields:'*',
                                outSR:4326,
                                returnIdsOnly:false,
                                returnCountOnly:false,
                                returnZ:false,
                                returnM:false,
                                returnDistinctValues:false,
                                returnExtentsOnly:false,
                                f:'geojson',
                            }
                        })
                            .then(function (response) {


                                if(map.getZoom() >= 11) {
                                    geoojson = L.geoJson(response.data, {
                                        pane: "pane200",

                                        pointToLayer: function (feature, latlng) {

                                        }
                                    }).bindTooltip(function (layer) {
                                            return layer.feature.properties.Сув_омбор_ва_сел_омборлар_номи; //merely sets the tooltip text
                                        }, {permanent: true,direction: 'center'}  //then add your options
                                    ).addTo(map);
                                }
                                else
                                {
                                    geoojson = L.geoJson(response.data, {
                                        pane: "pane200",

                                        pointToLayer: function (feature, latlng) {

                                        }
                                    }).addTo(map);

                                }

                                geoojson.on('click', function (e) {
                                    axios.get('{{route('rv.edit')}}', {
                                        params: {
                                            code: e.layer.feature.properties.Кадастр_рақами,
                                            start: main.year_star,
                                            finish: main.year_finish
                                        }
                                    })
                                        .then(function (response) {
                                            if (response != null) {
                                                main.reservoirs_ajax = response.data;
                                                $('#modalReservoirs').modal('show');


                                            }

                                        }).catch(function (error) {
                                        console.log(error);
                                    })
                                });

                            })
                            .catch(function (error) {
                                console.log(error);
                            })
                            .then(function () {
                                // always executed
                            });
                    }
                    else if(param == 'waterwork')
                    {
                        axios.get('http://213.230.126.118:6080/arcgis/rest/services/GVKWebService/MapServer/0/query', {
                            params: {
                                where: '',
                                text: '',
                                objectIds:'',
                                time:'',
                                geometry:{
                                    XMin:w_x,
                                    YMin:w_y,
                                    XMax:n_x,
                                    YMax:n_y
                                },
                                geometryType:'esriGeometryEnvelope',
                                inSR:4326,
                                spatialRel:'esriSpatialRelEnvelopeIntersects',
                                outFields:'*',
                                outSR:4326,
                                returnIdsOnly:false,
                                returnCountOnly:false,
                                returnZ:false,
                                returnM:false,
                                returnDistinctValues:false,
                                returnExtentsOnly:false,
                                f:'geojson',
                            }
                        })
                            .then(function (response) {

                                geoojson = L.geoJson(response.data, {
                                    pane: "pane250",

                                    pointToLayer: function(feature, latlng) {
                                        if(map.getZoom() >= 11)
                                        {
                                            var square = L.shapeMarker(latlng, {
                                                shape: "circle",
                                                radius: 8,
                                                fillOpacity:0.5,
                                                color:'#FF0000'
                                            }).bindTooltip(feature.properties.Гидроузел_номи,{  permanent: true,direction: 'right'}).addTo(map).on('click',function () {
                                                axios.get('{{route('ww.edit')}}', {
                                                    params: {
                                                        code: feature.properties.Кадастр_рақами,
                                                        start: main.year_star,
                                                        finish: main.year_finish
                                                    }
                                                })
                                                    .then(function (response) {
                                                        if (response != null) {
                                                            main.waterwork_ajax = response.data;
                                                            $('#modalWaterwork').modal('show');

                                                        }

                                                    }).catch(function (error) {
                                                    console.log(error);
                                                })
                                            });


                                        }
                                        else
                                        {
                                            var square = L.shapeMarker(latlng, {
                                                shape: "circle",
                                                radius: 8,
                                                fillOpacity:0.5,
                                                color:'#FF0000'
                                            }).addTo(map).on('click',function () {
                                                axios.get('{{route('ww.edit')}}', {
                                                    params: {
                                                        code: feature.properties.Кадастр_рақами,
                                                        start: main.year_star,
                                                        finish: main.year_finish
                                                    }
                                                })
                                                    .then(function (response) {
                                                        if (response != null) {
                                                            main.waterwork_ajax = response.data;
                                                            $('#modalWaterwork').modal('show');

                                                        }

                                                    }).catch(function (error) {
                                                    console.log(error);
                                                })
                                            });


                                        }

                                    }
                                }).addTo(map);

                                geoojson.on('click', function (e) {
                                    axios.get('{{route('c.edit')}}', {
                                        params: {
                                            code: e.layer.feature.properties.Кадастр_рақами,
                                            start: main.year_star,
                                            finish: main.year_finish
                                        }
                                    })
                                        .then(function (response) {
                                            if (response != null) {
                                                main.canal_ajax = response.data;
                                                canal_ajax = response.data;
                                                $('#bindPupUp').modal('show');


                                            }

                                        }).catch(function (error) {
                                        console.log(error);
                                    })
                                });

                            })
                            .catch(function (error) {
                                console.log(error);
                            })
                            .then(function () {
                                // always executed
                            });

                    }
                    else if(param == 'collector')
                    {
                        axios.get('http://213.230.126.118:6080/arcgis/rest/services/GVKWebService/MapServer/2/query', {
                            params: {
                                where: '',
                                text: '',
                                objectIds:'',
                                time:'',
                                geometry:{
                                    XMin:w_x,
                                    YMin:w_y,
                                    XMax:n_x,
                                    YMax:n_y
                                },
                                geometryType:'esriGeometryEnvelope',
                                inSR:4326,
                                spatialRel:'esriSpatialRelEnvelopeIntersects',
                                outFields:'*',
                                outSR:4326,
                                returnIdsOnly:false,
                                returnCountOnly:false,
                                returnZ:false,
                                returnM:false,
                                returnDistinctValues:false,
                                returnExtentsOnly:false,
                                f:'geojson',


                            }
                        })
                            .then(function (response) {


                                geoojson = L.geoJson(response.data, {
                                    pane: "pane250",



                                    style: function (feature) {
                                        if(feature.properties.Кадастр_рақами == main.input_value)
                                        {
                                            return {
                                                color: 'red',
                                                weight: 4,
                                                fillColor: '#9B9A9A',
                                                fillOpacity: 0.7
                                            }
                                        }
                                        else
                                        {
                                            return {
                                                color: '#2F5613',
                                                weight: 4,
                                                fillColor: '#9B9A9A',
                                                fillOpacity: 0.7
                                            }
                                        }
                                    },

                                    onEachFeature: function (feature, layer) {
                                        if(map.getZoom() >= 11)
                                        {
                                            layer.setText(feature.properties.Коллектор_номи, {
                                                repeat: false, center: true,
                                                offset: 10,
                                                attributes: {
                                                    fill: '#2F5613',
                                                    'font-weight': 'bold',
                                                    'font-size': '12'
                                                }
                                            });
                                        }
                                        else {
                                            layer.setText('', {
                                                repeat: false, center: true,
                                                offset: 10,
                                                attributes: {
                                                    fill: '#2F5613',
                                                    'font-weight': 'bold',
                                                    'font-size': '12'
                                                }
                                            });
                                        }

                                    }
                                }).addTo(map);

                                geoojson.on('click', function (e) {


                                    axios.get('{{route('ct.edit')}}', {
                                        params: {
                                            code: e.layer.feature.properties.Кадастр_рақами,
                                            start: main.year_star,
                                            finish: main.year_finish
                                        }
                                    })
                                        .then(function (response) {
                                            if (response != null) {
                                                main.collectors_ajax = response.data;
                                                $('#modalCollector').modal('show');


                                            }

                                        }).catch(function (error) {
                                        console.log(error);
                                    })
                                });

                            })
                            .catch(function (error) {
                                console.log(error);
                            });

                    }
                },
                getOneObjectRest(param,cadaster_number)
                {
                    if(param == 'approval_plots')
                    {
                        axios.get('http://83.221.160.76:6080/arcgis/rest/services/GVKWebservice/MapServer/1/query', {
                            params: {
                                // where: "id_raqam="+cadaster_number+ "" + "OR " + "obj_nomi LIKE '%"+cadaster_number+ "%'"  ,
                                where: "id_raqam="+cadaster_number+ "" ,
                                outFields:'*',
                                outSR:4326,

                                f:'geojson',


                            }
                        })
                            .then(function (response) {
                                //
                                // for(i in map._layers) {
                                //     if(map._layers[i]._path != undefined) {
                                //
                                //         try {
                                //             map.removeLayer(map._layers[i]);
                                //         }
                                //         catch(e) {
                                //             console.log("problem with " + e + map._layers[i]);
                                //         }
                                //
                                //
                                //     }
                                // }

                                geoojson = L.geoJson(response.data, {


                                }).addTo(map);

                                {{--geoojson.on('click', function (e) {--}}


                                {{--    axios.get('{{route('c.edit')}}', {--}}
                                {{--        params: {--}}
                                {{--            code: e.layer.feature.properties.Кадастр_рақами,--}}
                                {{--            start: main.year_star,--}}
                                {{--            finish: main.year_finish--}}
                                {{--        }--}}
                                {{--    })--}}
                                {{--        .then(function (response) {--}}
                                {{--            if (response != null) {--}}
                                {{--                // main.canal_ajax = response.data;--}}
                                {{--                // canal_ajax = response.data;--}}
                                {{--                // $('#bindPupUp').modal('show');--}}


                                {{--            }--}}

                                {{--        }).catch(function (error) {--}}
                                {{--        console.log(error);--}}
                                {{--    })--}}
                                {{--});--}}



                                map.fitBounds(geoojson.getBounds());


                                let map_bounds = geoojson.getBounds();


                                    let north_east_x = map_bounds._northEast.lat;
                                        let north_east_y = map_bounds._northEast.lng;
                                        let south_west_x = map_bounds._southWest.lat;
                                        let south_west_y = map_bounds._southWest.lng;
                                        main.getAllObjects('approval_plots',north_east_y,north_east_x,south_west_y,south_west_x);






                            })
                            .catch(function (error) {
                                console.log(error);
                            })
                            .then(function () {
                                // always executed
                            });
                    }
                    else if(param == 'birth_regions')
                    {
                        axios.get('http://83.221.160.76:6080/arcgis/rest/services/GVKWebservice/MapServer/3/query', {
                            params: {
                                where: "Kadastr_nu='"+cadaster_number+ "'",// + "OR " + "NAME LIKE '%"+cadaster_number+ "%'"  ,

                                outFields:'*',
                                outSR:4326,
                                f:'geojson',


                            }
                        })
                            .then(function (response) {

                                // for(i in map._layers) {
                                //     if(map._layers[i]._path != undefined) {
                                //
                                //         try {
                                //             map.removeLayer(map._layers[i]);
                                //         }
                                //         catch(e) {
                                //             console.log("problem with " + e + map._layers[i]);
                                //         }
                                //
                                //
                                //     }
                                // }

                                geoojson = L.geoJson(response.data, {

                                    style: function (feature) {
                                        if(feature.properties.NAME == main.input_value)
                                        {
                                            return {
                                                color: '#6e6e6e',
                                                weight: 4,
                                                fillColor: '#3333ff',
                                                fillOpacity: 0.7
                                            }
                                        }
                                        else
                                        {
                                            return {
                                                color: '#6e6e6e',
                                                weight: 4,
                                                fillColor: '#bcf5cd',
                                                fillOpacity: 0.7
                                            }
                                        }

                                    },


                                }).addTo(map);

                                {{--geoojson.on('click', function (e) {--}}


                                {{--    axios.get('{{route('c.edit')}}', {--}}
                                {{--        params: {--}}
                                {{--            code: e.layer.feature.properties.Кадастр_рақами,--}}
                                {{--            start: main.year_star,--}}
                                {{--            finish: main.year_finish--}}
                                {{--        }--}}
                                {{--    })--}}
                                {{--        .then(function (response) {--}}
                                {{--            if (response != null) {--}}
                                {{--                // main.canal_ajax = response.data;--}}
                                {{--                // canal_ajax = response.data;--}}
                                {{--                // $('#bindPupUp').modal('show');--}}


                                {{--            }--}}

                                {{--        }).catch(function (error) {--}}
                                {{--        console.log(error);--}}
                                {{--    })--}}
                                {{--});--}}



                                map.fitBounds(geoojson.getBounds());


                                let map_bounds = geoojson.getBounds();


                                let north_east_x = map_bounds._northEast.lat;
                                let north_east_y = map_bounds._northEast.lng;
                                let south_west_x = map_bounds._southWest.lat;
                                let south_west_y = map_bounds._southWest.lng;
                                main.getAllObjects('birth_regions',north_east_y,north_east_x,south_west_y,south_west_x);






                            })
                            .catch(function (error) {
                                console.log(error);
                            })
                            .then(function () {
                                // always executed
                            });

                    }
                    else if(param == 'mountain_ranges')
                    {
                        axios.get('http://83.221.160.76:6080/arcgis/rest/services/GVKWebservice/MapServer/4/query', {
                            params: {
                                where: "Kadastr_nu='"+cadaster_number+ "'",// + "OR " + "NAME LIKE '%"+cadaster_number+ "%'"  ,
                                outFields:'*',
                                outSR:4326,
                                f:'geojson',


                            }
                        })
                            .then(function (response) {

                                // for(i in map._layers) {
                                //     if(map._layers[i]._path != undefined) {
                                //
                                //         try {
                                //             map.removeLayer(map._layers[i]);
                                //         }
                                //         catch(e) {
                                //             console.log("problem with " + e + map._layers[i]);
                                //         }
                                //
                                //
                                //     }
                                // }

                                geoojson = L.geoJson(response.data, {




                                    style: function (feature) {
                                        if(feature.properties.NAME == main.input_value)
                                        {
                                            return {
                                                color: '#ff1a1a',
                                                weight: 2,
                                                fillColor: '#ebf7d0',
                                                fillOpacity: 0.7
                                            }
                                        }
                                        else
                                        {
                                            return {
                                                color: '#6e6e6e',
                                                weight: 2,
                                                fillColor: '#ebf7d0',
                                                fillOpacity: 0.7
                                            }
                                        }

                                    },
                                    // onEachFeature: function (feature, layer) {
                                    //     if(map.getZoom() >= 13)
                                    //     {
                                    //         layer.setText(feature.properties.Канал_номи, {
                                    //             repeat: false, center: true,
                                    //             offset: 10,
                                    //             attributes: {
                                    //                 fill: '#FF363A',
                                    //                 'font-weight': 'bold',
                                    //                 'font-size': '12'
                                    //             }
                                    //         });
                                    //     }
                                    //     else {
                                    //         layer.setText('', {
                                    //             repeat: false, center: true,
                                    //             offset: 10,
                                    //             attributes: {
                                    //                 fill: '#FF363A',
                                    //                 'font-weight': 'bold',
                                    //                 'font-size': '12'
                                    //             }
                                    //         });
                                    //     }
                                    //
                                    // }


                                }).addTo(map);

                                {{--geoojson.on('click', function (e) {--}}


                                {{--    axios.get('{{route('c.edit')}}', {--}}
                                {{--        params: {--}}
                                {{--            code: e.layer.feature.properties.Кадастр_рақами,--}}
                                {{--            start: main.year_star,--}}
                                {{--            finish: main.year_finish--}}
                                {{--        }--}}
                                {{--    })--}}
                                {{--        .then(function (response) {--}}
                                {{--            if (response != null) {--}}
                                {{--                // main.canal_ajax = response.data;--}}
                                {{--                // canal_ajax = response.data;--}}
                                {{--                // $('#bindPupUp').modal('show');--}}


                                {{--            }--}}

                                {{--        }).catch(function (error) {--}}
                                {{--        console.log(error);--}}
                                {{--    })--}}
                                {{--});--}}



                                map.fitBounds(geoojson.getBounds());


                                let map_bounds = geoojson.getBounds();


                                let north_east_x = map_bounds._northEast.lat;
                                let north_east_y = map_bounds._northEast.lng;
                                let south_west_x = map_bounds._southWest.lat;
                                let south_west_y = map_bounds._southWest.lng;
                                main.getAllObjects('mountain_ranges',north_east_y,north_east_x,south_west_y,south_west_x);






                            })
                            .catch(function (error) {
                                console.log(error);
                            })
                            .then(function () {
                                // always executed
                            });

                    }
                    else if(param == 'wells')
                    {
                        axios.get('http://83.221.160.76:6080/arcgis/rest/services/GVKWebservice/MapServer/0/query', {
                            params: {
                                where: "kadasrt_uz='"+cadaster_number+ "'",//+ "OR " + "назв LIKE '%"+cadaster_number+ "%'"  ,
                                outFields:'*',
                                outSR:4326,
                                f:'geojson',


                            }
                        })
                            .then(function (response) {

                                // for(i in map._layers) {
                                //     if(map._layers[i]._path != undefined) {
                                //
                                //         try {
                                //             map.removeLayer(map._layers[i]);
                                //         }
                                //         catch(e) {
                                //             console.log("problem with " + e + map._layers[i]);
                                //         }
                                //
                                //
                                //     }
                                // }

                                geoojson = L.geoJson(response.data, {



                                }).addTo(map);

                                {{--geoojson.on('click', function (e) {--}}


                                {{--    axios.get('{{route('c.edit')}}', {--}}
                                {{--        params: {--}}
                                {{--            code: e.layer.feature.properties.Кадастр_рақами,--}}
                                {{--            start: main.year_star,--}}
                                {{--            finish: main.year_finish--}}
                                {{--        }--}}
                                {{--    })--}}
                                {{--        .then(function (response) {--}}
                                {{--            if (response != null) {--}}
                                {{--                // main.canal_ajax = response.data;--}}
                                {{--                // canal_ajax = response.data;--}}
                                {{--                // $('#bindPupUp').modal('show');--}}


                                {{--            }--}}

                                {{--        }).catch(function (error) {--}}
                                {{--        console.log(error);--}}
                                {{--    })--}}
                                {{--});--}}



                                map.fitBounds(geoojson.getBounds());


                                let map_bounds = geoojson.getBounds();

                                let north_east_x = map_bounds._northEast.lat;
                                let north_east_y = map_bounds._northEast.lng;
                                let south_west_x = map_bounds._southWest.lat;
                                let south_west_y = map_bounds._southWest.lng;
                                main.getAllObjects('wells',north_east_y,north_east_x,south_west_y,south_west_x);






                            })
                            .catch(function (error) {
                                console.log(error);
                            })
                            .then(function () {
                                // always executed
                            });

                    }
                    else if(param == 'acr1')
                    {
                        axios.get('http://83.221.160.76:6080/arcgis/rest/services/GVKWebservice/MapServer/2/query', {
                            params: {
                                where: "'kad_raqam'='"+cadaster_number+ "'",// + "OR " + "NAME LIKE '%"+cadaster_number+ "%'"  ,
                                outFields:'*',
                                outSR:4326,
                                f:'geojson',



                            }
                        })
                            .then(function (response) {
                                // for(i in map._layers) {
                                //     if(map._layers[i]._path != undefined) {
                                //
                                //         try {
                                //             map.removeLayer(map._layers[i]);
                                //         }
                                //         catch(e) {
                                //             console.log("problem with " + e + map._layers[i]);
                                //         }
                                //
                                //
                                //     }
                                // }

                                geoojson = L.geoJson(response.data, {
                                    pointToLayer: function(feature, latlng) {
                                        if(map.getZoom() >= 11)
                                        {
                                            var square = L.shapeMarker(latlng, {
                                                shape: "circle",
                                                radius: 4,
                                                fillOpacity:0.7,
                                                color:'#00BCD4'
                                            }).bindTooltip(feature.properties.obj_nomi,{  permanent: true,direction: 'right'}).addTo(map);


                                        }
                                        else
                                        {
                                            var square = L.shapeMarker(latlng, {
                                                shape: "circle",
                                                radius: 4,
                                                fillOpacity:0.7,
                                                color:'#00BCD4'
                                            }).addTo(map);
                                        }


                                    }

                                }).addTo(map);

                                map.fitBounds(geoojson.getBounds());


                                let map_bounds = geoojson.getBounds();

                                let north_east_x = map_bounds._northEast.lat;
                                let north_east_y = map_bounds._northEast.lng;
                                let south_west_x = map_bounds._southWest.lat;
                                let south_west_y = map_bounds._southWest.lng;
                                main.getAllObjects('acr1',north_east_y,north_east_x,south_west_y,south_west_x);

                            })
                            .catch(function (error) {
                                console.log(error);
                            });

                    }
                    else if(param == 'canals')
                    {
                        axios.get('http://213.230.126.118:6080/arcgis/rest/services/GVKWebService/MapServer/3/query', {
                            params: {
                                where: "Кадастр_рақами='"+cadaster_number+ "'" + "OR " + "Канал_номи LIKE '%"+cadaster_number+ "%'"  ,
                                outFields:'*',
                                outSR:4326,
                                f:'geojson',


                            }
                        })
                            .then(function (response) {

                                for(i in map._layers) {
                                    if(map._layers[i]._path != undefined) {

                                        try {
                                            map.removeLayer(map._layers[i]);
                                        }
                                        catch(e) {
                                            console.log("problem with " + e + map._layers[i]);
                                        }


                                    }
                                }

                                geoojson = L.geoJson(response.data, {




                                    style: function (feature) {
                                        if(feature.properties.Кадастр_рақами == main.input_value)
                                        {
                                            return {
                                                color: 'red',
                                                weight: 4,
                                                fillColor: '#9B9A9A',
                                                fillOpacity: 0.7
                                            }
                                        }
                                        else
                                        {
                                            return {
                                                color: 'blue',
                                                weight: 4,
                                                fillColor: '#9B9A9A',
                                                fillOpacity: 0.7
                                            }
                                        }

                                    },

                                    onEachFeature: function (feature, layer) {
                                        if(map.getZoom() >= 13)
                                        {
                                            layer.setText(feature.properties.Канал_номи, {
                                                repeat: false, center: true,
                                                offset: 10,
                                                attributes: {
                                                    fill: '#FF363A',
                                                    'font-weight': 'bold',
                                                    'font-size': '12'
                                                }
                                            });
                                        }
                                        else {
                                            layer.setText('', {
                                                repeat: false, center: true,
                                                offset: 10,
                                                attributes: {
                                                    fill: '#FF363A',
                                                    'font-weight': 'bold',
                                                    'font-size': '12'
                                                }
                                            });
                                        }

                                    }


                                }).addTo(map);

                                geoojson.on('click', function (e) {


                                    axios.get('{{route('c.edit')}}', {
                                        params: {
                                            code: e.layer.feature.properties.Кадастр_рақами,
                                            start: main.year_star,
                                            finish: main.year_finish
                                        }
                                    })
                                        .then(function (response) {
                                            if (response != null) {
                                                main.canal_ajax = response.data;
                                                canal_ajax = response.data;
                                                $('#bindPupUp').modal('show');


                                            }

                                        }).catch(function (error) {
                                        console.log(error);
                                    })
                                });








                                map.fitBounds(geoojson.getBounds());


                                let map_bounds = geoojson.getBounds();

                                let north_east_x = map_bounds._northEast.lat;
                                let north_east_y = map_bounds._northEast.lng;
                                let south_west_x = map_bounds._southWest.lat;
                                let south_west_y = map_bounds._southWest.lng;
                                main.getAllObjects('canals',north_east_y,north_east_x,south_west_y,south_west_x);


                            })
                            .catch(function (error) {
                                console.log(error);
                            })
                            .then(function () {
                                // always executed
                            });
                    }
                    else if(param == 'pump_station')
                    {
                        axios.get('http://213.230.126.118:6080/arcgis/rest/services/GVKWebService/MapServer/1/query', {
                            params: {
                                where: "Кадастр_рақами='"+cadaster_number+ "'" + "OR " + "Насос_станция_номи LIKE '%"+cadaster_number+ "%'"  ,
                                outFields:'*',
                                outSR:4326,
                                f:'geojson',


                            }
                        })
                            .then(function (response) {
                                console.log(response);
                                for(var i = 0;i < response.data.features.length;i++)
                                {

                                    if(response.data.features[i].geometry.type == "Point")
                                    {
                                        main.pump_station_map.push(response.data.features[i].geometry.coordinates[1], response.data.features[i].geometry.coordinates[0]);
                                        main.greenIcon = L.icon({
                                            iconUrl: '{{asset('img/triangle-16.png')}}',

                                            iconSize:     [16, 16], // size of the icon

                                        });
                                        console.log(response.data.features[i].properties)
                                        main.pumpstation_el_one = new L.marker(main.pump_station_map, {icon: main.greenIcon}).bindTooltip(response.data.features[i].properties.Насос_станция_номи).addTo(map);

                                        map.fitBounds([main.pump_station_map]);
                                        var bounds = map.getBounds();


                                        let map_bounds = bounds;

                                        let north_east_x = map_bounds._northEast.lat;
                                        let north_east_y = map_bounds._northEast.lng;
                                        let south_west_x = map_bounds._southWest.lat;
                                        let south_west_y = map_bounds._southWest.lng;
                                        main.getAllObjects('pump_station',north_east_y,north_east_x,south_west_y,south_west_x);
                                    }
                                }

                            })
                            .catch(function (error) {
                                console.log(error);
                            })
                            .then(function () {
                                // always executed
                            });


                    }
                    else if(param == 'reservoirs')
                    {
                        axios.get('http://213.230.126.118:6080/arcgis/rest/services/GVKWebService/MapServer/1/query', {
                            params: {
                                where: "Кадастр_рақами='"+cadaster_number+ "'" + "OR " + "Сув_омбор_ва_сел_омборлар_номи LIKE '%"+cadaster_number+ "%'"  ,
                                outFields:'*',
                                outSR:4326,
                                f:'geojson',


                            }
                        })
                            .then(function (response) {

                                for(i in map._layers) {
                                    if(map._layers[i]._path != undefined) {
                                        if(map._layers[i]._leaflet_id != main.reservoirs_el_one._leaflet_id)
                                        {
                                            try {
                                                map.removeLayer(map._layers[i]);
                                            }
                                            catch(e) {
                                                console.log("problem with " + e + map._layers[i]);
                                            }
                                        }

                                    }
                                }

                                if(map.getZoom() >= 11) {
                                    geoojson = L.geoJson(response.data, {
                                        pointToLayer: function (feature, latlng) {

                                        }
                                    }).bindTooltip(function (layer) {
                                            return layer.feature.properties.Сув_омбор_ва_сел_омборлар_номи; //merely sets the tooltip text
                                        }, {permanent: true,direction: 'center'}  //then add your options
                                    ).addTo(map);
                                }
                                else
                                {
                                    geoojson = L.geoJson(response.data, {
                                        pointToLayer: function (feature, latlng) {

                                        }
                                    }).addTo(map);

                                }

                                geoojson.on('click', function (e) {
                                    axios.get('{{route('c.edit')}}', {
                                        params: {
                                            code: e.layer.feature.properties.Кадастр_рақами,
                                            start: main.year_star,
                                            finish: main.year_finish
                                        }
                                    })
                                        .then(function (response) {
                                            if (response != null) {
                                                main.canal_ajax = response.data;
                                                canal_ajax = response.data;
                                                $('#bindPupUp').modal('show');


                                            }

                                        }).catch(function (error) {
                                        console.log(error);
                                    })
                                });


                                map.fitBounds(geoojson.getBounds());

                                let map_bounds = geoojson.getBounds();

                                let north_east_x = map_bounds._northEast.lat;
                                let north_east_y = map_bounds._northEast.lng;
                                let south_west_x = map_bounds._southWest.lat;
                                let south_west_y = map_bounds._southWest.lng;
                                main.getAllObjects('reservoirs',north_east_y,north_east_x,south_west_y,south_west_x);


                            })
                            .catch(function (error) {
                                console.log(error);
                            })
                            .then(function () {
                                // always executed
                            });
                    }
                    else if(param == 'waterwork')
                    {
                        axios.get('http://213.230.126.118:6080/arcgis/rest/services/GVKWebService/MapServer/0/query', {
                            params: {
                                where: "Кадастр_рақами='"+cadaster_number+ "'" + "OR " + "Гидроузел_номи LIKE '%"+cadaster_number+ "%'"  ,
                                outFields:'*',
                                outSR:4326,
                                f:'geojson',


                            }
                        })
                            .then(function (response) {
                                for(var i = 0;i < response.data.features.length;i++)
                                {

                                    if(response.data.features[i].geometry.type == "Point")
                                    {
                                        main.waterwork_map.push(response.data.features[i].geometry.coordinates[1], response.data.features[i].geometry.coordinates[0]);

                                        main.waterworks_el = new L.circle(main.waterwork_map, {color:"red",fillColor:"#f03",fillOpacity: 0.5,
                                            radius: 20.0}).addTo(map);
                                        map.fitBounds([main.waterwork_map]);
                                        var bounds = map.getBounds();


                                        let map_bounds = bounds;

                                        let north_east_x = map_bounds._northEast.lat;
                                        let north_east_y = map_bounds._northEast.lng;
                                        let south_west_x = map_bounds._southWest.lat;
                                        let south_west_y = map_bounds._southWest.lng;
                                        main.getAllObjects('waterwork',north_east_y,north_east_x,south_west_y,south_west_x);
                                    }





                                }

                            })
                            .catch(function (error) {
                                console.log(error);
                            })
                            .then(function () {
                                // always executed
                            });

                    }
                    else if(param == 'collector')
                    {
                        axios.get('http://213.230.126.118:6080/arcgis/rest/services/GVKWebService/MapServer/2/query', {
                            params: {
                                where: "Кадастр_рақами='"+cadaster_number+ "'" + "OR " + "Коллектор_номи LIKE '%"+cadaster_number+ "%'"  ,
                                outFields:'*',
                                outSR:4326,
                                resultRecordCount:1,
                                f:'geojson',


                            }
                        })
                            .then(function (response) {
                                for(i in map._layers) {
                                    if(map._layers[i]._path != undefined) {
                                        if(map._layers[i]._leaflet_id != main.canals_el_one._leaflet_id)
                                        {
                                            try {
                                                map.removeLayer(map._layers[i]);
                                            }
                                            catch(e) {
                                                console.log("problem with " + e + map._layers[i]);
                                            }
                                        }

                                    }
                                }

                                geoojson = L.geoJson(response.data, {


                                    style: function (feature) {
                                        if(feature.properties.Кадастр_рақами == main.input_value)
                                        {
                                            return {
                                                color: 'red',
                                                weight: 4,
                                                fillColor: '#9B9A9A',
                                                fillOpacity: 0.7
                                            }
                                        }
                                        else
                                        {
                                            return {
                                                color: '#2F5613',
                                                weight: 4,
                                                fillColor: '#2F5613',
                                                fillOpacity: 0.7
                                            }
                                        }
                                    },

                                    onEachFeature: function (feature, layer) {
                                        if(map.getZoom() >= 11)
                                        {
                                            layer.setText(feature.properties.Коллектор_номи, {
                                                repeat: false, center: true,
                                                offset: 10,
                                                attributes: {
                                                    fill: '#2F5613',
                                                    'font-weight': 'bold',
                                                    'font-size': '12'
                                                }
                                            });
                                        }
                                        else {
                                            layer.setText('', {
                                                repeat: false, center: true,
                                                offset: 10,
                                                attributes: {
                                                    fill: '#2F5613',
                                                    'font-weight': 'bold',
                                                    'font-size': '12'
                                                }
                                            });
                                        }

                                    }
                                }).addTo(map);

                                geoojson.on('click', function (e) {


                                    axios.get('{{route('c.edit')}}', {
                                        params: {
                                            code: e.layer.feature.properties.Кадастр_рақами,
                                            start: main.year_star,
                                            finish: main.year_finish
                                        }
                                    })
                                        .then(function (response) {
                                            if (response != null) {
                                                main.canal_ajax = response.data;
                                                canal_ajax = response.data;
                                                $('#bindPupUp').modal('show');


                                            }

                                        }).catch(function (error) {
                                        console.log(error);
                                    })
                                });
                                map.fitBounds(geoojson.getBounds());


                                let map_bounds = geoojson.getBounds();

                                let north_east_x = map_bounds._northEast.lat;
                                let north_east_y = map_bounds._northEast.lng;
                                let south_west_x = map_bounds._southWest.lat;
                                let south_west_y = map_bounds._southWest.lng;
                                main.getAllObjects('collector',north_east_y,north_east_x,south_west_y,south_west_x);


                            })
                            .catch(function (error) {
                                console.log(error);
                            })
                            .then(function () {
                                // always executed
                            });

                    }
                }

            },
            created(){
                let that = this;

                document.addEventListener('keyup', function (evt) {
                    if (evt.keyCode === 27) {
                        main.isShow = true;
                    }
                });

                document.addEventListener('keyup', function (evt) {
                    if (evt.keyCode === 13) {
                        main.search();
                    }
                    if (evt.keyCode === 49  && document.activeElement.id != 'input_element') {
                        if(main.canals == true)
                            main.canals = false;
                        else
                            main.canals = true;
                    }
                    if (evt.keyCode === 50  && document.activeElement.id != 'input_element') {
                        if(main.pump_station == true)
                            main.pump_station = false;
                        else
                            main.pump_station = true;
                    }
                    if (evt.keyCode === 51 && document.activeElement.id != 'input_element') {
                        if(main.reservoirs == true)
                            main.reservoirs = false;
                        else
                            main.reservoirs = true;
                    }
                    if (evt.keyCode === 52 && document.activeElement.id != 'input_element') {
                        if(main.waterwork == true)
                            main.waterwork = false;
                        else
                            main.waterwork = true;
                    }
                    if (evt.keyCode === 53 && document.activeElement.id != 'input_element') {
                        if(main.collector == true)
                            main.collector = false;
                        else
                            main.collector = true;
                    }
                });

            },
            mounted() {
                this.InitialMap();
            }
        });



    </script>
    <script>

        var id = 0;
        function getId(id)
        {

        }


    </script>

    @endsection


    </body>
    </html>



