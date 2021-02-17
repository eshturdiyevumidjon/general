@extends('general.layouts.layout')

@section('content')
    <main id="main" class="py-3 " style="background-color: rgba(132, 142, 160, 0.03) !important">
        <div class="container mb-4">
            <div class="card pb-3 ">
                <div class="card-header">
                    {{--                    Поиск (Ежедневные данные)<button type="button" class="btn float-md-right p-1 btn-info btn-lg" style="font-size: 14px !important;" data-toggle="modal" data-target="#myModal">Загрузка объекта</button>--}}
                </div>
                <div class="card-body">

                    <form action="{{route('general.getviewpost')}}" method="get">
                        <div class="col-md-12 d-inline-flex ">
                            <div class="col-md-4 ">
                                <label>Дата</label>
                                @if(isset($date))
                                <input required v-model="date" type="month" value="{{$date}}" name="month"   class="form-control">
                                    @else
                                    <input required v-model="date" type="month"  name="month"   class="form-control">
                                    @endif

                            </div>
                            <div class="col-md-2 ">
                                <label>Фильтр</label>
                                <button class="btn btn-success form-control" type="submit">
                                    <i class="fa fa-filter"></i>&nbsp;Фильтр
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="card" style="font-size: 14px !important;">
                <div class="card-header">
                    Информация
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        @if(count($informations) > 0)
                            <table class="table table-condensed">
                                <thead >
                                <tr>
                                    <th class="border-0">Название</th>
                                    <th class="border-0">Ед.изм</th>
                                    @for($day = 1; $day <= $r_days_in_month; $day++)
                                        <th style="text-align: center!important;" class="border-0">{{ $day }}</th>
                                    @endfor
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($informations as $information)
                                    <tr>
                                        <td>{{$information->name}}</td>
                                        <td>{{$information->unit_name}}</td>
                                        @foreach($information->information as $item)

                                            <td >
                                                <span class="form-control">{{ $item->value }}</span>
                                            </td>
                                        @endforeach
                                    </tr>

                                @endforeach

                                </tbody>

                            </table>
                        @endif
                    </div>
                </div>

            </div>

        </div>
    </main>

    <!-- Modal -->

    <style>
        .table td{
            padding: 6px !important;
        }
    </style>
@endsection
@section('scripts')
    <script>



    </script>
@endsection