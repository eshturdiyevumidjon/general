<div id="my-top-menu" class="container-fluid">
  <div class="row align-items-center py-2">
    <div class="col-auto border-right border-white">
      <button id="mainToggle" class="btn px-0" onclick="openNav()">
        <img class="float-left align-self-middle" src="{{asset('img/Flag-Gerb-1.jpg')}}" alt="" width="70" height="50" />
      </button>
      <h1 style="cursor: pointer" onclick="window.location.href='{{ route('general.dashboard') }}'" class="text-white font-weight-bold float-right ml-2 my-1">{{ trans("messages.GVK RUZ") }}</h1>
    </div>
    <div style="cursor: pointer" onclick="window.location.href='{{route('general.dashboard')}}'" class="text-white col-auto">
      <h3 class="font-weight-bold">{{ trans("messages.Unified Water Cadastre") }}</h3>
      <p>{{ trans("messages.Common base") }}</p>
    </div>
    <div class="col-auto ml-auto">
      @php
      $languages = \App\Models\Additional\Language::all();
      @endphp
      <form class="my-auto" action="{{route('minvodxoz.lang.set')}}">
        <select class="custom-select custom-select-sm" name="lang" onchange="this.form.submit()" >
          @foreach($languages as $lang)
          <option {{ $lang->language_prefix == app()->getLocale() ? 'selected' : '' }}>{{$lang->language_prefix}}</option>
          @endforeach
        </select>
      </form>
    </div>
    <div class="col-auto px-1">
      <a class="btn btn-primary" href="{{ route('general.map') }}"><i class="fas fa-map fa-lg"></i> {{ trans("messages.Map") }}</a>
    </div>
    @if(\Auth::user()->role->name == 'Administrator')
    <div class="col-auto px-1">
      <a class="btn btn-primary" href="{{ route('general.admin') }}"><i class="fas fa-cog fa-lg"></i></a>
    </div>
    @endif

    <div class="col-auto px-1">
      <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-user-circle fa-2x"></i>
      </button>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
        @if(\Illuminate\Support\Facades\Auth::user())
        <p class="dropdown-item fullname font-weight-bold">{{\Illuminate\Support\Facades\Auth::user()->firstname}} {{\Illuminate\Support\Facades\Auth::user()->lastname}}</p>
        <p class="dropdown-item fullname">{{\Illuminate\Support\Facades\Auth::user()->email}}</p>
        @endif
        <br />
        <a class="dropdown-item" href="#"><i class="fas fa-lock text-primary"></i> {{ trans("messages.Change password") }}</a>
        <a class="dropdown-item btn btn-primary" href="{{route('logout')}}"><i class="fas fa-sign-out-alt fa-lg text-primary"></i> {{ trans("messages.Logout") }}</a>
      </div>
    </div>
  </div>
</div>
