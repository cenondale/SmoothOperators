<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get(route('products.index'))
            ->assertRedirect(route('login'));
    }

    public function test_staff_can_create_a_product_with_an_image(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('products.store'), [
            'name' => 'Notebook',
            'price' => '45.00',
            'stock_quantity' => 20,
            'image' => UploadedFile::fake()->image('notebook.jpg'),
        ]);

        $response->assertRedirect(route('products.index'));

        $product = Product::firstOrFail();
        $this->assertSame('Notebook', $product->name);
        $this->assertNotNull($product->image);
        Storage::disk('public')->assertExists($product->image);
    }

    public function test_negative_price_and_stock_are_rejected(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('products.store'), [
            'name' => 'Invalid Product',
            'price' => '-1',
            'stock_quantity' => -5,
        ]);

        $response->assertSessionHasErrors(['price', 'stock_quantity']);
        $this->assertDatabaseMissing('products', ['name' => 'Invalid Product']);
    }

    public function test_product_without_sales_can_be_deleted(): void
    {
        $user = User::factory()->create();
        $product = Product::create([
            'name' => 'Disposable Product',
            'price' => 10,
            'stock_quantity' => 2,
            'created_at' => now(),
        ]);

        $this->actingAs($user)
            ->delete(route('products.destroy', $product))
            ->assertRedirect(route('products.index'));

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    public function test_product_with_sales_is_archived_instead_of_deleted(): void
    {
        $user = User::factory()->create();
        $customer = Customer::create([
            'full_name' => 'Test Customer',
            'email' => 'customer@example.com',
            'phone' => null,
            'created_at' => now(),
        ]);
        $product = Product::create([
            'name' => 'Historical Product',
            'price' => 25,
            'stock_quantity' => 4,
            'created_at' => now(),
        ]);

        $this->actingAs($user)->post(route('products.store'), [
            'name' => 'Unrelated Product',
            'price' => 5,
            'stock_quantity' => 1,
        ]);

        $this->assertDatabaseHas('products', ['name' => 'Unrelated Product']);

        $product->sales()->create([
            'customer_id' => $customer->id,
            'sold_by' => $user->id,
            'quantity' => 1,
            'total_price' => 25,
            'created_at' => now(),
        ]);

        $this->actingAs($user)
            ->delete(route('products.destroy', $product))
            ->assertRedirect(route('products.index'));

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'is_active' => false,
        ]);
    }
}
