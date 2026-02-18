<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Laravel' }}</title>
    @filamentStyles
      @vite(['resources/css/app.css', 'resources/js/app.js']) <!-- подключение стилей, если используешь Vite -->
</head>
<body class="bg-gray-100 font-sans">
    <div class="min-h-screen flex flex-col justify-center items-center">
        {{ $slot }}
    </div>
     @filamentScripts
</body>
</html>
