@extends('general.layouts.layout')
@section('content')
    <main class="py-3" id="main">
        <div class="container-fluid">

<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">


                <a href="{{ route('minvodxoz.langs.add') }}" class="card-title btn btn-succses"><i class="mdi mdi-table-row-plus-before"></i>Добавить</a>


                  <div class="table-responsive">
                  <table class="table .table-striped">
    <thead>
        <tr>
            <td>#</td>
            <td>Названия</td>
            <td>префикс</td>
            <td>действия</td>
        </tr>
    </thead>

        <tbody>
            @foreach ($table as $key=>$item)
        <tr>
            <td>{{ $key +1}}</td>
            <td> {{ $item->language_name }}</td>
            <td> {{ $item->language_prefix }}</td>
            <td>
                <a class="btn btn-success" href="{{ URL("minvodxoz/language/update/".$item->id) }}" data-toggle="tooltip" title="Редактировать"><i class=" mdi mdi-lead-pencil "></i>Редактировать</a>
{{--                <a class="btn btn-danger" id="conf" href="{{ URL("minvodxoz/language/delete/".$item->id) }}" data-toggle="tooltip" title="Удалить"><i class="mdi mdi-delete-forever"></i>удалить</a>--}}
            </td>
        </tr>



@endforeach
        </tbody>
</table>
                  </div>
                </div>
              </div>
            </div>



</div>
    </main>
@endsection
