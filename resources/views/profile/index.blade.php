@extends('layouts.app')

@section('title', 'Профиль')
@section('content')
<div class="container">
<div class="dashboard" >

    {{-- Меню слева --}}
    <div class="dashboard__sidebar" >
        @include('profile.sections.menu', ['current_page' => $page])
    </div>

    {{-- Контент справа --}}
    <div class="dashboard__content" >
        @php
            $section = match($page) {
                'orders'    => 'profile.sections.orders',
                'pet'       => 'profile.sections.pet',
                'addresses' => 'profile.sections.addresses',
                'support'   => 'profile.sections.support',
                'reviews'   => 'profile.sections.reviews',
                default     => 'profile.sections.profile',
            };
        @endphp

        @include($section, ['page' => $page, 'orders' => $orders])
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>
</div>
@endsection
