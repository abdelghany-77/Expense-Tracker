<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('expense_categories', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->string('name');
      $table->string('color', 7)->default('#3B82F6');
      $table->string('icon')->default('💰');
      $table->decimal('monthly_budget', 12, 2)->default(0);
      $table->boolean('is_essential')->default(false);
      $table->integer('sort_order')->default(0);
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('expense_categories');
  }
};
