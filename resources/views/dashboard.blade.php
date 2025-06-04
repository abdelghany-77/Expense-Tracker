@extends('layouts.app')

@section('title', 'Financial Dashboard')

@section('content')
  <!-- Dashboard Header -->
  <div class="dashboard-header">
    <div class="header-content">
      <div class="header-background"></div>
      <div class="welcome-section">
        <h1 class="dashboard-title">
          <span class="title-gradient">Financial Dashboard</span>
          <div class="title-underline"></div>
        </h1>
        <p class="dashboard-subtitle">
          <span class="plan-icon" aria-hidden="true">📊</span>
          Welcome back, {{ Auth::user()->name }}
        </p>
        <div class="quick-stats">
          <div class="quick-stat">
            <span class="stat-label">This Month</span>
            <span class="stat-value positive" aria-label="Net income this month">
              ${{ number_format(($monthlyIncome ?? 0) - ($monthlyExpenses ?? 0), 2) }}
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Key Metrics Grid -->
  <div class="metrics-grid">
    <article class="metric-card income" data-aos="fade-up" data-aos-delay="100">
      <div class="metric-icon">
        <span class="icon-emoji" aria-hidden="true">💰</span>
        <div class="icon-bg"></div>
      </div>
      <div class="metric-content">
        <div class="metric-value" data-counter="{{ $monthlyIncome ?? 0 }}">
          ${{ number_format($monthlyIncome ?? 0, 2) }}
        </div>
        <h3 class="metric-label">Monthly Income</h3>
        <div class="metric-trend positive">
          <span class="trend-icon" aria-hidden="true">↗️</span>
          <span class="trend-text">+12.5% from last month</span>
        </div>
      </div>
      <div class="metric-overlay"></div>
    </article>

    <article class="metric-card expense" data-aos="fade-up" data-aos-delay="200">
      <div class="metric-icon">
        <span class="icon-emoji" aria-hidden="true">💸</span>
        <div class="icon-bg"></div>
      </div>
      <div class="metric-content">
        <div class="metric-value" data-counter="{{ $monthlyExpenses ?? 0 }}">
          ${{ number_format($monthlyExpenses ?? 0, 2) }}
        </div>
        <h3 class="metric-label">Monthly Expenses</h3>
        <div class="metric-trend negative">
          <span class="trend-icon" aria-hidden="true">📈</span>
          <span class="trend-text">+8.3% from last month</span>
        </div>
      </div>
      <div class="metric-overlay"></div>
    </article>

    <article class="metric-card savings" data-aos="fade-up" data-aos-delay="300">
      <div class="metric-icon">
        <span class="icon-emoji" aria-hidden="true">🏦</span>
        <div class="icon-bg"></div>
      </div>
      <div class="metric-content">
        <div class="metric-value" data-counter="{{ $monthlySavings ?? 0 }}">
          ${{ number_format($monthlySavings ?? 0, 2) }}
        </div>
        <h3 class="metric-label">Monthly Savings</h3>
        <div class="metric-trend positive">
          <span class="savings-ring">
            <svg viewBox="0 0 36 36" class="savings-chart"
              aria-label="Savings progress {{ number_format($savingsRate ?? 20, 1) }} percent">
              <path class="savings-bg"
                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
              <path class="savings-progress" stroke-dasharray="{{ $savingsRate ?? 20 }}, 100"
                d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
            </svg>
          </span>
          <span class="trend-text">{{ number_format($savingsRate ?? 20, 1) }}% savings rate</span>
        </div>
      </div>
      <div class="metric-overlay"></div>
    </article>

    <article class="metric-card net-worth" data-aos="fade-up" data-aos-delay="400">
      <div class="metric-icon">
        <span class="icon-emoji" aria-hidden="true">📈</span>
        <div class="icon-bg"></div>
      </div>
      <div class="metric-content">
        <div class="metric-value" data-counter="{{ $netWorth ?? 25000 }}">
          ${{ number_format($netWorth ?? 25000, 2) }}
        </div>
        <h3 class="metric-label">Net Worth</h3>
        <div class="metric-trend positive">
          <span class="trend-icon" aria-hidden="true">📊</span>
          <span class="trend-text">Growing steadily</span>
        </div>
      </div>
      <div class="metric-overlay"></div>
    </article>
  </div>

  <!-- Charts Section -->
  <div class="charts-section">
    <!-- Monthly Trends Chart -->
    <section class="chart-section trends-section" data-aos="fade-up" data-aos-delay="500">
      <div class="section-wrapper">
        <header class="section-header trends-header">
          <div class="header-left">
            <h2 class="section-title">
              <span class="title-icon trends-icon">
                <span class="icon-emoji" aria-hidden="true">📊</span>
                <div class="icon-glow"></div>
              </span>
              <span class="title-text">Monthly Trends</span>
            </h2>
            <p class="section-subtitle">Track your financial progress over time</p>
          </div>
        </header>

        <div class="chart-container trends-container">
          <div class="chart-background">
            <div class="grid-lines"></div>
          </div>
          <canvas id="trendsChart" role="img" aria-label="Monthly financial trends chart"></canvas>
          <div class="chart-loading" id="trendsLoading" aria-live="polite">
            <div class="loading-spinner"></div>
            <p>Loading trends...</p>
          </div>
        </div>

        <div class="chart-insights">
          <div class="insight-item">
            <span class="insight-label">Best Month</span>
            <span class="insight-value positive">March</span>
          </div>
          <div class="insight-item">
            <span class="insight-label">Average</span>
            <span class="insight-value">$2,450</span>
          </div>
          <div class="insight-item">
            <span class="insight-label">Trend</span>
            <span class="insight-value positive">↗️ Growing</span>
          </div>
        </div>
      </div>
    </section>

    <!-- Category Spending Chart -->
    <section class="chart-section spending-section" data-aos="fade-up" data-aos-delay="600">
      <div class="section-wrapper">
        <header class="section-header spending-header">
          <div class="header-left">
            <h2 class="section-title">
              <span class="title-icon spending-icon">
                <span class="icon-emoji" aria-hidden="true">🎯</span>
                <div class="icon-glow"></div>
              </span>
              <span class="title-text">Category Spending</span>
            </h2>
            <p class="section-subtitle">Breakdown of your expenses by category</p>
          </div>
          <div class="spending-summary">
            <div class="summary-item">
              <span class="summary-value">${{ number_format($totalCategorySpending ?? 3250, 2) }}</span>
              <span class="summary-label">Total Spent</span>
            </div>
            <div class="summary-item">
              <span class="summary-value">{{ $categoryCount ?? 6 }}</span>
              <span class="summary-label">Categories</span>
            </div>
          </div>
        </header>

        <div class="chart-container spending-container">
          <div class="chart-background">
            <div class="radial-grid"></div>
          </div>
          <canvas id="categoryChart" role="img" aria-label="Category spending breakdown chart"></canvas>
          <div class="chart-loading" id="categoryLoading" aria-live="polite">
            <div class="loading-spinner"></div>
            <p>Loading categories...</p>
          </div>
        </div>

        <div class="category-list enhanced">
          <header class="category-header-section">
            <h3 class="category-section-title">
              <span class="section-icon" aria-hidden="true">📋</span>
              Category Breakdown
            </h3>
            <div class="category-controls" role="tablist" aria-label="Category filter options">
              <button class="category-control active" data-view="all" role="tab" aria-selected="true">All</button>
              <button class="category-control" data-view="over-budget" role="tab" aria-selected="false">Over
                Budget</button>
              <button class="category-control" data-view="on-track" role="tab" aria-selected="false">On
                Track</button>
            </div>
          </header>

          @php
            $sampleCategories = [
                ['name' => 'Food & Dining', 'icon' => '🍽️', 'spent' => 850, 'budget' => 800, 'color' => '#ef4444'],
                ['name' => 'Transportation', 'icon' => '🚗', 'spent' => 420, 'budget' => 500, 'color' => '#3b82f6'],
                ['name' => 'Entertainment', 'icon' => '🎬', 'spent' => 220, 'budget' => 300, 'color' => '#8b5cf6'],
                ['name' => 'Shopping', 'icon' => '🛍️', 'spent' => 380, 'budget' => 400, 'color' => '#f59e0b'],
                ['name' => 'Healthcare', 'icon' => '🏥', 'spent' => 150, 'budget' => 200, 'color' => '#10b981'],
                ['name' => 'Utilities', 'icon' => '⚡', 'spent' => 275, 'budget' => 300, 'color' => '#6366f1'],
            ];
          @endphp

          <div class="categories-container" role="tabpanel">
            @foreach ($sampleCategories as $index => $category)
              @php
                $utilization = ($category['spent'] / $category['budget']) * 100;
                $status = $utilization > 100 ? 'over-budget' : ($utilization > 80 ? 'warning' : 'on-track');
              @endphp
              <article class="category-item enhanced premium"
                style="--category-color: {{ $category['color'] }}; --item-delay: {{ $index * 100 }}ms;"
                data-aos="fade-up" data-aos-delay="{{ 700 + $index * 100 }}" data-status="{{ $status }}">
                <div class="category-card-wrapper">
                  <header class="category-header">
                    <div class="category-info">
                      <div class="category-icon-wrapper">
                        <span class="category-icon" aria-hidden="true">{{ $category['icon'] }}</span>
                        <div class="icon-background"></div>
                      </div>
                      <div class="category-details">
                        <h4 class="category-name">{{ $category['name'] }}</h4>
                        <span class="category-description">Budget: ${{ number_format($category['budget'], 2) }}</span>
                      </div>
                    </div>
                    <div class="category-amount-section">
                      <div class="amount-display">
                        <span class="currency-symbol">$</span>
                        <span class="amount-value">{{ number_format($category['spent'], 2) }}</span>
                      </div>
                      <div class="budget-comparison">
                        <span class="budget-label">of</span>
                        <span class="budget-total">${{ number_format($category['budget'], 2) }}</span>
                      </div>
                    </div>
                  </header>

                  <div class="progress-section enhanced">
                    <div class="progress-header">
                      <span class="progress-label">Budget Usage</span>
                      <span class="progress-percentage">{{ number_format($utilization, 1) }}%</span>
                    </div>
                    <div class="progress-container premium" role="progressbar" aria-valuenow="{{ $utilization }}"
                      aria-valuemin="0" aria-valuemax="100" aria-label="Budget usage for {{ $category['name'] }}">
                      <div class="progress-track"></div>
                      <div class="progress-bar animated"
                        style="width: {{ min($utilization, 100) }}%;
                                  background: linear-gradient(90deg, {{ $category['color'] }}, {{ $category['color'] }}cc);">
                        <div class="progress-shine"></div>
                        <div class="progress-glow"></div>
                      </div>
                      @if ($utilization > 100)
                        <div class="progress-overflow"
                          style="width: {{ min($utilization - 100, 50) }}%;
                                    background: linear-gradient(90deg, #ef4444, #dc2626);">
                        </div>
                      @endif
                    </div>
                    <footer class="progress-footer">
                      <div class="status-indicator {{ $status }}">
                        <span class="status-dot" aria-hidden="true"></span>
                        <span class="status-text">
                          {{ $utilization > 100 ? 'Over Budget' : ($utilization > 80 ? 'Near Limit' : 'On Track') }}
                        </span>
                      </div>
                      <div class="remaining-budget">
                        <span class="remaining-label">Remaining:</span>
                        <span
                          class="remaining-amount {{ $category['budget'] - $category['spent'] < 0 ? 'negative' : 'positive' }}">
                          ${{ number_format(max(0, $category['budget'] - $category['spent']), 2) }}
                        </span>
                      </div>
                    </footer>
                  </div>
                </div>
              </article>
            @endforeach
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- Savings Goals Progress -->
  <section class="goals-section enhanced" data-aos="fade-up" data-aos-delay="900">
    <div class="section-wrapper premium">
      <header class="section-header goals-header">
        <div class="header-left">
          <h2 class="section-title">
            <span class="title-icon goals-icon">
              <span class="icon-emoji" aria-hidden="true">🎯</span>
              <div class="icon-glow"></div>
            </span>
            <span class="title-text">Savings Goals Progress</span>
          </h2>
          <p class="section-subtitle">Track your progress towards financial goals</p>
        </div>
        <div class="goals-summary">
          <div class="summary-stat">
            <span class="stat-value">3</span>
            <span class="stat-label">Active Goals</span>
          </div>
          <div class="summary-stat">
            <span class="stat-value">$12,450</span>
            <span class="stat-label">Total Saved</span>
          </div>
        </div>
      </header>

      <div class="goals-grid enhanced">
        @php
          $sampleGoals = [
              ['name' => 'Emergency Fund', 'current' => 8500, 'target' => 15000, 'days' => 120, 'color' => '#10b981'],
              ['name' => 'Vacation Fund', 'current' => 2450, 'target' => 5000, 'days' => 45, 'color' => '#3b82f6'],
              ['name' => 'New Car', 'current' => 1500, 'target' => 25000, 'days' => 365, 'color' => '#8b5cf6'],
          ];
        @endphp

        @foreach ($sampleGoals as $index => $goal)
          @php
            $progress = ($goal['current'] / $goal['target']) * 100;
            $priority = $goal['days'] < 30 ? 'urgent' : ($goal['days'] < 90 ? 'moderate' : 'normal');
          @endphp
          <article class="goal-card enhanced premium" data-aos="zoom-in" data-aos-delay="{{ 1000 + $index * 150 }}"
            style="--goal-color: {{ $goal['color'] }}; --goal-delay: {{ $index * 150 }}ms;">
            <div class="goal-background"></div>
            <header class="goal-header enhanced">
              <div class="goal-icon-section">
                <div class="goal-icon-wrapper">
                  <span class="goal-icon" aria-hidden="true">🎯</span>
                  <div class="goal-icon-bg"></div>
                </div>
                <div class="goal-priority {{ $priority }}">
                  <span class="priority-dot" aria-hidden="true"></span>
                  <span class="priority-text">
                    {{ $goal['days'] < 30 ? 'Urgent' : ($goal['days'] < 90 ? 'Moderate' : 'Normal') }}
                  </span>
                </div>
              </div>
              <h3 class="goal-name">{{ $goal['name'] }}</h3>
              <div class="goal-amounts">
                <div class="current-amount">
                  <span class="amount-label">Current</span>
                  <span class="amount-value">${{ number_format($goal['current'], 2) }}</span>
                </div>
                <div class="target-amount">
                  <span class="amount-label">Target</span>
                  <span class="amount-value">${{ number_format($goal['target'], 2) }}</span>
                </div>
              </div>
            </header>

            <div class="goal-progress enhanced">
              <div class="progress-visual">
                <div class="circular-progress" style="--progress: {{ $progress }};">
                  <svg class="progress-ring" width="120" height="120"
                    aria-label="Goal progress {{ number_format($progress, 0) }} percent complete">
                    <circle class="progress-ring-bg" cx="60" cy="60" r="54"></circle>
                    <circle class="progress-ring-progress" cx="60" cy="60" r="54"
                      style="--progress-color: {{ $goal['color'] }};
                                   stroke-dasharray: {{ $progress * 3.39 }}, 339;">
                    </circle>
                  </svg>
                  <div class="progress-center">
                    <span class="progress-percent">{{ number_format($progress, 0) }}%</span>
                    <span class="progress-label">Complete</span>
                  </div>
                </div>

                <div class="linear-progress" role="progressbar" aria-valuenow="{{ $progress }}" aria-valuemin="0"
                  aria-valuemax="100" aria-label="Linear progress for {{ $goal['name'] }}">
                  <div class="progress-track"></div>
                  <div class="progress-fill" style="width: {{ $progress }}%; background: {{ $goal['color'] }};">
                    <div class="progress-glow"></div>
                  </div>
                </div>
              </div>

              <div class="goal-stats enhanced">
                <div class="stat-item">
                  <span class="stat-icon" aria-hidden="true">💰</span>
                  <div class="stat-content">
                    <span class="stat-value">${{ number_format($goal['target'] - $goal['current'], 2) }}</span>
                    <span class="stat-label">Remaining</span>
                  </div>
                </div>
                <div class="stat-item">
                  <span class="stat-icon" aria-hidden="true">📅</span>
                  <div class="stat-content">
                    <span class="stat-value">{{ $goal['days'] }}</span>
                    <span class="stat-label">Days Left</span>
                  </div>
                </div>
                <div class="stat-item">
                  <span class="stat-icon" aria-hidden="true">📈</span>
                  <div class="stat-content">
                    <span class="stat-value">
                      ${{ number_format(($goal['target'] - $goal['current']) / max($goal['days'], 1), 2) }}
                    </span>
                    <span class="stat-label">Per Day</span>
                  </div>
                </div>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Recent Transactions -->
  <section class="transactions-section enhanced" data-aos="fade-up" data-aos-delay="800">
    <div class="section-wrapper">
      <header class="section-header transactions-header">
        <div class="header-left">
          <h2 class="section-title">
            <span class="title-icon transactions-icon">
              <span class="icon-emoji" aria-hidden="true">💳</span>
              <div class="icon-glow"></div>
            </span>
            <span class="title-text">Recent Transactions</span>
          </h2>
          <p class="section-subtitle">Your latest financial activities</p>
        </div>
        <div class="transaction-actions">
          <a href="{{ route('transactions.create') }}" class="action-btn primary">
            <span class="btn-icon" aria-hidden="true">➕</span>
            <span class="btn-text">Add Transaction</span>
          </a>
          <a href="{{ route('transactions.index') }}" class="action-btn secondary">
            <span class="btn-icon" aria-hidden="true">👁️</span>
            <span class="btn-text">View All</span>
          </a>
        </div>
      </header>

      @php
        $sampleTransactions = [
            [
                'date' => '15',
                'month' => 'Nov',
                'description' => 'Grocery Shopping',
                'category' => 'Food & Dining',
                'icon' => '🍽️',
                'type' => 'expense',
                'amount' => 89.5,
                'color' => '#ef4444',
            ],
            [
                'date' => '14',
                'month' => 'Nov',
                'description' => 'Salary Deposit',
                'category' => 'Income',
                'icon' => '💰',
                'type' => 'income',
                'amount' => 3500.0,
                'color' => '#10b981',
            ],
            [
                'date' => '13',
                'month' => 'Nov',
                'description' => 'Gas Station',
                'category' => 'Transportation',
                'icon' => '⛽',
                'type' => 'expense',
                'amount' => 45.2,
                'color' => '#3b82f6',
            ],
            [
                'date' => '12',
                'month' => 'Nov',
                'description' => 'Movie Tickets',
                'category' => 'Entertainment',
                'icon' => '🎬',
                'type' => 'expense',
                'amount' => 28.0,
                'color' => '#8b5cf6',
            ],
            [
                'date' => '11',
                'month' => 'Nov',
                'description' => 'Emergency Fund',
                'category' => 'Savings',
                'icon' => '🏦',
                'type' => 'savings',
                'amount' => 200.0,
                'color' => '#10b981',
            ],
        ];
      @endphp

      <div class="transactions-table enhanced">
        <div class="table-header">
          <div class="table-info">
            <span class="transaction-count">{{ count($sampleTransactions) }}</span>
            <span class="transaction-label">Recent Transactions</span>
          </div>
          <div class="table-filters" role="tablist" aria-label="Transaction filter options">
            <button class="filter-btn active" data-filter="all" role="tab" aria-selected="true">All</button>
            <button class="filter-btn" data-filter="expense" role="tab" aria-selected="false">Expenses</button>
            <button class="filter-btn" data-filter="income" role="tab" aria-selected="false">Income</button>
          </div>
        </div>

        <div class="table-container">
          <table class="enhanced-table" role="table" aria-label="Recent transactions table">
            <thead>
              <tr>
                <th class="sortable" data-sort="date" tabindex="0" role="columnheader" aria-sort="none"
                  aria-label="Sort by date">
                  <span>Date</span>
                  <span class="sort-icon" aria-hidden="true">⇅</span>
                </th>
                <th class="sortable" data-sort="description" tabindex="0" role="columnheader" aria-sort="none"
                  aria-label="Sort by description">
                  <span>Description</span>
                  <span class="sort-icon" aria-hidden="true">⇅</span>
                </th>
                <th role="columnheader">Category</th>
                <th class="sortable" data-sort="type" tabindex="0" role="columnheader" aria-sort="none"
                  aria-label="Sort by type">
                  <span>Type</span>
                  <span class="sort-icon" aria-hidden="true">⇅</span>
                </th>
                <th class="sortable" data-sort="amount" tabindex="0" role="columnheader" aria-sort="none"
                  aria-label="Sort by amount">
                  <span>Amount</span>
                  <span class="sort-icon" aria-hidden="true">⇅</span>
                </th>
                <th role="columnheader">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($sampleTransactions as $index => $transaction)
                <tr class="transaction-row enhanced" data-type="{{ $transaction['type'] }}" data-aos="fade-up"
                  data-aos-delay="{{ 900 + $index * 50 }}">
                  <td class="date-cell">
                    <div class="date-wrapper">
                      <span class="date-day">{{ $transaction['date'] }}</span>
                      <span class="date-month">{{ $transaction['month'] }}</span>
                    </div>
                  </td>
                  <td class="description-cell">
                    <div class="description-wrapper">
                      <span class="description-text">{{ $transaction['description'] }}</span>
                    </div>
                  </td>
                  <td class="category-cell">
                    <div class="category-tag enhanced" style="--category-color: {{ $transaction['color'] }};">
                      <span class="category-icon" aria-hidden="true">{{ $transaction['icon'] }}</span>
                      <span class="category-name">{{ $transaction['category'] }}</span>
                    </div>
                  </td>
                  <td class="type-cell">
                    <span class="transaction-type enhanced transaction-type-{{ $transaction['type'] }}">
                      <span class="type-icon" aria-hidden="true">{{ $transaction['icon'] }}</span>
                      <span class="type-text">{{ ucfirst($transaction['type']) }}</span>
                    </span>
                  </td>
                  <td class="amount-cell">
                    <div class="amount-wrapper">
                      <span class="amount enhanced {{ $transaction['type'] === 'expense' ? 'negative' : 'positive' }}">
                        <span class="amount-sign">{{ $transaction['type'] === 'expense' ? '-' : '+' }}</span>
                        <span class="amount-value">${{ number_format($transaction['amount'], 2) }}</span>
                      </span>
                    </div>
                  </td>
                  <td class="actions-cell">
                    <div class="action-buttons">
                      <button class="action-btn mini" title="Edit {{ $transaction['description'] }}"
                        aria-label="Edit transaction">
                        <span class="action-icon" aria-hidden="true">✏️</span>
                      </button>
                      <button class="action-btn mini delete" title="Delete {{ $transaction['description'] }}"
                        aria-label="Delete transaction">
                        <span class="action-icon" aria-hidden="true">🗑️</span>
                      </button>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

  <!-- Quick Actions Panel -->
  <section class="quick-actions-panel" data-aos="fade-up" data-aos-delay="1200">
    <header class="panel-header">
      <h2 class="panel-title">
        <span class="panel-icon" aria-hidden="true">⚡</span>
        Quick Actions
      </h2>
    </header>
    <div class="actions-grid">
      <a href="{{ route('transactions.create') }}" class="quick-action add-transaction">
        <div class="action-icon" aria-hidden="true">➕</div>
        <div class="action-content">
          <span class="action-title">Add Transaction</span>
          <span class="action-subtitle">Record income or expense</span>
        </div>
      </a>

      <a href="{{ route('savings-goals.create') }}" class="quick-action add-goal">
        <div class="action-icon" aria-hidden="true">🎯</div>
        <div class="action-content">
          <span class="action-title">Add Goal</span>
          <span class="action-subtitle">Set savings targets</span>
        </div>
      </a>

      <a href="{{ route('reports.index') }}" class="quick-action view-reports">
        <div class="action-icon" aria-hidden="true">📈</div>
        <div class="action-content">
          <span class="action-title">View Reports</span>
          <span class="action-subtitle">Analyze your finances</span>
        </div>
      </a>
    </div>
  </section>

  @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS with reduced motion support
        AOS.init({
          duration: 800,
          easing: 'ease-out-cubic',
          once: true,
          disable: window.matchMedia('(prefers-reduced-motion: reduce)').matches
        });

        // Animated counters with accessibility
        const counters = document.querySelectorAll('[data-counter]');
        const observerOptions = {
          threshold: 0.1,
          rootMargin: '0px 0px -50px 0px'
        };

        const counterObserver = new IntersectionObserver((entries) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              const target = parseFloat(entry.target.dataset.counter);
              animateCounter(entry.target, target);
              counterObserver.unobserve(entry.target);
            }
          });
        }, observerOptions);

        counters.forEach(counter => counterObserver.observe(counter));

        // Hide loading overlays and show charts
        const initTimer = setTimeout(() => {
          const loadingElements = document.querySelectorAll('.chart-loading');
          loadingElements.forEach(loading => {
            loading.style.display = 'none';
            loading.setAttribute('aria-hidden', 'true');
          });
          initializeCharts();
        }, 1000);

        // Enhanced category filter functionality
        const categoryControls = document.querySelectorAll('.category-control');
        categoryControls.forEach(control => {
          control.addEventListener('click', function() {
            // Update ARIA states
            categoryControls.forEach(c => {
              c.classList.remove('active');
              c.setAttribute('aria-selected', 'false');
            });
            this.classList.add('active');
            this.setAttribute('aria-selected', 'true');
            filterCategories(this.dataset.view);
          });

          // Keyboard navigation
          control.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
              e.preventDefault();
              this.click();
            }
          });
        });

        // Enhanced transaction filter functionality
        const filterBtns = document.querySelectorAll('.filter-btn');
        filterBtns.forEach(btn => {
          btn.addEventListener('click', function() {
            filterBtns.forEach(b => {
              b.classList.remove('active');
              b.setAttribute('aria-selected', 'false');
            });
            this.classList.add('active');
            this.setAttribute('aria-selected', 'true');
            filterTransactions(this.dataset.filter);
          });

          // Keyboard navigation
          btn.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
              e.preventDefault();
              this.click();
            }
          });
        });

        // Enhanced table sorting
        const sortableHeaders = document.querySelectorAll('.sortable');
        sortableHeaders.forEach(header => {
          header.addEventListener('click', function() {
            sortTable(this.dataset.sort);
          });

          header.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
              e.preventDefault();
              sortTable(this.dataset.sort);
            }
          });
        });

        // Cleanup
        window.addEventListener('beforeunload', () => {
          clearTimeout(initTimer);
        });
      });

      function animateCounter(element, target) {
        let current = 0;
        const increment = target / 50;
        const timer = setInterval(() => {
          current += increment;
          if (current >= target) {
            current = target;
            clearInterval(timer);
          }
          element.textContent = '$' + current.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
          });
        }, 40);
      }

      function initializeCharts() {
        // Chart.js default configurations
        Chart.defaults.font.family = 'Inter, -apple-system, BlinkMacSystemFont, sans-serif';
        Chart.defaults.color = '#64748b';
        Chart.defaults.borderColor = 'rgba(241, 245, 249, 0.3)';

        // Monthly trends chart with accessibility
        const trendsCtx = document.getElementById('trendsChart');
        if (trendsCtx) {
          new Chart(trendsCtx, {
            type: 'line',
            data: {
              labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
              datasets: [{
                label: 'Net Income',
                data: [1200, 1800, 2400, 2100, 2800, 2450],
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#667eea',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
              }]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              interaction: {
                intersect: false,
                mode: 'index'
              },
              plugins: {
                legend: {
                  display: false
                },
                tooltip: {
                  backgroundColor: 'rgba(255, 255, 255, 0.95)',
                  titleColor: '#1e293b',
                  bodyColor: '#475569',
                  borderColor: 'rgba(102, 126, 234, 0.2)',
                  borderWidth: 1,
                  cornerRadius: 12,
                  padding: 12
                }
              },
              scales: {
                x: {
                  grid: {
                    display: false
                  },
                  ticks: {
                    font: {
                      weight: 500
                    }
                  }
                },
                y: {
                  beginAtZero: true,
                  grid: {
                    color: 'rgba(241, 245, 249, 0.5)'
                  },
                  ticks: {
                    callback: function(value) {
                      return '$' + value.toLocaleString();
                    }
                  }
                }
              }
            }
          });
        }

        // Category spending pie chart with accessibility
        const categoryCtx = document.getElementById('categoryChart');
        if (categoryCtx) {
          new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
              labels: ['Food & Dining', 'Transportation', 'Entertainment', 'Shopping', 'Healthcare', 'Utilities'],
              datasets: [{
                data: [850, 420, 220, 380, 150, 275],
                backgroundColor: ['#ef4444', '#3b82f6', '#8b5cf6', '#f59e0b', '#10b981', '#6366f1'],
                borderWidth: 0,
                hoverBorderWidth: 3,
                hoverBorderColor: '#ffffff'
              }]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              cutout: '60%',
              plugins: {
                legend: {
                  display: false
                },
                tooltip: {
                  backgroundColor: 'rgba(255, 255, 255, 0.95)',
                  titleColor: '#1e293b',
                  bodyColor: '#475569',
                  borderColor: 'rgba(102, 126, 234, 0.2)',
                  borderWidth: 1,
                  cornerRadius: 12,
                  padding: 12,
                  callbacks: {
                    label: function(context) {
                      const label = context.label || '';
                      const value = context.parsed;
                      const total = context.dataset.data.reduce((a, b) => a + b, 0);
                      const percentage = ((value / total) * 100).toFixed(1);
                      return `${label}: $${value.toLocaleString()} (${percentage}%)`;
                    }
                  }
                }
              }
            }
          });
        }
      }

      function filterCategories(filter) {
        const categories = document.querySelectorAll('.category-item');
        categories.forEach(category => {
          const status = category.dataset.status;
          const shouldShow = filter === 'all' ||
            (filter === 'over-budget' && status === 'over-budget') ||
            (filter === 'on-track' && (status === 'on-track' || status === 'warning'));

          if (shouldShow) {
            category.style.display = 'block';
            category.removeAttribute('aria-hidden');
          } else {
            category.style.display = 'none';
            category.setAttribute('aria-hidden', 'true');
          }
        });
      }

      function filterTransactions(filter) {
        const transactions = document.querySelectorAll('.transaction-row');
        transactions.forEach(transaction => {
          const type = transaction.dataset.type;
          const shouldShow = filter === 'all' || type === filter;

          if (shouldShow) {
            transaction.style.display = 'table-row';
            transaction.removeAttribute('aria-hidden');
          } else {
            transaction.style.display = 'none';
            transaction.setAttribute('aria-hidden', 'true');
          }
        });
      }

      function sortTable(sortBy) {
        // Simple table sorting implementation
        const table = document.querySelector('.enhanced-table tbody');
        const rows = Array.from(table.querySelectorAll('.transaction-row'));

        rows.sort((a, b) => {
          let aVal, bVal;

          switch (sortBy) {
            case 'date':
              aVal = parseInt(a.querySelector('.date-day').textContent);
              bVal = parseInt(b.querySelector('.date-day').textContent);
              break;
            case 'description':
              aVal = a.querySelector('.description-text').textContent.toLowerCase();
              bVal = b.querySelector('.description-text').textContent.toLowerCase();
              break;
            case 'type':
              aVal = a.dataset.type;
              bVal = b.dataset.type;
              break;
            case 'amount':
              aVal = parseFloat(a.querySelector('.amount-value').textContent.replace(/[$,]/g, ''));
              bVal = parseFloat(b.querySelector('.amount-value').textContent.replace(/[$,]/g, ''));
              break;
            default:
              return 0;
          }

          if (typeof aVal === 'string') {
            return aVal.localeCompare(bVal);
          }
          return aVal - bVal;
        });

        rows.forEach(row => table.appendChild(row));

        // Update ARIA sort indicators
        document.querySelectorAll('.sortable').forEach(header => {
          header.setAttribute('aria-sort', header.dataset.sort === sortBy ? 'ascending' : 'none');
        });
      }

      // Reduced motion support
      if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        document.documentElement.style.setProperty('--transition-smooth', 'none');
        document.documentElement.style.setProperty('--transition-bounce', 'none');
      }

      // Enhanced error handling
      window.addEventListener('error', function(e) {
        console.error('Dashboard error:', e.error);
      });
    </script>
  @endpush

  @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
      rel="stylesheet">
  @endpush

  <style>

  </style>
@endsection
