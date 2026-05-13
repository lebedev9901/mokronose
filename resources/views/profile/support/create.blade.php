@extends('layouts.app')

@section('title', 'Новое обращение')

@section('content')

<div class="container">

    <div class="support-create">

        <div class="support-create-card">

            <h1 class="support-title">
                Новое обращение
            </h1>

            <form action="{{ route('support.store') }}"
                  method="POST"
                  class="support-form">

                @csrf

                {{-- SUBJECT --}}
                <div class="form-group">

                    <label>
                        Тема обращения
                    </label>

                    <input
                        type="text"
                        name="subject"
                        class="form-input"
                        placeholder="Например: Проблема с заказом"
                        value="{{ old('subject') }}"
                        required
                    >

                    @error('subject')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                {{-- MESSAGE --}}
                <div class="form-group">

                    <label>
                        Сообщение
                    </label>

                    <textarea
                        name="message"
                        class="form-textarea"
                        rows="8"
                        placeholder="Опишите вашу проблему..."
                        required
                    >{{ old('message') }}</textarea>

                    @error('message')
                        <div class="form-error">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <button class="support-btn">
                    Отправить обращение
                </button>

            </form>

        </div>

    </div>

</div>

@endsection