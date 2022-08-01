<ul>
    @foreach($children as $child)
        <div class="d-flex">
            @if(count($child->children))
                <p class="dropdown-toggle mb-0" data-bs-toggle="collapse" data-bs-target="#collapse{{$child->id}}" aria-expanded="false" aria-controls="collapseExample">
                    <span role="button">{{$child->name}}</span>
                </p>
            @else
                <a href="{{ route('searchByCategory', Str::slug($child->name)) }}" class= "text-dark text-decoration-none hover">{{$child->name}}</a>
            @endif
        </div>
        
        @if(count($child->children))
            <div class="collapse" id="collapse{{$child->id}}">
                @include('categories-loop',['children' => $child->children])
            </div>
        @endif
    @endforeach
</ul>