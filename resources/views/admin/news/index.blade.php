@extends('admin.layouts.app')

@section('title', 'Новости')

@section('content')

<h1>Новости</h1>

<a href="{{ route('admin.news.create') }}" class="btn btn-primary">
    + Создать новость
</a>

<div style="margin-top:20px; display:grid; gap:15px;">
    @forelse($news as $item)
        <div style="display:flex; gap:15px; align-items:center; padding:15px; border:1px solid #ddd; border-radius:12px;">
            @if($item->image)
                <img src="{{ asset('storage/' . $item->image) }}"
                     style="width:100px; height:70px; object-fit:cover; border-radius:8px;">
            @endif

            <div style="flex:1;">
                <h3>{{ $item->title }}</h3>
                <p>{{ $item->description }}</p>

                <small>
                    {{ $item->is_active ? 'Активна' : 'Скрыта' }}
                    |
                    Сортировка: {{ $item->sort_order }}
                </small>
            </div>

            <a href="{{ route('admin.news.edit', $item) }}" class="btn">
                Редактировать
            </a>

            <form action="{{ route('admin.news.destroy', $item) }}" method="POST">
                @csrf
                @method('DELETE')

                <button onclick="return confirm('Удалить новость?')" class="btn btn-danger">
                    Удалить
                </button>
            </form>
        </div>
    @empty
        <p>Новостей пока нет.</p>
    @endforelse
</div>

@endsection