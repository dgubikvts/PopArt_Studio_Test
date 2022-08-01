@extends('layouts.app')
@section('content')

<div class="d-flex p-4 justify-content-around">
    @include('layouts.sidebar')
    <div class="col-8">
        @if(request()->path() == 'user/'.Auth::id())
            <a href="{{ route('new_ad') }}" class="btn btn-success mb-3">Dodaj oglas</a>
        @endif
        <h1 class="text-center">@if($user->id == Auth::id()) Moji oglasi @else Oglasi korisnika {{$user->name}} @endif</h1>
        @if(count($advertisements))
            @foreach($advertisements as $ad)
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
                    @if($advertisements[0]->user->id == Auth::id() || Auth::user()->isAdmin())
                        <div class="d-flex flex-column justify-content-around m-2">
                            <div class=""><a href="{{ route('edit-ad', $ad->id) }}"><i class="fa-solid fa-pen blue"></i></a></div>
                            <div class=""><a href="{{ route('delete-ad') }}" id="delete-ad" data-id="{{$ad->id}}"><i class="fa-solid fa-trash red"></i></a></div>
                        </div>
                    @endif
                </div>
            @endforeach
            <div class="pagination d-flex justify-content-center align-items-center">
                <li class="page-item"><a class="page-link" href="{{ $advertisements->previousPageUrl() }}">Prethodna</a></li>
                <p class="m-0 mx-3">{{$advertisements->currentPage()}} of {{$advertisements->lastPage()}}</p>
                <li class="page-item"><a class="page-link" href="{{ $advertisements->nextPageUrl() }}">Sledeća</a></li>
            </div>
            @else
                <p class="lead text-center">@if($user->id == Auth::id()) Trenutno nemate nijedan oglas. @else Korisnik trenutno nema nijedan oglas. @endif</p>
            @endif
        </div>
    </div>
</div>  
<script>
    $( document ).ready(function() {
        $(document).on('click','#delete-ad',function(e){
            e.preventDefault();
            var trash = $(this);
            var user_id = "{{count($advertisements) ? $advertisements[0]->user->id : ''}}";
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