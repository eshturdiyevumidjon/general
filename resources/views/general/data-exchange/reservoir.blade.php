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
{{--                <a class="btn btn-danger btn-sm" href="{{ route( 'general.get-reservoir-form', ['year' => $r_year, 'elements' => $postAttr['elements'], 'form' => $postAttr['form'], 'month' => $postAttr['month'] ] ) }}">{{ $metki->where('id_column','Форма')->first() ? $metki->where('id_column','Форма')->first()->only('mark_name')['mark_name'] : 'Форма' }}</a>--}}
                @endif
              </div>
            </div>
          </form>
					<!-- end search form -->
                </div>
      <div class="card-body">
        <div class="table-responsive tableFixHead">
          <table class="table table-bordered">
            @if($year)
            <thead>
              <tr class="bir">
                <th rowspan="3"><input type="checkbox" id="markAll" value="1"></th>
                <th rowspan="3">{{ $metki->where('id_column','Наименование')->first() ? $metki->where('id_column','Наименование')->first()->only('mark_name')['mark_name'] : 'Наименование' }}</th>
                <th colspan="36">{{ $year }}</th>
              </tr>
              <tr class="ikki">
                <?php for($m = 1; $m <= 12; $m++) { ?>
                <th colspan="3">{{ App\Components\Month::name($m) }}</th>
                <?php } ?>
              </tr>
              <tr class="uch">
                <?php for($m = 1; $m <= 12; $m++) { ?>
                <th><div style="width: 60px;">I</div></th>
                <th><div style="width: 60px;">II</div></th>
                <th><div style="width: 60px;">III</div></th>
                <?php } ?>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($reservoir as $form) {
                ?>
                <tr>
                  <td>
                    <input type="checkbox" name="object[]" class="gr-obj-class" data-status="0" data-name="{{ $form['object']['name'] }}" value="{{ $form['object']['id'] }}">
                  </td>
                  <td><pre>{{ $form['object']['name'] }}</pre></td>
                  <?php
                  for($i = 1; $i <= 12; $i++) {
                    echo '<td>' . $stek[$form['object']['id'] . '_' . getMonthName($i)  . '_1']  . '</td>';
                    echo '<td>' . $stek[$form['object']['id'] . '_' . getMonthName($i)  . '_2']  . '</td>';
                    echo '<td>' . $stek[$form['object']['id'] . '_' . getMonthName($i)  . '_3']  . '</td>';
                  } ?>
                </tr>
                <?php } ?>
              </tbody>
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
          {{-- $.ajax({--}}

          {{--  'url':"{{ route ('ajax-select-element') }}",--}}
          {{--  'method':'POST',--}}
          {{--  'data':{--}}
          {{--    value:$(this).val(),--}}
          {{--  },success:function (data) {--}}
          {{--    $( "#elements_form" ).html( data);--}}
          {{--  },error:function () {--}}
          {{--    alert('ajax error');--}}
          {{--  }--}}
          {{--})--}}
         });

         $('.object-day-value').on('change',function(){
           $.ajaxSetup({
             headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
           });
           $.ajax({

            'url':"{{ route ('add-object-info-ajax') }}",
            'method':'POST',
            'data':{
              id:$(this).attr('data-id'),
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
              year : @if($year ){{ $year }} @else null @endif,
              selects : selected.join(",")
            }
            var url = "http://213.230.126.118:8080/export-decadares-gidromet?" + $.param(query)
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
              height: 11px;
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
          </style>
          @endsection
