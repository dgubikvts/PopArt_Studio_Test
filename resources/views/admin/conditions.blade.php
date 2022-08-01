@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-around">
    <div class="border-top bg-white col-2 justify-content-center text-center">
        <div class="border-bottom bg-light p-3 lead">Admin panel</div>
        <div class="list-group">
            <a class="list-group-item list-group-item-action list-group-item-light p-3 @if(Route::currentRouteName() == 'admin-index') selected @endif" href="{{ route('admin-index') }}">Oglasi</a>
            <a class="list-group-item list-group-item-action list-group-item-light p-3 @if(Route::currentRouteName() == 'admin-users') selected @endif" href="{{ route('admin-users') }}">Korisnici</a>
            <a class="list-group-item list-group-item-action list-group-item-light p-3 @if(Route::currentRouteName() == 'admin-categories') selected @endif" href="{{ route('admin-categories') }}">Kategorije</a>
            <a class="list-group-item list-group-item-action list-group-item-light p-3 @if(Route::currentRouteName() == 'admin-conditions') selected @endif" href="{{ route('admin-conditions') }}">Stanje robe</a>
        </div>
    </div>
    <div class="col-8 d-flex flex-column">
        <div class="">
            <div class="modal fade" id="addCondition" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Dodaj novu kategoriju</h5>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('add-condition') }}" method="POST">
                                @csrf
                                <input id="newCondition" type="text" class="form-control" name="newCondition" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Otkazi</button>
                            <button type="submit" class="btn btn-primary">Dodaj</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addCondition">Dodaj novo stanje</button>
        </div>
        @foreach($conditions as $condition)
            <div class="d-flex align-items-center mb-2">
                <p class="lead mb-0 me-3">{{$condition->name}}</p>
                <form action="{{ route('delete-condition', $condition->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger border-0 p-0 px-2 py-1 m-0 me-2"><i class="fas fa-minus"></i></button>
                </form>
                <div class="modal fade" id="edit{{$condition->id}}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Izmena naziva: {{$condition->name}}</h5>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('edit-condition', $condition->id) }}" method="POST">
                                    @csrf
                                    <input id="editCondition" type="text" class="form-control" name="editCondition" value="{{$condition->name}}" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Otkazi</button>
                                <button type="submit" class="btn btn-primary">Izmeni</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary border-0 p-0 px-2 py-1 m-0 me-2" data-bs-toggle="modal" data-bs-target="#edit{{$condition->id}}"><i class="fa-solid fa-pen"></i></button>
            </div>
        @endforeach
    </div>
</div>
@endsection