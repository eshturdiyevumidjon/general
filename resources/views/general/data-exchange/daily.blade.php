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

                            <div class="col-auto ml-auto">
                                <button type="button" id="btnClick" class="btn btn-info btn-sm ml-3">{{ trans('messages.Export') }}</button>
                            </div>
                        </div>
                    </form>
					           <!-- end search form -->
                </div>

                <div class="card-body">
                    <div class="table-responsive" style="max-height: 65vh; width: 100%;">
                        <table class="table table-bordered">
                            @if(!empty($allDatas))
                                <thead>
                                    <tr>
                                        <div id="graph-content" style="display:none; ">
                                            <button class="btn btn-info btn-sm" id="close-graph" title="Закрыть график">
                                                {{ trans('messages.Close') }}
                                            </button>
                                            <div id="chartContainer" style="height: 400px; width: 100%;"></div><br>
                                        </div>
                                    </tr>
                                    <tr class="bir">
                                        <th rowspan="2"><span>Число</span></th>
                                        @foreach($firstData as $data)
                                        <?php $colspan = 0; if($data['formObjectMorning']) $colspan++; if($data['formObjectPresent']) $colspan++; ?>
                                            <th colspan="{{$colspan}}" style="text-align: center!important;">{{ $data['object_name'] }}</th>
                                        @endforeach
                                    </tr>
                                    <tr class="bir">
                                        @foreach($firstData as $data)
                                            <?php if($data['formObjectMorning']) {?><td style="text-align: center!important;">08 часов</td><?php } ?>
                                            <?php if($data['formObjectPresent']) {?><td style="text-align: center!important;">ср</td><?php } ?>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $satr = 0; ?>
                                    @foreach($allDatas as $dayData)
                                    <?php $satr++; ?>
                                    <tr>
                                        <td>{{ $satr }}</td>
                                        @foreach($dayData as $data)
                                            <?php if($data['formObjectMorning']) {?><td style="text-align: center!important;">{{ $data['morning'] }}</td><?php } ?>
                                            <?php if($data['formObjectPresent']) {?><td style="text-align: center!important;">{{ $data['present'] }}</td><?php } ?>
                                        @endforeach
                                    </tr>
                                    @endforeach
                                </tbody>
                            @else
                                <tr>
                                    <td class="text-center">{{ trans('messages.Datas not found') }}</td>
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
         });

         $('.object-day-value').on('change',function(){
           $.ajaxSetup({
             headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
           });
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
