<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        {{-- <meta name="viewport" content="width=device-width, initial-scale=1"> --}}
        <meta name ="viewport" content ="initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="wx_openid" content="{{ $openid }}">
        <meta name="token" content="{{ $token }}">
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <title>Laravel Wechat</title>
    </head>
    <body>
        <div id="app">
            <app></app>
        </div>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
