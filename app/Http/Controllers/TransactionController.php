<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\ExpenseCategory;
use App\Models\FinancialPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TransactionController extends Controller
{
  use AuthorizesRequests;
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

    $query = Transaction::where('user_id', $user->id)
      ->where('financial_plan_id', $activePlan->id)
      ->with(['expenseCategory']);

    // Apply filters
    if ($request->filled('type')) {
      $query->where('type', $request->type);
    }

    if ($request->filled('category')) {
      $query->where('expense_category_id', $request->category);
    }

    if ($request->filled('month')) {
      $query->whereMonth('transaction_date', $request->month);
    }

    $transactions = $query->orderBy('transaction_date', 'desc')
      ->orderBy('created_at', 'desc')
      ->paginate(20);

    $categories = ExpenseCategory::where('user_id', $user->id)->get();

    // Calculate summary
    $summaryQuery = Transaction::where('user_id', $user->id)
      ->where('financial_plan_id', $activePlan->id);

    // Apply same filters to summary
    if ($request->filled('type')) {
      $summaryQuery->where('type', $request->type);
    }
    if ($request->filled('category')) {
      $summaryQuery->where('expense_category_id', $request->category);
    }
    if ($request->filled('month')) {
      $summaryQuery->whereMonth('transaction_date', $request->month);
    }

    $summary = [
      'income' => $summaryQuery->clone()->where('type', 'income')->sum('amount'),
      'expenses' => $summaryQuery->clone()->where('type', 'expense')->sum('amount'),
      'savings' => $summaryQuery->clone()->where('type', 'savings')->sum('amount'),
    ];
    $summary['net'] = $summary['income'] - $summary['expenses'];

    return view('transactions.index', compact('transactions', 'categories', 'summary'));
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

    $categories = ExpenseCategory::where('user_id', $user->id)
      ->orderBy('sort_order')
      ->get();

    return view('transactions.create', compact('categories'));
  }

  public function store(Request $request)
  {
    $user = Auth::user();
    $activePlan = FinancialPlan::where('user_id', $user->id)
      ->where('is_active', true)
      ->first();

    $validated = $request->validate([
      'type' => 'required|in:income,expense,savings,investment',
      'amount' => 'required|numeric|min:0.01',
      'description' => 'required|string|max:255',
      'transaction_date' => 'required|date',
      'expense_category_id' => 'nullable|exists:expense_categories,id',
      'payment_method' => 'nullable|string',
      'notes' => 'nullable|string',
      'is_recurring' => 'boolean',
      'recurring_frequency' => 'nullable|in:weekly,monthly,yearly',
    ]);

    $validated['user_id'] = $user->id;
    $validated['financial_plan_id'] = $activePlan->id;
    $validated['is_recurring'] = $request->boolean('is_recurring');

    Transaction::create($validated);

    return redirect()->route('transactions.index')
      ->with('success', 'Transaction added successfully!');
  }

  public function show(Transaction $transaction)
  {
    $this->authorize('view', $transaction);
    return view('transactions.show', compact('transaction'));
  }

  public function edit(Transaction $transaction)
  {
    $this->authorize('update', $transaction);

    $categories = ExpenseCategory::where('user_id', Auth::id())
      ->orderBy('sort_order')
      ->get();

    return view('transactions.edit', compact('transaction', 'categories'));
  }

  public function update(Request $request, Transaction $transaction)
  {
    $this->authorize('update', $transaction);

    $validated = $request->validate([
      'type' => 'required|in:income,expense,savings,investment',
      'amount' => 'required|numeric|min:0.01',
      'description' => 'required|string|max:255',
      'transaction_date' => 'required|date',
      'expense_category_id' => 'nullable|exists:expense_categories,id',
      'payment_method' => 'nullable|string',
      'notes' => 'nullable|string',
      'is_recurring' => 'boolean',
      'recurring_frequency' => 'nullable|in:weekly,monthly,yearly',
    ]);

    $validated['is_recurring'] = $request->boolean('is_recurring');

    $transaction->update($validated);

    return redirect()->route('transactions.index')
      ->with('success', 'Transaction updated successfully!');
  }

  public function destroy(Transaction $transaction)
  {
    $this->authorize('delete', $transaction);

    $transaction->delete();

    return redirect()->route('transactions.index')
      ->with('success', 'Transaction deleted successfully!');
  }
}
