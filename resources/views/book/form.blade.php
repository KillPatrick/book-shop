@csrf
<div class="form-group">
    <label for="title">Title</label>
    <input type="text" name="title" class="form-control" id="title" value="@isset($book){{$book->title}}@else{{ old('title') }}@endisset" required>
</div>
<div class="form-group">
    <label for="authors">Authors*</label>
    <input type="text" name="authors" class="form-control" id="authors"
        @isset($book)
        value="@forelse($book->authors as $author){{$author->name}}@if(!$loop->last),@endif @empty @endforelse"
        @else
        value="{{ old('authors') }}"
        @endisset
     required>
    <small>*Separate authors by comma</small>
</div>
<div class="form-group">
    <label for="genres">Genres*</label>
    <select multiple name="genres[]" class="form-control" id="genres" required>
        @foreach($genres as $genre)
            <option value="{{$genre->id}}" @isset($book) @if(in_array($genre->id, $book->genres->pluck('id')->toArray())) selected @endif @endisset>{{$genre->name}}</option>
        @endforeach
    </select>
    <small>*Multiple genres can be selected by hold ctrl/cmd key</small>
</div>
<div class="form-group">
    <label for="description">Example textarea</label>
    <textarea class="form-control" name="description" id="description" rows="5" required>@isset($book){{$book->description}}@else{{ old('description') }}@endisset</textarea>
</div>
<div class="form-group">
    <label for="price">Price &euro;</label>
    <input class="form-control" name="price" id="price" rows="5" type="number" min="0.1" step="0.01" value="@isset($book){{$book->price}}@else{{ old('price') }}@endisset"  required />
</div>
@isset($book)
<div class="form-group">
    <label for="discount">Discount %</label>
    <input class="form-control" name="discount" id="discount" rows="5" type="number" min="0" max="100" value="{{$book->discount}}"  required />
</div>
@endisset
<div class="form-group">
    <label for="customFile">Cover image</label>
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="customFile" name="image">
        <label class="custom-file-label" for="customFile">Choose file</label>
    </div>
</div>
<button type="submit" class="btn btn-primary">Submit</button>
