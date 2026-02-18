@extends('layouts.app')

@section('title', 'Профиль')
@section('content')
<div class="container">
<div class="profile-container" style="display:flex; gap:20px; align-items:flex-start; min-height:400px;">

    {{-- Меню слева --}}
    <div class="profile-menu" style="width:250px;">
        @include('profile.sections.menu', ['current_page' => $page])
    </div>

    {{-- Контент справа --}}
    <div class="profile-content" style="flex:1;">
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

        @include($section)
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>
</div>
@endsection
