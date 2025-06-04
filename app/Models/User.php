<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  protected $fillable = [
    'name',
    'email',
    'password',
  ];

  protected $hidden = [
    'password',
    'remember_token',
  ];

  protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
  ];

  public function financialPlans(): HasMany
  {
    return $this->hasMany(FinancialPlan::class);
  }

  public function transactions(): HasMany
  {
    return $this->hasMany(Transaction::class);
  }

  public function expenseCategories(): HasMany
  {
    return $this->hasMany(ExpenseCategory::class);
  }

  public function savingsGoals(): HasMany
  {
    return $this->hasMany(SavingsGoal::class);
  }

  public function getActiveFinancialPlanAttribute()
  {
    return $this->financialPlans()->where('is_active', true)->first();
  }
}
