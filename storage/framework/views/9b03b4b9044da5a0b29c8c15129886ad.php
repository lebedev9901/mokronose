<?php if(session('success')): ?>
    <div class="alert-success">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>
<div class="profile-pets-page">

    <div class="profile-pets-header">
        <div>
            <h1>🐾 Мои питомцы</h1>
            <p>Добавляйте питомцев, чтобы подбирать корм и товары точнее</p>
        </div>

        <button class="pet-btn pet-btn-primary" id="openPetModal" type="button">
            + Добавить питомца
        </button>
    </div>

    <div class="pets-list">
        <?php $__empty_1 = true; $__currentLoopData = $pets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="pet-card">

                <div class="pet-card__main">
                    <?php if($pet->avatar): ?>
                        <img src="<?php echo e(asset('storage/' . $pet->avatar)); ?>" class="pet-card__avatar-image" alt="<?php echo e($pet->name); ?>">
                    <?php else: ?>
                        <div class="pet-card__avatar">🐶</div>
                    <?php endif; ?>

                    <div>
                        <h3><?php echo e($pet->name); ?></h3>

                        <div class="pet-card__meta">
                            <?php if($pet->breed): ?>
                                <span><?php echo e($pet->breed); ?></span>
                            <?php endif; ?>

                            <?php if($pet->age_group): ?>
                                <span>
                                    <?php switch($pet->age_group):
                                        case ('puppy'): ?> Щенок <?php break; ?>
                                        <?php case ('junior'): ?> Юниор <?php break; ?>
                                        <?php case ('adult'): ?> Взрослый <?php break; ?>
                                        <?php default: ?> <?php echo e($pet->age_group); ?>

                                    <?php endswitch; ?>
                                </span>
                            <?php endif; ?>

                            <?php if($pet->breed_size): ?>
                                <span>
                                    <?php switch($pet->breed_size):
                                        case ('small'): ?> Мелкая порода <?php break; ?>
                                        <?php case ('medium'): ?> Средняя порода <?php break; ?>
                                        <?php case ('large'): ?> Крупная порода <?php break; ?>
                                        <?php default: ?> <?php echo e($pet->breed_size); ?>

                                    <?php endswitch; ?>
                                </span>
                            <?php endif; ?>

                            <?php if($pet->weight): ?>
                                <span><?php echo e($pet->weight); ?> кг</span>
                            <?php endif; ?>
                        </div>

                        <?php if($pet->notes): ?>
                            <p class="pet-card__notes"><?php echo e($pet->notes); ?></p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="pet-card__actions">
                    <button
                        class="pet-btn pet-btn-light edit-pet-btn"
                        type="button"
                        data-id="<?php echo e($pet->id); ?>"
                        data-name="<?php echo e($pet->name); ?>"
                        data-breed="<?php echo e($pet->breed); ?>"
                        data-age_group="<?php echo e($pet->age_group); ?>"
                        data-breed_size="<?php echo e($pet->breed_size); ?>"
                        data-weight="<?php echo e($pet->weight); ?>"
                        data-notes="<?php echo e($pet->notes); ?>"
                    >
                        Изменить
                    </button>

                    <form method="POST" action="<?php echo e(route('pets.destroy', $pet->id)); ?>">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>

                        <button class="pet-btn pet-btn-danger" type="submit" onclick="return confirm('Удалить питомца?')">
                            Удалить
                        </button>
                    </form>
                </div>

            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="pets-empty">
                🐶 У вас пока нет питомцев
            </div>
        <?php endif; ?>
    </div>

</div>


<div class="pet-modal" id="petModal">
    <div class="pet-modal__overlay" id="closePetOverlay"></div>

    <div class="pet-modal__content">
        <div class="pet-modal__header">
            <h2 id="petModalTitle">Добавить питомца</h2>
            <button class="pet-modal__close" id="closePetModal" type="button">×</button>
        </div>

        <form class="pet-form" id="petForm" method="POST" action="<?php echo e(route('pets.store')); ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="_method" id="petFormMethod" value="POST">

            <div class="pet-form__grid">
                <div class="pet-form__field">
                    <label>Имя</label>
                    <input type="text" name="name" id="petName" required>
                </div>

                <div class="pet-form__field">
                    <label>Порода</label>
                    <input type="text" name="breed" id="petBreed">
                </div>

                <div class="pet-form__field">
                    <label>Возраст</label>
                    <select name="age_group" id="petAgeGroup">
                        <option value="">Не указано</option>
                        <option value="puppy">Щенок</option>
                        <option value="junior">Юниор</option>
                        <option value="adult">Взрослый</option>
                    </select>
                </div>

                <div class="pet-form__field">
                    <label>Размер породы</label>
                    <select name="breed_size" id="petBreedSize">
                        <option value="">Не указано</option>
                        <option value="small">Маленькая</option>
                        <option value="medium">Средняя</option>
                        <option value="large">Крупная</option>
                    </select>
                </div>

                <div class="pet-form__field">
                    <label>Вес, кг</label>
                    <input type="number" step="0.1" name="weight" id="petWeight">
                </div>

                <div class="pet-form__field">
                    <label>Фото</label>
                    <input type="file" name="avatar" accept="image/*">
                </div>
            </div>

            <div class="pet-form__field">
                <label>Заметки</label>
                <textarea name="notes" id="petNotes"></textarea>
            </div>

            <div class="pet-form__actions">
                <button class="pet-btn pet-btn-light" type="button" id="cancelPetModal">
                    Отмена
                </button>

                <button class="pet-btn pet-btn-primary" type="submit">
                    Сохранить
                </button>
            </div>
        </form>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('petModal');
    const form = document.getElementById('petForm');

    const title = document.getElementById('petModalTitle');
    const method = document.getElementById('petFormMethod');

    const openBtn = document.getElementById('openPetModal');
    const closeBtn = document.getElementById('closePetModal');
    const cancelBtn = document.getElementById('cancelPetModal');
    const overlay = document.getElementById('closePetOverlay');

    const name = document.getElementById('petName');
    const breed = document.getElementById('petBreed');
    const ageGroup = document.getElementById('petAgeGroup');
    const breedSize = document.getElementById('petBreedSize');
    const weight = document.getElementById('petWeight');
    const notes = document.getElementById('petNotes');

    function openModal() {
        modal.classList.add('is-open');
    }

    function closeModal() {
        modal.classList.remove('is-open');
        form.reset();
        form.action = "<?php echo e(route('pets.store')); ?>";
        method.value = 'POST';
        title.textContent = 'Добавить питомца';
    }

    openBtn?.addEventListener('click', openModal);
    closeBtn?.addEventListener('click', closeModal);
    cancelBtn?.addEventListener('click', closeModal);
    overlay?.addEventListener('click', closeModal);

    document.querySelectorAll('.edit-pet-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.dataset.id;

            form.action = `/profile/pet/${id}`;
            method.value = 'PUT';

            title.textContent = 'Редактировать питомца';

            name.value = this.dataset.name || '';
            breed.value = this.dataset.breed || '';
            ageGroup.value = this.dataset.age_group || '';
            breedSize.value = this.dataset.breed_size || '';
            weight.value = this.dataset.weight || '';
            notes.value = this.dataset.notes || '';

            openModal();
        });
    });
});
</script><?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/profile/sections/pet.blade.php ENDPATH**/ ?>