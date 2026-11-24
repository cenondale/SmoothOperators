<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-semibold text-gray-800">Sales History</h2>
            <a href="{{ route('sales.create') }}" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Record Sale</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="overflow-x-auto rounded-lg bg-white shadow">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-left text-gray-600">
                    <tr>
                        <th scope="col" class="px-6 py-3">Date</th>
                        <th scope="col" class="px-6 py-3">Product</th>
                        <th scope="col" class="px-6 py-3">Customer</th>
                        <th scope="col" class="px-6 py-3">Staff</th>
                        <th scope="col" class="px-6 py-3 text-right">Quantity</th>
                        <th scope="col" class="px-6 py-3 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($sales as $sale)
                        <tr>
                            <td class="whitespace-nowrap px-6 py-4 text-gray-700">{{ $sale->created_at->format('M j, Y g:i A') }}</td>
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $sale->product?->name ?? 'Unavailable product' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $sale->customer?->full_name ?? 'Walk-in customer' }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $sale->staff?->full_name ?? $sale->staff?->username ?? 'Unavailable staff' }}</td>
                            <td class="px-6 py-4 text-right text-gray-700">{{ $sale->quantity }}</td>
                            <td class="whitespace-nowrap px-6 py-4 text-right font-medium text-gray-900">₱{{ number_format($sale->total_price, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-6 py-10 text-center text-gray-500">No sales recorded yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">{{ $sales->links() }}</div>
    </div>
</x-app-layout>
