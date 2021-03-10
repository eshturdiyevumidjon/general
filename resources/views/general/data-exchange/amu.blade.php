@extends('general.layouts.layout')
@section('content')
    <main id="main" class="py-3">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col">
                            <h6 class="text-uppercase font-weight-bold" style="color: #007bff;">{{ trans('messages.Data exchange') }}</h6>
                        </div>
                    </div>
                    <!-- search form -->
                    <form action="{{ route('general.exchange-index-post') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-3">
                                <select required class="form-control form-control-sm form_class" name="form" >
                                    <option value="">{{ trans('messages.Select') }}</option>
                                    @foreach($forms as $key => $value)
                                        <option @if($form_id == $key) selected="selected" @endif value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="col-3">
                                <select required class="form-control form-control-sm" name="elements" id="elements_form">
                                    <option value="">{{ trans('messages.Select') }}</option>
                                    @foreach($elements as $key => $value)
                                        <option @if($element == $key) selected="selected" @endif value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                        
                            <div class="col-auto">
                                <input required type="month" name="month" value="{{ $month }}" class="form-control form-control-sm">
                            </div>
                        
                            <div class="col-auto">
                                <button class="btn btn-sm btn-primary" type="submit">
                                    <i class="fa fa-filter"></i>
                                    {{ trans('messages.Open') }}
                                </button>
                            </div>

                            <!-- <div class="col-auto ml-auto">
                                <button type="button" id="btnClick" class="btn btn-info btn-sm ml-3">{{ trans('messages.Export') }}</button>
                            </div> -->
                        </div>
                    </form>
                    <!-- end search form -->
                </div>
                <div class="card-body">
                    <div class="table-responsive" style="max-height: 65vh; width: 100%;">
                        <table class="table table-bordered">
                            @if(!empty($formObjects))
                            <thead>
                            <tr>
                                <div id="graph-content" style="display:none; ">
                                    <button class="btn btn-info btn-sm" id="close-graph" title="Закрыть график">{{ trans('message.Close') }}</button>
                                    <div id="chartContainer" style="height: 400px; width: 100%;"></div><br>
                                </div>
                            </tr>
                            <tr class="bir">
                                <!-- <th><input type="checkbox" id="markAll" value="1"></th> -->
                                <th rowspan="3"><span>Число</span></th>
                                @foreach($formObjects as $index => $sirdForm)
                                <?php
                                    $resTitle = $sirdForm['object']['name'];
                                    $colspan = 2;
                                    if(count($formObjects) > $index + 1) {
                                        $next = $formObjects[$index + 1];
                                        if($next['order_number'] == $sirdForm['order_number'] ) {
                                            $resTitle = explode(' ', $sirdForm['object']['name'])[0];
                                            $colspan = 4;
                                        }
                                    }

                                    $isHave = false;
                                    if($index > 0) {
                                        $old = $formObjects[$index - 1];
                                        if($old['order_number'] == $sirdForm['order_number'] ) {
                                            $resTitle = $old['order_number'] . ' - ' . $sirdForm['order_number'];
                                            $isHave = true;
                                        }
                                    }
                                ?>
                                    <?php if(!$isHave) { ?>
                                    <th colspan="{{$colspan}}" style="text-align: center!important;"><?php echo $resTitle ?></th>
                                  <?php } ?>
                                @endforeach
                            </tr>
                            <tr class="bir">
                                @foreach($formObjects as $form)
                                <?php $title = 'расход , м3/с'; if($form['object']['unit_id'] == 4) $title = 'уровен , см'; ?>
                                    <td colspan="2" style="text-align: center!important;">{{ $title }}</td>
                                @endforeach
                            </tr>
                            <tr class="bir">
                                @foreach($formObjects as $form)
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
                                        ?>
                                        <td>                                                
                                            {{ isset($result[$key]) ? $result[$key] : null }}
                                        </td>
                                        <td>
                                            {{ isset($result[$key . '_sr']) ? $result[$key . '_sr'] : null }}
                                        </td>
                                    @endforeach
                                  </tr>
                                @endfor
                            </tbody>
                            @else
                                <tr>
                                    <td class="text-center">
                                        {{ trans('messages.Datas not found') }}
                                    </td>
                                </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

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

            },error:function (data) {
              alert(data);
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
