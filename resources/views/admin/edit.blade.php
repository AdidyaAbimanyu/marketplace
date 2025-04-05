@extends('layouts.app')

@section('title', 'Edit Account')

@section('content')
    <main class="container mt-4 pt-5">
        <div class="card p-4 mt-3 mx-auto" style="border-radius: 10px; max-width: 500px;">
            <h5 class="fw-bold mb-3">Edit Account</h5>
            <form action="{{ route('admin.update', ['id' => $pengguna->id_pengguna]) }}" method="POST" id="editAccountForm">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama_pengguna" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama_pengguna" name="nama_pengguna" value="{{ $pengguna->nama_pengguna }}" required>
                </div>

                <div class="mb-3">
                    <label for="username_pengguna" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username_pengguna" name="username_pengguna" value="{{ $pengguna->username_pengguna }}" required>
                </div>

                <div class="mb-3">
                    <label for="alamat_pengguna" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat_pengguna" name="alamat_pengguna" value="{{ $pengguna->alamat_pengguna }}" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password Baru (Opsional)</label>
                    <div class="input-group">
                        <input type="password" name="password" id="password" class="form-control">
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password')">👁</button>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        <button type="button" class="btn btn-outline-secondary" onclick="togglePassword('password_confirmation')">👁</button>
                    </div>
                    <small id="passwordMismatch" class="text-danger d-none">Passwords do not match</small>
                </div>

                <div class="mb-3">
                    <label for="edit_role" class="form-label">Role</label>
                    <select name="role" id="edit_role" class="form-control" required>
                        <option value="pembeli" {{ $pengguna->role == 'pembeli' ? 'selected' : '' }}>Pembeli</option>
                        <option value="penjual" {{ $pengguna->role == 'penjual' ? 'selected' : '' }}>Penjual</option>
                        <option value="admin" {{ $pengguna->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>

                <div class="text-center">
                    <button type="submit" id="submitBtn" class="btn text-white px-5" style="background-color: #F36F2A; border-radius: 5px;">
                        <span class="fw-bold">UPDATE</span> <i class="bi bi-check"></i>
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

        const password = document.getElementById('password');
        const confirm = document.getElementById('password_confirmation');
        const warning = document.getElementById('passwordMismatch');
        const submitBtn = document.getElementById('submitBtn');
        const allInputs = document.querySelectorAll('#editAccountForm input, #edit_role');

        function validateForm() {
            const allFilled = Array.from(allInputs).every(input => input.value.trim() !== '');
            const match = password.value === confirm.value;

            if (password.value || confirm.value) {
                warning.classList.toggle('d-none', match);
                submitBtn.disabled = !match;
            } else {
                warning.classList.add('d-none');
                submitBtn.disabled = false;
            }
        }

        password.addEventListener('input', validateForm);
        confirm.addEventListener('input', validateForm);
        allInputs.forEach(input => input.addEventListener('input', validateForm));
    </script>
@endsection
