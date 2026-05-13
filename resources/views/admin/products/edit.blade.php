@extends('admin.layouts.app')

@section('title', 'Редактирование товара')

@section('content')

<h1>Редактирование товара</h1>

<form action="{{ route('admin.products.update', $product->id) }}"
      method="POST"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    {{-- TITLE --}}
    <div>
        <label>Название</label>
        <input type="text" name="title" value="{{ $product->title }}">
    </div>

    {{-- DESCRIPTION --}}
    <div>
        <label>Описание</label>
        <textarea name="description">{{ $product->description }}</textarea>
    </div>

    {{-- WEIGHT --}}
    <div>
        <label>Вес</label>
        <input type="number" step="0.01" name="weight" value="{{ $product->weight }}">
    </div>

    {{-- PRICE --}}
    <div>
        <label>Цена</label>
        <input type="number" step="0.01" name="price" value="{{ $product->price }}">
    </div>

    {{-- STOCK --}}
    <div>
        <label>Остаток</label>
        <input type="number" name="stock" value="{{ $product->stock }}">
    </div>




@foreach($categories as $category)
    <label style="display:block;">
        <input type="checkbox"
               name="categories[]"
               value="{{ $category->id }}"

               {{-- 🔥 ВОТ ЭТО ГЛАВНОЕ --}}
               {{ $product->categories->contains($category->id) ? 'checked' : '' }}>

        {{ $category->title }}
    </label>
@endforeach



    {{-- IMAGES --}}
    <div style="margin-top:15px;">
        <label>Фото товара</label>
        <input type="file" name="images[]" multiple>
    </div>

    {{-- EXISTING IMAGES --}}
    <div style="margin-top:20px;">
    <h3>Текущие фото</h3>

    <div style="display:flex; gap:10px; flex-wrap:wrap;">

        @foreach($product->images as $img)

            <div style="position:relative;" data-id="{{ $img->id }}">

                <img src="{{ asset('storage/' . $img->image) }}"
                     style="width:90px; height:90px; object-fit:cover; border-radius:8px;">

                {{-- PREVIEW --}}
                @if($img->is_preview)
                    <div style="position:absolute; top:0; left:0; background:#22c55e; color:white; font-size:10px; padding:2px;">
                        MAIN
                    </div>
                @endif

                {{-- BUTTONS --}}
                <div style="display:flex; gap:5px; margin-top:5px;">

                    <button type="button"
                            onclick="setPreview({{ $img->id }})"
                            style="font-size:10px;">
                        ⭐
                    </button>

                    <button type="button"
                            onclick="deleteImage({{ $img->id }})"
                            style="font-size:10px; color:red;">
                        🗑
                    </button>

                </div>

            </div>

        @endforeach

    </div>
</div>

    <button class="btn btn-primary" style="margin-top:20px;">
        Сохранить
    </button>

</form>

<script>

function deleteImage(id) {

    fetch(`/admin/products/images/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(res => res.json())
    .then(() => {
        location.reload();
    });

}

function setPreview(id) {

    fetch(`/admin/products/images/${id}/preview`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(res => res.json())
    .then(() => {
        location.reload();
    });

}

</script>

@endsection