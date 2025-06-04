<?php

namespace App\Http\Controllers;

use App\Models\SavingsGoal;
use App\Models\FinancialPlan;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SavingsGoalController extends Controller
{
  use AuthorizesRequests;
  public function index()
  {
    $user = Auth::user();
    $goals = SavingsGoal::where('user_id', $user->id)
      ->orderBy('is_completed')
      ->orderBy('target_date')
      ->get();

    return view('savings-goals.index', compact('goals'));
  }

  public function create()
  {
    $user = Auth::user();
    $activePlan = FinancialPlan::where('user_id', $user->id)
      ->where('is_active', true)
      ->first();

    if (!$activePlan) {
      return redirect()->route('financial-plans.create')
        ->with('message', 'Please create a financial plan first.');
    }

    return view('savings-goals.create');
  }

  public function store(Request $request)
  {
    $user = Auth::user();
    $activePlan = FinancialPlan::where('user_id', $user->id)
      ->where('is_active', true)
      ->first();

    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'nullable|string',
      'target_amount' => 'required|numeric|min:0.01',
      'target_date' => 'required|date|after:today',
      'priority' => 'required|in:low,medium,high',
      'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
    ]);

    $validated['user_id'] = $user->id;
    $validated['financial_plan_id'] = $activePlan->id;

    SavingsGoal::create($validated);

    return redirect()->route('savings-goals.index')
      ->with('success', 'Savings goal created successfully!');
  }

  public function show(SavingsGoal $savingsGoal)
  {
    $this->authorize('view', $savingsGoal);
    return view('savings-goals.show', compact('savingsGoal'));
  }

  public function edit(SavingsGoal $savingsGoal)
  {
    $this->authorize('update', $savingsGoal);
    return view('savings-goals.edit', compact('savingsGoal'));
  }

  public function update(Request $request, SavingsGoal $savingsGoal)
  {
    $this->authorize('update', $savingsGoal);

    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'description' => 'nullable|string',
      'target_amount' => 'required|numeric|min:0.01',
      'target_date' => 'required|date',
      'priority' => 'required|in:low,medium,high',
      'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
    ]);

    $savingsGoal->update($validated);

    return redirect()->route('savings-goals.index')
      ->with('success', 'Savings goal updated successfully!');
  }

  public function addFunds(Request $request, SavingsGoal $savingsGoal)
  {
    $this->authorize('update', $savingsGoal);

    $validated = $request->validate([
      'amount' => 'required|numeric|min:0.01',
      'notes' => 'nullable|string|max:255',
    ]);

    $savingsGoal->increment('current_amount', $validated['amount']);

    // Create a savings transaction
    Transaction::create([
      'user_id' => $savingsGoal->user_id,
      'financial_plan_id' => $savingsGoal->financial_plan_id,
      'type' => 'savings',
      'amount' => $validated['amount'],
      'description' => "Savings toward: {$savingsGoal->name}",
      'notes' => $validated['notes'] ?? null,
      'transaction_date' => now()->format('Y-m-d'),
    ]);

    // Check if goal is completed
    if ($savingsGoal->current_amount >= $savingsGoal->target_amount) {
      $savingsGoal->update(['is_completed' => true]);
      $message = 'Congratulations! You\'ve reached your savings goal!';
    } else {
      $message = 'Funds added successfully!';
    }

    return redirect()->route('savings-goals.index')
      ->with('success', $message);
  }

  public function destroy(SavingsGoal $savingsGoal)
  {
    $this->authorize('delete', $savingsGoal);

    $savingsGoal->delete();

    return redirect()->route('savings-goals.index')
      ->with('success', 'Savings goal deleted successfully!');
  }
}
