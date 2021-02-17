@extends('general.layouts.layout')
@section('content')
    <main class="py-3" id="main">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h4 class="w-100 ml-3 font-weight-bold text-primary">список постов на реках и каналах свидания по которым использование для оценки ресурсов поверхностис вод</h4>
                <div class="col-auto">
                    <ul class="list-inline small">
                        @if(\Auth::user()->level->level == 'Administrator' || \Auth::user()->level->level == 'Editor')
                        <li class="list-inline-item"><a href="#" class="btn btn-primary btn-sm px-3" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Добавить</a></li>
                        @endif

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
                        <th scope="col">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1"></label>
                            </div>
                        </th>
                        <th scope="col">№</th>
                        <th scope="col">
                            <form>
                                <div class="form-group">
                                    <label for="exampleInput2">Название водного объекта</label>
                                    <input type="text" class="form-control form-control-sm" id="exampleInput2">
                                </div>
                            </form>
                        </th>
                        <th scope="col">
                            <form>
                                <div class="form-group">
                                    <label for="exampleInput2">Местоположения название поста </label>
                                    <input type="text" class="form-control form-control-sm" id="exampleInput2">
                                </div>
                            </form>
                        </th>
                        <th scope="col"><i class="fas fa-tasks fa-lg"></i></th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @foreach($directories as $key => $name)
                        <tr>
                            <th scope="row">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck2">
                                    <label class="form-check-label" for="defaultCheck2"></label>
                                </div>
                            </th>
                            <td>{{ $name->order }}</td>
                            <td class="text-left">{{$name->name}}</td>
                            <td class="text-left">{{$name->post_place}}</td>
                            <td>
                                <button onclick="getId({{$name->id}})" data-toggle="modal" data-target="#exampleModal1" type="button" class="btn btn-sm btn-outline-warning waves-effect"><i class="far fa-eye"></i></button>
                                @if(\Auth::user()->level->level == 'Administrator' || \Auth::user()->level->level == 'Editor')
                                <button onclick="getId({{$name->id}})"  data-toggle="modal" data-target="#exampleModal1"  type="button" class="btn btn-sm btn-outline-info waves-effect"><i class="fas fa-pencil-alt"></i></button>
                                @endif
                                @if(\Auth::user()->level->level == 'Administrator')

                                <button onclick="if (confirm('Are you sure you want to delete this thing into the database?')) {
                                        window.location.href='{{route('general.directories.list_posts.destroy',$name->id)}}'
                                        } else {
                                        }" type="button" class="btn btn-sm btn-outline-danger waves-effect"><i class="fas fa-times"></i></button>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $directories->links() }}
            </div>
        </div>
    </main>
@endsection

@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form  method="post" action="{{route('general.directories.list_posts.store')}}" class="modal-content">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title" id="exampleModalLabel">список постов на реках и каналах  - форма добавления</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="tab-pane fade show active" id="nav-ru" role="tabpanel" aria-labelledby="nav-ru-tab">
                        <table id="" class="table table-striped table-bordered adding-forms">
                            <tbody>
                            <tr>
                                <th scope="row">№</th>
                                <td class="form-group">
                                    <input type="number " value="{{old('order')}}" name="order" class="form-control" id="" placeholder="">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Название водного объекта</th>
                                <td class="form-group">
                                    <input type="text" value="{{old('name')}}" name="name" class="form-control" id="" placeholder="">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Местоположения название поста</th>
                                <td class="form-group">
                                    <input type="text" value="{{old('post_place')}}" name="post_place" class="form-control" id="" placeholder="">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Метка</th>
                                <td class="form-group">
                                    <input type="checkbox" checked name="isFavotire" class="form-control" id="" placeholder="">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary btn-sm px-5" data-dismiss="modal">Закрыть</button>
                    @if(\Auth::user()->level->level == 'Administrator' || \Auth::user()->level->level == 'Editor')
                    <input  type="submit" class="btn btn-primary px-5" value="Сохранить"></input>
                    @endif

                </div>
            </form>
        </div>
    </div>


    <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form  method="post" action="{{route('general.directories.list_posts.update')}}" class="modal-content">
                @csrf
                <input type="hidden" name="id" id="hidden">
                <div class="modal-header bg-primary text-white">
                    <h4 class="modal-title" id="exampleModalLabel">список постов на реках и каналах  - форма добавления</h4>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="tab-pane fade show active" id="nav-ru" role="tabpanel" aria-labelledby="nav-ru-tab">
                        <table id="" class="table table-striped table-bordered adding-forms">
                            <tbody>
                            <tr>
                                <th scope="row">Название водного объекта</th>
                                <td class="form-group">
                                    <input type="text" value="{{old('name_edit')}}"  name="name_edit" class="form-control" id="name_edit" placeholder="">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Местоположения название поста</th>
                                <td class="form-group">
                                    <input type="text" value="{{old('post_place_edit')}}" name="post_place_edit" class="form-control" id="post_place_edit" placeholder="">
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Метка</th>
                                <td class="form-group">
                                    <input type="checkbox"  name="isFavotire_edit" value="{{old('isFavotire_edit')}}" class="form-control" id="isFavotire_edit" placeholder="">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        </table>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary btn-sm px-5" data-dismiss="modal">Закрыть</button>
                    @if(\Auth::user()->level->level == 'Administrator' || \Auth::user()->level->level == 'Editor')
                        <input  type="submit" class="btn btn-primary px-5" value="Сохранить"></input>
                    @endif

                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>

        var id = 0;
        function getId(id)
        {
            this.id = id;
            axios.get('{{route('general.directories.list_posts.edit')}}',{
                params: {
                    id: id
                }
            })
                .then(function (response) {
                    $('#name_edit').val(response.data.name);
                    $('#post_place_edit').val(response.data.post_place);
                    if(response.data.isfavorite == true)
                    {
                        $('#isFavotire_edit').prop('checked', true);
                    }
                    else
                    {
                        $('#isFavotire_edit').prop('checked', false);


                    }
                    $('#hidden').val(response.data.id);

                })
                .catch(function (error) {
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
        }


    </script>
@endsection
