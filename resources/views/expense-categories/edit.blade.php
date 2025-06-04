@extends('layouts.app')

@section('title', 'Edit Category')

@section('page-header')
  <div style="display: flex; justify-content: space-between; align-items: center;">
    <div>
      <h1 class="page-title">✏️ Edit Category</h1>
      <p class="page-subtitle">Update your expense category details</p>
    </div>
    <div class="header-actions">
      <a href="{{ route('expense-categories.show', $expenseCategory) }}" class="action-btn secondary">
        <span class="btn-icon">👁️</span>
        <span class="btn-text">View Details</span>
      </a>
    </div>
  </div>
@endsection

@section('breadcrumbs')
  <a href="{{ route('expense-categories.index') }}" class="breadcrumb-item">📂 Categories</a>
  <span class="breadcrumb-separator">›</span>
  <span class="breadcrumb-item">{{ $expenseCategory->name }}</span>
  <span class="breadcrumb-separator">›</span>
  <span class="breadcrumb-item">Edit</span>
@endsection

@section('content')
  <div class="form-container enhanced">
    <form action="{{ route('expense-categories.update', $expenseCategory) }}" method="POST" class="enhanced-form">
      @csrf
      @method('PUT')

      <div class="form-section">
        <h3 class="section-title">
          <span class="section-icon">📝</span>
          Basic Information
        </h3>

        <div class="form-group enhanced">
          <label for="name" class="form-label required">Category Name</label>
          <input type="text" id="name" name="name" value="{{ old('name', $expenseCategory->name) }}"
            class="form-input enhanced @error('name') error @enderror" placeholder="e.g., Groceries, Gas, Entertainment" required>
          @error('name')
            <div class="error-message">{{ $message }}</div>
          @enderror
          <div class="form-help">Choose a clear, descriptive name for your category</div>
        </div>

        <div class="form-row">
          <div class="form-group enhanced">
            <label for="icon" class="form-label required">Category Icon</label>
            <div class="icon-selector enhanced">
              <input type="hidden" id="icon" name="icon" value="{{ old('icon', $expenseCategory->icon) }}" required>
              <div class="selected-icon" id="selectedIcon">{{ old('icon', $expenseCategory->icon) }}</div>
              <div class="icon-grid">
                @php
                  $icons = ['💰', '🛒', '⛽', '🏠', '🚗', '🍽️', '👕', '🎬', '🏥', '📚', '✈️', '🎮', '💊', '🔧', '📱', '💡', '🎵', '🏋️', '🐕', '🎁', '⚡', '🛡️', '💄', '📺', '🛍️'];
                @endphp
                @foreach ($icons as $emoji)
                  <button type="button" class="icon-option {{ $emoji === $expenseCategory->icon ? 'selected' : '' }}" data-icon="{{ $emoji }}">{{ $emoji }}</button>
                @endforeach
              </div>
            </div>
            @error('icon')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group enhanced">
            <label for="color" class="form-label required">Category Color</label>
            <div class="color-picker enhanced">
              <input type="color" id="color" name="color" value="{{ old('color', $expenseCategory->color) }}" class="color-input @error('color') error @enderror" required>
              <div class="color-presets">
                @php
                  $colors = ['#EF4444', '#F59E0B', '#10B981', '#3B82F6', '#8B5CF6', '#EC4899', '#06B6D4', '#84CC16'];
                @endphp
                @foreach ($colors as $presetColor)
                  <button type="button" class="color-preset" style="background-color: {{ $presetColor }};" data-color="{{ $presetColor }}"></button>
                @endforeach
              </div>
            </div>
            @error('color')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <div class="form-section">
        <h3 class="section-title">
          <span class="section-icon">💰</span>
          Budget Settings
        </h3>

        <div class="form-group enhanced">
          <label for="monthly_budget" class="form-label">Monthly Budget</label>
          <div class="input-group enhanced">
            <span class="input-prefix">$</span>
            <input type="number" id="monthly_budget" name="monthly_budget" value="{{ old('monthly_budget', $expenseCategory->monthly_budget) }}" step="0.01" min="0" class="form-input @error('monthly_budget') error @enderror" placeholder="0.00">
          </div>
          <div class="form-help">Set a monthly spending limit for this category (optional)</div>
          @error('monthly_budget')
            <div class="error-message">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group enhanced">
          <label class="checkbox-container">
            <input type="checkbox" name="is_essential" value="1" {{ old('is_essential', $expenseCategory->is_essential) ? 'checked' : '' }}>
            <span class="checkmark enhanced"></span>
            <span class="checkbox-label">This is an essential category</span>
          </label>
          <div class="form-help">Essential categories are necessities like housing, food, and utilities</div>
        </div>
      </div>

      <!-- Enhanced Preview -->
      <div class="form-section">
        <h3 class="section-title">
          <span class="section-icon">👁️</span>
          Preview
        </h3>

        <div class="category-preview enhanced">
          <div class="preview-item">
            <div class="preview-icon" id="previewIcon" style="background-color: {{ $expenseCategory->color }};">{{ $expenseCategory->icon }}</div>
            <div class="preview-details">
              <div class="preview-name" id="previewName">{{ $expenseCategory->name }}</div>
              <div class="preview-budget" id="previewBudget">
                @if ($expenseCategory->monthly_budget > 0)
                  ${{ number_format($expenseCategory->monthly_budget, 2) }} monthly budget
                @else
                  No budget set
                @endif
              </div>
              <div class="preview-status" id="previewStatus">
                @if ($expenseCategory->is_essential)
                  <span class="essential-indicator">⭐ Essential Category</span>
                @else
                  <span class="optional-indicator">Optional Category</span>
                @endif
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="form-actions enhanced">
        <button type="submit" class="action-btn primary large">
          <span class="btn-icon">💾</span>
          <span class="btn-text">Update Category</span>
        </button>
        <a href="{{ route('expense-categories.index') }}" class="action-btn secondary">
          <span class="btn-icon">←</span>
          <span class="btn-text">Cancel</span>
        </a>
        <a href="{{ route('expense-categories.show', $expenseCategory) }}" class="action-btn secondary">
          <span class="btn-icon">👁️</span>
          <span class="btn-text">View Details</span>
        </a>
      </div>
    </form>
  </div>

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const iconInput = document.getElementById('icon');
        const colorInput = document.getElementById('color');
        const budgetInput = document.getElementById('monthly_budget');
        const essentialCheckbox = document.querySelector('input[name="is_essential"]');

        const selectedIcon = document.getElementById('selectedIcon');
        const previewIcon = document.getElementById('previewIcon');
        const previewName = document.getElementById('previewName');
        const previewBudget = document.getElementById('previewBudget');
        const previewStatus = document.getElementById('previewStatus');

        // Icon selection
        document.querySelectorAll('.icon-option').forEach(option => {
          option.addEventListener('click', function() {
            const icon = this.getAttribute('data-icon');
            iconInput.value = icon;
            selectedIcon.textContent = icon;
            updatePreview();

            // Update selection state
            document.querySelectorAll('.icon-option').forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
          });
        });

        // Color presets
        document.querySelectorAll('.color-preset').forEach(preset => {
          preset.addEventListener('click', function() {
            const color = this.getAttribute('data-color');
            colorInput.value = color;
            updatePreview();
          });
        });

        // Update preview
        function updatePreview() {
          previewName.textContent = nameInput.value || 'Category Name';
          previewIcon.textContent = iconInput.value;
          previewIcon.style.backgroundColor = colorInput.value;

          const budget = parseFloat(budgetInput.value);
          if (budget > 0) {
            previewBudget.textContent = `$${budget.toFixed(2)} monthly budget`;
          } else {
            previewBudget.textContent = 'No budget set';
          }

          if (essentialCheckbox.checked) {
            previewStatus.innerHTML = '<span class="essential-indicator">⭐ Essential Category</span>';
          } else {
            previewStatus.innerHTML = '<span class="optional-indicator">Optional Category</span>';
          }
        }

        // Add event listeners
        nameInput.addEventListener('input', updatePreview);
        colorInput.addEventListener('change', updatePreview);
        budgetInput.addEventListener('input', updatePreview);
        essentialCheckbox.addEventListener('change', updatePreview);

        // Initial preview update
        updatePreview();
      });
    </script>
  @endpush

  @push('styles')
    <style>
      /* Form Container */
      .form-container.enhanced {
        max-width: 800px;
        margin: 0 auto;
      }

      .enhanced-form {
        background: var(--glass-bg-strong);
        backdrop-filter: var(--glass-backdrop);
        border: 1px solid var(--glass-border);
        border-radius: var(--space-6);
        padding: var(--space-8);
        box-shadow: var(--shadow-lg);
      }

      /* Form Sections */
      .form-section {
        margin-bottom: var(--space-8);
        padding-bottom: var(--space-6);
        border-bottom: 1px solid var(--border-light);
      }

      .form-section:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
      }

      .section-title {
        display: flex;
        align-items: center;
        gap: var(--space-3);
        font-size: var(--text-xl);
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: var(--space-6);
      }

      .section-icon {
        font-size: var(--text-2xl);
      }

      /* Enhanced Form Controls */
      .form-group.enhanced {
        margin-bottom: var(--space-6);
      }

      .form-label {
        display: block;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: var(--space-2);
        font-size: var(--text-sm);
      }

      .form-label.required::after {
        content: ' *';
        color: var(--danger-red);
      }

      .form-input.enhanced {
        width: 100%;
        padding: var(--space-4);
        border: 2px solid var(--border-light);
        border-radius: var(--space-3);
        font-size: var(--text-base);
        transition: var(--transition-normal);
        background: var(--bg-primary);
      }

      .form-input.enhanced:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
      }

      .form-input.enhanced.error {
        border-color: var(--danger-red);
      }

      .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--space-6);
      }

      /* Enhanced Icon Selector */
      .icon-selector.enhanced {
        position: relative;
      }

      .selected-icon {
        width: 80px;
        height: 80px;
        border: 2px solid var(--border-light);
        border-radius: var(--space-4);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: var(--text-3xl);
        background: var(--bg-primary);
        cursor: pointer;
        margin-bottom: var(--space-4);
        transition: var(--transition-normal);
        box-shadow: var(--shadow-sm);
      }

      .selected-icon:hover {
        border-color: var(--primary-blue);
        transform: scale(1.05);
      }

      .icon-grid {
        display: grid;
        grid-template-columns: repeat(8, 1fr);
        gap: var(--space-2);
        max-height: 200px;
        overflow-y: auto;
        border: 1px solid var(--border-light);
        border-radius: var(--space-3);
        padding: var(--space-4);
        background: var(--bg-primary);
      }

      .icon-option {
        width: 40px;
        height: 40px;
        border: 1px solid var(--border-light);
        border-radius: var(--space-2);
        background: var(--bg-primary);
        cursor: pointer;
        font-size: var(--text-lg);
        transition: var(--transition-normal);
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .icon-option:hover {
        border-color: var(--primary-blue);
        background: var(--primary-blue-50);
        transform: scale(1.1);
      }

      .icon-option.selected {
        border-color: var(--primary-blue);
        background: var(--primary-blue);
        color: var(--text-inverse);
        box-shadow: var(--shadow-primary);
      }

      /* Enhanced Color Picker */
      .color-picker.enhanced {
        display: flex;
        flex-direction: column;
        gap: var(--space-4);
      }

      .color-input {
        width: 80px;
        height: 80px;
        padding: 0;
        border: 2px solid var(--border-light);
        border-radius: var(--space-4);
        cursor: pointer;
        box-shadow: var(--shadow-sm);
        transition: var(--transition-normal);
      }

      .color-input:hover {
        transform: scale(1.05);
        border-color: var(--primary-blue);
      }

      .color-presets {
        display: flex;
        gap: var(--space-2);
        flex-wrap: wrap;
      }

      .color-preset {
        width: 40px;
        height: 40px;
        border: 2px solid var(--border-light);
        border-radius: 50%;
        cursor: pointer;
        transition: var(--transition-normal);
        box-shadow: var(--shadow-sm);
      }

      .color-preset:hover {
        transform: scale(1.1);
        border-color: var(--text-primary);
        box-shadow: var(--shadow-md);
      }

      /* Enhanced Input Group */
      .input-group.enhanced {
        position: relative;
        display: flex;
        align-items: center;
      }

      .input-prefix {
        position: absolute;
        left: var(--space-4);
        color: var(--text-muted);
        font-weight: 600;
        z-index: 2;
      }

      .input-group.enhanced .form-input {
        padding-left: var(--space-8);
      }

      /* Enhanced Checkbox */
      .checkbox-container {
        display: flex;
        align-items: center;
        gap: var(--space-3);
        cursor: pointer;
        font-weight: 500;
      }

      .checkbox-container input[type="checkbox"] {
        display: none;
      }

      .checkmark.enhanced {
        width: 24px;
        height: 24px;
        border: 2px solid var(--border-medium);
        border-radius: var(--space-1);
        position: relative;
        transition: var(--transition-normal);
        background: var(--bg-primary);
      }

      .checkbox-container:hover .checkmark.enhanced {
        border-color: var(--primary-blue);
      }

      .checkbox-container input[type="checkbox"]:checked + .checkmark.enhanced {
        background: var(--primary-blue);
        border-color: var(--primary-blue);
      }

      .checkbox-container input[type="checkbox"]:checked + .checkmark.enhanced::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: var(--text-inverse);
        font-weight: bold;
        font-size: var(--text-sm);
      }

      /* Enhanced Preview */
      .category-preview.enhanced {
        background: var(--bg-secondary);
        border: 1px solid var(--border-light);
        border-radius: var(--space-4);
        padding: var(--space-6);
        box-shadow: var(--shadow-sm);
      }

      .preview-item {
        display: flex;
        align-items: center;
        gap: var(--space-4);
        padding: var(--space-4);
        background: var(--bg-primary);
        border-radius: var(--space-3);
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-sm);
      }

      .preview-icon {
        width: 60px;
        height: 60px;
        border-radius: var(--space-3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: var(--text-2xl);
        color: var(--text-inverse);
        box-shadow: var(--shadow-md);
        transition: var(--transition-normal);
      }

      .preview-details {
        flex: 1;
      }

      .preview-name {
        font-weight: 700;
        font-size: var(--text-lg);
        color: var(--text-primary);
        margin-bottom: var(--space-1);
      }

      .preview-budget {
        font-size: var(--text-sm);
        color: var(--text-muted);
        margin-bottom: var(--space-1);
      }

      .essential-indicator {
        color: var(--accent-gold);
        font-weight: 600;
        font-size: var(--text-sm);
      }

      .optional-indicator {
        color: var(--text-muted);
        font-size: var(--text-sm);
      }

      /* Form Help */
      .form-help {
        font-size: var(--text-sm);
        color: var(--text-muted);
        margin-top: var(--space-2);
      }

      /* Error Messages */
      .error-message {
        color: var(--danger-red);
        font-size: var(--text-sm);
        margin-top: var(--space-2);
        font-weight: 500;
      }

      /* Enhanced Form Actions */
      .form-actions.enhanced {
        display: flex;
        gap: var(--space-4);
        justify-content: flex-start;
        margin-top: var(--space-8);
        padding-top: var(--space-6);
        border-top: 1px solid var(--border-light);
      }

      /* Responsive Design */
      @media (max-width: 768px) {
        .form-row {
          grid-template-columns: 1fr;
        }

        .icon-grid {
          grid-template-columns: repeat(6, 1fr);
        }

        .form-actions.enhanced {
          flex-direction: column;
        }

        .preview-item {
          flex-direction: column;
          text-align: center;
        }
      }
    </style>
  @endpush
@endsection
