@extends('general.layouts.layout')
@section('content')
    <main class="py-3" id="main">
        <div class="container-fluid">

<div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">





                  <div class="table-responsive">


                      <form method="post" action="{{ URL("/minvodxoz/language/add") }}">
                          <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <div class="form-group">
                          <div>
                              <label for="language_name">Названия </label>
                              <input name="language_name" id="language_name" class="form-control">
                          </div>

                          <div>
                              <label for="language_prefix">Префикс</label>
                              <input name="language_prefix" id="language_prefix" class="form-control">
                          </div>
                      </div>

                        <button class="btn btn-success" type="submit">Сохранить</button>

                      </form>
                  </div>
                </div>
              </div>
            </div>



</div>
    </main>
@endsection
