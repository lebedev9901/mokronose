@extends('emails.layout')

@section('content')

<h2 style="margin:0 0 15px;font-size:24px;">
    Новое сообщение от поддержки
</h2>

<p style="font-size:16px;line-height:1.6;">
    В чате поддержки появился новый ответ.
</p>

<div style="background:#FAF7F2;border-radius:14px;padding:18px;margin:25px 0;">
    <p>
        <strong>Чат:</strong>
        {{ $chat->subject ?? ('Чат #' . $chat->id) }}
    </p>

    <p>
        <strong>Статус:</strong>
        {{ $chat->status_label ?? $chat->status }}
    </p>
</div>

<div style="background:#ffffff;border:1px solid #eee;border-radius:12px;padding:18px;margin-bottom:20px;">
    {{ $supportMessage->message }}
</div>

<a href="{{ url('/profile/support/' . $chat->id) }}"
   style="display:inline-block;background:#A86E2C;color:#fff;text-decoration:none;padding:14px 22px;border-radius:12px;">
    Открыть чат поддержки
</a>

@endsection