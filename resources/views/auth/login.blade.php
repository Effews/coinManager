@extends('commonUser.layout.app')

<header>
    <a href="{{ route('homePageOff') }}" class="logo"><i class="fab fa-bitcoin"></i>Coin Manager</a>

</header>
<x-guest-layout>
    <x-auth-card>


        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />


        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="card">
                    <div class="card-header">
                        <h3>Entre</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text icon"><i class="fas fa-at"></i></span>
                                </div>
                                <x-input id="email" class="form-control" placeholder="Email" type="email" name="email" :value="old('email')" required autofocus />
                            </div>

                            <!-- Password -->
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text icon"><i class="fas fa-key"></i></span>
                                </div>

                                <x-input id="password" class="form-control" placeholder="Senha" type="password" name="password" required autocomplete="current-password" />
                            </div>
                            <!-- Remember Me -->
                            <div class="row align-items-center remember">
                                <input type="checkbox">{{ __('Lembrar') }}
                            </div>
                            <div class="form-group">
                                <x-button class="btn float-right login_btn">
                                    {{ __('Log in') }}
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
                            <a class="forgot" href="{{ route('password.request') }}">
                                Esqueceu sua Senha?
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-auth-card>
</x-guest-layout>
<section class="footer">

    <div class="share">
        <a href="#" class="btn">facebook</a>
        <a href="#" class="btn">twitter</a>
        <a href="#" class="btn">instagram</a>
    </div>

    <h1 class="credit"> Desenvolvido por <span> Igor Oliveira, Leonardo Freitas, Marlon Santos </span> | Todos os direitos reservados! </h1>

</section>