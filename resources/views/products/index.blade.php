<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-800">
                Products
            </h2>

            <a href="{{ route('products.create') }}"
               class="rounded bg-blue-600 px-4 py-2 text-sm font-semibold text-white">
                Add Product
            </a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-7xl p-6">
        @if (session('success'))
            <div class="mb-4 rounded bg-green-100 p-4 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-hidden rounded-lg bg-white shadow">
            <table class="min-w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left">Image</th>
                        <th class="px-6 py-3 text-left">Name</th>
                        <th class="px-6 py-3 text-left">Price</th>
                        <th class="px-6 py-3 text-left">Stock</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($products as $product)
                        <tr class="border-t">
                            <td class="px-6 py-4">
                                @if ($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         class="h-12 w-12 rounded object-cover">
                                @else
                                    <span class="text-gray-400">No image</span>
                                @endif
                            </td>

                            <td class="px-6 py-4">{{ $product->name }}</td>

                            <td class="px-6 py-4">
                                ₱{{ number_format($product->price, 2) }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $product->stock_quantity }}
                            </td>

                            <td class="px-6 py-4">
                                <a href="{{ route('products.edit', $product) }}"
                                   class="text-blue-600">
                                    Edit
                                </a>

                                <form method="POST"
                                      action="{{ route('products.destroy', $product) }}"
                                      class="ml-3 inline">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            class="text-red-600"
                                            onclick="return confirm('Delete this product?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                                No products found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>