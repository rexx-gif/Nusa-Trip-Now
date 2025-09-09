<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Account</title>
    
    {{-- Arahkan ke file CSS di folder public --}}
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    
    {{-- Link ke Font Awesome untuk ikon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        
        {{-- Bagian Kiri --}}
        <div class="left-section">
            <div class="left-content">
                <p class="join-for-free">JOIN FOR FREE</p>
                <h1>Unleash the traveler <span class="blue-text">inside YOU</span>, Enjoy your Dream Vacation</h1>
                <p class="description">Get started with the easiest no most secure website to buy travel tickets.</p>
                <div class="buttons">
                    <button class="explore-btn">Explore more</button>
                    <button class="book-now-btn">Book Now</button>
                </div>
            </div>
        </div>

        {{-- Bagian Kanan (Form) --}}
        <div class="right-section">
            <div class="form-wrapper">
                <h2>Create <span>new account.</span></h2>
                
                {{-- Form mengarah ke route 'register' dengan method POST --}}
                <form action="{{ route('register') }}" method="POST">
                    @csrf {{-- Token keamanan wajib di Laravel --}}

                    <div class="input-group">
                        <label for="name">Name</label>
                        <div class="input-field">
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                            <i class="fas fa-user"></i>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="email">Email</label>
                        <div class="input-field">
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="password">Password</label>
                        <div class="input-field">
                            <input type="password" id="password" name="password" required>
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <div class="input-field">
                            <input type="password" id="password_confirmation" name="password_confirmation" required>
                            <i class="fas fa-eye"></i>
                        </div>
                    </div>

                    <div class="member-link">
                        Already A Member? <a href="{{ route('login') }}">Log In</a>
                    </div>

                    <button type="submit" class="create-account-btn">Create Account</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>