@extends('general.layouts.layout')

@section('content')
    <main id="main" class="py-3 " style="background-color: rgba(132, 142, 160, 0.03) !important">
        <div class="container mb-4">
            <div class="card pb-3 ">
                <div class="card-header">
{{--                    Поиск (Ежедневные данные)<button type="button" class="btn float-md-right p-1 btn-info btn-lg" style="font-size: 14px !important;" data-toggle="modal" data-target="#myModal">Загрузка объекта</button>--}}
                </div>
                <div class="card-body">

                    <form action="{{route('general.getinfo')}}" method="get">
                        <div class="col-md-12 d-inline-flex ">
                            <div class="col-md-4 ">
                                <label>Дата</label>
                                <input required v-model="date" type="month" name="month"   class="form-control">
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

                                            <td  >


                                                <input type="number" step="0.01"  class="form-control object-day-value " style="width: 100px !important; font-size: 14px; !important;"
                                                       data-id="{{ $item->id }}"
                                                       data-form-id=""
                                                       data-object-id=""
                                                       name="date_info"
                                                       value="{{ $item->value }}">

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

        $(document).ready(function(){
            $('.object-day-value').on('change',function(){
                {{--$.ajaxSetup({--}}
                {{--    headers: {--}}
                {{--        'Accept':'application/json',--}}
                {{--        'Content-Type':'application/json',--}}
                {{--        'token':'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjkxNjViZGQ4NDg5NDM1ZjdkNWJmMDFhOTUwZTllMmE3ZGEyY2ExMDljYjc1MmFmNWY5NzdmOGZlNGYzM2Q4NDYwOGYxNTY2ZGFiOTEzYjUzIn0.eyJhdWQiOiIxIiwianRpIjoiOTE2NWJkZDg0ODk0MzVmN2Q1YmYwMWE5NTBlOWUyYTdkYTJjYTEwOWNiNzUyYWY1Zjk3N2Y4ZmU0ZjMzZDg0NjA4ZjE1NjZkYWI5MTNiNTMiLCJpYXQiOjE1NjgyOTEwMzYsIm5iZiI6MTU2ODI5MTAzNiwiZXhwIjoxNTk5OTEzNDM2LCJzdWIiOiI2Iiwic2NvcGVzIjpbXX0.Arg5hK5rWH4qqGj6AQ1vwNFrSV0QMaDBD8XZXpXk8zgBca0DJh_wN0toWmwGWCGKfvtBP7ZwA9_LQr8idpELzGTV-5ZKSsD-aor0g_tK7ysd786rtKKH78UI2BFDRzxxOetT4FMZhZoLZNjVRgSVFr3evwHtumbzdIBOxdJyJ0kv4K2grHdw0oBi0bG9wIyOX1tKyV9qF3cPiwsrOU6-HDU9L7lVTB7MCWqqaw0CV87GqyK89XkEHWtJhFhwi4WdaewDUJxItZ9Uf2PGmo3c7wG1xcB6b-dOepw72yEdtOuWmrbyXprwLBpPd2I4mTOsxSsu5BRB2wR7ZnuizLGak2LuK99Mdr6nNJPfW5goXw5wcfL5wGQlXtmgsV55s_fyGgS9hVMRJbPjdWV_D8eVwBhHV1kuIHww_8BgBh-u2sJqpsM_HQ2RrhqytMWLV9QF8Nw-KWW2mjDi5Q7ahUHK2Zqwxu5HNQ7dK5M7ZaIEBSDFGmPkJ_h7Ad7XefZUJXEqyLG2fBVumGd4s58vtGJYVH0cLPvqpzG2IujDKQwvRqizGYtcBT11bJn-wTg9f5U1UCIAkv0zcw37xXvfAKEtHHgPZo09UE_EyLVzpEUXt3rj02vh-PEgLgxjBRYiLRUD1K8zTYaZUpYWmgejXGDbO3n_HnXQKBV-YCdqTUYHiWo'--}}
                {{--    }--}}
                {{--});--}}
                {{--$.ajax({--}}

                {{--    'url':"{{ url('http://192.168.0.106/api/post-value')  }}",--}}
                {{--    headers: {--}}
                {{--        'Accept':'application/json',--}}
                {{--        'Content-Type':'application/json',--}}
                {{--        'token':'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjkxNjViZGQ4NDg5NDM1ZjdkNWJmMDFhOTUwZTllMmE3ZGEyY2ExMDljYjc1MmFmNWY5NzdmOGZlNGYzM2Q4NDYwOGYxNTY2ZGFiOTEzYjUzIn0.eyJhdWQiOiIxIiwianRpIjoiOTE2NWJkZDg0ODk0MzVmN2Q1YmYwMWE5NTBlOWUyYTdkYTJjYTEwOWNiNzUyYWY1Zjk3N2Y4ZmU0ZjMzZDg0NjA4ZjE1NjZkYWI5MTNiNTMiLCJpYXQiOjE1NjgyOTEwMzYsIm5iZiI6MTU2ODI5MTAzNiwiZXhwIjoxNTk5OTEzNDM2LCJzdWIiOiI2Iiwic2NvcGVzIjpbXX0.Arg5hK5rWH4qqGj6AQ1vwNFrSV0QMaDBD8XZXpXk8zgBca0DJh_wN0toWmwGWCGKfvtBP7ZwA9_LQr8idpELzGTV-5ZKSsD-aor0g_tK7ysd786rtKKH78UI2BFDRzxxOetT4FMZhZoLZNjVRgSVFr3evwHtumbzdIBOxdJyJ0kv4K2grHdw0oBi0bG9wIyOX1tKyV9qF3cPiwsrOU6-HDU9L7lVTB7MCWqqaw0CV87GqyK89XkEHWtJhFhwi4WdaewDUJxItZ9Uf2PGmo3c7wG1xcB6b-dOepw72yEdtOuWmrbyXprwLBpPd2I4mTOsxSsu5BRB2wR7ZnuizLGak2LuK99Mdr6nNJPfW5goXw5wcfL5wGQlXtmgsV55s_fyGgS9hVMRJbPjdWV_D8eVwBhHV1kuIHww_8BgBh-u2sJqpsM_HQ2RrhqytMWLV9QF8Nw-KWW2mjDi5Q7ahUHK2Zqwxu5HNQ7dK5M7ZaIEBSDFGmPkJ_h7Ad7XefZUJXEqyLG2fBVumGd4s58vtGJYVH0cLPvqpzG2IujDKQwvRqizGYtcBT11bJn-wTg9f5U1UCIAkv0zcw37xXvfAKEtHHgPZo09UE_EyLVzpEUXt3rj02vh-PEgLgxjBRYiLRUD1K8zTYaZUpYWmgejXGDbO3n_HnXQKBV-YCdqTUYHiWo'--}}
                {{--    },--}}
                {{--    'method':'POST',--}}
                {{--    'data':{--}}
                {{--        information_id:$(this).attr('data-id'),--}}
                {{--        value:$(this).val(),--}}
                {{--    },success:function (data) {--}}

                {{--        /* $('#alert-div').append('<div id="not-'+data.id+'" class="alert alert-success">'+data.msg+': '+data.val+'</div>');--}}
                {{--         setTimeout(function(){ $('#not-'+data.id).hide(); }, 5000);*/--}}
                {{--    },error:function (data) {--}}
                {{--        console.log(data);--}}
                {{--    }--}}
                {{--})--}}

                var markers = [{
                    information_id:$(this).attr('data-id'),
                    value:$(this).val(),
                }];

                $.ajax({
                    type: "POST",
                    url: "http://213.230.126.118:8080/api/post-value",
                    // The key needs to match your method's input parameter (case-sensitive).
                    data: JSON.stringify({
                        information_id:$(this).attr('data-id'),
                        value:$(this).val(),
                    }),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function(data){},
                    failure: function(errMsg) {
                        alert(errMsg);
                    }
                });
            });
        });


    </script>
@endsection
