<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\SavingsGoal;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SavingsGoalSeeder extends Seeder
{
  public function run(): void
  {
    $users = User::all();

    $goals = [
      [
        'name' => 'Emergency Fund',
        'description' => '6 months of expenses for unexpected situations',
        'target_amount' => 25000.00,
        'current_amount' => 8500.00,
        'target_date' => Carbon::now()->addMonths(8),
        'priority' => 'high',
        'color' => '#EF4444',
        'completed' => false,
      ],
      [
        'name' => 'House Down Payment',
        'description' => 'Saving for a 20% down payment on our dream home',
        'target_amount' => 60000.00,
        'current_amount' => 22000.00,
        'target_date' => Carbon::now()->addMonths(18),
        'priority' => 'high',
        'color' => '#10B981',
        'completed' => false,
      ],
      [
        'name' => 'Vacation to Japan',
        'description' => 'Two-week trip to explore Japan in spring 2026',
        'target_amount' => 8000.00,
        'current_amount' => 2400.00,
        'target_date' => Carbon::now()->addMonths(10),
        'priority' => 'medium',
        'color' => '#F59E0B',
        'completed' => false,
      ],
      [
        'name' => 'New Car Fund',
        'description' => 'Reliable vehicle for daily commuting',
        'target_amount' => 25000.00,
        'current_amount' => 7500.00,
        'target_date' => Carbon::now()->addMonths(14),
        'priority' => 'medium',
        'color' => '#3B82F6',
        'completed' => false,
      ],
      [
        'name' => 'Professional Development',
        'description' => 'Courses, certifications, and conference attendance',
        'target_amount' => 5000.00,
        'current_amount' => 1800.00,
        'target_date' => Carbon::now()->addMonths(6),
        'priority' => 'medium',
        'color' => '#8B5CF6',
        'completed' => false,
      ],
      [
        'name' => 'Home Office Setup',
        'description' => 'Complete workspace upgrade with standing desk and equipment',
        'target_amount' => 3500.00,
        'current_amount' => 3500.00,
        'target_date' => Carbon::now()->subMonths(1),
        'priority' => 'low',
        'color' => '#06B6D4',
        'completed' => true,
      ],
      [
        'name' => 'Wedding Fund',
        'description' => 'Dream wedding celebration with family and friends',
        'target_amount' => 30000.00,
        'current_amount' => 12000.00,
        'target_date' => Carbon::now()->addMonths(20),
        'priority' => 'high',
        'color' => '#EC4899',
        'completed' => false,
      ],
    ];

    foreach ($users as $user) {
      $activePlan = $user->financialPlans()->where('is_active', true)->first();

      // Create different goals for different users
      $userGoals = $this->getUserGoals($user->id, $goals);

      foreach ($userGoals as $goal) {
        SavingsGoal::create([
          'user_id' => $user->id,
          'financial_plan_id' => $activePlan->id,
          'name' => $goal['name'],
          'description' => $goal['description'],
          'target_amount' => $goal['target_amount'],
          'current_amount' => $goal['current_amount'],
          'target_date' => $goal['target_date'],
          'priority' => $goal['priority'],
          'color' => $goal['color'],
          'is_completed' => $goal['completed'],
        ]);
      }
    }
  }

  private function getUserGoals($userId, $allGoals): array
  {
    switch ($userId) {
      case 1: // Abdelghany - Full set of goals
        return $allGoals;
      case 2: // John - Career focused
        return [$allGoals[0], $allGoals[1], $allGoals[4], $allGoals[5]];
      case 3: // Sarah - Travel and lifestyle
        return [$allGoals[0], $allGoals[2], $allGoals[5], $allGoals[6]];
      case 4: // Mike - Basic goals
        return [$allGoals[0], $allGoals[3], $allGoals[5]];
      default:
        return [$allGoals[0], $allGoals[2]]; // Default: Emergency fund + vacation
    }
  }
}
