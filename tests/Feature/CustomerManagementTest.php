<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CustomerManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_guests_are_redirected_to_login(): void
    {
        $this->get(route('customers.index'))->assertRedirect(route('login'));
    }

    public function test_staff_can_view_the_customer_pages(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get(route('customers.index'))->assertOk()->assertSee('Customers');
        $this->get(route('customers.create'))->assertOk()->assertSee('Add customer');
    }

    public function test_staff_can_create_and_update_a_customer(): void
    {
        $this->actingAs(User::factory()->create());

        $this->post(route('customers.store'), [
            'full_name' => 'Ana Cruz',
            'email' => 'ana@example.com',
            'phone' => '09171234567',
        ])->assertRedirect(route('customers.index'));

        $customer = Customer::firstOrFail();
        $this->assertNotNull($customer->created_at);

        $this->put(route('customers.update', $customer), [
            'full_name' => 'Ana Santos',
            'email' => 'ana@example.com',
            'phone' => '',
        ])->assertRedirect(route('customers.index'));

        $this->assertDatabaseHas('customers', [
            'id' => $customer->id,
            'full_name' => 'Ana Santos',
            'phone' => null,
        ]);
    }

    public function test_customer_fields_are_validated(): void
    {
        $this->actingAs(User::factory()->create());
        Customer::create([
            'full_name' => 'Existing Customer',
            'email' => 'existing@example.com',
            'created_at' => now(),
        ]);

        $this->post(route('customers.store'), [
            'full_name' => '',
            'email' => 'existing@example.com',
            'phone' => str_repeat('1', 21),
        ])->assertSessionHasErrors(['full_name', 'email', 'phone']);

        $this->assertDatabaseCount('customers', 1);
    }

    public function test_customer_with_sales_cannot_be_deleted(): void
    {
        $staff = User::factory()->create();
        $this->actingAs($staff);
        $customer = Customer::create([
            'full_name' => 'Ana Cruz',
            'email' => 'ana@example.com',
            'created_at' => now(),
        ]);
        $product = Product::create([
            'name' => 'Sample',
            'price' => 10,
            'stock_quantity' => 1,
            'created_at' => now(),
        ]);
        DB::table('sales')->insert([
            'customer_id' => $customer->id,
            'product_id' => $product->id,
            'sold_by' => $staff->id,
            'quantity' => 1,
            'total_price' => 10,
            'created_at' => now(),
        ]);

        $this->delete(route('customers.destroy', $customer))
            ->assertRedirect(route('customers.index'))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('customers', ['id' => $customer->id]);
    }

    public function test_customer_without_sales_can_be_deleted(): void
    {
        $this->actingAs(User::factory()->create());
        $customer = Customer::create([
            'full_name' => 'Ana Cruz',
            'email' => 'ana@example.com',
            'created_at' => now(),
        ]);

        $this->delete(route('customers.destroy', $customer))
            ->assertRedirect(route('customers.index'));

        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
    }
}
