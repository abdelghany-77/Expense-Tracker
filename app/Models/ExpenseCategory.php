<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExpenseCategory extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id',
    'name',
    'color',
    'icon',
    'monthly_budget',
    'is_essential',
    'sort_order',
  ];

  protected $casts = [
    'monthly_budget' => 'decimal:2',
    'is_essential' => 'boolean',
  ];

  public function user(): BelongsTo
  {
    return $this->belongsTo(User::class);
  }

  public function transactions(): HasMany
  {
    return $this->hasMany(Transaction::class);
  }

  public function getMonthlySpentAttribute()
  {
    return $this->transactions()
      ->thisMonth()
      ->sum('amount');
  }

  public function getBudgetUtilizationAttribute()
  {
    if ($this->monthly_budget <= 0) {
      return 0;
    }

    return ($this->monthly_spent / $this->monthly_budget) * 100;
  }
}
