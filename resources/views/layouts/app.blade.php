<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="@yield('meta-description', 'Professional expense tracking and financial management system')">
  <meta name="keywords" content="@yield('meta-keywords', 'expense tracker, financial management, budgeting, savings goals')">
  <meta name="author" content="Expense Tracker">

  <!-- Open Graph Meta Tags -->
  <meta property="og:title" content="@yield('title', 'Expense Tracker')">
  <meta property="og:description" content="@yield('meta-description', 'Professional expense tracking and financial management system')">
  <meta property="og:type" content="website">
  <meta property="og:url" content="{{ url()->current() }}">

  <title>@yield('title', 'Expense Tracker') - Professional Financial Management</title>

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="/favicon.ico">
  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
    rel="stylesheet">

  <!-- Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lucide@latest/dist/umd/lucide.js">

  <!-- Main Styles -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

  @stack('styles')

  <style>
    /*  Layout Styles */
    :root {
      /* Primary Financial Blues - Trust & Stability */
      --primary-blue: #1e40af;
      /* Deep trust blue */
      --primary-blue-light: #2563eb;
      /* Lighter professional blue */
      --primary-blue-dark: #1e3a8a;
      /* Dark navy for depth */
      --primary-blue-50: #eff6ff;
      /* Very light blue wash */
      --primary-blue-100: #dbeafe;
      /* Light blue background */
      --primary-blue-200: #bfdbfe;
      /* Soft blue accent */
      --primary-blue-300: #93c5fd;
      /* Medium blue */
      --primary-blue-400: #60a5fa;
      /* Bright blue */
      --primary-blue-500: #3b82f6;
      /* Standard blue */
      --primary-blue-600: var(--primary-blue);
      /* Main brand blue */
      --primary-blue-700: var(--primary-blue-dark);
      /* Dark blue */
      --primary-blue-800: #1e3a8a;
      /* Deeper blue */
      --primary-blue-900: #1e3a8a;
      /* Darkest blue */

      /* Success & Growth Greens - Prosperity & Positive Returns */
      --success-green: #16a34a;
      /* Vibrant success green */
      --success-green-light: #22c55e;
      /* Lighter success */
      --success-green-dark: #15803d;
      /* Darker success */
      --secondary-green: #059669;
      /* Investment green */
      --secondary-green-light: #10b981;
      /* Lighter investment green */
      --secondary-green-dark: #047857;
      /* Deep forest green */
      --money-green: #16a34a;
      /* Money/profit green */
      --growth-green: #22c55e;
      /* Growth indicator */

      /* Premium Wealth Colors - Luxury & High Value */
      --accent-gold: #f59e0b;
      /* Rich gold */
      --accent-gold-light: #fbbf24;
      /* Lighter gold */
      --accent-gold-dark: #d97706;
      /* Deeper gold */
      --premium-gold: #eab308;
      /* Premium gold accent */
      --bronze: #ea580c;
      /* Bronze/copper */
      --platinum: #71717a;
      /* Platinum gray */

      /* Alert & Status Colors - Clear Communication */
      --danger-red: #dc2626;
      /* Loss/debt red */
      --danger-red-light: #ef4444;
      /* Lighter alert red */
      --danger-red-dark: #b91c1c;
      /* Deep warning red */
      --warning-amber: #f59e0b;
      /* Caution amber */
      --warning-amber-light: #fbbf24;
      /* Light warning */
      --warning-amber-dark: #d97706;
      /* Deep amber */
      --info-cyan: #0891b2;
      /* Information cyan */
      --info-cyan-light: #06b6d4;
      /* Light info blue */
      --info-cyan-dark: #0e7490;
      /* Deep info blue */

      /* Neutral Professional Grays */
      --neutral-50: #f8fafc;
      /* Lightest gray */
      --neutral-100: #f1f5f9;
      /* Very light gray */
      --neutral-200: #e2e8f0;
      /* Light gray */
      --neutral-300: #cbd5e1;
      /* Medium-light gray */
      --neutral-400: #94a3b8;
      /* Medium gray */
      --neutral-500: #64748b;
      /* Standard gray */
      --neutral-600: #475569;
      /* Medium-dark gray */
      --neutral-700: #334155;
      /* Dark gray */
      --neutral-800: #1e293b;
      /* Very dark gray */
      --neutral-900: #0f172a;
      /* Darkest gray */

      /* ========================================
     FINANCIAL GRADIENTS
     ======================================== */

      --primary-gradient: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
      --success-gradient: linear-gradient(135deg, var(--success-green) 0%, var(--success-green-dark) 100%);
      --wealth-gradient: linear-gradient(135deg, var(--accent-gold) 0%, var(--accent-gold-dark) 100%);
      --premium-gradient: linear-gradient(135deg, var(--premium-gold) 0%, var(--bronze) 100%);
      --danger-gradient: linear-gradient(135deg, var(--danger-red) 0%, var(--danger-red-dark) 100%);
      --warning-gradient: linear-gradient(135deg, var(--warning-amber) 0%, var(--warning-amber-dark) 100%);
      --info-gradient: linear-gradient(135deg, var(--info-cyan) 0%, var(--info-cyan-dark) 100%);
      --neutral-gradient: linear-gradient(135deg, var(--neutral-500) 0%, var(--neutral-700) 100%);

      /* Hero & Background Gradients */
      --hero-gradient: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 40%, var(--success-green-dark) 100%);
      --card-gradient: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.8) 100%);
      --glass-gradient: linear-gradient(135deg, rgba(30, 64, 175, 0.08) 0%, rgba(22, 163, 74, 0.05) 100%);

      /* ========================================
      GLASS MORPHISM
     ======================================== */

      --glass-bg: rgba(255, 255, 255, 0.08);
      /* Subtle glass */
      --glass-bg-light: rgba(255, 255, 255, 0.05);
      /* Very light glass */
      --glass-bg-medium: rgba(255, 255, 255, 0.15);
      /* Medium glass */
      --glass-bg-strong: rgba(255, 255, 255, 0.25);
      /* Strong glass */
      --glass-bg-heavy: rgba(255, 255, 255, 0.35);
      /* Heavy glass */

      --glass-border: rgba(255, 255, 255, 0.18);
      /* Glass border */
      --glass-border-light: rgba(255, 255, 255, 0.12);
      /* Light glass border */
      --glass-border-strong: rgba(255, 255, 255, 0.25);
      /* Strong glass border */

      --glass-backdrop: blur(24px);
      /* Enhanced blur */
      --glass-backdrop-light: blur(16px);
      /* Light blur */
      --glass-backdrop-heavy: blur(32px);
      /* Heavy blur */

      /* Financial Themed Glass */
      --glass-financial: rgba(30, 64, 175, 0.08);
      /* Blue-tinted glass */
      --glass-success: rgba(22, 163, 74, 0.08);
      /* Green-tinted glass */
      --glass-warning: rgba(245, 158, 11, 0.08);
      /* Amber-tinted glass */
      --glass-danger: rgba(220, 38, 38, 0.08);
      /* Red-tinted glass */

      /* ========================================
      SHADOW SYSTEM
     ======================================== */

      /* Standard Shadows */
      --shadow-xs: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
      --shadow-sm: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
      --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
      --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);
      --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
      --shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
      --shadow-inner: inset 0 2px 4px 0 rgba(0, 0, 0, 0.05);

      /* Enhanced Financial Shadows */
      --shadow-focus: 0 0 0 3px rgba(30, 64, 175, 0.25);
      --shadow-primary: 0 4px 14px rgba(30, 64, 175, 0.15);
      --shadow-success: 0 4px 14px rgba(22, 163, 74, 0.15);
      --shadow-warning: 0 4px 14px rgba(245, 158, 11, 0.15);
      --shadow-danger: 0 4px 14px rgba(220, 38, 38, 0.15);
      --shadow-gold: 0 4px 14px rgba(245, 158, 11, 0.2);

      /* Glow Effects for Premium Elements */
      --glow-primary: 0 0 20px rgba(30, 64, 175, 0.3);
      --glow-success: 0 0 20px rgba(22, 163, 74, 0.3);
      --glow-gold: 0 0 20px rgba(245, 158, 11, 0.4);

      /* ========================================
      SPACING SYSTEM
     ======================================== */

      --space-0: 0;
      --space-px: 1px;
      --space-0-5: 0.125rem;
      /* 2px */
      --space-1: 0.25rem;
      /* 4px */
      --space-1-5: 0.375rem;
      /* 6px */
      --space-2: 0.5rem;
      /* 8px */
      --space-2-5: 0.625rem;
      /* 10px */
      --space-3: 0.75rem;
      /* 12px */
      --space-3-5: 0.875rem;
      /* 14px */
      --space-4: 1rem;
      /* 16px */
      --space-5: 1.25rem;
      /* 20px */
      --space-6: 1.5rem;
      /* 24px */
      --space-7: 1.75rem;
      /* 28px */
      --space-8: 2rem;
      /* 32px */
      --space-9: 2.25rem;
      /* 36px */
      --space-10: 2.5rem;
      /* 40px */
      --space-11: 2.75rem;
      /* 44px */
      --space-12: 3rem;
      /* 48px */
      --space-14: 3.5rem;
      /* 56px */
      --space-16: 4rem;
      /* 64px */
      --space-20: 5rem;
      /* 80px */
      --space-24: 6rem;
      /* 96px */
      --space-28: 7rem;
      /* 112px */
      --space-32: 8rem;
      /* 128px */
      --space-36: 9rem;
      /* 144px */
      --space-40: 10rem;
      /* 160px */
      --space-44: 11rem;
      /* 176px */
      --space-48: 12rem;
      /* 192px */
      --space-52: 13rem;
      /* 208px */
      --space-56: 14rem;
      /* 224px */
      --space-60: 15rem;
      /* 240px */
      --space-64: 16rem;
      /* 256px */
      --space-72: 18rem;
      /* 288px */
      --space-80: 20rem;
      /* 320px */
      --space-96: 24rem;
      /* 384px */

      /* ========================================
      TYPOGRAPHY SYSTEM
     ======================================== */

      /* Font Sizes */
      --text-xs: 0.75rem;
      /* 12px */
      --text-sm: 0.875rem;
      /* 14px */
      --text-base: 1rem;
      /* 16px */
      --text-lg: 1.125rem;
      /* 18px */
      --text-xl: 1.25rem;
      /* 20px */
      --text-2xl: 1.5rem;
      /* 24px */
      --text-3xl: 1.875rem;
      /* 30px */
      --text-4xl: 2.25rem;
      /* 36px */
      --text-5xl: 3rem;
      /* 48px */
      --text-6xl: 3.75rem;
      /* 60px */
      --text-7xl: 4.5rem;
      /* 72px */
      --text-8xl: 6rem;
      /* 96px */
      --text-9xl: 8rem;
      /* 128px */

      /* Font Weights */
      --font-thin: 100;
      --font-extralight: 200;
      --font-light: 300;
      --font-normal: 400;
      --font-medium: 500;
      --font-semibold: 600;
      --font-bold: 700;
      --font-extrabold: 800;
      --font-black: 900;

      /* Line Heights */
      --leading-3: 0.75rem;
      /* 12px */
      --leading-4: 1rem;
      /* 16px */
      --leading-5: 1.25rem;
      /* 20px */
      --leading-6: 1.5rem;
      /* 24px */
      --leading-7: 1.75rem;
      /* 28px */
      --leading-8: 2rem;
      /* 32px */
      --leading-9: 2.25rem;
      /* 36px */
      --leading-10: 2.5rem;
      /* 40px */
      --leading-none: 1;
      --leading-tight: 1.25;
      --leading-snug: 1.375;
      --leading-normal: 1.5;
      --leading-relaxed: 1.625;
      --leading-loose: 2;

      /* ========================================
      COLOR SYSTEM
     ======================================== */

      /* Text Colors */
      --text-primary: var(--neutral-900);
      /* #0f172a */
      --text-secondary: var(--neutral-600);
      /* #475569 */
      --text-muted: var(--neutral-500);
      /* #64748b */
      --text-light: var(--neutral-400);
      /* #94a3b8 */
      --text-inverse: #ffffff;

      /* Financial Status Text */
      --text-profit: var(--success-green);
      --text-loss: var(--danger-red);
      --text-neutral: var(--neutral-500);
      --text-warning: var(--warning-amber);
      --text-info: var(--info-cyan);
      --text-premium: var(--accent-gold);

      /* Background Colors */
      --bg-primary: #ffffff;
      --bg-secondary: var(--neutral-50);
      /* #f8fafc */
      --bg-muted: var(--neutral-100);
      /* #f1f5f9 */
      --bg-accent: #eff6ff;

      /* Status Backgrounds */
      --bg-success: #f0fdf4;
      --bg-warning: #fffbeb;
      --bg-danger: #fef2f2;
      --bg-info: #f0f9ff;
      --bg-premium: #fefce8;

      /* Border Colors */
      --border-light: var(--neutral-200);
      /* #e2e8f0 */
      --border-medium: var(--neutral-300);
      /* #cbd5e1 */
      --border-dark: var(--neutral-500);
      /* #64748b */

      /* Status Borders */
      --border-success: rgba(22, 163, 74, 0.3);
      --border-warning: rgba(245, 158, 11, 0.3);
      --border-danger: rgba(220, 38, 38, 0.3);
      --border-info: rgba(8, 145, 178, 0.3);
      --border-premium: rgba(245, 158, 11, 0.3);

      /* ========================================
      TRANSITIONS
     ======================================== */

      --transition-none: none;
      --transition-all: all;
      --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
      --transition-normal: 300ms cubic-bezier(0.4, 0, 0.2, 1);
      --transition-slow: 500ms cubic-bezier(0.4, 0, 0.2, 1);
      --transition-slower: 700ms cubic-bezier(0.4, 0, 0.2, 1);

      /* Specialized Transitions */
      --transition-bounce: 600ms cubic-bezier(0.68, -0.55, 0.265, 1.55);
      --transition-spring: 400ms cubic-bezier(0.175, 0.885, 0.32, 1.275);
      --transition-smooth: 300ms cubic-bezier(0.25, 0.46, 0.45, 0.94);
      --transition-sharp: 200ms cubic-bezier(0.4, 0, 1, 1);

      /* ========================================
     FINANCIAL COMPONENT COLORS
     ======================================== */

      /* Category Colors */
      --category-housing: #8b5cf6;
      /* Purple */
      --category-food: var(--warning-amber);
      /* Orange */
      --category-transport: var(--info-cyan);
      /* Cyan */
      --category-healthcare: #ef4444;
      /* Red */
      --category-entertainment: #ec4899;
      /* Pink */
      --category-education: var(--primary-blue-light);
      /* Blue */
      --category-shopping: #a855f7;
      /* Violet */
      --category-utilities: #84cc16;
      /* Lime */
      --category-insurance: var(--neutral-500);
      /* Gray */
      --category-savings: var(--success-green);
      /* Green */
      --category-investment: var(--accent-gold);
      /* Gold */
      --category-debt: var(--danger-red);
      /* Red */

      /* Chart & Visualization Colors */
      --chart-primary: var(--primary-blue);
      --chart-secondary: var(--success-green);
      --chart-tertiary: var(--accent-gold);
      --chart-quaternary: var(--danger-red);
      --chart-quinary: var(--info-cyan);

      /* Financial Metrics */
      --metric-excellent: var(--success-green);
      --metric-good: #22c55e;
      --metric-average: var(--warning-amber);
      --metric-poor: var(--bronze);
      --metric-critical: var(--danger-red);

      /* ========================================
     RESPONSIVE & ACCESSIBILITY
     ======================================== */

      /* Focus States */
      --focus-ring-width: 2px;
      --focus-ring-offset: 2px;
      --focus-ring-primary: rgba(30, 64, 175, 0.5);
      --focus-ring-success: rgba(22, 163, 74, 0.5);
      --focus-ring-warning: rgba(245, 158, 11, 0.5);
      --focus-ring-danger: rgba(220, 38, 38, 0.5);

      /* Z-Index Scale */
      --z-auto: auto;
      --z-0: 0;
      --z-10: 10;
      --z-20: 20;
      --z-30: 30;
      --z-40: 40;
      --z-50: 50;
      --z-dropdown: 1000;
      --z-sticky: 1020;
      --z-fixed: 1030;
      --z-modal-backdrop: 1040;
      --z-modal: 1050;
      --z-popover: 1060;
      --z-tooltip: 1070;
      --z-toast: 1080;

      /* Breakpoint Values (for JavaScript) */
      --screen-sm: 640px;
      --screen-md: 768px;
      --screen-lg: 1024px;
      --screen-xl: 1280px;
      --screen-2xl: 1536px;
    }

    /* ========================================
   RESPONSIVE THEME VARIATIONS
   ======================================== */

    /* Dark Theme Support */
    @media (prefers-color-scheme: dark) {
      :root {
        --glass-bg: rgba(15, 23, 42, 0.8);
        --glass-bg-strong: rgba(15, 23, 42, 0.9);
        --glass-border: rgba(255, 255, 255, 0.1);
        --text-primary: #f8fafc;
        --text-secondary: #cbd5e1;
        --bg-primary: #0f172a;
        --bg-secondary: #1e293b;
        --border-light: #334155;
        --border-medium: #475569;
      }
    }

    /* High Contrast Support */
    @media (prefers-contrast: high) {
      :root {
        --border-light: rgba(30, 64, 175, 0.4);
        --border-medium: rgba(30, 64, 175, 0.6);
        --text-muted: var(--text-secondary);
        --glass-bg: rgba(255, 255, 255, 0.95);
        --glass-bg-strong: rgba(255, 255, 255, 0.98);
      }
    }

    /* Reduced Motion Support */
    @media (prefers-reduced-motion: reduce) {
      :root {
        --transition-fast: none;
        --transition-normal: none;
        --transition-slow: none;
        --transition-bounce: none;
        --transition-spring: none;
        --transition-smooth: none;
      }
    }

    /* Reset and Base Styles */
    *,
    *::before,
    *::after {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    html {
      scroll-behavior: smooth;
      font-size: 16px;
    }

    body {
      font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      font-feature-settings: 'kern' 1, 'liga' 1, 'calt' 1;
      background: linear-gradient(135deg, var(--primary-blue) 0%, var(--primary-blue-dark) 100%);
      background-attachment: fixed;
      color: var(--text-primary);
      line-height: 1.6;
      min-height: 100vh;
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      overflow-x: hidden;
    }

    /* Skip Link for Accessibility */
    .skip-link {
      position: absolute;
      top: -40px;
      left: var(--space-2);
      background: var(--text-primary);
      color: var(--text-inverse);
      padding: var(--space-2) var(--space-4);
      text-decoration: none;
      z-index: 1000;
      border-radius: var(--space-1);
      font-weight: 600;
      transition: var(--transition-fast);
    }

    .skip-link:focus {
      top: var(--space-2);
    }

    /* Focus Management */
    *:focus {
      outline: none;
    }

    *:focus-visible {
      box-shadow: var(--shadow-focus);
      outline: 2px solid transparent;
      outline-offset: 2px;
    }

    /*  Navigation */
    .navbar {
      background: var(--glass-bg-strong);
      backdrop-filter: var(--glass-backdrop);
      border-bottom: 1px solid var(--glass-border);
      padding: var(--space-4) 0;
      position: sticky;
      top: 0;
      z-index: 100;
      box-shadow: var(--shadow-md);
    }

    .container {
      max-width: 1400px;
      margin: 0 auto;
      padding: 0 var(--space-4);
      position: relative;
    }

    .nav-content {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: var(--space-8);
    }

    .nav-brand {
      color: var(--text-inverse);
      font-size: var(--text-2xl);
      font-weight: 800;
      text-decoration: none;
      transition: var(--transition-fast);
      display: flex;
      align-items: center;
      gap: var(--space-2);
    }

    .nav-brand:hover {
      opacity: 0.9;
      transform: scale(1.02);
    }

    .nav-brand .brand-icon {
      font-size: var(--text-3xl);
      background: var(--accent-gold);
      border-radius: 50%;
      width: 40px;
      height: 40px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: var(--shadow-md);
    }

    .nav-links {
      display: flex;
      list-style: none;
      gap: var(--space-6);
      align-items: center;
      margin: 0;
    }

    .nav-links li {
      position: relative;
    }

    .nav-links a {
      color: var(--text-inverse);
      text-decoration: none;
      padding: var(--space-3) var(--space-4);
      border-radius: var(--space-3);
      font-weight: 600;
      font-size: var(--text-sm);
      transition: var(--transition-fast);
      position: relative;
      display: flex;
      align-items: center;
      gap: var(--space-2);
      white-space: nowrap;
    }

    .nav-links a:hover,
    .nav-links a:focus-visible {
      background-color: rgba(255, 255, 255, 0.15);
      transform: translateY(-1px);
    }

    .nav-links a.active {
      background-color: rgba(255, 255, 255, 0.2);
      box-shadow: var(--shadow-sm);
    }

    .nav-links a::before {
      content: '';
      position: absolute;
      bottom: -8px;
      left: 50%;
      width: 0;
      height: 2px;
      background: var(--accent-gold);
      border-radius: 1px;
      transition: var(--transition-fast);
      transform: translateX(-50%);
    }

    .nav-links a:hover::before,
    .nav-links a.active::before {
      width: 80%;
    }

    /* Mobile Navigation */
    .mobile-nav-toggle {
      display: none;
      background: none;
      border: none;
      color: var(--text-inverse);
      font-size: var(--text-2xl);
      cursor: pointer;
      padding: var(--space-2);
      border-radius: var(--space-2);
      transition: var(--transition-fast);
    }

    .mobile-nav-toggle:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }

    .logout-btn {
      background: linear-gradient(135deg, var(--danger-red) 0%, #b91c1c 100%);
      border: none;
      color: var(--text-inverse);
      padding: var(--space-3) var(--space-5);
      border-radius: var(--space-3);
      font-weight: 600;
      font-size: var(--text-sm);
      cursor: pointer;
      transition: var(--transition-fast);
      display: flex;
      align-items: center;
      gap: var(--space-2);
      box-shadow: var(--shadow-sm);
    }

    .logout-btn:hover,
    .logout-btn:focus-visible {
      transform: translateY(-1px);
      box-shadow: var(--shadow-md);
    }

    /* Main Content */
    .main-content {
      margin-top: var(--space-8);
      padding-bottom: var(--space-20);
      min-height: calc(100vh - 200px);
    }

    /*  Alerts */
    .alert {
      padding: var(--space-4) var(--space-6);
      border-radius: var(--space-4);
      margin-bottom: var(--space-6);
      border: 1px solid;
      display: flex;
      align-items: center;
      gap: var(--space-3);
      font-weight: 500;
      box-shadow: var(--shadow-sm);
      position: relative;
      overflow: hidden;
    }

    .alert::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 4px;
      background: currentColor;
    }

    .alert-success {
      background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(5, 150, 105, 0.05) 100%);
      border-color: var(--secondary-green);
      color: #065f46;
    }

    .alert-error {
      background: linear-gradient(135deg, rgba(220, 38, 38, 0.1) 0%, rgba(185, 28, 28, 0.05) 100%);
      border-color: var(--danger-red);
      color: #991b1b;
    }

    .alert-warning {
      background: linear-gradient(135deg, rgba(245, 158, 11, 0.1) 0%, rgba(217, 119, 6, 0.05) 100%);
      border-color: var(--warning-amber);
      color: #92400e;
    }

    .alert-info {
      background: linear-gradient(135deg, rgba(8, 145, 178, 0.1) 0%, rgba(6, 95, 70, 0.05) 100%);
      border-color: var(--info-cyan);
      color: #0c4a6e;
    }

    .alert-icon {
      font-size: var(--text-lg);
      flex-shrink: 0;
    }

    .alert-close {
      margin-left: auto;
      background: none;
      border: none;
      color: currentColor;
      cursor: pointer;
      padding: var(--space-1);
      border-radius: var(--space-1);
      opacity: 0.7;
      transition: var(--transition-fast);
    }

    .alert-close:hover {
      opacity: 1;
      background: rgba(0, 0, 0, 0.1);
    }

    /* Page Header */
    .page-header {
      background: var(--glass-bg-strong);
      backdrop-filter: var(--glass-backdrop);
      border: 1px solid var(--glass-border);
      border-radius: var(--space-6);
      padding: var(--space-8);
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
      background: linear-gradient(135deg, var(--primary-blue) 0%, var(--secondary-green) 100%);
      opacity: 0.05;
      border-radius: var(--space-6);
    }

    .page-header-content {
      position: relative;
      z-index: 2;
    }

    .page-title {
      font-size: var(--text-3xl);
      font-weight: 800;
      color: var(--text-inverse);
      margin-bottom: var(--space-2);
      display: flex;
      align-items: center;
      gap: var(--space-3);
    }

    .page-subtitle {
      color: var(--text-light);
      font-size: var(--text-lg);
      font-weight: 500;
      margin: 0;
    }

    /* Content Cards */
    .content-card {
      background: var(--glass-bg-strong);
      backdrop-filter: var(--glass-backdrop);
      border: 1px solid var(--glass-border);
      border-radius: var(--space-6);
      padding: var(--space-8);
      margin-bottom: var(--space-8);
      box-shadow: var(--shadow-lg);
      transition: var(--transition-normal);
    }

    .content-card:hover {
      transform: translateY(-2px);
      box-shadow: var(--shadow-xl);
    }

    .content-card-header {
      display: flex;
      justify-content: between;
      align-items: center;
      margin-bottom: var(--space-6);
      padding-bottom: var(--space-4);
      border-bottom: 1px solid var(--border-light);
    }

    .content-card-title {
      font-size: var(--text-xl);
      font-weight: 700;
      color: var(--text-primary);
      margin: 0;
    }

    /*  Charts */
    .chart-container {
      position: relative;
      height: 400px;
      background: var(--bg-primary);
      border-radius: var(--space-4);
      padding: var(--space-4);
      box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
      border: 1px solid var(--border-light);
    }

    .chart-loading {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: var(--space-4);
      color: var(--text-muted);
      font-weight: 600;
    }

    .loading-spinner {
      width: 40px;
      height: 40px;
      border: 4px solid var(--border-light);
      border-top: 4px solid var(--primary-blue);
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    /* Footer */
    .footer {
      background: var(--glass-bg-strong);
      backdrop-filter: var(--glass-backdrop);
      border-top: 1px solid var(--glass-border);
      padding: var(--space-8) 0;
      margin-top: var(--space-20);
      color: var(--text-light);
      text-align: center;
    }

    .footer-content {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-wrap: wrap;
      gap: var(--space-4);
    }

    .footer-links {
      display: flex;
      gap: var(--space-6);
      list-style: none;
    }

    .footer-links a {
      color: var(--text-light);
      text-decoration: none;
      font-weight: 500;
      transition: var(--transition-fast);
    }

    .footer-links a:hover {
      color: var(--text-inverse);
    }

    /* Breadcrumbs */
    .breadcrumbs {
      display: flex;
      align-items: center;
      gap: var(--space-2);
      margin-bottom: var(--space-6);
      padding: var(--space-3) var(--space-4);
      background: var(--glass-bg);
      backdrop-filter: var(--glass-backdrop);
      border-radius: var(--space-3);
      border: 1px solid var(--glass-border);
    }

    .breadcrumb-item {
      color: var(--text-light);
      text-decoration: none;
      font-weight: 500;
      transition: var(--transition-fast);
    }

    .breadcrumb-item:hover {
      color: var(--text-inverse);
    }

    .breadcrumb-item.active {
      color: var(--text-inverse);
      font-weight: 600;
    }

    .breadcrumb-separator {
      color: var(--text-muted);
      margin: 0 var(--space-1);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .mobile-nav-toggle {
        display: block;
      }

      .nav-links {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        background: var(--glass-bg-strong);
        backdrop-filter: var(--glass-backdrop);
        border: 1px solid var(--glass-border);
        border-top: none;
        border-radius: 0 0 var(--space-4) var(--space-4);
        flex-direction: column;
        padding: var(--space-4);
        gap: var(--space-2);
        transform: translateY(-100%);
        opacity: 0;
        visibility: hidden;
        transition: var(--transition-normal);
        z-index: 50;
      }

      .nav-links.active {
        transform: translateY(0);
        opacity: 1;
        visibility: visible;
      }

      .nav-links a {
        width: 100%;
        justify-content: flex-start;
        padding: var(--space-4);
        border-radius: var(--space-3);
      }

      .nav-links a::before {
        display: none;
      }

      .page-title {
        font-size: var(--text-2xl);
      }

      .container {
        padding: 0 var(--space-3);
      }

      .content-card {
        padding: var(--space-6);
      }

      .footer-content {
        flex-direction: column;
        text-align: center;
      }
    }

    @media (max-width: 640px) {
      .nav-content {
        gap: var(--space-4);
      }

      .nav-brand {
        font-size: var(--text-xl);
      }

      .nav-brand .brand-icon {
        width: 32px;
        height: 32px;
        font-size: var(--text-xl);
      }

      .page-header {
        padding: var(--space-6);
      }

      .chart-container {
        height: 300px;
      }
    }

    /* Loading States */
    .loading {
      opacity: 0.6;
      pointer-events: none;
    }

    .skeleton {
      background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
      background-size: 200% 100%;
      animation: loading 1.5s infinite;
      border-radius: var(--space-2);
    }

    @keyframes loading {
      0% {
        background-position: 200% 0;
      }

      100% {
        background-position: -200% 0;
      }
    }

    /* Accessibility & Preferences */
    @media (prefers-reduced-motion: reduce) {
      * {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
      }
    }

    @media (prefers-contrast: high) {
      :root {
        --glass-bg: rgba(255, 255, 255, 0.95);
        --glass-bg-strong: rgba(255, 255, 255, 0.98);
        --glass-border: rgba(0, 0, 0, 0.3);
        --text-muted: var(--text-secondary);
        --border-light: rgba(0, 0, 0, 0.2);
      }
    }

    /* Print Styles */
    @media print {

      .navbar,
      .footer,
      .alert {
        display: none !important;
      }

      body {
        background: white !important;
        color: black !important;
      }

      .content-card,
      .page-header {
        background: white !important;
        border: 1px solid #000 !important;
        box-shadow: none !important;
      }
    }
  </style>
</head>

<body>
  <!--  Navigation -->
  <nav class="navbar" role="navigation" aria-label="Main navigation">
    <div class="container">
      <div class="nav-content">
        <a href="{{ route('dashboard') }}" class="nav-brand" aria-label="Expense Tracker Home">
          <span>Expense Tracker</span>
        </a>

        @auth
          <button class="mobile-nav-toggle" aria-label="Toggle navigation menu" onclick="toggleMobileNav()">
            <span id="nav-icon">☰</span>
          </button>

          <ul class="nav-links" id="nav-links" role="menubar">
            <li role="none">
              <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"
                role="menuitem" aria-current="{{ request()->routeIs('dashboard') ? 'page' : 'false' }}">
                <span></span> Dashboard
              </a>
            </li>
            <li role="none">
              <a href="{{ route('transactions.index') }}"
                class="{{ request()->routeIs('transactions.*') ? 'active' : '' }}" role="menuitem"
                aria-current="{{ request()->routeIs('transactions.*') ? 'page' : 'false' }}">
                <span></span> Transactions
              </a>
            </li>
            <li role="none">
              <a href="{{ route('financial-plans.index') }}"
                class="{{ request()->routeIs('financial-plans.*') ? 'active' : '' }}" role="menuitem"
                aria-current="{{ request()->routeIs('financial-plans.*') ? 'page' : 'false' }}">
                <span></span> Plans
              </a>
            </li>
            <li role="none">
              <a href="{{ route('savings-goals.index') }}"
                class="{{ request()->routeIs('savings-goals.*') ? 'active' : '' }}" role="menuitem"
                aria-current="{{ request()->routeIs('savings-goals.*') ? 'page' : 'false' }}">
                <span></span> Goals
              </a>
            </li>
            <li role="none">
              <a href="{{ route('reports.index') }}" class="{{ request()->routeIs('reports.*') ? 'active' : '' }}"
                role="menuitem" aria-current="{{ request()->routeIs('reports.*') ? 'page' : 'false' }}">
                <span></span> Reports
              </a>
            </li>
            <li role="none">
              <a href="{{ route('expense-categories.index') }}"
                class="{{ request()->routeIs('expense-categories.*') ? 'active' : '' }}" role="menuitem"
                aria-current="{{ request()->routeIs('expense-categories.*') ? 'page' : 'false' }}">
                <span></span> Categories
              </a>
            </li>
            <li role="none">
              <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="logout-btn" role="menuitem" aria-label="Logout from your account">
                  <span></span> Logout
                </button>
              </form>
            </li>
          </ul>
        @endauth

        @guest
          <div class="auth-links">
            <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
            <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
          </div>
        @endguest
      </div>
    </div>
  </nav>

  <!-- Breadcrumbs -->
  @if (!request()->routeIs('dashboard'))
    <div class="container">
      <nav class="breadcrumbs" aria-label="Breadcrumb">
        <a href="{{ route('dashboard') }}" class="breadcrumb-item">
          <span>🏠</span> Home
        </a>
        <span class="breadcrumb-separator">›</span>
        @yield('breadcrumbs')
        <span class="breadcrumb-item active">@yield('page-title')</span>
      </nav>
    </div>
  @endif

  <!-- Main Content -->
  <main id="main-content" class="main-content" role="main">
    <div class="container">
      <!-- Page Header -->
      @hasSection('page-header')
        <header class="page-header">
          <div class="page-header-content">
            @yield('page-header')
          </div>
        </header>
      @endif

      <!-- Flash Messages -->
      @if (session('success'))
        <div class="alert alert-success" role="alert" aria-live="polite">
          <span class="alert-icon">✅</span>
          <span>{{ session('success') }}</span>
          <button class="alert-close" onclick="this.parentElement.remove()" aria-label="Close message">×</button>
        </div>
      @endif

      @if (session('error'))
        <div class="alert alert-error" role="alert" aria-live="assertive">
          <span class="alert-icon">❌</span>
          <span>{{ session('error') }}</span>
          <button class="alert-close" onclick="this.parentElement.remove()" aria-label="Close message">×</button>
        </div>
      @endif

      @if (session('warning'))
        <div class="alert alert-warning" role="alert" aria-live="polite">
          <span class="alert-icon">⚠️</span>
          <span>{{ session('warning') }}</span>
          <button class="alert-close" onclick="this.parentElement.remove()" aria-label="Close message">×</button>
        </div>
      @endif

      @if (session('info'))
        <div class="alert alert-info" role="alert" aria-live="polite">
          <span class="alert-icon">ℹ️</span>
          <span>{{ session('info') }}</span>
          <button class="alert-close" onclick="this.parentElement.remove()" aria-label="Close message">×</button>
        </div>
      @endif

      <!-- Validation Errors -->
      @if ($errors->any())
        <div class="alert alert-error" role="alert" aria-live="assertive">
          <span class="alert-icon">❌</span>
          <div>
            <strong>Please fix the following errors:</strong>
            <ul style="margin: 0.5rem 0 0 1rem;">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          <button class="alert-close" onclick="this.parentElement.remove()" aria-label="Close message">×</button>
        </div>
      @endif

      <!-- Page Content -->
      @yield('content')
    </div>
  </main>

  <!--  Footer -->
  <footer class="footer" role="contentinfo">
    <div class="container ">
      <div class="footer-content ">
        <div class="footer-info">
          <p>&copy; {{ date('Y') }} Expense Tracker. All rights reserved.</p>
          <p>Welcome back, <strong>{{ auth()->user()->name ?? 'Guest' }}</p>
        </div>
      </div>
    </div>
  </footer>

  <!--  JavaScript -->
  <script>
    // Mobile Navigation Toggle
    function toggleMobileNav() {
      const navLinks = document.getElementById('nav-links');
      const navIcon = document.getElementById('nav-icon');

      navLinks.classList.toggle('active');
      navIcon.textContent = navLinks.classList.contains('active') ? '✕' : '☰';
    }

    // Auto-close mobile nav when clicking outside
    document.addEventListener('click', function(event) {
      const navLinks = document.getElementById('nav-links');
      const toggleBtn = document.querySelector('.mobile-nav-toggle');

      if (!event.target.closest('.nav-content') && navLinks.classList.contains('active')) {
        navLinks.classList.remove('active');
        document.getElementById('nav-icon').textContent = '☰';
      }
    });

    // Update current time
    function updateCurrentTime() {
      const timeElement = document.getElementById('current-time');
      if (timeElement) {
        const now = new Date();
        timeElement.textContent = now.toISOString().slice(0, 19).replace('T', ' ') + ' UTC';
      }
    }

    // Update time every minute
    setInterval(updateCurrentTime, 60000);

    //  Chart Implementation
    function createLineChart(canvasId, data, options = {}) {
      const canvas = document.getElementById(canvasId);
      if (!canvas) return;

      const ctx = canvas.getContext('2d');
      const rect = canvas.getBoundingClientRect();
      const dpr = window.devicePixelRatio || 1;

      canvas.width = rect.width * dpr;
      canvas.height = rect.height * dpr;
      ctx.scale(dpr, dpr);

      const width = rect.width;
      const height = rect.height;
      const padding = 50;
      const chartWidth = width - 2 * padding;
      const chartHeight = height - 2 * padding;

      // Clear canvas
      ctx.clearRect(0, 0, width, height);

      if (!data || data.length === 0) {
        ctx.fillStyle = '#64748b';
        ctx.font = '16px Inter, sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText('No data available', width / 2, height / 2);
        return;
      }

      // Find min and max values
      const values = data.map(d => d.value);
      const minValue = Math.min(...values);
      const maxValue = Math.max(...values);
      const valueRange = maxValue - minValue || 1;

      // Set styles
      ctx.strokeStyle = options.gridColor || '#e2e8f0';
      ctx.lineWidth = 1;

      // Draw grid
      const gridLines = 5;
      for (let i = 0; i <= gridLines; i++) {
        const y = padding + (chartHeight * i / gridLines);
        ctx.beginPath();
        ctx.moveTo(padding, y);
        ctx.lineTo(width - padding, y);
        ctx.stroke();

        // Y-axis labels
        const value = maxValue - (valueRange * i / gridLines);
        ctx.fillStyle = '#64748b';
        ctx.font = '12px Inter, sans-serif';
        ctx.textAlign = 'right';
        ctx.fillText('$' + value.toFixed(0), padding - 10, y + 4);
      }

      // Draw line and area
      if (data.length > 1) {
        // Create gradient
        const gradient = ctx.createLinearGradient(0, padding, 0, height - padding);
        gradient.addColorStop(0, (options.color || '#3b82f6') + '40');
        gradient.addColorStop(1, (options.color || '#3b82f6') + '00');

        // Draw area
        ctx.beginPath();
        data.forEach((point, index) => {
          const x = padding + (chartWidth * index / (data.length - 1));
          const y = height - padding - ((point.value - minValue) / valueRange * chartHeight);

          if (index === 0) {
            ctx.moveTo(x, height - padding);
            ctx.lineTo(x, y);
          } else {
            ctx.lineTo(x, y);
          }
        });
        ctx.lineTo(padding + chartWidth, height - padding);
        ctx.closePath();
        ctx.fillStyle = gradient;
        ctx.fill();

        // Draw line
        ctx.strokeStyle = options.color || '#3b82f6';
        ctx.lineWidth = 3;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        ctx.beginPath();

        data.forEach((point, index) => {
          const x = padding + (chartWidth * index / (data.length - 1));
          const y = height - padding - ((point.value - minValue) / valueRange * chartHeight);

          if (index === 0) {
            ctx.moveTo(x, y);
          } else {
            ctx.lineTo(x, y);
          }
        });
        ctx.stroke();

        // Draw points
        ctx.fillStyle = options.color || '#3b82f6';
        data.forEach((point, index) => {
          const x = padding + (chartWidth * index / (data.length - 1));
          const y = height - padding - ((point.value - minValue) / valueRange * chartHeight);

          ctx.beginPath();
          ctx.arc(x, y, 4, 0, 2 * Math.PI);
          ctx.fill();

          // Add white border to points
          ctx.strokeStyle = '#ffffff';
          ctx.lineWidth = 2;
          ctx.stroke();
        });
      }

      // Draw X-axis labels
      ctx.fillStyle = '#64748b';
      ctx.font = '12px Inter, sans-serif';
      ctx.textAlign = 'center';

      data.forEach((point, index) => {
        const x = padding + (chartWidth * index / (data.length - 1));
        ctx.fillText(point.label, x, height - 15);
      });
    }

    function createPieChart(canvasId, data, options = {}) {
      const canvas = document.getElementById(canvasId);
      if (!canvas) return;

      const ctx = canvas.getContext('2d');
      const rect = canvas.getBoundingClientRect();
      const dpr = window.devicePixelRatio || 1;

      canvas.width = rect.width * dpr;
      canvas.height = rect.height * dpr;
      ctx.scale(dpr, dpr);

      const width = rect.width;
      const height = rect.height;
      const centerX = width / 2;
      const centerY = height / 2;
      const radius = Math.min(width, height) / 2 - 30;

      ctx.clearRect(0, 0, width, height);

      if (!data || data.length === 0) {
        ctx.fillStyle = '#64748b';
        ctx.font = '16px Inter, sans-serif';
        ctx.textAlign = 'center';
        ctx.fillText('No data available', centerX, centerY);
        return;
      }

      const total = data.reduce((sum, item) => sum + item.value, 0);
      let currentAngle = -Math.PI / 2;

      const colors = [
        '#3b82f6', '#10b981', '#f59e0b', '#ef4444',
        '#8b5cf6', '#06b6d4', '#84cc16', '#f97316'
      ];

      data.forEach((item, index) => {
        const sliceAngle = (item.value / total) * 2 * Math.PI;
        const color = item.color || colors[index % colors.length];

        // Draw slice
        ctx.fillStyle = color;
        ctx.beginPath();
        ctx.moveTo(centerX, centerY);
        ctx.arc(centerX, centerY, radius, currentAngle, currentAngle + sliceAngle);
        ctx.closePath();
        ctx.fill();

        // Add border
        ctx.strokeStyle = '#ffffff';
        ctx.lineWidth = 2;
        ctx.stroke();

        // Draw label
        const labelAngle = currentAngle + sliceAngle / 2;
        const labelRadius = radius * 0.7;
        const labelX = centerX + Math.cos(labelAngle) * labelRadius;
        const labelY = centerY + Math.sin(labelAngle) * labelRadius;

        ctx.fillStyle = '#ffffff';
        ctx.font = 'bold 12px Inter, sans-serif';
        ctx.textAlign = 'center';
        ctx.shadowColor = 'rgba(0, 0, 0, 0.5)';
        ctx.shadowBlur = 2;

        const percentage = ((item.value / total) * 100).toFixed(1);
        ctx.fillText(`${percentage}%`, labelX, labelY);

        ctx.shadowBlur = 0;

        currentAngle += sliceAngle;
      });
    }

    // Utility functions for footer links
    function showPrivacyPolicy() {
      alert('Privacy Policy: We protect your financial data with enterprise-grade security.');
    }

    function showTermsOfService() {
      alert('Terms of Service: Please use this application responsibly for personal financial management.');
    }

    function showHelp() {
      alert('Help: Contact support at support@expensetracker.com for assistance.');
    }

    function showAbout() {
      alert(
        'Expense Tracker v2.0 - Professional Financial Management System\nBuilt with Laravel and modern web technologies.'
      );
    }

    // Initialize tooltips and other interactive elements
    document.addEventListener('DOMContentLoaded', function() {
      // Add smooth scrolling for anchor links
      document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
          e.preventDefault();
          const target = document.querySelector(this.getAttribute('href'));
          if (target) {
            target.scrollIntoView({
              behavior: 'smooth',
              block: 'start'
            });
          }
        });
      });

      // Auto-hide alerts after 5 seconds
      document.querySelectorAll('.alert').forEach(alert => {
        setTimeout(() => {
          if (alert.parentElement) {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';
            setTimeout(() => alert.remove(), 300);
          }
        }, 5000);
      });

      // Add keyboard navigation support
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
          // Close mobile nav
          const navLinks = document.getElementById('nav-links');
          if (navLinks && navLinks.classList.contains('active')) {
            navLinks.classList.remove('active');
            document.getElementById('nav-icon').textContent = '☰';
          }

          // Close alerts
          document.querySelectorAll('.alert').forEach(alert => {
            alert.remove();
          });
        }
      });
    });

    // Loading state management
    function showLoading(element) {
      element.classList.add('loading');
    }

    function hideLoading(element) {
      element.classList.remove('loading');
    }

    //  error handling
    window.addEventListener('error', function(e) {
      console.error('Application error:', e.error);
    });

    // Performance monitoring
    window.addEventListener('load', function() {
      if ('performance' in window) {
        const loadTime = performance.timing.loadEventEnd - performance.timing.navigationStart;
        console.log(`Page loaded in ${loadTime}ms`);
      }
    });
  </script>

  @stack('scripts')
</body>

</html>
