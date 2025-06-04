<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\FinancialPlan;
use Illuminate\Database\Seeder;

class FinancialPlanSeeder extends Seeder
{
  public function run(): void
  {
    $users = User::all();

    foreach ($users as $user) {
      // Create an active financial plan for each user
      FinancialPlan::create([
        'user_id' => $user->id,
        'name' => '2025 Financial Goals',
        'description' => 'My main financial plan for achieving stability and growth in 2025.',
        'monthly_income' => $this->getRandomIncome(),
        'monthly_savings_target' => 1500.00,
        'emergency_fund_target' => 25000.00,
        'inflation_rate' => 3.50,
        'investment_return_rate' => 8.00,
        'tuition_costs' => $user->id <= 2 ? 15000.00 : 0, // Only first 2 users have tuition
        'living_costs' => 2000.00,
        'financial_goals' => [
          'emergency_fund' => true,
          'house_down_payment' => true,
          'retirement_savings' => true,
          'vacation_fund' => true,
        ],
        'is_active' => true,
      ]);

      // Create an additional inactive plan for some users
      if ($user->id <= 2) {
        FinancialPlan::create([
          'user_id' => $user->id,
          'name' => '2024 Financial Plan (Completed)',
          'description' => 'Previous year financial plan with great results.',
          'monthly_income' => $this->getRandomIncome() - 500,
          'monthly_savings_target' => 1200.00,
          'emergency_fund_target' => 20000.00,
          'inflation_rate' => 3.20,
          'investment_return_rate' => 7.50,
          'tuition_costs' => 12000.00,
          'living_costs' => 1800.00,
          'is_active' => false,
        ]);
      }
    }
  }

  private function getRandomIncome(): float
  {
    $incomes = [4500.00, 5200.00, 6800.00, 7500.00, 8200.00, 9000.00];
    return $incomes[array_rand($incomes)];
  }
}
