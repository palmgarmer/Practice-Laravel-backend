@extends('layout')

@section('title', 'About')

@section('content')
    <h2>About Us</h2>
    <hr>
    <p>Developed by {{ $name}}</p>
    <p>Started Project : {{ $date }}</p>
@endsection
