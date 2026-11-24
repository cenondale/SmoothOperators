<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Dashboard</h2>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="rounded-lg bg-white p-6 shadow">
            <h3 class="text-lg font-semibold text-gray-900">Welcome, {{ Auth::user()->full_name ?? Auth::user()->name ?? Auth::user()->username }}!</h3>
            <p class="mt-2 text-sm text-gray-600">Choose an area to manage.</p>
        </div>

        <div class="mt-6 grid gap-4 sm:grid-cols-2">
            @if (Route::has('customers.index'))
                <a href="{{ route('customers.index') }}" class="rounded-lg bg-white p-6 shadow transition hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <h3 class="font-semibold text-gray-900">Customers</h3>
                    <p class="mt-2 text-sm text-gray-600">View, add, and update customer records.</p>
                </a>
            @endif
            @if (Route::has('products.index'))
                <a href="{{ route('products.index') }}" class="rounded-lg bg-white p-6 shadow transition hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <h3 class="font-semibold text-gray-900">Products</h3>
                    <p class="mt-2 text-sm text-gray-600">View products and available stock.</p>
                </a>
            @endif
            <a href="{{ route('sales.create') }}" class="rounded-lg bg-white p-6 shadow transition hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <h3 class="font-semibold text-gray-900">Record Sale</h3>
                <p class="mt-2 text-sm text-gray-600">Sell a product and update its stock.</p>
            </a>
            <a href="{{ route('sales.index') }}" class="rounded-lg bg-white p-6 shadow transition hover:shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <h3 class="font-semibold text-gray-900">Sales History</h3>
                <p class="mt-2 text-sm text-gray-600">Review past transactions.</p>
            </a>
        </div>
    </div>
</x-app-layout>
