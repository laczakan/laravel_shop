@extends('layouts.template')

@section('title', 'Profile')

@section('header')
    @parent
    <p>This is user header.</p>
@endsection

@section('content')
    @auth

        <div class="jumbotron mt-3">
            <div class="row">
                <div class="col-sm-8">
                    <h3>Hello {{Auth::user()->name}}</h3>
                    @if (Auth::user()->admin)
                        <span class="badge badge-danger m-3">admin</span>
                    @endif
                    @if (Auth::user()->mod)
                        <span class="badge badge-warning m-3">moderator</span>
                    @endif
                    <p>Email: {{Auth::user()->email}}</p>
                </div>

                <div class="col-sm-4">
                    <div class="row">
                        <img src="{{ url('storage/upload/users/' . (Auth::user()->image ?? 'default.png')) }}"
                             class="img-thumbnail rounded-circle" width="200" height="200">
                    </div>
                    <div class="row">
                        <a href="{{ url('users/'. Auth::id() .'/image')}}" type="submit"
                           class="btn btn-sm btn-primary m-2"
                           title="Edit"> {{ Auth::user()->image ? 'Change image' : 'Add image' }}</a>

                        @if (Auth::user()->image)
                            <form method="POST" enctype="multipart/form-data"
                                  action="{{ url('users/'.Auth::id().'/delete') }}">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger m-2" title="Delete"
                                        onclick="return confirm('are you sure?')">Delete image
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if (Auth::user())
            <div class="row">
                <h3>My orders: </h3>
                <table class="table m-3">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Address</th>
                        <th scope="col">info</th>
                        <th scope="col">total</th>
                        <th scope="col">created at</th>
                        <th scope="col">details</th>
                    </tr>
                    </thead>
                    @foreach ($orders as $order)
                        <tr>
                            <th scope="row"><span>{{ $order->id }}</span></th>
                            <td><span>{{ $order->name }}</span></td>
                            <td><span>{{ $order->address }}</span></td>
                            <td><span>{{ $order->info }}</span></td>
                            <td><span>{{ $order->total }}</span></td>
                            <td><span>{{ $order->created_at }}</span></td>
                            <td><span><a href="{{ url('orders/'.$order->id) }}" type="submit"
                                         class="btn btn-primary btn-small">details</a></span></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif
    @endauth
@endsection
