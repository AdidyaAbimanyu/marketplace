@extends('layouts.app')

@section('title', 'Add Account')

@section('content')
    <main class="container mt-4 pt-5">
        <div class="card p-4 mt-3 mx-auto" style="border-radius: 10px; max-width: 500px;">
            <h5 class="fw-bold mb-3">Add Account</h5>
            <form action="{{ route('admin.store') }}" method="POST" id="addAccountForm">
                @csrf
                <div class="mb-3">
                    <label for="nama_pengguna" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna" required>
                </div>
                <div class="mb-3">
                    <label for="username_pengguna" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username_pengguna" name="username_pengguna" required>
                </div>
                <div class="mb-3">
                    <label for="alamat_pengguna" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat_pengguna" name="alamat_pengguna" required>
                </div>
                <div class="mb-3">
                    <label for="signup_password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" name="password" id="signup_password" class="form-control" required>
                        <button type="button" class="btn btn-outline-secondary"
                            onclick="togglePassword('signup_password')">👁</button>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control" required>
                        <button type="button" class="btn btn-outline-secondary"
                            onclick="togglePassword('password_confirmation')">👁</button>
                    </div>
                    <small id="passwordMismatch" class="text-danger d-none">Passwords do not match</small>
                </div>
                <div class="mb-3">
                    <label for="signup_role" class="form-label">Role</label>
                    <select name="role" id="signup_role" class="form-control" required>
                        <option value="pembeli">Pembeli</option>
                        <option value="penjual">Penjual</option>
                    </select>
                </div>
                <div class="text-center">
                    <button type="submit" id="submitBtn" class="btn text-white px-5"
                        style="background-color: #F36F2A; border-radius: 5px;" disabled>
                        <span class="fw-bold">SUBMIT</span> <i class="bi bi-arrow-right"></i>
                    </button>
                </div>
            </form>
        </div>
    </main>

    <script>
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            field.type = field.type === 'password' ? 'text' : 'password';
        }

        const password = document.getElementById('signup_password');
        const confirm = document.getElementById('password_confirmation');
        const warning = document.getElementById('passwordMismatch');
        const submitBtn = document.getElementById('submitBtn');
        const allInputs = document.querySelectorAll('#addAccountForm input, #signup_role');

        function validateForm() {
            const allFilled = Array.from(allInputs).every(input => input.value.trim() !== '');
            const match = password.value === confirm.value;

            warning.classList.toggle('d-none', match);
            submitBtn.disabled = !(allFilled && match);
        }

        password.addEventListener('input', validateForm);
        confirm.addEventListener('input', validateForm);
        allInputs.forEach(input => input.addEventListener('input', validateForm));
    </script>
@endsection
