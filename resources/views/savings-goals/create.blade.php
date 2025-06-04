@extends('layouts.app')

@section('content')
  <div class="page-header">
    <h1 class="page-title">
      <span>🎯</span> Create Savings Goal
    </h1>
    <p class="page-subtitle">Set a target and track your progress towards your financial dreams</p>
  </div>

  <div class="content-card" style="max-width: 800px; margin: 0 auto;">
    <form action="{{ route('savings-goals.store') }}" method="POST" class="goal-form">
      @csrf

      <div class="form-section">
        <h3 class="section-title">
          <span>📝</span> Goal Details
        </h3>

        <div class="form-group">
          <label for="name" class="form-label">Goal Name *</label>
          <input type="text" id="name" name="name" value="{{ old('name') }}"
            class="form-input @error('name') form-input-error @enderror"
            placeholder="e.g., Emergency Fund, Dream Vacation, New Car"
            required>
          @error('name')
            <div class="form-error">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="description" class="form-label">Description</label>
          <textarea id="description" name="description" rows="3"
            class="form-input @error('description') form-input-error @enderror"
            placeholder="Describe what this goal means to you and why it's important...">{{ old('description') }}</textarea>
          @error('description')
            <div class="form-error">{{ $message }}</div>
          @enderror
        </div>
      </div>

      <div class="form-section">
        <h3 class="section-title">
          <span>💰</span> Financial Details
        </h3>

        <div class="form-grid">
          <div class="form-group">
            <label for="target_amount" class="form-label">Target Amount *</label>
            <div class="input-group">
              <span class="input-prefix">$</span>
              <input type="number" id="target_amount" name="target_amount" value="{{ old('target_amount') }}"
                step="0.01" min="0.01" class="form-input @error('target_amount') form-input-error @enderror"
                placeholder="10000.00" required>
            </div>
            @error('target_amount')
              <div class="form-error">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="target_date" class="form-label">Target Date *</label>
            <input type="date" id="target_date" name="target_date"
              value="{{ old('target_date', now()->addYear()->format('Y-m-d')) }}"
              class="form-input @error('target_date') form-input-error @enderror"
              min="{{ now()->addDay()->format('Y-m-d') }}"
              required>
            @error('target_date')
              <div class="form-error">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <div class="form-section">
        <h3 class="section-title">
          <span>⚙️</span> Goal Settings
        </h3>

        <div class="form-grid">
          <div class="form-group">
            <label for="priority" class="form-label">Priority Level *</label>
            <select id="priority" name="priority" class="form-input @error('priority') form-input-error @enderror" required>
              <option value="">Select Priority</option>
              <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>🟢 Low Priority</option>
              <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>🟡 Medium Priority</option>
              <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>🔴 High Priority</option>
            </select>
            @error('priority')
              <div class="form-error">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="color" class="form-label">Color Theme *</label>
            <div class="color-picker-container">
              <input type="color" id="color" name="color" value="{{ old('color', '#10B981') }}"
                class="color-input @error('color') form-input-error @enderror" required>
              <div class="color-preview" id="colorPreview"></div>
              <div class="color-presets">
                <button type="button" class="color-preset" data-color="#10B981" style="background: #10B981;"></button>
                <button type="button" class="color-preset" data-color="#3B82F6" style="background: #3B82F6;"></button>
                <button type="button" class="color-preset" data-color="#F59E0B" style="background: #F59E0B;"></button>
                <button type="button" class="color-preset" data-color="#EF4444" style="background: #EF4444;"></button>
                <button type="button" class="color-preset" data-color="#8B5CF6" style="background: #8B5CF6;"></button>
                <button type="button" class="color-preset" data-color="#06B6D4" style="background: #06B6D4;"></button>
              </div>
            </div>
            @error('color')
              <div class="form-error">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <div class="form-section">
        <h3 class="section-title">
          <span>👀</span> Goal Preview
        </h3>

        <div class="goal-preview">
          <div class="preview-card" id="previewCard">
            <div class="preview-header">
              <div>
                <h4 class="preview-name" id="previewName">Your Goal Name</h4>
                <p class="preview-description" id="previewDescription">Goal description...</p>
              </div>
              <span class="preview-priority" id="previewPriority">Medium Priority</span>
            </div>

            <div class="preview-amount">
              <span class="preview-target" id="previewAmount">$0.00</span>
              <span class="preview-label">target amount</span>
            </div>

            <div class="preview-progress">
              <div class="progress-container">
                <div class="progress-bar" id="previewProgressBar" style="width: 0%;"></div>
              </div>
              <div class="preview-details">
                <span class="preview-percentage">0% complete</span>
                <span class="preview-date" id="previewDate">Target Date</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary">
          <span>🎯</span> Create Savings Goal
        </button>
        <a href="{{ route('savings-goals.index') }}" class="btn btn-secondary">
          <span>❌</span> Cancel
        </a>
      </div>
    </form>
  </div>

  <style>
    .goal-form {
      max-width: none;
    }

    .form-section {
      margin-bottom: var(--space-8);
      padding-bottom: var(--space-6);
      border-bottom: 1px solid var(--border-light);
    }

    .form-section:last-of-type {
      border-bottom: none;
      margin-bottom: var(--space-6);
    }

    .section-title {
      display: flex;
      align-items: center;
      gap: var(--space-2);
      font-size: var(--text-lg);
      font-weight: var(--font-semibold);
      color: var(--text-primary);
      margin-bottom: var(--space-6);
    }

    .form-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: var(--space-6);
    }

    .form-group {
      margin-bottom: var(--space-6);
    }

    .form-label {
      display: block;
      font-size: var(--text-sm);
      font-weight: var(--font-medium);
      color: var(--text-primary);
      margin-bottom: var(--space-2);
    }

    .form-input {
      width: 100%;
      padding: var(--space-3) var(--space-4);
      border: 1px solid var(--border-light);
      border-radius: var(--space-2);
      font-size: var(--text-base);
      background: var(--bg-primary);
      color: var(--text-primary);
      transition: var(--transition-fast);
    }

    .form-input:focus {
      outline: none;
      border-color: var(--primary-blue);
      box-shadow: var(--shadow-focus);
    }

    .form-input-error {
      border-color: var(--danger-red);
    }

    .form-input-error:focus {
      border-color: var(--danger-red);
      box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.25);
    }

    .form-error {
      color: var(--danger-red);
      font-size: var(--text-sm);
      margin-top: var(--space-1);
      display: flex;
      align-items: center;
      gap: var(--space-1);
    }

    .form-error::before {
      content: '⚠️';
      font-size: var(--text-xs);
    }

    .input-group {
      position: relative;
      display: flex;
      align-items: center;
    }

    .input-prefix {
      position: absolute;
      left: var(--space-4);
      color: var(--text-muted);
      font-weight: var(--font-medium);
      z-index: 1;
    }

    .input-group .form-input {
      padding-left: var(--space-8);
    }

    /* Color Picker */
    .color-picker-container {
      display: flex;
      align-items: center;
      gap: var(--space-4);
    }

    .color-input {
      width: 60px;
      height: 60px;
      padding: 0;
      border: 2px solid var(--border-light);
      border-radius: var(--space-2);
      cursor: pointer;
      transition: var(--transition-fast);
    }

    .color-input:hover {
      border-color: var(--border-medium);
      transform: scale(1.05);
    }

    .color-preview {
      width: 40px;
      height: 40px;
      border-radius: var(--space-2);
      border: 2px solid var(--border-light);
      background-color: #10B981;
      transition: var(--transition-fast);
    }

    .color-presets {
      display: flex;
      gap: var(--space-2);
    }

    .color-preset {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      border: 2px solid transparent;
      cursor: pointer;
      transition: var(--transition-fast);
    }

    .color-preset:hover {
      transform: scale(1.1);
      border-color: var(--border-medium);
    }

    .color-preset.active {
      border-color: var(--text-primary);
      transform: scale(1.15);
    }

    /* Goal Preview */
    .goal-preview {
      background: var(--bg-muted);
      border-radius: var(--space-4);
      padding: var(--space-6);
      border: 1px solid var(--border-light);
    }

    .preview-card {
      background: var(--bg-primary);
      border-radius: var(--space-3);
      padding: var(--space-6);
      border-left: 4px solid #10B981;
      box-shadow: var(--shadow-sm);
      transition: var(--transition-normal);
    }

    .preview-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: var(--space-6);
    }

    .preview-name {
      font-size: var(--text-lg);
      font-weight: var(--font-semibold);
      color: var(--text-primary);
      margin-bottom: var(--space-1);
    }

    .preview-description {
      font-size: var(--text-sm);
      color: var(--text-muted);
      margin: 0;
      display: none;
    }

    .preview-description.show {
      display: block;
    }

    .preview-priority {
      padding: var(--space-1) var(--space-3);
      border-radius: var(--space-2);
      font-size: var(--text-xs);
      font-weight: var(--font-medium);
      background: #fef3c7;
      color: #92400e;
    }

    .preview-amount {
      text-align: center;
      margin-bottom: var(--space-6);
    }

    .preview-target {
      display: block;
      font-size: var(--text-3xl);
      font-weight: var(--font-bold);
      color: var(--text-primary);
      margin-bottom: var(--space-1);
    }

    .preview-label {
      font-size: var(--text-sm);
      color: var(--text-muted);
      text-transform: uppercase;
      letter-spacing: 0.05em;
    }

    .preview-progress {
      margin-bottom: var(--space-4);
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
      background-color: #10B981;
      border-radius: var(--space-2);
      transition: var(--transition-normal);
    }

    .preview-details {
      display: flex;
      justify-content: space-between;
      font-size: var(--text-xs);
      color: var(--text-muted);
    }

    .preview-percentage {
      font-weight: var(--font-medium);
    }

    .preview-date {
      display: flex;
      align-items: center;
      gap: var(--space-1);
    }

    .preview-date::before {
      content: '📅';
    }

    /* Form Actions */
    .form-actions {
      display: flex;
      gap: var(--space-4);
      padding-top: var(--space-6);
      border-top: 1px solid var(--border-light);
    }

    .btn {
      display: inline-flex;
      align-items: center;
      gap: var(--space-2);
      padding: var(--space-3) var(--space-6);
      border-radius: var(--space-2);
      font-size: var(--text-base);
      font-weight: var(--font-medium);
      text-decoration: none;
      border: 1px solid transparent;
      cursor: pointer;
      transition: var(--transition-fast);
    }

    .btn-primary {
      background: var(--primary-gradient);
      color: var(--text-inverse);
      border-color: var(--primary-blue);
    }

    .btn-primary:hover {
      transform: translateY(-1px);
      box-shadow: var(--shadow-md);
    }

    .btn-secondary {
      background: var(--bg-primary);
      color: var(--text-secondary);
      border-color: var(--border-medium);
    }

    .btn-secondary:hover {
      background: var(--bg-muted);
      color: var(--text-primary);
    }

    /* Priority Classes */
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

    /* Responsive Design */
    @media (max-width: 768px) {
      .form-grid {
        grid-template-columns: 1fr;
      }

      .color-picker-container {
        flex-direction: column;
        align-items: flex-start;
        gap: var(--space-3);
      }

      .preview-header {
        flex-direction: column;
        gap: var(--space-3);
      }

      .form-actions {
        flex-direction: column;
      }

      .btn {
        justify-content: center;
      }
    }
  </style>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const nameInput = document.getElementById('name');
      const descriptionInput = document.getElementById('description');
      const targetAmountInput = document.getElementById('target_amount');
      const targetDateInput = document.getElementById('target_date');
      const priorityInput = document.getElementById('priority');
      const colorInput = document.getElementById('color');

      const previewName = document.getElementById('previewName');
      const previewDescription = document.getElementById('previewDescription');
      const previewAmount = document.getElementById('previewAmount');
      const previewDate = document.getElementById('previewDate');
      const previewPriority = document.getElementById('previewPriority');
      const previewProgressBar = document.getElementById('previewProgressBar');
      const colorPreview = document.getElementById('colorPreview');
      const previewCard = document.getElementById('previewCard');

      // Color presets functionality
      const colorPresets = document.querySelectorAll('.color-preset');
      colorPresets.forEach(preset => {
        preset.addEventListener('click', function() {
          const color = this.getAttribute('data-color');
          colorInput.value = color;
          updatePreview();

          // Update active state
          colorPresets.forEach(p => p.classList.remove('active'));
          this.classList.add('active');
        });
      });

      function updatePreview() {
        // Update name
        const name = nameInput.value.trim();
        previewName.textContent = name || 'Your Goal Name';

        // Update description
        const description = descriptionInput.value.trim();
        if (description) {
          previewDescription.textContent = description;
          previewDescription.classList.add('show');
        } else {
          previewDescription.classList.remove('show');
        }

        // Update amount
        const amount = parseFloat(targetAmountInput.value) || 0;
        previewAmount.textContent = '$' + amount.toLocaleString('en-US', {
          minimumFractionDigits: 2,
          maximumFractionDigits: 2
        });

        // Update date
        if (targetDateInput.value) {
          const date = new Date(targetDateInput.value);
          const now = new Date();
          const timeDiff = date.getTime() - now.getTime();
          const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24));

          previewDate.textContent = date.toLocaleDateString('en-US', {
            month: 'short',
            day: 'numeric',
            year: 'numeric'
          }) + ` (${daysDiff} days)`;
        } else {
          previewDate.textContent = 'Target Date';
        }

        // Update priority
        const priority = priorityInput.value || 'medium';
        const priorityText = priority.charAt(0).toUpperCase() + priority.slice(1) + ' Priority';
        previewPriority.textContent = priorityText;
        previewPriority.className = `preview-priority priority-${priority}`;

        // Update color
        const color = colorInput.value;
        colorPreview.style.backgroundColor = color;
        previewCard.style.borderLeftColor = color;
        previewProgressBar.style.backgroundColor = color;

        // Update active color preset
        colorPresets.forEach(preset => {
          preset.classList.toggle('active', preset.getAttribute('data-color') === color);
        });
      }

      // Add event listeners
      nameInput.addEventListener('input', updatePreview);
      descriptionInput.addEventListener('input', updatePreview);
      targetAmountInput.addEventListener('input', updatePreview);
      targetDateInput.addEventListener('change', updatePreview);
      priorityInput.addEventListener('change', updatePreview);
      colorInput.addEventListener('change', updatePreview);

      // Initial update
      updatePreview();

      // Form validation enhancement
      const form = document.querySelector('.goal-form');
      form.addEventListener('submit', function(e) {
        const amount = parseFloat(targetAmountInput.value);
        const targetDate = new Date(targetDateInput.value);
        const now = new Date();

        if (amount < 1) {
          e.preventDefault();
          alert('Target amount must be at least $1.00');
          targetAmountInput.focus();
          return;
        }

        if (targetDate <= now) {
          e.preventDefault();
          alert('Target date must be in the future');
          targetDateInput.focus();
          return;
        }
      });
    });
  </script>
@endsection
