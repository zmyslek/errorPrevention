@extends('layouts.app')
@section('title', 'Server Error')
@section('content')
<div class="container text-center py-5">
    <h1 class="display-4">500</h1>
    <p class="lead">Whoops! Something went wrong.</p>
    <a href="{{ url()->previous() }}" class="btn btn-warning mt-3">Try Again</a>
    <a href="{{ url('/') }}" class="btn btn-secondary mt-3">Return Home</a>
    <p class="mt-4"><a href="mailto:support@example.com">Contact Support</a></p>
</div>
@endsection
