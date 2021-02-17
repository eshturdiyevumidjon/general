@extends('general.layouts.layout')

@section('content')

    <main id="main" class="py-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-auto">
                    <h4 class="font-weight-bold text-primary text-uppercase mb-3">General</h4>
                </div>
                <div class="col-auto ml-auto">
                    @include('gidromet.partials.alerts')
                </div>
            </div>
            <div class="row create-daily-form-row p-3">
                <div class="col-12">
                    <form action="{{route('general.word.export')}}"  method="post">
                        @csrf
                        <div class="form-row mb-3">
                            <div class="col-auto">
                                <label for="">Год</label>
                                <select class="custom-select custom-select-sm" name="year">
                                    @for ($i = date('Y'); $i >= 1970; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-auto ml-auto mt-auto">
                                <button type="submit" class="btn btn-sm btn-primary"><i class="fas fa-glass-martini-alt"></i> Сформировать</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

@endsection
