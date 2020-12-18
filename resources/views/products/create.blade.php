@extends('layouts.template')

@section('title', 'Add product')


@section('content')
    <h3>Add new product:</h3>
    <div class="jumbotron">
        <form method="POST" enctype="multipart/form-data" action="{{ url('products') }}">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" name="name" value="{{ old('name') }}" type="text"
                       class="form-control @error('name') is-invalid @enderror">
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="category_id">Category</label>
                <select name="category_id" class="custom-select @error('category_id') is-invalid @enderror"
                        id="category_id">
                    <option value="" @if( old('category_id') == '') selected="selected" @endif>Choose category</option>
                    @foreach ($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            @if( old('category_id') == $category->id) selected="selected" @endif>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input id="quantity" name="quantity" value="{{ old('quantity') }}" type="text"
                       class="form-control @error('quantity') is-invalid @enderror">
                @error('quantity')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div> <div class="form-group">
                <label for="price">Price (in pence)</label>
                <input id="price" name="price" value="{{ old('price') }}" type="text"
                       class="form-control @error('price') is-invalid @enderror">
                @error('price')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="image">Select image:</label>
                <input type="file" name="image" class=" @error('image') is-invalid @enderror" id="image">
                <div class="invalid-feedback">
                    @error('image')
                    <div class="invalid-feedback">{{ $message }} </div>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="name">Description</label>
                <textarea id="desctiption" name="description"
                          class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Add new product</button>
        </form>
    </div>
@endsection

