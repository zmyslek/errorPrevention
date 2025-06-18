@extends('layouts.app')
@section('title', 'Page Not Found')
@section('content')
<div class="container text-center py-5">
    <h1 class="display-4">404</h1>
    <p class="lead">Oops! Page not found.</p>
    <a href="{{ url('/') }}" class="btn btn-primary mt-3">Go to Homepage</a>
</div>
@endsection
