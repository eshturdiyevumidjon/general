@extends('general.layouts.layout')
@section('content')
<main id="main" class="py-3">
    <div class="container">
        <div class="row my-3">
            <div class="col-3">
                <div class="card text-white bg-danger">
                    <div class="card-body text-center">
                        <h3 class="card-title">{{ 1 }}</h3>
                        <p class="card-text">{{ trans('messages.Gidromet') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card text-white bg-success">
                    <div class="card-body text-center">
                        <h3 class="card-title">{{ 2 }}</h3>
                        <p class="card-text">{{ trans('messages.Minvodxoz') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-3">
                <div class="card text-white bg-warning">
                    <div class="card-body text-center">
                        <h3 class="card-title">{{ 3 }}</h3>
                        <p class="card-text">{{ trans('messages.Gidrogeologiya') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('css')
<style type="text/css">
    .card {
        box-shadow: 5px 5px grey;
    }
</style>
@endsection