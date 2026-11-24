<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-semibold text-gray-800">Record Sale</h2>
            <a href="{{ route('sales.index') }}" class="text-sm font-medium text-indigo-600 hover:underline">Sales History</a>
        </div>
    </x-slot>

    <div class="mx-auto max-w-3xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="rounded-lg bg-white p-6 shadow">
            @if ($products->isEmpty())
                <p class="text-sm text-gray-700">No products have stock available. Add stock before recording a sale.</p>
                <a href="{{ route('products.index') }}" class="mt-4 inline-block text-sm font-medium text-indigo-600 hover:underline">View products</a>
            @else
                <p class="mb-6 text-sm text-gray-600">Choose one product for this sale. The total is calculated from its current price when you submit.</p>

                <form method="POST" action="{{ route('sales.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="product_id" value="Product" />
                        <select id="product_id" name="product_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select a product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>
                                    {{ $product->name }} - ₱{{ number_format($product->price, 2) }} ({{ $product->stock_quantity }} in stock)
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('product_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="customer_id" value="Customer (optional)" />
                        <select id="customer_id" name="customer_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Walk-in customer</option>
                            @foreach ($customers as $customer)
                                <option value="{{ $customer->id }}" @selected(old('customer_id') == $customer->id)>{{ $customer->full_name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('customer_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="quantity" value="Quantity" />
                        <x-text-input id="quantity" name="quantity" type="number" min="1" step="1" :value="old('quantity', 1)" required class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                    </div>

                    <p class="text-sm text-gray-600">Recorded by {{ Auth::user()->full_name ?? Auth::user()->username }}.</p>

                    <x-primary-button>Record Sale</x-primary-button>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
