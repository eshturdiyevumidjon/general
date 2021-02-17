@php

    $lang_id = \App\language::where('language_prefix', app()->getLocale())->first();
          if(isset($lang_id))
              $metki  = \App\Metki::where('language_id', $lang_id->id)->get();
           else
            $metki  = \App\Metki::where('language_id', 3)->get();
@endphp
@extends('general.layouts.layout')
@section('content')
    <main id="main" class="py-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
					<div class="row">
						<div class="col">
							<h6 class="text-uppercase font-weight-bold" style="color: #007bff;">{{$metki->where('id_column','Обмен данными')->first() ? $metki->where('id_column','Обмен данными')->first()->only('mark_name')['mark_name'] : 'Обмен данными'  }}</h6>
						</div>
					</div>
					<!-- search form -->
					<form action="{{ route('general.exchange-index-post') }}" method="POST">
						@csrf
						<div class="row">
							<div class="col-3">
								<select required class="form-control form-control-sm form_class" name="form" >
									<option value="">Выберите</option>
									@foreach($forms as $key => $value)
										<option @if($postAttr) @if($postAttr['form'] == $key) selected="selected" @endif @endif value="{{ $key }}">{{ $value }}</option>
									@endforeach
								</select>
							</div>
              <div class="col-3">
                <select required class="form-control form-control-sm" name="elements" id="elements_form">
                  <option value="">Выберите</option>
                  @foreach($elements as $key => $value)
                    <option @if($postAttr) @if($postAttr['elements'] == $key) selected="selected" @endif @endif value="{{ $key }}">{{ $value }}</option>
                  @endforeach
                </select>
              </div>
							<div class="col-auto">
								<input required type="month" name="month" @if($postAttr)value="{{ $postAttr['month'] }}"@endif class="form-control form-control-sm">
							</div>
							<div class="col-auto">
								<button class="btn btn-sm btn-primary" type="submit">
									<i class="fa fa-filter"></i> {{ $metki->where('id_column','Открыть')->first() ? $metki->where('id_column','Открыть')->first()->only('mark_name')['mark_name'] : 'Открыть' }}
								</button>
							</div>
							<div class="col-auto ml-auto">
								@if($postAttr)
								<button type="button" id="btnClick" class="btn btn-info btn-sm ml-3">Экспорт</button>
								<!-- <button type="button" class="btn btn-warning btn-sm" style="font-size: 14px !important;" data-toggle="modal" data-target="#myModal">{{ $metki->where('id_column','Импорт')->first() ? $metki->where('id_column','Импорт')->first()->only('mark_name')['mark_name'] : 'Импорт'}}</button> -->
{{--                <a class="btn btn-danger btn-sm" href="{{ route( 'get-oper-form', ['year' => $r_year, 'elements' => $postAttr['elements'], 'form' => $postAttr['form'], 'month' => $postAttr['month'] ] ) }}">{{ $metki->where('id_column','Форма')->first() ? $metki->where('id_column','Форма')->first()->only('mark_name')['mark_name'] : 'Форма' }}</a>--}}
								@endif
							</div>
						</div>
					</form>
					<!-- end search form -->
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="max-height: 65vh; width: 100%;">
                        <table class="table table-bordered">
                            @if(!empty($formObjects))
                            <thead>
                            <tr >
                                <div id="graph-content" style="display:none; ">
                                    <button class="btn btn-info btn-sm" id="close-graph" title="Закрыть график">{{ $metki->where('id_column','Закрыть')->first() ? $metki->where('id_column','Закрыть')->first()->only('mark_name')['mark_name'] : 'Закрыть' }}</button>
                                    <div id="chartContainer" style="height: 400px; width: 100%;"></div><br>
                                </div>
                            </tr>
                            <tr class="bir">
                                <!-- <th><input type="checkbox" id="markAll" value="1"></th> -->
                                <th rowspan="3"><span>Число</span></th>
                                @foreach($formObjects as $sirdForm)
                                    <th colspan="2" style="text-align: center!important;">{{ $sirdForm['object']['name'] }}</th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($formObjects as $sirdForm)
                                    <th colspan="2" style="text-align: center!important;">{{ $sirdForm['object']['name_ru'] }}</th>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach($formObjects as $sirdForm)
                                    <td style="text-align: center!important;">08 часов</td>
                                    <td style="text-align: center!important;">ср</td>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                                @for($day = 1; $day <= $r_days_in_month; $day++)
                                  <tr>
                                    <td style="text-align: center!important;">{{ $day }}</td>
                                    @foreach($formObjects as $form)
                                        <?php
                                              $monKey = $r_month;
                                              $dayKey = $day;
                                              if($day < 10) $dayKey = '0' . $day;
                                              if($r_month < 10) $monKey = '0' . $r_month ;
                                              $key = $form['gvk_object_id'] . '_' . $dayKey . '_' . $monKey . '_' . $r_year;

                                              $first = null;
                                              $second = null;
                                              if(isset($result[$key])) $first = $result[$key];
                                              if(isset($result[$key . '_sr'])) $second = $result[$key . '_sr'];
                                        ?>
                                        <td>{{--{{ $first }}--}}
                                            <input type="number" step="any"  class="two-decimals form-control object-day-value obj-{{ $form['gvk_object_id'] }}" style="width: 75px!important; font-size: 12px!important; text-align: center; height: 15px !important;"
                                                   data-id="{{ $result[$key.'_id'] }}"
                                                   data-type="08"
                                                   {{--                                                       id="{{ $satr . '-' . $day_date }}"--}}
                                                   {{--                                                       data-form-id="{{ $dayInfo->form_id }}"--}}
                                                   {{--                                                       data-object-id="{{ $object->id }}"--}}
                                                   {{--                                                       data-object-obj_id="{{ $object->obj_id }}"--}}
                                                   name="date_info"
                                                   value="{{ $first }}"
                                                {{--                                                       data-day ="@php $i += 1; @endphp {{ $i }}"--}}
                                            >
                                        </td>
                                        <td>{{--{{ $second }}--}}
                                            <input type="number" step="any"  class="two-decimals form-control object-day-value obj-{{ $form['gvk_object_id'] }}" style="width: 75px!important; font-size: 12px!important; text-align: center; height: 15px !important;"
                                                   data-id="{{ $result[$key.'_id'] }}"
                                                   data-type="sr"
                                                   {{--                                                       id="{{ $satr . '-' . $day_date }}"--}}
                                                   {{--                                                       data-form-id="{{ $dayInfo->form_id }}"--}}
                                                   {{--                                                       data-object-id="{{ $object->id }}"--}}
                                                   {{--                                                       data-object-obj_id="{{ $object->obj_id }}"--}}
                                                   name="date_info"
                                                   value="{{ $second }}"
                                                {{--                                                       data-day ="@php $i += 1; @endphp {{ $i }}"--}}
                                            >
                                        </td>
                                    @endforeach
                                  </tr>
                                @endfor

                            </tbody>

      @else
      <tr>
        <td class="text-center">
          {{$metki->where('id_column','Данные не найдены')->first() ? $metki->where('id_column','Данные не найдены')->first()->only('mark_name')['mark_name'] : 'Данные не найдены' }}
        </td>
      </tr>
      @endif
    </table>

  </div>
