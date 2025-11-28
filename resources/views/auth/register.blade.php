@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 500px; margin: 50px auto;">
    <h2>Register</h2>
    <form action="{{ route('register') }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>

        <div class="form-group">
            <label for="role">I want to:</label>
            <select name="role" id="role" required onchange="toggleBakeryFields()">
                <option value="">Select Role</option>
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Reserve food (User)</option>
                <option value="bakery" {{ old('role') == 'bakery' ? 'selected' : '' }}>Post food (Bakery)</option>
            </select>
        </div>

        <div id="bakery-fields" style="display: none;">
            <div class="form-group">
                <label for="bakery_name">Bakery Name</label>
                <input type="text" name="bakery_name" id="bakery_name" value="{{ old('bakery_name') }}">
            </div>

            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" name="address" id="address" value="{{ old('address') }}">
            </div>
        </div>

        <button type="submit" class="btn">Register</button>
        <p style="margin-top: 15px;">Already have an account? <a href="{{ route('login') }}">Login</a></p>
    </form>
</div>

<script>
    function toggleBakeryFields() {
        const role = document.getElementById('role').value;
        const bakeryFields = document.getElementById('bakery-fields');
        bakeryFields.style.display = role === 'bakery' ? 'block' : 'none';
    }
    
    // Call on page load
    toggleBakeryFields();
</script>
@endsection