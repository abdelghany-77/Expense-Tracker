<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FinancialPlan extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'name',
    'description',
    'monthly_income',
    'monthly_savings_target',
    'emergency_fund_target',
    'inflation_rate',
    'investment_return_rate',
    'tuition_costs',
    'living_costs',
    'financial_goals',
    'is_active',
  ];

  protected $casts = [
    'monthly_income' => 'decimal:2',
    'monthly_savings_target' => 'decimal:2',
    'emergency_fund_target' => 'decimal:2',
    'inflation_rate' => 'decimal:2',
    'investment_return_rate' => 'decimal:2',
    'tuition_costs' => 'decimal:2',
    'living_costs' => 'decimal:2',
    'financial_goals' => 'array',
    'is_active' => 'boolean',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function transactions(): HasMany
  {
    return $this->hasMany(Transaction::class);
  }

  public function savingsGoals(): HasMany
  {
    return $this->hasMany(SavingsGoal::class);
  }

  public function getMonthlyExpensesAttribute()
  {
    return $this->transactions()
      ->where('type', 'expense')
      ->whereMonth('transaction_date', now()->month)
      ->whereYear('transaction_date', now()->year)
      ->sum('amount');
  }

  public function getMonthlySavingsAttribute()
  {
    return $this->transactions()
      ->where('type', 'savings')
      ->whereMonth('transaction_date', now()->month)
      ->whereYear('transaction_date', now()->year)
      ->sum('amount');
  }

  public function calculateNetWorth(): float
  {
    $totalSavings = $this->transactions()->where('type', 'savings')->sum('amount');
    $totalInvestments = $this->transactions()->where('type', 'investment')->sum('amount');

    return $totalSavings + $totalInvestments;
  }

  public function calculateSavingsRate(): float
  {
    if ($this->monthly_income <= 0) {
      return 0;
    }

    return ($this->monthly_savings / $this->monthly_income) * 100;
  }
}
