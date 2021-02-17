@extends('general.layouts.layout')
@section('content')

<main id="main" class="py-3">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">

        <div class="table-responsive">

          <form method="post" action="{{ URL("/minvodxoz/metka/update") }}" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="group_id" value="{{ $group_id }}">

            <ul class="nav nav-tabs">
              @foreach($language as $key=>$lang)
              <li @if($key == 0) class="active"  @endif><a   class="btn btn-inverse-info" data-toggle="tab" href="#{{  $lang->language_prefix.$lang->id }}">{{ $lang->language_prefix }}</a></li>
              @endforeach
            </ul>

            <div class="tab-content">
              @foreach($language as $key=>$lang)
              <?php $el = \App\Http\Controllers\MetkiController::getelement($group_id,$lang->id) ?>
              @if($el)
              <input type="hidden" name="language_id[]" value="{{ $lang->id }}" />
              <div id="{{  $lang->language_prefix.$lang->id }}" class="tab-pane fade @if($key==0) active show  @endif" style="margin-top: 15px;">
                <div class="form-group">
                  <div>
                    <label for="mark_name">Названия</label>
                    <input type="text" name="mark_name[]" value="{{ $el->mark_name ?? '' }}" id="mark_name" class="form-control" />
                    {{-- <textarea name="mark_name[]" id="mark_name"  rows="40" class="form-control">{!! $el->mark_name ?? "" !!} </textarea> --}}
                  </div>
                </div>
              </div>
              @endif
              @endforeach
            </div>

            <br/>

            <button class="btn btn-outline-primary btn-fw" type="submit">Сохранить</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>

@endsection
