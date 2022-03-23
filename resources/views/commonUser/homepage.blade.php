@extends('commonUser.layout.app')

<link rel="stylesheet" type="text/css" href="{{ asset('css/home.css') }}" >
<script src="{{ asset('js/script.js') }}" defer></script>

<header>
    @if (Route::has('login'))
    <a href="#" class="logo"><i class="fab fa-bitcoin"></i>Coin Manager</a>

    <div id="menu-bar" class="fas fa-bars"></div>

    <nav class="navbar">
        @auth
        <a href="#">Dashboard</a>
        @else
        <a href="{{ route('login') }}">Login</a>
        @if (Route::has('register'))
        <a href="{{ route('register') }}">Register</a>
        @endif
        @endauth
    </nav>
    @endif
</header>

<!-- home section starts  -->
<section class="home" id="home">

    <div class="content">
        <h3>Coin Manager</h3>
        <p>Coin Manager é o sistema de transações e cotações de cripto moedas!</p>
    </div>

    <div class="image">
        <img src="{{ asset('img/coin.png') }}" alt="">
    </div>

</section>
<!-- home section ends -->
<!-- footer section  -->

<section class="footer">

    <div class="share">
        <a href="#" class="btn">facebook</a>
        <a href="#" class="btn">twitter</a>
        <a href="#" class="btn">instagram</a>
    </div>

    <h1 class="credit"> Desenvolvido por <span> Igor Oliveira, Leonardo Freitas, Marlon Santos </span> | Todos os direitos reservados! </h1>

</section>

<!-- scroll top button  
<a href="#home" class="fas fa-angle-up" id="scroll-top"></a>-->

