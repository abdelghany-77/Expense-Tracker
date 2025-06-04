<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    Schema::create('savings_goals', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained()->onDelete('cascade');
      $table->foreignId('financial_plan_id')->constrained()->onDelete('cascade');
      $table->string('name');
      $table->text('description')->nullable();
      $table->decimal('target_amount', 12, 2);
      $table->decimal('current_amount', 12, 2)->default(0);
      $table->date('target_date');
      $table->string('priority')->default('medium'); // low, medium, high
      $table->string('color', 7)->default('#10B981');
      $table->boolean('is_completed')->default(false);
      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('savings_goals');
  }
};
