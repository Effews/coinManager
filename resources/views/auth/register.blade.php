@extends('commonUser.layout.app')



<header>
    <a href="{{ route ('homePageOff')}}" class="logo"><i class="fab fa-bitcoin"></i>Coin Manager</a>

</header>
<x-guest-layout>
    <x-auth-card>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />


        <div class="container">
            <div class="d-flex justify-content-center">

                <div class="card-register">
                    <div class="card-header">
                        <h3>
                            Registre-se
                        </h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text icon"><i class="fas fa-user"></i></span>
                                </div>
                                <x-input id="name" class="form-control" placeholder="Nome" type="text" name="name" :value="old('name')" required autofocus />
                            </div>

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
                                <x-input id="password" class="form-control" placeholder="Senha" type="password" name="password" required autocomplete="new-password" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="input-group form-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text icon"><i class="fas fa-key"></i></span>
                                </div>
                                <x-input id="password_confirmation" class=" form-control" placeholder="Confirme sua Senha" type="password" name="password_confirmation" required />
                            </div>
                            <div class="form-group">
                                <x-button class="btn login_btn">
                                    {{ __('Register') }}
                                </x-button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                    <div class="d-flex justify-content-center links">
                            <a href="{{ route('login') }}">Já tem Cadastro?</a>
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