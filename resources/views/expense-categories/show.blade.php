@extends('layouts.app')

@section('title', $expenseCategory->name . ' Category')

@section('page-header')
  <div style="display: flex; justify-content: space-between; align-items: center;">
    <div>
      <h1 class="page-title">
        <span
          style="color: {{ $expenseCategory->color }}; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));">{{ $expenseCategory->icon }}</span>
        {{ $expenseCategory->name }}
        @if ($expenseCategory->is_essential)
          <span class="essential-badge-header">⭐ Essential</span>
        @endif
      </h1>
      <p class="page-subtitle">Category details and spending analysis</p>
    </div>
    <div class="header-actions">
      <a href="{{ route('transactions.create') }}?category={{ $expenseCategory->id }}" class="action-btn primary">
        <span class="btn-icon">➕</span>
        <span class="btn-text">Add Transaction</span>
      </a>
      <a href="{{ route('expense-categories.edit', $expenseCategory) }}" class="action-btn secondary">
        <span class="btn-icon">✏️</span>
        <span class="btn-text">Edit Category</span>
      </a>
      <a href="{{ route('expense-categories.index') }}" class="action-btn secondary">
        <span class="btn-icon">←</span>
        <span class="btn-text">Back to Categories</span>
      </a>
    </div>
  </div>
@endsection

@section('breadcrumbs')
  <a href="{{ route('expense-categories.index') }}" class="breadcrumb-item">📂 Categories</a>
  <span class="breadcrumb-separator">›</span>
  <span class="breadcrumb-item">{{ $expenseCategory->name }}</span>
@endsection

