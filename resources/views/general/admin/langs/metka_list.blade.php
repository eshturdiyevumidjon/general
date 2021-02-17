@extends('general.layouts.layout')
@section('content')

<main class="py-3" id="main">
  <div class="container-fluid">
    <div class="row mb-3 justify-content-between">
      <div class="col-auto">
        <a href="#" data-toggle="modal" data-target="#myModal"  class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Добавить</a>
      </div>
      <div class="col-auto">
        @include('partials.alerts')
      </div>
      <div class="col-auto">
        <button type="submit" onclick="document.getElementById('allUpload').submit()" class="btn btn-sm btn-success float-right">Сохранить</button>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table table-sm small table-bordered table-striped">
        <thead>
          <tr>
            <th>#</th>
            <th>key</th>

            @foreach($language as $key=>$lang)
            <th> Метка: {{ $lang->language_prefix }}</th>
            @endforeach
            <th>Действия</th>
          </tr>
          <tr>
            <form id="searchForm" action="{{ route('general.metki.search') }}" method="post" role="search">
              @csrf
              <td></td>
              <td>
                <input type="text" name="search1" value="{{ request()->search1 ?? '' }}" class="form-control form-control-sm">
              </td>
              <td>
                <input type="text" name="search2" value="{{ request()->search2 ?? '' }}" class="form-control form-control-sm">
              </td>
              <td>
                <input type="text" name="search3" value="{{ request()->search3 ?? '' }}" class="form-control form-control-sm">
              </td>
              <td>
                <input type="text" name="search4" value="{{ request()->search4 ?? '' }}" class="form-control form-control-sm">
              </td>
              <td>
                <button class="btn btn-sm btn-outline-info" type="submit">Поиск</button>
              </td>
            </form>
          </tr>
        </thead>
        <tbody>
          @foreach($table as $row => $tb)
          <tr class="">
            <form id="allUpload" method="post" action="{{ route('general.metki.update.all') }}">
              @csrf
              <td class="align-middle">{{ $row + 1 }}</td>
              <td class="align-middle">{{$tb->id_column}}</td>
              @foreach($language as $key=>$lang)
              @php
              $el = \App\Metki::where("group_id", $tb->group_id)->where("language_id", $lang->id)->first();
              @endphp
              <td>
                <input type="hidden" name="language_id[]" value="{{ $lang->id ?? "" }}">
                <input type="hidden" name="group_id[]" value="{{ $el->group_id ?? "" }}">
                <input class="form-control form-control-sm" type="text" onchange="document.getElementById('allUpload').submit()" name="mark_name[]" value="{{ $el->mark_name ?? '' }}" /> 
              </td>
              @endforeach
            </form>
            <td>
              <a class="btn btn-outline-danger btn-sm" onclick="return confirm('А Вы уверены?');" href="{{ route('general.metki.delete', $el->group_id) }}">Удалить</a>
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

@section('modal')
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form  method="post" action="{{route('general.metki.addmetka')}}" class="modal-content">
      @csrf
      <div class="modal-header bg-primary text-white">
        <h4 class="modal-title" id="exampleModalLabel">форма добавления</h4>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="tab-pane fade show active" id="nav-ru" role="tabpanel" aria-labelledby="nav-ru-tab">
          <table id="" class="table table-sm table-striped table-bordered adding-forms">
            <tbody>
              <tr>
                <th scope="row">Название метка</th>
                <td class="form-group">
                  <input id="myInput" type="text" name="name" class="form-control form-control-sm" />
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Закрыть</button>
        <input  type="submit" class="btn btn-sm btn-primary" value="Сохранить" />
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
  $('#myModal').on('shown.bs.modal', function () {
    $('#myInput').focus()
  })
</script>
@stop
