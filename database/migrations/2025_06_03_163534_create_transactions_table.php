<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('transactions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->foreignId('financial_plan_id')->constrained()->onDelete('cascade');
      $table->foreignId('expense_category_id')->nullable()->constrained()->onDelete('set null');
      $table->string('type')->default('expense'); // expense, income, savings, investment
      $table->decimal('amount', 12, 2);
      $table->string('description');
      $table->text('notes')->nullable();
      $table->date('transaction_date');
      $table->string('payment_method')->nullable();
      $table->json('tags')->nullable();
      $table->boolean('is_recurring')->default(false);
      $table->string('recurring_frequency')->nullable();
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('transactions');
  }
};
