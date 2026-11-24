<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Smooth Operators POS') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        body{background:#f1f5f9;color:#0f172a}
        nav{background:rgba(255,255,255,.96)!important;border-bottom:1px solid #e2e8f0!important;box-shadow:0 1px 8px rgba(15,23,42,.04)}
        nav a{transition:color .2s,background .2s}
        nav a:hover{color:#4f46e5!important}
        header{background:rgba(255,255,255,.96)!important;border-bottom:1px solid #e2e8f0;box-shadow:none!important}
        main{background:#f1f5f9;min-height:calc(100vh - 9rem)}
        main>div:first-child:has(.text-red-600),main>div:first-child:has(.text-green-600){padding-top:1rem}
        main .bg-white{border:1px solid #e2e8f0;border-radius:1rem;box-shadow:0 4px 14px rgba(15,23,42,.05)}
        main h1,main h2,main h3{letter-spacing:-.02em}
        main input:not([type=checkbox]):not([type=radio]),main select,main textarea{border:1px solid #cbd5e1!important;border-radius:.65rem!important;background:#fff;transition:border-color .2s,box-shadow .2s}
        main input:not([type=checkbox]):not([type=radio]):focus,main select:focus,main textarea:focus{border-color:#818cf8!important;box-shadow:0 0 0 3px rgba(99,102,241,.15)!important;outline:none}
        main button[type=submit],main a[class*=bg-indigo],main a[class*=bg-blue]{border-radius:.6rem!important;box-shadow:0 4px 10px rgba(79,70,229,.15);transition:transform .2s,box-shadow .2s}
        main button[type=submit]:hover,main a[class*=bg-indigo]:hover,main a[class*=bg-blue]:hover{transform:translateY(-1px);box-shadow:0 7px 16px rgba(79,70,229,.2)}
        main table{width:100%;border-collapse:separate;border-spacing:0;overflow:hidden;border:1px solid #e2e8f0;border-radius:1rem;background:#fff;box-shadow:0 4px 14px rgba(15,23,42,.05)}
        main thead{background:#eef2ff;color:#3730a3}
        main th{font-size:.75rem;text-transform:uppercase;letter-spacing:.05em}
        main th,main td{padding:1rem;border-bottom:1px solid #eef2f7;text-align:left}
        main tbody tr:hover{background:#f8fafc}
        main tbody tr:last-child td{border-bottom:0}
        .pos-page-title{font-size:1.65rem;font-weight:700;color:#0f172a}
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen">
        @include('layouts.navigation')
        @isset($header)
            <header>
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset
        <main>
            <div class="mx-auto max-w-7xl px-4 pt-6 sm:px-6 lg:px-8">
                <x-flash-messages />
            </div>
            {{ $slot }}
        </main>
    </div>
</body>
</html>
