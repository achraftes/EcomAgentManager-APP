<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}"> <!-- Lien vers votre fichier CSS personnalisé -->
</head>
<body class="login-body">
    <div class="login-container">
        <!-- Image (left side) -->
        <div class="login-image">
            <!-- Background image only -->
        </div>
        
        <!-- Login form (right side) -->
        <div class="login-form">
            <div class="form-wrapper">
                <header class="form-header">
                    <p class="form-title">
                        <span class="icon"><i class="mdi mdi-lock"></i></span>
                        Login
                    </p>
                </header>
                
                <!-- Laravel Auth Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    
                    <!-- Email Address -->
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <div class="input-wrapper">
                            <span class="input-icon"><i class="mdi mdi-account"></i></span>
                            <input class="form-input" type="email" name="email" placeholder="user@example.com" autocomplete="username" value="{{ old('email') }}" required autofocus>
                        </div>
                        @error('email')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                        <p class="input-hint">
                            Please enter your Email
                        </p>
                    </div>
                    
                    <!-- Password -->
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-wrapper">
                            <span class="input-icon"><i class="mdi mdi-asterisk"></i></span>
                            <input class="form-input" type="password" name="password" placeholder="Password" required autocomplete="current-password">
                        </div>
                        @error('password')
                            <p class="error-message">{{ $message }}</p>
                        @enderror
                        <p class="input-hint">
                            Please enter your password
                        </p>
                    </div>
                    
                    <!-- Remember Me -->
                    <div class="form-group">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember" class="checkbox-input">
                            <span>Remember</span>
                        </label>
                    </div>
                    
                    <hr class="form-divider">
                    
                    <div class="form-actions">
                        <button type="submit" class="submit-button">
                            Login
                        </button>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-password">
                                Forgot Password?
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<style>
    /* Reset */
body, html {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
}

/* Body */
.login-body {
    height: 100vh;
    width: 100vw;
    overflow: hidden;
}

/* Container */
.login-container {
    display: flex;
    height: 100%;
    width: 100%;
}

/* Image Section */
.login-image {
    display: none;
    width: 50%;
    background-image: url('{{ asset('img/examples/exemple13.jpg') }}');
    background-size: cover;
    background-position: center;
}

@media (min-width: 768px) {
    .login-image {
        display: block;
    }
}

/* Form Section */
.login-form {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: white;
    padding: 1rem;
}

@media (min-width: 768px) {
    .login-form {
        width: 50%;
    }
}

.form-wrapper {
    width: 100%;
    max-width: 24rem;
}

/* Header */
.form-header {
    margin-bottom: 1.5rem;
}

.form-title {
    font-size: 1.5rem;
    font-weight: bold;
    display: flex;
    align-items: center;
}

.form-title .icon {
    margin-right: 0.5rem;
}

/* Form Groups */
.form-group {
    margin-bottom: 1rem;
}

.form-label {
    display: block;
    font-weight: 500;
    margin-bottom: 0.5rem;
}

.input-wrapper {
    position: relative;
}

.input-icon {
    position: absolute;
    left: 0.75rem;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
}

.form-input {
    width: 100%;
    padding: 0.5rem 0.5rem 0.5rem 2.5rem;
    border: 1px solid #d1d5db;
    border-radius: 0.375rem;
    font-size: 1rem;
}

.form-input:focus {
    outline: none;
    border-color: #3b82f6;
}

.error-message {
    color: #ef4444;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.input-hint {
    color: #6b7280;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

/* Checkbox */
.checkbox-label {
    display: flex;
    align-items: center;
}

.checkbox-input {
    margin-right: 0.5rem;
}

/* Divider */
.form-divider {
    border: 0;
    border-top: 1px solid #e5e7eb;
    margin: 1rem 0;
}

/* Form Actions */
.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.submit-button {
    background-color: #3b82f6;
    color: white;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 0.375rem;
    cursor: pointer;
    font-size: 1rem;
}

.submit-button:hover {
    background-color: #2563eb;
}

.forgot-password {
    color: #3b82f6;
    text-decoration: none;
    font-size: 0.875rem;
}

.forgot-password:hover {
    color: #2563eb;
}
</style>
</html>