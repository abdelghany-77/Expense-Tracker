@extends('layouts.app')

@section('title', 'Financial Reports')

@section('page-header')
  <div style="display: flex; justify-content: space-between; align-items: center;">
    <div>
      <h1 class="page-title">📈 Financial Reports</h1>
      <p class="page-subtitle">Analyze your financial patterns and trends</p>
    </div>
    <div class="report-filters">
      <select id="reportPeriod"
        style="background: var(--glass-bg-strong); border: 1px solid var(--glass-border); border-radius: var(--space-3); padding: var(--space-3) var(--space-4); color: var(--text-inverse); font-weight: 500;">
        <option value="month">This Month</option>
        <option value="quarter">This Quarter</option>
        <option value="year">This Year</option>
        <option value="all">All Time</option>
      </select>
    </div>
  </div>
@endsection

@section('breadcrumbs')
  <span class="breadcrumb-item">📈 Reports</span>
@endsection

@section('content')
  <!-- Key Metrics Overview -->
  <div
    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: var(--space-6); margin-bottom: var(--space-8);">
    <div class="content-card" style="padding: var(--space-6); text-align: center;">
      <div
        style="font-size: var(--text-3xl); font-weight: 800; color: var(--success-green); margin-bottom: var(--space-2);">
        ${{ number_format($metrics['total_income'], 2) }}
      </div>
      <div
        style="font-size: var(--text-lg); font-weight: 600; color: var(--text-primary); margin-bottom: var(--space-2);">
        Total Income
      </div>
      <div style="font-size: var(--text-sm); color: var(--success-green); font-weight: 500;">
        +{{ number_format($metrics['income_growth'], 1) }}% vs last period
      </div>
    </div>

    <div class="content-card" style="padding: var(--space-6); text-align: center;">
      <div style="font-size: var(--text-3xl); font-weight: 800; color: var(--danger-red); margin-bottom: var(--space-2);">
        ${{ number_format($metrics['total_expenses'], 2) }}
      </div>
      <div
        style="font-size: var(--text-lg); font-weight: 600; color: var(--text-primary); margin-bottom: var(--space-2);">
        Total Expenses
      </div>
      <div
        style="font-size: var(--text-sm); color: {{ $metrics['expense_growth'] >= 0 ? 'var(--danger-red)' : 'var(--success-green)' }}; font-weight: 500;">
        {{ $metrics['expense_growth'] >= 0 ? '+' : '' }}{{ number_format($metrics['expense_growth'], 1) }}% vs last period
      </div>
    </div>

    <div class="content-card" style="padding: var(--space-6); text-align: center;">
      <div
        style="font-size: var(--text-3xl); font-weight: 800; color: var(--primary-blue); margin-bottom: var(--space-2);">
        ${{ number_format($metrics['net_savings'], 2) }}
      </div>
      <div
        style="font-size: var(--text-lg); font-weight: 600; color: var(--text-primary); margin-bottom: var(--space-2);">
        Net Savings
      </div>
      <div
        style="font-size: var(--text-sm); color: {{ $metrics['savings_rate'] >= 20 ? 'var(--success-green)' : 'var(--warning-amber)' }}; font-weight: 500;">
        {{ number_format($metrics['savings_rate'], 1) }}% savings rate
      </div>
    </div>

    <div class="content-card" style="padding: var(--space-6); text-align: center;">
      <div
        style="font-size: var(--text-3xl); font-weight: 800; color: var(--accent-gold); margin-bottom: var(--space-2);">
        {{ number_format($metrics['transaction_count']) }}
      </div>
      <div
        style="font-size: var(--text-lg); font-weight: 600; color: var(--text-primary); margin-bottom: var(--space-2);">
        Transactions
      </div>
      <div style="font-size: var(--text-sm); color: var(--success-green); font-weight: 500;">
        ${{ number_format($metrics['avg_transaction'], 2) }} avg amount
      </div>
    </div>
  </div>

  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(500px, 1fr)); gap: var(--space-8);">
    <!-- Spending by Category -->
    <div class="content-card">
      <div class="content-card-header">
        <h3 class="content-card-title">📊 Spending by Category</h3>
        <div class="chart-controls">
          <button class="chart-control active" data-chart="doughnut">Doughnut</button>
          <button class="chart-control" data-chart="bar">Bar</button>
        </div>
      </div>
      <div class="chart-container enhanced">
        <div class="chart-background">
          <div class="radial-grid"></div>
        </div>
        <canvas id="categorySpendingChart" role="img" aria-label="Category spending breakdown chart"></canvas>
        <div class="chart-loading" id="categoryLoading" aria-live="polite">
          <div class="loading-spinner"></div>
          <p>Loading categories...</p>
        </div>
      </div>
      <div style="margin-top: var(--space-4);">
        @foreach ($categoryData as $category)
          <div class="category-item enhanced" style="--category-color: {{ $category['color'] }};">
            <div style="display: flex; align-items: center; gap: var(--space-3);">
              <span class="category-indicator" style="background-color: {{ $category['color'] }};"></span>
              <span style="font-weight: 500; color: var(--text-primary);">{{ $category['name'] }}</span>
            </div>
            <div style="text-align: right;">
              <span
                style="font-weight: 600; color: var(--text-primary);">${{ number_format($category['amount'], 2) }}</span>
              <span
                style="font-size: var(--text-sm); color: var(--text-muted); margin-left: var(--space-2);">{{ number_format($category['percentage'], 1) }}%</span>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- Monthly Trends -->
    <div class="content-card">
      <div class="content-card-header">
        <h3 class="content-card-title">📈 Monthly Trends</h3>
        <div class="chart-controls">
          <button class="chart-control active" data-view="combined">Combined</button>
          <button class="chart-control" data-view="separate">Separate</button>
        </div>
      </div>
      <div class="chart-container enhanced">
        <div class="chart-background">
          <div class="grid-lines"></div>
        </div>
        <canvas id="monthlyTrendsChart" role="img" aria-label="Monthly financial trends chart"></canvas>
        <div class="chart-loading" id="trendsLoading" aria-live="polite">
          <div class="loading-spinner"></div>
          <p>Loading trends...</p>
        </div>
      </div>
      <div style="display: flex; gap: var(--space-4); margin-top: var(--space-4); justify-content: center;">
        <div class="legend-item enhanced">
          <span class="legend-indicator"
            style="background: linear-gradient(90deg, var(--success-green), var(--success-green-light));"></span>
          <span>Income</span>
        </div>
        <div class="legend-item enhanced">
          <span class="legend-indicator"
            style="background: linear-gradient(90deg, var(--danger-red), var(--danger-red-light));"></span>
          <span>Expenses</span>
        </div>
        <div class="legend-item enhanced">
          <span class="legend-indicator"
            style="background: linear-gradient(90deg, var(--primary-blue), var(--primary-blue-light));"></span>
          <span>Net</span>
        </div>
      </div>
    </div>
  </div>

  <!-- Savings Goals Progress -->
  <div class="content-card">
    <div class="content-card-header">
      <h3 class="content-card-title">🎯 Savings Goals Progress</h3>
    </div>
    @if ($savingsGoals->count() > 0)
      <div style="display: grid; gap: var(--space-4);">
        @foreach ($savingsGoals as $goal)
          <div
            style="padding: var(--space-4); border: 1px solid var(--border-light); border-radius: var(--space-3); background: var(--bg-secondary);">
            <div
              style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-3);">
              <h4 style="margin: 0; font-size: var(--text-lg); font-weight: 600; color: var(--text-primary);">
                {{ $goal->name }}</h4>
              <span
                style="font-size: var(--text-sm); color: var(--text-muted);">${{ number_format($goal->target_amount, 2) }}
                target</span>
            </div>
            <div style="display: flex; align-items: center; gap: var(--space-4);">
              <div style="flex: 1; background-color: var(--neutral-200); border-radius: var(--space-2); height: 8px;">
                <div
                  style="width: {{ $goal->progress_percentage }}%; background-color: {{ $goal->color }}; height: 100%; border-radius: var(--space-2); transition: var(--transition-normal);">
                </div>
              </div>
              <span
                style="font-size: var(--text-sm); font-weight: 500; color: var(--text-muted); white-space: nowrap;">{{ number_format($goal->progress_percentage, 1) }}%</span>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div style="text-align: center; color: var(--text-muted); padding: var(--space-8);">
        <p>No savings goals yet. <a href="{{ route('savings-goals.create') }}"
            style="color: var(--primary-blue); text-decoration: none; font-weight: 600;">Create one now</a></p>
      </div>
    @endif
  </div>

  <!-- Budget vs Actual -->
  <div class="content-card">
    <div class="content-card-header">
      <h3 class="content-card-title">💰 Budget vs Actual Spending</h3>
      <div class="budget-summary">
        <div class="summary-item">
          <span class="summary-value">{{ count($budgetComparison) }}</span>
          <span class="summary-label">Categories</span>
        </div>
        <div class="summary-item">
          <span class="summary-value">${{ number_format(collect($budgetComparison)->sum('actual'), 2) }}</span>
          <span class="summary-label">Total Spent</span>
        </div>
      </div>
    </div>
    <div class="chart-container budget-chart-container">
      <canvas id="budgetComparisonChart" role="img"
        aria-label="Budget vs actual spending comparison chart"></canvas>
      <div class="chart-loading" id="budgetLoading" aria-live="polite">
        <div class="loading-spinner"></div>
        <p>Loading budget comparison...</p>
      </div>
    </div>
    <div style="display: grid; gap: var(--space-6); margin-top: var(--space-6);">
      @foreach ($budgetComparison as $budget)
        <div class="budget-item enhanced"
          style="--budget-color: {{ $budget['percentage'] > 100 ? 'var(--danger-red)' : ($budget['percentage'] > 80 ? 'var(--warning-amber)' : 'var(--success-green)') }};">
          <div
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-3);">
            <span style="font-weight: 600; color: var(--text-muted);">{{ $budget['category'] }}</span>
            <span style="font-size: var(--text-sm); color: var(--text-muted);">
              ${{ number_format($budget['actual'], 2) }} / ${{ number_format($budget['budget'], 2) }}
            </span>
          </div>
          <div class="progress-container enhanced">
            <div class="progress-track"></div>
            <div class="progress-bar animated"
              style="width: {{ min($budget['percentage'], 100) }}%; background: linear-gradient(90deg, {{ $budget['percentage'] > 100 ? 'var(--danger-red)' : ($budget['percentage'] > 80 ? 'var(--warning-amber)' : 'var(--success-green)') }}, {{ $budget['percentage'] > 100 ? 'var(--danger-red-light)' : ($budget['percentage'] > 80 ? 'var(--warning-amber-light)' : 'var(--success-green-light)') }});">
              <div class="progress-shine"></div>
            </div>
            @if ($budget['percentage'] > 100)
              <div class="progress-overflow" style="width: {{ min($budget['percentage'] - 100, 50) }}%;"></div>
            @endif
          </div>
          <div style="text-align: right; font-size: var(--text-sm); margin-top: var(--space-2);">
            @if ($budget['percentage'] > 100)
              <span style="color: var(--danger-red); font-weight: 500;">Over budget by
                ${{ number_format($budget['actual'] - $budget['budget'], 2) }}</span>
            @else
              <span style="color: var(--success-green); font-weight: 500;">Under budget by
                ${{ number_format($budget['budget'] - $budget['actual'], 2) }}</span>
            @endif
          </div>
        </div>
      @endforeach
    </div>
  </div>

  @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Chart.js default configurations
        Chart.defaults.font.family = 'Inter, -apple-system, BlinkMacSystemFont, sans-serif';
        Chart.defaults.color = '#64748b';
        Chart.defaults.borderColor = 'rgba(241, 245, 249, 0.3)';

        // Hide loading overlays after delay
        setTimeout(() => {
          document.querySelectorAll('.chart-loading').forEach(loading => {
            loading.style.display = 'none';
          });
          initializeCharts();
        }, 1000);

        // Chart controls functionality
        document.querySelectorAll('.chart-control').forEach(control => {
          control.addEventListener('click', function() {
            const container = this.closest('.content-card');
            container.querySelectorAll('.chart-control').forEach(c => c.classList.remove('active'));
            this.classList.add('active');

            if (this.dataset.chart) {
              updateCategoryChart(this.dataset.chart);
            } else if (this.dataset.view) {
              updateTrendsChart(this.dataset.view);
            }
          });
        });

        let categoryChart, trendsChart, budgetChart;

        function initializeCharts() {
          // Category spending chart
          const categoryData = @json($categoryData);
          if (categoryData.length > 0) {
            createCategoryChart(categoryData);
          }

          // Monthly trends chart
          const monthlyData = @json($monthlyTrends);
          if (monthlyData.length > 0) {
            createTrendsChart(monthlyData);
          }

          // Budget comparison chart
          const budgetData = @json($budgetComparison);
          if (budgetData.length > 0) {
            createBudgetChart(budgetData);
          }
        }

        function createCategoryChart(data) {
          const ctx = document.getElementById('categorySpendingChart');
          if (!ctx) return;

          const chartData = {
            labels: data.map(item => item.name),
            datasets: [{
              data: data.map(item => item.amount),
              backgroundColor: data.map(item => item.color),
              borderWidth: 3,
              borderColor: '#ffffff',
              hoverBorderWidth: 5,
              hoverOffset: 10
            }]
          };

          categoryChart = new Chart(ctx, {
            type: 'doughnut',
            data: chartData,
            options: {
              responsive: true,
              maintainAspectRatio: false,
              cutout: '65%',
              animation: {
                animateRotate: true,
                animateScale: true,
                duration: 1000,
                easing: 'easeOutQuart'
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
                  padding: 16,
                  titleFont: {
                    size: 14,
                    weight: 'bold'
                  },
                  bodyFont: {
                    size: 13
                  },
                  callbacks: {
                    label: function(context) {
                      const value = context.parsed;
                      const total = context.dataset.data.reduce((a, b) => a + b, 0);
                      const percentage = ((value / total) * 100).toFixed(1);
                      return `$${value.toLocaleString()} (${percentage}%)`;
                    }
                  }
                }
              },
              onHover: (event, activeElements) => {
                ctx.style.cursor = activeElements.length > 0 ? 'pointer' : 'default';
              }
            }
          });
        }

        function createTrendsChart(data) {
          const ctx = document.getElementById('monthlyTrendsChart');
          if (!ctx) return;

          const gradient1 = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
          gradient1.addColorStop(0, 'rgba(16, 185, 129, 0.3)');
          gradient1.addColorStop(1, 'rgba(16, 185, 129, 0.05)');

          const gradient2 = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
          gradient2.addColorStop(0, 'rgba(239, 68, 68, 0.3)');
          gradient2.addColorStop(1, 'rgba(239, 68, 68, 0.05)');

          const gradient3 = ctx.getContext('2d').createLinearGradient(0, 0, 0, 400);
          gradient3.addColorStop(0, 'rgba(59, 130, 246, 0.3)');
          gradient3.addColorStop(1, 'rgba(59, 130, 246, 0.05)');

          trendsChart = new Chart(ctx, {
            type: 'line',
            data: {
              labels: data.map(item => item.month),
              datasets: [{
                label: 'Income',
                data: data.map(item => item.income),
                borderColor: '#10b981',
                backgroundColor: gradient1,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#10b981',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 3,
                pointRadius: 6,
                pointHoverRadius: 10,
                pointHoverBackgroundColor: '#10b981',
                pointHoverBorderColor: '#ffffff',
                pointHoverBorderWidth: 3
              }, {
                label: 'Expenses',
                data: data.map(item => item.expenses),
                borderColor: '#ef4444',
                backgroundColor: gradient2,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#ef4444',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 3,
                pointRadius: 6,
                pointHoverRadius: 10,
                pointHoverBackgroundColor: '#ef4444',
                pointHoverBorderColor: '#ffffff',
                pointHoverBorderWidth: 3
              }, {
                label: 'Net',
                data: data.map(item => item.net),
                borderColor: '#3b82f6',
                backgroundColor: gradient3,
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#3b82f6',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 3,
                pointRadius: 6,
                pointHoverRadius: 10,
                pointHoverBackgroundColor: '#3b82f6',
                pointHoverBorderColor: '#ffffff',
                pointHoverBorderWidth: 3
              }]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              animation: {
                duration: 1500,
                easing: 'easeInOutQuart'
              },
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
                  padding: 16,
                  titleFont: {
                    size: 14,
                    weight: 'bold'
                  },
                  bodyFont: {
                    size: 13
                  },
                  callbacks: {
                    label: function(context) {
                      return `${context.dataset.label}: $${context.parsed.y.toLocaleString()}`;
                    }
                  }
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
                    },
                    color: '#64748b'
                  }
                },
                y: {
                  beginAtZero: true,
                  grid: {
                    color: 'rgba(241, 245, 249, 0.5)',
                    drawBorder: false
                  },
                  ticks: {
                    font: {
                      weight: 500
                    },
                    color: '#64748b',
                    callback: function(value) {
                      return '$' + value.toLocaleString();
                    }
                  }
                }
              }
            }
          });
        }

        function createBudgetChart(data) {
          const ctx = document.getElementById('budgetComparisonChart');
          if (!ctx) return;

          budgetChart = new Chart(ctx, {
            type: 'bar',
            data: {
              labels: data.map(item => item.category),
              datasets: [{
                label: 'Budget',
                data: data.map(item => item.budget),
                backgroundColor: 'rgba(148, 163, 184, 0.3)',
                borderColor: '#94a3b8',
                borderWidth: 2,
                borderRadius: 6,
                borderSkipped: false
              }, {
                label: 'Actual',
                data: data.map(item => item.actual),
                backgroundColor: data.map(item =>
                  item.percentage > 100 ? 'rgba(239, 68, 68, 0.8)' :
                  item.percentage > 80 ? 'rgba(245, 158, 11, 0.8)' :
                  'rgba(16, 185, 129, 0.8)'
                ),
                borderColor: data.map(item =>
                  item.percentage > 100 ? '#ef4444' :
                  item.percentage > 80 ? '#f59e0b' :
                  '#10b981'
                ),
                borderWidth: 2,
                borderRadius: 6,
                borderSkipped: false
              }]
            },
            options: {
              responsive: true,
              maintainAspectRatio: false,
              animation: {
                duration: 1200,
                easing: 'easeOutQuart'
              },
              plugins: {
                legend: {
                  position: 'top',
                  labels: {
                    usePointStyle: true,
                    pointStyle: 'rectRounded',
                    font: {
                      weight: 500
                    },
                    padding: 20
                  }
                },
                tooltip: {
                  backgroundColor: 'rgba(255, 255, 255, 0.95)',
                  titleColor: '#1e293b',
                  bodyColor: '#475569',
                  borderColor: 'rgba(102, 126, 234, 0.2)',
                  borderWidth: 1,
                  cornerRadius: 12,
                  padding: 16,
                  callbacks: {
                    label: function(context) {
                      return `${context.dataset.label}: $${context.parsed.y.toLocaleString()}`;
                    }
                  }
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
                    },
                    color: '#64748b'
                  }
                },
                y: {
                  beginAtZero: true,
                  grid: {
                    color: 'rgba(241, 245, 249, 0.5)',
                    drawBorder: false
                  },
                  ticks: {
                    font: {
                      weight: 500
                    },
                    color: '#64748b',
                    callback: function(value) {
                      return '$' + value.toLocaleString();
                    }
                  }
                }
              }
            }
          });
        }

        function updateCategoryChart(type) {
          if (!categoryChart) return;

          categoryChart.config.type = type;
          if (type === 'bar') {
            categoryChart.options.cutout = undefined;
            categoryChart.options.scales = {
              x: {
                grid: {
                  display: false
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
            };
          } else {
            categoryChart.options.cutout = '65%';
            categoryChart.options.scales = undefined;
          }
          categoryChart.update('active');
        }

        function updateTrendsChart(view) {
          if (!trendsChart) return;

          if (view === 'separate') {
            trendsChart.data.datasets.forEach((dataset, index) => {
              dataset.fill = false;
              dataset.backgroundColor = 'transparent';
            });
          } else {
            const ctx = trendsChart.ctx;
            const gradients = [
              createGradient(ctx, 'rgba(16, 185, 129, 0.3)', 'rgba(16, 185, 129, 0.05)'),
              createGradient(ctx, 'rgba(239, 68, 68, 0.3)', 'rgba(239, 68, 68, 0.05)'),
              createGradient(ctx, 'rgba(59, 130, 246, 0.3)', 'rgba(59, 130, 246, 0.05)')
            ];

            trendsChart.data.datasets.forEach((dataset, index) => {
              dataset.fill = true;
              dataset.backgroundColor = gradients[index];
            });
          }
          trendsChart.update('active');
        }

        function createGradient(ctx, colorStart, colorEnd) {
          const gradient = ctx.createLinearGradient(0, 0, 0, 400);
          gradient.addColorStop(0, colorStart);
          gradient.addColorStop(1, colorEnd);
          return gradient;
        }
      });
    </script>
  @endpush

  @push('styles')
    <style>
      /* Enhanced Chart Containers */
      .chart-container.enhanced {
        position: relative;
        height: 450px;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);
        border-radius: var(--space-4);
        padding: var(--space-6);
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        border: 1px solid var(--border-light);
        overflow: hidden;
      }

      .chart-container.enhanced::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, transparent 25%, rgba(255, 255, 255, 0.05) 25%, rgba(255, 255, 255, 0.05) 50%, transparent 50%, transparent 75%, rgba(255, 255, 255, 0.05) 75%);
        background-size: 20px 20px;
        pointer-events: none;
        opacity: 0.3;
      }

      .chart-background {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        opacity: 0.1;
      }

      .grid-lines {
        background-image:
          linear-gradient(rgba(59, 130, 246, 0.1) 1px, transparent 1px),
          linear-gradient(90deg, rgba(59, 130, 246, 0.1) 1px, transparent 1px);
        background-size: 40px 40px;
        height: 100%;
        width: 100%;
      }

      .radial-grid {
        background-image:
          radial-gradient(circle at 50% 50%, rgba(59, 130, 246, 0.1) 1px, transparent 1px);
        background-size: 30px 30px;
        height: 100%;
        width: 100%;
      }

      /* Chart Controls */
      .chart-controls {
        display: flex;
        gap: var(--space-2);
        background: var(--neutral-100);
        border-radius: var(--space-3);
        padding: var(--space-1);
      }

      .chart-control {
        background: transparent;
        border: none;
        padding: var(--space-2) var(--space-3);
        border-radius: var(--space-2);
        font-size: var(--text-sm);
        font-weight: 500;
        color: var(--text-muted);
        cursor: pointer;
        transition: var(--transition-normal);
      }

      .chart-control:hover {
        color: var(--text-primary);
        background: rgba(255, 255, 255, 0.7);
      }

      .chart-control.active {
        background: var(--primary-blue);
        color: var(--text-inverse);
        box-shadow: var(--shadow-sm);
      }

      /* Enhanced Category Items */
      .category-item.enhanced {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--space-4) 0;
        border-bottom: 1px solid var(--border-light);
        transition: var(--transition-normal);
        position: relative;
      }

      .category-item.enhanced:hover {
        background: linear-gradient(90deg, var(--category-color, var(--primary-blue))08, transparent);
        transform: translateX(var(--space-1));
      }

      .category-indicator {
        width: 16px;
        height: 16px;
        border-radius: 50%;
        box-shadow: 0 0 8px rgba(0, 0, 0, 0.2);
        position: relative;
      }

      .category-indicator::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 8px;
        height: 8px;
        background: rgba(255, 255, 255, 0.8);
        border-radius: 50%;
        transform: translate(-50%, -50%);
      }

      /* Enhanced Legend */
      .legend-item.enhanced {
        display: flex;
        align-items: center;
        gap: var(--space-2);
        font-size: var(--text-sm);
        font-weight: 500;
        padding: var(--space-2) var(--space-3);
        border-radius: var(--space-2);
        background: rgba(255, 255, 255, 0.5);
        border: 1px solid var(--border-light);
        transition: var(--transition-normal);
      }

      .legend-item.enhanced:hover {
        background: rgba(255, 255, 255, 0.8);
        transform: translateY(-1px);
        box-shadow: var(--shadow-sm);
      }

      .legend-indicator {
        width: 16px;
        height: 12px;
        border-radius: var(--space-1);
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
      }

      /* Enhanced Budget Items */
      .budget-item.enhanced {
        padding: var(--space-5);
        border: 1px solid var(--border-light);
        border-radius: var(--space-4);
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.9) 0%, rgba(255, 255, 255, 0.7) 100%);
        position: relative;
        overflow: hidden;
        transition: var(--transition-normal);
      }

      .budget-item.enhanced:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
        border-color: var(--budget-color, var(--primary-blue));
      }

      .budget-item.enhanced::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 4px;
        height: 100%;
        background: var(--budget-color, var(--primary-blue));
        transition: var(--transition-normal);
      }

      /* Enhanced Progress Bars */
      .progress-container.enhanced {
        background-color: var(--neutral-200);
        border-radius: var(--space-3);
        height: 12px;
        position: relative;
        overflow: hidden;
        box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.1);
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
        background: linear-gradient(90deg, #ef4444, #dc2626);
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

      /* Budget Chart Container */
      .budget-chart-container {
        height: 350px;
        margin-bottom: var(--space-6);
      }

      /* Summary Items */
      .budget-summary,
      .summary-item {
        display: flex;
        gap: var(--space-4);
        align-items: center;
      }

      .summary-item {
        flex-direction: column;
        text-align: center;
        padding: var(--space-3);
        background: rgba(255, 255, 255, 0.5);
        border-radius: var(--space-3);
        border: 1px solid var(--border-light);
      }

      .summary-value {
        font-size: var(--text-lg);
        font-weight: 700;
        color: var(--text-primary);
      }

      .summary-label {
        font-size: var(--text-sm);
        color: var(--text-muted);
        font-weight: 500;
      }

      /* Responsive adjustments */
      @media (max-width: 768px) {
        .chart-container.enhanced {
          height: 350px;
          padding: var(--space-4);
        }

        .chart-controls {
          gap: var(--space-1);
        }

        .chart-control {
          padding: var(--space-1) var(--space-2);
          font-size: var(--text-xs);
        }
      }
    </style>
  @endpush
@endsection
