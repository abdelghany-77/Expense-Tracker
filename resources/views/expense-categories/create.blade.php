@extends('layouts.app')

@section('title', 'Create Expense Category')

@section('page-header')
  <div>
    <h1 class="page-title">➕ Create Expense Category</h1>
    <p class="page-subtitle">Add a new category to organize your expenses</p>
  </div>
@endsection

@section('breadcrumbs')
  <span class="breadcrumb-item">📂 Categories</span>
@endsection

@section('content')
  <div class="content-card" style="max-width: 800px; margin: 0 auto;">
    <form action="{{ route('expense-categories.store') }}" method="POST" class="enhanced-form">
      @csrf

      <div class="form-section">
        <div class="form-group enhanced">
          <label for="name" class="form-label">Category Name *</label>
          <input type="text" id="name" name="name" value="{{ old('name') }}"
            class="form-input enhanced @error('name') error @enderror"
            placeholder="e.g., Groceries, Gas, Entertainment" required>
          @error('name')
            <div class="error-message">{{ $message }}</div>
          @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-6);">
          <div class="form-group enhanced">
            <label for="icon" class="form-label">Icon *</label>
            <div class="icon-selector enhanced">
              <input type="hidden" id="icon" name="icon" value="{{ old('icon', '💰') }}" required>
              <div class="selected-icon" id="selectedIcon">{{ old('icon', '💰') }}</div>
              <div class="icon-grid enhanced">
                @php
                  $icons = ['💰', '🛒', '⛽', '🏠', '🚗', '🍽️', '👕', '🎬', '🏥', '📚', '✈️', '🎮', '💊', '🔧', '📱', '💡', '🎵', '🏋️', '🐕', '🎁'];
                @endphp
                @foreach ($icons as $emoji)
                  <button type="button" class="icon-option enhanced" data-icon="{{ $emoji }}">{{ $emoji }}</button>
                @endforeach
              </div>
            </div>
            @error('icon')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group enhanced">
            <label for="color" class="form-label">Color *</label>
            <div class="color-picker enhanced">
              <input type="color" id="color" name="color" value="{{ old('color', '#3B82F6') }}"
                class="form-input color-input enhanced @error('color') error @enderror" required>
              <div class="color-presets">
                @php
                  $colors = ['#EF4444', '#F59E0B', '#10B981', '#3B82F6', '#8B5CF6', '#EC4899', '#06B6D4', '#84CC16'];
                @endphp
                @foreach ($colors as $presetColor)
                  <button type="button" class="color-preset enhanced"
                    style="background-color: {{ $presetColor }};" data-color="{{ $presetColor }}"></button>
                @endforeach
              </div>
            </div>
            @error('color')
              <div class="error-message">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="form-group enhanced">
          <label for="monthly_budget" class="form-label">Monthly Budget (Optional)</label>
          <div class="input-group enhanced">
            <span class="input-prefix">$</span>
            <input type="number" id="monthly_budget" name="monthly_budget" value="{{ old('monthly_budget') }}"
              step="0.01" min="0" class="form-input enhanced @error('monthly_budget') error @enderror" placeholder="0.00">
          </div>
          <div class="form-help">Set a monthly spending limit for this category (optional)</div>
          @error('monthly_budget')
            <div class="error-message">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group enhanced">
          <label class="checkbox-label enhanced">
            <input type="checkbox" name="is_essential" value="1" {{ old('is_essential') ? 'checked' : '' }}>
            <span class="checkmark enhanced"></span>
            This is an essential category
          </label>
          <div class="form-help">Essential categories are necessities like housing, food, and utilities</div>
        </div>
      </div>

      <!-- Enhanced Preview -->
      <div class="category-preview enhanced">
        <div class="preview-header">
          <h4 style="color: var(--text-primary); font-weight: 600; margin-bottom: var(--space-2);">Live Preview</h4>
          <p style="color: var(--text-muted); font-size: var(--text-sm);">See how your category will look</p>
        </div>
        <div class="preview-item enhanced">
          <div class="preview-icon enhanced" id="previewIcon">💰</div>
          <div class="preview-details">
            <div class="preview-name" id="previewName">Category Name</div>
            <div class="preview-budget" id="previewBudget">No budget set</div>
            <div class="preview-type" id="previewType">Regular category</div>
          </div>
          <div class="preview-actions">
            <span class="preview-action">👁️</span>
            <span class="preview-action">✏️</span>
          </div>
        </div>
      </div>

      <div class="form-actions enhanced">
        <button type="submit" class="btn btn-primary enhanced">
          <span>✨</span> Create Category
        </button>
        <a href="{{ route('expense-categories.index') }}" class="btn btn-secondary enhanced">
          <span>❌</span> Cancel
        </a>
      </div>
    </form>
  </div>

  @push('styles')
    <style>
      .enhanced-form {
        display: grid;
        gap: var(--space-8);
      }

      .form-section {
        display: grid;
        gap: var(--space-6);
      }

      .form-group.enhanced {
        display: grid;
        gap: var(--space-3);
      }

      .form-label {
        font-weight: 600;
        color: var(--text-primary);
        font-size: var(--text-sm);
      }

      .form-input.enhanced {
        padding: var(--space-4);
        border: 2px solid var(--border-light);
        border-radius: var(--space-3);
        background: var(--bg-primary);
        color: var(--text-primary);
        font-size: var(--text-base);
        transition: var(--transition-normal);
        font-family: inherit;
      }

      .form-input.enhanced:focus {
        border-color: var(--primary-blue);
        box-shadow: var(--shadow-focus);
        outline: none;
      }

      .form-input.enhanced.error {
        border-color: var(--danger-red);
      }

      .input-group.enhanced {
        display: flex;
        align-items: center;
        border: 2px solid var(--border-light);
        border-radius: var(--space-3);
        background: var(--bg-primary);
        transition: var(--transition-normal);
      }

      .input-group.enhanced:focus-within {
        border-color: var(--primary-blue);
        box-shadow: var(--shadow-focus);
      }

      .input-prefix {
        padding: var(--space-4);
        background: var(--neutral-100);
        color: var(--text-muted);
        font-weight: 600;
        border-right: 1px solid var(--border-light);
      }

      .input-group.enhanced .form-input.enhanced {
        border: none;
        box-shadow: none;
        flex: 1;
      }

      .checkbox-label.enhanced {
        display: flex;
        align-items: center;
        gap: var(--space-3);
        cursor: pointer;
        font-weight: 500;
        color: var(--text-primary);
      }

      .checkmark.enhanced {
        width: 20px;
        height: 20px;
        border: 2px solid var(--border-medium);
        border-radius: var(--space-1);
        position: relative;
        transition: var(--transition-fast);
      }

      .checkbox-label.enhanced input[type="checkbox"] {
        display: none;
      }

      .checkbox-label.enhanced input[type="checkbox"]:checked + .checkmark.enhanced {
        background: var(--primary-blue);
        border-color: var(--primary-blue);
      }

      .checkbox-label.enhanced input[type="checkbox"]:checked + .checkmark.enhanced::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: white;
        font-size: var(--text-xs);
        font-weight: bold;
      }

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
        font-size: var(--text-4xl);
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

      .icon-grid.enhanced {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(48px, 1fr));
        gap: var(--space-2);
        max-height: 240px;
        overflow-y: auto;
        border: 1px solid var(--border-light);
        border-radius: var(--space-3);
        padding: var(--space-4);
        background: var(--bg-secondary);
      }

      .icon-option.enhanced {
        width: 48px;
        height: 48px;
        border: 1px solid var(--border-light);
        border-radius: var(--space-2);
        background: var(--bg-primary);
        cursor: pointer;
        font-size: var(--text-xl);
        transition: var(--transition-fast);
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .icon-option.enhanced:hover {
        border-color: var(--primary-blue);
        background: var(--primary-blue-50);
        transform: scale(1.1);
      }

      .icon-option.enhanced.selected {
        border-color: var(--primary-blue);
        background: var(--primary-blue);
        color: white;
        box-shadow: var(--shadow-md);
      }

      .color-picker.enhanced {
        display: flex;
        flex-direction: column;
        gap: var(--space-4);
      }

      .color-input.enhanced {
        width: 80px;
        height: 80px;
        padding: 0;
        border: 2px solid var(--border-light);
        cursor: pointer;
        border-radius: var(--space-3);
      }

      .color-presets {
        display: flex;
        gap: var(--space-2);
        flex-wrap: wrap;
      }

      .color-preset.enhanced {
        width: 36px;
        height: 36px;
        border: 2px solid var(--border-light);
        border-radius: 50%;
        cursor: pointer;
        transition: var(--transition-fast);
        position: relative;
      }

      .color-preset.enhanced:hover {
        transform: scale(1.2);
        border-color: var(--text-primary);
        box-shadow: var(--shadow-md);
      }

      .category-preview.enhanced {
        padding: var(--space-8);
        background: linear-gradient(135deg, var(--glass-bg-strong) 0%, var(--glass-bg-medium) 100%);
        backdrop-filter: var(--glass-backdrop);
        border: 1px solid var(--glass-border);
        border-radius: var(--space-6);
        box-shadow: var(--shadow-lg);
      }

      .preview-header {
        text-align: center;
        margin-bottom: var(--space-6);
      }

      .preview-item.enhanced {
        display: flex;
        align-items: center;
        gap: var(--space-4);
        padding: var(--space-6);
        background: var(--bg-primary);
        border-radius: var(--space-4);
        border: 1px solid var(--border-light);
        box-shadow: var(--shadow-sm);
        transition: var(--transition-normal);
      }

      .preview-icon.enhanced {
        width: 56px;
        height: 56px;
        border-radius: var(--space-3);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: var(--text-2xl);
        color: white;
        background-color: var(--primary-blue);
        box-shadow: var(--shadow-md);
        transition: var(--transition-normal);
      }

      .preview-details {
        flex: 1;
      }

      .preview-name {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: var(--space-1);
        font-size: var(--text-lg);
      }

      .preview-budget {
        font-size: var(--text-sm);
        color: var(--text-muted);
        margin-bottom: var(--space-1);
      }

      .preview-type {
        font-size: var(--text-xs);
        color: var(--text-light);
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
      }

      .preview-actions {
        display: flex;
        gap: var(--space-2);
      }

      .preview-action {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--neutral-100);
        border-radius: var(--space-2);
        font-size: var(--text-sm);
      }

      .form-actions.enhanced {
        display: flex;
        gap: var(--space-4);
        justify-content: flex-end;
        padding-top: var(--space-6);
        border-top: 1px solid var(--border-light);
      }

      .btn.enhanced {
        display: flex;
        align-items: center;
        gap: var(--space-2);
        padding: var(--space-4) var(--space-6);
        border-radius: var(--space-3);
        font-weight: 600;
        transition: var(--transition-normal);
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: var(--text-base);
      }

      .btn-primary.enhanced {
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
        color: white;
        box-shadow: var(--shadow-md);
      }

      .btn-primary.enhanced:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-lg);
      }

      .btn-secondary.enhanced {
        background: var(--neutral-100);
        color: var(--text-primary);
        border: 1px solid var(--border-light);
      }

      .btn-secondary.enhanced:hover {
        background: var(--neutral-200);
        transform: translateY(-1px);
      }

      .form-help {
        font-size: var(--text-sm);
        color: var(--text-muted);
        font-style: italic;
      }

      .error-message {
        color: var(--danger-red);
        font-size: var(--text-sm);
        font-weight: 500;
      }

      /* Responsive Design */
      @media (max-width: 768px) {
        .content-card {
          margin: 0 var(--space-4);
        }

        .form-section > div[style*="grid-template-columns"] {
          grid-template-columns: 1fr;
        }

        .selected-icon,
        .color-input.enhanced {
          width: 60px;
          height: 60px;
        }

        .form-actions.enhanced {
          flex-direction: column;
        }
      }
    </style>
  @endpush

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const nameInput = document.getElementById('name');
        const iconInput = document.getElementById('icon');
        const colorInput = document.getElementById('color');
        const budgetInput = document.getElementById('monthly_budget');

        const selectedIcon = document.getElementById('selectedIcon');
        const previewIcon = document.getElementById('previewIcon');
        const previewName = document.getElementById('previewName');
        const previewBudget = document.getElementById('previewBudget');

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
        }

        // Add event listeners
        nameInput.addEventListener('input', updatePreview);
        colorInput.addEventListener('change', updatePreview);
        budgetInput.addEventListener('input', updatePreview);

        // Set initial selected icon
        const currentIcon = iconInput.value;
        document.querySelectorAll('.icon-option').forEach(option => {
          if (option.getAttribute('data-icon') === currentIcon) {
            option.classList.add('selected');
          }
        });

        // Initial preview update
        updatePreview();
      });
    </script>
  @endpush
@endsection
