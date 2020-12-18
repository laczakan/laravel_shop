@extends('layouts.template')

@section('title', 'Order details')

@section('header')
    @parent
@endsection

@section('content')



    <div class="row">
        <div>
            <h3>Order "nr: {{ $order->id }}" details:</h3>
            <br>
            <div class="jumbotron">
                <h5 class="m-2">Name: {{ $order->name }}</h5>
                <h5 class="m-2">Address: {{ $order->address }}</h5>
                <h5 class="m-2">Message: {{ $order->info }}</h5>
                <h5 class="m-2">Created at: {{ $order->created_at }}</h5>
            </div>
        </div>


        <table class="table m-3">
            <thead class="thead-light">
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
            </tr>
            </thead>
            @foreach ($order_details as $product)
                <tr>
                    <th scope="row"><span>{{ $product->product_id }}</span></th>
                    <td><span>{{ $product->product->name }}</span></td>
                    <td><span>{{ $product->quantity }}</span></td>
                    <td><span>{{ $product->price }}</span></td>
                    {{--                            <td><span><a href="{{ url('product/'.$product->id.'/edit') }}" type="submit"--}}
                    {{--                                         class="btn btn-primary btn-small">Edit</a></span></td>--}}
                </tr>
            @endforeach
        </table>
        <h3 class="float-right m-4">Order total: {{ $order->total }}</h3>
    </div>
@endsection
