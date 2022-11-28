@extends('layouts.auth')

@section('title', 'Reset Password')

@section('content')
<section class="signin-section">
    <div class="container-fluid">
      <div class="row g-0 auth-row">
        <div class="col-lg-6">
          <div class="auth-cover-wrapper bg-primary-100">
            <div class="auth-cover">
              <div class="title text-center">
                <h1 class="text-primary mb-10">Forgot password?</h1>
                <p class="text-medium">
                  No worries! Enter your email address and we'll send you a link to reset your password.
                </p>
              </div>
              <div class="cover-image">
                <img src="{{ asset('images/auth/reset-password.svg') }}" alt="" />
              </div>
              <div class="shape-image">
                <img src="{{ asset('images/auth/shape.svg') }}" alt="" />
              </div>
            </div>
          </div>
        </div>
        <!-- end col -->
        <div class="col-lg-6">
          <div class="signin-wrapper">
            <div class="form-wrapper">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
              <div class="w-100">
                <img src="{{ asset('images/MP.png') }}" class="d-block mx-auto mb-3" alt="Magic Pixel">
              </div>
              <form action="{{ route('password.email') }}" method="POST">
                @csrf
                <div class="row">
                  <div class="col-12">
                    <div class="input-style-1">
                      <label>Email</label>
                      <input name="email" type="email" class="@error('email') is-invalid @enderror" placeholder="Email" value="{{ old('email') }}" autofocus />
                      @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                      @enderror
                    </div>
                  </div>
                  <!-- end col -->
                  <div class="col-xxl-6 col-lg-12 col-md-6">
                    <div
                      class="
                        text-start text-md-end text-lg-start text-xxl-end
                        mb-30
                      "
                    >
                      <a href="{{ route('login') }}" class="hover-underline"
                        >Back to Login</a
                      >
                    </div>
                  </div>
                  <!-- end col -->
                  <div class="col-12">
                    <div
                      class="
                        button-group
                        d-flex
                        justify-content-center
                        flex-wrap
                      "
                    >
                      <button
                        type="submit"
                        class="
                          main-btn
                          primary-btn
                          btn-hover
                          w-100
                          text-center
                        "
                      >
                      Send Password Reset Link
                      </button>
                    </div>
                  </div>
                </div>
                <!-- end row -->
              </form>
            </div>
          </div>
        </div>
        <!-- end col -->
      </div>
      <!-- end row -->
    </div>
  </section>
@endsection
