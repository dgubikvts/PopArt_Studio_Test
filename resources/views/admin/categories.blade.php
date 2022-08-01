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
            <div class="modal fade" id="addCategory" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Dodaj novu kategoriju</h5>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('add-category', -1) }}" method="POST">
                                @csrf
                                <input id="newCategory" type="text" class="form-control" name="newCategory" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Otkazi</button>
                            <button type="submit" class="btn btn-primary">Dodaj</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addCategory">Dodaj novu kategoriju</button>
        </div>
        @foreach($categories as $category)
            <div class="d-flex align-items-center mb-2">
                <p class="lead mb-0 me-3">{{$category->name}}</p>
                <div class="modal fade" id="addNew{{$category->id}}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Dodajte podkategoriju za: {{$category->name}}</h5>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('add-category', $category->id) }}" method="POST">
                                    @csrf
                                    <input id="newCategory" type="text" class="form-control" name="newCategory" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Otkazi</button>
                                <button type="submit" class="btn btn-primary">Dodaj</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="edit{{$category->id}}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Izmena imena za: {{$category->name}}</h5>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('edit-category', $category->id) }}" method="POST">
                                    @csrf
                                    <input id="editCategory" type="text" class="form-control" name="editCategory" value="{{$category->name}}" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Otkazi</button>
                                <button type="submit" class="btn btn-primary">Izmeni</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-success border-0 p-0 px-2 py-1 m-0 me-2" data-bs-toggle="modal" data-bs-target="#addNew{{$category->id}}"><i class="fa-solid fa-plus m-0 p-0"></i></button>
                <button type="button" class="btn btn-primary border-0 p-0 px-2 py-1 m-0 me-2" data-bs-toggle="modal" data-bs-target="#edit{{$category->id}}"><i class="fa-solid fa-pen"></i></button>
                <form action="{{ route('delete-category', $category->id) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger border-0 p-0 px-2 py-1 m-0"><i class="fas fa-minus"></i></button>
                </form>
            </div>
            @if(count($category->children))
                @include('edit-categories-loop ',['children' => $category->children])
            @endif
        @endforeach
    </div>
</div>
@endsection