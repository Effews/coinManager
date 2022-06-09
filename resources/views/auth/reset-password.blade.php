@extends('commonUser.layout.app')

<header>
    <a href="{{ route('homePageOff') }}" class="logo"><i class="fab fa-bitcoin"></i>Coin Manager</a>
</header>

<x-guest-layout>
    <x-auth-card>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="card">
                    <div class="card-header">
                        <h3>Entre</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <!-- Email Address -->
                            <div style="display:none">
                                <x-label for="email" :value="__('Email')" />

                                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
                            </div>

                            <!-- Password -->
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text icon"><i class="fas fa-key"></i></span>
                                </div>
                                <x-input id="password" class="form-control" placeholder="Senha" type="password" name="password" required />
                            </div>


                            <!-- Confirm Password -->
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text icon"><i class="fas fa-key"></i></span>
                                </div>
                                <x-input id="password_confirmation" class="form-control" type="password" placeholder="Confirme a nova senha" name="password_confirmation" required />
                            </div>

                            <div class="form-group">
                                <x-button class="login_btn glow-button">
                                    {{ __('Trocar Senha') }}
                                </x-button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-center links">
                            Ou faça seu<a href="{{ route('login') }}">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-auth-card>
</x-guest-layout>

<section class="footer">
    <h1 class="credit"> Desenvolvido por <span> Igor Oliveira, Leonardo Freitas, Marlon Santos </span> | Todos os direitos reservados! </h1>
</section>