</div>

</div>

</div>
</main>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <form action="{{ route('object-excel-import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header ">
          <h5 class="modal-title">{{ $metki->where('id_column','Импорт')->first() ? $metki->where('id_column','Импорт')->first()->only('mark_name')['mark_name'] : 'Импорт' }}</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="">
            <div class="custom-file mb-1">
              <input type="file" required name="file" class="custom-file-input" id="inputGroupFile01"
              aria-describedby="inputGroupFileAddon01">
              <label class="custom-file-label" for="inputGroupFile01">{{ $metki->where('id_column','Выбрать файл')->first() ? $metki->where('id_column','Выбрать файл')->first()->only('mark_name')['mark_name'] : 'Выбрать файл'}}</label>
            </div>
            <?php
            if($postAttr) {
              ?>
              <a href="{{ route('gvk-get-export-information-template', ['form_id' => $form_id, 'year' => $r_year, 'month' => $r_month] ) }}" class="btn btn-sm btn-warning"><i class="fa fa-download"></i>{{ $metki->where('id_column','Скачать шаблон')->first() ? $metki->where('id_column','Скачать шаблон')->first()->only('mark_name')['mark_name'] : 'Скачать шаблон' }}</a>
              <?}?>
            </div>
          </div>
          <div class="modal-footer">
            <input class="btn btn-primary btn-sm" type="submit" value="Загрузить">
          </div>
        </form>
      </div>
    </div>
  </div>

   {{-- <div id="graphModal" class="modal fade" role="dialog">
        <div class="modal-dialog graph-style" style="width: 2000px !important;" >
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header ">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
--}}{{--            <div id="chartContainer" style="height: 400px; width: 100%;"></div>--}}{{--
                </div>

            </div>

        </div>
      </div>--}}

      @endsection
      @section('scripts')

      <script>
        $(".two-decimals").change(function(){
          this.value = parseFloat(this.value).toFixed(2);
        });

        $(document).ready(function(){
          $('.form_class').on('change',function(){
           $.ajaxSetup({
             headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
           });
           $.ajax({

            'url':"{{ route ('general.ajax-select-element') }}",
            'method':'POST',
            'data':{
              value:$(this).val(),
            },success:function (data) {
              $( "#elements_form" ).html( data);
            },error:function () {
              alert('ajax error');
            }
          })
         });

         $('.object-day-value').on('change',function(){
           $.ajaxSetup({
             headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
           });
           $.ajax({

               'url':"http://213.230.126.118:8080/add-info-gidromet",
               'method':'GET',
               'data':{
                   id:$(this).attr('data-id'),
                   type:$(this).attr('data-type'),
                   value:$(this).val(),
            },success:function (data) {

            },error:function () {
              alert('ajax error');
            }
          })
         });
         $('.gr-obj-class').click(function(){
          let st = $(this).attr('data-status');
          if(st == 0){
            $(this).attr('data-status',1).addClass('selected-obj')
          }
          if(st == 1){
            $(this).attr('data-status',0).removeClass('selected-obj')
          }
        });
       });

        $('.btn-graph').click(function(){
          let object = $('.selected-obj');
          let data_array = [];
          $.each($(object),function(i,v){
            let day_val = [];
            let days = $('.obj-'+$(this).val());

            $.each($(days),function(i,v){
              if(!parseInt($(this).val())){
                data_val = '';
              } else {
                data_val = parseInt($(this).val())
              }
              day_val.push(
              {
                x: parseInt($(this).attr('data-day')), y: data_val
              }
              )
            });

            data_array.push(
            {
                        //visible: false,
                        type: "line",
                        showInLegend: true,
                        name: $(this).attr('data-name'),
                        lineDashType: "dash",
                        yValueFormatString: "#,##0",
                        dataPoints: day_val
                      }
                      );
          });

          let options = {
            animationEnabled: true,
            theme: "light2",
            title:{
              text: " "
            },
            axisX:{
              title: "@if($r_month ){{ App\Components\Month::name($r_month) }}@endif",
              interval:1,
                        //suffix: "K",
                        //minimum: 0,
                        maximum: "@if($r_days_in_month){{ $r_days_in_month }}@endif"
                      },
                      axisY: {
                        title: "Значение",
                        //suffix: "K",
                        //minimum: 0
                      },
                      toolTip:{
                        content: "{name}: {y}",
                      },
                      legend:{
                        cursor:"pointer",
                        verticalAlign: "center",
                        horizontalAlign: "right",
                        dockInsidePlotArea: false,
                        itemclick: toogleDataSeries
                      },
                      data: data_array

                    };
                    $('#graph-content').show();
                    $("#chartContainer").CanvasJSChart(options);
                    function toogleDataSeries(e){
                      if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                        e.dataSeries.visible = false;
                      } else{
                        e.dataSeries.visible = true;
                      }
                      e.chart.render();
                    }
                  });
        $('#close-graph').click(function(){
          $('#graph-content').hide();
        });

        $('#markAll').change(function(){
          if($(this).is(":checked")){
            $(':checkbox').attr('class', 'gr-obj-class selected-obj');
            $(':checkbox').attr('checked', true);
            $(':checkbox').attr('data-status', 1);
          }
          else{
            $(':checkbox').attr('class', 'gr-obj-class');
            $(':checkbox').attr('data-status', 0);
            $(':checkbox').attr('checked', false);
          }
        });

        $("#btnClick").click(function () {
          var selected = new Array();

          $("input[type=checkbox]:checked").each(function () {
            selected.push(this.value);
          });

          if (selected.length > 0) {
                //alert("Selected values: " + selected.join(","));

                var query = {
                  //form_id : @if($postAttr ){{ $postAttr['form'] }}@endif,
                  //year : @if($postAttr ){{ $r_year }}@endif,
                  //month : @if($postAttr ){{ $r_month }}@endif,
                  selects : selected.join(",")
                }
                var url = "{{route('gvk-export-information')}}?" + $.param(query)
                window.location = url;
              }
              else alert('Выберите объект');
            });

          </script>

          <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
          <script src="{{ asset('\js\jquery.canvasjs.min.js') }}"></script>
          <script type='text/javascript'>
            $(document).ready(function(){
                $('input').keydown(function(e) {
                    if(e.keyCode == 13) {
                        var str = $(this).attr('id');
                        res = str.split("-");
                        var nextId = parseInt(res[0]) + 1;
                        var next = '#' + nextId + '-' + res[1];
                        if ($(next).length) $(next).focus();
                        else {
                          next = '#1' + '-' + (parseInt(res[1]) + 1);
                          $(next).focus();
                        }
                        return false;
                    }
                });
            });
        </script>
          <style>
            input[type="number"]::-webkit-outer-spin-button,
            input[type="number"]::-webkit-inner-spin-button {
              -webkit-appearance: none;
              margin: 0;
              border: none;
              background: transparent;
            }
            input[type="number"] {
              -moz-appearance: textfield;
              border: none;
              background: transparent;
            }
            input .form-control {
              height: 24px !important;
            }
            pre{
              margin-bottom : 0px !important;
              text-align: left!important;
            }
            .table td{
              text-align: center!important;
              font-size: 12px!important;
              padding: 0.30rem !important;
            }
            .btn-light {
              background-color: #ffffff !important;
              border-color: #ffffff !important;
            }

            th { background-color: #fff !important; text-align: center!important; padding: 0.30rem !important; }

            .tableFixHead {
              overflow: auto;
            }

            .bir th {
              position: sticky;
              top: -4px;

            }
            .gorizontal {
              position: sticky !important;
              left: 0;
              top: 25px;
              background-color: #fff !important;
            }
            th span
            {
              -ms-writing-mode: tb-rl;
              -webkit-writing-mode: vertical-rl;
              writing-mode: vertical-rl;
              transform: rotate(180deg);
              white-space: nowrap;
            }
          </style>
          @endsection
