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

  <title></title>

  <!-- font awesome -->
  <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">

  <!-- Roboto fonts -->
  <link href="{{asset('css/fonts.css')}}" rel="stylesheet">
  <link href="{{asset('css/jquery.growl.css')}}" rel="stylesheet">


  <!-- custom css -->
  <link rel="stylesheet" href="{{asset('css/style.css')}}">

  @yield('css')
</head>
<body id="root">
  <header id="header" class="bg-primary">
    @include('general.blocks.header')
  </header>

  <div class="position-relative" style="min-height: calc(100vh - 80px);">
    <!-- Sidebar navigation -->
    <div id="sidebar" class="sidebar" style="display: block;">
      @include('general.blocks.sidebar')
    </div>

    <div>
      @yield('content')
    </div>
    @yield('modal')
  </div>
  <!-- container-fluidOptional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

  <script src="{{asset('js/jquery.growl.js')}}"></script>
  <script src="{{asset('js/popper.min.js')}}"  crossorigin="anonymous"></script>
  <script src="{{asset('js/bootstrap.min.js')}}"  crossorigin="anonymous"></script>
  <!-- Awesome svg icons -->
  <script defer src="{{asset('js/all.js')}}"  crossorigin="anonymous"></script>
  <!-- custom js -->
  <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
  <!-- (Optional) Latest compiled and minified JavaScript translation files -->
  {{--<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.7/dist/js/i18n/defaults-*.min.js"></script>--}}
  <!-- Awesome svg icons -->
  <script src="{{asset('js/main.js')}}"></script>
  <script src="{{asset('js/vue.js')}}"></script>

  <script src="{{asset('js/axios.min.js')}}"></script>



  @yield('scripts')

  {{--<script type="text/javascript"  src="{{ URL("/js/table.js") }}"></script>--}}

  <script>
   
   let sidebar = new Vue({
    el: "#sidebar",

    data() {
      return {
        isShown1:  false,
        isShown2:  false,
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
        } else if (key == 'isShown2') {
          this.isShown2 = !this.isShown2;
          sessionStorage.setItem("isShown1", false);
          sessionStorage.setItem(key, this.isShown2);
        } else if(key == 'langs') {
          this.langs = !this.langs;
          sessionStorage.setItem("isShown1", false);
          sessionStorage.setItem("isShown2", false);
          sessionStorage.setItem(key, this.langs);
        } else {
          sessionStorage.setItem("isShown1", false);
          sessionStorage.setItem("isShown2", false);
          sessionStorage.setItem("langs", false);
        }
      }
    },
  });

   function ready() {
    openNav();
  }

  document.addEventListener("DOMContentLoaded", ready);

  $(document).ready(function () {
    bsCustomFileInput.init()
  })

</script>

</body>
</html>
