@extends('layouts.app')
@section('content')

<div class="d-flex p-4 justify-content-around">
    @include('layouts.sidebar')
    <form method="POST" id="create-ad" class="col-7" action="{{ route('create_ad', Auth::id()) }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="col-8">
                <label for="title" class="form-label">Naziv oglasa:</label>
                <input type="text" id="title" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required>
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-3">
                <label for="photos" class="form-label">Slike:</label>
                <input type="file" id="photos" class="form-control" name="files[]" name="photos" accept="image/png, image/gif, image/jpeg" multiple/>
                @error('photos')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="col-8">
                <label for="desc" class="form-label">Opis oglasa:</label>
                <textarea class="form-control" id="desc" rows="3"name="desc" value="{{ old('desc') }}" required></textarea>
                @error('desc')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-3">
                <label for="price" class="form-label">Cena:</label>
                <input type="text" id="price" class="form-control" name="price" value="{{ old('price') }}" required>
                @error('price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="col-5">
                <label for="phone" class="form-label">Kontakt telefon:</label>
                <input type="text" id="phone" class="form-control" name="phone" value="{{ old('phone') }}" required>
                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-5">
                <label for="location" class="form-label">Lokacija:</label>
                <input type="text" id="location" class="form-control" name="location" value="{{ old('location') }}" required>
                @error('location')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="col-5">
                <label for="Stanje" class="form-label">Stanje robe:</label>
                <select name="condition" class="form-select">
                    @foreach($conditions as $condition)
                        <option value="{{$condition->id}}">{{$condition->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-5">
                <label for="Kategorija" class="form-label">Kategorija:</label>
                <select name="category" class="form-select">
                    @foreach($categories as $category)
                        @if($category->children)
                            <optgroup label="{{$category->name}}">
                            @include('choose-category', ['children' => $category->children])
                        @else
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endif
                    @endforeach
                    </optgroup>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Postavi oglas</button>
    </form>
</div>
<script>
    $( document ).ready(function() {
        $('#create-ad').submit(function(){
            $('button[type=submit]').addClass("disabled");
        });
    });
</script>
@endsection