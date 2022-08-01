<nav class="col-2 p-3 border border-dark text-bg-info" style="overflow: auto; max-height: 100vh;">
    @foreach($categories as $category)
        @if(count($category->children))
            <p class="lead dropdown-toggle mb-0" data-bs-toggle="collapse" data-bs-target="#collapse{{$category->id}}" aria-expanded="false" aria-controls="collapseExample">
            <span role="button">{{$category->name}}</span></p>
        @else
            <div class="">
                <a href="{{ route('searchByCategory', Str::slug($category->name)) }}" class= "lead text-dark text-decoration-none hover">{{$category->name}}</a>
            </div>
        @endif
 
        @if(count($category->children))
            <div class="collapse" id="collapse{{$category->id}}">
                @include('categories-loop ',['children' => $category->children])
            </div>
        @endif
    @endforeach
</nav>