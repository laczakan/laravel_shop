@extends('layouts.template')

@section('title', 'Product details')


@section('content')

    <div class="jumbotron mt-3">
        <div class="row">
            <div class="col-sm-8">
                <h3>Product: {{ $product->name }}</h3>
                <br>
                <p>Category: <b>{{ $product->category->name }}</b></p>
                <p>Available Quantity: <b>{{ $product->quantity }}</b></p>
                <p>Price: <b>{{ $product->price }}</b></p>
                <p>Description: <b>{{ $product->description }}</b></p>
            </div>

            <div class="col-sm-4">
                <div class="row">
                    <img
                        src="{{ url('storage/upload/products/' . ($product->image ?? 'default.png')) }}"
                        class="img-thumbnail rounded" width="400" height="400">
                </div>
@endsection
