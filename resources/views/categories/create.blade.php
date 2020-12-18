@extends('layouts.template')

@section('title', 'Add category')


@section('content')
    <h3>Add category:</h3>
    <div class="jumbotron">
        <form method="POST" enctype="multipart/form-data" action="{{ url('category') }}">
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
                <label for="status">Status</label>
                <select name="status" class="custom-select @error('status') is-invalid @enderror" id="status">
                    <option value="" @if( old('status') == '') selected="selected" @endif>Choose...</option>
                    <option value="pending" @if( old('status') == 'pending') selected="selected" @endif>Pending</option>
                    <option value="active" @if( old('status') == 'active') selected="selected" @endif>Active</option>
                </select>
                @error('status')
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
            <button type="submit" class="btn btn-primary">Add Category</button>
        </form>
    </div>
@endsection

