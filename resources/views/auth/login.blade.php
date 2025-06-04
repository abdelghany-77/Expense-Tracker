@extends('layouts.guest')

@section('content')
  <div class="auth-container">
    <div class="auth-card">
      <div class="auth-header">
        <h2>Welcome Back</h2>
        <p>Sign in to your expense tracker account</p>
      </div>

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
          <label for="email" class="form-label">Email Address</label>
          <input id="email" type="email" name="email" value="{{ old('email') }}"
            class="form-input @error('email') error @enderror" required autofocus>
          @error('email')
            <div class="error-message">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="password" class="form-label">Password</label>
          <input id="password" type="password" name="password" class="form-input @error('password') error @enderror"
            required>
          @error('password')
            <div class="error-message">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label class="checkbox-label">
            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
            <span class="checkmark"></span>
            Remember me
          </label>
        </div>

        <button type="submit" class="btn btn-primary btn-full">
          Sign In
        </button>

        <div class="auth-links">
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}">Forgot your password?</a>
          @endif

          <p>Don't have an account? <a href="{{ route('register') }}">Sign up here</a></p>
        </div>
      </form>
    </div>
  </div>
@endsection
