@extends('layouts.template')

@section('title', 'Categories')

@section('header')
    @parent
@endsection

@section('content')

    <h3>Categories: </h3>
    <br>
    <div class="row">
        <div class="col " style="column-count: 2">
            @foreach ($categories as $category)
                <a style="display:block" href="{{ url('category/' . $category->id) }} ">
                    <div class="card card-body mb-3" style="color: darkblue">
                        <h2>{{ $category->name }}
                            <img alt="image"
                                 src="{{ url('storage/upload/categories/' . ($category->image ?? 'default.png')) }}"
                                 class="img float-right" width="150" height="100"></h2>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

@endsection
