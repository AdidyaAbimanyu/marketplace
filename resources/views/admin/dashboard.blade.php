@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <main class="container mt-5 pt-5">
        <div class="card p-3 mt-3" style="border-radius: 10px;">
            <table class="table table-bordered">
                <thead>
                    <tr style="background-color: #f7b17c; color: black;">
                        <th>Name</th>
                        <th>Username</th>
                        <th>Alamat</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengguna as $user)
                        <tr>
                            <td>{{ $user->nama_pengguna }}</td>
                            <td>{{ substr($user->username_pengguna, 0, 6) . '**' . substr($user->username_pengguna, -1) }}
                            </td>
                            <td>{{ $user->alamat_pengguna }}</td>
                            <td>{{ ucfirst(string: $user->role) }}</td>
                            <td>
                                <div class="d-flex justify-content-center">
                                    <div class="btn-group p-2" style="border: 1px solid #ddd; border-radius: 8px;">
                                        <button class="btn btn-edit dropdown-toggle" type="button"
                                            style="color: #3FA9F5; background-color: #D5EDFF; border-color: #3FA9F5;"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            Edit
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item"
                                                    href="{{ route('admin.edit', ['id' => $user->id_pengguna]) }}"><i
                                                        class="bi bi-pencil"></i>
                                                    Edit</a></li>
                                            <li>
                                                <form
                                                    action="{{ route('admin.reset', parameters: ['id' => $user->id_pengguna]) }}"
                                                    method="POST" class="form-reset"
                                                    data-nama="{{ $user->nama_pengguna }}">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="bi bi-arrow-clockwise"></i> Reset Password
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                        @if (isset($user->id_pengguna))
                                            <form action="{{ route('admin.delete', ['id' => $user->id_pengguna]) }}"
                                                method="POST" class="form-delete" data-nama="{{ $user->nama_pengguna }}"
                                                style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-delete" type="submit"
                                                    style="color: #CE6A6C; background-color: #FFE2E3; border-color: #CE6A6C; margin-left: 5px;">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Add Account Button -->
            <div class="d-flex justify-content-end mt-2">
                <a href="{{ route('admin.add') }}" class="btn btn-outline-secondary d-flex align-items-center"
                    style="border-radius: 8px; padding: 8px 12px;">
                    <i class="bi bi-plus-circle" style="margin-right: 5px;"></i> Add Account
                </a>
            </div>
        </div>
    </main>

    <script>
        // Konfirmasi untuk Hapus Akun
        document.querySelectorAll('.form-delete').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const nama = this.getAttribute('data-nama');
                Swal.fire({
                    title: 'Yakin ingin menghapus akun ini?',
                    text: `Akun dengan nama "${nama}" akan dihapus secara permanen!`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });

        // Konfirmasi untuk Reset Password
        document.querySelectorAll('.form-reset').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const nama = this.getAttribute('data-nama');
                Swal.fire({
                    title: 'Reset Password?',
                    text: `Password untuk "${nama}" akan diubah menjadi default (123)!`,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#aaa',
                    confirmButtonText: 'Ya, reset!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@endsection
