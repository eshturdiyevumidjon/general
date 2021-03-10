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
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <div class="table-responsive">

      <table id="" class="table table-striped small reestr-tables">
        <thead class="bg-primary text-white text-center">
          <tr class="">
            <th scope="col">№ п.п</th>
            <th scope="col">Имя пользователя</th>
            <th scope="col">ФИО</th>
            <th scope="col">Роль</th>
            <th scope="col">Эл.почта</th>
            <th scope="col">Тип пользователя</th>
            <th scope="col"><i class="fas fa-tasks fa-lg"></i></th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $key=>$user)
          <tr>
            <td>{{$key+1}}</td>
            <td>{{$user->email}}</td>
            <td>{{$user->getFullname()}}</td>
            <td>{{$user->role_id ? $user->role->name : ''}}</td>
            <td>{{$user->user_email}}</td>
            <td>{{$user->getUserTypeName()}}</td>
            <td class="d-flex text-center">
              <button type="button" @click="getUser({{$user->id}})"  class="btn btn-sm btn-outline-info waves-effect" data-toggle="modal" data-target="#editUser_a"><i class="fas fa-pencil-alt"></i></button>
              <button type="button" onclick="if (confirm('Are you sure you want to delete this thing into the database?')) {
                window.location.href='{{route('general.admin.users.delete',$user->id)}}'
              } else {
              }" class="btn btn-sm btn-outline-danger waves-effect"><i class="fas fa-times"></i></button>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      {{ $users->links() }}

    </div>
  </div>

  {{-- Modal for create --}}
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <form action="{{route('general.admin.users.store')}}" method="post" class="needs-validation" novalidate>
          @csrf
          <div class="modal-header bg-primary text-white">
            <h4 class="modal-title" id="exampleModalLabel">Пользователь - форма добавления</h4>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="small">
              <div class="form-row">
                <div class="form-group col-auto">
                  <label for="">Имя пользователя</label>
                  <input type="text" name="email" class="form-control form-control-sm" id="" placeholder="" required>
                  <div class="invalid-feedback">
                    Please choose a username.
                  </div>
                </div>
                <div class="form-group col-auto">
                  <label for="">Фамилия</label>
                  <input type="text" name="lastname" class="form-control form-control-sm" id="" placeholder="" required>
                  <div class="invalid-feedback">
                    Please choose a username.
                  </div>
                </div>
                <div class="form-group col-auto">
                  <label for="">Имя</label>
                  <input type="text" name="firstname" class="form-control form-control-sm" id="" placeholder="" required>
                  <div class="invalid-feedback">
                    Please choose a username.
                  </div>
                </div>
                <div class="form-group col-auto">
                  <label for="">Отчество</label>
                  <input type="text" name="middlename" class="form-control form-control-sm" id="" placeholder="" required>
                  <div class="invalid-feedback">
                    Please choose a username.
                  </div>
                </div>
                <div class="form-group col-auto">
                  <label for="">Роль</label>
                  <select class="custom-select custom-select-sm" name="roll_id" required>
                    @foreach($rolls as $roll)
                    @if($roll->name == 'Administrator')
                    <option value="{{$roll->id}}">{{App\Helpers\MyHelpers::getLocaleValue('administrator')}}</option>
                    @elseif($roll->name == 'Editor')
                    <option value="{{$roll->id}}">{{App\Helpers\MyHelpers::getLocaleValue('editor')}}</option>
                    @elseif($roll->name == 'Viewer')
                    <option value="{{$roll->id}}">{{App\Helpers\MyHelpers::getLocaleValue('viewer')}}</option>
                     @else
                     <option value="{{$roll->id}}">{{App\Helpers\MyHelpers::getLocaleValue($roll->name)}}</option>
                    @endif
                    @endforeach
                  </select>
                  <div class="invalid-feedback">
                    Please choose a username.
                  </div>
                </div>
              </div>

              <div class="form-row">

                <div class="form-group col-auto">
                  <label for="">Тип пользователя</label>
                  <select class="custom-select custom-select-sm" name="user_type" required>
                    <option value="gidromet">Гидромет</option>
                    <option value="gidrogeologiya">Гидрогеология</option>
                    <option value="minvodxoz">Минводхоз</option>
                    <option value="general">Единый Водный Кадастр</option>
                  </select>
                  <div class="invalid-feedback">
                    Please choose a user type.
                  </div>
                </div>

                <div class="form-group col-auto">
                  <label for="">Эл.почта</label>
                  <input type="email" name="user_email" class="form-control form-control-sm" id="" placeholder="" required>
                  <div class="invalid-feedback">
                    Please choose a username.
                  </div>
                </div>

                <div class="form-group col-auto">
                  <label for="">Пароль</label>
                  <input type="password" name="password" class="form-control form-control-sm" id="" placeholder="" required>
                  <div class="invalid-feedback">
                    Please choose a username.
                  </div>
                </div>
                <div class="form-group col-auto">
                  <label for="">Подтверждение пароля</label>
                  <input type="password" name="password_confirmation" class="form-control form-control-sm" id="" placeholder="" required>
                  <div class="invalid-feedback">
                    Please choose a username.
                  </div>
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

  {{-- Modal for edit --}}
  <div class="modal fade" id="editUser_a" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <form action="{{route('general.admin.users.update')}}" method="post" class="needs-validation" novalidate>
          @csrf
          <div class="modal-header bg-primary text-white">
            <h4 class="modal-title" id="exampleModalLabel">Пользователь - форма изменения</h4>
            <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="small">
              <div class="form-row">
                <div class="form-group col-auto">
                  <label for="">Имя пользователя</label>
                  <input type="text" name="email" v-model="user.email" class="form-control form-control-sm" id="" placeholder="" required>
                  <input type="hidden" name="id" v-model="user.id" class="form-control form-control-sm" id="" placeholder="">
                  <div class="invalid-feedback">
                    Please choose a username.
                  </div>
                </div>
                <div class="form-group col-auto">
                  <label for="">Фамилия</label>
                  <input type="text" name="lastname" v-model="user.lastname" class="form-control form-control-sm" id="" placeholder="" required>
                  <div class="invalid-feedback">
                    Please choose a username.
                  </div>
                </div>
                <div class="form-group col-auto">
                  <label for="">Имя</label>
                  <input type="text" name="firstname" v-model="user.firstname" class="form-control form-control-sm" id="" placeholder="" required>
                  <div class="invalid-feedback">
                    Please choose a username.
                  </div>
                </div>
                <div class="form-group col-auto">
                  <label for="">Отчество</label>
                  <input type="text" name="middlename" v-model="user.middlename" class="form-control form-control-sm" id="" placeholder="" required>
                  <div class="invalid-feedback">
                    Please choose a username.
                  </div>
                </div>
                <div class="form-group col-auto">
                  <label for="">Роль</label>
                  <select class="custom-select custom-select-sm" v-for="item in user.roles" v-model="item.name" name="roll_id" required>
                    @foreach($rolls as $roll)
                    @if($roll->name == 'Administrator')
                    <option  value="{{$roll->id}}">{{App\Helpers\MyHelpers::getLocaleValue('administrator')}}</option>
                    @elseif($roll->name == 'Editor')
                    <option value="{{$roll->id}}">{{App\Helpers\MyHelpers::getLocaleValue('editor')}}</option>
                    @else
                    <option value="{{$roll->id}}">{{$roll->name}}</option>
                    @endif
                    @endforeach
                  </select>
                  <div class="invalid-feedback">
                    Please choose a username.
                  </div>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group col-auto">
                  <label for="">Эл.почта</label>
                  <input type="email" name="user_email" v-model="user.user_email" class="form-control form-control-sm" id="" placeholder="" required>
                  <div class="invalid-feedback">
                    Please choose a username.
                  </div>
                </div>

                <div class="form-group col-auto">
                  <label for="">Пароль</label>
                  <input type="password" name="password"  class="form-control form-control-sm" id="" placeholder="" required>
                  <div class="invalid-feedback">
                    Please choose a username.
                  </div>
                </div>
                <div class="form-group col-auto">
                  <label for="">Подтверждение пароля</label>
                  <input type="password" name="password_confirmation" class="form-control form-control-sm" id="" placeholder="" required>
                  <div class="invalid-feedback">
                    Please choose a username.
                  </div>
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
      user:'',
      divisions:[],
    },

	methods:{
      getUser:function(id){
       axios.get('{{route('general.admin.users.edit')}}', {
         params: {
           id: id
         }
       })
       .then(function (response) {
        main.user = response.data;
        main.getPositions(main.user.id);
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
        console.log(response.data);

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
