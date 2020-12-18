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
                <h3>Categories: </h3>
                <table class="table m-3">
                    <thead class="thead-light">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Image</th>
                        <th scope="col">Name</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                        <th scope="col"><a href="{{ url('category/create') }}" type="submit"
                                           class="btn btn-primary float-right">Add category</a></th>
                    </tr>
                    </thead>
                    @foreach ($categories as $category)
                        <tr>
                            <th scope="row"><span>{{ $category->id }}</span></th>
                            <td><span><img
                                        src="{{ url('storage/upload/categories/' . ($category->image ?? 'default.png')) }}"
                                        class="img-thumbnail rounded" width="75" height="75"></span></td>
                            <td><span>{{ $category->name }}</span></td>
                            <td><span>{{ $category->status }}</span></td>
                            <td><span><a href="{{ url('category/'.$category->id.'/edit') }}" type="submit"
                                         class="btn btn-primary btn-small">Edit</a></span></td>
                        </tr>
                    @endforeach
                </table>
            </div>
        @endif

    @endauth
@endsection