@section('content')
  <!-- Category Overview Metrics -->
  <div class="metrics-grid">
    <article class="metric-card spending" data-aos="fade-up" data-aos-delay="100"
      style="--metric-color: {{ $expenseCategory->color }};">
      <div class="metric-icon">
        <span class="icon-emoji">{{ $expenseCategory->icon }}</span>
        <div class="icon-bg" style="background: {{ $expenseCategory->color }};"></div>
      </div>
      <div class="metric-content">
        <div class="metric-value" style="color: {{ $expenseCategory->color }};">
          ${{ number_format($monthlySpending, 2) }}
        </div>
        <h3 class="metric-label">This Month</h3>
        @if ($expenseCategory->monthly_budget > 0)
          <div class="metric-trend {{ $expenseCategory->budget_utilization > 100 ? 'negative' : 'positive' }}">
            <span class="trend-icon">{{ $expenseCategory->budget_utilization > 100 ? '⚠️' : '✅' }}</span>
            <span class="trend-text">{{ number_format($expenseCategory->budget_utilization, 1) }}% of budget</span>
          </div>
        @else
          <div class="metric-trend neutral">
            <span class="trend-icon">📊</span>
            <span class="trend-text">No budget set</span>
          </div>
        @endif
      </div>
      <div class="metric-overlay"></div>
    </article>

    <article class="metric-card budget" data-aos="fade-up" data-aos-delay="200">
      <div class="metric-icon">
        <span class="icon-emoji">💰</span>
        <div class="icon-bg"></div>
      </div>
      <div class="metric-content">
        @if ($expenseCategory->monthly_budget > 0)
          <div class="metric-value" style="color: var(--primary-blue);">
            ${{ number_format($expenseCategory->monthly_budget, 2) }}
          </div>
          <h3 class="metric-label">Monthly Budget</h3>
          <div
            class="metric-trend {{ $expenseCategory->monthly_budget - $monthlySpending >= 0 ? 'positive' : 'negative' }}">
            <span class="trend-icon">💵</span>
            <span class="trend-text">${{ number_format(abs($expenseCategory->monthly_budget - $monthlySpending), 2) }}
              {{ $expenseCategory->monthly_budget - $monthlySpending >= 0 ? 'remaining' : 'over' }}</span>
          </div>
        @else
          <div class="metric-value" style="color: var(--text-muted);">No Budget</div>
          <h3 class="metric-label">Monthly Budget</h3>
          <div class="metric-trend neutral">
            <span class="trend-icon">💡</span>
            <span class="trend-text">Consider setting a budget</span>
          </div>
        @endif
      </div>
      <div class="metric-overlay"></div>
    </article>

    <article class="metric-card transactions" data-aos="fade-up" data-aos-delay="300">
      <div class="metric-icon">
        <span class="icon-emoji">📊</span>
        <div class="icon-bg"></div>
      </div>
      <div class="metric-content">
        <div class="metric-value" style="color: var(--accent-gold);">{{ $recentTransactions->count() }}</div>
        <h3 class="metric-label">Recent Transactions</h3>
        <div class="metric-trend neutral">
          <span class="trend-icon">📈</span>
          <span class="trend-text">Last 30 days</span>
        </div>
      </div>
      <div class="metric-overlay"></div>
    </article>

    <article class="metric-card average" data-aos="fade-up" data-aos-delay="400">
      <div class="metric-icon">
        <span class="icon-emoji">📋</span>
        <div class="icon-bg"></div>
      </div>
      <div class="metric-content">
        <div class="metric-value" style="color: var(--info-cyan);">
          @if ($recentTransactions->count() > 0)
            ${{ number_format($recentTransactions->avg('amount'), 2) }}
          @else
            $0.00
          @endif
        </div>
        <h3 class="metric-label">Average Transaction</h3>
        <div class="metric-trend info">
          <span class="trend-icon">💳</span>
          <span class="trend-text">Per transaction</span>
        </div>
      </div>
      <div class="metric-overlay"></div>
    </article>
  </div>

  <!-- Budget Progress Section -->
  @if ($expenseCategory->monthly_budget > 0)
    <section class="content-card" data-aos="fade-up" data-aos-delay="500">
      <div class="content-card-header">
        <h3 class="content-card-title">💰 Budget Progress</h3>
        <div class="budget-overview">
          <span class="budget-spent">${{ number_format($monthlySpending, 2) }}</span>
          <span class="budget-separator">of</span>
          <span class="budget-total">${{ number_format($expenseCategory->monthly_budget, 2) }}</span>
        </div>
      </div>

      <div class="budget-progress-section">
        <div class="progress-container enhanced" style="--category-color: {{ $expenseCategory->color }};">
          <div class="progress-track"></div>
          <div class="progress-bar animated"
            style="width: {{ min($expenseCategory->budget_utilization, 100) }}%;
                  background: linear-gradient(90deg, {{ $expenseCategory->budget_utilization > 100 ? 'var(--danger-red)' : ($expenseCategory->budget_utilization > 80 ? 'var(--warning-amber)' : $expenseCategory->color) }}, {{ $expenseCategory->budget_utilization > 100 ? 'var(--danger-red-light)' : ($expenseCategory->budget_utilization > 80 ? 'var(--warning-amber-light)' : $expenseCategory->color . '80') }});">
            <div class="progress-shine"></div>
          </div>
          @if ($expenseCategory->budget_utilization > 100)
            <div class="progress-overflow" style="width: {{ min($expenseCategory->budget_utilization - 100, 50) }}%;">
            </div>
          @endif
        </div>

        <div class="budget-status-section">
          @if ($expenseCategory->budget_utilization > 100)
            <div class="budget-status over-budget">
              <span class="status-icon">⚠️</span>
              <span class="status-text">Over budget by
                ${{ number_format($monthlySpending - $expenseCategory->monthly_budget, 2) }}</span>
              <div class="status-advice">Consider reducing spending in this category or adjusting your budget.</div>
            </div>
          @elseif($expenseCategory->budget_utilization > 80)
            <div class="budget-status warning">
              <span class="status-icon">⚡</span>
              <span class="status-text">Approaching budget limit
                ({{ number_format($expenseCategory->budget_utilization, 1) }}%)</span>
              <div class="status-advice">You have
                ${{ number_format($expenseCategory->monthly_budget - $monthlySpending, 2) }} left for this month.</div>
            </div>
          @else
            <div class="budget-status on-track">
              <span class="status-icon">✅</span>
              <span class="status-text">Within budget
                ({{ number_format($expenseCategory->budget_utilization, 1) }}%)</span>
              <div class="status-advice">Great job staying within your budget!</div>
            </div>
          @endif
        </div>

        <!-- Budget Analytics -->
        <div class="budget-analytics">
          <div class="analytics-grid">
            <div class="analytics-item">
              <span class="analytics-label">Daily Average</span>
              <span class="analytics-value">${{ number_format($monthlySpending / max(date('j'), 1), 2) }}</span>
            </div>
            <div class="analytics-item">
              <span class="analytics-label">Days Remaining</span>
              <span class="analytics-value">{{ date('t') - date('j') }}</span>
            </div>
            <div class="analytics-item">
              <span class="analytics-label">Projected Total</span>
              <span
                class="analytics-value">${{ number_format(($monthlySpending / max(date('j'), 1)) * date('t'), 2) }}</span>
            </div>
          </div>
        </div>
      </div>
    </section>
  @endif

  <!-- Category Insights -->
  <section class="content-card insights-card" data-aos="fade-up" data-aos-delay="600">
    <div class="content-card-header">
      <h3 class="content-card-title">📈 Category Insights</h3>
      <div class="insights-period">
        <span class="period-label">Last 30 days</span>
      </div>
    </div>

    <div class="insights-grid">
      <div class="insight-item frequency">
        <div class="insight-icon">🔄</div>
        <div class="insight-content">
          <span class="insight-label">Transaction Frequency</span>
          <span class="insight-value">{{ $recentTransactions->count() }} transactions</span>
          <span class="insight-description">
            @if ($recentTransactions->count() > 0)
              {{ round(30 / $recentTransactions->count(), 1) }} days between transactions on average
            @else
              No transactions recorded
            @endif
          </span>
        </div>
      </div>

      <div class="insight-item spending-pattern">
        <div class="insight-icon">📊</div>
        <div class="insight-content">
          <span class="insight-label">Spending Pattern</span>
          <span class="insight-value">
            @if ($recentTransactions->count() > 0)
              {{ $recentTransactions->count() > 10 ? 'Frequent' : ($recentTransactions->count() > 5 ? 'Moderate' : 'Occasional') }}
            @else
              No Data
            @endif
          </span>
          <span class="insight-description">Based on transaction frequency</span>
        </div>
      </div>

      <div class="insight-item category-rank">
        <div class="insight-icon">🏆</div>
        <div class="insight-content">
          <span class="insight-label">Category Priority</span>
          <span class="insight-value">{{ $expenseCategory->is_essential ? 'Essential' : 'Optional' }}</span>
          <span
            class="insight-description">{{ $expenseCategory->is_essential ? 'High priority expense' : 'Discretionary spending' }}</span>
        </div>
      </div>
    </div>
  </section>

  <!-- Recent Transactions Section -->
  <section class="content-card" data-aos="fade-up" data-aos-delay="700">
    <div class="content-card-header">
      <h3 class="content-card-title">💳 Recent Transactions</h3>
      <div class="transaction-actions">
        <a href="{{ route('transactions.create') }}?category={{ $expenseCategory->id }}" class="action-btn primary">
          <span class="btn-icon">➕</span>
          <span class="btn-text">Add Transaction</span>
        </a>
        <a href="{{ route('transactions.index') }}?category={{ $expenseCategory->id }}" class="action-btn secondary">
          <span class="btn-icon">👁️</span>
          <span class="btn-text">View All</span>
        </a>
      </div>
    </div>

    @if ($recentTransactions->count() > 0)
      <div class="transactions-table enhanced">
        <div class="table-container">
          <table class="enhanced-table">
            <thead>
              <tr>
                <th>Date</th>
                <th>Description</th>
                <th>Amount</th>
                <th>Payment Method</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($recentTransactions as $transaction)
                <tr class="transaction-row enhanced">
                  <td class="date-cell">
                    <div class="date-wrapper">
                      <span class="date-day">{{ $transaction->transaction_date->format('d') }}</span>
                      <span class="date-month">{{ $transaction->transaction_date->format('M') }}</span>
                      <span class="date-year">{{ $transaction->transaction_date->format('Y') }}</span>
                    </div>
                  </td>
                  <td class="description-cell">
                    <div class="description-wrapper">
                      <span class="description-text">{{ $transaction->description }}</span>
                      @if ($transaction->notes)
                        <span class="transaction-notes"
                          title="{{ $transaction->notes }}">{{ Str::limit($transaction->notes, 60) }}</span>
                      @endif
                      @if ($transaction->is_recurring)
                        <span class="recurring-badge enhanced">🔄 Recurring</span>
                      @endif
                    </div>
                  </td>
                  <td class="amount-cell">
                    <div class="amount-wrapper">
                      <span class="amount enhanced negative">
                        <span class="amount-sign">-</span>
                        <span class="amount-value">${{ number_format($transaction->amount, 2) }}</span>
                      </span>
                    </div>
                  </td>
                  <td class="payment-cell">
                    <span
                      class="payment-method enhanced">{{ ucfirst(str_replace('_', ' ', $transaction->payment_method ?? 'Unknown')) }}</span>
                  </td>
                  <td class="actions-cell">
                    <div class="action-buttons">
                      <button class="action-btn mini" title="Edit {{ $transaction->description }}"
                        onclick="window.location.href='{{ route('transactions.edit', $transaction) }}'">
                        <span class="action-icon">✏️</span>
                      </button>
                      <button class="action-btn mini view" title="View {{ $transaction->description }}"
                        onclick="showTransactionDetails({{ $transaction->id }})">
                        <span class="action-icon">👁️</span>
                      </button>
                    </div>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        @if ($recentTransactions->count() >= 10)
          <div class="table-footer">
            <p class="showing-results">Showing {{ $recentTransactions->count() }} most recent transactions</p>
            <a href="{{ route('transactions.index') }}?category={{ $expenseCategory->id }}"
              class="action-btn secondary large">
              <span class="btn-icon">📋</span>
              <span class="btn-text">View All Transactions in This Category</span>
            </a>
          </div>
        @endif
      </div>
    @else
      <div class="empty-state enhanced">
        <div class="empty-state-content">
          <div class="empty-state-icon" style="color: {{ $expenseCategory->color }};">{{ $expenseCategory->icon }}
          </div>
          <h4 class="empty-state-title">No Transactions Yet</h4>
          <p class="empty-state-description">Start tracking expenses in this category to see insights and analytics.</p>
          <div class="empty-state-actions">
            <a href="{{ route('transactions.create') }}?category={{ $expenseCategory->id }}"
              class="action-btn primary large">
              <span class="btn-icon">➕</span>
              <span class="btn-text">Add First Transaction</span>
            </a>
            @if (!$expenseCategory->monthly_budget)
              <a href="{{ route('expense-categories.edit', $expenseCategory) }}" class="action-btn secondary">
                <span class="btn-icon">💰</span>
                <span class="btn-text">Set Budget</span>
              </a>
            @endif
          </div>
        </div>
      </div>
    @endif
  </section>

  @push('styles')
    <style>
      /* Header Actions */
      .header-actions {
        display: flex;
        gap: var(--space-3);
        align-items: center;
        flex-wrap: wrap;
      }

      .essential-badge-header {
        background: linear-gradient(135deg, var(--accent-gold) 0%, var(--accent-gold-dark) 100%);
        color: var(--text-inverse);
        padding: var(--space-1) var(--space-3);
        border-radius: var(--space-2);
        font-size: var(--text-sm);
        font-weight: 600;
        box-shadow: var(--shadow-sm);
        margin-left: var(--space-3);
      }

      /* Budget Overview */
      .budget-overview {
        display: flex;
        align-items: center;
        gap: var(--space-2);
        font-size: var(--text-lg);
      }

      .budget-spent {
        font-weight: 700;
        color: var(--text-primary);
      }

      .budget-separator {
        color: var(--text-muted);
      }

      .budget-total {
        color: var(--text-muted);
      }

      /* Budget Progress Section */
      .budget-progress-section {
        display: flex;
        flex-direction: column;
        gap: var(--space-6);
      }

      .progress-container.enhanced {
        position: relative;
        height: 16px;
        background: var(--neutral-200);
        border-radius: var(--space-3);
        overflow: hidden;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
      }

      .progress-track {
        position: absolute;
        inset: 0;
        background: var(--neutral-200);
        border-radius: var(--space-3);
      }

      .progress-bar.animated {
        height: 100%;
        border-radius: var(--space-3);
        position: relative;
        transition: width 1.5s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
      }

      .progress-shine {
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.6), transparent);
        animation: shine 2s infinite;
      }

      .progress-overflow {
        position: absolute;
        top: 0;
        right: 0;
        height: 100%;
        background: linear-gradient(90deg, var(--danger-red), var(--danger-red-dark));
        border-radius: var(--space-3);
        animation: pulse 1s infinite alternate;
      }

      @keyframes shine {
        0% {
          left: -100%;
        }

        100% {
          left: 100%;
        }
      }

      @keyframes pulse {
        0% {
          opacity: 0.7;
        }

        100% {
          opacity: 1;
        }
      }

      /* Budget Status */
      .budget-status-section {
        text-align: center;
      }

      .budget-status {
        display: inline-flex;
        flex-direction: column;
        align-items: center;
        gap: var(--space-2);
        padding: var(--space-4) var(--space-6);
        border-radius: var(--space-4);
        font-weight: 600;
        max-width: 400px;
        margin: 0 auto;
      }

      .budget-status.over-budget {
        background: rgba(220, 38, 38, 0.1);
        color: var(--danger-red);
        border: 1px solid rgba(220, 38, 38, 0.3);
      }

      .budget-status.warning {
        background: rgba(245, 158, 11, 0.1);
        color: var(--warning-amber);
        border: 1px solid rgba(245, 158, 11, 0.3);
      }

      .budget-status.on-track {
        background: rgba(16, 185, 129, 0.1);
        color: var(--success-green);
        border: 1px solid rgba(16, 185, 129, 0.3);
      }

      .status-text {
        font-size: var(--text-lg);
        display: flex;
        align-items: center;
        gap: var(--space-2);
      }

      .status-advice {
        font-size: var(--text-sm);
        font-weight: 400;
        opacity: 0.8;
      }

      /* Budget Analytics */
      .budget-analytics {
        background: var(--bg-secondary);
        border-radius: var(--space-4);
        padding: var(--space-5);
        border: 1px solid var(--border-light);
      }

      .analytics-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: var(--space-4);
      }

      .analytics-item {
        text-align: center;
        padding: var(--space-3);
        background: var(--bg-primary);
        border-radius: var(--space-3);
        border: 1px solid var(--border-light);
      }

      .analytics-label {
        display: block;
        font-size: var(--text-xs);
        color: var(--text-muted);
        font-weight: 500;
        margin-bottom: var(--space-1);
      }

      .analytics-value {
        display: block;
        font-size: var(--text-lg);
        font-weight: 700;
        color: var(--text-primary);
      }

      /* Insights Card */
      .insights-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.8) 100%);
      }

      .insights-period {
        color: var(--text-muted);
        font-size: var(--text-sm);
        font-weight: 500;
      }

      .insights-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: var(--space-6);
        margin-top: var(--space-6);
      }

      .insight-item {
        display: flex;
        align-items: flex-start;
        gap: var(--space-4);
        padding: var(--space-5);
        background: var(--bg-primary);
        border-radius: var(--space-4);
        border: 1px solid var(--border-light);
        transition: var(--transition-normal);
      }

      .insight-item:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
      }

      .insight-icon {
        font-size: var(--text-2xl);
        width: 50px;
        height: 50px;
        background: var(--bg-secondary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px solid var(--border-light);
        flex-shrink: 0;
      }

      .insight-content {
        display: flex;
        flex-direction: column;
        gap: var(--space-1);
        flex: 1;
      }

      .insight-label {
        font-size: var(--text-sm);
        color: var(--text-muted);
        font-weight: 500;
      }

      .insight-value {
        font-size: var(--text-lg);
        font-weight: 700;
        color: var(--text-primary);
      }

      .insight-description {
        font-size: var(--text-sm);
        color: var(--text-muted);
        line-height: 1.4;
      }

      /* Transaction Actions */
      .transaction-actions {
        display: flex;
        gap: var(--space-3);
        align-items: center;
        flex-wrap: wrap;
      }

      /* Enhanced Table */
      .transactions-table.enhanced {
        margin-top: var(--space-6);
      }

      .table-container {
        overflow-x: auto;
        border-radius: var(--space-3);
        border: 1px solid var(--border-light);
        background: var(--bg-primary);
      }

      .enhanced-table {
        width: 100%;
        border-collapse: collapse;
      }

      .enhanced-table th {
        background: var(--bg-secondary);
        padding: var(--space-4);
        text-align: left;
        font-weight: 600;
        color: var(--text-primary);
        border-bottom: 1px solid var(--border-light);
        font-size: var(--text-sm);
      }

      .enhanced-table td {
        padding: var(--space-4);
        border-bottom: 1px solid var(--border-light);
      }

      .transaction-row.enhanced:hover {
        background: var(--bg-secondary);
      }

      .date-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: var(--space-1);
        padding: var(--space-2);
        background: var(--bg-secondary);
        border-radius: var(--space-2);
        min-width: 50px;
      }

      .date-day {
        font-size: var(--text-lg);
        font-weight: 700;
        color: var(--text-primary);
      }

      .date-month {
        font-size: var(--text-xs);
        color: var(--text-muted);
        font-weight: 500;
      }

      .date-year {
        font-size: var(--text-xs);
        color: var(--text-muted);
      }

      .description-wrapper {
        display: flex;
        flex-direction: column;
        gap: var(--space-1);
      }

      .description-text {
        font-weight: 600;
        color: var(--text-primary);
      }

      .transaction-notes {
        font-size: var(--text-sm);
        color: var(--text-muted);
        font-style: italic;
      }

      .recurring-badge.enhanced {
        background: linear-gradient(135deg, var(--info-cyan) 0%, var(--info-cyan-dark) 100%);
        color: var(--text-inverse);
        padding: var(--space-1) var(--space-2);
        border-radius: var(--space-1);
        font-size: var(--text-xs);
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: var(--space-1);
        box-shadow: var(--shadow-sm);
      }

      .amount.enhanced.negative {
        color: var(--danger-red);
        font-weight: 700;
        font-size: var(--text-lg);
      }

      .payment-method.enhanced {
        background: var(--bg-secondary);
        padding: var(--space-2) var(--space-3);
        border-radius: var(--space-2);
        font-size: var(--text-sm);
        font-weight: 500;
        color: var(--text-primary);
        border: 1px solid var(--border-light);
      }

      .action-buttons {
        display: flex;
        gap: var(--space-2);
      }

      /* Table Footer */
      .table-footer {
        padding: var(--space-5);
        background: var(--bg-secondary);
        border-top: 1px solid var(--border-light);
        text-align: center;
        border-radius: 0 0 var(--space-3) var(--space-3);
      }

      .showing-results {
        color: var(--text-muted);
        font-size: var(--text-sm);
        margin-bottom: var(--space-4);
      }

      /* Enhanced Empty State */
      .empty-state.enhanced {
        text-align: center;
        padding: var(--space-16) var(--space-8);
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);
        border-radius: var(--space-6);
        border: 2px dashed var(--border-light);
      }

      .empty-state-content {
        max-width: 400px;
        margin: 0 auto;
      }

      .empty-state-icon {
        font-size: var(--text-6xl);
        margin-bottom: var(--space-6);
        opacity: 0.8;
        filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
      }

      .empty-state-title {
        font-size: var(--text-2xl);
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: var(--space-4);
      }

      .empty-state-description {
        color: var(--text-muted);
        font-size: var(--text-lg);
        margin-bottom: var(--space-8);
        line-height: 1.6;
      }

      .empty-state-actions {
        display: flex;
        gap: var(--space-4);
        justify-content: center;
        flex-wrap: wrap;
      }

      /* Responsive Design */
      @media (max-width: 768px) {
        .header-actions {
          width: 100%;
          justify-content: center;
          margin-top: var(--space-4);
        }

        .budget-overview {
          flex-direction: column;
          gap: var(--space-1);
          text-align: center;
        }

        .analytics-grid {
          grid-template-columns: 1fr 1fr;
        }

        .insights-grid {
          grid-template-columns: 1fr;
        }

        .transaction-actions {
          flex-direction: column;
          width: 100%;
        }

        .action-btn {
          width: 100%;
          justify-content: center;
        }

        .enhanced-table {
          font-size: var(--text-sm);
        }

        .enhanced-table th,
        .enhanced-table td {
          padding: var(--space-3);
        }

        .empty-state-actions {
          flex-direction: column;
          align-items: stretch;
        }
      }

      @media (max-width: 640px) {
        .analytics-grid {
          grid-template-columns: 1fr;
        }

        .date-wrapper {
          min-width: 40px;
        }

        .date-day {
          font-size: var(--text-base);
        }
      }
    </style>
  @endpush

  @push('scripts')
    <script>
      // Transaction details modal functionality
      function showTransactionDetails(transactionId) {
        // This would open a modal or navigate to transaction details
        // For now, we'll just show an alert
        alert(`Transaction details for ID: ${transactionId}`);
      }

      // Initialize tooltips and animations
      document.addEventListener('DOMContentLoaded', function() {
        // Add hover effects to insight items
        const insightItems = document.querySelectorAll('.insight-item');
        insightItems.forEach(item => {
          item.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-4px)';
          });

          item.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
          });
        });

        // Animate progress bar on load
        const progressBar = document.querySelector('.progress-bar.animated');
        if (progressBar) {
          setTimeout(() => {
            progressBar.style.transition = 'width 2s cubic-bezier(0.4, 0, 0.2, 1)';
          }, 500);
        }

        // Add loading states for actions
        const actionButtons = document.querySelectorAll('.action-btn');
        actionButtons.forEach(button => {
          button.addEventListener('click', function(e) {
            if (this.href || this.type === 'submit') {
              this.style.opacity = '0.7';
              this.style.pointerEvents = 'none';

              // Reset after 2 seconds if still on page
              setTimeout(() => {
                this.style.opacity = '1';
                this.style.pointerEvents = 'auto';
              }, 2000);
            }
          });
        });
      });
    </script>
  @endpush
@endsection
