<x-app-layout>
    <x-slot name="header"><h2 class="text-xl font-semibold text-gray-800">Edit Staff</h2></x-slot>
    <div class="mx-auto max-w-3xl p-6"><div class="rounded-lg bg-white p-6 shadow">
        @if ($staffMember->avatar)
            <img src="{{ Storage::disk('public')->url($staffMember->avatar) }}" alt="{{ $staffMember->full_name }}" class="mb-6 h-24 w-24 rounded-full object-cover">
        @endif
        <form method="POST" action="{{ route('staff.update', $staffMember) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')
            @include('staff.partials.form')
            <div class="flex gap-3"><x-primary-button>Update staff</x-primary-button><a href="{{ route('staff.index') }}" class="rounded bg-gray-200 px-4 py-2">Cancel</a></div>
        </form>
    </div></div>
</x-app-layout>
