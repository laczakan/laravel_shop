@extends('layouts.template')

@section('title', 'Profile')

@section('header')
    @parent
    <p>This is user header.</p>
@endsection

@section('content')
    @auth

        @if (Auth::user()->admin)
            <div class="row">
                <h3>Products: </h3>
                <table class="table m-3">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Category</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Action</th>
                        <th scope="col"><a href="{{ url('products/create') }}" type="submit"
                                           class="btn btn-primary float-right">Add new product</a></th>
                    </tr>
                    </thead>
                    @foreach ($products as $product)
                        <tr>
                            <th scope="row"><span>{{ $product->id }}</span></th>
                            <td><span><img
                                        src="{{ url('storage/upload/products/' . ($product->image ?? 'default.png')) }}"
                                        class="img-thumbnail rounded" width="75" height="75"></span></td>
                            <td><span>{{ $product->name }}</span></td>
                            <td><span>{{ $product->category->name }}</span></td>
                            <td><span>{{ $product->quantity }}</span></td>
                            <td><span>{{ $product->price }}</span></td>
                            <td><span><a href="{{ url('products/'.$product->id.'/edit') }}" type="submit"
                                         class="btn btn-primary btn-small">Edit</a></span></td>
                        </tr>
                    @endforeach
                </table>
            </div>
            {{--    {{$products->links()}}--}}
        @endif

    @endauth
@endsection
