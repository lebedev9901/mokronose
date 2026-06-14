

<?php $__env->startSection('title', 'Каталог товаров — Мокронос'); ?>
<?php $__env->startSection('description', 'Каталог товаров для животных в интернет-магазине Мокронос.'); ?>

<?php $__env->startSection('content'); ?>
<div class="container catalog">

    <h2 class="section-title">Каталог лакомств</h2>

    <div class="catalog-layout">

        <aside class="catalog-sidebar">
            <div class="catalog-filters">

                <h3 class="catalog-filters__title">Категории</h3>

                <div class="catalog-main-categories">
                    <a href="<?php echo e(route('catalog', request()->except('category', 'page'))); ?>"
                       class="catalog-filter-main catalog-category-link <?php echo e(request('category') ? '' : 'is-active'); ?>"
                       data-category="">
                        Все товары
                    </a>

                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route('catalog', array_merge(request()->except('page'), ['category' => $category->id]))); ?>"
                           class="catalog-filter-main catalog-category-link <?php echo e(request('category') == $category->id ? 'is-active' : ''); ?>"
                           data-category="<?php echo e($category->id); ?>">
                            <?php echo e($category->title); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="catalog-subcategories">
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($category->children->isNotEmpty()): ?>
                            <div
                                class="catalog-subcategory-row <?php echo e(request('category') == $category->id ||
                                    $category->children->pluck('id')->contains((int) request('category'))
                                    ? 'is-visible'
                                    : ''); ?>"
                                data-parent-category="<?php echo e($category->id); ?>"
                            >
                                <a href="<?php echo e(route('catalog', array_merge(request()->except('page'), ['category' => $category->id]))); ?>"
                                   class="catalog-filter-child catalog-category-link <?php echo e(request('category') == $category->id ? 'is-active' : ''); ?>"
                                   data-category="<?php echo e($category->id); ?>"
                                   data-parent="<?php echo e($category->id); ?>">
                                    Все в категории
                                </a>

                                <?php $__currentLoopData = $category->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="<?php echo e(route('catalog', array_merge(request()->except('page'), ['category' => $child->id]))); ?>"
                                       class="catalog-filter-child catalog-category-link <?php echo e(request('category') == $child->id ? 'is-active' : ''); ?>"
                                       data-category="<?php echo e($child->id); ?>"
                                       data-parent="<?php echo e($category->id); ?>">
                                        <?php echo e($child->title); ?>

                                    </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <?php if(auth()->guard()->check()): ?>
                    <?php if(isset($pets) && $pets->count()): ?>
                        <div class="catalog-filter-section">
                            <h3 class="catalog-filters__title">Подбор</h3>

                            <button type="button" class="catalog-pet-btn" id="petPickBtn">
                                Подобрать для питомца
                            </button>

                            <select id="catalogPetSelect" class="catalog-pet-select">
                                <option value="">Выберите питомца</option>

                                <?php $__currentLoopData = $pets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option
                                        value="<?php echo e($pet->id); ?>"
                                        data-age="<?php echo e($pet->age_group); ?>"
                                        data-size="<?php echo e($pet->breed_size); ?>"
                                    >
                                        <?php echo e($pet->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <form method="GET" action="<?php echo e(route('catalog')); ?>" class="catalog-sort-form" id="catalogFilterForm">

                    <input type="hidden" name="category" id="catalogCategoryInput" value="<?php echo e(request('category')); ?>">
                    <input type="hidden" name="sort" id="catalogSortInput" value="<?php echo e(request('sort', 'new')); ?>">

                    <h3 class="catalog-filters__title">Фильтры</h3>

                    <div class="catalog-sort-field">
                        <label>Цена от</label>
                        <input type="number" name="price_from" value="<?php echo e(request('price_from')); ?>" placeholder="0">
                    </div>

                    <div class="catalog-sort-field">
                        <label>Цена до</label>
                        <input type="number" name="price_to" value="<?php echo e(request('price_to')); ?>" placeholder="5000">
                    </div>

                    <div class="catalog-filter-section">
                        <h3 class="catalog-filters__title">Возраст</h3>

                        <label class="catalog-check">
                            <input type="checkbox" name="age_group[]" value="puppy" <?php echo e(in_array('puppy', (array) request('age_group', [])) ? 'checked' : ''); ?>>
                            <span>Щенки</span>
                        </label>

                        <label class="catalog-check">
                            <input type="checkbox" name="age_group[]" value="junior" <?php echo e(in_array('junior', (array) request('age_group', [])) ? 'checked' : ''); ?>>
                            <span>Юниоры</span>
                        </label>

                        <label class="catalog-check">
                            <input type="checkbox" name="age_group[]" value="adult" <?php echo e(in_array('adult', (array) request('age_group', [])) ? 'checked' : ''); ?>>
                            <span>Взрослые</span>
                        </label>
                    </div>

                    <div class="catalog-filter-section">
                        <h3 class="catalog-filters__title">Размер породы</h3>

                        <label class="catalog-check">
                            <input type="checkbox" name="breed_size[]" value="small" <?php echo e(in_array('small', (array) request('breed_size', [])) ? 'checked' : ''); ?>>
                            <span>Маленькие</span>
                        </label>

                        <label class="catalog-check">
                            <input type="checkbox" name="breed_size[]" value="medium" <?php echo e(in_array('medium', (array) request('breed_size', [])) ? 'checked' : ''); ?>>
                            <span>Средние</span>
                        </label>

                        <label class="catalog-check">
                            <input type="checkbox" name="breed_size[]" value="large" <?php echo e(in_array('large', (array) request('breed_size', [])) ? 'checked' : ''); ?>>
                            <span>Крупные</span>
                        </label>

                        <label class="catalog-check">
                            <input type="checkbox" name="breed_size[]" value="all" <?php echo e(in_array('all', (array) request('breed_size', [])) ? 'checked' : ''); ?>>
                            <span>Для всех пород</span>
                        </label>
                    </div>

                    <a href="<?php echo e(route('catalog')); ?>" class="catalog-filter-reset" id="catalogReset">
                        Сбросить
                    </a>

                </form>

            </div>
        </aside>

        <div class="catalog-content">

            <div class="catalog-toolbar">
                <div class="catalog-count">
                    Найдено товаров: <span id="catalogTotal"><?php echo e($products->total()); ?></span>
                </div>

                <div class="catalog-toolbar-sort">
                    <label>Сортировка</label>

                    <select id="catalogSortTop">
                        <option value="new" <?php echo e(request('sort') == 'new' ? 'selected' : ''); ?>>Сначала новые</option>
                        <option value="old" <?php echo e(request('sort') == 'old' ? 'selected' : ''); ?>>Сначала старые</option>
                        <option value="price_asc" <?php echo e(request('sort') == 'price_asc' ? 'selected' : ''); ?>>Цена ↑</option>
                        <option value="price_desc" <?php echo e(request('sort') == 'price_desc' ? 'selected' : ''); ?>>Цена ↓</option>
                    </select>
                </div>
            </div>

            <div class="catalog-grid" id="catalogProducts">
                <?php echo $__env->make('partials.product', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

            <div id="catalogPagination">
                <?php echo $__env->make('partials.pagination', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            </div>

        </div>

    </div>

</div>
<div class="quick-modal" id="quickModal">
                    <div class="quick-modal__overlay" data-quick-close></div>

                    <div class="quick-modal__content">
                        <button type="button" class="quick-modal__close" data-quick-close>×</button>

                        <div class="quick-modal__body" id="quickModalBody">
                            Загрузка...
                        </div>
                    </div>
                </div>
<script>
const filterForm = document.getElementById('catalogFilterForm');
const productsBox = document.getElementById('catalogProducts');
const paginationBox = document.getElementById('catalogPagination');
const categoryInput = document.getElementById('catalogCategoryInput');
const resetBtn = document.getElementById('catalogReset');

const petPickBtn = document.getElementById('petPickBtn');
const petSelect = document.getElementById('catalogPetSelect');

const catalogTotal = document.getElementById('catalogTotal');
const catalogSortTop = document.getElementById('catalogSortTop');
const catalogSortInput = document.getElementById('catalogSortInput');

let catalogTimer = null;

function buildCatalogUrl() {
    const formData = new FormData(filterForm);
    const params = new URLSearchParams();

    formData.forEach((value, key) => {
        if (value !== null && value !== '') {
            params.append(key, value);
        }
    });

    const query = params.toString();

    return query ? `${filterForm.action}?${query}` : filterForm.action;
}

function loadCatalog(url = null) {
    const requestUrl = url || buildCatalogUrl();

    productsBox.classList.add('is-loading');

    fetch(requestUrl, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        productsBox.innerHTML = data.products || '';
        paginationBox.innerHTML = data.pagination || '';

        if (catalogTotal && typeof data.total !== 'undefined') {
            catalogTotal.textContent = data.total;
        }

        window.history.pushState({}, '', requestUrl);

        productsBox.classList.remove('is-loading');
    })
    .catch(error => {
        console.error(error);
        productsBox.classList.remove('is-loading');
    });
}

function showSubcategories(categoryLink) {
    document.querySelectorAll('.catalog-subcategory-row').forEach(row => {
        row.classList.remove('is-visible');
    });

    const parentId = categoryLink.dataset.parent || categoryLink.dataset.category;

    if (!parentId) {
        return;
    }

    const subRow = document.querySelector(
        `.catalog-subcategory-row[data-parent-category="${parentId}"]`
    );

    if (subRow) {
        subRow.classList.add('is-visible');
    }
}

filterForm.addEventListener('submit', function(e) {
    e.preventDefault();
    loadCatalog();
});

filterForm.querySelectorAll('input, select').forEach(input => {
    input.addEventListener('input', () => {
        clearTimeout(catalogTimer);
        catalogTimer = setTimeout(loadCatalog, 500);
    });

    input.addEventListener('change', () => {
        clearTimeout(catalogTimer);
        catalogTimer = setTimeout(loadCatalog, 250);
    });
});

if (catalogSortTop && catalogSortInput) {
    catalogSortTop.addEventListener('change', function() {
        catalogSortInput.value = catalogSortTop.value;
        loadCatalog();
    });
}

document.addEventListener('click', function(e) {
    const categoryLink = e.target.closest('.catalog-category-link');

    if (categoryLink) {
        e.preventDefault();

        document.querySelectorAll('.catalog-category-link').forEach(link => {
            link.classList.remove('is-active');
        });

        categoryLink.classList.add('is-active');

        categoryInput.value = categoryLink.dataset.category || '';

        showSubcategories(categoryLink);

        loadCatalog();
        return;
    }

    const paginationLink = e.target.closest('#catalogPagination a');

    if (paginationLink) {
        e.preventDefault();

        loadCatalog(paginationLink.href);

        window.scrollTo({
            top: document.querySelector('.catalog').offsetTop - 20,
            behavior: 'smooth'
        });
    }
});

if (resetBtn) {
    resetBtn.addEventListener('click', function(e) {
        e.preventDefault();

        filterForm.reset();

        categoryInput.value = '';
        catalogSortInput.value = 'new';

        if (catalogSortTop) {
            catalogSortTop.value = 'new';
        }

        document.querySelectorAll('.catalog-category-link').forEach(link => {
            link.classList.remove('is-active');
        });

        document.querySelectorAll('.catalog-subcategory-row').forEach(row => {
            row.classList.remove('is-visible');
        });

        const allProductsLink = document.querySelector('.catalog-category-link[data-category=""]');

        if (allProductsLink) {
            allProductsLink.classList.add('is-active');
        }

        if (petSelect) {
            petSelect.value = '';
        }

        loadCatalog(filterForm.action);
    });
}

if (petPickBtn && petSelect) {
    petPickBtn.addEventListener('click', function() {
        petSelect.focus();
    });

    petSelect.addEventListener('change', function() {
        const option = petSelect.options[petSelect.selectedIndex];

        const age = option.dataset.age || '';
        const size = option.dataset.size || '';

        filterForm.querySelectorAll('input[name="age_group[]"]').forEach(input => {
            input.checked = input.value === age;
        });

        filterForm.querySelectorAll('input[name="breed_size[]"]').forEach(input => {
            input.checked = input.value === size || input.value === 'all';
        });

        loadCatalog();
    });
}

function toggleFavorite(button) {
    const productId = button.dataset.productId;

    fetch(`/favorites/${productId}/toggle`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        button.classList.toggle('is-active', data.is_favorite);
    });
}
const quickModal = document.getElementById('quickModal');
const quickModalBody = document.getElementById('quickModalBody');

document.addEventListener('click', function(e) {
    const quickBtn = e.target.closest('.product-quick-btn');

    if (quickBtn && quickModal && quickModalBody) {
        e.preventDefault();

        const productId = quickBtn.dataset.productId;

        quickModal.classList.add('is-open');
        document.body.classList.add('modal-open');
        quickModalBody.innerHTML = 'Загрузка...';

        fetch(`/catalog/product/${productId}/quick`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => res.text())
        .then(html => {
            quickModalBody.innerHTML = html;
        });

        return;
    }

    if (e.target.closest('[data-quick-close]') && quickModal && quickModalBody) {
        quickModal.classList.remove('is-open');
        document.body.classList.remove('modal-open');
        quickModalBody.innerHTML = '';
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && quickModal && quickModalBody) {
        quickModal.classList.remove('is-open');
        document.body.classList.remove('modal-open');
        quickModalBody.innerHTML = '';
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/catalog/index.blade.php ENDPATH**/ ?>