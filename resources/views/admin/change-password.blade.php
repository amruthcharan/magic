@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title mb-30">
                        <h2>Change Password</h2>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card-style mb-30">
                    <div class="form-wrapper">
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                      <form action="{{ route('password.change') }}" method="POST">
                        @csrf
                        <div class="row">
                          <div class="col-12">
                            <div class="input-style-1">
                              <label>Current Password</label>
                              <input name="current_password" type="password" class="@if(session('error')) is-invalid @endif" placeholder="Current Password" autofocus />
                              @if (session('error'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ session('error') }}</strong>
                                </span>
                              @endif
                            </div>
                          </div>
                          <!-- end col -->
                          <div class="col-12">
                            <div class="input-style-1">
                              <label>New Password</label>
                              <input name="password" type="password" class="@error('password') is-invalid @enderror" placeholder="New Password" />
                              @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                            <!-- end col -->
                            <div class="col-12">
                                <div class="input-style-1">
                                  <label>Confirm Password</label>
                                  <input name="password_confirmation" type="password" placeholder="Password Again" />
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
                              Change Password
                              </button>
                            </div>
                          </div>
                        </div>
                        <!-- end row -->
                      </form>
                    </div>
                </div>
            </div>
            <!-- End Col -->
        </div>
        <!-- End Row -->
    </div>
@endsection
