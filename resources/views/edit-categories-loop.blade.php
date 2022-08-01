<ul>
    @foreach($children as $child)
        <div class="d-flex align-items-center mb-2">
            <p class="mb-0 me-3">{{$child->name}}</p>
            <div class="modal fade" id="addNew{{$child->id}}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Dodajte podkategoriju za: {{$child->name}}</h5>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('add-category', $child->id) }}" method="POST">
                                @csrf
                                <input id="newCategory" type="text" class="form-control" name="newCategory" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Otkazi</button>
                            <button type="submit" class="btn btn-primary">Dodaj</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="edit{{$child->id}}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Izmena imena za: {{$child->name}}</h5>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('edit-category', $child->id) }}" method="POST">
                                @csrf
                                <input id="editCategory" type="text" class="form-control" name="editCategory" value="{{$child->name}}" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Otkazi</button>
                            <button type="submit" class="btn btn-primary">Izmeni</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-success border-0 p-0 px-2 py-1 m-0 me-2" data-bs-toggle="modal" data-bs-target="#addNew{{$category->id}}"><i class="fa-solid fa-plus m-0 p-0"></i></button>
            <button type="button" class="btn btn-primary border-0 p-0 px-2 py-1 m-0 me-2" data-bs-toggle="modal" data-bs-target="#edit{{$child->id}}"><i class="fa-solid fa-pen"></i></button>
            <form action="{{ route('delete-category', $child->id) }}" method="post">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger border-0 p-0 px-2 py-1 m-0"><i class="fas fa-minus"></i></button>
            </form>
        </div>
        @if(count($child->children))
            @include('edit-categories-loop', ['children' => $child->children])
        @endif
    @endforeach
</ul>