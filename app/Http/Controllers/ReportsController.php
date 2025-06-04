<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\ExpenseCategory;
use App\Models\SavingsGoal;
use App\Models\FinancialPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportsController extends Controller
{
  public function index(Request $request)
  {
    $user = Auth::user();
    $activePlan = FinancialPlan::where('user_id', $user->id)
      ->where('is_active', true)
      ->first();

    if (!$activePlan) {
      return redirect()->route('financial-plans.create')
        ->with('message', 'Please create a financial plan first.');
    }

    $period = $request->get('period', 'month');
    $dateRange = $this->getDateRange($period);

    // Calculate metrics
    $metrics = $this->calculateMetrics($activePlan, $dateRange);

    // Get category data
    $categoryData = $this->getCategoryData($activePlan, $dateRange);

    // Get monthly trends
    $monthlyTrends = $this->getMonthlyTrends($activePlan);

    // Get savings goals
    $savingsGoals = SavingsGoal::where('user_id', $user->id)
      ->where('is_completed', false)
      ->get();

    // Get budget comparison
    $budgetComparison = $this->getBudgetComparison($user, $dateRange);

    return view('reports.index', compact(
      'metrics',
      'categoryData',
      'monthlyTrends',
      'savingsGoals',
      'budgetComparison'
    ));
  }

  private function getDateRange($period)
  {
    switch ($period) {
      case 'quarter':
        return [
          'start' => now()->startOfQuarter(),
          'end' => now()->endOfQuarter(),
        ];
      case 'year':
        return [
          'start' => now()->startOfYear(),
          'end' => now()->endOfYear(),
        ];
      case 'all':
        return [
          'start' => null,
          'end' => null,
        ];
      default: // month
        return [
          'start' => now()->startOfMonth(),
          'end' => now()->endOfMonth(),
        ];
    }
  }

  private function calculateMetrics($plan, $dateRange)
  {
    $query = Transaction::where('financial_plan_id', $plan->id);

    if ($dateRange['start'] && $dateRange['end']) {
      $query->whereBetween('transaction_date', [$dateRange['start'], $dateRange['end']]);
    }

    $totalIncome = $query->clone()->where('type', 'income')->sum('amount');
    $totalExpenses = $query->clone()->where('type', 'expense')->sum('amount');
    $netSavings = $query->clone()->where('type', 'savings')->sum('amount');
    $transactionCount = $query->count();

    // Calculate growth (compare with previous period)
    $previousQuery = Transaction::where('financial_plan_id', $plan->id);
    if ($dateRange['start'] && $dateRange['end']) {
      $periodLength = $dateRange['start']->diffInDays($dateRange['end']);
      $previousStart = $dateRange['start']->copy()->subDays($periodLength + 1);
      $previousEnd = $dateRange['start']->copy()->subDay();
      $previousQuery->whereBetween('transaction_date', [$previousStart, $previousEnd]);
    }

    $previousIncome = $previousQuery->clone()->where('type', 'income')->sum('amount');
    $previousExpenses = $previousQuery->clone()->where('type', 'expense')->sum('amount');

    return [
      'total_income' => $totalIncome,
      'total_expenses' => $totalExpenses,
      'net_savings' => $netSavings,
      'transaction_count' => $transactionCount,
      'avg_transaction' => $transactionCount > 0 ? ($totalIncome + $totalExpenses) / $transactionCount : 0,
      'savings_rate' => $totalIncome > 0 ? ($netSavings / $totalIncome) * 100 : 0,
      'income_growth' => $previousIncome > 0 ? (($totalIncome - $previousIncome) / $previousIncome) * 100 : 0,
      'expense_growth' => $previousExpenses > 0 ? (($totalExpenses - $previousExpenses) / $previousExpenses) * 100 : 0,
    ];
  }

  private function getCategoryData($plan, $dateRange)
  {
    $query = Transaction::where('financial_plan_id', $plan->id)
      ->where('type', 'expense')
      ->with('expenseCategory');

    if ($dateRange['start'] && $dateRange['end']) {
      $query->whereBetween('transaction_date', [$dateRange['start'], $dateRange['end']]);
    }

    $transactions = $query->get();
    $totalExpenses = $transactions->sum('amount');

    $categoryData = $transactions->groupBy('expense_category_id')->map(function ($group) use ($totalExpenses) {
      $amount = $group->sum('amount');
      $category = $group->first()->expenseCategory;

      return [
        'name' => $category ? $category->name : 'Uncategorized',
        'color' => $category ? $category->color : '#6b7280',
        'amount' => $amount,
        'percentage' => $totalExpenses > 0 ? ($amount / $totalExpenses) * 100 : 0,
      ];
    })->sortByDesc('amount')->values()->toArray();

    return $categoryData;
  }

  private function getMonthlyTrends($plan)
  {
    $trends = [];

    for ($i = 5; $i >= 0; $i--) {
      $date = now()->subMonths($i);

      $income = Transaction::where('financial_plan_id', $plan->id)
        ->where('type', 'income')
        ->whereMonth('transaction_date', $date->month)
        ->whereYear('transaction_date', $date->year)
        ->sum('amount');

      $expenses = Transaction::where('financial_plan_id', $plan->id)
        ->where('type', 'expense')
        ->whereMonth('transaction_date', $date->month)
        ->whereYear('transaction_date', $date->year)
        ->sum('amount');

      $trends[] = [
        'month' => $date->format('M Y'),
        'income' => $income,
        'expenses' => $expenses,
        'net' => $income - $expenses
      ];
    }

    return $trends;
  }

  private function getBudgetComparison($user, $dateRange)
  {
    $categories = ExpenseCategory::where('user_id', $user->id)
      ->where('monthly_budget', '>', 0)
      ->get();

    return $categories->map(function ($category) use ($dateRange) {
      $query = Transaction::where('expense_category_id', $category->id)
        ->where('type', 'expense');

      if ($dateRange['start'] && $dateRange['end']) {
        $query->whereBetween('transaction_date', [$dateRange['start'], $dateRange['end']]);
      } else {
        $query->thisMonth();
      }

      $actual = $query->sum('amount');
      $budget = $category->monthly_budget;

      return [
        'category' => $category->name,
        'budget' => $budget,
        'actual' => $actual,
        'percentage' => $budget > 0 ? ($actual / $budget) * 100 : 0,
      ];
    })->toArray();
  }
}
