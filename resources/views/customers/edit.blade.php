<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Edit customer</h2>
    </x-slot>

    <div class="mx-auto max-w-2xl px-4 py-8 sm:px-6">
        <div class="rounded-lg bg-white p-6 shadow">
            <form method="POST" action="{{ route('customers.update', $customer) }}" class="space-y-6">
                @csrf
                @method('PUT')
                @include('customers.partials.form')
                <div class="flex items-center justify-end gap-4">
                    <a href="{{ route('customers.index') }}" class="text-sm text-gray-600 hover:underline">Cancel</a>
                    <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
