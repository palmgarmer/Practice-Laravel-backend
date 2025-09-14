@extends('layouts.app')

@section('title', 'edit')

@section('content')
    <h2 class="text text-center">Edit Post</h2>
    <form method="POST" action="{{route('update', $blog->id)}}">
        @csrf
        <div class="form-goup">
            <label for="title">name</label>
            <input type="text" name="title" class="form-control" value="{{$blog->title}}">

        </div>
        @error('title')
            <div class="my-2 text text-danger">
                <span>{{ $message }}</span>
            </div>
        @enderror
        <div class="form-goup">
            <label for="content">content</label>
            <textarea name="content" cols="30" rows="5" class="form-control">{{$blog->content}}</textarea>
        </div>
         @error('content')
            <div class="my-2 text text-danger">
                <span>{{ $message }}</span>
            </div>
        @enderror
        <input type="submit" value="update" class="btn btn-primary my-3">
        <a href="/blog" class="btn btn-success">Blog posts</a>
    </form>
@endsection
