@extends('layouts.app')

@section('content')
<div class="card" style="margin-top: 50px;">
    <h2>Registracija</h2>
    
    @if ($errors->any())
        <div style="background-color: #fee; border: 1px solid #fcc; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li style="color: #c33;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('register') }}" method="POST" id="registerForm">
        @csrf
        
        <div class="form-group">
            <label for="name">Ime</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
            <span class="error-message" id="name-error"></span>
        </div>

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

        <div class="form-group">
            <label for="password_confirmation">Potvrdi lozinku</label>
            <div style="position: relative;">
                <input type="password" name="password_confirmation" id="password_confirmation" required style="padding-right: 40px;">
                <span id="togglePasswordConfirmation" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); cursor: pointer; user-select: none;">
                    <svg id="eyeIconConfirmation" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </span>
            </div>
            <span class="error-message" id="password_confirmation-error"></span>
        </div>

        <div class="form-group">
            <label for="role">Želim da:</label>
            <select name="role" id="role" required onchange="toggleBakeryFields()">
                <option value="">Izaberi ulogu</option>
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>
                    Rezervišem hranu (Korisnik)
                </option>
                <option value="bakery" {{ old('role') == 'bakery' ? 'selected' : '' }}>
                    Objavljujem hranu (Pekara)
                </option>
            </select>
            <span class="error-message" id="role-error"></span>
        </div>

        <div id="bakery-fields" style="display: none;">
            <div class="form-group">
                <label for="bakery_name">Naziv pekare</label>
                <input type="text" name="bakery_name" id="bakery_name" value="{{ old('bakery_name') }}">
                <span class="error-message" id="bakery_name-error"></span>
            </div>

            <div class="form-group">
                <label for="address">Adresa</label>
                <input type="text" name="address" id="address" value="{{ old('address') }}">
                <span class="error-message" id="address-error"></span>
            </div>
        </div>

        <button type="submit" class="btn">Registruj se</button>
        <p style="margin-top: 15px;">
            Već imaš nalog? <a href="{{ route('login') }}">Prijavi se</a>
        </p>
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
    function toggleBakeryFields() {
        const role = document.getElementById('role').value;
        const bakeryFields = document.getElementById('bakery-fields');
        bakeryFields.style.display = role === 'bakery' ? 'block' : 'none';
        
        // Validacija role-a
        validateRole();
    }
    
    // Toggle lozinke
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

    const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
    const passwordConfirmationInput = document.getElementById('password_confirmation');
    const eyeIconConfirmation = document.getElementById('eyeIconConfirmation');

    togglePasswordConfirmation.addEventListener('click', function() {
        const type = passwordConfirmationInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordConfirmationInput.setAttribute('type', type);
        
        if (type === 'password') {
            eyeIconConfirmation.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle>';
        } else {
            eyeIconConfirmation.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line>';
        }
    });
    
    toggleBakeryFields();

    // LIVE VALIDACIJA
    function showError(field, message) {
        const errorElement = document.getElementById(field + '-error');
        errorElement.textContent = message;
    }

    function showSuccess(field) {
        const errorElement = document.getElementById(field + '-error');
        errorElement.textContent = '';
    }

    function clearValidation(field) {
        const errorElement = document.getElementById(field + '-error');
        errorElement.textContent = '';
    }

    // Validacija imena
    function validateName() {
        const name = document.getElementById('name').value.trim();
        if (name === '') {
            showError('name', 'Ime je obavezno.');
            return false;
        } else if (name.length < 2) {
            showError('name', 'Ime mora imati najmanje 2 karaktera.');
            return false;
        } else if (name.length > 255) {
            showError('name', 'Ime ne sme biti duže od 255 karaktera.');
            return false;
        } else {
            showSuccess('name');
            return true;
        }
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
        } else if (email.length > 255) {
            showError('email', 'Email adresa ne sme biti duža od 255 karaktera.');
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
        } else if (password.length < 8) {
            showError('password', 'Lozinka mora imati najmanje 8 karaktera.');
            return false;
        } else {
            showSuccess('password');
            // Ako je confirmation već popunjena, validuj i nju
            if (document.getElementById('password_confirmation').value !== '') {
                validatePasswordConfirmation();
            }
            return true;
        }
    }

    // Validacija potvrde lozinke
    function validatePasswordConfirmation() {
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;
        
        if (passwordConfirmation === '') {
            showError('password_confirmation', 'Potvrda lozinke je obavezna.');
            return false;
        } else if (password !== passwordConfirmation) {
            showError('password_confirmation', 'Lozinke se ne poklapaju.');
            return false;
        } else {
            showSuccess('password_confirmation');
            return true;
        }
    }

    // Validacija uloge
    function validateRole() {
        const role = document.getElementById('role').value;
        
        if (role === '') {
            showError('role', 'Morate izabrati ulogu.');
            return false;
        } else {
            showSuccess('role');
            // Validacija bakery polja ako je izabrana pekara
            if (role === 'bakery') {
                validateBakeryName();
                validateAddress();
            }
            return true;
        }
    }

    // Validacija naziva pekare
    function validateBakeryName() {
        const role = document.getElementById('role').value;
        const bakeryName = document.getElementById('bakery_name').value.trim();
        
        if (role === 'bakery') {
            if (bakeryName === '') {
                showError('bakery_name', 'Naziv pekare je obavezan.');
                return false;
            } else if (bakeryName.length < 2) {
                showError('bakery_name', 'Naziv mora imati najmanje 2 karaktera.');
                return false;
            } else {
                showSuccess('bakery_name');
                return true;
            }
        } else {
            clearValidation('bakery_name');
            return true;
        }
    }

    // Validacija adrese
    function validateAddress() {
        const role = document.getElementById('role').value;
        const address = document.getElementById('address').value.trim();
        
        if (role === 'bakery') {
            if (address === '') {
                showError('address', 'Adresa je obavezna.');
                return false;
            } else if (address.length < 5) {
                showError('address', 'Adresa mora imati najmanje 5 karaktera.');
                return false;
            } else {
                showSuccess('address');
                return true;
            }
        } else {
            clearValidation('address');
            return true;
        }
    }

    // Event listeneri za live validaciju
    document.getElementById('name').addEventListener('blur', validateName);
    document.getElementById('name').addEventListener('input', function() {
        if (this.value.trim() !== '') validateName();
    });

    document.getElementById('email').addEventListener('blur', validateEmail);
    document.getElementById('email').addEventListener('input', function() {
        if (this.value.trim() !== '') validateEmail();
    });

    document.getElementById('password').addEventListener('blur', validatePassword);
    document.getElementById('password').addEventListener('input', function() {
        if (this.value !== '') validatePassword();
    });

    document.getElementById('password_confirmation').addEventListener('blur', validatePasswordConfirmation);
    document.getElementById('password_confirmation').addEventListener('input', function() {
        if (this.value !== '') validatePasswordConfirmation();
    });

    document.getElementById('role').addEventListener('change', validateRole);

    document.getElementById('bakery_name').addEventListener('blur', validateBakeryName);
    document.getElementById('bakery_name').addEventListener('input', function() {
        if (this.value.trim() !== '') validateBakeryName();
    });

    document.getElementById('address').addEventListener('blur', validateAddress);
    document.getElementById('address').addEventListener('input', function() {
        if (this.value.trim() !== '') validateAddress();
    });

    // Validacija pre submit-a
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        let isValid = true;

        isValid = validateName() && isValid;
        isValid = validateEmail() && isValid;
        isValid = validatePassword() && isValid;
        isValid = validatePasswordConfirmation() && isValid;
        isValid = validateRole() && isValid;
        
        if (document.getElementById('role').value === 'bakery') {
            isValid = validateBakeryName() && isValid;
            isValid = validateAddress() && isValid;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
</script>
@endsection