@extends('commonUser.layout.app')
@section('content')

<div class="relative flex items-top min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
    @if (Route::has('login'))
    <div class="hidden fixed left-2 px-6 py-4 sm:block">
        @auth
        <a href="{{ url('/main') }}" class="btn btn-info btn-lg" >Dashboard</a>

        @else
        <a href="{{ route('login') }}" class="btn btn-primary btn-lg ">Login</a>

        @if (Route::has('register'))
        <a href="{{ route('register') }}" class="btn btn-secondary btn-lg">Cadastre-se</a>
        @endif
        @endauth
    </div>
    @endif    
@endsection