<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ExpenseCategoryController extends Controller
{
  use AuthorizesRequests;
  public function index()
  {
    $categories = ExpenseCategory::where('user_id', Auth::id())
      ->orderBy('sort_order')
      ->orderBy('name')
      ->get();

    return view('expense-categories.index', compact('categories'));
  }

  public function create()
  {
    return view('expense-categories.create');
  }

  public function store(Request $request)
  {
    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
      'icon' => 'required|string|max:10',
      'monthly_budget' => 'nullable|numeric|min:0',
      'is_essential' => 'boolean',
    ]);

    $validated['user_id'] = Auth::id();
    $validated['is_essential'] = $request->boolean('is_essential');
    $validated['sort_order'] = ExpenseCategory::where('user_id', Auth::id())->max('sort_order') + 1;

    ExpenseCategory::create($validated);

    return redirect()->route('expense-categories.index')
      ->with('success', 'Expense category created successfully!');
  }

  public function show(ExpenseCategory $expenseCategory)
  {
    $this->authorize('view', $expenseCategory);

    // Get recent transactions for this category
    $recentTransactions = $expenseCategory->transactions()
      ->orderBy('transaction_date', 'desc')
      ->take(10)
      ->get();

    // Calculate monthly spending
    $monthlySpending = $expenseCategory->transactions()
      ->thisMonth()
      ->sum('amount');

    return view('expense-categories.show', compact('expenseCategory', 'recentTransactions', 'monthlySpending'));
  }

  public function edit(ExpenseCategory $expenseCategory)
  {
    $this->authorize('update', $expenseCategory);

    return view('expense-categories.edit', compact('expenseCategory'));
  }

  public function update(Request $request, ExpenseCategory $expenseCategory)
  {
    $this->authorize('update', $expenseCategory);

    $validated = $request->validate([
      'name' => 'required|string|max:255',
      'color' => 'required|string|regex:/^#[0-9A-Fa-f]{6}$/',
      'icon' => 'required|string|max:10',
      'monthly_budget' => 'nullable|numeric|min:0',
      'is_essential' => 'boolean',
    ]);

    $validated['is_essential'] = $request->boolean('is_essential');

    $expenseCategory->update($validated);

    return redirect()->route('expense-categories.index')
      ->with('success', 'Expense category updated successfully!');
  }

  public function destroy(ExpenseCategory $expenseCategory)
  {
    $this->authorize('delete', $expenseCategory);

    // Check if category has transactions
    if ($expenseCategory->transactions()->count() > 0) {
      return redirect()->route('expense-categories.index')
        ->with('error', 'Cannot delete category that has transactions. Please reassign or delete transactions first.');
    }

    $expenseCategory->delete();

    return redirect()->route('expense-categories.index')
      ->with('success', 'Expense category deleted successfully!');
  }

  public function updateOrder(Request $request)
  {
    $validated = $request->validate([
      'categories' => 'required|array',
      'categories.*' => 'required|integer|exists:expense_categories,id',
    ]);

    foreach ($validated['categories'] as $index => $categoryId) {
      ExpenseCategory::where('id', $categoryId)
        ->where('user_id', Auth::id())
        ->update(['sort_order' => $index]);
    }

    return response()->json(['success' => true]);
  }
}
