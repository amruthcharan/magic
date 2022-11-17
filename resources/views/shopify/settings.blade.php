@extends('layouts.shopify')

@section('title', 'Settings')

@section('content')
<div class="container-fluid">
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>Settings</h2>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>

    @if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
    <div class="row">
        <form action="{{ route('shopify.settings.update') }}" method="POST">
            @csrf
            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        General Settings
                    </div>
                    <div class="card-body">
                        <div class="form-group row mb-3">
                            <label for="is_active" class="col-sm-3 col-form-label text-end">Enable</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="is_active" id="is_active">
                                    <option @if((old('is_active') ?? $shop->settings->is_active ?? false) == true) selected @endif value=1>Yes</option>
                                    <option @if((old('is_active') ?? $shop->settings->is_active ?? false) == false) selected @endif value=0>No</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="sdk_url" class="col-sm-3 col-form-label text-end">SDK URL Path</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('sdk_url') is-invalid @enderror" id="sdk_url" name="sdk_url" value="{{ old('sdk_url') ?? $shop->settings->sdk_url ?? '' }}">
                                @error('sdk_url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        Identity Link Settings
                    </div>
                    <div class="card-body">
                        <div class="form-group row mb-3">
                            <label for="is_identity_enabled" class="col-sm-3 col-form-label text-end">Enable Identity</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="is_identity_enabled" id="is_identity_enabled">
                                    <option @if((old('is_identity_enabled') ?? $shop->settings->is_identity_enabled ?? true) == true) selected @endif value=1>Yes</option>
                                    <option @if((old('is_identity_enabled') ?? $shop->settings->is_identity_enabled ?? true) == false) selected @endif value=0>No</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="is_idl_aync" class="col-sm-3 col-form-label text-end">Async Identity</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="is_idl_aync" id="is_idl_aync">
                                    <option @if((old('is_idl_aync') ?? $shop->settings->is_idl_aync ?? false) == true) selected @endif value=1>Yes</option>
                                    <option @if((old('is_idl_aync') ?? $shop->settings->is_idl_aync ?? false) == false) selected @endif value=0>No</option>
                                </select>
                                <div class="form-text">please confirm with MagicPixel team before updating</div>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="is_idl_optimised" class="col-sm-3 col-form-label text-end">Optimise Identity Calls</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="is_idl_optimised" id="is_idl_optimised">
                                    <option @if((old('is_idl_optimised') ?? $shop->settings->is_idl_optimised ?? true) == true) selected @endif value=1>Yes</option>
                                    <option @if((old('is_idl_optimised') ?? $shop->settings->is_idl_optimised ?? true) == false) selected @endif value=0>No</option>
                                </select>
                                <div class="form-text">
                                    This option optimised the identity resolution by enabling the identity resolution call if cookies are not present. Please leave this as Yes unless intructed by MagicPixel team.
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="cookie_key" class="col-sm-3 col-form-label text-end">Cookie Key</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('cookie_key') is-invalid @enderror" id="cookie_key" name="cookie_key" value="{{ old('cookie_key') ?? $shop->settings->cookie_key ?? '_mplidl' }}">
                            </div>
                            @error('cookie_key')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group row mb-3">
                            <label for="identity_url" class="col-sm-3 col-form-label text-end">IDL URL Path</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('identity_url') is-invalid @enderror" id="identity_url" name="identity_url" value="{{ old('identity_url') ?? $shop->settings->identity_url ?? '' }}">
                                @error('identity_url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        Other Settings
                    </div>
                    <div class="card-body">
                        <div class="form-group row mb-3">
                            <label for="cache_time" class="col-sm-3 col-form-label text-end">SDK Cache Buster</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('cache_time') is-invalid @enderror" id="cache_time" name="cache_time" value="{{ old('cache_time') ?? $shop->settings->cache_time ?? 60 }}">
                            </div>
                            @error('cache_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group row mb-3">
                            <label for="default_country_code" class="col-sm-3 col-form-label text-end">Default Currency Code</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('default_country_code') is-invalid @enderror" id="default_country_code" name="default_country_code" value="{{ old('default_country_code') ?? $shop->settings->default_country_code ?? 'US' }}">
                            </div>
                            @error('default_country_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group row mb-3">
                            <label for="default_currency_code" class="col-sm-3 col-form-label text-end">Default Country Code</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control @error('default_currency_code') is-invalid @enderror" id="default_currency_code" name="default_currency_code" value="{{ old('default_currency_code') ?? $shop->settings->default_currency_code ?? 'USD' }}">
                            </div>
                            @error('default_currency_code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group row mb-3">
                            <label for="id_type" class="col-sm-3 col-form-label text-end">Default Product ID</label>
                            <div class="col-sm-9">
                                <select class="form-select" name="id_type" id="id_type">
                                    <option @if((old('id_type') ?? $shop->settings->id_type ?? 0) == 0) selected @endif value=0>Product ID</option>
                                    <option @if((old('id_type') ?? $shop->settings->id_type ?? 0) == 1) selected @endif value=1>SKU</option>
                                    <option @if((old('id_type') ?? $shop->settings->id_type ?? 0) == 2) selected @endif value=2>VARAINT ID</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center">
                <input type="submit" value="Update Settings" class="btn btn-primary">
            </div>
        </form>
    </div>
    <!-- End Row -->
</div>
@endsection