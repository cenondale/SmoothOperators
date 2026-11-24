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
        body{margin:0;background:linear-gradient(135deg,#eef2ff,#f8fafc 55%,#fae8ff);color:#0f172a}
        .guest-shell{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:2rem 1rem}
        .guest-box{width:100%;max-width:28rem}
        .guest-brand{text-align:center;margin-bottom:1.25rem;color:#4338ca;font-size:1.1rem;font-weight:700;letter-spacing:.02em}
        .guest-card{background:rgba(255,255,255,.95);border:1px solid #e2e8f0;border-radius:1rem;padding:1.75rem;box-shadow:0 18px 45px rgba(79,70,229,.12)}
        .guest-card input{border-radius:.6rem!important;border-color:#cbd5e1!important}
        .guest-card input:focus{border-color:#818cf8!important;box-shadow:0 0 0 3px rgba(99,102,241,.15)!important}
        .guest-card button{border-radius:.6rem!important;background:#4f46e5!important;transition:transform .2s,background .2s}
        .guest-card button:hover{background:#4338ca!important;transform:translateY(-1px)}
        .guest-card a{color:#4f46e5}
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="guest-shell">
        <div class="guest-box">
            <div class="guest-brand">Smooth Operators POS</div>
            <div class="guest-card">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>