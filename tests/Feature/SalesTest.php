<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SalesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_sales_pages_require_a_logged_in_staff_member(): void
    {
        $this->get(route('sales.create'))->assertRedirect(route('login'));
        $this->get(route('sales.index'))->assertRedirect(route('login'));
        $this->post(route('sales.store'), [])->assertRedirect(route('login'));
    }

    public function test_a_sale_records_the_customer_and_staff_and_reduces_stock(): void
    {
        $staff = $this->staff();
        $product = $this->product();
        $customer = Customer::create([
            'full_name' => 'Sample Customer',
            'email' => 'customer@example.com',
            'created_at' => now(),
        ]);

        $this->actingAs($staff)->get(route('sales.create'))
            ->assertOk()
            ->assertSee('Sample Product')
            ->assertSee('Sample Customer');

        $this->actingAs($staff)->post(route('sales.store'), [
            'product_id' => $product->id,
            'customer_id' => $customer->id,
            'quantity' => 3,
            'total_price' => '0.01',
            'sold_by' => 999,
        ])->assertRedirect(route('sales.index'));

        $this->assertSame(7, $product->fresh()->stock_quantity);
        $this->assertDatabaseHas('sales', [
            'product_id' => $product->id,
            'customer_id' => $customer->id,
            'sold_by' => $staff->id,
            'quantity' => 3,
            'total_price' => '37.50',
        ]);

        $this->actingAs($staff)->get(route('sales.index'))
            ->assertOk()
            ->assertSee('Sample Product')
            ->assertSee('Sample Customer')
            ->assertSee('Sample Staff')
            ->assertSee('37.50');
    }

    public function test_walk_in_sale_works_without_a_customer(): void
    {
        $this->actingAs($this->staff())->post(route('sales.store'), [
            'product_id' => $this->product()->id,
            'quantity' => 1,
        ])->assertRedirect(route('sales.index'));

        $this->assertDatabaseHas('sales', ['customer_id' => null, 'total_price' => '12.50']);
        $this->get(route('sales.index'))->assertSee('Walk-in customer');
    }

    public function test_overselling_is_rejected_without_changing_stock(): void
    {
        $product = $this->product();

        $this->actingAs($this->staff())->post(route('sales.store'), [
            'product_id' => $product->id,
            'quantity' => 11,
        ])->assertSessionHasErrors('quantity');

        $this->assertSame(10, $product->fresh()->stock_quantity);
        $this->assertDatabaseCount('sales', 0);
    }

    public function test_archived_products_cannot_be_sold(): void
    {
        $product = $this->product();
        $product->update(['is_active' => false]);

        $this->actingAs($this->staff())->post(route('sales.store'), [
            'product_id' => $product->id,
            'quantity' => 1,
        ])->assertSessionHasErrors('product_id');

        $this->assertSame(10, $product->fresh()->stock_quantity);
        $this->assertDatabaseCount('sales', 0);
    }

    public function test_quantity_must_be_a_positive_whole_number(): void
    {
        $product = $this->product();
        $this->actingAs($this->staff());

        foreach (['0', '-1', '1.5'] as $quantity) {
            $this->post(route('sales.store'), [
                'product_id' => $product->id,
                'quantity' => $quantity,
            ])->assertSessionHasErrors('quantity');
        }

        $this->assertSame(10, $product->fresh()->stock_quantity);
        $this->assertDatabaseCount('sales', 0);
    }

    private function staff(): User
    {
        return User::create([
            'username' => 'sales-staff',
            'full_name' => 'Sample Staff',
            'password' => 'password',
            'created_at' => now(),
        ]);
    }

    private function product(): Product
    {
        return Product::create([
            'name' => 'Sample Product',
            'price' => '12.50',
            'stock_quantity' => 10,
            'is_active' => true,
            'created_at' => now(),
        ]);
    }
}
