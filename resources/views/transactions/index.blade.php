@extends('layouts.app')

@section('title', 'Transactions - Financial Management')
@section('meta-description', 'View and manage all your financial transactions including income, expenses, and savings')

@section('page-header')
  <div class="page-header-content">
    <div class="header-title-section">
      <h1 class="page-title">
        <span class="title-icon">💳</span>
        Transaction History
      </h1>
      <p class="page-subtitle">Track and manage all your financial activities</p>
    </div>
    <div class="header-actions">
      <a href="{{ route('transactions.create') }}" class="action-btn primary">
        <span class="btn-icon">➕</span>
        <span class="btn-text">Add Transaction</span>
      </a>
    </div>
  </div>
@endsection

@section('breadcrumbs')
  <span class="breadcrumb-item">💳 Transactions</span>
@endsection

@section('content')
  <!-- Enhanced Filters Section -->
  <section class="filters-section enhanced" data-aos="fade-up">
    <div class="section-wrapper">
      <header class="section-header">
        <div class="header-left">
          <h2 class="section-title">
            <span class="title-icon">
              <span class="icon-emoji">🔍</span>
              <div class="icon-glow"></div>
            </span>
            <span class="title-text">Filter & Search</span>
          </h2>
          <p class="section-subtitle">Refine your transaction view</p>
        </div>
      </header>

      <form method="GET" action="{{ route('transactions.index') }}" class="enhanced-filters">
        <div class="filters-grid">
          <div class="filter-group">
            <label for="type" class="filter-label">
              <span class="label-icon">🏷️</span>
              Transaction Type
            </label>
            <select id="type" name="type" class="filter-input enhanced">
              <option value="">All Types</option>
              <option value="income" {{ request('type') === 'income' ? 'selected' : '' }}>💰 Income</option>
              <option value="expense" {{ request('type') === 'expense' ? 'selected' : '' }}>💸 Expense</option>
              <option value="savings" {{ request('type') === 'savings' ? 'selected' : '' }}>🏦 Savings</option>
              <option value="investment" {{ request('type') === 'investment' ? 'selected' : '' }}>📈 Investment</option>
            </select>
          </div>

          <div class="filter-group">
            <label for="category" class="filter-label">
              <span class="label-icon">📂</span>
              Category
            </label>
            <select id="category" name="category" class="filter-input enhanced">
              <option value="">All Categories</option>
              @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                  {{ $category->icon }} {{ $category->name }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="filter-group">
            <label for="month" class="filter-label">
              <span class="label-icon">📅</span>
              Month
            </label>
            <select id="month" name="month" class="filter-input enhanced">
              <option value="">All Months</option>
              @for ($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" {{ request('month') == $i ? 'selected' : '' }}>
                  {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                </option>
              @endfor
            </select>
          </div>

          <div class="filter-group">
            <label class="filter-label">&nbsp;</label>
            <button type="submit" class="action-btn primary filter-btn">
              <span class="btn-icon">🔍</span>
              <span class="btn-text">Apply Filters</span>
            </button>
          </div>
        </div>
      </form>
    </div>
  </section>

  <!-- Enhanced Summary Cards -->
  <section class="summary-section" data-aos="fade-up" data-aos-delay="200">
    <div class="metrics-grid summary-grid">
      <article class="metric-card summary-card income" data-aos="fade-up" data-aos-delay="300">
        <div class="metric-icon">
          <span class="icon-emoji">💰</span>
          <div class="icon-bg"></div>
        </div>
        <div class="metric-content">
          <div class="metric-value">${{ number_format($summary['income'], 2) }}</div>
          <h3 class="metric-label">Total Income</h3>
          <div class="metric-trend positive">
            <span class="trend-icon">📈</span>
            <span class="trend-text">This period</span>
          </div>
        </div>
      </article>

      <article class="metric-card summary-card expense" data-aos="fade-up" data-aos-delay="400">
        <div class="metric-icon">
          <span class="icon-emoji">💸</span>
          <div class="icon-bg"></div>
        </div>
        <div class="metric-content">
          <div class="metric-value">${{ number_format($summary['expenses'], 2) }}</div>
          <h3 class="metric-label">Total Expenses</h3>
          <div class="metric-trend negative">
            <span class="trend-icon">📉</span>
            <span class="trend-text">This period</span>
          </div>
        </div>
      </article>

      <article class="metric-card summary-card savings" data-aos="fade-up" data-aos-delay="500">
        <div class="metric-icon">
          <span class="icon-emoji">🏦</span>
          <div class="icon-bg"></div>
        </div>
        <div class="metric-content">
          <div class="metric-value">${{ number_format($summary['savings'], 2) }}</div>
          <h3 class="metric-label">Total Savings</h3>
          <div class="metric-trend positive">
            <span class="trend-icon">💎</span>
            <span class="trend-text">This period</span>
          </div>
        </div>
      </article>

      <article class="metric-card summary-card net-worth" data-aos="fade-up" data-aos-delay="600">
        <div class="metric-icon">
          <span class="icon-emoji">📊</span>
          <div class="icon-bg"></div>
        </div>
        <div class="metric-content">
          <div class="metric-value" style="color: {{ $summary['net'] >= 0 ? '#10b981' : '#ef4444' }};">
            ${{ number_format($summary['net'], 2) }}
          </div>
          <h3 class="metric-label">Net Amount</h3>
          <div class="metric-trend {{ $summary['net'] >= 0 ? 'positive' : 'negative' }}">
            <span class="trend-icon">{{ $summary['net'] >= 0 ? '✅' : '⚠️' }}</span>
            <span class="trend-text">{{ $summary['net'] >= 0 ? 'Positive' : 'Negative' }} flow</span>
          </div>
        </div>
      </article>
    </div>
  </section>

  <!-- Enhanced Transactions Table -->
  <section class="transactions-section enhanced" data-aos="fade-up" data-aos-delay="700">
    <div class="section-wrapper">
      <header class="section-header transactions-header">
        <div class="header-left">
          <h2 class="section-title">
            <span class="title-icon transactions-icon">
              <span class="icon-emoji">📋</span>
              <div class="icon-glow"></div>
            </span>
            <span class="title-text">Transaction Details</span>
          </h2>
          <p class="section-subtitle">Complete history of all financial activities</p>
        </div>
        <div class="transaction-actions">
          <a href="{{ route('transactions.create') }}" class="action-btn primary">
            <span class="btn-icon">➕</span>
            <span class="btn-text">Add New</span>
          </a>
        </div>
      </header>

      @if ($transactions->count() > 0)
        <div class="transactions-table enhanced">
          <div class="table-header">
            <div class="table-info">
              <span class="transaction-count">{{ $transactions->total() }}</span>
              <span class="transaction-label">Total Transactions</span>
            </div>
            <div class="table-filters" role="tablist">
              <button class="filter-btn active" data-filter="all" role="tab">All</button>
              <button class="filter-btn" data-filter="income" role="tab">Income</button>
              <button class="filter-btn" data-filter="expense" role="tab">Expenses</button>
              <button class="filter-btn" data-filter="savings" role="tab">Savings</button>
            </div>
          </div>

          <div class="table-container">
            <table class="enhanced-table" role="table">
              <thead>
                <tr>
                  <th class="sortable" data-sort="date" role="columnheader">
                    <span>Date</span>
                    <span class="sort-icon">⇅</span>
                  </th>
                  <th class="sortable" data-sort="description" role="columnheader">
                    <span>Description</span>
                    <span class="sort-icon">⇅</span>
                  </th>
                  <th role="columnheader">Category</th>
                  <th class="sortable" data-sort="type" role="columnheader">
                    <span>Type</span>
                    <span class="sort-icon">⇅</span>
                  </th>
                  <th class="sortable" data-sort="amount" role="columnheader">
                    <span>Amount</span>
                    <span class="sort-icon">⇅</span>
                  </th>
                  <th role="columnheader">Payment Method</th>
                  <th role="columnheader">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($transactions as $index => $transaction)
                  <tr class="transaction-row enhanced" data-type="{{ $transaction->type }}" data-aos="fade-up"
                    data-aos-delay="{{ 800 + $index * 50 }}">
                    <td class="date-cell">
                      <div class="date-wrapper">
                        <span class="date-day">{{ $transaction->transaction_date->format('j') }}</span>
                        <span class="date-month">{{ $transaction->transaction_date->format('M') }}</span>
                      </div>
                    </td>
                    <td class="description-cell">
                      <div class="description-wrapper">
                        <span class="description-text">{{ $transaction->description }}</span>
                        @if ($transaction->notes)
                          <span class="description-note">{{ Str::limit($transaction->notes, 50) }}</span>
                        @endif
                      </div>
                    </td>
                    <td class="category-cell">
                      @if ($transaction->expenseCategory)
                        <div class="category-tag enhanced">
                          <span class="category-icon">{{ $transaction->expenseCategory->icon }}</span>
                          <span class="category-name">{{ $transaction->expenseCategory->name }}</span>
                        </div>
                      @else
                        <span class="no-category">—</span>
                      @endif
                    </td>
                    <td class="type-cell">
                      <span class="transaction-type enhanced transaction-type-{{ $transaction->type }}">
                        <span class="type-icon">
                          @switch($transaction->type)
                            @case('income')
                              💰
                            @break

                            @case('expense')
                              💸
                            @break

                            @case('savings')
                              🏦
                            @break

                            @case('investment')
                              📈
                            @break

                            @default
                              💳
                          @endswitch
                        </span>
                        <span class="type-text">{{ ucfirst($transaction->type) }}</span>
                      </span>
                      @if ($transaction->is_recurring)
                        <div class="recurring-indicator" title="Recurring {{ $transaction->recurring_frequency }}">
                          <span class="recurring-icon">🔄</span>
                          <span class="recurring-text">{{ ucfirst($transaction->recurring_frequency) }}</span>
                        </div>
                      @endif
                    </td>
                    <td class="amount-cell">
                      <div class="amount-wrapper">
                        <span class="amount enhanced {{ $transaction->type === 'expense' ? 'negative' : 'positive' }}">
                          <span class="amount-sign">{{ $transaction->type === 'expense' ? '-' : '+' }}</span>
                          <span class="amount-value">${{ number_format($transaction->amount, 2) }}</span>
                        </span>
                      </div>
                    </td>
                    <td class="payment-cell">
                      @if ($transaction->payment_method)
                        <div class="payment-method">
                          <span class="payment-icon">
                            @switch($transaction->payment_method)
                              @case('cash')
                                💵
                              @break

                              @case('credit_card')
                                💳
                              @break

                              @case('debit_card')
                                🏧
                              @break

                              @case('bank_transfer')
                                🏦
                              @break

                              @case('mobile_payment')
                                📱
                              @break

                              @case('check')
                                📝
                              @break

                              @default
                                💳
                            @endswitch
                          </span>
                          <span
                            class="payment-text">{{ ucwords(str_replace('_', ' ', $transaction->payment_method)) }}</span>
                        </div>
                      @else
                        <span class="no-payment">—</span>
                      @endif
                    </td>
                    <td class="actions-cell">
                      <div class="action-buttons">
                        <a href="{{ route('transactions.edit', $transaction) }}" class="action-btn mini"
                          title="Edit {{ $transaction->description }}">
                          <span class="action-icon">✏️</span>
                        </a>
                        <form action="{{ route('transactions.destroy', $transaction) }}" method="POST"
                          style="display: inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="action-btn mini delete"
                            title="Delete {{ $transaction->description }}"
                            onclick="return confirm('Are you sure you want to delete this transaction?')">
                            <span class="action-icon">🗑️</span>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <!-- Enhanced Pagination -->
          @if ($transactions->hasPages())
            <div class="pagination-wrapper enhanced" data-aos="fade-up" data-aos-delay="1000">
              <div class="pagination-container premium">
                <!-- Pagination Summary -->
                <div class="pagination-summary">
                  <div class="pagination-info">
                    <div class="info-main">
                      <span class="info-icon">📄</span>
                      <span class="info-text">
                        Showing <strong>{{ $transactions->firstItem() }}</strong> to
                        <strong>{{ $transactions->lastItem() }}</strong> of
                        <strong>{{ $transactions->total() }}</strong> transactions
                      </span>
                    </div>
                    <div class="info-meta">
                      <span class="page-indicator">
                        Page {{ $transactions->currentPage() }} of {{ $transactions->lastPage() }}
                      </span>
                    </div>
                  </div>

                  <!-- Items Per Page Selector -->
                  <div class="pagination-controls">
                    <div class="per-page-selector">
                      <label for="per-page" class="per-page-label">
                        <span class="label-icon">📋</span>
                        <span class="label-text">Show:</span>
                      </label>
                      <select id="per-page" class="per-page-select enhanced" onchange="changePerPage(this.value)">
                        <option value="10" {{ request('per_page', 15) == 10 ? 'selected' : '' }}>10</option>
                        <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                        <option value="25" {{ request('per_page', 15) == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ request('per_page', 15) == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ request('per_page', 15) == 100 ? 'selected' : '' }}>100</option>
                      </select>
                    </div>
                  </div>
                </div>

                <!-- Enhanced Pagination Navigation -->
                <nav class="pagination-nav" role="navigation" aria-label="Transaction pagination">
                  <div class="pagination-links enhanced">
                    <!-- First Page -->
                    @if ($transactions->currentPage() > 1)
                      <a href="{{ $transactions->url(1) }}" class="pagination-link first-page"
                        title="Go to first page" aria-label="Go to first page">
                        <span class="link-icon">⏮️</span>
                        <span class="link-text">First</span>
                      </a>
                    @endif

                    <!-- Previous Page -->
                    @if ($transactions->onFirstPage())
                      <span class="pagination-link disabled" aria-disabled="true">
                        <span class="link-icon">⬅️</span>
                        <span class="link-text">Previous</span>
                      </span>
                    @else
                      <a href="{{ $transactions->previousPageUrl() }}" class="pagination-link previous-page"
                        title="Go to previous page" aria-label="Go to previous page">
                        <span class="link-icon">⬅️</span>
                        <span class="link-text">Previous</span>
                      </a>
                    @endif

                    <!-- Page Numbers with Smart Range -->
                    @php
                      $start = max(1, $transactions->currentPage() - 2);
                      $end = min($transactions->lastPage(), $transactions->currentPage() + 2);

                      // Adjust range to always show 5 pages when possible
                      if ($end - $start < 4) {
                          if ($start == 1) {
                              $end = min($transactions->lastPage(), $start + 4);
                          } else {
                              $start = max(1, $end - 4);
                          }
                      }
                    @endphp

                    <!-- Show first page and ellipsis if needed -->
                    @if ($start > 1)
                      <a href="{{ $transactions->url(1) }}" class="pagination-link page-number">1</a>
                      @if ($start > 2)
                        <span class="pagination-ellipsis" aria-hidden="true">
                          <span class="ellipsis-dots">⋯</span>
                        </span>
                      @endif
                    @endif

                    <!-- Page Number Range -->
                    @for ($page = $start; $page <= $end; $page++)
                      @if ($page == $transactions->currentPage())
                        <span class="pagination-link active current-page" aria-current="page"
                          aria-label="Current page, page {{ $page }}">
                          <span class="page-number">{{ $page }}</span>
                          <div class="active-indicator"></div>
                        </span>
                      @else
                        <a href="{{ $transactions->url($page) }}" class="pagination-link page-number"
                          title="Go to page {{ $page }}" aria-label="Go to page {{ $page }}">
                          {{ $page }}
                        </a>
                      @endif
                    @endfor

                    <!-- Show last page and ellipsis if needed -->
                    @if ($end < $transactions->lastPage())
                      @if ($end < $transactions->lastPage() - 1)
                        <span class="pagination-ellipsis" aria-hidden="true">
                          <span class="ellipsis-dots">⋯</span>
                        </span>
                      @endif
                      <a href="{{ $transactions->url($transactions->lastPage()) }}"
                        class="pagination-link page-number">
                        {{ $transactions->lastPage() }}
                      </a>
                    @endif

                    <!-- Next Page -->
                    @if ($transactions->hasMorePages())
                      <a href="{{ $transactions->nextPageUrl() }}" class="pagination-link next-page"
                        title="Go to next page" aria-label="Go to next page">
                        <span class="link-text">Next</span>
                        <span class="link-icon">➡️</span>
                      </a>
                    @else
                      <span class="pagination-link disabled" aria-disabled="true">
                        <span class="link-text">Next</span>
                        <span class="link-icon">➡️</span>
                      </span>
                    @endif

                    <!-- Last Page -->
                    @if ($transactions->currentPage() < $transactions->lastPage())
                      <a href="{{ $transactions->url($transactions->lastPage()) }}" class="pagination-link last-page"
                        title="Go to last page" aria-label="Go to last page">
                        <span class="link-text">Last</span>
                        <span class="link-icon">⏭️</span>
                      </a>
                    @endif
                  </div>

                  <!-- Quick Jump -->
                  @if ($transactions->lastPage() > 10)
                    <div class="pagination-quick-jump">
                      <div class="quick-jump-wrapper">
                        <label for="quick-jump" class="quick-jump-label">
                          <span class="label-icon">🎯</span>
                          <span class="label-text">Jump to page:</span>
                        </label>
                        <div class="quick-jump-input-group">
                          <input type="number" id="quick-jump" class="quick-jump-input" min="1"
                            max="{{ $transactions->lastPage() }}" value="{{ $transactions->currentPage() }}"
                            aria-label="Enter page number">
                          <button type="button" class="quick-jump-btn" onclick="quickJumpToPage()"
                            title="Go to entered page">
                            <span class="btn-icon">🚀</span>
                          </button>
                        </div>
                      </div>
                    </div>
                  @endif
                </nav>

                <!-- Pagination Progress Bar -->
                <div class="pagination-progress">
                  <div class="progress-track" role="progressbar" aria-valuenow="{{ $transactions->currentPage() }}"
                    aria-valuemin="1" aria-valuemax="{{ $transactions->lastPage() }}"
                    aria-label="Pagination progress">
                    <div class="progress-fill"
                      style="width: {{ ($transactions->currentPage() / $transactions->lastPage()) * 100 }}%;">
                      <div class="progress-glow"></div>
                    </div>
                  </div>
                  <div class="progress-text">
                    {{ round(($transactions->currentPage() / $transactions->lastPage()) * 100, 1) }}% of pages viewed
                  </div>
                </div>
              </div>
            </div>
          @endif
        </div>
      @else
        <div class="empty-state enhanced">
          <div class="empty-content">
            <div class="empty-icon">💳</div>
            <h3 class="empty-title">No Transactions Found</h3>
            <p class="empty-description">Start tracking your financial activity by adding your first transaction.</p>
            <div class="empty-actions">
              <a href="{{ route('transactions.create') }}" class="action-btn primary large">
                <span class="btn-icon">➕</span>
                <span class="btn-text">Add Your First Transaction</span>
              </a>
            </div>
          </div>
        </div>
      @endif
    </div>
  </section>

  @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  @endpush

  @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Initialize AOS
        AOS.init({
          duration: 800,
          easing: 'ease-out-cubic',
          once: true,
          disable: window.matchMedia('(prefers-reduced-motion: reduce)').matches
        });

        //  table filtering
        const filterBtns = document.querySelectorAll('.table-filters .filter-btn');
        filterBtns.forEach(btn => {
          btn.addEventListener('click', function() {
            filterBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            filterTransactions(this.dataset.filter);
          });
        });

        //  table sorting
        const sortableHeaders = document.querySelectorAll('.sortable');
        sortableHeaders.forEach(header => {
          header.addEventListener('click', function() {
            sortTable(this.dataset.sort);
          });
        });

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

          // Update sort indicators
          document.querySelectorAll('.sortable').forEach(header => {
            header.setAttribute('aria-sort', header.dataset.sort === sortBy ? 'ascending' : 'none');
          });
        }

        // Enhanced pagination functionality
        setupPaginationEnhancements();
      });

      function setupPaginationEnhancements() {
        // Keyboard navigation for pagination
        document.addEventListener('keydown', function(e) {
          if (e.target.closest('.pagination-nav')) {
            switch (e.key) {
              case 'ArrowLeft':
                e.preventDefault();
                const prevLink = document.querySelector('.pagination-link.previous-page:not(.disabled)');
                if (prevLink) prevLink.click();
                break;
              case 'ArrowRight':
                e.preventDefault();
                const nextLink = document.querySelector('.pagination-link.next-page:not(.disabled)');
                if (nextLink) nextLink.click();
                break;
              case 'Home':
                e.preventDefault();
                const firstLink = document.querySelector('.pagination-link.first-page');
                if (firstLink) firstLink.click();
                break;
              case 'End':
                e.preventDefault();
                const lastLink = document.querySelector('.pagination-link.last-page');
                if (lastLink) lastLink.click();
                break;
            }
          }
        });

        // Enhanced hover effects for pagination links
        const paginationLinks = document.querySelectorAll('.pagination-link:not(.disabled):not(.active)');
        paginationLinks.forEach(link => {
          link.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px) scale(1.05)';
          });

          link.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
          });
        });

        // Loading state for pagination
        const allPaginationLinks = document.querySelectorAll('.pagination-link:not(.disabled):not(.active)');
        allPaginationLinks.forEach(link => {
          link.addEventListener('click', function(e) {
            if (!this.href) return;

            // Add loading state
            this.style.opacity = '0.6';
            this.style.pointerEvents = 'none';

            // Add loading spinner
            const originalContent = this.innerHTML;
            this.innerHTML = '<span class="loading-spinner mini"></span>';

            // Restore content if page doesn't change (for debugging)
            setTimeout(() => {
              this.innerHTML = originalContent;
              this.style.opacity = '1';
              this.style.pointerEvents = 'auto';
            }, 5000);
          });
        });
      }

      function changePerPage(value) {
        const url = new URL(window.location);
        url.searchParams.set('per_page', value);
        url.searchParams.delete('page'); // Reset to first page

        // Add loading state to the select
        const select = document.getElementById('per-page');
        select.style.opacity = '0.6';
        select.disabled = true;

        window.location.href = url.toString();
      }

      function quickJumpToPage() {
        const input = document.getElementById('quick-jump');
        const page = parseInt(input.value);
        const maxPage = {{ $transactions->lastPage() }};

        if (page >= 1 && page <= maxPage && page !== {{ $transactions->currentPage() }}) {
          const url = new URL(window.location);
          url.searchParams.set('page', page);

          // Add loading state
          const btn = document.querySelector('.quick-jump-btn');
          btn.style.opacity = '0.6';
          btn.disabled = true;
          input.disabled = true;

          window.location.href = url.toString();
        } else {
          // Invalid page number - shake animation
          input.style.animation = 'shake 0.5s ease-in-out';
          setTimeout(() => {
            input.style.animation = '';
          }, 500);
        }
      }

      // Enter key support for quick jump
      document.addEventListener('DOMContentLoaded', function() {
        const quickJumpInput = document.getElementById('quick-jump');
        if (quickJumpInput) {
          quickJumpInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
              e.preventDefault();
              quickJumpToPage();
            }
          });
        }
      });
    </script>
  @endpush

  <style>
    /* Enhanced styling specific to transactions index */
    .filters-section {
      background: linear-gradient(135deg, rgba(59, 130, 246, 0.03) 0%, rgba(16, 185, 129, 0.03) 100%);
      border-radius: 32px;
      padding: var(--space-xl);
      margin-bottom: var(--space-xl);
      border: 1px solid rgba(59, 130, 246, 0.15);
      box-shadow: var(--shadow-light);
    }

    .enhanced-filters {
      margin-top: var(--space-lg);
    }

    .filters-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: var(--space-lg);
      align-items: end;
    }

    .filter-group {
      display: flex;
      flex-direction: column;
      gap: var(--space-sm);
    }

    .filter-label {
      display: flex;
      align-items: center;
      gap: var(--space-sm);
      font-size: var(--font-size-sm);
      font-weight: 600;
      color: var(--text-primary);
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }

    .label-icon {
      font-size: var(--font-size-base);
    }

    .filter-input.enhanced {
      padding: var(--space-3) var(--space-4);
      border: 2px solid var(--border-light);
      border-radius: var(--space-3);
      background: var(--glass-bg);
      backdrop-filter: var(--blur-backdrop);
      color: var(--text-primary);
      font-weight: 500;
      transition: var(--transition-smooth);
    }

    .filter-input.enhanced:focus {
      border-color: var(--primary-blue);
      box-shadow: var(--shadow-focus);
      background: rgba(255, 255, 255, 0.9);
    }

    .summary-grid {
      margin-bottom: var(--space-xl);
    }

    .summary-card {
      background: var(--glass-bg-strong);
      backdrop-filter: var(--blur-backdrop);
    }

    .description-note {
      display: block;
      font-size: var(--font-size-xs);
      color: var(--text-muted);
      margin-top: var(--space-1);
      font-style: italic;
    }

    .recurring-indicator {
      display: flex;
      align-items: center;
      gap: var(--space-1);
      margin-top: var(--space-1);
      padding: var(--space-1) var(--space-2);
      background: rgba(59, 130, 246, 0.1);
      border-radius: var(--space-2);
      font-size: var(--font-size-xs);
      color: var(--primary-blue);
      font-weight: 500;
    }

    .payment-method {
      display: flex;
      align-items: center;
      gap: var(--space-2);
      font-size: var(--font-size-sm);
      font-weight: 500;
    }

    .no-category,
    .no-payment {
      color: var(--text-muted);
      font-style: italic;
    }

    .pagination-wrapper.enhanced {
      margin-top: var(--space-xl);
      background: var(--glass-bg-strong);
      backdrop-filter: var(--blur-backdrop);
      border-radius: var(--space-6);
      border: 1px solid var(--glass-border);
      box-shadow: var(--shadow-lg);
      overflow: hidden;
    }

    .pagination-container.premium {
      padding: var(--space-8);
      display: flex;
      flex-direction: column;
      gap: var(--space-6);
    }

    /* Pagination Summary */
    .pagination-summary {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      gap: var(--space-6);
      padding-bottom: var(--space-6);
      border-bottom: 2px solid var(--border-light);
    }

    .pagination-info {
      flex: 1;
    }

    .info-main {
      display: flex;
      align-items: center;
      gap: var(--space-sm);
      margin-bottom: var(--space-2);
    }

    .info-icon {
      font-size: var(--font-size-lg);
      opacity: 0.8;
    }

    .info-text {
      font-size: var(--font-size-base);
      color: var(--text-primary);
      font-weight: 500;
    }

    .info-text strong {
      font-weight: 700;
      color: var(--primary-blue);
    }

    .info-meta {
      margin-left: var(--space-8);
    }

    .page-indicator {
      font-size: var(--font-size-sm);
      color: var(--text-muted);
      font-weight: 600;
      background: var(--glass-bg);
      padding: var(--space-1) var(--space-3);
      border-radius: var(--space-2);
      border: 1px solid var(--border-light);
    }

    /* Per Page Selector */
    .pagination-controls {
      display: flex;
      align-items: center;
      gap: var(--space-4);
    }

    .per-page-selector {
      display: flex;
      align-items: center;
      gap: var(--space-2);
    }

    .per-page-label {
      display: flex;
      align-items: center;
      gap: var(--space-1);
      font-size: var(--font-size-sm);
      font-weight: 600;
      color: var(--text-primary);
      white-space: nowrap;
    }

    .per-page-select.enhanced {
      padding: var(--space-2) var(--space-3);
      border: 2px solid var(--border-light);
      border-radius: var(--space-2);
      background: var(--glass-bg);
      backdrop-filter: var(--blur-backdrop);
      color: var(--text-primary);
      font-weight: 600;
      font-size: var(--font-size-sm);
      cursor: pointer;
      transition: var(--transition-smooth);
      min-width: 80px;
    }

    .per-page-select.enhanced:focus {
      border-color: var(--primary-blue);
      box-shadow: var(--shadow-focus);
      outline: none;
    }

    .per-page-select.enhanced:hover {
      border-color: var(--primary-blue-light);
      background: var(--glass-bg-medium);
    }

    /* Pagination Navigation */
    .pagination-nav {
      display: flex;
      flex-direction: column;
      gap: var(--space-4);
    }

    .pagination-links.enhanced {
      display: flex;
      justify-content: center;
      align-items: center;
      gap: var(--space-2);
      flex-wrap: wrap;
    }

    .pagination-link {
      display: flex;
      align-items: center;
      gap: var(--space-1);
      padding: var(--space-3) var(--space-4);
      border: 2px solid var(--border-light);
      border-radius: var(--space-3);
      background: var(--glass-bg);
      backdrop-filter: var(--blur-backdrop);
      color: var(--text-primary);
      text-decoration: none;
      font-weight: 600;
      font-size: var(--font-size-sm);
      transition: var(--transition-spring);
      position: relative;
      overflow: hidden;
      min-height: 44px;
      min-width: 44px;
      justify-content: center;
    }

    .pagination-link::before {
      content: '';
      position: absolute;
      inset: 0;
      background: var(--primary-gradient);
      opacity: 0;
      transition: var(--transition-smooth);
    }

    .pagination-link:hover:not(.disabled):not(.active) {
      border-color: var(--primary-blue);
      background: var(--glass-bg-medium);
      transform: translateY(-2px);
      box-shadow: var(--shadow-primary);
    }

    .pagination-link:hover:not(.disabled):not(.active)::before {
      opacity: 0.1;
    }

    .pagination-link.active {
      background: var(--primary-gradient);
      border-color: var(--primary-blue);
      color: white;
      font-weight: 700;
      position: relative;
      box-shadow: var(--shadow-primary);
    }

    .pagination-link.active .page-number {
      position: relative;
      z-index: 2;
    }

    .active-indicator {
      position: absolute;
      bottom: -2px;
      left: 50%;
      transform: translateX(-50%);
      width: 20px;
      height: 3px;
      background: white;
      border-radius: 2px;
      opacity: 0.8;
    }

    .pagination-link.disabled {
      opacity: 0.4;
      cursor: not-allowed;
      pointer-events: none;
      background: var(--glass-bg-light);
    }

    .pagination-link.first-page,
    .pagination-link.last-page {
      background: var(--glass-bg-medium);
      border-color: var(--border-medium);
      font-weight: 700;
    }

    .pagination-link.previous-page,
    .pagination-link.next-page {
      background: linear-gradient(135deg, var(--glass-bg-medium) 0%, var(--glass-bg-strong) 100%);
      border-color: var(--border-medium);
      font-weight: 700;
      padding: var(--space-3) var(--space-5);
    }

    .pagination-link.page-number {
      min-width: 44px;
      font-size: var(--font-size-base);
    }

    .pagination-ellipsis {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: var(--space-3) var(--space-2);
      color: var(--text-muted);
      font-weight: 700;
      user-select: none;
    }

    .ellipsis-dots {
      font-size: var(--font-size-lg);
      letter-spacing: 2px;
    }

    /* Quick Jump */
    .pagination-quick-jump {
      display: flex;
      justify-content: center;
      padding-top: var(--space-4);
      border-top: 1px solid var(--border-light);
    }

    .quick-jump-wrapper {
      display: flex;
      align-items: center;
      gap: var(--space-3);
      background: var(--glass-bg);
      padding: var(--space-4);
      border-radius: var(--space-4);
      border: 1px solid var(--border-light);
    }

    .quick-jump-label {
      display: flex;
      align-items: center;
      gap: var(--space-1);
      font-size: var(--font-size-sm);
      font-weight: 600;
      color: var(--text-primary);
      white-space: nowrap;
    }

    .quick-jump-input-group {
      display: flex;
      align-items: center;
      gap: var(--space-2);
    }

    .quick-jump-input {
      width: 80px;
      padding: var(--space-2) var(--space-3);
      border: 2px solid var(--border-light);
      border-radius: var(--space-2);
      background: white;
      color: var(--text-primary);
      font-weight: 600;
      text-align: center;
      transition: var(--transition-smooth);
    }

    .quick-jump-input:focus {
      border-color: var(--primary-blue);
      box-shadow: var(--shadow-focus);
      outline: none;
    }

    .quick-jump-btn {
      padding: var(--space-2) var(--space-3);
      border: 2px solid var(--primary-blue);
      border-radius: var(--space-2);
      background: var(--primary-gradient);
      color: white;
      cursor: pointer;
      transition: var(--transition-smooth);
      display: flex;
      align-items: center;
      justify-content: center;
      min-width: 40px;
      height: 40px;
    }

    .quick-jump-btn:hover {
      transform: translateY(-1px);
      box-shadow: var(--shadow-primary);
    }

    .quick-jump-btn:active {
      transform: translateY(0);
    }

    /* Pagination Progress */
    .pagination-progress {
      display: flex;
      flex-direction: column;
      gap: var(--space-2);
      margin-top: var(--space-4);
      padding-top: var(--space-4);
      border-top: 1px solid var(--border-light);
    }

    .progress-track {
      height: 6px;
      background: var(--border-light);
      border-radius: 3px;
      overflow: hidden;
      position: relative;
    }

    .progress-fill {
      height: 100%;
      background: var(--primary-gradient);
      transition: var(--transition-smooth);
      position: relative;
      border-radius: 3px;
    }

    .progress-glow {
      position: absolute;
      top: 0;
      right: 0;
      width: 20px;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.6));
      animation: glow 2s ease-in-out infinite alternate;
    }

    .progress-text {
      text-align: center;
      font-size: var(--font-size-xs);
      color: var(--text-muted);
      font-weight: 600;
    }

    /* Loading States */
    .loading-spinner.mini {
      width: 16px;
      height: 16px;
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-top: 2px solid currentColor;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    /* Animations */
    @keyframes glow {
      0% {
        opacity: 0.5;
      }

      100% {
        opacity: 1;
      }
    }

    @keyframes shake {

      0%,
      100% {
        transform: translateX(0);
      }

      25% {
        transform: translateX(-5px);
      }

      75% {
        transform: translateX(5px);
      }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .pagination-summary {
        flex-direction: column;
        gap: var(--space-4);
        align-items: stretch;
      }

      .pagination-controls {
        justify-content: center;
      }

      .pagination-links.enhanced {
        gap: var(--space-1);
      }

      .pagination-link {
        padding: var(--space-2) var(--space-3);
        font-size: var(--font-size-xs);
        min-width: 36px;
        min-height: 36px;
      }

      .pagination-link .link-text {
        display: none;
      }

      .pagination-quick-jump {
        padding-top: var(--space-3);
      }

      .quick-jump-wrapper {
        flex-direction: column;
        gap: var(--space-2);
        text-align: center;
      }

      .quick-jump-input-group {
        justify-content: center;
      }
    }

    @media (max-width: 480px) {
      .pagination-container.premium {
        padding: var(--space-4);
      }

      .info-main {
        flex-direction: column;
        align-items: flex-start;
        gap: var(--space-1);
      }

      .info-meta {
        margin-left: 0;
      }

      .pagination-links.enhanced {
        justify-content: center;
      }

      /* Hide some pagination elements on very small screens */
      .pagination-link.first-page,
      .pagination-link.last-page {
        display: none;
      }

      .pagination-ellipsis {
        display: none;
      }
    }

    /* High contrast mode support */
    @media (prefers-contrast: high) {
      .pagination-link {
        border-width: 3px;
      }

      .pagination-link.active {
        border-color: black;
        background: black;
        color: white;
      }
    }

    @media (prefers-reduced-motion: reduce) {
      .pagination-link {
        transition: none;
      }

      .progress-glow {
        animation: none;
      }
    }
  </style>
@endsection
