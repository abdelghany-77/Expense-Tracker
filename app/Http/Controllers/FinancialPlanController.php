<?php

namespace App\Http\Controllers;

use App\Models\FinancialPlan;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FinancialPlanController extends Controller
{
  use AuthorizesRequests;

  public function index()
  {
    $plans = FinancialPlan::where('user_id', Auth::id())
      ->orderBy('created_at', 'desc')
      ->get();
    return view('financial-plans.index', compact('plans'));
  }

  public function create()
  {
    return view('financial-plans.create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'nullable|string',
      'monthly_income' => 'required|numeric|min:0',
      'monthly_savings_target' => 'required|numeric|min:0',
      'emergency_fund_target' => 'nullable|numeric|min:0',
      'inflation_rate' => 'nullable|numeric|min:0|max:100',
      'investment_return_rate' => 'nullable|numeric|min:0|max:100',
      'tuition_costs' => 'nullable|numeric|min:0',
      'living_costs' => 'nullable|numeric|min:0',
    ]);

    // Set defaults
    $validated['emergency_fund_target'] = $validated['emergency_fund_target'] ?? $validated['monthly_income'] * 6;
    $validated['inflation_rate'] = $validated['inflation_rate'] ?? 3.00;
    $validated['investment_return_rate'] = $validated['investment_return_rate'] ?? 7.00;
    $validated['tuition_costs'] = $validated['tuition_costs'] ?? 0;
    $validated['living_costs'] = $validated['living_costs'] ?? 0;

    // Deactivate other plans
    FinancialPlan::where('user_id', Auth::id())
      ->update(['is_active' => false]);

    $validated['user_id'] = Auth::id();
    $plan = FinancialPlan::create($validated);

    // Create default expense categories
    $this->createDefaultCategories($plan->user_id);

    return redirect()->route('dashboard')
      ->with('success', 'Financial plan created successfully!');
  }

  public function show(FinancialPlan $financialPlan)
  {
    $this->authorize('view', $financialPlan);

    return view('financial-plans.show', compact('financialPlan'));
  }

  public function edit(FinancialPlan $financialPlan)
  {
    $this->authorize('update', $financialPlan);

    return view('financial-plans.edit', compact('financialPlan'));
  }

  public function update(Request $request, FinancialPlan $financialPlan)
  {
    $this->authorize('update', $financialPlan);

    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'nullable|string',
      'monthly_income' => 'required|numeric|min:0',
      'monthly_savings_target' => 'required|numeric|min:0',
      'emergency_fund_target' => 'nullable|numeric|min:0',
      'inflation_rate' => 'nullable|numeric|min:0|max:100',
      'investment_return_rate' => 'nullable|numeric|min:0|max:100',
      'tuition_costs' => 'nullable|numeric|min:0',
      'living_costs' => 'nullable|numeric|min:0',
    ]);

    $financialPlan->update($validated);

    return redirect()->route('financial-plans.show', $financialPlan)
      ->with('success', 'Financial plan updated successfully!');
  }

  public function activate(FinancialPlan $financialPlan)
  {
    $this->authorize('update', $financialPlan);

    // Deactivate other plans
    FinancialPlan::where('user_id', Auth::id())
      ->update(['is_active' => false]);

    // Activate selected plan
    $financialPlan->update(['is_active' => true]);

    return redirect()->route('dashboard')
      ->with('success', 'Financial plan activated successfully!');
  }

  private function createDefaultCategories($userId)
  {
    $defaultCategories = [
      ['name' => 'Housing', 'color' => '#EF4444', 'icon' => '🏠', 'is_essential' => true],
      ['name' => 'Food & Groceries', 'color' => '#F59E0B', 'icon' => '🛒', 'is_essential' => true],
      ['name' => 'Transportation', 'color' => '#10B981', 'icon' => '🚗', 'is_essential' => true],
      ['name' => 'Utilities', 'color' => '#3B82F6', 'icon' => '⚡', 'is_essential' => true],
      ['name' => 'Healthcare', 'color' => '#8B5CF6', 'icon' => '🏥', 'is_essential' => true],
      ['name' => 'Entertainment', 'color' => '#EC4899', 'icon' => '🎬', 'is_essential' => false],
      ['name' => 'Shopping', 'color' => '#06B6D4', 'icon' => '🛍️', 'is_essential' => false],
      ['name' => 'Education', 'color' => '#84CC16', 'icon' => '📚', 'is_essential' => false],
    ];

    foreach ($defaultCategories as $index => $category) {
      ExpenseCategory::create([
        'user_id' => $userId,
        'sort_order' => $index,
        ...$category
      ]);
    }
  }
}
