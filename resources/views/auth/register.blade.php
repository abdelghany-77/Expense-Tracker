@extends('layouts.guest')

@section('content')
  <div class="auth-container">
    <div class="auth-card">
      <div class="auth-header">
        <h2>Create Account</h2>
        <p>Start tracking your expenses today</p>
      </div>

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
          <label for="name" class="form-label">Full Name</label>
          <input id="name" type="text" name="name" value="{{ old('name') }}"
            class="form-input @error('name') error @enderror" required autofocus>
          @error('name')
            <div class="error-message">{{ $message }}</div>
          @enderror
        </div>

        <div class="form-group">
          <label for="email" class="form-label">Email Address</label>
          <input id="email" type="email" name="email" value="{{ old('email') }}"
            class="form-input @error('email') error @enderror" required>
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
          <label for="password_confirmation" class="form-label">Confirm Password</label>
          <input id="password_confirmation" type="password" name="password_confirmation" class="form-input" required>
        </div>

        <button type="submit" class="btn btn-primary btn-full">
          Create Account
        </button>

        <div class="auth-links">
          <p>Already have an account? <a href="{{ route('login') }}">Sign in here</a></p>
        </div>
      </form>
    </div>
  </div>
@endsection
