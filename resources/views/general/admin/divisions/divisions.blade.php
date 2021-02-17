@extends('general.layouts.layout')
@section('content')
    <main class="py-3" id="main">
        <div class="container-fluid">
            <div class="row justify-content-between">
                <h4 class="w-100 ml-3 font-weight-bold text-primary">divisions</h4>
                <div class="col-auto">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <select class="custom-select custom-select-sm w-50 float-left">
                                <option selected>10</option>
                                <option value="1">20</option>
                                <option value="2">30</option>
                                <option value="3">40</option>
                            </select>
                            <p class="float-right w-50 pl-2"><small>записей на странице</small></p>
                        </div>
                        <div class="col-auto">
                            <ul class="list-inline small">
                                <li class="list-inline-item"><a href="#" class="text-primary"><i class="fas fa-file-export fa-lg"></i> Экспорт</a></li>
                                <li class="list-inline-item"><a href="#" class="text-primary"><i class="fas fa-file-import fa-lg"></i> Импорт</a></li>
                                <li class="list-inline-item"><a href="#" class="text-primary"><i class="fas fa-list-alt fa-lg"></i> Колонки</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <ul class="list-inline small">
                        <li class="list-inline-item"><a href="#" class="text-primary"><i class="fas fa-trash-alt fa-lg"></i> Удалить</a></li>
                        <li class="list-inline-item"><a href="{{route('general.admin.divisions.create')}}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Добавить</a></li>
                    </ul>
                </div>
            </div>
            <div class="table-responsive-sm">
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
                                    <label for="exampleInput2">name of divisions</label>
                                    <input type="text" class="form-control form-control-sm" id="exampleInput2">
                                </div>
                            </form>
                        </th>
                        <th scope="col"><i class="fas fa-tasks fa-lg"></i></th>
                    </tr>
                    </thead>
                    <tbody class="text-center">
                    @foreach($divisions as $key => $division)
                        <tr>
                            <th scope="row">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck2">
                                    <label class="form-check-label" for="defaultCheck2"></label>
                                </div>
                            </th>
                            <td>{{ $key+1 }}</td>
                            <td class="text-left">{{$division->name}}</td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-warning waves-effect"><i class="far fa-eye"></i></button>
                                <button onclick="window.location.href='{{route('general.admin.divisions.edit',$division->id)}}'"  type="button" class="btn btn-sm btn-outline-info waves-effect"><i class="fas fa-pencil-alt"></i></button>
                                <button onclick="if (confirm('Are you sure you want to delete this thing into the database?')) {
                                        window.location.href='{{route('general.admin.divisions.delete',$division->id)}}'
                                        } else {
                                        }" type="button" class="btn btn-sm btn-outline-danger waves-effect"><i class="fas fa-times"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $divisions->links() }}
            </div>
        </div>
    </main>
@endsection
