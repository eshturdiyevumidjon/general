@extends('layouts.app')

@section('content')

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card my-5">
        <div class="card-body row justify-content-center">
          <img class="float-left align-self-middle mr-3" src="{{asset('img/Flag-Gerb-1.jpg')}}" alt="main-img" width="70" height="50" />
          <h5 class="font-weight-bold">ГОСУДАРСТВЕННЫЙ ВОДНЫЙ КАДАСТР<br />РЕСПУБЛИКИ УЗБЕКИСТАН</h5>
        </div>
      </div>
      <div class="card">
        {{-- <div class="card-header">{{ __('Login') }}</div> --}}

        <div class="card-body container">
          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group row justify-content-center">
              <div class="col-md-8">
                <h4>Введите данные для входа</h4>
              </div>
            </div>
            <div class="form-group row justify-content-center">
              <div class="col-md-8">
                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="{{ getLocaleValue("Имя пользователя") }}">

                @error('email')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row justify-content-center">
              <div class="col-md-8">
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="{{ getLocaleValue("Пароль") }}">

                @error('password')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="form-group row">
              <div class="col-md-4 offset-md-2">
                <div class="custom-control custom-checkbox">
                  <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                  <label class="custom-control-label" for="remember">
                    {{ getLocaleValue("Запомнить") }}
                  </label>
                </div>
              </div>
              <div class="col-md-4 text-right">
                <button type="submit" class="btn btn-primary py-1 px-3">
                  {{ getLocaleValue("Вход") }}
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('css')
<style type="text/css">
  .card {
    background-color: #B2D6E3;
    box-shadow: 5px 5px 10px #0083b4;
  }
  h4, h5 {
    color: #0079ca;
  }
</style>
@endsection
