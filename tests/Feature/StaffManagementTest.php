<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StaffManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_pages_require_authentication(): void
    {
        $this->get(route('staff.index'))->assertRedirect(route('login'));
        $this->get(route('staff.create'))->assertRedirect(route('login'));
    }

    public function test_authenticated_staff_can_create_staff_with_avatar(): void
    {
        Storage::fake('public');
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('staff.store'), [
            'username' => 'new-staff',
            'full_name' => 'New Staff Member',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'avatar' => UploadedFile::fake()->image('avatar.png'),
        ]);

        $response->assertRedirect(route('staff.index'));

        $staff = User::where('username', 'new-staff')->firstOrFail();
        $this->assertSame('New Staff Member', $staff->full_name);
        $this->assertTrue(Hash::check('Password123!', $staff->password));
        $this->assertNotNull($staff->avatar);
        Storage::disk('public')->assertExists($staff->avatar);
    }

    public function test_authenticated_staff_can_update_staff_without_changing_password(): void
    {
        $admin = User::factory()->create();
        $staff = User::factory()->create([
            'username' => 'existing-staff',
            'full_name' => 'Existing Staff',
        ]);
        $originalPassword = $staff->password;

        $this->actingAs($admin)->put(route('staff.update', $staff), [
            'username' => 'updated-staff',
            'full_name' => 'Updated Staff',
        ])->assertRedirect(route('staff.index'));

        $staff->refresh();
        $this->assertSame('updated-staff', $staff->username);
        $this->assertSame('Updated Staff', $staff->full_name);
        $this->assertSame($originalPassword, $staff->password);
    }

    public function test_staff_with_sales_cannot_be_deleted(): void
    {
        $admin = User::factory()->create();
        $staff = User::factory()->create();
        $product = Product::create([
            'name' => 'Recorded Product',
            'price' => 10,
            'stock_quantity' => 1,
            'created_at' => now(),
        ]);
        $customer = Customer::create([
            'full_name' => 'Recorded Customer',
            'email' => 'recorded@example.com',
            'created_at' => now(),
        ]);

        $staff->sales()->create([
            'product_id' => $product->id,
            'customer_id' => $customer->id,
            'quantity' => 1,
            'total_price' => 10,
            'created_at' => now(),
        ]);

        $this->actingAs($admin)
            ->delete(route('staff.destroy', $staff))
            ->assertRedirect(route('staff.index'));

        $this->assertDatabaseHas('users', ['id' => $staff->id]);
    }
}
