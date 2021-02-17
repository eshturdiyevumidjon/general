@php

  $lang_id = \App\language::where('language_prefix', app()->getLocale())->first();
        if(isset($lang_id))
            $metki  = \App\Metki::where('language_id', $lang_id->id)->get();
            else
            $metki  = \App\Metki::where('language_id', 3)->get();
@endphp
<!DOCTYPE html>
<html lang="ru">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}"  crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('css/bootstrap-select.min.css')}}">

    <title>ГОСУДАРСТВЕННЫЙ ВОДНЫЙ КАДАСТР РЕСПУБЛИКИ УЗБЕКИСТАН</title>

    <!-- font awesome -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">

    <!-- Roboto fonts -->
    <link href="{{asset('css/fonts.css')}}" rel="stylesheet">
    <link href="{{asset('css/jquery.growl.css')}}" rel="stylesheet">
    <link href="{{asset('css/tableexport.min.css')}}" rel="stylesheet"  crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/docs.css')}}">
    <link rel="stylesheet" href="{{asset('css/flag-icon.css')}}">
    <script src="{{asset('js/Chart.js')}}"></script>
    <script src="{{asset('js/chartjs-plugin-doughnutlabel.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/Chart.css')}}">


    <!-- custom css -->
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    @yield('css')
    <style>
      .sticky {
        position: fixed;
        top: 0;
        width: 100%;
      }
    </style>

  </head>
  <body id="root">
    <header id="header" class="bg-primary">
      @include('blocks.header')
    </header>

    <div class="position-relative">
      <!-- Sidebar navigation -->
      <div id="sidebar">
        @include('blocks.sidebar')
      </div>

      <div id="myContent">
        @yield('content')
      </div>
      @yield('modal')

      {{-- <div id="alert-div" style="position: fixed !important; bottom: 20px !important; right: 30px !important;">

      </div> --}}
    </div>
    <!-- container-fluidOptional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="{{asset('js/jquery-3.2.1.min.js')}}" crossorigin="anonymous"></script>
    <script src="{{asset('js/docs.js')}}" ></script>

    <script src="{{asset('js/jquery.growl.js')}}"></script>
    <script src="{{asset('js/popper.min.js')}}"  crossorigin="anonymous"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"  crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js" crossorigin="anonymous"></script>

    <!-- Awesome svg icons -->
    <script defer src="{{asset('js/all.js')}}"  crossorigin="anonymous"></script>
    <!-- custom js -->
    <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
    <!-- (Optional) Latest compiled and minified JavaScript translation files -->

    <!-- Awesome svg icons -->
    <script src="{{asset('js/main.js')}}"></script>
    <script src="{{asset('js/vue.js')}}"></script>

    <script src="{{asset('js/axios.min.js')}}"></script>

    @yield('scripts')
    <script>

      let sidebar = new Vue({
        el: "#sidebar",

        data() {
          return {
            isShown1: false,
            isShown2: false,
            isShown3: false,
            isShown4: false,
            langs: false,
          }
        },

        mounted() {
          if(sessionStorage.getItem("isShown1")) {
            this.isShown1 = JSON.parse(sessionStorage.getItem("isShown1"));
          }
          if(sessionStorage.getItem("isShown2")) {
            this.isShown2 = JSON.parse(sessionStorage.getItem("isShown2"));
          }
          if(sessionStorage.getItem("isShown3")) {
            this.isShown3 = JSON.parse(sessionStorage.getItem("isShown3"));
          }
          if(sessionStorage.getItem("isShown4")) {
            this.isShown4 = JSON.parse(sessionStorage.getItem("isShown4"));
          }
          if(sessionStorage.getItem("langs")) {
            this.langs = JSON.parse(sessionStorage.getItem("langs"));
          }
        },

        methods: {
          persist(key) {
            if (key == 'isShown1') {
              this.isShown1 = !this.isShown1;
              sessionStorage.setItem(key, this.isShown1);
              sessionStorage.setItem("isShown2", false);
              sessionStorage.setItem("isShown3", false);
              sessionStorage.setItem("isShown4", false);
            } else if (key == 'isShown2') {
              this.isShown2 = !this.isShown2;
              sessionStorage.setItem("isShown1", false);
              sessionStorage.setItem(key, this.isShown2);
              sessionStorage.setItem("isShown3", false);
              sessionStorage.setItem("isShown4", false);
            } else if (key == 'isShown3') {
              this.isShown3 = !this.isShown3;
              sessionStorage.setItem("isShown1", false);
              sessionStorage.setItem("isShown2", false);
              sessionStorage.setItem(key, this.isShown3);
              sessionStorage.setItem("isShown4", false);
            } else if (key == 'isShown4') {
              this.isShown4 = !this.isShown4;
              sessionStorage.setItem("isShown1", false);
              sessionStorage.setItem("isShown2", false);
              sessionStorage.setItem("isShown3", false);
              sessionStorage.setItem(key, this.isShown4);
            }
            else if(key == 'langs')
            {
              this.langs = !this.langs;
              sessionStorage.setItem("isShown1", false);
              sessionStorage.setItem("isShown2", false);
              sessionStorage.setItem("isShown3", false);
              sessionStorage.setItem("isShown4", false);
              sessionStorage.setItem(key, this.langs);
            }
            else {
              sessionStorage.setItem("isShown1", false);
              sessionStorage.setItem("isShown2", false);
              sessionStorage.setItem("isShown3", false);
              sessionStorage.setItem("isShown4", false);
              sessionStorage.setItem("langs", false);
            }
          }
        },
      });

    </script>

  </body>
  </html>
