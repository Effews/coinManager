@extends('commonUser.layout.app')
@section('content')

<x-auth-card>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />

    <div class="container">
        <div class="d-flex justify-content-center h-100">
            <div class="card">
                <div class="card-header">
                    <h3>Sign In</h3>

                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-at"></i></span>
                            </div>
                            <input id="email" type="text" class="form-control" placeholder="Email">

                        </div>
                        <div class="input-group form-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                            </div>
                            <input id="password" name="password" type="password" class="form-control" placeholder="Password" required autocomplete="current-password" :value="__('Password')">
                        </div>
                        <div class="row align-items-center remember">
                            <input type="checkbox">{{ __('Remember Me') }}
                        </div>
                        <div class="form-group">
                            <x-button class="btn float-right login_btn">
                                Log in
                            </x-button>

                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                        Não tem uma conta?<a href="{{ route('register') }}">Cadastre-se</a>
                    </div>
                    <div class="d-flex justify-content-center">
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-auth-card>
