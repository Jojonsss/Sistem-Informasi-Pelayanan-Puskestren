@extends('layouts.adminlte')

@section('title', 'Edit Pengguna')
@section('page_title', 'Edit Pengguna')
@section('page_description', 'Memperbarui informasi akun pengguna')

@section('content')

<div class="row justify-content-center">

    <div class="col-lg-8 col-xl-7">

        <div class="card card-warning">

            <div class="card-header">

                <h3 class="card-title">

                    <i class="bi bi-pencil-square me-2"></i>

                    Form Edit Pengguna

                </h3>

            </div>


            <div class="card-body">

                @if ($errors->any())

                    <div class="alert alert-danger">

                        <strong>
                            Data belum dapat diperbarui.
                        </strong>

                        <ul class="mb-0 mt-2">

                            @foreach ($errors->all() as $error)

                                <li>
                                    {{ $error }}
                                </li>

                            @endforeach

                        </ul>

                    </div>

                @endif


                <form
                    method="POST"
                    action="{{ route('admin.users.update', $user) }}"
                    novalidate
                >

                    @csrf

                    @method('PUT')


                    {{-- Nama --}}
                    <div class="mb-3">

                        <label
                            for="name"
                            class="form-label"
                        >
                            Nama
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-person"></i>
                            </span>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $user->name) }}"
                                class="form-control @error('name') is-invalid @enderror"
                            >

                            @error('name')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    {{-- Email --}}
                    <div class="mb-3">

                        <label
                            for="email"
                            class="form-label"
                        >
                            Email
                            <span class="text-danger">*</span>
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-envelope"></i>
                            </span>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', $user->email) }}"
                                class="form-control @error('email') is-invalid @enderror"
                            >

                            @error('email')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    {{-- Password --}}
                    <div class="mb-3">

                        <label
                            for="password"
                            class="form-label"
                        >
                            Password Baru
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-lock-fill"></i>
                            </span>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Kosongkan jika tidak ingin mengubah"
                            >

                            @error('password')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    {{-- Role --}}
                    <div class="mb-3">

                        <label
                            for="role"
                            class="form-label"
                        >
                            Role
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            id="role"
                            name="role"
                            class="form-select @error('role') is-invalid @enderror"
                        >

                            <option
                                value="pasien"
                                {{ old('role', $user->role) === 'pasien' ? 'selected' : '' }}
                            >
                                Pasien
                            </option>

                            <option
                                value="admin"
                                {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}
                            >
                                Admin
                            </option>

                            <option
                                value="dokter"
                                {{ old('role', $user->role) === 'dokter' ? 'selected' : '' }}
                            >
                                Dokter
                            </option>

                        </select>

                        @error('role')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- Status --}}
                    <div class="mb-3">

                        <label
                            for="status"
                            class="form-label"
                        >
                            Status
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            id="status"
                            name="status"
                            class="form-select @error('status') is-invalid @enderror"
                        >

                            <option
                                value="aktif"
                                {{ old('status', $user->status) === 'aktif' ? 'selected' : '' }}
                            >
                                Aktif
                            </option>

                            <option
                                value="nonaktif"
                                {{ old('status', $user->status) === 'nonaktif' ? 'selected' : '' }}
                            >
                                Nonaktif
                            </option>

                        </select>

                        @error('status')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <hr>


                    <div class="d-flex justify-content-end gap-2">

                        <a
                            href="{{ route('admin.users.index') }}"
                            class="btn btn-secondary"
                        >
                            <i class="bi bi-arrow-left me-1"></i>
                            Kembali
                        </a>

                        <button
                            type="submit"
                            class="btn btn-warning"
                        >
                            <i class="bi bi-check-circle me-1"></i>
                            Simpan Perubahan
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@stop