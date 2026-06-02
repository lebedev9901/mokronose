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
    <hr>

    <h3>Характеристики товара</h3>

    <div>
        <label>Белки</label>
        <input type="text" name="proteins" value="{{ old('proteins', $product->proteins) }}">
    </div>

    <div>
        <label>Жиры</label>
        <input type="text" name="fats" value="{{ old('fats', $product->fats) }}">
    </div>

    <div>
        <label>Углеводы</label>
        <input type="text" name="carbohydrates" value="{{ old('carbohydrates', $product->carbohydrates) }}">
    </div>

    <div>
        <label>Энергетическая ценность</label>
        <input type="text" name="energy_value" value="{{ old('energy_value', $product->energy_value) }}">
    </div>

    <div>
        <label>Срок годности</label>
        <input type="text" name="shelf_life" value="{{ old('shelf_life', $product->shelf_life) }}">
    </div>

    <div>
        <label>Состав</label>
        <textarea name="composition">{{ old('composition', $product->composition) }}</textarea>
    </div>

    <div>
        <label>Условия хранения</label>
        <textarea name="storage_conditions">{{ old('storage_conditions', $product->storage_conditions) }}</textarea>
    </div>

    <div>
        <label>Рекомендации</label>
        <textarea name="recommendations">{{ old('recommendations', $product->recommendations) }}</textarea>
    </div>

    <div>
        <label>Возраст</label>
        <select name="age_group">
            <option value="all" {{ $product->age_group === 'all' ? 'selected' : '' }}>Все возрасты</option>
            <option value="puppy" {{ $product->age_group === 'puppy' ? 'selected' : '' }}>Щенок</option>
            <option value="junior" {{ $product->age_group === 'junior' ? 'selected' : '' }}>Юниор</option>
            <option value="adult" {{ $product->age_group === 'adult' ? 'selected' : '' }}>Взрослый</option>
        </select>
    </div>

    <div>
        <label>Порода</label>
        <select name="breed_size">
            <option value="all" {{ $product->breed_size === 'all' ? 'selected' : '' }}>Все породы</option>
            <option value="small" {{ $product->breed_size === 'small' ? 'selected' : '' }}>Мелкие породы</option>
            <option value="medium" {{ $product->breed_size === 'medium' ? 'selected' : '' }}>Средние породы</option>
            <option value="large" {{ $product->breed_size === 'large' ? 'selected' : '' }}>Крупные породы</option>
        </select>
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
        <input
            type="file"
            name="images[]"
            id="imagesInput"
            multiple
            accept="image/*"
        >

        <div
            id="imagePreviewContainer"
            style="display:flex; gap:15px; flex-wrap:wrap; margin-top:20px;"
        ></div>
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
const imagesInput = document.getElementById('imagesInput');

if (imagesInput) {
    imagesInput.addEventListener('change', function (e) {
        const container = document.getElementById('imagePreviewContainer');

        container.innerHTML = '';

        Array.from(e.target.files).forEach((file, index) => {
            const reader = new FileReader();

            reader.onload = function (event) {
                const wrapper = document.createElement('div');

                wrapper.style.width = '180px';

                wrapper.innerHTML = `
                    <img
                        src="${event.target.result}"
                        style="
                            width:180px;
                            height:180px;
                            object-fit:cover;
                            border-radius:10px;
                            border:1px solid #ddd;
                        "
                    >

                    <div style="margin-top:10px; font-size:12px;">
                        Новое фото
                    </div>
                `;

                container.appendChild(wrapper);
            };

            reader.readAsDataURL(file);
        });
    });
}
</script>

@endsection