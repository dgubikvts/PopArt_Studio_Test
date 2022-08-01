@foreach($children as $child)
    @if(count($child->children))
        <optgroup label="{{$child->name}}">
        @include('choose-category',['children' => $child->children])
    @else
        <option value="{{$child->id}}">{{$child->name}}</option>
    @endif
@endforeach
</optgroup>