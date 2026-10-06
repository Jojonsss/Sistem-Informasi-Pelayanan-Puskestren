@extends('layouts.adminlte')

@section('title', 'Tambah Pengguna')
@section('page_title', 'Tambah Pengguna')
@section('page_description', 'Membuat akun pengguna baru')

@section('content')

<div class="row justify-content-center">

    <div class="col-lg-8 col-xl-7">

        <div class="card card-primary">

            <div class="card-header">

                <h3 class="card-title">

                    <i class="bi bi-person-plus-fill me-2"></i>

                    Form Tambah Pengguna

                </h3>

            </div>


            <div class="card-body">

                @if ($errors->any())

                    <div class="alert alert-danger">

                        <strong>
                            Data belum dapat disimpan.
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
                    action="{{ route('admin.users.store') }}"
                    novalidate
                >

                    @csrf


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
                                value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Masukkan nama pengguna"
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
                                value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="contoh@email.com"
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
                            Password
                            <span class="text-danger">*</span>
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
                                placeholder="Minimal 8 karakter"
                            >

                            @error('password')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                        <small class="text-body-secondary">
                            Password minimal 8 karakter.
                        </small>

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

                            <option value="">
                                -- Pilih Role --
                            </option>

                            <option
                                value="pasien"
                                {{ old('role') === 'pasien' ? 'selected' : '' }}
                            >
                                Pasien
                            </option>

                            <option
                                value="admin"
                                {{ old('role') === 'admin' ? 'selected' : '' }}
                            >
                                Admin
                            </option>

                            <option
                                value="dokter"
                                {{ old('role') === 'dokter' ? 'selected' : '' }}
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
                                {{ old('status', 'aktif') === 'aktif' ? 'selected' : '' }}
                            >
                                Aktif
                            </option>

                            <option
                                value="nonaktif"
                                {{ old('status') === 'nonaktif' ? 'selected' : '' }}
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
                            class="btn btn-primary"
                        >
                            <i class="bi bi-save me-1"></i>
                            Simpan Pengguna
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

@stop