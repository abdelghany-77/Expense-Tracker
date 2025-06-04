<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Transaction;
use App\Models\ExpenseCategory;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
  public function run(): void
  {
    $users = User::all();

    foreach ($users as $user) {
      $activePlan = $user->financialPlans()->where('is_active', true)->first();
      $categories = $user->expenseCategories;

      // Generate transactions for the last 6 months
      for ($month = 5; $month >= 0; $month--) {
        $startDate = Carbon::now()->subMonths($month)->startOfMonth();
        $endDate = Carbon::now()->subMonths($month)->endOfMonth();

        $this->createMonthlyTransactions($user, $activePlan, $categories, $startDate, $endDate);
      }
    }
  }

  private function createMonthlyTransactions($user, $plan, $categories, $startDate, $endDate)
  {
    // Monthly Income (1-3 transactions per month)
    $incomeTransactions = rand(1, 3);
    for ($i = 0; $i < $incomeTransactions; $i++) {
      $date = $this->randomDateBetween($startDate, $endDate);
      $incomeTypes = [
        ['desc' => 'Salary Payment', 'amount' => $plan->monthly_income * 0.8],
        ['desc' => 'Freelance Project', 'amount' => rand(500, 2000)],
        ['desc' => 'Investment Dividend', 'amount' => rand(100, 500)],
        ['desc' => 'Bonus Payment', 'amount' => rand(1000, 3000)],
        ['desc' => 'Side Business Income', 'amount' => rand(300, 1500)],
      ];

      $income = $incomeTypes[array_rand($incomeTypes)];

      Transaction::create([
        'user_id' => $user->id,
        'financial_plan_id' => $plan->id,
        'type' => 'income',
        'amount' => $income['amount'],
        'description' => $income['desc'],
        'transaction_date' => $date,
        'payment_method' => 'bank_transfer',
      ]);
    }

    // Monthly Savings (1-4 transactions per month)
    $savingsTransactions = rand(1, 4);
    for ($i = 0; $i < $savingsTransactions; $i++) {
      $date = $this->randomDateBetween($startDate, $endDate);
      $savingsTypes = [
        'Emergency Fund Contribution',
        'Retirement Savings',
        'House Down Payment Fund',
        'Investment Account Deposit',
        'High-Yield Savings Transfer',
        'Goal-based Savings',
      ];

      Transaction::create([
        'user_id' => $user->id,
        'financial_plan_id' => $plan->id,
        'type' => 'savings',
        'amount' => rand(200, 800),
        'description' => $savingsTypes[array_rand($savingsTypes)],
        'transaction_date' => $date,
        'payment_method' => 'bank_transfer',
      ]);
    }

    // Investments (0-2 transactions per month)
    $investmentTransactions = rand(0, 2);
    for ($i = 0; $i < $investmentTransactions; $i++) {
      $date = $this->randomDateBetween($startDate, $endDate);
      $investmentTypes = [
        'Stock Market Investment',
        'Index Fund Purchase',
        'Crypto Investment',
        'Bond Purchase',
        'Real Estate Investment',
        'ETF Purchase',
      ];

      Transaction::create([
        'user_id' => $user->id,
        'financial_plan_id' => $plan->id,
        'type' => 'investment',
        'amount' => rand(300, 1500),
        'description' => $investmentTypes[array_rand($investmentTypes)],
        'transaction_date' => $date,
        'payment_method' => 'bank_transfer',
      ]);
    }

    // Expense Transactions
    foreach ($categories as $category) {
      $this->createCategoryExpenses($user, $plan, $category, $startDate, $endDate);
    }
  }

  private function createCategoryExpenses($user, $plan, $category, $startDate, $endDate)
  {
    $expenseData = $this->getExpenseDataForCategory($category->name);
    $transactionCount = $expenseData['frequency'];

    for ($i = 0; $i < $transactionCount; $i++) {
      $date = $this->randomDateBetween($startDate, $endDate);
      $expense = $expenseData['transactions'][array_rand($expenseData['transactions'])];

      // Add some randomness to amounts
      $amount = $expense['amount'] * (0.8 + (rand(0, 40) / 100)); // ±20% variation

      Transaction::create([
        'user_id' => $user->id,
        'financial_plan_id' => $plan->id,
        'expense_category_id' => $category->id,
        'type' => 'expense',
        'amount' => round($amount, 2),
        'description' => $expense['description'],
        'notes' => $expense['notes'] ?? null,
        'transaction_date' => $date,
        'payment_method' => $expense['payment_method'],
        'is_recurring' => $expense['recurring'] ?? false,
        'recurring_frequency' => ($expense['recurring'] ?? false) ? 'monthly' : null, // Fixed this line
      ]);
    }
  }

  private function getExpenseDataForCategory($categoryName): array
  {
    $expenseData = [
      'Housing & Rent' => [
        'frequency' => 1,
        'transactions' => [
          ['description' => 'Monthly Rent Payment', 'amount' => 1800, 'payment_method' => 'bank_transfer', 'recurring' => true],
          ['description' => 'Property Tax', 'amount' => 300, 'payment_method' => 'bank_transfer', 'recurring' => false],
          ['description' => 'Home Maintenance', 'amount' => 200, 'payment_method' => 'credit_card', 'recurring' => false],
        ]
      ],
      'Groceries' => [
        'frequency' => rand(8, 12),
        'transactions' => [
          ['description' => 'Walmart Grocery Shopping', 'amount' => 85, 'payment_method' => 'debit_card', 'recurring' => false],
          ['description' => 'Target Groceries', 'amount' => 120, 'payment_method' => 'credit_card', 'recurring' => false],
          ['description' => 'Whole Foods Market', 'amount' => 95, 'payment_method' => 'credit_card', 'recurring' => false],
          ['description' => 'Local Farmers Market', 'amount' => 45, 'payment_method' => 'cash', 'recurring' => false],
          ['description' => 'Costco Bulk Shopping', 'amount' => 180, 'payment_method' => 'debit_card', 'recurring' => false],
        ]
      ],
      'Transportation' => [
        'frequency' => rand(6, 10),
        'transactions' => [
          ['description' => 'Gas Station Fill-up', 'amount' => 55, 'payment_method' => 'credit_card', 'recurring' => false],
          ['description' => 'Uber Ride', 'amount' => 25, 'payment_method' => 'mobile_payment', 'recurring' => false],
          ['description' => 'Public Transit Pass', 'amount' => 120, 'payment_method' => 'debit_card', 'recurring' => true],
          ['description' => 'Car Maintenance', 'amount' => 150, 'payment_method' => 'credit_card', 'recurring' => false],
          ['description' => 'Parking Fee', 'amount' => 15, 'payment_method' => 'mobile_payment', 'recurring' => false],
        ]
      ],
      'Utilities' => [
        'frequency' => rand(3, 5),
        'transactions' => [
          ['description' => 'Electricity Bill', 'amount' => 85, 'payment_method' => 'bank_transfer', 'recurring' => true],
          ['description' => 'Water & Sewer', 'amount' => 45, 'payment_method' => 'bank_transfer', 'recurring' => true],
          ['description' => 'Natural Gas', 'amount' => 65, 'payment_method' => 'bank_transfer', 'recurring' => true],
          ['description' => 'Trash & Recycling', 'amount' => 35, 'payment_method' => 'bank_transfer', 'recurring' => true],
        ]
      ],
      'Healthcare' => [
        'frequency' => rand(1, 3),
        'transactions' => [
          ['description' => 'Doctor Visit Copay', 'amount' => 25, 'payment_method' => 'debit_card', 'recurring' => false],
          ['description' => 'Prescription Medication', 'amount' => 45, 'payment_method' => 'credit_card', 'recurring' => false],
          ['description' => 'Dental Cleaning', 'amount' => 120, 'payment_method' => 'credit_card', 'recurring' => false],
          ['description' => 'Eye Exam', 'amount' => 80, 'payment_method' => 'credit_card', 'recurring' => false],
          ['description' => 'Physical Therapy', 'amount' => 75, 'payment_method' => 'credit_card', 'recurring' => false],
        ]
      ],
      'Phone & Internet' => [
        'frequency' => 2,
        'transactions' => [
          ['description' => 'Cell Phone Bill', 'amount' => 75, 'payment_method' => 'bank_transfer', 'recurring' => true],
          ['description' => 'Internet Service', 'amount' => 65, 'payment_method' => 'bank_transfer', 'recurring' => true],
        ]
      ],
      'Insurance' => [
        'frequency' => rand(1, 2),
        'transactions' => [
          ['description' => 'Auto Insurance', 'amount' => 125, 'payment_method' => 'bank_transfer', 'recurring' => true],
          ['description' => 'Health Insurance Premium', 'amount' => 180, 'payment_method' => 'bank_transfer', 'recurring' => true],
          ['description' => 'Renters Insurance', 'amount' => 25, 'payment_method' => 'bank_transfer', 'recurring' => true],
        ]
      ],
      'Entertainment' => [
        'frequency' => rand(4, 8),
        'transactions' => [
          ['description' => 'Movie Theater', 'amount' => 35, 'payment_method' => 'credit_card', 'recurring' => false],
          ['description' => 'Concert Tickets', 'amount' => 120, 'payment_method' => 'credit_card', 'recurring' => false],
          ['description' => 'Streaming Services', 'amount' => 45, 'payment_method' => 'credit_card', 'recurring' => true],
          ['description' => 'Video Games', 'amount' => 60, 'payment_method' => 'credit_card', 'recurring' => false],
          ['description' => 'Board Game Night', 'amount' => 25, 'payment_method' => 'cash', 'recurring' => false],
        ]
      ],
      'Dining Out' => [
        'frequency' => rand(8, 15),
        'transactions' => [
          ['description' => 'Restaurant Dinner', 'amount' => 65, 'payment_method' => 'credit_card', 'recurring' => false],
          ['description' => 'Coffee Shop', 'amount' => 12, 'payment_method' => 'mobile_payment', 'recurring' => false],
          ['description' => 'Fast Food Lunch', 'amount' => 18, 'payment_method' => 'debit_card', 'recurring' => false],
          ['description' => 'Food Delivery', 'amount' => 35, 'payment_method' => 'credit_card', 'recurring' => false],
          ['description' => 'Breakfast Cafe', 'amount' => 22, 'payment_method' => 'credit_card', 'recurring' => false],
        ]
      ],
      'Shopping' => [
        'frequency' => rand(3, 7),
        'transactions' => [
          ['description' => 'Clothing Purchase', 'amount' => 85, 'payment_method' => 'credit_card', 'recurring' => false],
          ['description' => 'Amazon Order', 'amount' => 45, 'payment_method' => 'credit_card', 'recurring' => false],
          ['description' => 'Electronics Store', 'amount' => 200, 'payment_method' => 'credit_card', 'recurring' => false],
          ['description' => 'Home Goods', 'amount' => 65, 'payment_method' => 'debit_card', 'recurring' => false],
          ['description' => 'Online Shopping', 'amount' => 35, 'payment_method' => 'credit_card', 'recurring' => false],
        ]
      ],
      'Gym & Fitness' => [
        'frequency' => rand(1, 3),
        'transactions' => [
          ['description' => 'Gym Membership', 'amount' => 45, 'payment_method' => 'bank_transfer', 'recurring' => true],
          ['description' => 'Personal Training Session', 'amount' => 75, 'payment_method' => 'credit_card', 'recurring' => false],
          ['description' => 'Fitness Equipment', 'amount' => 120, 'payment_method' => 'credit_card', 'recurring' => false],
        ]
      ],
      'Education' => [
        'frequency' => rand(1, 3),
        'transactions' => [
          ['description' => 'Online Course', 'amount' => 99, 'payment_method' => 'credit_card', 'recurring' => false],
          ['description' => 'Books & Materials', 'amount' => 45, 'payment_method' => 'credit_card', 'recurring' => false],
          ['description' => 'Conference Ticket', 'amount' => 250, 'payment_method' => 'credit_card', 'recurring' => false],
        ]
      ],
      'Travel' => [
        'frequency' => rand(0, 2),
        'transactions' => [
          ['description' => 'Flight Tickets', 'amount' => 450, 'payment_method' => 'credit_card', 'recurring' => false],
          ['description' => 'Hotel Booking', 'amount' => 180, 'payment_method' => 'credit_card', 'recurring' => false],
          ['description' => 'Travel Insurance', 'amount' => 65, 'payment_method' => 'credit_card', 'recurring' => false],
        ]
      ],
      'Subscriptions' => [
        'frequency' => rand(2, 4),
        'transactions' => [
          ['description' => 'Netflix Subscription', 'amount' => 15, 'payment_method' => 'credit_card', 'recurring' => true],
          ['description' => 'Spotify Premium', 'amount' => 10, 'payment_method' => 'credit_card', 'recurring' => true],
          ['description' => 'Software License', 'amount' => 25, 'payment_method' => 'credit_card', 'recurring' => true],
        ]
      ],
      'Personal Care' => [
        'frequency' => rand(2, 5),
        'transactions' => [
          ['description' => 'Haircut & Styling', 'amount' => 45, 'payment_method' => 'cash', 'recurring' => false],
          ['description' => 'Skincare Products', 'amount' => 35, 'payment_method' => 'credit_card', 'recurring' => false],
          ['description' => 'Spa Treatment', 'amount' => 85, 'payment_method' => 'credit_card', 'recurring' => false],
        ]
      ],
    ];

    // Default data for categories not specifically defined
    $defaultData = [
      'frequency' => rand(1, 4),
      'transactions' => [
        ['description' => 'Miscellaneous Expense', 'amount' => 50, 'payment_method' => 'credit_card', 'recurring' => false],
        ['description' => 'Category Purchase', 'amount' => 75, 'payment_method' => 'debit_card', 'recurring' => false],
      ]
    ];

    return $expenseData[$categoryName] ?? $defaultData;
  }

  private function randomDateBetween($startDate, $endDate): Carbon
  {
    $startTimestamp = $startDate->timestamp;
    $endTimestamp = $endDate->timestamp;
    $randomTimestamp = rand($startTimestamp, $endTimestamp);

    return Carbon::createFromTimestamp($randomTimestamp);
  }
}
