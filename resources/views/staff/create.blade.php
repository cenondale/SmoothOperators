<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Add Staff</h2></x-slot>
    <div class="mx-auto max-w-3xl p-6"><div class="rounded-lg bg-white p-6 shadow">
        <form method="POST" action="{{ route('staff.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @include('staff.partials.form')
            <div class="flex gap-3"><x-primary-button>Save staff</x-primary-button><a href="{{ route('staff.index') }}" class="rounded bg-gray-200 px-4 py-2">Cancel</a></div>
        </form>
    </div></div>
</x-app-layout>
