<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('financial_plans', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->string('name');
      $table->text('description')->nullable();
      $table->decimal('monthly_income', 12, 2);
      $table->decimal('monthly_savings_target', 12, 2);
      $table->decimal('emergency_fund_target', 12, 2)->default(0);
      $table->decimal('inflation_rate', 5, 2)->default(3.00);
      $table->decimal('investment_return_rate', 5, 2)->default(7.00);
      $table->decimal('tuition_costs', 12, 2)->default(0);
      $table->decimal('living_costs', 12, 2)->default(0);
      $table->json('financial_goals')->nullable();
      $table->boolean('is_active')->default(true);
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('financial_plans');
  }
};
