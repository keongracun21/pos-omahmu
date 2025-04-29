@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="d-flex flex-column justify-content-center align-items-center vh-100 bg-custom">
    <!-- Kartu Login -->
    <div class="card shadow-lg d-flex justify-content-center align-items-center mb-3"
        style="width: 471px; height: 464px;">
        <div style="width: 350px;">
            <h3 class="text-center mb-4">Log in</h3>

            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label label-faded">Email atau No Hp</label>
                    <input type="text" name="username" class="form-control input-custom" required>
                </div>
                <div class="mb-3">
                    <label class="form-label label-faded">Password</label>
                    <input type="password" name="password" class="form-control input-custom" required>
                </div>
                <button type="submit" class="btn w-100" style="background-color: #D9D9D9;">Log in</button>

                <div class="mt-2 text-end">
                    <a href="#" class="text-decoration-none text-muted" style="font-size: 0.9rem;">Lupa Password?</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection