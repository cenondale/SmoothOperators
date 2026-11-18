<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->string('username', 50)->nullable()->unique()->after('id');
        $table->string('full_name', 100)->nullable()->after('username');
        $table->string('avatar')->nullable()->after('password');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['username', 'full_name', 'avatar']);
    });
}
};
