@extends('admin.layouts.app')

@section('title', 'Редактирование пользователя')
@section('page-title', 'Редактирование пользователя')
@section('page-subtitle', $user->name)

@section('content')

<form method="POST"
      action="{{ route('admin.users.update', $user->id) }}"
      class="admin-form">

    @csrf
    @method('PUT')

    <div class="admin-form-card">
        <h3>Данные пользователя</h3>

        <div class="admin-field">
            <label>Имя</label>
            <input type="text"
                   name="name"
                   value="{{ old('name', $user->name) }}"
                   required>
        </div>

        <div class="admin-field">
            <label>Email</label>
            <input type="email"
                   name="email"
                   value="{{ old('email', $user->email) }}"
                   required>
        </div>

        <div class="admin-field">
            <label>Роль</label>
            <select name="role">
                <option value="user" @selected(old('role', $user->role) === 'user')>
                    Пользователь
                </option>

                <option value="support" @selected(old('role', $user->role) === 'support')>
                    Поддержка
                </option>

                <option value="admin" @selected(old('role', $user->role) === 'admin')>
                    Администратор
                </option>
            </select>
        </div>
    </div>

    <div class="admin-form-actions">
        <a href="{{ route('admin.users') }}" class="admin-btn-light">
            Назад
        </a>

        <button class="admin-btn">
            Сохранить
        </button>
    </div>

</form>

@endsection