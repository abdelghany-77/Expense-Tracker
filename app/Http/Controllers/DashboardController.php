<?php

namespace App\Http\Controllers;

use App\Models\FinancialPlan;
use App\Models\Transaction;
use App\Models\ExpenseCategory;
use App\Models\SavingsGoal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
  public function index()
  {
    $user = Auth::user();

    $activePlan = FinancialPlan::where('user_id', $user->id)
      ->where('is_active', true)
      ->first();

    if (!$activePlan) {
      return redirect()->route('financial-plans.create')
        ->with('message', 'Please create your first financial plan to get started.');
    }

    $currentMonth = now();
    $previousMonth = now()->subMonth();

    // Monthly Statistics
    $monthlyIncome = $activePlan->transactions()
      ->ofType('income')
      ->thisMonth()
      ->sum('amount');

    $monthlyExpenses = $activePlan->transactions()
      ->ofType('expense')
      ->thisMonth()
      ->sum('amount');

    $monthlySavings = $activePlan->transactions()
      ->ofType('savings')
      ->thisMonth()
      ->sum('amount');

    // Previous month for comparison
    $previousMonthExpenses = $activePlan->transactions()
      ->ofType('expense')
      ->whereMonth('transaction_date', $previousMonth->month)
      ->whereYear('transaction_date', $previousMonth->year)
      ->sum('amount');

    // Category spending
    $categorySpending = ExpenseCategory::where('user_id', $user->id)
      ->with(['transactions' => function ($query) {
        $query->thisMonth();
      }])
      ->get()
      ->map(function ($category) {
        return [
          'name' => $category->name,
          'spent' => $category->monthly_spent,
          'budget' => $category->monthly_budget,
          'color' => $category->color,
          'utilization' => $category->budget_utilization
        ];
      });

    // Savings goals progress
    $savingsGoals = SavingsGoal::where('user_id', $user->id)
      ->where('is_completed', false)
      ->orderBy('target_date')
      ->take(5)
      ->get();

    // Recent transactions
    $recentTransactions = Transaction::where('user_id', $user->id)
      ->with(['expenseCategory'])
      ->orderBy('transaction_date', 'desc')
      ->orderBy('created_at', 'desc')
      ->take(10)
      ->get();

    // Monthly trends (last 6 months)
    $monthlyTrends = $this->getMonthlyTrends($activePlan);

    return view('dashboard', compact(
      'activePlan',
      'monthlyIncome',
      'monthlyExpenses',
      'monthlySavings',
      'previousMonthExpenses',
      'categorySpending',
      'savingsGoals',
      'recentTransactions',
      'monthlyTrends'
    ));
  }

  private function getMonthlyTrends($plan)
  {
    $trends = [];

    for ($i = 5; $i >= 0; $i--) {
      $date = now()->subMonths($i);

      $income = $plan->transactions()
        ->ofType('income')
        ->whereMonth('transaction_date', $date->month)
        ->whereYear('transaction_date', $date->year)
        ->sum('amount');

      $expenses = $plan->transactions()
        ->ofType('expense')
        ->whereMonth('transaction_date', $date->month)
        ->whereYear('transaction_date', $date->year)
        ->sum('amount');

      $savings = $plan->transactions()
        ->ofType('savings')
        ->whereMonth('transaction_date', $date->month)
        ->whereYear('transaction_date', $date->year)
        ->sum('amount');

      $trends[] = [
        'month' => $date->format('M Y'),
        'income' => $income,
        'expenses' => $expenses,
        'savings' => $savings,
        'net' => $income - $expenses
      ];
    }

    return $trends;
  }
}
