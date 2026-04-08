<h1>Профиль</h1>
<div class="dashboard">

    <div class="profile-card">
        <div class="profile-avatar">
            <img src="{{ $user->avatar ?? '/img/default-avatar.png' }}" alt="">
        </div>

        <div class="profile-info">
            <h2>{{ $user->name }}</h2>
            <p>{{ $user->email }}</p>
        </div>

        <div class="profile-actions">
            <a href="#" class="btn">Редактировать</a>
        </div>
    </div>

</div>