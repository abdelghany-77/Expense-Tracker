@extends('layouts.app')

@section('content')
  <div class="page-header">
    <div class="page-header-content">
      <div class="page-header-main">
        <div class="page-title-section">
          <h1 class="page-title">
            <span class="page-icon">🎯</span>
            Savings Goals
          </h1>
          <p class="page-subtitle">Track your progress towards financial milestones and achieve your dreams</p>
        </div>
        <div class="page-actions">
          <a href="{{ route('savings-goals.create') }}" class="btn btn-primary btn-enhanced">
            <span class="btn-icon">🎯</span>
            <span class="btn-text">Create New Goal</span>
            <span class="btn-accent">✨</span>
          </a>
        </div>
      </div>

      @if ($goals->count() > 0)
        <div class="page-header-stats">
          <div class="quick-stat">
            <span class="quick-stat-icon">🎯</span>
            <div class="quick-stat-content">
              <span class="quick-stat-value">{{ $goals->count() }}</span>
              <span class="quick-stat-label">Total Goals</span>
            </div>
          </div>

          <div class="quick-stat">
            <span class="quick-stat-icon">✅</span>
            <div class="quick-stat-content">
              <span class="quick-stat-value">{{ $goals->where('is_completed', true)->count() }}</span>
              <span class="quick-stat-label">Completed</span>
            </div>
          </div>

          <div class="quick-stat">
            <span class="quick-stat-icon">⏱️</span>
            <div class="quick-stat-content">
              <span class="quick-stat-value">{{ $goals->where('is_completed', false)->count() }}</span>
              <span class="quick-stat-label">In Progress</span>
            </div>
          </div>

          <div class="quick-stat featured">
            <span class="quick-stat-icon">💰</span>
            <div class="quick-stat-content">
              <span class="quick-stat-value">${{ number_format($goals->sum('current_amount'), 0) }}</span>
              <span class="quick-stat-label">Total Saved</span>
            </div>
          </div>
        </div>
      @endif
    </div>
  </div>

  @if ($goals->count() > 0)
    <!-- Active Goals -->
    <div class="content-card">
      <div class="content-card-header">
        <h2 class="content-card-title">
          <span>🎯</span> Active Goals
        </h2>
      </div>

      <div class="goals-container">
        @foreach ($goals->where('is_completed', false) as $goal)
          <div class="goal-card" style="border-left: 4px solid {{ $goal->color }};">
            <div class="goal-header">
              <div class="goal-info">
                <h3 class="goal-title">{{ $goal->name }}</h3>
                @if ($goal->description)
                  <p class="goal-description">{{ $goal->description }}</p>
                @endif
              </div>
              <div class="goal-actions">
                <button type="button" class="btn-icon btn-icon-primary" onclick="openAddFundsModal({{ $goal->id }})"
                  title="Add Funds" aria-label="Add funds to {{ $goal->name }}">
                  <span>💰</span>
                </button>
                <a href="{{ route('savings-goals.edit', $goal) }}" class="btn-icon btn-icon-secondary"
                   title="Edit Goal" aria-label="Edit {{ $goal->name }}">
                  <span>✏️</span>
                </a>
              </div>
            </div>

            <div class="goal-progress">
              <div class="progress-info">
                <span class="progress-current">${{ number_format($goal->current_amount, 2) }}</span>
                <span class="progress-target">of ${{ number_format($goal->target_amount, 2) }}</span>
              </div>
              <div class="progress-container">
                <div class="progress-bar"
                  style="width: {{ $goal->progress_percentage }}%; background-color: {{ $goal->color }};">
                </div>
              </div>
              <div class="progress-details">
                <span class="progress-percentage">{{ number_format($goal->progress_percentage, 1) }}% complete</span>
                <span class="progress-remaining">
                  @if ($goal->days_remaining >= 0)
                    {{ $goal->days_remaining }} days left
                  @else
                    <span style="color: var(--danger-red);">{{ abs($goal->days_remaining) }} days overdue</span>
                  @endif
                </span>
              </div>
            </div>

            <div class="goal-meta">
              <div class="goal-priority priority-{{ $goal->priority }}">
                {{ ucfirst($goal->priority) }} Priority
              </div>
              <div class="goal-date">
                <span>📅</span>
                Target: {{ $goal->target_date->format('M j, Y') }}
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- Completed Goals -->
    @if ($goals->where('is_completed', true)->count() > 0)
      <div class="content-card">
        <div class="content-card-header">
          <h2 class="content-card-title">
            <span>🎉</span> Completed Goals
          </h2>
        </div>

        <div class="goals-container">
          @foreach ($goals->where('is_completed', true) as $goal)
            <div class="goal-card completed" style="border-left: 4px solid {{ $goal->color }};">
              <div class="goal-header">
                <div class="goal-info">
                  <h3 class="goal-title">{{ $goal->name }}</h3>
                  <div class="completion-badge">
                    <span>✅</span> Goal Achieved!
                  </div>
                </div>
              </div>
              <div class="goal-achievement">
                <span class="achievement-amount" style="color: {{ $goal->color }};">
                  ${{ number_format($goal->target_amount, 2) }}
                </span>
                <span class="achievement-label">Successfully Saved</span>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif
  @else
    <div class="content-card">
      <div class="empty-state">
        <div class="empty-icon">🎯</div>
        <h3 class="empty-title">No Savings Goals Yet</h3>
        <p class="empty-description">Set your first savings goal and start working towards your financial dreams.</p>
        <a href="{{ route('savings-goals.create') }}" class="btn btn-primary">
          <span>🎯</span> Create Your First Goal
        </a>
      </div>
    </div>
  @endif

  <!-- Add Funds Modal -->
  <div id="addFundsModal" class="modal" style="display: none;">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Add Funds to Goal</h3>
        <button type="button" class="modal-close" onclick="closeAddFundsModal()" aria-label="Close modal">&times;</button>
      </div>
      <form id="addFundsForm" method="POST" class="modal-body">
        @csrf
        @method('PATCH')
        <div class="form-group">
          <label for="amount" class="form-label">Amount to Add *</label>
          <div class="input-group">
            <span class="input-prefix">$</span>
            <input type="number" id="amount" name="amount" step="0.01" min="0.01" class="form-input"
              placeholder="0.00" required>
          </div>
        </div>
        <div class="form-group">
          <label for="notes" class="form-label">Notes (Optional)</label>
          <input type="text" id="notes" name="notes" class="form-input"
            placeholder="e.g., Monthly savings deposit">
        </div>
        <div class="modal-actions">
          <button type="submit" class="btn btn-primary">
            <span>💰</span> Add Funds
          </button>
          <button type="button" class="btn btn-secondary" onclick="closeAddFundsModal()">Cancel</button>
        </div>
      </form>
    </div>
  </div>

  <style>
    /* Enhanced Page Header */
    .page-header {
      background: var(--glass-bg-strong);
      backdrop-filter: var(--glass-backdrop);
      border: 1px solid var(--glass-border);
      border-radius: var(--space-6);
      padding: 0;
      margin-bottom: var(--space-8);
      box-shadow: var(--shadow-lg);
      position: relative;
      overflow: hidden;
    }

    .page-header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: var(--hero-gradient);
      opacity: 0.08;
      border-radius: var(--space-6);
    }

    .page-header-content {
      position: relative;
      z-index: 2;
    }

    .page-header-main {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      padding: var(--space-8);
      gap: var(--space-6);
    }

    .page-title-section {
      flex: 1;
      min-width: 0;
    }

    .page-title {
      font-size: var(--text-4xl);
      font-weight: var(--font-black);
      color: var(--text-inverse);
      margin-bottom: var(--space-3);
      display: flex;
      align-items: center;
      gap: var(--space-3);
      line-height: 1.2;
    }

    .page-icon {
      font-size: var(--text-4xl);
      background: var(--glass-bg-strong);
      border-radius: var(--space-3);
      padding: var(--space-3);
      border: 1px solid var(--glass-border);
      box-shadow: var(--shadow-md);
    }

    .page-subtitle {
      color: rgba(255, 255, 255, 0.9);
      font-size: var(--text-lg);
      font-weight: var(--font-medium);
      margin-bottom: var(--space-4);
      line-height: 1.5;
      max-width: 500px;
    }

    .page-breadcrumb {
      display: flex;
      align-items: center;
      gap: var(--space-2);
      font-size: var(--text-sm);
      font-weight: var(--font-medium);
    }

    .breadcrumb-item {
      color: rgba(255, 255, 255, 0.7);
      display: flex;
      align-items: center;
      gap: var(--space-1);
    }

    .breadcrumb-item.active {
      color: var(--accent-gold);
    }

    .breadcrumb-separator {
      color: rgba(255, 255, 255, 0.5);
      font-weight: var(--font-normal);
    }

    .page-actions {
      display: flex;
      gap: var(--space-3);
      align-items: flex-start;
      flex-shrink: 0;
    }

    .btn-enhanced {
      position: relative;
      padding: var(--space-4) var(--space-6);
      background: var(--primary-gradient);
      border: 1px solid rgba(255, 255, 255, 0.2);
      border-radius: var(--space-3);
      color: var(--text-inverse);
      text-decoration: none;
      font-weight: var(--font-semibold);
      font-size: var(--text-base);
      display: flex;
      align-items: center;
      gap: var(--space-2);
      box-shadow: var(--shadow-lg);
      transition: var(--transition-smooth);
      overflow: hidden;
    }

    .btn-enhanced::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: var(--transition-normal);
    }

    .btn-enhanced:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow-xl);
      border-color: rgba(255, 255, 255, 0.3);
    }

    .btn-enhanced:hover::before {
      left: 100%;
    }

    .btn-enhanced:active {
      transform: translateY(0);
    }

    .btn-icon {
      font-size: var(--text-lg);
      transition: var(--transition-fast);
    }

    .btn-enhanced:hover .btn-icon {
      transform: scale(1.1);
    }

    .btn-text {
      font-weight: var(--font-semibold);
    }

    .btn-accent {
      opacity: 0.7;
      transition: var(--transition-fast);
    }

    .btn-enhanced:hover .btn-accent {
      opacity: 1;
      animation: sparkle 0.6s ease-in-out;
    }

    @keyframes sparkle {
      0%, 100% { transform: scale(1) rotate(0deg); }
      50% { transform: scale(1.2) rotate(180deg); }
    }

    /* Page Header Stats */
    .page-header-stats {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
      gap: var(--space-4);
      padding: var(--space-6) var(--space-8);
      background: rgba(255, 255, 255, 0.05);
      border-top: 1px solid rgba(255, 255, 255, 0.1);
    }

    .quick-stat {
      display: flex;
      align-items: center;
      gap: var(--space-3);
      padding: var(--space-3);
      background: rgba(255, 255, 255, 0.08);
      border-radius: var(--space-3);
      border: 1px solid rgba(255, 255, 255, 0.12);
      transition: var(--transition-fast);
    }

    .quick-stat:hover {
      background: rgba(255, 255, 255, 0.12);
      transform: translateY(-1px);
    }

    .quick-stat.featured {
      background: var(--wealth-gradient);
      background-size: 200% 200%;
      animation: shimmer 3s ease-in-out infinite;
      border-color: var(--accent-gold);
      box-shadow: var(--shadow-gold);
    }

    @keyframes shimmer {
      0%, 100% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
    }

    .quick-stat-icon {
      font-size: var(--text-xl);
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: rgba(255, 255, 255, 0.1);
      border-radius: var(--space-2);
      flex-shrink: 0;
    }

    .quick-stat.featured .quick-stat-icon {
      background: rgba(255, 255, 255, 0.2);
      box-shadow: var(--shadow-sm);
    }

    .quick-stat-content {
      display: flex;
      flex-direction: column;
      min-width: 0;
    }

    .quick-stat-value {
      font-size: var(--text-lg);
      font-weight: var(--font-bold);
      color: var(--text-inverse);
      line-height: 1.2;
    }

    .quick-stat-label {
      font-size: var(--text-xs);
      color: rgba(255, 255, 255, 0.8);
      font-weight: var(--font-medium);
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    /* Stats Grid */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: var(--space-6);
      margin-bottom: var(--space-8);
    }

    .stat-card {
      background: var(--glass-bg-strong);
      backdrop-filter: var(--glass-backdrop);
      border: 1px solid var(--glass-border);
      border-radius: var(--space-4);
      padding: var(--space-6);
      display: flex;
      align-items: center;
      gap: var(--space-4);
      box-shadow: var(--shadow-md);
      transition: var(--transition-normal);
    }

    .stat-card:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow-lg);
    }

    .stat-icon {
      font-size: var(--text-3xl);
      width: 60px;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--glass-bg);
      border-radius: var(--space-3);
      border: 1px solid var(--glass-border);
    }

    .stat-content {
      flex: 1;
    }

    .stat-value {
      font-size: var(--text-2xl);
      font-weight: var(--font-bold);
      color: var(--text-inverse);
      line-height: 1.2;
    }

    .stat-label {
      font-size: var(--text-sm);
      color: var(--text-light);
      font-weight: var(--font-medium);
    }

    /* Goals Container */
    .goals-container {
      display: grid;
      gap: var(--space-6);
    }

    .goal-card {
      background: var(--bg-primary);
      border-radius: var(--space-4);
      padding: var(--space-6);
      box-shadow: var(--shadow-sm);
      transition: var(--transition-normal);
    }

    .goal-card:hover {
      transform: translateY(-1px);
      box-shadow: var(--shadow-md);
    }

    .goal-card.completed {
      opacity: 0.9;
      background: var(--bg-muted);
    }

    .goal-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: var(--space-6);
    }

    .goal-info {
      flex: 1;
    }

    .goal-title {
      font-size: var(--text-xl);
      font-weight: var(--font-semibold);
      color: var(--text-primary);
      margin-bottom: var(--space-2);
    }

    .goal-description {
      color: var(--text-muted);
      font-size: var(--text-sm);
      margin: 0;
    }

    .goal-actions {
      display: flex;
      gap: var(--space-2);
    }

    .btn-icon {
      width: 40px;
      height: 40px;
      border-radius: var(--space-2);
      border: 1px solid var(--border-light);
      background: var(--bg-primary);
      color: var(--text-secondary);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: var(--text-lg);
      cursor: pointer;
      transition: var(--transition-fast);
      text-decoration: none;
    }

    .btn-icon:hover {
      transform: translateY(-1px);
      box-shadow: var(--shadow-sm);
    }

    .btn-icon-primary:hover {
      background: var(--primary-blue-50);
      border-color: var(--primary-blue);
      color: var(--primary-blue);
    }

    .btn-icon-secondary:hover {
      background: var(--neutral-100);
      border-color: var(--neutral-400);
      color: var(--neutral-600);
    }

    /* Goal Progress */
    .goal-progress {
      margin-bottom: var(--space-6);
    }

    .progress-info {
      display: flex;
      justify-content: space-between;
      align-items: baseline;
      margin-bottom: var(--space-3);
    }

    .progress-current {
      font-size: var(--text-xl);
      font-weight: var(--font-semibold);
      color: var(--text-primary);
    }

    .progress-target {
      color: var(--text-muted);
      font-size: var(--text-sm);
    }

    .progress-container {
      background: var(--bg-muted);
      border-radius: var(--space-2);
      height: 8px;
      overflow: hidden;
      margin-bottom: var(--space-2);
    }

    .progress-bar {
      height: 100%;
      border-radius: var(--space-2);
      transition: var(--transition-normal);
    }

    .progress-details {
      display: flex;
      justify-content: space-between;
      font-size: var(--text-xs);
      color: var(--text-muted);
    }

    /* Goal Meta */
    .goal-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: var(--space-4);
      border-top: 1px solid var(--border-light);
    }

    .goal-priority {
      padding: var(--space-1) var(--space-3);
      border-radius: var(--space-2);
      font-size: var(--text-xs);
      font-weight: var(--font-medium);
    }

    .priority-low {
      background: var(--neutral-100);
      color: var(--neutral-600);
    }

    .priority-medium {
      background: #fef3c7;
      color: #92400e;
    }

    .priority-high {
      background: #fee2e2;
      color: #991b1b;
    }

    .goal-date {
      display: flex;
      align-items: center;
      gap: var(--space-1);
      font-size: var(--text-sm);
      color: var(--text-muted);
    }

    /* Completed Goals */
    .completion-badge {
      display: flex;
      align-items: center;
      gap: var(--space-2);
      color: var(--success-green);
      font-size: var(--text-sm);
      font-weight: var(--font-medium);
      margin-top: var(--space-2);
    }

    .goal-achievement {
      text-align: center;
      padding: var(--space-4) 0;
    }

    .achievement-amount {
      display: block;
      font-size: var(--text-2xl);
      font-weight: var(--font-bold);
      margin-bottom: var(--space-1);
    }

    .achievement-label {
      display: block;
      font-size: var(--text-sm);
      color: var(--text-muted);
    }

    /* Empty State */
    .empty-state {
      text-align: center;
      padding: var(--space-16) var(--space-8);
    }

    .empty-icon {
      font-size: 4rem;
      margin-bottom: var(--space-4);
      opacity: 0.5;
    }

    .empty-title {
      font-size: var(--text-xl);
      font-weight: var(--font-semibold);
      color: var(--text-primary);
      margin-bottom: var(--space-2);
    }

    .empty-description {
      color: var(--text-muted);
      margin-bottom: var(--space-6);
      max-width: 400px;
      margin-left: auto;
      margin-right: auto;
    }

    /* Modal Styles */
    .modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: var(--z-modal);
      backdrop-filter: blur(4px);
    }

    .modal-content {
      background: var(--bg-primary);
      border-radius: var(--space-4);
      width: 90%;
      max-width: 500px;
      max-height: 90vh;
      overflow-y: auto;
      box-shadow: var(--shadow-2xl);
    }

    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: var(--space-6);
      border-bottom: 1px solid var(--border-light);
    }

    .modal-title {
      font-size: var(--text-xl);
      font-weight: var(--font-semibold);
      color: var(--text-primary);
      margin: 0;
    }

    .modal-close {
      background: none;
      border: none;
      font-size: var(--text-2xl);
      cursor: pointer;
      color: var(--text-muted);
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: var(--space-1);
      transition: var(--transition-fast);
    }

    .modal-close:hover {
      color: var(--text-primary);
      background: var(--bg-muted);
    }

    .modal-body {
      padding: var(--space-6);
    }

    .modal-actions {
      display: flex;
      gap: var(--space-3);
      margin-top: var(--space-6);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .page-header-main {
        flex-direction: column;
        gap: var(--space-6);
        padding: var(--space-6);
      }

      .page-title {
        font-size: var(--text-3xl);
      }

      .page-icon {
        font-size: var(--text-3xl);
      }

      .page-actions {
        width: 100%;
        justify-content: center;
      }

      .btn-enhanced {
        flex: 1;
        justify-content: center;
        padding: var(--space-4) var(--space-5);
      }

      .page-header-stats {
        grid-template-columns: repeat(2, 1fr);
        padding: var(--space-4) var(--space-6);
        gap: var(--space-3);
      }

      .quick-stat {
        padding: var(--space-2);
      }

      .quick-stat-value {
        font-size: var(--text-base);
      }

      .page-breadcrumb {
        justify-content: center;
      }
    }

    @media (max-width: 480px) {
      .page-header-stats {
        grid-template-columns: 1fr;
      }

      .page-title {
        font-size: var(--text-2xl);
        flex-direction: column;
        text-align: center;
        gap: var(--space-2);
      }

      .page-subtitle {
        text-align: center;
      }
    }

    /* Stats Grid */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: var(--space-6);
      margin-bottom: var(--space-8);
    }

    .stat-card {
      background: var(--glass-bg-strong);
      backdrop-filter: var(--glass-backdrop);
      border: 1px solid var(--glass-border);
      border-radius: var(--space-4);
      padding: var(--space-6);
      display: flex;
      align-items: center;
      gap: var(--space-4);
      box-shadow: var(--shadow-md);
      transition: var(--transition-normal);
    }

    .stat-card:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow-lg);
    }

    .stat-icon {
      font-size: var(--text-3xl);
      width: 60px;
      height: 60px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: var(--glass-bg);
      border-radius: var(--space-3);
      border: 1px solid var(--glass-border);
    }

    .stat-content {
      flex: 1;
    }

    .stat-value {
      font-size: var(--text-2xl);
      font-weight: var(--font-bold);
      color: var(--text-inverse);
      line-height: 1.2;
    }

    .stat-label {
      font-size: var(--text-sm);
      color: var(--text-light);
      font-weight: var(--font-medium);
    }

    /* Goals Container */
    .goals-container {
      display: grid;
      gap: var(--space-6);
    }

    .goal-card {
      background: var(--bg-primary);
      border-radius: var(--space-4);
      padding: var(--space-6);
      box-shadow: var(--shadow-sm);
      transition: var(--transition-normal);
    }

    .goal-card:hover {
      transform: translateY(-1px);
      box-shadow: var(--shadow-md);
    }

    .goal-card.completed {
      opacity: 0.9;
      background: var(--bg-muted);
    }

    .goal-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: var(--space-6);
    }

    .goal-info {
      flex: 1;
    }

    .goal-title {
      font-size: var(--text-xl);
      font-weight: var(--font-semibold);
      color: var(--text-primary);
      margin-bottom: var(--space-2);
    }

    .goal-description {
      color: var(--text-muted);
      font-size: var(--text-sm);
      margin: 0;
    }

    .goal-actions {
      display: flex;
      gap: var(--space-2);
    }

    .btn-icon {
      width: 40px;
      height: 40px;
      border-radius: var(--space-2);
      border: 1px solid var(--border-light);
      background: var(--bg-primary);
      color: var(--text-secondary);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: var(--text-lg);
      cursor: pointer;
      transition: var(--transition-fast);
      text-decoration: none;
    }

    .btn-icon:hover {
      transform: translateY(-1px);
      box-shadow: var(--shadow-sm);
    }

    .btn-icon-primary:hover {
      background: var(--primary-blue-50);
      border-color: var(--primary-blue);
      color: var(--primary-blue);
    }

    .btn-icon-secondary:hover {
      background: var(--neutral-100);
      border-color: var(--neutral-400);
      color: var(--neutral-600);
    }

    /* Goal Progress */
    .goal-progress {
      margin-bottom: var(--space-6);
    }

    .progress-info {
      display: flex;
      justify-content: space-between;
      align-items: baseline;
      margin-bottom: var(--space-3);
    }

    .progress-current {
      font-size: var(--text-xl);
      font-weight: var(--font-semibold);
      color: var(--text-primary);
    }

    .progress-target {
      color: var(--text-muted);
      font-size: var(--text-sm);
    }

    .progress-container {
      background: var(--bg-muted);
      border-radius: var(--space-2);
      height: 8px;
      overflow: hidden;
      margin-bottom: var(--space-2);
    }

    .progress-bar {
      height: 100%;
      border-radius: var(--space-2);
      transition: var(--transition-normal);
    }

    .progress-details {
      display: flex;
      justify-content: space-between;
      font-size: var(--text-xs);
      color: var(--text-muted);
    }

    /* Goal Meta */
    .goal-meta {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-top: var(--space-4);
      border-top: 1px solid var(--border-light);
    }

    .goal-priority {
      padding: var(--space-1) var(--space-3);
      border-radius: var(--space-2);
      font-size: var(--text-xs);
      font-weight: var(--font-medium);
    }

    .priority-low {
      background: var(--neutral-100);
      color: var(--neutral-600);
    }

    .priority-medium {
      background: #fef3c7;
      color: #92400e;
    }

    .priority-high {
      background: #fee2e2;
      color: #991b1b;
    }

    .goal-date {
      display: flex;
      align-items: center;
      gap: var(--space-1);
      font-size: var(--text-sm);
      color: var(--text-muted);
    }

    /* Completed Goals */
    .completion-badge {
      display: flex;
      align-items: center;
      gap: var(--space-2);
      color: var(--success-green);
      font-size: var(--text-sm);
      font-weight: var(--font-medium);
      margin-top: var(--space-2);
    }

    .goal-achievement {
      text-align: center;
      padding: var(--space-4) 0;
    }

    .achievement-amount {
      display: block;
      font-size: var(--text-2xl);
      font-weight: var(--font-bold);
      margin-bottom: var(--space-1);
    }

    .achievement-label {
      display: block;
      font-size: var(--text-sm);
      color: var(--text-muted);
    }

    /* Empty State */
    .empty-state {
      text-align: center;
      padding: var(--space-16) var(--space-8);
    }

    .empty-icon {
      font-size: 4rem;
      margin-bottom: var(--space-4);
      opacity: 0.5;
    }

    .empty-title {
      font-size: var(--text-xl);
      font-weight: var(--font-semibold);
      color: var(--text-primary);
      margin-bottom: var(--space-2);
    }

    .empty-description {
      color: var(--text-muted);
      margin-bottom: var(--space-6);
      max-width: 400px;
      margin-left: auto;
      margin-right: auto;
    }

    /* Modal Styles */
    .modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: var(--z-modal);
      backdrop-filter: blur(4px);
    }

    .modal-content {
      background: var(--bg-primary);
      border-radius: var(--space-4);
      width: 90%;
      max-width: 500px;
      max-height: 90vh;
      overflow-y: auto;
      box-shadow: var(--shadow-2xl);
    }

    .modal-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: var(--space-6);
      border-bottom: 1px solid var(--border-light);
    }

    .modal-title {
      font-size: var(--text-xl);
      font-weight: var(--font-semibold);
      color: var(--text-primary);
      margin: 0;
    }

    .modal-close {
      background: none;
      border: none;
      font-size: var(--text-2xl);
      cursor: pointer;
      color: var(--text-muted);
      width: 32px;
      height: 32px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: var(--space-1);
      transition: var(--transition-fast);
    }

    .modal-close:hover {
      color: var(--text-primary);
      background: var(--bg-muted);
    }

    .modal-body {
      padding: var(--space-6);
    }

    .modal-actions {
      display: flex;
      gap: var(--space-3);
      margin-top: var(--space-6);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .page-header-main {
        flex-direction: column;
        gap: var(--space-6);
        padding: var(--space-6);
      }

      .page-title {
        font-size: var(--text-3xl);
      }

      .page-icon {
        font-size: var(--text-3xl);
      }

      .page-actions {
        width: 100%;
        justify-content: center;
      }

      .btn-enhanced {
        flex: 1;
        justify-content: center;
        padding: var(--space-4) var(--space-5);
      }

      .page-header-stats {
        grid-template-columns: repeat(2, 1fr);
        padding: var(--space-4) var(--space-6);
        gap: var(--space-3);
      }

      .quick-stat {
        padding: var(--space-2);
      }

      .quick-stat-value {
        font-size: var(--text-base);
      }

      .page-breadcrumb {
        justify-content: center;
      }
    }

    @media (max-width: 480px) {
      .page-header-stats {
        grid-template-columns: 1fr;
      }

      .page-title {
        font-size: var(--text-2xl);
        flex-direction: column;
        text-align: center;
        gap: var(--space-2);
      }

      .page-subtitle {
        text-align: center;
      }
    }
  </style>

  <script>
    function openAddFundsModal(goalId) {
      const modal = document.getElementById('addFundsModal');
      const form = document.getElementById('addFundsForm');

      form.action = `/savings-goals/${goalId}/add-funds`;
      modal.style.display = 'flex';

      // Focus on amount input
      setTimeout(() => {
        document.getElementById('amount').focus();
      }, 100);
    }

    function closeAddFundsModal() {
      const modal = document.getElementById('addFundsModal');
      modal.style.display = 'none';

      // Reset form
      document.getElementById('addFundsForm').reset();
    }

    // Close modal when clicking outside
    document.getElementById('addFundsModal').addEventListener('click', function(e) {
      if (e.target === this) {
        closeAddFundsModal();
      }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        closeAddFundsModal();
      }
    });
  </script>
@endsection
