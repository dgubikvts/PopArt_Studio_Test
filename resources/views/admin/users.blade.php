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
    <div class="col-8">
        @if(count($users))
            @foreach($users as $user)
                <div class="d-flex justify-content-between">
                    <div class="container border rounded p-3 mb-3">
                        <p class="lead m-0"><a href="{{route('profile', $user->id)}}">{{$user->name}}</a> </p>
                        <p class="m-0">Broj oglasa: {{count($user->advertisements)}}</p>
                    </div>
                    <div class="d-flex flex-column justify-content-around m-2">
                        <div class=""><a href="" id="delete-user" data-id="{{$user->id}}"><i class="fa-solid fa-trash red"></i></a></div>
                    </div>
                </div>
            @endforeach
            <div class="pagination d-flex justify-content-center align-items-center">
                <li class="page-item"><a class="page-link" href="{{ $users->previousPageUrl() }}">Prethodna</a></li>
                <p class="m-0 mx-3">{{$users->currentPage()}} of {{$users->lastPage()}}</p>
                <li class="page-item"><a class="page-link" href="{{ $users->nextPageUrl() }}">Sledeća</a></li>
            </div>
        @else
            <p class="lead text-center">Trenutno ne postoji nijedan oglas.</p>
        @endif
    </div>
</div>

<script>
    $( document ).ready(function() {
        $(document).on('click','#delete-user',function(e){
            e.preventDefault();
            var trash = $(this);
            var user_id = "{{Auth::id()}}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'DELETE',
                url: `{{ route('delete-user') }}`,
                data: {user: $(this).data('id'), user_id: user_id},
                success: function (response) {
                    trash.parent().parent().parent().remove();
                    document.location.reload();
                }
            });
          });
    });
</script>

@endsection