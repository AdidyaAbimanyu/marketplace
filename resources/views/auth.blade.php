@extends('layouts.app')

@section('title', 'Authentication')

@section('content')
    <div class="container d-flex justify-content-center align-items-center mt-5 pt-4">
        <div class="auth-container">
            <ul class="nav nav-tabs nav-justified mb-3" id="authTabs">
                <li class="nav-item">
                    <a class="nav-link active" id="signInTab" data-bs-toggle="tab" href="#signIn">Sign In</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="signUpTab" data-bs-toggle="tab" href="#signUp">Sign Up</a>
                </li>
            </ul>

            <div class="tab-content">
                <!-- Sign In Form -->
                <div class="tab-pane fade show active" id="signIn">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="loginPassword" required>
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="togglePassword('loginPassword', 'toggleLoginPassword')">
                                    👁️
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" id="signInButton" disabled>SIGN IN →</button>
                    </form>
                </div>

                <!-- Sign Up Form -->
                <div class="tab-pane fade" id="signUp">
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password" id="registerPassword" required>
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="togglePassword('registerPassword', 'toggleRegisterPassword')">
                                    👁️
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="confirm_password" id="confirmPassword"
                                    required>
                                <button class="btn btn-outline-secondary" type="button"
                                    onclick="togglePassword('confirmPassword')">
                                    👁️
                                </button>
                            </div>
                            <small id="confirmPasswordError" class="error-message">⚠ Password tidak cocok!</small>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" name="role" required>
                                <option value="Penjual">Penjual</option>
                                <option value="Pembeli">Pembeli</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" id="signUpButton" disabled>SIGN UP →</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function togglePassword(inputId, toggleButtonId) {
            var input = document.getElementById(inputId);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Validasi untuk Sign In
            const signInForm = document.querySelector("#signIn form");
            const signInInputs = signInForm.querySelectorAll("input, select");
            const signInButton = document.getElementById("signInButton");

            function validateSignIn() {
                const allFilled = Array.from(signInInputs).every(i => i.value.trim() !== "");
                signInButton.disabled = !allFilled;
            }

            signInInputs.forEach(input => {
                input.addEventListener("input", validateSignIn);
            });

            // Validasi untuk Sign Up
            const signUpForm = document.querySelector("#signUp form");
            const signUpInputs = signUpForm.querySelectorAll("input, select");
            const signUpButton = document.getElementById("signUpButton");
            const passwordField = document.querySelector("#registerPassword");
            const confirmPasswordField = document.querySelector("#confirmPassword");
            const errorMessage = document.getElementById("confirmPasswordError");

            function validateSignUp() {
                const allFilled = Array.from(signUpInputs).every(i => i.value.trim() !== "");
                const passwordsMatch = passwordField.value === confirmPasswordField.value;

                signUpButton.disabled = !(allFilled && passwordsMatch);

                if (!passwordsMatch) {
                    errorMessage.style.display = "block";
                } else {
                    errorMessage.style.display = "none";
                }
            }

            signUpInputs.forEach(input => {
                input.addEventListener("input", validateSignUp);
            });

            passwordField.addEventListener("input", validateSignUp);
            confirmPasswordField.addEventListener("input", validateSignUp);
        });
    </script>

    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                title: 'Gagal!',
                text: "{{ session('error') }}",
                icon: 'error',
                confirmButtonText: 'Coba lagi'
            });
        </script>
    @endif

@endsection
