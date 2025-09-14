@extends('layouts.app')

@section('title', 'Blog')

@section('content')
@if (count($blogs)>0)
    <h2 class="text text-center">Blog Post</h2>
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th scope="col">title</th>
                <th scope="col">status</th>
                <th scope="col">edit</th>
                <th scope="col">remove</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($blogs as $item)
                <tr>
                    <td>{{ $item->title }}</td>
                    <td>
                        @if ($item->status == true)
                        <a href="{{route('change',$item->id)}}" class="btn btn-success">published</a>
                        @else
                        <a href="{{route('change',$item->id)}}" class="btn btn-secondary">draft</a>
                        @endif
                    </td>
                     <td>
                        <a 
                        href="{{route('edit',$item->id)}}" 
                        class="btn btn-warning"
                        onclick=""                        
                        >
                            edit
                        </a>
                     </td>
                    <td>
                        <a 
                        href="{{route('delete',$item->id)}}" 
                        class="btn btn-danger"
                        onclick="return confirm('Are you sure? Delete {{$item->title}}')"                        
                        >
                            remove
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{$blogs->links()}}
@else
    <h2 class="text text-center">No any post.</h2>
@endif
@endsection
