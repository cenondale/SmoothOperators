<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SmoothOperators POS') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-950 text-white">
    <main class="relative isolate overflow-hidden">
        <div class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top_right,_rgba(99,102,241,0.28),_transparent_42%),radial-gradient(circle_at_bottom_left,_rgba(20,184,166,0.18),_transparent_38%)]"></div>

        <nav class="mx-auto flex max-w-7xl items-center justify-between px-6 py-6 lg:px-8">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-500 text-lg font-black shadow-lg shadow-indigo-500/30">S</span>
                <span class="text-lg font-bold tracking-tight">SmoothOperators</span>
            </a>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="rounded-lg bg-white px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-slate-200">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="rounded-lg px-4 py-2 text-sm font-semibold text-slate-200 transition hover:text-white">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="rounded-lg bg-white px-4 py-2 text-sm font-semibold text-slate-900 transition hover:bg-slate-200">Register</a>
                    @endif
                @endauth
            </div>
        </nav>

        <section class="mx-auto grid max-w-7xl items-center gap-14 px-6 pb-24 pt-16 lg:grid-cols-[1.1fr_0.9fr] lg:px-8 lg:pb-32 lg:pt-24">
            <div>
                <p class="mb-5 text-sm font-semibold uppercase tracking-[0.25em] text-indigo-300">Point of Sale Management</p>
                <h1 class="max-w-3xl text-5xl font-black tracking-tight text-white sm:text-6xl">Run every sale with confidence.</h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">SmoothOperators brings products, customers, staff, inventory, and sales history together in one simple workspace.</p>
                <div class="mt-9 flex flex-wrap gap-4">
                    @auth
                        <a href="{{ route('sales.create') }}" class="rounded-xl bg-indigo-500 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-500/25 transition hover:bg-indigo-400">Record a sale</a>
                        <a href="{{ route('products.index') }}" class="rounded-xl border border-slate-700 px-5 py-3 text-sm font-bold text-slate-200 transition hover:border-slate-500 hover:text-white">Manage products</a>
                    @else
                        <a href="{{ route('login') }}" class="rounded-xl bg-indigo-500 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-indigo-500/25 transition hover:bg-indigo-400">Get started</a>
                        <a href="#features" class="rounded-xl border border-slate-700 px-5 py-3 text-sm font-bold text-slate-200 transition hover:border-slate-500 hover:text-white">Explore features</a>
                    @endauth
                </div>
            </div>

            <div class="rounded-3xl border border-white/10 bg-white/10 p-5 shadow-2xl shadow-indigo-950/40 backdrop-blur">
                <div class="rounded-2xl bg-slate-900 p-6 ring-1 ring-white/10">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-5">
                        <div><p class="text-xs uppercase tracking-widest text-slate-500">Workspace</p><p class="mt-1 text-lg font-bold">Today's overview</p></div>
                        <span class="rounded-full bg-emerald-400/10 px-3 py-1 text-xs font-semibold text-emerald-300">Live</span>
                    </div>
                    <div class="grid grid-cols-2 gap-4 py-6">
                        <div class="rounded-2xl bg-slate-800 p-4"><p class="text-sm text-slate-400">Inventory</p><p class="mt-2 text-2xl font-bold">Organized</p><p class="mt-1 text-xs text-emerald-300">Stock at a glance</p></div>
                        <div class="rounded-2xl bg-slate-800 p-4"><p class="text-sm text-slate-400">Sales</p><p class="mt-2 text-2xl font-bold">Tracked</p><p class="mt-1 text-xs text-indigo-300">Every transaction</p></div>
                    </div>
                    <div class="rounded-2xl border border-dashed border-slate-700 p-4 text-sm text-slate-400">A clear view of the work that keeps your store moving.</div>
                </div>
            </div>
        </section>

        <section id="features" class="mx-auto max-w-7xl border-t border-white/10 px-6 py-16 lg:px-8">
            <div class="grid gap-5 md:grid-cols-3">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6"><div class="mb-5 text-2xl">◈</div><h2 class="font-bold">Manage inventory</h2><p class="mt-2 text-sm leading-6 text-slate-400">Keep product information, pricing, images, and available stock in one place.</p></div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6"><div class="mb-5 text-2xl">◎</div><h2 class="font-bold">Know your customers</h2><p class="mt-2 text-sm leading-6 text-slate-400">Maintain customer records and connect optional customer details to every sale.</p></div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6"><div class="mb-5 text-2xl">↗</div><h2 class="font-bold">Record with confidence</h2><p class="mt-2 text-sm leading-6 text-slate-400">Protect stock levels with validated sales and a complete transaction history.</p></div>
            </div>
        </section>

        <section class="mx-auto max-w-7xl border-t border-white/10 px-6 py-16 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-indigo-300">The Team</p>
                <h2 class="mt-3 text-3xl font-black tracking-tight text-white">Built by SmoothOperators</h2>
                <p class="mt-4 text-slate-400">A collaborative Point-of-Sale project built by our team.</p>
            </div>
            <div class="mx-auto mt-8 grid max-w-4xl gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-5 text-center text-sm font-semibold text-slate-200">Macaraeg, Cenon Dale C.</div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-5 text-center text-sm font-semibold text-slate-200">Espino, Renzo Miguel</div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-5 text-center text-sm font-semibold text-slate-200">Morales, Alexandra Gwen P.</div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-5 text-center text-sm font-semibold text-slate-200">Sacramento, Lanz Allen B.</div>
            </div>
        </section>

        <footer class="mx-auto max-w-7xl px-6 pb-8 text-sm text-slate-500 lg:px-8">SmoothOperators POS · A complete workspace for everyday sales operations.</footer>
    </main>
</body>
</html>
