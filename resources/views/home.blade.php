@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="text-center mt-5">
    <h1 class="fw-bold">Ini Landing Page.</h1>
    <a href="{{ url('/login') }}" class="btn btn-primary mt-3">Ke Halaman Login</a>
</div>
@endsection
