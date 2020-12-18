@extends('layouts.template')

@section('title', 'Categories')

@section('header')
    @parent
@endsection

@section('content')

    <div class="row">
        <h3>{{$category->name}}</h3>
        <div>
            <img class="img m-1" alt="image"
                 src="{{ url('storage/upload/categories/' . ($category->image ?? 'default.png')) }}"
                 width="150" height="100">
        </div>
    </div>

    <div class="row">
        <table class="table m-3">
            <thead class="thead-light">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Image</th>
                <th scope="col">Name</th>
                <th scope="col">Quantity available</th>
                <th scope="col">Price</th>
                @auth
                    <th scope="col">Quantity to buy</th>
                    <th scope="col"></th>
                @endauth
                <th scope="col">Info</th>
            </tr>
            </thead>
            @foreach ($products as $product)
                <tr>
                    <form class="" action="{{url('basket/store')}}" method="post">
                        @csrf
                        <th scope="row">
                            <span>{{ $product->id }}</span>
                            <input type="hidden" name="basket_id" value="{{ Auth::id() }}">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                        </th>
                        <td><span><img
                                    src="{{ url('storage/upload/products/' . ($product->image ?? 'default.png')) }}"
                                    class="img rounded" width="75" height="60"></span></td>
                        <td><span>{{ $product->name }}</span></td>
                        <td><span>{{ $product->quantity }}</span></td>
                        <td><span>{{ $product->price }}</span></td>
                        @auth
                            @if( $product->quantity != 0)
                                <td>
                                    <select class="form-control" name="quantity">
                                        @for ($i = 1; $i <= $product->quantity; $i++)
                                            <option value="{{ $i }}">{{ $i}}</option>
                                        @endfor
                                    </select>
                                </td>
                                <td><input type="submit" name="submit" value="Add to basket" class="btn btn-primary">
                                </td>
                            @else

                                <td><span style="color:#ff0000"><b>Out of stock</b></span></td>
                                <td><span style="color:#ff0000"><b>Out of stock</b></span></td>
                            @endif
                        @endauth
                        {{--                        {{ dd($errors) }}--}}
                        <td><a href="{{ url('products/' . $product->id) }}" name="info">Info</a></td>
                    </form>
                </tr>
            @endforeach
        </table>
    </div>

@endsection
