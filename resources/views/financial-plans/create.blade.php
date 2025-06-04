@extends('layouts.app')

@section('title', 'Create Financial Plan - Financial Management')
@section('meta-description', 'Create a comprehensive financial plan with income targets, savings goals, and investment
  strategies')

@section('page-header')
  <div class="page-header-content">
    <div class="header-title-section">
      <h1 class="page-title">
        <span class="title-icon">➕</span>
        Create Financial Plan
      </h1>
      <p class="page-subtitle">Set up your financial goals and parameters for success</p>
    </div>
  </div>
@endsection

@section('breadcrumbs')
  <a href="{{ route('financial-plans.index') }}" class="breadcrumb-item">📋 Financial Plans</a>
  <span class="breadcrumb-separator">›</span>
@endsection

@section('content')
  <!-- Enhanced Plan Creation Form -->
  <section class="form-section enhanced" data-aos="fade-up">
    <div class="section-wrapper form-wrapper">
      <header class="section-header form-header">
        <div class="header-left">
          <h2 class="section-title">
            <span class="title-icon">
              <span class="icon-emoji">📊</span>
              <div class="icon-glow"></div>
            </span>
            <span class="title-text">Plan Configuration</span>
          </h2>
          <p class="section-subtitle">Configure your financial plan parameters and goals</p>
        </div>
      </header>

      <form action="{{ route('financial-plans.store') }}" method="POST" class="enhanced-form" id="planForm">
        @csrf

        <!-- Basic Information Section -->
        <div class="form-section-group" data-aos="fade-up" data-aos-delay="200">
          <div class="form-group-header">
            <h3 class="group-title">
              <span class="group-icon">📝</span>
              Basic Information
            </h3>
            <p class="group-description">Start with your plan name and description</p>
          </div>

          <div class="form-fields-grid">
            <div class="form-row">
              <div class="form-group enhanced">
                <label for="name" class="form-label enhanced">
                  <span class="label-icon">📋</span>
                  <span class="label-text">Plan Name</span>
                  <span class="label-required">*</span>
                </label>
                <div class="input-group enhanced">
                  <input type="text" id="name" name="name" value="{{ old('name') }}"
                    class="form-input enhanced @error('name') error @enderror"
                    placeholder="e.g., 2024 Financial Master Plan" required>
                  <div class="input-focus-ring"></div>
                </div>
                @error('name')
                  <div class="error-message enhanced">
                    <span class="error-icon">⚠️</span>
                    <span class="error-text">{{ $message }}</span>
                  </div>
                @enderror
              </div>

              <div class="form-group enhanced">
                <label for="monthly_income" class="form-label enhanced">
                  <span class="label-icon">💰</span>
                  <span class="label-text">Monthly Income</span>
                  <span class="label-required">*</span>
                </label>
                <div class="input-group enhanced">
                  <span class="input-prefix">$</span>
                  <input type="number" id="monthly_income" name="monthly_income" value="{{ old('monthly_income') }}"
                    step="0.01" min="0" class="form-input enhanced @error('monthly_income') error @enderror"
                    placeholder="5000.00" required>
                  <div class="input-focus-ring"></div>
                </div>
                @error('monthly_income')
                  <div class="error-message enhanced">
                    <span class="error-icon">⚠️</span>
                    <span class="error-text">{{ $message }}</span>
                  </div>
                @enderror
              </div>
            </div>

            <div class="form-group enhanced full-width">
              <label for="description" class="form-label enhanced">
                <span class="label-icon">📝</span>
                <span class="label-text">Description</span>
                <span class="label-optional">(Optional)</span>
              </label>
              <div class="input-group enhanced">
                <textarea id="description" name="description" rows="3"
                  class="form-input enhanced @error('description') error @enderror"
                  placeholder="Describe your financial plan goals and strategy...">{{ old('description') }}</textarea>
                <div class="input-focus-ring"></div>
              </div>
              @error('description')
                <div class="error-message enhanced">
                  <span class="error-icon">⚠️</span>
                  <span class="error-text">{{ $message }}</span>
                </div>
              @enderror
            </div>
          </div>
        </div>

        <!-- Savings & Goals Section -->
        <div class="form-section-group" data-aos="fade-up" data-aos-delay="400">
          <div class="form-group-header">
            <h3 class="group-title">
              <span class="group-icon">🎯</span>
              Savings & Goals
            </h3>
            <p class="group-description">Define your savings targets and financial objectives</p>
          </div>

          <div class="form-fields-grid">
            <div class="form-row">
              <div class="form-group enhanced">
                <label for="monthly_savings_target" class="form-label enhanced">
                  <span class="label-icon">🎯</span>
                  <span class="label-text">Monthly Savings Target</span>
                  <span class="label-required">*</span>
                </label>
                <div class="input-group enhanced">
                  <span class="input-prefix">$</span>
                  <input type="number" id="monthly_savings_target" name="monthly_savings_target"
                    value="{{ old('monthly_savings_target') }}" step="0.01" min="0"
                    class="form-input enhanced @error('monthly_savings_target') error @enderror" placeholder="1000.00"
                    required>
                  <div class="input-focus-ring"></div>
                </div>
                <div class="form-help enhanced">
                  <span class="help-icon">💡</span>
                  <span class="help-text">Recommended: 20% of monthly income</span>
                </div>
                @error('monthly_savings_target')
                  <div class="error-message enhanced">
                    <span class="error-icon">⚠️</span>
                    <span class="error-text">{{ $message }}</span>
                  </div>
                @enderror
              </div>

              <div class="form-group enhanced">
                <label for="emergency_fund_target" class="form-label enhanced">
                  <span class="label-icon">🏦</span>
                  <span class="label-text">Emergency Fund Target</span>
                  <span class="label-optional">(Optional)</span>
                </label>
                <div class="input-group enhanced">
                  <span class="input-prefix">$</span>
                  <input type="number" id="emergency_fund_target" name="emergency_fund_target"
                    value="{{ old('emergency_fund_target') }}" step="0.01" min="0"
                    class="form-input enhanced @error('emergency_fund_target') error @enderror" placeholder="30000.00">
                  <div class="input-focus-ring"></div>
                </div>
                <div class="form-help enhanced">
                  <span class="help-icon">💡</span>
                  <span class="help-text">Recommended: 6 months of expenses</span>
                </div>
                @error('emergency_fund_target')
                  <div class="error-message enhanced">
                    <span class="error-icon">⚠️</span>
                    <span class="error-text">{{ $message }}</span>
                  </div>
                @enderror
              </div>
            </div>

            <!-- Savings Rate Calculator -->
            <div class="calculator-section enhanced" data-aos="fade-up" data-aos-delay="600">
              <div class="calculator-header">
                <h4 class="calculator-title">
                  <span class="calculator-icon">🧮</span>
                  Savings Rate Calculator
                </h4>
                <p class="calculator-description">See your savings rate in real-time</p>
              </div>
              <div class="calculator-display">
                <div class="rate-display">
                  <span class="rate-label">Your Savings Rate:</span>
                  <span class="rate-value" id="savingsRate">0%</span>
                </div>
                <div class="rate-indicator">
                  <div class="rate-bar">
                    <div class="rate-fill" id="rateBar" style="width: 0%"></div>
                  </div>
                  <div class="rate-benchmarks">
                    <span class="benchmark poor">0%</span>
                    <span class="benchmark average">10%</span>
                    <span class="benchmark good">20%</span>
                    <span class="benchmark excellent">30%</span>
                  </div>
                </div>
                <div class="rate-feedback" id="rateFeedback">
                  <span class="feedback-icon">📊</span>
                  <span class="feedback-text">Enter your income and savings target to see your rate</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Investment & Growth Section -->
        <div class="form-section-group" data-aos="fade-up" data-aos-delay="600">
          <div class="form-group-header">
            <h3 class="group-title">
              <span class="group-icon">📈</span>
              Investment & Growth
            </h3>
            <p class="group-description">Set your expected returns and inflation assumptions</p>
          </div>

          <div class="form-fields-grid">
            <div class="form-row">
              <div class="form-group enhanced">
                <label for="investment_return_rate" class="form-label enhanced">
                  <span class="label-icon">📈</span>
                  <span class="label-text">Expected Investment Return (%)</span>
                  <span class="label-optional">(Optional)</span>
                </label>
                <div class="input-group enhanced">
                  <span class="input-suffix">%</span>
                  <input type="number" id="investment_return_rate" name="investment_return_rate"
                    value="{{ old('investment_return_rate', '7.00') }}" step="0.01" min="0" max="100"
                    class="form-input enhanced @error('investment_return_rate') error @enderror" placeholder="7.00">
                  <div class="input-focus-ring"></div>
                </div>
                <div class="form-help enhanced">
                  <span class="help-icon">💡</span>
                  <span class="help-text">Historical stock market average: 7-10%</span>
                </div>
                @error('investment_return_rate')
                  <div class="error-message enhanced">
                    <span class="error-icon">⚠️</span>
                    <span class="error-text">{{ $message }}</span>
                  </div>
                @enderror
              </div>

              <div class="form-group enhanced">
                <label for="inflation_rate" class="form-label enhanced">
                  <span class="label-icon">📊</span>
                  <span class="label-text">Inflation Rate (%)</span>
                  <span class="label-optional">(Optional)</span>
                </label>
                <div class="input-group enhanced">
                  <span class="input-suffix">%</span>
                  <input type="number" id="inflation_rate" name="inflation_rate"
                    value="{{ old('inflation_rate', '3.00') }}" step="0.01" min="0" max="100"
                    class="form-input enhanced @error('inflation_rate') error @enderror" placeholder="3.00">
                  <div class="input-focus-ring"></div>
                </div>
                <div class="form-help enhanced">
                  <span class="help-icon">💡</span>
                  <span class="help-text">Current US average: 2-4%</span>
                </div>
                @error('inflation_rate')
                  <div class="error-message enhanced">
                    <span class="error-icon">⚠️</span>
                    <span class="error-text">{{ $message }}</span>
                  </div>
                @enderror
              </div>
            </div>
          </div>
        </div>

        <!-- Additional Expenses Section -->
        <div class="form-section-group" data-aos="fade-up" data-aos-delay="800">
          <div class="form-group-header">
            <h3 class="group-title">
              <span class="group-icon">🎓</span>
              Additional Expenses
            </h3>
            <p class="group-description">Include major future expenses in your planning</p>
          </div>

          <div class="form-fields-grid">
            <div class="form-row">
              <div class="form-group enhanced">
                <label for="tuition_costs" class="form-label enhanced">
                  <span class="label-icon">🎓</span>
                  <span class="label-text">Annual Tuition Costs</span>
                  <span class="label-optional">(Optional)</span>
                </label>
                <div class="input-group enhanced">
                  <span class="input-prefix">$</span>
                  <input type="number" id="tuition_costs" name="tuition_costs"
                    value="{{ old('tuition_costs', '0') }}" step="0.01" min="0"
                    class="form-input enhanced @error('tuition_costs') error @enderror" placeholder="25000.00">
                  <div class="input-focus-ring"></div>
                </div>
                @error('tuition_costs')
                  <div class="error-message enhanced">
                    <span class="error-icon">⚠️</span>
                    <span class="error-text">{{ $message }}</span>
                  </div>
                @enderror
              </div>

              <div class="form-group enhanced">
                <label for="living_costs" class="form-label enhanced">
                  <span class="label-icon">🏠</span>
                  <span class="label-text">Annual Living Costs</span>
                  <span class="label-optional">(Optional)</span>
                </label>
                <div class="input-group enhanced">
                  <span class="input-prefix">$</span>
                  <input type="number" id="living_costs" name="living_costs" value="{{ old('living_costs', '0') }}"
                    step="0.01" min="0" class="form-input enhanced @error('living_costs') error @enderror"
                    placeholder="15000.00">
                  <div class="input-focus-ring"></div>
                </div>
                @error('living_costs')
                  <div class="error-message enhanced">
                    <span class="error-icon">⚠️</span>
                    <span class="error-text">{{ $message }}</span>
                  </div>
                @enderror
              </div>
            </div>
          </div>
        </div>

        <!-- Enhanced Form Actions -->
        <div class="form-actions enhanced" data-aos="fade-up" data-aos-delay="1000">
          <div class="actions-wrapper">
            <button type="submit" class="action-btn primary large">
              <span class="btn-icon">💾</span>
              <span class="btn-text">Create Financial Plan</span>
              <div class="btn-shine"></div>
            </button>
            <a href="{{ route('financial-plans.index') }}" class="action-btn secondary large">
              <span class="btn-icon">↩️</span>
              <span class="btn-text">Cancel</span>
            </a>
          </div>
        </div>
      </form>
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

        // Enhanced form functionality
        const form = document.getElementById('planForm');
        const monthlyIncomeInput = document.getElementById('monthly_income');
        const savingsTargetInput = document.getElementById('monthly_savings_target');
        const savingsRateElement = document.getElementById('savingsRate');
        const rateBarElement = document.getElementById('rateBar');
        const rateFeedbackElement = document.getElementById('rateFeedback');

        // Real-time savings rate calculator
        function updateSavingsRate() {
          const monthlyIncome = parseFloat(monthlyIncomeInput.value) || 0;
          const savingsTarget = parseFloat(savingsTargetInput.value) || 0;

          if (monthlyIncome > 0) {
            const rate = (savingsTarget / monthlyIncome) * 100;
            savingsRateElement.textContent = rate.toFixed(1) + '%';
            rateBarElement.style.width = Math.min(rate, 100) + '%';

            // Update color based on rate
            const rateBar = rateBarElement;
            if (rate >= 20) {
              rateBar.style.background = 'linear-gradient(90deg, #10b981, #059669)';
              rateFeedbackElement.innerHTML =
                '<span class="feedback-icon">🎉</span><span class="feedback-text">Excellent savings rate!</span>';
              rateFeedbackElement.className = 'rate-feedback excellent';
            } else if (rate >= 10) {
              rateBar.style.background = 'linear-gradient(90deg, #f59e0b, #d97706)';
              rateFeedbackElement.innerHTML =
                '<span class="feedback-icon">👍</span><span class="feedback-text">Good savings rate</span>';
              rateFeedbackElement.className = 'rate-feedback good';
            } else if (rate > 0) {
              rateBar.style.background = 'linear-gradient(90deg, #ef4444, #dc2626)';
              rateFeedbackElement.innerHTML =
                '<span class="feedback-icon">⚠️</span><span class="feedback-text">Consider increasing your savings rate</span>';
              rateFeedbackElement.className = 'rate-feedback warning';
            } else {
              rateBar.style.background = 'linear-gradient(90deg, #6b7280, #4b5563)';
              rateFeedbackElement.innerHTML =
                '<span class="feedback-icon">📊</span><span class="feedback-text">Enter a savings target</span>';
              rateFeedbackElement.className = 'rate-feedback neutral';
            }
          } else {
            savingsRateElement.textContent = '0%';
            rateBarElement.style.width = '0%';
            rateFeedbackElement.innerHTML =
              '<span class="feedback-icon">📊</span><span class="feedback-text">Enter your monthly income</span>';
            rateFeedbackElement.className = 'rate-feedback neutral';
          }
        }

        // Enhanced form validation
        const inputs = form.querySelectorAll('.form-input');
        inputs.forEach(input => {
          input.addEventListener('blur', function() {
            validateField(this);
          });

          input.addEventListener('input', function() {
            if (this.classList.contains('error')) {
              validateField(this);
            }

            // Update savings rate for relevant fields
            if (this.id === 'monthly_income' || this.id === 'monthly_savings_target') {
              updateSavingsRate();
            }
          });
        });

        function validateField(field) {
          const value = field.value.trim();
          const isRequired = field.hasAttribute('required');

          if (isRequired && !value) {
            field.classList.add('error');
            showFieldError(field, 'This field is required');
          } else if (field.type === 'number' && value && parseFloat(value) < 0) {
            field.classList.add('error');
            showFieldError(field, 'Value must be positive');
          } else {
            field.classList.remove('error');
            hideFieldError(field);
          }
        }

        function showFieldError(field, message) {
          let errorEl = field.parentElement.parentElement.querySelector('.error-message');
          if (!errorEl) {
            errorEl = document.createElement('div');
            errorEl.className = 'error-message enhanced';
            errorEl.innerHTML = `<span class="error-icon">⚠️</span><span class="error-text">${message}</span>`;
            field.parentElement.parentElement.appendChild(errorEl);
          } else {
            errorEl.querySelector('.error-text').textContent = message;
          }
        }

        function hideFieldError(field) {
          const errorEl = field.parentElement.parentElement.querySelector('.error-message');
          if (errorEl) {
            errorEl.remove();
          }
        }

        // Enhanced form submission
        form.addEventListener('submit', function(e) {
          let hasErrors = false;

          inputs.forEach(input => {
            validateField(input);
            if (input.classList.contains('error')) {
              hasErrors = true;
            }
          });

          if (hasErrors) {
            e.preventDefault();
            const firstError = form.querySelector('.form-input.error');
            if (firstError) {
              firstError.focus();
              firstError.scrollIntoView({
                behavior: 'smooth',
                block: 'center'
              });
            }
          } else {
            // Add loading state
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.style.opacity = '0.6';
            submitBtn.style.pointerEvents = 'none';

            const originalContent = submitBtn.innerHTML;
            submitBtn.innerHTML =
              '<span class="loading-spinner mini"></span><span class="btn-text">Creating Plan...</span>';
          }
        });

        // Initialize savings rate calculator
        updateSavingsRate();

        // Auto-fill emergency fund based on income
        monthlyIncomeInput.addEventListener('change', function() {
          const emergencyFundInput = document.getElementById('emergency_fund_target');
          if (!emergencyFundInput.value && this.value) {
            const recommendedFund = parseFloat(this.value) * 6; // 6 months of income
            emergencyFundInput.value = recommendedFund.toFixed(2);
          }
        });

        // Auto-suggest savings target based on income
        monthlyIncomeInput.addEventListener('change', function() {
          const savingsInput = document.getElementById('monthly_savings_target');
          if (!savingsInput.value && this.value) {
            const recommendedSavings = parseFloat(this.value) * 0.2; // 20% of income
            savingsInput.value = recommendedSavings.toFixed(2);
            updateSavingsRate();
          }
        });
      });
    </script>
  @endpush

  <style>
    /* Enhanced styling specific to financial plans create page */
    .form-section.enhanced {
      background: linear-gradient(135deg, rgba(16, 185, 129, 0.03) 0%, rgba(59, 130, 246, 0.03) 100%);
      border-radius: 40px;
      padding: var(--space-xl);
      margin-bottom: var(--space-xl);
      border: 1px solid rgba(16, 185, 129, 0.15);
      box-shadow: var(--shadow-light);
    }

    .form-wrapper {
      max-width: 1000px;
      margin: 0 auto;
    }

    .form-section-group {
      margin-bottom: var(--space-xl);
      padding: var(--space-lg);
      background: var(--glass-bg);
      backdrop-filter: var(--blur-backdrop);
      border-radius: var(--space-6);
      border: 1px solid var(--glass-border);
    }

    .form-group-header {
      margin-bottom: var(--space-lg);
      text-align: center;
    }

    .group-title {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: var(--space-sm);
      font-size: var(--text-xl);
      font-weight: 700;
      color: var(--text-primary);
      margin-bottom: var(--space-sm);
    }

    .group-icon {
      font-size: var(--text-2xl);
    }

    .group-description {
      color: var(--text-muted);
      font-size: var(--text-sm);
      margin: 0;
    }

    .form-fields-grid {
      display: flex;
      flex-direction: column;
      gap: var(--space-lg);
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: var(--space-lg);
    }

    .form-group.enhanced {
      display: flex;
      flex-direction: column;
      gap: var(--space-sm);
      position: relative;
    }

    .form-group.enhanced.full-width {
      grid-column: 1 / -1;
    }

    .form-label.enhanced {
      display: flex;
      align-items: center;
      gap: var(--space-sm);
      font-size: var(--text-sm);
      font-weight: 600;
      color: var(--text-primary);
    }

    .label-icon {
      font-size: var(--text-base);
    }

    .label-required {
      color: var(--danger-red);
      font-weight: 700;
    }

    .label-optional {
      color: var(--text-muted);
      font-weight: 400;
      font-size: var(--text-xs);
    }

    .input-group.enhanced {
      position: relative;
    }

    .input-prefix,
    .input-suffix {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-muted);
      font-weight: 600;
      z-index: 2;
      font-size: var(--text-sm);
    }

    .input-prefix {
      left: var(--space-3);
    }

    .input-suffix {
      right: var(--space-3);
    }

    .input-group.enhanced .form-input[type="number"] {
      padding-left: var(--space-8);
    }

    .input-group.enhanced .form-input:has(+ .input-suffix) {
      padding-right: var(--space-8);
    }

    .form-input.enhanced {
      width: 100%;
      padding: var(--space-4);
      border: 2px solid var(--border-light);
      border-radius: var(--space-3);
      background: var(--glass-bg);
      backdrop-filter: var(--blur-backdrop);
      color: var(--text-primary);
      font-weight: 500;
      font-size: var(--text-base);
      transition: var(--transition-smooth);
      position: relative;
      z-index: 1;
    }

    .form-input.enhanced:focus {
      border-color: var(--primary-blue);
      background: rgba(255, 255, 255, 0.9);
      box-shadow: var(--shadow-focus);
      outline: none;
    }

    .form-input.enhanced.error {
      border-color: var(--danger-red);
      background: rgba(239, 68, 68, 0.05);
    }

    .input-focus-ring {
      position: absolute;
      inset: -2px;
      border-radius: var(--space-3);
      background: var(--primary-gradient);
      opacity: 0;
      transition: var(--transition-smooth);
      z-index: 0;
    }

    .form-input.enhanced:focus+.input-focus-ring {
      opacity: 0.1;
    }

    .form-help.enhanced {
      display: flex;
      align-items: center;
      gap: var(--space-1);
      margin-top: var(--space-2);
      font-size: var(--text-xs);
      color: var(--text-muted);
      font-weight: 500;
    }

    .help-icon {
      font-size: var(--text-sm);
    }

    /* Calculator Section */
    .calculator-section.enhanced {
      grid-column: 1 / -1;
      margin-top: var(--space-lg);
      padding: var(--space-lg);
      background: var(--glass-bg-medium);
      backdrop-filter: var(--blur-backdrop);
      border: 1px solid var(--glass-border-strong);
      border-radius: var(--space-4);
    }

    .calculator-header {
      text-align: center;
      margin-bottom: var(--space-lg);
    }

    .calculator-title {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: var(--space-2);
      font-size: var(--text-lg);
      font-weight: 700;
      color: var(--text-primary);
      margin-bottom: var(--space-2);
    }

    .calculator-icon {
      font-size: var(--text-xl);
    }

    .calculator-description {
      color: var(--text-muted);
      font-size: var(--text-sm);
      margin: 0;
    }

    .calculator-display {
      display: flex;
      flex-direction: column;
      gap: var(--space-4);
    }

    .rate-display {
      text-align: center;
      padding: var(--space-4);
      background: var(--glass-bg);
      border-radius: var(--space-3);
      border: 1px solid var(--glass-border);
    }

    .rate-label {
      display: block;
      font-size: var(--text-sm);
      color: var(--text-muted);
      font-weight: 600;
      margin-bottom: var(--space-2);
    }

    .rate-value {
      font-size: var(--text-3xl);
      font-weight: 800;
      color: var(--text-primary);
    }

    .rate-indicator {
      display: flex;
      flex-direction: column;
      gap: var(--space-2);
    }

    .rate-bar {
      height: 12px;
      background: var(--border-light);
      border-radius: 6px;
      overflow: hidden;
      position: relative;
    }

    .rate-fill {
      height: 100%;
      background: linear-gradient(90deg, #6b7280, #4b5563);
      border-radius: 6px;
      transition: width 0.5s ease-out;
      position: relative;
    }

    .rate-benchmarks {
      display: flex;
      justify-content: space-between;
      font-size: var(--text-xs);
      color: var(--text-muted);
      font-weight: 600;
    }

    .benchmark {
      padding: var(--space-1) var(--space-2);
      border-radius: var(--space-1);
      background: var(--glass-bg);
    }

    .benchmark.poor {
      color: var(--danger-red);
    }

    .benchmark.average {
      color: var(--warning-amber);
    }

    .benchmark.good {
      color: var(--success-green);
    }

    .benchmark.excellent {
      color: var(--primary-blue);
    }

    .rate-feedback {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: var(--space-2);
      padding: var(--space-3);
      border-radius: var(--space-3);
      font-size: var(--text-sm);
      font-weight: 600;
      transition: var(--transition-smooth);
    }

    .rate-feedback.neutral {
      background: var(--glass-bg);
      color: var(--text-muted);
    }

    .rate-feedback.warning {
      background: rgba(239, 68, 68, 0.1);
      color: var(--danger-red);
    }

    .rate-feedback.good {
      background: rgba(245, 158, 11, 0.1);
      color: var(--warning-amber);
    }

    .rate-feedback.excellent {
      background: rgba(16, 185, 129, 0.1);
      color: var(--success-green);
    }

    .feedback-icon {
      font-size: var(--text-base);
    }

    /* Enhanced form actions */
    .form-actions.enhanced {
      margin-top: var(--space-xl);
      padding-top: var(--space-xl);
      border-top: 2px solid var(--border-light);
    }

    .actions-wrapper {
      display: flex;
      gap: var(--space-lg);
      justify-content: center;
    }

    .action-btn.large {
      padding: var(--space-4) var(--space-8);
      font-size: var(--text-lg);
      position: relative;
      overflow: hidden;
    }

    .btn-shine {
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
      transition: left 0.6s ease;
    }

    .action-btn.primary:hover .btn-shine {
      left: 100%;
    }

    .error-message.enhanced {
      display: flex;
      align-items: center;
      gap: var(--space-sm);
      margin-top: var(--space-sm);
      padding: var(--space-sm) var(--space-md);
      background: rgba(239, 68, 68, 0.1);
      border: 1px solid rgba(239, 68, 68, 0.2);
      border-radius: var(--space-2);
      color: var(--danger-red);
      font-size: var(--text-sm);
      font-weight: 500;
    }

    .error-icon {
      flex-shrink: 0;
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
      .form-row {
        grid-template-columns: 1fr;
      }

      .actions-wrapper {
        flex-direction: column;
      }

      .action-btn.large {
        width: 100%;
        justify-content: center;
      }
    }

    @media (max-width: 640px) {
      .form-section-group {
        padding: var(--space-md);
      }

      .form-section.enhanced {
        padding: var(--space-lg);
      }

      .calculator-section.enhanced {
        padding: var(--space-md);
      }
    }
  </style>
@endsection
