@extends('layouts.layout')
@section('content')
    <main class="" id="main">
        <div class="container my-5">

            <div class="row justify-content-center">
                <div class="col-8">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" action="{{route('admin.divisions.update',$division->id)}}" class="row border border-primary justify-content-center">
                        @csrf
                        <h5 class="bg-primary text-white p-3 w-100 d-flex justify-content-between">rolls_add - форма добавления </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="col-12 p-4">
                            <table id="" class="table table-striped table-bordered adding-forms">
                                <tbody>
                                <tr>
                                    <th scope="row">rolls</th>
                                    <td class="form-group">
                                        <input type="text" name="name" value="{{$division->name}}" class="form-control" id="" placeholder="">
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-auto justify-content-center pb-3">
                            <a href="#"  class="btn btn-secondary px-5" data-dismiss="modal">Закрыть</a>
                            <input  type="submit" class="btn btn-primary px-5" value="Сохранить"></input>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
