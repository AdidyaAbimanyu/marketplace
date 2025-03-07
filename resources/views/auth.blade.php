@extends('layouts.app')

@section('title', 'Authentication')

@section('content')
    <div class="container d-flex justify-content-center align-items-center py-5 mt-5">
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
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" name="role" required>
                                <option value="Penjual">Penjual</option>
                                <option value="Pembeli">Pembeli</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">SIGN IN →</button>
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
                                <input type="password" class="form-control" name="password" id="registerPassword"
                                    required>
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
                                    onclick="togglePassword('confirmPassword', 'toggleConfirmPassword')">
                                    👁️
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-select" name="role" required>
                                <option value="Penjual">Penjual</option>
                                <option value="Pembeli">Pembeli</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">SIGN UP →</button>
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
    </script>
@endsection
