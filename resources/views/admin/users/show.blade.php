@extends('admin.layouts.app')

@section('title', 'Пользователь')
@section('page-title', 'Карточка пользователя')
@section('page-subtitle', 'Подробная информация о клиенте')

@section('content')

<div class="user-profile">


    {{-- HERO --}}
    <div class="user-profile__hero">


        <div class="user-profile__avatar">
            {{ mb_substr($user->name, 0, 1) }}
        </div>


        <div class="user-profile__info">


            <h1>
                {{ $user->name }}
            </h1>


            <div class="user-profile__badges">


                <span class="badge badge-primary">
                    ID #{{ $user->id }}
                </span>


                @if($user->role === 'admin')

                    <span class="badge badge-danger">
                        Администратор
                    </span>

                @elseif($user->role === 'support')

                    <span class="badge badge-info">
                        Поддержка
                    </span>

                @else

                    <span class="badge badge-success">
                        Пользователь
                    </span>

                @endif


            </div>



            <div class="user-profile__contacts">


                <div>
                    <strong>Email</strong>

                    <span>
                        {{ $user->email }}
                    </span>
                </div>



                <div>
                    <strong>Телефон</strong>

                    <span>
                        {{ $user->phone ?: 'Не указан' }}
                    </span>
                </div>



                <div>
                    <strong>Регистрация</strong>

                    <span>
                        {{ $user->created_at?->format('d.m.Y H:i') }}
                    </span>
                </div>


            </div>


        </div>


    </div>




    {{-- СТАТИСТИКА --}}

    <div class="stats-grid">


        <div class="stat-card">

            <span>
                {{ $stats['orders'] ?? 0 }}
            </span>

            <small>
                Заказов
            </small>

        </div>



        <div class="stat-card">

            <span>
                {{ number_format($stats['spent'] ?? 0,0,'',' ') }} ₽
            </span>

            <small>
                Потрачено
            </small>

        </div>



        <div class="stat-card">

            <span>
                {{ $stats['pets'] ?? 0 }}
            </span>

            <small>
                Питомцев
            </small>

        </div>



        <div class="stat-card">

            <span>
                {{ $stats['reviews'] ?? 0 }}
            </span>

            <small>
                Отзывов
            </small>

        </div>



        <div class="stat-card">

            <span>
                {{ $stats['favorites'] ?? 0 }}
            </span>

            <small>
                Избранное
            </small>

        </div>



        <div class="stat-card">

            <span>
                {{ $user->addresses?->count() ?? 0 }}
            </span>

            <small>
                Адресов
            </small>

        </div>


    </div>






    {{-- ПИТОМЦЫ --}}

    <div class="admin-card">


        <h2>
            🐶 Питомцы
        </h2>



        @forelse($user->pets as $pet)


            <div class="pet-card">


                <h3>
                    {{ $pet->name }}
                </h3>



                <div class="pet-grid">


                    <div>

                        <strong>
                            Порода
                        </strong>

                        <span>
                            {{ $pet->breed ?: 'Не указана' }}
                        </span>

                    </div>



                    <div>

                        <strong>
                            Возраст
                        </strong>

                        <span>
                              @switch($pet->age_group)
                                        @case('puppy') Щенок @break
                                        @case('junior') Юниор @break
                                        @case('adult') Взрослый @break
                                        @default {{ $pet->age_group }}
                                    @endswitch
                        </span>

                    </div>



                    <div>

                        <strong>
                            Размер породы
                        </strong>

                        <span>
                            @switch($pet->breed_size)
                                        @case('small') Мелкая порода @break
                                        @case('medium') Средняя порода @break
                                        @case('large') Крупная порода @break
                                        @default {{ $pet->breed_size }}
                                    @endswitch
                        </span>

                    </div>



                    <div>

                        <strong>
                            Вес
                        </strong>

                        <span>
                            {{ $pet->weight ? $pet->weight.' кг' : 'Не указан' }}
                        </span>

                    </div>



                </div>



            </div>


        @empty


            <p>
                Питомцев пока нет.
            </p>


        @endforelse


    </div>







    {{-- ЗАКАЗЫ --}}

    <div class="admin-card">


        <h2>
            Последние заказы
        </h2>



        @if($user->orders->count())


        <table class="admin-table">


            <thead>

                <tr>

                    <th>
                        №
                    </th>


                    <th>
                        Дата
                    </th>


                    <th>
                        Статус
                    </th>


                    <th>
                        Сумма
                    </th>


                    <th>
                        
                    </th>

                </tr>

            </thead>



            <tbody>


            @foreach($user->orders->sortByDesc('created_at')->take(10) as $order)


                <tr>


                    <td>
                        #{{ $order->id }}
                    </td>



                    <td>
                        {{ $order->created_at?->format('d.m.Y') }}
                    </td>



                    <td>

                        <span class="badge">

                            {{ $order->status_label }}

                        </span>

                    </td>



                    <td>

                        {{ number_format($order->total_after_discount ?? $order->total,0,'',' ') }} ₽

                    </td>



                    <td>


                        <a href="{{ route('admin.orders.show',$order) }}">

                            Открыть

                        </a>


                    </td>



                </tr>


            @endforeach



            </tbody>


        </table>


        @else


            <p>
                Заказов пока нет.
            </p>


        @endif


    </div>






    {{-- АДРЕСА --}}
<div class="admin-card">


    <h2>
        📍 Адреса доставки
    </h2>


    @forelse($user->addresses as $address)


        <div class="address-card">


            <div class="address-card__header">

                <strong>
                    {{ $address->city }}
                </strong>


                @if($address->is_default)

                    <span class="badge badge-success">
                        Основной
                    </span>

                @endif

            </div>



            <div class="address-card__body">


                <span>
                    ул. {{ $address->street }}
                </span>


                <span>
                    д. {{ $address->house }}
                </span>



                @if($address->apartment)

                    <span>
                        кв. {{ $address->apartment }}
                    </span>

                @endif


            </div>


        </div>


    @empty


        <p>
            Адресов пока нет.
        </p>


    @endforelse



</div>


</div>

@endsection