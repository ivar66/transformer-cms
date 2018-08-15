@foreach(load_categories() as $category)
    @if($select_id == $category->id)
        <option value="{{ $category->id }}" selected >{{ $category->category_name }}</option>
    @else
        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
    @endif
@endforeach