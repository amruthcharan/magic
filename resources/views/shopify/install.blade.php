@extends('layouts.auth')

@section('title', 'Install Shopify Extension')

@section('content')
<section class="signin-section">
    <div class="container-fluid">
      <div class="row g-0 auth-row">
        <div class="col-lg-6">
          <div class="auth-cover-wrapper bg-primary-100">
            <div class="auth-cover">
              <div class="title text-center">
                <h1 class="text-primary mb-10">Get Started</h1>
                <p class="text-medium">
                  enter your shopify store url to install the extension
                </p>
              </div>
              <div class="cover-image">
                <img src="{{ asset('images/auth/signin-image.svg') }}" alt="" />
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
              <div class="w-100">
                <img src="{{ asset('images/mp.png') }}" class="d-block mx-auto mb-3" alt="Magic Pixel">
              </div>
              <form action="{{ route('shopify.install') }}" method="POST">
                @csrf
                <div class="row">
                  <div class="col-12">
                    <div class="input-style-1">
                      <label>Shopify Store URL</label>
                      <input name="store_url" type="text" class="@if(session()->has('error')) is-invalid @endif" placeholder="Your Shopify Store URL" value="{{ old('email') }}" autofocus />
                      @if(session()->has('error'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ session('error') }}</strong>
                        </span>
                      @endif
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
                        Install Magic Pixel
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
