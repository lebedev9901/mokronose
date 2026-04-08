@extends('layouts.app')

@section('title', 'Профиль')
@section('content')
<div class="container">
<div class="profile-container" >

    {{-- Меню слева --}}
    <div class="profile-menu" >
        @include('profile.sections.menu', ['current_page' => $page])
    </div>

    {{-- Контент справа --}}
    <div class="profile-content" >
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
