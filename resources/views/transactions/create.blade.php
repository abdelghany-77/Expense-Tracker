@extends('layouts.app')

@section('title', 'Add Transaction - Financial Management')
@section('meta-description', 'Add a new financial transaction including income, expenses, savings, or investments')

@section('page-header')
  <div class="page-header-content">
    <div class="header-title-section">
      <h1 class="page-title">
        <span class="title-icon">➕</span>
        Add New Transaction
      </h1>
      <p class="page-subtitle">Record your income, expenses, savings, or investments</p>
    </div>
  </div>
@endsection

@section('breadcrumbs')
  <a href="{{ route('transactions.index') }}" class="breadcrumb-item">💳 Transactions</a>
  <span class="breadcrumb-separator">›</span>
@endsection

@section('content')
  <!-- Enhanced Transaction Form -->
  <section class="form-section enhanced" data-aos="fade-up">
    <div class="section-wrapper form-wrapper">
      <header class="section-header form-header">
        <div class="header-left">
          <h2 class="section-title">
            <span class="title-icon">
              <span class="icon-emoji">📝</span>
              <div class="icon-glow"></div>
            </span>
            <span class="title-text">Transaction Details</span>
          </h2>
          <p class="section-subtitle">Fill in the information below to record your transaction</p>
        </div>
      </header>

      <form action="{{ route('transactions.store') }}" method="POST" class="enhanced-form">
        @csrf

        <!-- Enhanced Transaction Type Selection -->
        <div class="form-section-group" data-aos="fade-up" data-aos-delay="200">
          <div class="form-group-header">
            <h3 class="group-title">
              <span class="group-icon">🏷️</span>
              Transaction Type
            </h3>
            <p class="group-description">Select the type of financial transaction</p>
          </div>

          <div class="type-selector enhanced">
            <label class="type-option" data-aos="zoom-in" data-aos-delay="300">
              <input type="radio" name="type" value="expense"
                {{ old('type', request('category') ? 'expense' : 'expense') === 'expense' ? 'checked' : '' }}>
              <div class="type-card type-expense enhanced">
                <div class="type-icon-wrapper">
                  <div class="type-icon">💸</div>
                  <div class="icon-background"></div>
                </div>
                <div class="type-content">
                  <div class="type-label">Expense</div>
                  <div class="type-desc">Money you spent</div>
                </div>
                <div class="type-indicator"></div>
              </div>
            </label>

            <label class="type-option" data-aos="zoom-in" data-aos-delay="400">
              <input type="radio" name="type" value="income" {{ old('type') === 'income' ? 'checked' : '' }}>
              <div class="type-card type-income enhanced">
                <div class="type-icon-wrapper">
                  <div class="type-icon">💰</div>
                  <div class="icon-background"></div>
                </div>
                <div class="type-content">
                  <div class="type-label">Income</div>
                  <div class="type-desc">Money you earned</div>
                </div>
                <div class="type-indicator"></div>
              </div>
            </label>

            <label class="type-option" data-aos="zoom-in" data-aos-delay="500">
              <input type="radio" name="type" value="savings" {{ old('type') === 'savings' ? 'checked' : '' }}>
              <div class="type-card type-savings enhanced">
                <div class="type-icon-wrapper">
                  <div class="type-icon">🏦</div>
                  <div class="icon-background"></div>
                </div>
                <div class="type-content">
                  <div class="type-label">Savings</div>
                  <div class="type-desc">Money you saved</div>
                </div>
                <div class="type-indicator"></div>
              </div>
            </label>

            <label class="type-option" data-aos="zoom-in" data-aos-delay="600">
              <input type="radio" name="type" value="investment" {{ old('type') === 'investment' ? 'checked' : '' }}>
              <div class="type-card type-investment enhanced">
                <div class="type-icon-wrapper">
                  <div class="type-icon">📈</div>
                  <div class="icon-background"></div>
                </div>
                <div class="type-content">
                  <div class="type-label">Investment</div>
                  <div class="type-desc">Money you invested</div>
                </div>
                <div class="type-indicator"></div>
              </div>
            </label>
          </div>

          @error('type')
            <div class="error-message enhanced">
              <span class="error-icon">⚠️</span>
              <span class="error-text">{{ $message }}</span>
            </div>
          @enderror
        </div>

        <!-- Enhanced Form Fields -->
        <div class="form-fields-grid" data-aos="fade-up" data-aos-delay="700">
          <div class="form-row">
            <div class="form-group enhanced">
              <label for="amount" class="form-label enhanced">
                <span class="label-icon">💵</span>
                <span class="label-text">Amount</span>
                <span class="label-required">*</span>
              </label>
              <div class="input-group enhanced">
                <span class="input-prefix">$</span>
                <input type="number" id="amount" name="amount" value="{{ old('amount') }}"
                  step="0.01" min="0" class="form-input enhanced @error('amount') error @enderror"
                  placeholder="0.00" required>
                <div class="input-focus-ring"></div>
              </div>
              @error('amount')
                <div class="error-message enhanced">
                  <span class="error-icon">⚠️</span>
                  <span class="error-text">{{ $message }}</span>
                </div>
              @enderror
            </div>

            <div class="form-group enhanced">
              <label for="transaction_date" class="form-label enhanced">
                <span class="label-icon">📅</span>
                <span class="label-text">Date</span>
                <span class="label-required">*</span>
              </label>
              <div class="input-group enhanced">
                <input type="date" id="transaction_date" name="transaction_date"
                  value="{{ old('transaction_date', date('Y-m-d')) }}"
                  class="form-input enhanced @error('transaction_date') error @enderror" required>
                <div class="input-focus-ring"></div>
              </div>
              @error('transaction_date')
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
              <span class="label-required">*</span>
            </label>
            <div class="input-group enhanced">
              <input type="text" id="description" name="description" value="{{ old('description') }}"
                class="form-input enhanced @error('description') error @enderror"
                placeholder="e.g., Grocery shopping at Walmart" required>
              <div class="input-focus-ring"></div>
            </div>
            @error('description')
              <div class="error-message enhanced">
                <span class="error-icon">⚠️</span>
                <span class="error-text">{{ $message }}</span>
              </div>
            @enderror
          </div>

          <div class="form-row">
            <div class="form-group enhanced category-group">
              <label for="expense_category_id" class="form-label enhanced">
                <span class="label-icon">📂</span>
                <span class="label-text">Category</span>
              </label>
              <div class="input-group enhanced">
                <select id="expense_category_id" name="expense_category_id" class="form-input enhanced">
                  <option value="">Select Category</option>
                  @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                      {{ old('expense_category_id', request('category')) == $category->id ? 'selected' : '' }}>
                      {{ $category->icon }} {{ $category->name }}
                    </option>
                  @endforeach
                </select>
                <div class="input-focus-ring"></div>
              </div>
            </div>

            <div class="form-group enhanced">
              <label for="payment_method" class="form-label enhanced">
                <span class="label-icon">💳</span>
                <span class="label-text">Payment Method</span>
              </label>
              <div class="input-group enhanced">
                <select id="payment_method" name="payment_method" class="form-input enhanced">
                  <option value="">Select Method</option>
                  <option value="cash" {{ old('payment_method') === 'cash' ? 'selected' : '' }}>💵 Cash</option>
                  <option value="credit_card" {{ old('payment_method') === 'credit_card' ? 'selected' : '' }}>💳 Credit Card</option>
                  <option value="debit_card" {{ old('payment_method') === 'debit_card' ? 'selected' : '' }}>🏧 Debit Card</option>
                  <option value="bank_transfer" {{ old('payment_method') === 'bank_transfer' ? 'selected' : '' }}>🏦 Bank Transfer</option>
                  <option value="mobile_payment" {{ old('payment_method') === 'mobile_payment' ? 'selected' : '' }}>📱 Mobile Payment</option>
                  <option value="check" {{ old('payment_method') === 'check' ? 'selected' : '' }}>📝 Check</option>
                </select>
                <div class="input-focus-ring"></div>
              </div>
            </div>
          </div>

          <div class="form-group enhanced full-width">
            <label for="notes" class="form-label enhanced">
              <span class="label-icon">📋</span>
              <span class="label-text">Notes</span>
              <span class="label-optional">(Optional)</span>
            </label>
            <div class="input-group enhanced">
              <textarea id="notes" name="notes" rows="3" class="form-input enhanced"
                placeholder="Additional details about this transaction...">{{ old('notes') }}</textarea>
              <div class="input-focus-ring"></div>
            </div>
          </div>

          <!-- Enhanced Recurring Options -->
          <div class="form-group enhanced full-width recurring-section" data-aos="fade-up" data-aos-delay="800">
            <div class="checkbox-wrapper enhanced">
              <label class="checkbox-label enhanced">
                <input type="checkbox" id="is_recurring" name="is_recurring" value="1"
                  {{ old('is_recurring') ? 'checked' : '' }} class="checkbox-input enhanced">
                <span class="checkmark enhanced">
                  <span class="check-icon">✓</span>
                </span>
                <span class="checkbox-text">
                  <span class="checkbox-title">Recurring Transaction</span>
                  <span class="checkbox-desc">Set this transaction to repeat automatically</span>
                </span>
              </label>
            </div>

            <div class="recurring-options enhanced" style="display: none;">
              <div class="form-group enhanced">
                <label for="recurring_frequency" class="form-label enhanced">
                  <span class="label-icon">🔄</span>
                  <span class="label-text">Frequency</span>
                </label>
                <div class="input-group enhanced">
                  <select id="recurring_frequency" name="recurring_frequency" class="form-input enhanced">
                    <option value="weekly" {{ old('recurring_frequency') === 'weekly' ? 'selected' : '' }}>📅 Weekly</option>
                    <option value="monthly" {{ old('recurring_frequency', 'monthly') === 'monthly' ? 'selected' : '' }}>🗓️ Monthly</option>
                    <option value="yearly" {{ old('recurring_frequency') === 'yearly' ? 'selected' : '' }}>📆 Yearly</option>
                  </select>
                  <div class="input-focus-ring"></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Enhanced Form Actions -->
        <div class="form-actions enhanced" data-aos="fade-up" data-aos-delay="900">
          <div class="actions-wrapper">
            <button type="submit" class="action-btn primary large">
              <span class="btn-icon">💾</span>
              <span class="btn-text">Save Transaction</span>
              <div class="btn-shine"></div>
            </button>
            <a href="{{ route('transactions.index') }}" class="action-btn secondary large">
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

        const typeRadios = document.querySelectorAll('input[name="type"]');
        const categoryGroup = document.querySelector('.category-group');
        const recurringCheckbox = document.getElementById('is_recurring');
        const recurringOptions = document.querySelector('.recurring-options');

        // Enhanced type selection with animations
        function updateCategoryVisibility() {
          const selectedType = document.querySelector('input[name="type"]:checked')?.value;

          if (selectedType === 'expense') {
            categoryGroup.style.display = 'block';
            categoryGroup.style.opacity = '0';
            setTimeout(() => {
              categoryGroup.style.opacity = '1';
              categoryGroup.style.transform = 'translateY(0)';
            }, 100);
          } else {
            categoryGroup.style.opacity = '0';
            categoryGroup.style.transform = 'translateY(-10px)';
            setTimeout(() => {
              categoryGroup.style.display = 'none';
            }, 300);
          }
        }

        // Enhanced type card interactions
        typeRadios.forEach(radio => {
          radio.addEventListener('change', function() {
            // Remove active state from all cards
            document.querySelectorAll('.type-card').forEach(card => {
              card.classList.remove('active');
            });

            // Add active state to selected card
            this.parentElement.querySelector('.type-card').classList.add('active');

            updateCategoryVisibility();
          });
        });

        // Enhanced recurring options
        recurringCheckbox.addEventListener('change', function() {
          if (this.checked) {
            recurringOptions.style.display = 'block';
            setTimeout(() => {
              recurringOptions.style.opacity = '1';
              recurringOptions.style.transform = 'translateY(0)';
            }, 100);
          } else {
            recurringOptions.style.opacity = '0';
            recurringOptions.style.transform = 'translateY(-10px)';
            setTimeout(() => {
              recurringOptions.style.display = 'none';
            }, 300);
          }
        });

        // Enhanced form validation
        const form = document.querySelector('.enhanced-form');
        const inputs = form.querySelectorAll('.form-input');

        inputs.forEach(input => {
          input.addEventListener('blur', function() {
            validateField(this);
          });

          input.addEventListener('input', function() {
            if (this.classList.contains('error')) {
              validateField(this);
            }
          });
        });

        function validateField(field) {
          const value = field.value.trim();
          const isRequired = field.hasAttribute('required');

          if (isRequired && !value) {
            field.classList.add('error');
            showFieldError(field, 'This field is required');
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
          }
        }

        function hideFieldError(field) {
          const errorEl = field.parentElement.parentElement.querySelector('.error-message');
          if (errorEl) {
            errorEl.remove();
          }
        }

        // Initialize on page load
        updateCategoryVisibility();
        if (recurringCheckbox.checked) {
          recurringOptions.style.display = 'block';
          recurringOptions.style.opacity = '1';
        }

        // Set initial active state for pre-selected type
        const checkedType = document.querySelector('input[name="type"]:checked');
        if (checkedType) {
          checkedType.parentElement.querySelector('.type-card').classList.add('active');
        }
      });
    </script>
  @endpush

  <style>
    /* Enhanced form styling specific to create page */
    .form-section.enhanced {
      background: linear-gradient(135deg, rgba(102, 126, 234, 0.03) 0%, rgba(118, 75, 162, 0.03) 100%);
      border-radius: 40px;
      padding: var(--space-xl);
      margin-bottom: var(--space-xl);
      border: 1px solid rgba(102, 126, 234, 0.15);
      box-shadow: var(--shadow-light);
    }

    .form-wrapper {
      max-width: 900px;
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
      font-size: var(--font-size-xl);
      font-weight: 700;
      color: var(--text-primary);
      margin-bottom: var(--space-sm);
    }

    .group-icon {
      font-size: var(--font-size-2xl);
    }

    .group-description {
      color: var(--text-muted);
      font-size: var(--font-size-sm);
      margin: 0;
    }

    .type-selector.enhanced {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: var(--space-lg);
    }

    .type-option {
      cursor: pointer;
      transition: var(--transition-smooth);
    }

    .type-option input[type="radio"] {
      display: none;
    }

    .type-card.enhanced {
      padding: var(--space-lg);
      border: 2px solid var(--border-light);
      border-radius: var(--space-4);
      text-align: center;
      transition: var(--transition-spring);
      position: relative;
      overflow: hidden;
      background: var(--glass-bg);
      backdrop-filter: var(--blur-backdrop);
    }

    .type-card.enhanced::before {
      content: '';
      position: absolute;
      inset: 0;
      background: var(--card-gradient, var(--primary-gradient));
      opacity: 0;
      transition: var(--transition-smooth);
    }

    .type-card.enhanced:hover {
      transform: translateY(-4px);
      box-shadow: var(--shadow-lg);
    }

    .type-card.enhanced.active {
      border-color: var(--primary-blue);
      background: var(--glass-bg-strong);
      transform: translateY(-4px);
      box-shadow: var(--shadow-primary);
    }

    .type-card.enhanced.active::before {
      opacity: 0.05;
    }

    .type-icon-wrapper {
      position: relative;
      width: 60px;
      height: 60px;
      margin: 0 auto var(--space-md);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .type-icon {
      font-size: 2.5rem;
      position: relative;
      z-index: 2;
    }

    .icon-background {
      position: absolute;
      inset: 0;
      background: var(--card-color, var(--primary-blue));
      opacity: 0.1;
      border-radius: 50%;
      transition: var(--transition-smooth);
    }

    .type-card.enhanced.active .icon-background {
      opacity: 0.2;
      transform: scale(1.1);
    }

    .type-content {
      position: relative;
      z-index: 2;
    }

    .type-label {
      font-weight: 700;
      font-size: var(--font-size-lg);
      color: var(--text-primary);
      margin-bottom: var(--space-xs);
    }

    .type-desc {
      font-size: var(--font-size-sm);
      color: var(--text-muted);
      font-weight: 500;
    }

    .type-indicator {
      position: absolute;
      top: var(--space-3);
      right: var(--space-3);
      width: 20px;
      height: 20px;
      border-radius: 50%;
      border: 2px solid var(--border-medium);
      background: transparent;
      transition: var(--transition-smooth);
    }

    .type-card.enhanced.active .type-indicator {
      background: var(--primary-blue);
      border-color: var(--primary-blue);
    }

    .type-card.enhanced.active .type-indicator::after {
      content: '✓';
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: white;
      font-size: var(--font-size-xs);
      font-weight: 700;
    }

    /* Enhanced form fields */
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
      font-size: var(--font-size-sm);
      font-weight: 600;
      color: var(--text-primary);
    }

    .label-icon {
      font-size: var(--font-size-base);
    }

    .label-required {
      color: var(--danger-red);
      font-weight: 700;
    }

    .label-optional {
      color: var(--text-muted);
      font-weight: 400;
      font-size: var(--font-size-xs);
    }

    .input-group.enhanced {
      position: relative;
    }

    .input-prefix {
      position: absolute;
      left: var(--space-3);
      top: 50%;
      transform: translateY(-50%);
      color: var(--text-muted);
      font-weight: 600;
      z-index: 2;
    }

    .input-group.enhanced .form-input {
      padding-left: var(--space-8);
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
      font-size: var(--font-size-base);
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

    .form-input.enhanced:focus + .input-focus-ring {
      opacity: 0.1;
    }

    /* Enhanced checkbox styling */
    .checkbox-wrapper.enhanced {
      margin-bottom: var(--space-lg);
    }

    .checkbox-label.enhanced {
      display: flex;
      align-items: flex-start;
      gap: var(--space-md);
      cursor: pointer;
      padding: var(--space-lg);
      background: var(--glass-bg);
      backdrop-filter: var(--blur-backdrop);
      border: 2px solid var(--border-light);
      border-radius: var(--space-4);
      transition: var(--transition-smooth);
    }

    .checkbox-label.enhanced:hover {
      border-color: var(--primary-blue);
      background: var(--glass-bg-strong);
    }

    .checkbox-input.enhanced {
      display: none;
    }

    .checkmark.enhanced {
      width: 24px;
      height: 24px;
      border: 2px solid var(--border-medium);
      border-radius: var(--space-1);
      background: white;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: var(--transition-smooth);
      flex-shrink: 0;
    }

    .checkbox-input.enhanced:checked + .checkmark.enhanced {
      background: var(--primary-blue);
      border-color: var(--primary-blue);
    }

    .check-icon {
      color: white;
      font-size: var(--font-size-sm);
      font-weight: 700;
      opacity: 0;
      transition: var(--transition-smooth);
    }

    .checkbox-input.enhanced:checked + .checkmark.enhanced .check-icon {
      opacity: 1;
    }

    .checkbox-text {
      flex: 1;
    }

    .checkbox-title {
      display: block;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: var(--space-xs);
    }

    .checkbox-desc {
      display: block;
      font-size: var(--font-size-sm);
      color: var(--text-muted);
    }

    .recurring-options.enhanced {
      margin-top: var(--space-lg);
      padding: var(--space-lg);
      background: var(--glass-bg);
      backdrop-filter: var(--blur-backdrop);
      border-radius: var(--space-4);
      border: 1px solid var(--glass-border);
      transition: var(--transition-smooth);
      opacity: 0;
      transform: translateY(-10px);
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
      font-size: var(--font-size-lg);
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
      font-size: var(--font-size-sm);
      font-weight: 500;
    }

    .error-icon {
      flex-shrink: 0;
    }

    /* Category variations */
    .type-expense {
      --card-color: var(--danger-red);
      --card-gradient: var(--danger-gradient);
    }

    .type-income {
      --card-color: var(--success-green);
      --card-gradient: var(--success-gradient);
    }

    .type-savings {
      --card-color: var(--primary-blue);
      --card-gradient: var(--primary-gradient);
    }

    .type-investment {
      --card-color: var(--accent-gold);
      --card-gradient: var(--wealth-gradient);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .form-row {
        grid-template-columns: 1fr;
      }

      .type-selector.enhanced {
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

      .type-card.enhanced {
        padding: var(--space-md);
      }
    }
  </style>
@endsection
