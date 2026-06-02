<section class="profile-pets-page">
    <div class="profile-pets-header">
        <div>
            <h1>Мои питомцы</h1>
            <p>Добавляйте питомцев, чтобы мы могли подбирать товары под возраст и породу.</p>
        </div>

        <button type="button" class="pet-btn pet-btn-primary" onclick="openPetModal()">
            + Добавить питомца
        </button>
    </div>

    <div id="petsList" class="pets-list"></div>
</section>

<div id="petModal" class="pet-modal">
    <div class="pet-modal__overlay" onclick="closePetModal()"></div>

    <div class="pet-modal__content">
        <div class="pet-modal__header">
            <h2 id="petModalTitle">Добавить питомца</h2>

            <button type="button" class="pet-modal__close" onclick="closePetModal()">
                ×
            </button>
        </div>

        <form id="petForm" class="pet-form">
            <?php echo csrf_field(); ?>

            <input type="hidden" name="pet_id" id="petId">
            <div class="pet-form__field">
                <label>Фото питомца</label>

                <input
                    type="file"
                    name="avatar"
                    id="petAvatar"
                    accept="image/*"
                >

                <div id="avatarPreview" class="avatar-preview"></div>
            </div>
            <div class="pet-form__field">
                <label>Кличка</label>
                <input type="text" name="name" id="petName" required>
            </div>

            <div class="pet-form__field">
                <label>Порода</label>
                <input type="text" name="breed" id="petBreed">
            </div>

            <div class="pet-form__grid">
                <div class="pet-form__field">
                    <label>Возраст</label>
                    <select name="age_group" id="petAgeGroup">
                        <option value="">Не выбран</option>
                        <option value="puppy">Щенок</option>
                        <option value="junior">Юниор</option>
                        <option value="adult">Взрослый</option>
                    </select>
                </div>

                <div class="pet-form__field">
                    <label>Размер породы</label>
                    <select name="breed_size" id="petBreedSize">
                        <option value="">Не выбран</option>
                        <option value="small">Мелкая порода</option>
                        <option value="medium">Средняя порода</option>
                        <option value="large">Крупная порода</option>
                    </select>
                </div>
            </div>

            <div class="pet-form__grid">
                <div class="pet-form__field">
                    <label>Дата рождения</label>
                    <input type="date" name="birth_date" id="petBirthDate">
                </div>

                <div class="pet-form__field">
                    <label>Вес, кг</label>
                    <input type="number" step="0.01" min="0" max="200" name="weight" id="petWeight">
                </div>
            </div>

            <div class="pet-form__field">
                <label>Особенности питомца</label>
                <textarea name="notes" id="petNotes"></textarea>
            </div>

            <div class="pet-form__actions">
                <button type="button" class="pet-btn pet-btn-light" onclick="closePetModal()">
                    Отмена
                </button>

                <button type="submit" class="pet-btn pet-btn-primary">
                    Сохранить
                </button>
            </div>
        </form>
    </div>
</div>

<script>
const petForm = document.getElementById('petForm');
const petsList = document.getElementById('petsList');
const petModal = document.getElementById('petModal');
const petModalTitle = document.getElementById('petModalTitle');

const petId = document.getElementById('petId');
const petName = document.getElementById('petName');
const petBreed = document.getElementById('petBreed');
const petAgeGroup = document.getElementById('petAgeGroup');
const petBreedSize = document.getElementById('petBreedSize');
const petBirthDate = document.getElementById('petBirthDate');
const petWeight = document.getElementById('petWeight');
const petNotes = document.getElementById('petNotes');

const ageLabels = {
    puppy: 'Щенок',
    junior: 'Юниор',
    adult: 'Взрослый',
};

const breedLabels = {
    small: 'Мелкая порода',
    medium: 'Средняя порода',
    large: 'Крупная порода',
};

document.getElementById('petAvatar')?.addEventListener('change', function(e){

    const file = e.target.files[0];

    if (!file) return;

    const reader = new FileReader();

    reader.onload = function(event){

        document.getElementById('avatarPreview').innerHTML = `
            <img
                src="${event.target.result}"
                style="
                    width:120px;
                    height:120px;
                    border-radius:50%;
                    object-fit:cover;
                "
            >
        `;
    };

    reader.readAsDataURL(file);
});

function openPetModal(pet = null) {
    petForm.reset();

    if (pet) {
        petModalTitle.textContent = 'Редактировать питомца';

        petId.value = pet.id;
        petName.value = pet.name ?? '';
        petBreed.value = pet.breed ?? '';
        petAgeGroup.value = pet.age_group ?? '';
        petBreedSize.value = pet.breed_size ?? '';
        petBirthDate.value = pet.birth_date ?? '';
        petWeight.value = pet.weight ?? '';
        petNotes.value = pet.notes ?? '';
    } else {
        petModalTitle.textContent = 'Добавить питомца';
        petId.value = '';
    }

    petModal.classList.add('is-open');
}

function closePetModal() {
    petModal.classList.remove('is-open');
}

function renderPet(pet) {
    const div = document.createElement('div');
    div.className = 'pet-card';
    div.dataset.id = pet.id;

    div.innerHTML = `
        <div class="pet-card__main">
            ${
                pet.avatar
                    ? `<img src="/storage/${pet.avatar}" class="pet-card__avatar-image">`
                    : `<div class="pet-card__avatar">🐶</div>`
            }

            <div>
                <h3>${pet.name}</h3>

                <div class="pet-card__meta">
                    ${pet.breed ? `<span>${pet.breed}</span>` : ''}
                    ${pet.age_group ? `<span>${ageLabels[pet.age_group] ?? pet.age_group}</span>` : ''}
                    ${pet.breed_size ? `<span>${breedLabels[pet.breed_size] ?? pet.breed_size}</span>` : ''}
                    ${pet.weight ? `<span>${pet.weight} кг</span>` : ''}
                </div>

                ${pet.notes ? `<p class="pet-card__notes">${pet.notes}</p>` : ''}
            </div>
        </div>

        <div class="pet-card__actions">
            <button type="button" class="pet-btn pet-btn-light" onclick='openPetModal(${JSON.stringify(pet)})'>
                Редактировать
            </button>

            <button type="button" class="pet-btn pet-btn-danger" onclick="deletePet(${pet.id})">
                Удалить
            </button>
        </div>
    `;

    return div;
}

function loadPets() {
    fetch('<?php echo e(route('pets.index')); ?>', {
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        petsList.innerHTML = '';

        if (!data.pets.length) {
            petsList.innerHTML = `
                <div class="pets-empty">
                    <h3>Питомцев пока нет</h3>
                    <p>Добавьте первого питомца, чтобы получать рекомендации по товарам.</p>
                </div>
            `;
            return;
        }

        data.pets.forEach(pet => {
            petsList.appendChild(renderPet(pet));
        });
    });
}

petForm.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(petForm);
    const id = petId.value;

    let url = '<?php echo e(route('pets.store')); ?>';
    let method = 'POST';

    if (id) {
        url = `/profile/pet/${id}`;
        formData.append('_method', 'PUT');
    }

    fetch(url, {
        method: method,
        headers: {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success) return;

        closePetModal();
        loadPets();
    });
});

function deletePet(id) {
   

    fetch(`/profile/pet/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success) return;

        loadPets();
    });
}

loadPets();
</script>

<?php /**PATH C:\Users\AdminPC\Herd\mokronose\resources\views/profile/sections/pet.blade.php ENDPATH**/ ?>