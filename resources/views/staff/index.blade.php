<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-semibold text-gray-800">Staff</h2>
            <a href="{{ route('staff.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Add staff</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="overflow-x-auto rounded-lg bg-white shadow">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-left text-gray-600">
                    <tr><th class="px-6 py-3">Avatar</th><th class="px-6 py-3">Username</th><th class="px-6 py-3">Full name</th><th class="px-6 py-3">Actions</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($staff as $staffMember)
                        <tr>
                            <td class="px-6 py-4">
                                @if ($staffMember->avatar)
                                    <img src="{{ Storage::disk('public')->url($staffMember->avatar) }}" alt="{{ $staffMember->full_name }}" class="h-10 w-10 rounded-full object-cover">
                                @else
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-200 text-xs text-gray-500">N/A</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-700">{{ $staffMember->username }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $staffMember->full_name }}</td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <a href="{{ route('staff.edit', $staffMember) }}" class="font-medium text-indigo-600 hover:underline">Edit</a>
                                <form method="POST" action="{{ route('staff.destroy', $staffMember) }}" class="ml-4 inline" onsubmit="return confirm('Delete this staff member?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="font-medium text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-6 py-10 text-center text-gray-500">No staff members yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $staff->links() }}</div>
    </div>
</x-app-layout>
