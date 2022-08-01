@extends('layouts.app')
@section('content')

<div class="d-flex p-4 justify-content-around">
    @include('layouts.sidebar')
    <div class="col-8">
        @if(count($ads))
            @foreach($ads as $ad)
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
                    <p class="my-2">Kontakt telefon: {{$ad->phone}}</p>
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
@endsection
