@extends('general.layouts.layout')

@section('content')
<main class="py-3" id="main">
  <div class="container-fluid">
    <div class="row float-right mb-3">
      <div class="col-auto">
        <a href="{{ URL("minvodxoz/metka/add") }}" class="btn btn-sm btn-primary">Добавить</a>
        <a href="{{ URL("minvodxoz/metka/list") }}" class="btn btn-sm btn-primary">LIST</a>
      </div>
    </div>
    <div class="clearfix"></div>
    
    <div class="table-responsive">
      <table class="table table-sm small table-bordered ">
        <thead>
          <tr>
            <th>#</th>
            <th>Метка</th>
            <th>Действия</th>
          </tr>
        </thead>

        <tbody>
          @foreach ($table as $key=>$item)
          <tr>
            <td>{{ $key +1}}</td>
            <td> {{ $item->mark_name }}</td>
            <td>
              <span><a class="btn btn-sm btn-outline-success" href="{{ URL("minvodxoz/metka/update/".$item->group_id) }}" data-toggle="tooltip" title="Редактировать">Редактировать</a></span>
              <span><a class="btn btn-sm btn-outline-danger" href="{{ URL("minvodxoz/metka/delete/".$item->group_id) }}" data-toggle="tooltip" title="Удалить">Удалить</a></span>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {{ $table->links() }}
    </div>
  </div>
</main>
@endsection
