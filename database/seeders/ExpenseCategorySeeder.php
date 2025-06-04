<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;

class ExpenseCategorySeeder extends Seeder
{
  public function run(): void
  {
    $users = User::all();

    $categories = [
      ['name' => 'Housing & Rent', 'color' => '#EF4444', 'icon' => '🏠', 'budget' => 2000, 'essential' => true],
      ['name' => 'Groceries', 'color' => '#F59E0B', 'icon' => '🛒', 'budget' => 600, 'essential' => true],
      ['name' => 'Transportation', 'color' => '#10B981', 'icon' => '🚗', 'budget' => 400, 'essential' => true],
      ['name' => 'Utilities', 'color' => '#3B82F6', 'icon' => '⚡', 'budget' => 250, 'essential' => true],
      ['name' => 'Healthcare', 'color' => '#8B5CF6', 'icon' => '🏥', 'budget' => 300, 'essential' => true],
      ['name' => 'Phone & Internet', 'color' => '#06B6D4', 'icon' => '📱', 'budget' => 120, 'essential' => true],
      ['name' => 'Insurance', 'color' => '#84CC16', 'icon' => '🛡️', 'budget' => 200, 'essential' => true],
      ['name' => 'Entertainment', 'color' => '#EC4899', 'icon' => '🎬', 'budget' => 200, 'essential' => false],
      ['name' => 'Dining Out', 'color' => '#F97316', 'icon' => '🍽️', 'budget' => 300, 'essential' => false],
      ['name' => 'Shopping', 'color' => '#A855F7', 'icon' => '🛍️', 'budget' => 250, 'essential' => false],
      ['name' => 'Gym & Fitness', 'color' => '#22C55E', 'icon' => '🏋️', 'budget' => 80, 'essential' => false],
      ['name' => 'Education', 'color' => '#0EA5E9', 'icon' => '📚', 'budget' => 150, 'essential' => false],
      ['name' => 'Travel', 'color' => '#8B5CF6', 'icon' => '✈️', 'budget' => 300, 'essential' => false],
      ['name' => 'Subscriptions', 'color' => '#F59E0B', 'icon' => '📺', 'budget' => 50, 'essential' => false],
      ['name' => 'Personal Care', 'color' => '#EC4899', 'icon' => '💄', 'budget' => 100, 'essential' => false],
    ];

    foreach ($users as $user) {
      foreach ($categories as $index => $category) {
        ExpenseCategory::create([
          'user_id' => $user->id,
          'name' => $category['name'],
          'color' => $category['color'],
          'icon' => $category['icon'],
          'monthly_budget' => $category['budget'] + rand(-50, 100), // Add some variation
          'is_essential' => $category['essential'],
          'sort_order' => $index,
        ]);
      }
    }
  }
}
