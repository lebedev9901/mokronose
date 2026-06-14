@extends('admin.layouts.app')

@section('title', 'Редактирование товара')
@section('page-title', 'Редактирование товара')
@section('page-subtitle', $product->title)

@section('content')

@php
    $ageGroups = old('age_group', $product->age_group ?? []);
    $breedSizes = old('breed_size', $product->breed_size ?? []);
@endphp

<form action="{{ route('admin.products.update', $product->id) }}"
      method="POST"
      enctype="multipart/form-data"
      class="admin-form">

    @csrf
    @method('PUT')

    <div class="admin-form-grid">

        <div class="admin-form-card">
            <h3>Основная информация</h3>

            <div class="admin-field">
                <label>Название</label>
                <input type="text" name="title" value="{{ old('title', $product->title) }}" required>
            </div>

            <div class="admin-field">
                <label>Описание</label>
                <textarea name="description">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="admin-field">
                <label>Вес</label>
                <input type="number" step="0.01" name="weight" value="{{ old('weight', $product->weight) }}" required>
            </div>

            <div class="admin-field">
                <label>Цена</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" required>
            </div>

            <div class="admin-field">
                <label>Остаток</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}">
            </div>
        </div>

        <div class="admin-form-card">
            <h3>Категории</h3>

            <div class="admin-checkbox-list">
                @foreach($categories as $category)
                    <label>
                        <input type="checkbox"
                               name="categories[]"
                               value="{{ $category->id }}"
                               {{ $product->categories->contains($category->id) ? 'checked' : '' }}>
                        <span>{{ $category->title }}</span>
                    </label>
                @endforeach
            </div>
        </div>

    </div>

    <div class="admin-form-card">
        <h3>Характеристики товара</h3>

        <div class="admin-form-grid admin-form-grid--3">
            <div class="admin-field">
                <label>Белки</label>
                <input type="text" name="proteins" value="{{ old('proteins', $product->proteins) }}">
            </div>

            <div class="admin-field">
                <label>Жиры</label>
                <input type="text" name="fats" value="{{ old('fats', $product->fats) }}">
            </div>

            <div class="admin-field">
                <label>Углеводы</label>
                <input type="text" name="carbohydrates" value="{{ old('carbohydrates', $product->carbohydrates) }}">
            </div>

            <div class="admin-field">
                <label>Энергетическая ценность</label>
                <input type="text" name="energy_value" value="{{ old('energy_value', $product->energy_value) }}">
            </div>

            <div class="admin-field">
                <label>Срок годности</label>
                <input type="text" name="shelf_life" value="{{ old('shelf_life', $product->shelf_life) }}">
            </div>
        </div>

        <div class="admin-form-grid admin-form-grid--3">
            <div class="admin-field">
                <label>Состав</label>
                <textarea name="composition">{{ old('composition', $product->composition) }}</textarea>
            </div>

            <div class="admin-field">
                <label>Условия хранения</label>
                <textarea name="storage_conditions">{{ old('storage_conditions', $product->storage_conditions) }}</textarea>
            </div>

            <div class="admin-field">
                <label>Рекомендации</label>
                <textarea name="recommendations">{{ old('recommendations', $product->recommendations) }}</textarea>
            </div>
        </div>
    </div>

    <div class="admin-form-card">
        <h3>Подходит для</h3>

        <div class="admin-form-grid">
            <div>
                <label class="admin-section-label">Возраст</label>

                <div class="admin-checkbox-list">
                    <label>
                        <input type="checkbox" name="age_group[]" value="puppy"
                            {{ in_array('puppy', $ageGroups) ? 'checked' : '' }}>
                        <span>Щенки</span>
                    </label>

                    <label>
                        <input type="checkbox" name="age_group[]" value="junior"
                            {{ in_array('junior', $ageGroups) ? 'checked' : '' }}>
                        <span>Юниоры</span>
                    </label>

                    <label>
                        <input type="checkbox" name="age_group[]" value="adult"
                            {{ in_array('adult', $ageGroups) ? 'checked' : '' }}>
                        <span>Взрослые</span>
                    </label>
                    <label>
                        <input type="checkbox" name="age_group[]" value="all"
                            {{ in_array('all', $ageGroups) ? 'checked' : '' }}>
                        <span>Для всех</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="admin-section-label">Размер породы</label>

                <div class="admin-checkbox-list">
                    <label>
                        <input type="checkbox" name="breed_size[]" value="small"
                            {{ in_array('small', $breedSizes) ? 'checked' : '' }}>
                        <span>Мелкие породы</span>
                    </label>

                    <label>
                        <input type="checkbox" name="breed_size[]" value="medium"
                            {{ in_array('medium', $breedSizes) ? 'checked' : '' }}>
                        <span>Средние породы</span>
                    </label>

                    <label>
                        <input type="checkbox" name="breed_size[]" value="large"
                            {{ in_array('large', $breedSizes) ? 'checked' : '' }}>
                        <span>Крупные породы</span>
                    </label>
                    <label>
                        <input type="checkbox" name="breed_size[]" value="all"
                            {{ in_array('all', $breedSizes) ? 'checked' : '' }}>
                        <span>Крупные породы</span>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="admin-form-card">
        <h3>Текущие фото</h3>

        <div class="admin-current-images">
            @forelse($product->images as $img)
                <div class="admin-current-image">
                    <img src="{{ asset('storage/' . $img->image) }}">

                    @if($img->is_preview)
                        <span class="admin-current-image__main">Главное</span>
                    @endif

                    <div class="admin-current-image__actions">
                        <button type="button" onclick="setPreview({{ $img->id }})">
                            ⭐ Главное
                        </button>

                        <button type="button" onclick="deleteImage({{ $img->id }})">
                            🗑 Удалить
                        </button>
                    </div>
                </div>
            @empty
                <p class="admin-empty-text">Фото пока не добавлены</p>
            @endforelse
        </div>
    </div>

    <div class="admin-form-card">
        <h3>Добавить новые фото</h3>

        <div class="admin-field">
            <input type="file" name="images[]" id="imagesInput" multiple accept="image/*">
        </div>

        <div id="imagePreviewContainer" class="admin-image-preview"></div>
    </div>

    <div class="admin-form-actions">
        <button class="admin-btn">
            Сохранить изменения
        </button>
    </div>

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
    .then(() => location.reload());
}

function setPreview(id) {
    fetch(`/admin/products/images/${id}/preview`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(res => res.json())
    .then(() => location.reload());
}

const imagesInput = document.getElementById('imagesInput');

if (imagesInput) {
    imagesInput.addEventListener('change', function (e) {
        const container = document.getElementById('imagePreviewContainer');
        container.innerHTML = '';

        Array.from(e.target.files).forEach((file) => {
            const reader = new FileReader();

            reader.onload = function (event) {
                const wrapper = document.createElement('div');
                wrapper.className = 'admin-preview-item';

                wrapper.innerHTML = `
                    <img src="${event.target.result}">
                    <div class="admin-preview-label">Новое фото</div>
                `;

                container.appendChild(wrapper);
            };

            reader.readAsDataURL(file);
        });
    });
}
</script>

@endsection