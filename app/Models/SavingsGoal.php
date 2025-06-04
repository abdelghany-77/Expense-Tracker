<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SavingsGoal extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'financial_plan_id',
    'name',
    'description',
    'target_amount',
    'current_amount',
    'target_date',
    'priority',
    'color',
    'is_completed',
  ];

  protected $casts = [
    'target_amount' => 'decimal:2',
    'current_amount' => 'decimal:2',
    'target_date' => 'date',
    'is_completed' => 'boolean',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function financialPlan(): BelongsTo
  {
    return $this->belongsTo(FinancialPlan::class);
  }

  public function getProgressPercentageAttribute()
  {
    if ($this->target_amount <= 0) {
      return 0;
    }

    return min(($this->current_amount / $this->target_amount) * 100, 100);
  }

  public function getRemainingAmountAttribute()
  {
    return max($this->target_amount - $this->current_amount, 0);
  }

  public function getDaysRemainingAttribute()
  {
    return now()->diffInDays($this->target_date, false);
  }
}
