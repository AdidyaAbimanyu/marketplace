@extends('layouts.app')

@section('title', 'Authentication')

@section('content')
    <div class="container mt-5 py-5 d-flex justify-content-center" data-aos="fade-up">
        <div class="card p-4" style="width: 400px; border-color: #FF5722;">
            <ul class="nav nav-tabs mb-3 justify-content-center">
                <li class="nav-item">
                    <a class="nav-link active" href="#" id="signInTab" style="color: #FF5722;">Sign In</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="signUpTab" style="color: #FF5722;">Sign Up</a>
                </li>
            </ul>

            <!-- Sign In Form -->
            <form id="signInForm" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="signin_username" class="form-label">Username</label>
                    <input type="text" name="username_pengguna" id="signin_username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="signin_password" class="form-label">Kata Sandi</label>
                    <div class="input-group">
                        <input type="password" name="password" id="signin_password" class="form-control" required>
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('signin_password')">👁</button>
                    </div>
                </div>
                <button type="submit" id="signInBtn" class="btn w-100" style="background-color: #FF5722; color: white;" disabled>SIGN IN →</button>
            </form>

            <!-- Sign Up Form -->
            <form id="signUpForm" action="{{ route('register') }}" method="POST" class="d-none">
                @csrf
                <div class="mb-3">
                    <label for="signup_name" class="form-label">Nama</label>
                    <input type="text" name="nama_pengguna" id="signup_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="signup_username" class="form-label">Username</label>
                    <input type="text" name="username_pengguna" id="signup_username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="signup_address" class="form-label">Alamat</label>
                    <input type="text" name="alamat_pengguna" id="signup_address" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="signup_password" class="form-label">Kata Sandi</label>
                    <div class="input-group">
                        <input type="password" name="password" id="signup_password" class="form-control" required>
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('signup_password')">👁</button>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Konfirmasi Kata Sandi</label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="confirm_password" class="form-control" required>
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('confirm_password')">👁</button>
                    </div>
                    <small id="passwordMismatch" class="text-danger d-none">Kata Sandi Tidak Sama</small>
                </div>
                <div class="mb-3">
                    <label for="signup_role" class="form-label">Role</label>
                    <select name="role" id="signup_role" class="form-control" required>
                        <option value="pembeli">Pembeli</option>
                        <option value="penjual">Penjual</option>
                    </select>
                </div>
                <button type="submit" id="signUpBtn" class="btn w-100" style="background-color: #FF5722; color: white;" disabled>SIGN UP →</button>
            </form>
        </div>
    </div>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            field.type = field.type === 'password' ? 'text' : 'password';
        }

        document.getElementById('signInTab').addEventListener('click', function() {
            document.getElementById('signInForm').classList.remove('d-none');
            document.getElementById('signUpForm').classList.add('d-none');
            this.classList.add('active');
            document.getElementById('signUpTab').classList.remove('active');
        });

        document.getElementById('signUpTab').addEventListener('click', function() {
            document.getElementById('signUpForm').classList.remove('d-none');
            document.getElementById('signInForm').classList.add('d-none');
            this.classList.add('active');
            document.getElementById('signInTab').classList.remove('active');
        });

        document.querySelectorAll('#signInForm input').forEach(input => {
            input.addEventListener('input', () => {
                const allFilled = Array.from(document.querySelectorAll('#signInForm input')).every(i => i.value);
                document.getElementById('signInBtn').disabled = !allFilled;
            });
        });

        document.querySelectorAll('#signUpForm input').forEach(input => {
            input.addEventListener('input', () => {
                const allFilled = Array.from(document.querySelectorAll('#signUpForm input')).every(i => i.value);
                const password = document.getElementById('signup_password').value;
                const confirmPassword = document.getElementById('confirm_password').value;
                const passwordsMatch = password === confirmPassword;

                document.getElementById('passwordMismatch').classList.toggle('d-none', passwordsMatch);
                document.getElementById('signUpBtn').disabled = !(allFilled && passwordsMatch);
            });
        });
    </script>
@endsection
