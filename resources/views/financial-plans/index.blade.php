@extends('layouts.app')

@section('title', 'Financial Plans - Financial Management')
@section('meta-description', 'Manage your financial planning strategies, income targets, and savings goals')

@section('page-header')
  <div class="page-header-content">
    <div class="header-title-section">
      <h1 class="page-title">
        <span class="title-icon">📋</span>
        Financial Plans
      </h1>
      <p class="page-subtitle">Manage your financial planning strategies and goals</p>
    </div>
    <div class="header-actions">
      <a href="{{ route('financial-plans.create') }}" class="action-btn primary">
        <span class="btn-icon">➕</span>
        <span class="btn-text">Create New Plan</span>
      </a>
    </div>
  </div>
@endsection

@section('breadcrumbs')
  <span class="breadcrumb-item">📋 Financial Plans</span>
@endsection

@section('content')
  <!-- Enhanced Overview Section -->
  <section class="overview-section enhanced" data-aos="fade-up">
    <div class="section-wrapper">
      <header class="section-header">
        <div class="header-left">
          <h2 class="section-title">
            <span class="title-icon">
              <span class="icon-emoji">📊</span>
              <div class="icon-glow"></div>
            </span>
            <span class="title-text">Plans Overview</span>
          </h2>
          <p class="section-subtitle">Track your financial planning progress</p>
        </div>
      </header>

      @php
        $totalPlans = $plans->count();
        $activePlans = $plans->where('is_active', true)->count();
        $totalIncome = $plans->sum('monthly_income');
        $totalSavingsTarget = $plans->sum('monthly_savings_target');
      @endphp

      <div class="metrics-grid overview-metrics">
        <article class="metric-card overview-card" data-aos="fade-up" data-aos-delay="200">
          <div class="metric-icon">
            <span class="icon-emoji">📋</span>
            <div class="icon-bg"></div>
          </div>
          <div class="metric-content">
            <div class="metric-value">{{ $totalPlans }}</div>
            <h3 class="metric-label">Total Plans</h3>
            <div class="metric-trend">
              <span class="trend-icon">📈</span>
              <span class="trend-text">{{ $activePlans }} active</span>
            </div>
          </div>
        </article>

        <article class="metric-card overview-card" data-aos="fade-up" data-aos-delay="300">
          <div class="metric-icon">
            <span class="icon-emoji">💰</span>
            <div class="icon-bg"></div>
          </div>
          <div class="metric-content">
            <div class="metric-value">${{ number_format($totalIncome, 2) }}</div>
            <h3 class="metric-label">Total Monthly Income</h3>
            <div class="metric-trend positive">
              <span class="trend-icon">📊</span>
              <span class="trend-text">Across all plans</span>
            </div>
          </div>
        </article>

        <article class="metric-card overview-card" data-aos="fade-up" data-aos-delay="400">
          <div class="metric-icon">
            <span class="icon-emoji">🎯</span>
            <div class="icon-bg"></div>
          </div>
          <div class="metric-content">
            <div class="metric-value">${{ number_format($totalSavingsTarget, 2) }}</div>
            <h3 class="metric-label">Total Savings Target</h3>
            <div class="metric-trend positive">
              <span class="trend-icon">💎</span>
              <span class="trend-text">Monthly goal</span>
            </div>
          </div>
        </article>

        @if($totalIncome > 0)
          <article class="metric-card overview-card" data-aos="fade-up" data-aos-delay="500">
            <div class="metric-icon">
              <span class="icon-emoji">📈</span>
              <div class="icon-bg"></div>
            </div>
            <div class="metric-content">
              <div class="metric-value">{{ number_format(($totalSavingsTarget / $totalIncome) * 100, 1) }}%</div>
              <h3 class="metric-label">Savings Rate</h3>
              <div class="metric-trend {{ ($totalSavingsTarget / $totalIncome) >= 0.2 ? 'positive' : 'warning' }}">
                <span class="trend-icon">{{ ($totalSavingsTarget / $totalIncome) >= 0.2 ? '✅' : '⚠️' }}</span>
                <span class="trend-text">{{ ($totalSavingsTarget / $totalIncome) >= 0.2 ? 'Excellent' : 'Improve' }}</span>
              </div>
            </div>
          </article>
        @endif
      </div>
    </div>
  </section>

  <!-- Enhanced Financial Plans Section -->
  <section class="plans-section enhanced" data-aos="fade-up" data-aos-delay="600">
    <div class="section-wrapper">
      <header class="section-header plans-header">
        <div class="header-left">
          <h2 class="section-title">
            <span class="title-icon plans-icon">
              <span class="icon-emoji">📋</span>
              <div class="icon-glow"></div>
            </span>
            <span class="title-text">Your Financial Plans</span>
          </h2>
          <p class="section-subtitle">Manage and track your financial strategies</p>
        </div>
        <div class="plans-actions">
          <a href="{{ route('financial-plans.create') }}" class="action-btn primary">
            <span class="btn-icon">➕</span>
            <span class="btn-text">Create Plan</span>
          </a>
        </div>
      </header>

      @if ($plans->count() > 0)
        <div class="plans-grid enhanced">
          @foreach ($plans as $index => $plan)
            <article class="plan-card enhanced {{ $plan->is_active ? 'active-plan' : '' }}"
                     data-aos="fade-up"
                     data-aos-delay="{{ 700 + $index * 150 }}">
              <div class="plan-background"></div>

              <header class="plan-header enhanced">
                <div class="plan-info">
                  <div class="plan-title-section">
                    <h3 class="plan-name">{{ $plan->name }}</h3>
                    @if ($plan->is_active)
                      <div class="active-badge enhanced">
                        <span class="badge-icon">✅</span>
                        <span class="badge-text">Active</span>
                      </div>
                    @endif
                  </div>
                  @if ($plan->description)
                    <p class="plan-description">{{ Str::limit($plan->description, 100) }}</p>
                  @endif
                </div>
                <div class="plan-actions enhanced">
                  <a href="{{ route('financial-plans.show', $plan) }}"
                     class="action-btn mini plan-action"
                     title="View {{ $plan->name }}">
                    <span class="action-icon">👁️</span>
                  </a>
                  <a href="{{ route('financial-plans.edit', $plan) }}"
                     class="action-btn mini plan-action"
                     title="Edit {{ $plan->name }}">
                    <span class="action-icon">✏️</span>
                  </a>
                </div>
              </header>

              <div class="plan-stats enhanced">
                <div class="stats-grid">
                  <div class="stat-item income-stat">
                    <div class="stat-icon">💰</div>
                    <div class="stat-content">
                      <div class="stat-label">Monthly Income</div>
                      <div class="stat-value">${{ number_format($plan->monthly_income, 2) }}</div>
                    </div>
                  </div>

                  <div class="stat-item savings-stat">
                    <div class="stat-icon">🎯</div>
                    <div class="stat-content">
                      <div class="stat-label">Savings Target</div>
                      <div class="stat-value">${{ number_format($plan->monthly_savings_target, 2) }}</div>
                    </div>
                  </div>

                  <div class="stat-item emergency-stat">
                    <div class="stat-icon">🏦</div>
                    <div class="stat-content">
                      <div class="stat-label">Emergency Fund</div>
                      <div class="stat-value">${{ number_format($plan->emergency_fund_target, 2) }}</div>
                    </div>
                  </div>

                  <div class="stat-item return-stat">
                    <div class="stat-icon">📈</div>
                    <div class="stat-content">
                      <div class="stat-label">Investment Return</div>
                      <div class="stat-value">{{ $plan->investment_return_rate }}%</div>
                    </div>
                  </div>
                </div>

                <!-- Savings Rate Progress -->
                @php
                  $savingsRate = $plan->monthly_income > 0 ? ($plan->monthly_savings_target / $plan->monthly_income) * 100 : 0;
                @endphp
                <div class="progress-section enhanced">
                  <div class="progress-header">
                    <span class="progress-label">Savings Rate</span>
                    <span class="progress-percentage">{{ number_format($savingsRate, 1) }}%</span>
                  </div>
                  <div class="progress-container premium" role="progressbar"
                       aria-valuenow="{{ $savingsRate }}"
                       aria-valuemin="0"
                       aria-valuemax="100"
                       aria-label="Savings rate for {{ $plan->name }}">
                    <div class="progress-track"></div>
                    <div class="progress-bar animated"
                         style="width: {{ min($savingsRate, 100) }}%;
                                background: linear-gradient(90deg,
                                  {{ $savingsRate >= 20 ? '#10b981' : ($savingsRate >= 10 ? '#f59e0b' : '#ef4444') }},
                                  {{ $savingsRate >= 20 ? '#059669' : ($savingsRate >= 10 ? '#d97706' : '#dc2626') }});">
                      <div class="progress-shine"></div>
                      <div class="progress-glow"></div>
                    </div>
                  </div>
                  <div class="progress-footer">
                    <div class="savings-status {{ $savingsRate >= 20 ? 'excellent' : ($savingsRate >= 10 ? 'good' : 'needs-improvement') }}">
                      <span class="status-dot"></span>
                      <span class="status-text">
                        {{ $savingsRate >= 20 ? 'Excellent Rate' : ($savingsRate >= 10 ? 'Good Rate' : 'Needs Improvement') }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>

              @if (!$plan->is_active)
                <footer class="plan-footer">
                  <form action="{{ route('financial-plans.activate', $plan) }}" method="POST" class="activate-form">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="action-btn success activate-btn">
                      <span class="btn-icon">⚡</span>
                      <span class="btn-text">Activate Plan</span>
                    </button>
                  </form>
                </footer>
              @endif
            </article>
          @endforeach
        </div>
      @else
        <div class="empty-state enhanced">
          <div class="empty-content">
            <div class="empty-icon">📋</div>
            <h3 class="empty-title">No Financial Plans Yet</h3>
            <p class="empty-description">
              Create your first financial plan to start tracking your income, expenses, and savings goals effectively.
            </p>
            <div class="empty-actions">
              <a href="{{ route('financial-plans.create') }}" class="action-btn primary large">
                <span class="btn-icon">➕</span>
                <span class="btn-text">Create Your First Plan</span>
              </a>
            </div>
            <div class="empty-features">
              <div class="feature-item">
                <span class="feature-icon">💰</span>
                <span class="feature-text">Track Income & Expenses</span>
              </div>
              <div class="feature-item">
                <span class="feature-icon">🎯</span>
                <span class="feature-text">Set Savings Goals</span>
              </div>
              <div class="feature-item">
                <span class="feature-icon">📈</span>
                <span class="feature-text">Monitor Investment Returns</span>
              </div>
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

        // Enhanced plan card interactions
        const planCards = document.querySelectorAll('.plan-card');
        planCards.forEach(card => {
          card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
          });

          card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
          });
        });

        // Activate form confirmation
        const activateForms = document.querySelectorAll('.activate-form');
        activateForms.forEach(form => {
          form.addEventListener('submit', function(e) {
            const planName = this.closest('.plan-card').querySelector('.plan-name').textContent;
            if (!confirm(`Are you sure you want to activate the plan "${planName}"? This will deactivate your current active plan.`)) {
              e.preventDefault();
            }
          });
        });

        // Loading state for activate buttons
        const activateButtons = document.querySelectorAll('.activate-btn');
        activateButtons.forEach(btn => {
          btn.addEventListener('click', function() {
            this.style.opacity = '0.6';
            this.style.pointerEvents = 'none';

            const originalContent = this.innerHTML;
            this.innerHTML = '<span class="loading-spinner mini"></span><span class="btn-text">Activating...</span>';

            // Restore after timeout (for error cases)
            setTimeout(() => {
              this.innerHTML = originalContent;
              this.style.opacity = '1';
              this.style.pointerEvents = 'auto';
            }, 5000);
          });
        });
      });
    </script>
  @endpush

  <style>
    /* Enhanced styling specific to financial plans index */
    .overview-section {
      background: linear-gradient(135deg, rgba(16, 185, 129, 0.03) 0%, rgba(59, 130, 246, 0.03) 100%);
      border-radius: 32px;
      padding: var(--space-xl);
      margin-bottom: var(--space-xl);
      border: 1px solid rgba(16, 185, 129, 0.15);
      box-shadow: var(--shadow-light);
    }

    .overview-metrics {
      margin-top: var(--space-lg);
    }

    .overview-card {
      background: var(--glass-bg-strong);
      backdrop-filter: var(--blur-backdrop);
    }

    .plans-grid.enhanced {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
      gap: var(--space-8);
      margin-top: var(--space-lg);
    }

    .plan-card.enhanced {
      background: var(--glass-bg-strong);
      backdrop-filter: var(--blur-backdrop);
      border: 2px solid var(--glass-border);
      border-radius: var(--space-6);
      padding: var(--space-8);
      position: relative;
      overflow: hidden;
      transition: var(--transition-spring);
      box-shadow: var(--shadow-lg);
    }

    .plan-card.enhanced:hover {
      transform: translateY(-8px) scale(1.02);
      box-shadow: var(--shadow-2xl);
    }

    .plan-card.enhanced.active-plan {
      border-color: var(--success-green);
      background: linear-gradient(135deg, var(--glass-bg-strong) 0%, rgba(16, 185, 129, 0.05) 100%);
      box-shadow: var(--shadow-success);
    }

    .plan-background {
      position: absolute;
      inset: 0;
      background: var(--primary-gradient);
      opacity: 0;
      transition: var(--transition-smooth);
      border-radius: var(--space-6);
    }

    .plan-card.enhanced:hover .plan-background {
      opacity: 0.02;
    }

    .plan-card.enhanced.active-plan .plan-background {
      background: var(--success-gradient);
      opacity: 0.03;
    }

    .plan-header.enhanced {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: var(--space-6);
      position: relative;
      z-index: 2;
    }

    .plan-info {
      flex: 1;
    }

    .plan-title-section {
      display: flex;
      align-items: center;
      gap: var(--space-3);
      margin-bottom: var(--space-2);
    }

    .plan-name {
      font-size: var(--font-size-xl);
      font-weight: 700;
      color: var(--text-primary);
      margin: 0;
    }

    .active-badge.enhanced {
      display: flex;
      align-items: center;
      gap: var(--space-1);
      background: var(--success-gradient);
      color: white;
      font-size: var(--font-size-xs);
      padding: var(--space-1) var(--space-3);
      border-radius: var(--space-4);
      font-weight: 600;
      box-shadow: var(--shadow-success);
      animation: pulse 2s infinite;
    }

    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.8; }
    }

    .badge-icon {
      font-size: var(--font-size-xs);
    }

    .plan-description {
      color: var(--text-muted);
      font-size: var(--font-size-sm);
      line-height: 1.5;
      margin: 0;
    }

    .plan-actions.enhanced {
      display: flex;
      gap: var(--space-2);
      position: relative;
      z-index: 2;
    }

    .plan-action {
      background: var(--glass-bg-medium);
      backdrop-filter: var(--blur-backdrop);
      border: 1px solid var(--glass-border);
      transition: var(--transition-smooth);
    }

    .plan-action:hover {
      background: var(--glass-bg-strong);
      transform: translateY(-1px);
    }

    .plan-stats.enhanced {
      position: relative;
      z-index: 2;
    }

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: var(--space-4);
      margin-bottom: var(--space-6);
    }

    .stat-item {
      display: flex;
      align-items: center;
      gap: var(--space-3);
      padding: var(--space-4);
      background: var(--glass-bg);
      backdrop-filter: var(--blur-backdrop);
      border: 1px solid var(--glass-border);
      border-radius: var(--space-4);
      transition: var(--transition-smooth);
    }

    .stat-item:hover {
      background: var(--glass-bg-medium);
      transform: translateY(-2px);
    }

    .stat-icon {
      font-size: var(--font-size-lg);
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--glass-bg-medium);
      border-radius: 50%;
      flex-shrink: 0;
    }

    .stat-content {
      flex: 1;
    }

    .stat-label {
      font-size: var(--font-size-xs);
      color: var(--text-muted);
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: var(--space-1);
    }

    .stat-value {
      font-size: var(--font-size-base);
      font-weight: 700;
      color: var(--text-primary);
    }

    .progress-section.enhanced {
      margin-top: var(--space-6);
      padding: var(--space-4);
      background: var(--glass-bg);
      backdrop-filter: var(--blur-backdrop);
      border: 1px solid var(--glass-border);
      border-radius: var(--space-4);
    }

    .progress-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: var(--space-3);
    }

    .progress-label {
      font-size: var(--font-size-sm);
      font-weight: 600;
      color: var(--text-primary);
    }

    .progress-percentage {
      font-size: var(--font-size-sm);
      font-weight: 700;
      color: var(--text-primary);
    }

    .progress-container.premium {
      position: relative;
      height: 8px;
      background: var(--border-light);
      border-radius: 4px;
      overflow: hidden;
    }

    .progress-bar.animated {
      height: 100%;
      border-radius: 4px;
      position: relative;
      transition: width 1s ease-out;
    }

    .progress-shine {
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
      animation: shine 2s infinite;
    }

    @keyframes shine {
      0% { left: -100%; }
      100% { left: 100%; }
    }

    .progress-glow {
      position: absolute;
      inset: -2px;
      background: inherit;
      filter: blur(4px);
      opacity: 0.3;
      border-radius: 6px;
    }

    .progress-footer {
      margin-top: var(--space-3);
      display: flex;
      justify-content: center;
    }

    .savings-status {
      display: flex;
      align-items: center;
      gap: var(--space-2);
      font-size: var(--font-size-xs);
      font-weight: 600;
    }

    .savings-status.excellent {
      color: var(--success-green);
    }

    .savings-status.good {
      color: var(--warning-amber);
    }

    .savings-status.needs-improvement {
      color: var(--danger-red);
    }

    .status-dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background: currentColor;
      animation: pulse 2s infinite;
    }

    .plan-footer {
      margin-top: var(--space-6);
      padding-top: var(--space-4);
      border-top: 1px solid var(--border-light);
      position: relative;
      z-index: 2;
    }

    .activate-form {
      display: flex;
      justify-content: center;
    }

    .activate-btn {
      background: var(--success-gradient);
      color: white;
      border: 2px solid var(--success-green);
      transition: var(--transition-smooth);
    }

    .activate-btn:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow-success);
    }

    .empty-state.enhanced {
      background: var(--glass-bg-strong);
      backdrop-filter: var(--blur-backdrop);
      border-radius: var(--space-8);
      padding: var(--space-20);
      text-align: center;
      border: 1px solid var(--glass-border);
      box-shadow: var(--shadow-light);
    }

    .empty-content {
      max-width: 600px;
      margin: 0 auto;
    }

    .empty-icon {
      font-size: 4rem;
      margin-bottom: var(--space-lg);
      opacity: 0.7;
    }

    .empty-title {
      font-size: var(--font-size-2xl);
      font-weight: 700;
      color: var(--text-primary);
      margin-bottom: var(--space-md);
    }

    .empty-description {
      color: var(--text-muted);
      font-size: var(--font-size-lg);
      margin-bottom: var(--space-xl);
      line-height: 1.6;
    }

    .empty-actions {
      margin-bottom: var(--space-xl);
    }

    .empty-features {
      display: flex;
      justify-content: center;
      gap: var(--space-8);
      flex-wrap: wrap;
    }

    .feature-item {
      display: flex;
      align-items: center;
      gap: var(--space-2);
      color: var(--text-muted);
      font-size: var(--font-size-sm);
      font-weight: 500;
    }

    .feature-icon {
      font-size: var(--font-size-lg);
    }

    .loading-spinner.mini {
      width: 16px;
      height: 16px;
      border: 2px solid rgba(255, 255, 255, 0.3);
      border-top: 2px solid currentColor;
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .plans-grid.enhanced {
        grid-template-columns: 1fr;
        gap: var(--space-6);
      }

      .stats-grid {
        grid-template-columns: 1fr;
      }

      .plan-header.enhanced {
        flex-direction: column;
        gap: var(--space-4);
        align-items: stretch;
      }

      .plan-title-section {
        justify-content: space-between;
      }

      .plan-actions.enhanced {
        justify-content: center;
      }

      .empty-features {
        flex-direction: column;
        align-items: center;
        gap: var(--space-4);
      }
    }

    @media (max-width: 480px) {
      .plan-card.enhanced {
        padding: var(--space-6);
      }

      .overview-section {
        padding: var(--space-6);
      }
    }
  </style>
@endsection
