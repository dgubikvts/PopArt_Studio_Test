@extends('layouts.app')
@section('content')

<div class="d-flex p-4 justify-content-around">
    @include('layouts.sidebar')
    <form method="POST" class="col-7" action="{{ route('patch-ad', $ad->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="col-8">
                <label for="title" class="form-label">Naziv oglasa:</label>
                <input type="text" id="title" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $ad->title }}" required>
                @error('title')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-3">
                <label for="price" class="form-label">Cena:</label>
                <input type="text" id="price" class="form-control" name="price" value="{{ $ad->price }}" required>
                @error('price')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="mb-3 d-flex justify-content-between align-items-center col-12">
            <label for="desc" class="form-label col-2">Opis oglasa:</label>
            <textarea class="form-control" id="desc" rows="3" name="desc" required>{{$ad->description}}</textarea>
            @error('desc')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <div class="col-5">
                <label for="phone" class="form-label">Kontakt telefon:</label>
                <input type="text" id="phone" class="form-control" name="phone" value="{{ $ad->phone }}" required>
                @error('phone')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-5">
                <label for="location" class="form-label">Lokacija:</label>
                <input type="text" id="location" class="form-control" name="location" value="{{ $ad->location }}" required>
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
                <select name="condition" class="form-select" id="condition">
                    @foreach($conditions as $condition)
                        <option value="{{$condition->id}}">{{$condition->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-5">
                <label for="Kategorija" class="form-label">Kategorija:</label>
                <select name="category" class="form-select" id="category">
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
        <div class="col-5 mb-3">
            <label for="photos" class="form-label">Slike:</label>
            <input type="file" id="photos" class="form-control" name="files[]" name="photos" accept="image/png, image/gif, image/jpeg" multiple/>
            @error('photos')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="d-flex flex-wrap">
            @if(count($ad->images))
                @foreach($ad->images as $image)
                    <div class="d-flex flex-column align-items-center">
                        <a href="" id="delete-img" data-id="{{$image->id}}"><i class="fa-solid fa-trash red"></i></a>
                        <img class="me-2 mb-3" id="{{$image->id}}" src="{{asset($image->path)}}" style="object-fit:contain;" width="200px" height="200px">
                    </div>
                @endforeach
            @endif
        </div>
        <button type="submit" class="btn btn-primary">Izmeni oglas</button>
    </form>
</div>

<script>
    $( document ).ready(function() {
        $("#condition option").each(function()
        {
            if($(this).val() ==  "{{$ad->condition}}") $(this).attr('selected', 'selected');
        });
        $("#category option").each(function()
        {
            if($(this).val() ==  "{{$ad->category}}") $(this).attr('selected', 'selected');
        });
        $(document).on('click','#delete-img',function(e){
            e.preventDefault();
            var img = $(this);
            $.ajaxSetup({
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'DELETE',
                url: `{{ route('delete-img') }}`,
                data: {img_id: $(this).data('id')},
                success: function (response) {
                    img.parent().remove();
                }
            });
          });
    });

</script>

@endsection