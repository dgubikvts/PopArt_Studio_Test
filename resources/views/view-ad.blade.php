@extends('layouts.app')
@section('content')

<div class="d-flex p-4 justify-content-around">
    @include('layouts.sidebar')
    <div class="d-flex col-8 flex-wrap p-3 border border-dark">
        @auth
            @if($ad->user->id == Auth::id() || Auth::user()->isAdmin())
                <div class="my-2">
                    <a href="{{ route('edit-ad', $ad->id) }}" class="btn btn-primary me-3">Izmeni oglas</a>
                    <div class="btn btn-danger" id="delete-ad" data-id="{{$ad->id}}">Obrisi oglas</div>
                </div>
            @endif
        @endauth
        <div class="d-flex flex-column col-12">
            <div class="">
                <p class="m-0">Postavljen oglas: {{$ad->created_at->format('d/m/Y')}}</p>
                <p class="m-0">Kategorija: <a href="{{ route('searchByCategory', Str::slug($ad->getCategory->name)) }}">{{$ad->getCategory->name}}</a></p>
                <h2 class="m-0 mt-4">{{$ad->title}}</h2>
                <p class="m-0 mb-3">Stanje: {{$ad->getCondition->name}}</p>
            </div>
            <hr>
            <div class="d-flex justify-content-around col-12">
                <div class="d-flex">
                    <img src="{{count($ad->images) ? asset($ad->images[0]->path) : 'https://via.placeholder.com/200'}}" width="200px" height="200px" style="object-fit: contain;" alt="">
                    <p class="lead ms-5 align-self-center">Cena: {{$ad->price}}rsd</p>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <p>Objavio korisnik: <a href="{{ route('profile', $ad->user->id) }}">{{$ad->user->name}}</a></p>
                    <p>Lokacija: {{$ad->location}}</p>
                    <button type="submit" class="btn btn-primary">Kontaktiraj prodavca(ne radi)</button>
                </div>
            </div>
        </div>
        <div class="my-5 col-12">
        <hr>
            <p class="lead">{{$ad->description}}</p>
            <hr>
        </div>
        <div class="d-flex col-12">
            <a class="prev align-self-center" onclick="plus(-1)">❮</a>
            <div class="slideshow-container">
                @if(count($ad->images))

                    @foreach($ad->images as $image)
                        <div class="image-slide">
                            <img src="{{asset($image->path)}}" style="width:100%">  
                        </div>
                    @endforeach
                @else
                    <img src="https://via.placeholder.com/200" style="width:100%">  
                @endif
            </div>
            <a class="next align-self-center" onclick="plus(1)">❯</a>        
        </div>
    </div>
</div>

<script>
    $( document ).ready(function() {
        $(document).on('click','#delete-ad',function(e){
            e.preventDefault();
            var user_id = "{{$ad->user->id}}";
            console.log(user_id);
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
                    document.location = '/';
                }
            });
          });
    });
    var imgIndex = 1;
    showImage(imgIndex);
    function plus(n) {
    showImage(imgIndex += n);
    }
    function currentImg(n) {
    showImage(imgIndex = n);
    }
    function showImage(n) {
        var i;
        var images = document.getElementsByClassName("image-slide");
        if (n > images.length) imgIndex = 1
        if (n < 1) imgIndex = images.length
        for (i = 0; i < images.length; i++)
            images[i].style.display = "none";
        images[imgIndex-1].style.display = "block";
    }

    

</script>

@endsection