@extends('admin.layouts.app')

@section('title', 'Пользователи')
@section('page-title', 'Пользователи')
@section('page-subtitle', 'Управление аккаунтами пользователей')

@section('content')

<div class="admin-page-head">
    <div>
        <h2>Список пользователей</h2>
        <p>Всего пользователей: {{ $users->count() }}</p>
    </div>
</div>

<div class="admin-table-wrap">
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Пользователь</th>
                <th>Email</th>
                <th>Роль</th>
                <th>Дата регистрации</th>
                <th>Действия</th>
            </tr>
        </thead>

        <tbody>
            @forelse($users as $user)
                <tr>
                    <td class="admin-muted">#{{ $user->id }}</td>

                    <td>
                        <strong>{{ $user->name }}</strong>
                    </td>

                    <td>{{ $user->email }}</td>

                    <td>
                        @if($user->role === 'admin')
                            <span class="admin-status admin-status--danger">Админ</span>
                        @elseif($user->role === 'support')
                            <span class="admin-status admin-status--info">Поддержка</span>
                        @else
                            <span class="admin-status admin-status--success">Пользователь</span>
                        @endif
                    </td>

                    <td>{{ $user->created_at->format('d.m.Y H:i') }}</td>

                    <td>
                        <div class="admin-actions">
                            <a href="{{ route('admin.users.edit', $user->id) }}"
                               class="admin-btn-light">
                                Изменить
                            </a>

                            <form method="POST"
                                  action="{{ route('admin.users.destroy', $user->id) }}"
                                  onsubmit="return confirm('Удалить пользователя?')">
                                @csrf
                                @method('DELETE')

                                <button class="admin-btn-danger">
                                    Удалить
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="admin-empty">
                        Пользователи не найдены
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection