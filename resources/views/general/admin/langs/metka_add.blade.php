@extends('general.layouts.layout')
@section('content')

<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">





                  <div class="table-responsive">


                      <form method="post" action="{{ URL("/minvodxoz/metka/add") }}" enctype="multipart/form-data">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">

                          <ul class="nav nav-tabs">
                              @foreach($language as $key=>$lang)


                              <li @if($key == 0) class="active"  @endif><a   class="btn btn-inverse-info" data-toggle="tab" href="#{{  $lang->language_prefix.$lang->id }}">{{ $lang->language_prefix }}</a></li>
                                  @endforeach

                          </ul>

                          <div class="tab-content">

                              @foreach($language as $key=>$lang)

                                  <input type="hidden" name="language_id[]" value="{{ $lang->id }}">

                              <div id="{{  $lang->language_prefix.$lang->id }}" class="tab-pane fade @if($key==0) active show  @endif " style="margin-top: 15px;">

                                  <div class="form-group">
                                      <div>
                                          <label for="mark_name">Названия</label>



                                          <textarea name="mark_name[]" id="mark_name"  rows="10" class="form-control"> </textarea>
                                      </div>

                                  </div>

                              </div>
                              @endforeach


                          </div>
                          <div>
                              <label for="mark_name">Ид</label>
                              <input name="id_column" id="id_column"  class="form-control">
                          </div>

                          </br>



                        <button class="btn btn-outline-primary btn-fw" type="submit">Сохранить</button>

                      </form>
                  </div>
                </div>
              </div>
            </div>




@endsection
