<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link rel="stylesheet" href="{{ asset('css/profile-edit.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

    <main class="page-container">
        <div class="container">
            <header class="page-header">
                <h1>{{ __('Profile') }}</h1>
            </header>

            <div class="sections-wrapper">
                <section class="profile-section">
                    <header class="section-header">
                        <h2 class="section-title">Informasi Profil</h2>
                        <p class="section-description">Perbarui informasi profil dan alamat email akun Anda.</p>
                    </header>
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                            @error('name') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                            @error('email') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            @if (session('status') === 'profile-updated')
                                <p class="form-saved-message">Tersimpan.</p>
                            @endif
                        </div>
                    </form>
                </section>

                <section class="profile-section">
                    <header class="section-header">
                        <h2 class="section-title">Perbarui Kata Sandi</h2>
                        <p class="section-description">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.</p>
                    </header>
                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="form-group">
                            <label for="current_password">Kata Sandi Saat Ini</label>
                            <input id="current_password" name="current_password" type="password" autocomplete="current-password">
                            @error('current_password', 'updatePassword') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Kata Sandi Baru</label>
                            <input id="password" name="password" type="password" autocomplete="new-password">
                            @error('password', 'updatePassword') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password">
                            @error('password_confirmation', 'updatePassword') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            @if (session('status') === 'password-updated')
                                <p class="form-saved-message">Tersimpan.</p>
                            @endif
                        </div>
                    </form>
                </section>

                <section class="profile-section">
                    <header class="section-header">
                        <h2 class="section-title">Hapus Akun</h2>
                        <p class="section-description">Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Sebelum menghapus akun Anda, harap unduh data atau informasi apa pun yang ingin Anda simpan.</p>
                    </header>
                    {{-- Tombol ini biasanya memicu modal. Untuk saat ini, kita hanya akan menatanya. --}}
                    <form method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')
                         {{-- Anda mungkin perlu menambahkan input password di sini jika ada modal --}}
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus akun Anda? Tindakan ini tidak dapat diurungkan.')">Hapus Akun</button>
                    </form>
                </section>
            </div>
        </div>
    </main>

</body>
</html>