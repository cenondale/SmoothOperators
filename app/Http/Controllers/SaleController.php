<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    public function index(): View
    {
        return view('sales.index', [
            'sales' => Sale::with(['product', 'customer', 'staff'])
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('sales.create', [
            'products' => Product::where('is_active', true)
                ->where('stock_quantity', '>', 0)
                ->orderBy('name')
                ->get(),

            'customers' => Customer::orderBy('full_name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => [
                'required',
                'integer',
                Rule::exists('products', 'id')
                    ->where(fn ($query) => $query->where('is_active', true)),
            ],
            'customer_id' => [
                'nullable',
                'integer',
                Rule::exists('customers', 'id'),
            ],
            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],
        ]);

        DB::transaction(function () use ($data, $request): void {
            $product = Product::whereKey($data['product_id'])
                ->lockForUpdate()
                ->firstOrFail();

            $quantity = (int) $data['quantity'];

            if ($product->stock_quantity < $quantity) {
                throw ValidationException::withMessages([
                    'quantity' => "Only {$product->stock_quantity} unit(s) are available.",
                ]);
            }

            $updated = Product::whereKey($product->id)
                ->where('stock_quantity', '>=', $quantity)
                ->decrement('stock_quantity', $quantity);

            if ($updated === 0) {
                throw ValidationException::withMessages([
                    'quantity' => 'The available stock changed. Please try again.',
                ]);
            }

            $totalPrice = $product->price * $quantity;

            Sale::create([
                'product_id' => $product->id,
                'customer_id' => $data['customer_id'] ?? null,
                'sold_by' => $request->user()->id,
                'quantity' => $quantity,
                'total_price' => $totalPrice,
                'created_at' => now(),
            ]);
        });

        return redirect()
            ->route('sales.index')
            ->with('success', 'Sale recorded successfully.');
    }
}
