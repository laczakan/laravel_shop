@extends('layouts.template')

@section('title', 'Home')

@section('header')
    @parent
@endsection

@section('content')

    <h1 class="text-center">Laravel 8 + Bootstrap = Shop v8 by Andrzej Laczak</h1>

    <p class="text-center">
        <img src="{{ asset('/img/shop.jpeg') }}" class="img-fluid" alt="Responsive image">
    </p>


    <h3 class="text-center">1-31 September</h3>

@endsection
