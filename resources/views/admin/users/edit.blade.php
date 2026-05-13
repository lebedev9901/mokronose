@extends('admin.layouts.app')

@section('title', 'Редактирование товара')

@section('content')

<h1>Редактирование товара</h1>

<form method="POST" action="{{ route('admin.users.update', $user->id) }}">
    @csrf
    @method('PUT')

    <input name="name" value="{{ $user->name }}">
    <input name="email" value="{{ $user->email }}">



    <select name="role">
        <option value="user" @selected($user->role == 'user')>User</option>
        <option value="support" @selected($user->role == 'support')>Support</option>
        <option value="admin" @selected($user->role == 'admin')>Admin</option>
    </select>

    <button>Сохранить</button>
</form>

@endsection