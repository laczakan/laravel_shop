@extends('layouts.template')

@section('title', 'My basket')


@section('content')

    @if (!$basket)
        <p>
        <h3 class="text-center">Empty basket</h3>
        <img src="{{ asset('/img/basket.jpeg') }}" class="img-fluid" alt="image" width="500" height="500">
        </p>
    @else
        <div class="row">
            <h3>My basket: </h3>
            <table class="table m-3">
                <thead class="thead-light">
                <tr>
                    <th scope="col">Product</th>
                    <th scope="col">Image</th>
                    <th scope="col">Category</th>
                    <th scope="col">Single price</th>
                    <th scope="col" >Quantity</th>
                    <th scope="col"></th>
                    <th scope="col">Price</th>
                    <th scope="col">Info</th>
                </tr>
                </thead>
                @foreach ($basket->basketProducts as $basketProduct)
                    <tr>
                        <td><span>{{ $basketProduct->product->name }}</span></td>
                        <td><span><img
                                    src="{{ url('storage/upload/products/' . ($basketProduct->product->image ?? 'default.png')) }}"
                                    class="img-thumbnail rounded" width="75" height="75"></span></td>
                        <td><span>{{ $basketProduct->product->category->name }}</span></td>
                        <td style="text-align:center"><span>{{ $basketProduct->product->price }}</span></td>

                        <td>
                            <form method="POST" action="{{ url('basket') }}">
                                @method('PUT')
                                @csrf
                                <input type="number" name="quantity"
                                       value="{{ old('quantity') ?? $basketProduct->quantity }}"
                                       class="@error('quantity') is-invalid @enderror" id="quantity" min="0"
                                       max="{{ $basketProduct->product->quantity }}">
                                <input type="hidden" name="product_id" value="{{ $basketProduct->product->id }}">

                                @error('quantity')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <button type="submit" class="btn btn-primary btn-small">update quantity</button>
                            </form>
                        </td>
                        <td>
                            <form method="POST" action="{{ url('basket/products/'. $basketProduct->product->id ) }}">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger btn-small">delete</button>
                            </form>
                        </td>
                        <td><span>{{ $basketProduct->product->price->multiply($basketProduct->quantity) }}</span></td>
                        <td><a href="{{ url('products/' . $basketProduct->product->id) }}">Info</a></td>
                    </tr>
                @endforeach
            </table>
        </div>

        <div class="float-right m-1">
            <h3>Total: {{ $total }}</h3>
            @auth
                <p><a href="{{ url('basket/checkout') }}" type="submit"
                              class="btn btn-primary btn-small float-right">Checkout</a></p>
            @endauth
        </div>


    @endif

@endsection
