<?php

namespace App\Policies;

use App\Models\FinancialPlan;
use App\Models\User;

class FinancialPlanPolicy
{
  public function view(User $user, FinancialPlan $financialPlan): bool
  {
    return $user->id === $financialPlan->user_id;
  }

  public function update(User $user, FinancialPlan $financialPlan): bool
  {
    return $user->id === $financialPlan->user_id;
  }

  public function delete(User $user, FinancialPlan $financialPlan): bool
  {
    return $user->id === $financialPlan->user_id;
  }
}
