<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'financial_plan_id',
    'expense_category_id',
    'type',
    'amount',
    'description',
    'notes',
    'transaction_date',
    'payment_method',
    'tags',
    'is_recurring',
    'recurring_frequency',
  ];

  protected $casts = [
    'amount' => 'decimal:2',
    'transaction_date' => 'date',
    'tags' => 'array',
    'is_recurring' => 'boolean',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function financialPlan(): BelongsTo
  {
    return $this->belongsTo(FinancialPlan::class);
  }

  public function expenseCategory(): BelongsTo
  {
    return $this->belongsTo(ExpenseCategory::class);
  }

  public function scopeOfType($query, string $type)
  {
    return $query->where('type', $type);
  }

  public function scopeThisMonth($query)
  {
    return $query->whereMonth('transaction_date', now()->month)
      ->whereYear('transaction_date', now()->year);
  }

  public function scopeThisYear($query)
  {
    return $query->whereYear('transaction_date', now()->year);
  }
}
