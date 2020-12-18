@extends('layouts.template')

@section('title', 'My basket')


@section('content')

    <div class="jumbotron">
        <div class="row">
            <h3>My basket: </h3>
            <table class="table m-3">
                <thead class="thead-light">
                <tr>
                    <th scope="col">Product</th>
                    <th scope="col">Category</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Price</th>
                </tr>
                </thead>
                @foreach ($basket->basketProducts as $basketProduct)
                    <tr>
                        <td><span>{{ $basketProduct->product->name }}</span></td>
                        <td><span>{{ $basketProduct->product->category->name }}</span></td>
                        <td><span>{{ ($basketProduct->quantity) }}</span></td>
                        <td><span>{{ $basketProduct->product->price->multiply($basketProduct->quantity) }}</span></td>
                    </tr>
                @endforeach
            </table>
        </div>

        <h3 class="float-right mb-5"> Total: {{ $total }}</h3>
    </div>

    <h2>Fill address and place the order:</h2>

    <form method="POST" action="{{ url('basket/checkout') }}">
        @csrf

        <div class="form-group">
            <label for="name">Full Name:</label>
            <input id="name" name="name" value="{{ old('name') }}" type="text"
                   class="form-control @error('name') is-invalid @enderror">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input id="address" name="address" value="{{ old('address') }}" type="text"
                   class="form-control @error('address') is-invalid @enderror">
            @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="info">Additional info:</label>
            <textarea id="info" name="info"
                      class="form-control @error('info') is-invalid @enderror">{{ old('info') }}</textarea>
            @error('info')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Place order</button>
    </form>

@endsection
