@extends('layouts.app')

@section('title', 'Expense Categories')

@section('page-header')
  <div style="display: flex; justify-content: space-between; align-items: center;">
    <div>
      <h1 class="page-title">📂 Expense Categories</h1>
      <p class="page-subtitle">Organize your spending into categories</p>
    </div>
    <a href="{{ route('expense-categories.create') }}" class="action-btn primary">
      <span class="btn-icon">➕</span>
      <span class="btn-text">Add New Category</span>
    </a>
  </div>
@endsection

@section('breadcrumbs')
  <span class="breadcrumb-item">📂 Categories</span>
@endsection

@section('content')
  @if ($categories->count() > 0)
    <div class="content-card">
      <div class="content-card-header">
        <h3 class="content-card-title">Your Categories </h3>
        <div class="category-info">
          <br>
          <span style="color: var(--text-muted); font-size: var(--text-sm);">
            Drag and drop to reorder categories. Essential categories are marked with a star.
          </span>
        </div>
      </div>

      <div class="categories-list enhanced" id="categoriesList">
        @foreach ($categories as $category)
          <div class="category-item enhanced" data-id="{{ $category->id }}"
            style="--category-color: {{ $category->color }};">
            <div class="category-handle">
              <span class="handle-icon">⋮⋮</span>
            </div>

            <div class="category-info-section">
              <div class="category-icon-wrapper" style="background-color: {{ $category->color }};">
                <span class="category-icon">{{ $category->icon }}</span>
                <div class="icon-glow"></div>
              </div>

              <div class="category-details">
                <div class="category-name-section">
                  <h4 class="category-name " style="color:black ;">{{ $category->name }}</h4>
                  @if ($category->is_essential)
                    <span class="essential-badge" title="Essential Category">
                      <span class="badge-icon">⭐</span>
                      <span class="badge-text">Essential</span>
                    </span>
                  @endif
                </div>

                @if ($category->monthly_budget > 0)
                  <div class="category-budget enhanced">
                    <div class="budget-amounts">
                      <span class="budget-spent"
                        style="color:rgb(55, 61, 59) ;">${{ number_format($category->monthly_spent, 2) }}</span>
                      <span class="budget-separator">of</span>
                      <span class="budget-total">${{ number_format($category->monthly_budget, 2) }}</span>
                    </div>
                    <div class="budget-progress-container">
                      <div class="progress-track"></div>
                      <div class="progress-bar animated"
                        style="width: {{ min($category->budget_utilization, 100) }}%;
                              background: linear-gradient(90deg, {{ $category->budget_utilization > 100 ? 'var(--danger-red)' : ($category->budget_utilization > 80 ? 'var(--warning-amber)' : $category->color) }}, {{ $category->budget_utilization > 100 ? 'var(--danger-red-light)' : ($category->budget_utilization > 80 ? 'var(--warning-amber-light)' : $category->color . '80') }});">
                        <div class="progress-shine"></div>
                      </div>
                      @if ($category->budget_utilization > 100)
                        <div class="progress-overflow"
                          style="width: {{ min($category->budget_utilization - 100, 50) }}%;"></div>
                      @endif
                    </div>
                    <div class="budget-status">
                      <span class="budget-percentage">{{ number_format($category->budget_utilization, 1) }}%</span>
                      <span
                        class="budget-status-text {{ $category->budget_utilization > 100 ? 'over-budget' : ($category->budget_utilization > 80 ? 'warning' : 'on-track') }}">
                        {{ $category->budget_utilization > 100 ? 'Over Budget' : ($category->budget_utilization > 80 ? 'Near Limit' : 'On Track') }}
                      </span>
                    </div>
                  </div>
                @else
                  <div class="category-spent">
                    <span class="spent-label">This month:</span>
                    <span class="spent-amount">${{ number_format($category->monthly_spent, 2) }}</span>
                  </div>
                @endif
              </div>
            </div>

            <div class="category-actions enhanced">
              <button class="action-btn mini" title="View {{ $category->name }}"
                onclick="window.location.href='{{ route('expense-categories.show', $category) }}'">
                <span class="action-icon">👁️</span>
              </button>
              <button class="action-btn mini edit" title="Edit {{ $category->name }}"
                onclick="window.location.href='{{ route('expense-categories.edit', $category) }}'">
                <span class="action-icon">✏️</span>
              </button>
              <form action="{{ route('expense-categories.destroy', $category) }}" method="POST" style="display: inline;"
                onsubmit="return confirm('Are you sure? This will unassign all transactions from this category.')">
                @csrf
                @method('DELETE')
                <button type="submit" class="action-btn mini delete" title="Delete {{ $category->name }}">
                  <span class="action-icon">🗑️</span>
                </button>
              </form>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- Category Statistics -->
    <div class="metrics-grid">
      <article class="metric-card categories" data-aos="fade-up" data-aos-delay="100">
        <div class="metric-icon">
          <span class="icon-emoji">📊</span>
          <div class="icon-bg"></div>
        </div>
        <div class="metric-content">
          <div class="metric-value">{{ $categories->count() }}</div>
          <h3 class="metric-label">Total Categories</h3>
          <div class="metric-trend positive">
            <span class="trend-icon">📈</span>
            <span class="trend-text">Active categories</span>
          </div>
        </div>
        <div class="metric-overlay"></div>
      </article>

      <article class="metric-card essential" data-aos="fade-up" data-aos-delay="200">
        <div class="metric-icon">
          <span class="icon-emoji">⭐</span>
          <div class="icon-bg"></div>
        </div>
        <div class="metric-content">
          <div class="metric-value">{{ $categories->where('is_essential', true)->count() }}</div>
          <h3 class="metric-label">Essential Categories</h3>
          <div class="metric-trend warning">
            <span class="trend-icon">💡</span>
            <span class="trend-text">Must-have expenses</span>
          </div>
        </div>
        <div class="metric-overlay"></div>
      </article>

      <article class="metric-card budget" data-aos="fade-up" data-aos-delay="300">
        <div class="metric-icon">
          <span class="icon-emoji">💰</span>
          <div class="icon-bg"></div>
        </div>
        <div class="metric-content">
          <div class="metric-value">${{ number_format($categories->sum('monthly_budget'), 2) }}</div>
          <h3 class="metric-label">Total Monthly Budget</h3>
          <div class="metric-trend positive">
            <span class="trend-icon">🎯</span>
            <span class="trend-text">Planned spending</span>
          </div } </div>
          <div class="metric-overlay"></div>
      </article>
    </div>
  @else
    <div class="empty-state enhanced">
      <div class="empty-state-content">
        <div class="empty-state-icon">📂</div>
        <h3 class="empty-state-title">No Categories Yet</h3>
        <p class="empty-state-description">
          Create your first expense category to start organizing your spending.
        </p>
        <a href="{{ route('expense-categories.create') }}" class="action-btn primary large">
          <span class="btn-icon">➕</span>
          <span class="btn-text">Create Your First Category</span>
        </a>
      </div>
    </div>
  @endif

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const categoriesList = document.getElementById('categoriesList');
        let draggedElement = null;

        // Add drag and drop functionality
        if (categoriesList) {
          categoriesList.addEventListener('dragstart', function(e) {
            if (e.target.classList.contains('category-item')) {
              draggedElement = e.target;
              e.target.classList.add('dragging');
            }
          });

          categoriesList.addEventListener('dragend', function(e) {
            if (e.target.classList.contains('category-item')) {
              e.target.classList.remove('dragging');
              draggedElement = null;
            }
          });

          categoriesList.addEventListener('dragover', function(e) {
            e.preventDefault();
            const afterElement = getDragAfterElement(categoriesList, e.clientY);
            if (afterElement == null) {
              categoriesList.appendChild(draggedElement);
            } else {
              categoriesList.insertBefore(draggedElement, afterElement);
            }
          });

          categoriesList.addEventListener('drop', function(e) {
            e.preventDefault();
            updateCategoryOrder();
          });

          // Make category items draggable
          document.querySelectorAll('.category-item').forEach(item => {
            item.setAttribute('draggable', true);
          });
        }

        function getDragAfterElement(container, y) {
          const draggableElements = [...container.querySelectorAll('.category-item:not(.dragging)')];

          return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect();
            const offset = y - box.top - box.height / 2;

            if (offset < 0 && offset > closest.offset) {
              return {
                offset: offset,
                element: child
              };
            } else {
              return closest;
            }
          }, {
            offset: Number.NEGATIVE_INFINITY
          }).element;
        }

        function updateCategoryOrder() {
          const categoryIds = Array.from(document.querySelectorAll('.category-item')).map(item =>
            parseInt(item.getAttribute('data-id'))
          );

          fetch('{{ route('expense-categories.index') }}/update-order', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
              },
              body: JSON.stringify({
                categories: categoryIds
              })
            })
            .then(response => response.json())
            .then(data => {
              if (data.success) {
                console.log('Category order updated successfully');
              }
            })
            .catch(error => {
              console.error('Error updating category order:', error);
            });
        }
      });
    </script>
  @endpush

  @push('styles')
    <style>
      /* Enhanced Categories List */
      .categories-list.enhanced {
        display: grid;
        gap: var(--space-4);
        margin-top: var(--space-6);
      }

      .category-item.enhanced {
        display: flex;
        align-items: center;
        gap: var(--space-4);
        padding: var(--space-5);
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);
        border: 1px solid var(--border-light);
        border-radius: var(--space-4);
        transition: var(--transition-normal);
        cursor: move;
        position: relative;
        overflow: hidden;
      }

      .category-item.enhanced:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        border-color: var(--category-color, var(--primary-blue));
      }

      .category-item.enhanced.dragging {
        opacity: 0.5;
        transform: rotate(2deg) scale(1.02);
        box-shadow: var(--shadow-2xl);
      }

      .category-item.enhanced::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--category-color, var(--primary-blue));
        transition: var(--transition-normal);
      }

      .category-handle {
        color: var(--text-muted);
        cursor: grab;
        padding: var(--space-2);
        border-radius: var(--space-2);
        transition: var(--transition-fast);
      }

      .category-handle:hover {
        background: rgba(var(--category-color, 59, 130, 246), 0.1);
        color: var(--category-color, var(--primary-blue));
      }

      .category-handle:active {
        cursor: grabbing;
      }

      .handle-icon {
        font-weight: bold;
        font-size: var(--text-lg);
      }

      .category-icon-wrapper {
        width: 50px;
        height: 50px;
        border-radius: var(--space-3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: var(--text-xl);
        color: var(--text-inverse);
        font-weight: bold;
        position: relative;
        box-shadow: var(--shadow-md);
      }

      .category-icon-wrapper .icon-glow {
        position: absolute;
        inset: -2px;
        border-radius: var(--space-3);
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
        opacity: 0;
        transition: var(--transition-normal);
      }

      .category-item.enhanced:hover .icon-glow {
        opacity: 1;
      }

      .category-info-section {
        display: flex;
        align-items: center;
        gap: var(--space-4);
        flex: 1;
      }

      .category-details {
        flex: 1;
      }

      .category-name-section {
        display: flex;
        align-items: center;
        gap: var(--space-3);
        margin-bottom: var(--space-2);
      }

      .category-name {
        font-weight: 600;
        font-size: var(--text-lg);
        color: var(--text-primary);
        margin: 0;
      }

      .essential-badge {
        display: flex;
        align-items: center;
        gap: var(--space-1);
        background: linear-gradient(135deg, var(--accent-gold) 0%, var(--accent-gold-dark) 100%);
        color: var(--text-inverse);
        padding: var(--space-1) var(--space-2);
        border-radius: var(--space-2);
        font-size: var(--text-xs);
        font-weight: 600;
        box-shadow: var(--shadow-sm);
      }

      .badge-icon {
        font-size: var(--text-sm);
      }

      /* Enhanced Budget Display */
      .category-budget.enhanced {
        display: flex;
        flex-direction: column;
        gap: var(--space-2);
      }

      .budget-amounts {
        display: flex;
        align-items: center;
        gap: var(--space-2);
        font-size: var(--text-sm);
      }

      .budget-spent {
        font-weight: 600;
        color: var(--text-primary);
      }

      .budget-separator {
        color: var(--text-muted);
      }

      .budget-total {
        color: var(--text-muted);
      }

      .budget-progress-container {
        position: relative;
        height: 8px;
        background: var(--neutral-200);
        border-radius: var(--space-2);
        overflow: hidden;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
      }

      .progress-track {
        position: absolute;
        inset: 0;
        background: var(--neutral-200);
        border-radius: var(--space-2);
      }

      .progress-bar.animated {
        height: 100%;
        border-radius: var(--space-2);
        position: relative;
        transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
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
        border-radius: var(--space-2);
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

      .budget-status {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: var(--text-xs);
      }

      .budget-percentage {
        font-weight: 600;
        color: var(--text-muted);
      }

      .budget-status-text.on-track {
        color: var(--success-green);
      }

      .budget-status-text.warning {
        color: var(--warning-amber);
      }

      .budget-status-text.over-budget {
        color: var(--danger-red);
      }

      .category-spent {
        font-size: var(--text-sm);
        color: var(--text-muted);
      }

      .spent-label {
        margin-right: var(--space-1);
      }

      .spent-amount {
        font-weight: 600;
        color: var(--text-primary);
      }

      /* Enhanced Actions */
      .category-actions.enhanced {
        display: flex;
        gap: var(--space-2);
        align-items: center;
      }

      /* Enhanced Empty State */
      .empty-state.enhanced {
        text-align: center;
        padding: var(--space-20) var(--space-8);
        background: var(--glass-bg-strong);
        backdrop-filter: var(--glass-backdrop);
        border: 1px solid var(--glass-border);
        border-radius: var(--space-6);
        box-shadow: var(--shadow-lg);
      }

      .empty-state-content {
        max-width: 400px;
        margin: 0 auto;
      }

      .empty-state-icon {
        font-size: var(--text-6xl);
        margin-bottom: var(--space-6);
        opacity: 0.8;
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

      /* Responsive Design */
      @media (max-width: 768px) {
        .category-item.enhanced {
          flex-direction: column;
          align-items: flex-start;
          gap: var(--space-3);
          padding: var(--space-4);
        }

        .category-info-section {
          width: 100%;
        }

        .category-actions.enhanced {
          width: 100%;
          justify-content: flex-end;
        }

        .budget-amounts {
          flex-wrap: wrap;
        }
      }
    </style>
  @endpush
@endsection
