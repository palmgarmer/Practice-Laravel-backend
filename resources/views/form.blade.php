@extends('layouts.app')

@section('title', 'create')

@section('content')
    <h2 class="text text-center">New Post</h2>
    <form method="POST" action="/insert">
        @csrf
        <div class="form-goup">
            <label for="title">name</label>
            <input type="text" name="title" class="form-control">

        </div>
        @error('title')
            <div class="my-2 text text-danger">
                <span>{{ $message }}</span>
            </div>
        @enderror
        <div class="form-goup">
            <label for="content">content</label>
            <textarea name="content" cols="30" rows="5" class="form-control"></textarea>
        </div>
         @error('content')
            <div class="my-2 text text-danger">
                <span>{{ $message }}</span>
            </div>
        @enderror
        <input type="submit" value="save" class="btn btn-primary my-3">
        <a href="/blog" class="btn btn-success">Blog posts</a>
    </form>
@endsection
