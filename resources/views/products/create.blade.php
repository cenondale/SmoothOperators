<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">
            Add Product
        </h2>
    </x-slot>

    <div class="mx-auto max-w-3xl p-6">
        <div class="rounded-lg bg-white p-6 shadow">
            <form method="POST"
                  action="{{ route('products.store') }}"
                  enctype="multipart/form-data">

                @csrf

                <div class="mb-4">
                    <label class="block font-medium">Product Name</label>
                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           class="mt-1 w-full rounded border-gray-300">

                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Price</label>
                    <input type="number"
                           name="price"
                           step="0.01"
                           min="0"
                           value="{{ old('price') }}"
                           class="mt-1 w-full rounded border-gray-300">

                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium">Stock Quantity</label>
                    <input type="number"
                           name="stock_quantity"
                           min="0"
                           value="{{ old('stock_quantity', 0) }}"
                           class="mt-1 w-full rounded border-gray-300">

                    @error('stock_quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label class="block font-medium">Product Image</label>
                    <input type="file"
                           name="image"
                           accept="image/jpeg,image/png"
                           class="mt-1 w-full">

                    @error('image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3">
                    <button type="submit"
                            class="rounded bg-blue-600 px-4 py-2 font-semibold text-white">
                        Save Product
                    </button>

                    <a href="{{ route('products.index') }}"
                       class="rounded bg-gray-200 px-4 py-2">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>