@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 500px; margin: 50px auto;">
    <h2>Login</h2>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>

        <button type="submit" class="btn">Login</button>
        <p style="margin-top: 15px;">Don't have an account? <a href="{{ route('register') }}">Register</a></p>
    </form>
</div>
@endsection
