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
        @if(count($ads))
            @foreach($ads as $ad)
                <div class="d-flex justify-content-between">
                    <div class="container border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center my-2">
                            <h2 class="lead m-0"><a href="{{ route('view-ad', $ad->id) }}" class="text-decoration-none text-dark hover">{{$ad->title}}</a></h2>
                            <p class="m-0">Cena: {{$ad->price}}rsd</p>
                            <p class="m-0">Stanje: {{$ad->getCondition->name}}</p>
                            <p class="m-0">Lokacija: {{$ad->location}}</p>
                        </div>
                        <div class="d-flex">
                            <a href="{{ route('view-ad', $ad->id) }}"><img class="img-hover" src="{{count($ad->images) ? asset($ad->images[0]->path) : 'https://via.placeholder.com/150'}}" style="object-fit:contain;" width="150px" height="150px"></a>
                            <p class="mx-5 align-self-center">{{$ad->description}}</p>
                        </div>
                    </div>
                    <div class="d-flex flex-column justify-content-around m-2">
                        <div class=""><a href="{{ route('edit-ad', $ad->id) }}"><i class="fa-solid fa-pen blue"></i></a></div>
                        <div class=""><a href="{{ route('delete-ad') }}" id="delete-ad" data-id="{{$ad->id}}"><i class="fa-solid fa-trash red"></i></a></div>
                    </div>
                </div>
            @endforeach
            <div class="pagination d-flex justify-content-center align-items-center">
                <li class="page-item"><a class="page-link" href="{{ $ads->previousPageUrl() }}">Prethodna</a></li>
                <p class="m-0 mx-3">{{$ads->currentPage()}} of {{$ads->lastPage()}}</p>
                <li class="page-item"><a class="page-link" href="{{ $ads->nextPageUrl() }}">Sledeća</a></li>
            </div>
        @else
            <p class="lead text-center">Trenutno ne postoji nijedan oglas.</p>
        @endif
    </div>
</div>

<script>
    $( document ).ready(function() {
        $(document).on('click','#delete-ad',function(e){
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
                url: `{{ route('delete-ad') }}`,
                data: {ad_id: $(this).data('id'), user_id: user_id},
                success: function (response) {
                    trash.parent().parent().parent().remove();
                    document.location.reload();
                }
            });
          });
    });
</script>

@endsection