<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Travel Booking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="container">
        <!-- Left Section (Text Content) -->
        <div class="left-section">
            <div class="left-content">
                <p class="join-for-free">EXPLORE THE WORLD</p>
                <h1>Discover Amazing <span class="blue-text">Travel</span> Experiences</h1>
                <p class="description">Sign in to access exclusive deals, personalized recommendations, and manage your bookings with ease.</p>
                <div class="buttons">
                    <button class="explore-btn">Explore Destinations</button>
                </div>
            </div>
        </div>

        <!-- Right Section (Form) -->
        <div class="right-section">
            <div class="form-wrapper">
                <h2>Sign In</h2>
                
                <!-- Session Status -->
                @if(session('status'))
                    <div class="session-status">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="input-group">
                        <label for="email">Email</label>
                        <div class="input-field">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                            <i class="fas fa-envelope"></i>
                        </div>
                        @error('email')
                            <div class="error-message" style="color: red; font-weight: bold;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="input-group">
                        <label for="password">Password</label>
                        <div class="input-field">
                            <input id="password" type="password" name="password" required autocomplete="current-password">
                            <i class="fas fa-lock"></i>
                        </div>
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="options-group">
                        <label for="remember_me" class="remember-me">
                            <input id="remember_me" type="checkbox" name="remember">
                            <span>Remember me</span>
                        </label>
                        
                        @if (Route::has('password.request'))
                            <a class="forgot-password" href="{{ route('password.request') }}">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="login-btn">Log In</button>
                </form>

                <div class="register-link">
                    Don't have an account? <a href="{{ route('register') }}">Sign up</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>