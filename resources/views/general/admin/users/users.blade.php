@extends('general.layouts.layout')
@section('content')

<main id="main" class="py-3">
  <div class="container-fluid">
    <div class="row justify-content-between">
      <h4 class="w-100 ml-3 font-weight-bold text-primary text-uppercase" id="titleOfForm"></h4>
      <div class="col-auto">
        <ul class="list-inline small">
          <li class="list-inline-item"><a href="#" class="btn btn-primary btn-sm px-3" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Добавить</a></li>
        </ul>
      </div>
    </div>
    @if ($errors->any())
    <div class="alert small alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <div class="table-responsive-sm">
      <table id="" class="table table-striped small">
        <thead class="bg-primary text-white text-center">
          <tr class="">
            <th scope="col">№ п.п</th>
            <th scope="col">Имя пользователя</th>
            <th scope="col">ФИО</th>
            <th scope="col">Роль</th>
            <th scope="col">Организация</th>
            <th scope="col">Эл.почта</th>
            <th scope="col"><i class="fas fa-tasks fa-lg"></i></th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $key=>$user)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->getFullname()}}</td>
            @foreach($user->getRoleNames() as $item)
              @if($item == 'Administrator')
              <td>{{App\Helpers\MyHelpers::getLocaleValue('administrator')}}</td>
              @elseif($item == 'Editor')
              <td>{{App\Helpers\MyHelpers::getLocaleValue('editor')}}</td>
              @elseif($item == 'Viewer')
              <td>{{App\Helpers\MyHelpers::getLocaleValue('viewer')}}</td>
              @endif
            @endforeach
            <td>
             @if($user->org_name == 'minvodxoz')
             Минводхоз
             @elseif($user->org_name == 'gidromet')
             Гидромет
             @elseif($user->org_name == 'gidrogeologiya')
             Гидрогеология
             @elseif($user->org_name == 'other')
             Универсальный
             @endif
           </td>
           <td>{{$user->user_email}}</td>
           <td class="d-flex text-center">
            <button type="button" @click="getUser({{$user->id}})" class="btn btn-sm btn-outline-info waves-effect" data-toggle="modal" data-target="#exampleModalEdit" ><i class="fas fa-pencil-alt" ></i></button>
            <button type="button" class="btn btn-sm btn-outline-danger waves-effect"><i class="fas fa-times"></i></button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    {{ $users->links() }}
    </div>
  </div>

  <!-- Modal for create -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <form action="{{route('general.admin.users.store')}}" method="post" class="needs-validation" novalidate>
          @csrf
          <div class="modal-header bg-primary text-white">
            <h4 class="modal-title" id="exampleModalLabel">Пользователь - форма добавления</h4>
          </div>
          <div class="modal-body">
            <div class="small">
              <div class="form-row">
                <div class="form-group col-auto">
                  <label for="">Имя пользователя</label>
                  <input type="text" v-model="email" name="email" class="form-control form-control-sm" id="email"  required>
                </div>
                <div class="form-group col-auto">
                  <label for="">Фамилия</label>
                  <input type="text" v-model="lastname" name="lastname" class="form-control form-control-sm" id="lastname"  required>
                </div>
                <div class="form-group col-auto">
                  <label for="">Имя</label>
                  <input type="text" name="firstname"  v-model="firstname" class="form-control form-control-sm" id="firstname"  required>
                </div>
                <div class="form-group col-auto">
                  <label for="">Отчество</label>
                  <input type="text" name="middlename" v-model="middlename" class="form-control form-control-sm" id="middlename"  required>
                </div>
                <div class="form-group col-auto">
                  <label for="">Роль</label>
                  <select v-model="roll_id" class="custom-select custom-select-sm" name="roll_id" required>
                    @foreach($rolls as $roll)
                    @if($roll->name == 'Administrator')
                    <option value="{{$roll->name}}">{{App\Helpers\MyHelpers::getLocaleValue('administrator')}}</option>
                    @elseif($roll->name == 'Editor')
                    <option value="{{$roll->name}}">{{App\Helpers\MyHelpers::getLocaleValue('editor')}}</option>
                    @elseif($roll->name == 'Viewer')
                    <option value="{{$roll->name}}">{{App\Helpers\MyHelpers::getLocaleValue('viewer')}}</option>
                    @endif                                            
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-auto">
                  <label for="">Организация</label>
                  <select  class="selectpicker" name="org_name"  data-live-search='true' title='Выбрать..' data-width='100%' required>
                    <option value="minvodxoz">Минводхоз</option>
                    <option value="gidromet">Гидромет</option>
                    <option value="gidrogeologiya">Гидрогеология</option>
                    <option value="other">Универсальный</option>
                  </select>
                </div>
                <div class="form-group col-auto">
                  <label for="">Области</label>
                  <select class="custom-select custom-select-sm" data-live-search='true' title='Выбрать..' v-model="regions" name="regions" required>
                    <option value="" selected disabled></option>
                    @foreach($regions as $region)
                    <option value="{{$region->regionid}}">{{$region->nameUz}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-auto">
                  <label for="">Эл.почта</label>
                  <input type="email" name="user_email"  v-model="user_email" class="form-control form-control-sm" id="user_email"  required>
                </div>
                <div class="form-group col-auto">
                  <label for="">Пароль</label>
                  <input type="password" name="password" v-model="password" class="form-control form-control-sm" id="password"  required>
                </div>
                <div class="form-group col-auto">
                  <label for="">Подтверждение пароля</label>
                  <input type="password" v-model="password_confirmation" name="password_confirmation" class="form-control form-control-sm" id="password_confirmation"  required>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary btn-sm px-5" data-dismiss="modal">Закрыть</button>
            <input type="submit" class="btn btn-primary btn-sm px-5" value="Сохранить" />
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal for edit -->
  <div class="modal fade" id="exampleModalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <form action="{{route('general.admin.users.update')}}" method="post"  class="needs-validation" novalidate>
          @csrf
          <div class="modal-header bg-primary text-white">
            <h4 class="modal-title" id="exampleModalLabel">Пользователь - форма изменения</h4>
          </div>
          <div class="modal-body">
            <div class="small">
              <div class="form-row">
                <div class="form-group col-auto">
                  <label for="">Имя пользователя</label>
                  <input type="text" v-model="user.email" name="email" class="form-control form-control-sm" id="email"  required>
                  <input type="hidden" name="id" v-model="user.id" class="form-control form-control-sm" id="" >
                </div>
                <div class="form-group col-auto">
                  <label for="">Фамилия</label>
                  <input type="text"  v-model="user.lastname" name="lastname" class="form-control form-control-sm" id="lastname"  required>
                </div>
                <div class="form-group col-auto">
                  <label for="">Имя</label>
                  <input type="text" name="firstname"  v-model="user.firstname" class="form-control form-control-sm" id="firstname"  required>
                </div>
                <div class="form-group col-auto">
                  <label for="">Отчество</label>
                  <input type="text" name="middlename" v-model="user.middlename" class="form-control form-control-sm" id="middlename"  required>
                </div>
                <div class="form-group col-auto">
                  <label for="">Роль</label>
                  <select v-for="item in user.roles" v-model="item.name" class="custom-select custom-select-sm" name="roll_id" required>
                    @foreach($rolls as $roll)
                    @if($roll->name == 'Administrator')
                    <option value="{{$roll->name}}">{{App\Helpers\MyHelpers::getLocaleValue('administrator')}}</option>
                    @elseif($roll->name == 'Editor')
                    <option value="{{$roll->name}}">{{App\Helpers\MyHelpers::getLocaleValue('editor')}}</option>
                    @elseif($roll->name == 'Viewer')
                    <option value="{{$roll->name}}">{{App\Helpers\MyHelpers::getLocaleValue('viewer')}}</option>
                    @endif
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-auto">
                  <label for="">Организация</label>
                  <select  class="selectpicker"   name="org_name"  data-live-search='true' title='Выбрать..' data-width='100%' required>
                    <option v-if="user.org_name == 'minvodxoz'" selected value="minvodxoz">Минводхоз</option>
                    <option v-else value="minvodxoz">Минводхоз</option>
                    <option v-if="user.org_name == 'gidromet'" selected value="gidromet">Гидромет</option>
                    <option v-else value="gidromet">Гидромет</option>
                    <option v-if="user.org_name == 'gidrogeologiya'" selected value="gidrogeologiya">Гидрогеология</option>
                    <option v-else value="gidrogeologiya">Гидрогеология</option>
                    <option v-if="user.org_name == 'other'" selected value="other">Универсальный</option>
                    <option  v-else  value="other">Универсальный</option>
                  </select>
                </div>
                <div class="form-group col-auto">
                  <label for="">Области</label>
                  <select class="custom-select custom-select-sm"  v-model="user.region_id" name="regions" required>
                    <option value="" selected disabled></option>
                    @foreach($regions as $region)
                    <option value="{{$region->regionid}}">{{$region->nameUz}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-auto">
                  <label for="">Эл.почта</label>
                  <input type="email" name="user_email"  v-model="user.user_email" class="form-control form-control-sm" id="user_email"  required>
                </div>

                <div class="form-group col-auto">
                  <label for="">Пароль</label>
                  <input type="password" name="password" v-model="password" class="form-control form-control-sm" id="password"  required>
                </div>
                <div class="form-group col-auto">
                  <label for="">Подтверждение пароля</label>
                  <input type="password" v-model="password_confirmation" name="password_confirmation" class="form-control form-control-sm" id="password_confirmation"  required>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary btn-sm px-5" data-dismiss="modal">Закрыть</button>
            <input type="submit" class="btn btn-primary btn-sm px-5" value="Сохранить" />
          </div>
        </form>
      </div>
    </div>
  </div>
</main>
@endsection
@section('scripts')
<script>
  var results = [];

  let main = new Vue({
   el:'#main',
   data:{
    errors: [],
    name: null,
    email: null,
    lastname: null,
    firstname: null,
    middlename: null,
    roll_id: null,
    division_id: null,
    level_id: null,
    regions: null,
    user_email: null,
    password: null,
    password_confirmation: null,
    user:'',
    divisions:[],
    roles:''
  },
  methods:{
    getUser:function (id) {
      axios.get('{{route('general.admin.users.edit')}}', {
        params: {
          id: id
        }
      })
      .then(function (response) {
        main.user = response.data;
        main.getPositions(main.user.id);
        main.roles = main.user.roles[0].name;
        console.log(response.data);
      })
      .catch(function (error) {
        console.log(error);
      })
      .finally(function () {
        // always execute    d
      });

    },
    getPositions:function (id) {
      results = [];
      let theVue = this;

      axios.get('{{route('general.admin.users.get_division')}}', {
        params: {
          id: id
        }
      })
      .then(function (response) {
        for(var i=0;i<response.data.length;i++)
        {
          //console.log(response.data);
          if(response.data[i].minvodxoz_division_id != null)
            results.push(response.data[i].minvodxoz_division_id);

        }

        main.divisions = results;
        theVue.$nextTick(function(){ $('.selectpicker').selectpicker('refresh'); });

      })
      .catch(function (error) {
        console.log(error);
      })
      .finally(function () {
        // always executed
      });
    },
  }
  });
  
  // Example starter JavaScript for disabling form submissions if there are invalid fields
  (function() {
    'use strict';
    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');
      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            form.classList.add('was-validated');
          }
          else
          {
            form.submit();

          }
        }, false);
      });
    }, false);
  })();
</script>
@endsection

