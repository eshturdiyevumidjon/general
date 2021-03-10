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
                    <div class="table-responsive tableFixHead">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="bir">
                                    <th><input type="checkbox" id="markAll" value="1"></th>
                                    <th>{{ trans('messages.Name') }}</th>
                                    <th>{{ trans('messages.Cadaster number') }}</th>
                                    <th>{{ trans('messages.Groundwater resource') }}</th>
                                    <th>{{ trans('messages.Reserve') }}</th>
                                    <th>{{ trans('messages.Year') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($allDatas as $data)
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="object[]" class="gr-obj-class" data-status="0" data-name="{{ $data['name'] }}" value="{{ $data['name'] }}">
                                        </td>
                                        <td>{{ $data['name'] }}</td>
                                        <td>{{ $data['code'] }}</td>
                                        <td>{{ $data['groundwater_resource'] }}</td>
                                        <td>{{ $data['selection_from_approved_groundwater_reserves'] }}</td>
                                        <td>{{ $data['year'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
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
