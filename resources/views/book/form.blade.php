<form method="POST" enctype="multipart/form-data"
      @can('is-admin')
          action="{{route('admin.books.store')}}"
      @else
          action="{{route('user.books.store')}}"
      @endif
>
    @csrf
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" class="form-control" id="title" required>
    </div>
    <div class="form-group">
        <label for="authors">Authors*</label>
        <input type="text" name="authors" class="form-control" id="authors" required>
        <small>*Separate authors by comma</small>
    </div>
    <div class="form-group">
        <label for="genres">Genres*</label>
        <select multiple name="genres[]" class="form-control" id="genres" required>
            @foreach($genres as $genre)
                <option value="{{$genre->id}}">{{$genre->name}}</option>
            @endforeach
        </select>
        <small>*Multiple genres can be selected by hold ctrl/cmd key</small>
    </div>
    <div class="form-group">
        <label for="description">Example textarea</label>
        <textarea class="form-control" name="description" id="description" rows="5" required></textarea>
    </div>
    <div class="form-group">
        <label for="price">Price &euro;</label>
        <input class="form-control" name="price" id="price" rows="5" type="number" min="0.1" step="0.01" required />
    </div>
    <div class="form-group">
        <label for="customFile">Cover image</label>
        <div class="custom-file">
            <input type="file" class="custom-file-input" id="customFile">
            <label class="custom-file-label" for="customFile">Choose file</label>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
