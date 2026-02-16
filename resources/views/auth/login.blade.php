@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 500px; margin: 50px auto;">
    <h2>Prijava</h2>
    
    @if ($errors->any())
        <div style="background-color: #fee; border: 1px solid #fcc; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li style="color: #c33;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('login') }}" method="POST" id="loginForm">
        @csrf
        
        <div class="form-group">
            <label for="email">Email adresa</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
            <span class="error-message" id="email-error"></span>
        </div>

        <div class="form-group">
            <label for="password">Lozinka</label>
            <div style="position: relative;">
                <input type="password" name="password" id="password" required style="padding-right: 40px;">
                <span id="togglePassword" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; user-select: none;">
                    <svg id="eyeIcon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </span>
            </div>
            <span class="error-message" id="password-error"></span>
        </div>

        <button type="submit" class="btn">Prijavi se</button>
        <p style="margin-top: 15px;">Nemaš nalog? <a href="{{ route('register') }}">Registruj se</a></p>
    </form>
</div>

<style>
    .error-message {
        color: #c33;
        font-size: 14px;
        display: block;
        margin-top: 5px;
    }
</style>

<script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');

    togglePassword.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        if (type === 'password') {
            eyeIcon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
        } else {
            eyeIcon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
        }
    });

    // LIVE VALIDACIJA
    function showError(field, message) {
        const errorElement = document.getElementById(field + '-error');
        errorElement.textContent = message;
    }

    function showSuccess(field) {
        const errorElement = document.getElementById(field + '-error');
        errorElement.textContent = '';
    }

    // Validacija email-a
    function validateEmail() {
        const email = document.getElementById('email').value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (email === '') {
            showError('email', 'Email adresa je obavezna.');
            return false;
        } else if (!emailRegex.test(email)) {
            showError('email', 'Unesite validnu email adresu.');
            return false;
        } else {
            showSuccess('email');
            return true;
        }
    }

    // Validacija lozinke
    function validatePassword() {
        const password = document.getElementById('password').value;
        
        if (password === '') {
            showError('password', 'Lozinka je obavezna.');
            return false;
        } else if (password.length < 6) {
            showError('password', 'Lozinka mora imati najmanje 6 karaktera.');
            return false;
        } else {
            showSuccess('password');
            return true;
        }
    }

    // Event listeneri
    document.getElementById('email').addEventListener('blur', validateEmail);
    document.getElementById('email').addEventListener('input', function() {
        if (this.value.trim() !== '') validateEmail();
    });

    document.getElementById('password').addEventListener('blur', validatePassword);
    document.getElementById('password').addEventListener('input', function() {
        if (this.value !== '') validatePassword();
    });

    // Validacija pre submit-a
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        let isValid = true;

        isValid = validateEmail() && isValid;
        isValid = validatePassword() && isValid;

        if (!isValid) {
            e.preventDefault();
        }
    });
</script>
@endsection