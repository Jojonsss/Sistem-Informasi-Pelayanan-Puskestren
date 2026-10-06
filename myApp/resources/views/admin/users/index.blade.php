@extends('layouts.adminlte')

@section('title', 'Management Pengguna')
@section('page_title', 'Management Pengguna')
@section('page_description', 'Kelola akun pengguna Sistem Informasi Pelayanan Puskestren')

@section('content')

<div class="card">

    <div class="card-header">

        <div class="d-flex justify-content-between align-items-center">

            <h3 class="card-title">
                <i class="bi bi-people-fill me-2"></i>
                Daftar Pengguna
            </h3>

            <div>

                <a
                    href="{{ route('admin.dashboard') }}"
                    class="btn btn-secondary btn-sm"
                >
                    <i class="bi bi-speedometer2 me-1"></i>
                    Dashboard
                </a>

                <a
                    href="{{ route('admin.users.create') }}"
                    class="btn btn-primary btn-sm"
                >
                    <i class="bi bi-person-plus-fill me-1"></i>
                    Tambah Pengguna
                </a>

            </div>

        </div>

    </div>


    <div class="card-body">

        {{-- Success --}}
        @if (session('success'))

            <div
                class="alert alert-success alert-dismissible fade show"
                role="alert"
            >

                <i class="bi bi-check-circle-fill me-2"></i>

                {{ session('success') }}

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                ></button>

            </div>

        @endif


        {{-- Error --}}
        @if ($errors->any())

            <div class="alert alert-danger">

                <i class="bi bi-exclamation-triangle-fill me-2"></i>

                {{ $errors->first() }}

            </div>

        @endif


        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-light">

                    <tr>

                        <th style="width: 70px;">
                            ID
                        </th>

                        <th>
                            Nama
                        </th>

                        <th>
                            Email
                        </th>

                        <th>
                            Role
                        </th>

                        <th>
                            Status
                        </th>

                        <th style="width: 170px;">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse ($users as $user)

                        <tr>

                            <td>
                                <strong>
                                    {{ $user->id }}
                                </strong>
                            </td>

                            <td>
                                {{ $user->name }}
                            </td>

                            <td>
                                {{ $user->email }}
                            </td>

                            <td>

                                @if ($user->role === 'admin')

                                    <span class="badge text-bg-primary">
                                        Admin
                                    </span>

                                @elseif ($user->role === 'dokter')

                                    <span class="badge text-bg-warning">
                                        Dokter
                                    </span>

                                @else

                                    <span class="badge text-bg-info">
                                        Pasien
                                    </span>

                                @endif

                            </td>

                            <td>

                                @if ($user->status === 'aktif')

                                    <span class="badge text-bg-success">
                                        Aktif
                                    </span>

                                @else

                                    <span class="badge text-bg-danger">
                                        Nonaktif
                                    </span>

                                @endif

                            </td>

                            <td>

                                <div class="btn-group">

                                    <a
                                        href="{{ route('admin.users.edit', $user) }}"
                                        class="btn btn-warning btn-sm"
                                    >
                                        <i class="bi bi-pencil-square"></i>
                                        Edit
                                    </a>

                                    @if ($user->id !== auth()->id())

                                        <form
                                            action="{{ route('admin.users.destroy', $user) }}"
                                            method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="btn btn-danger btn-sm"
                                            >
                                                <i class="bi bi-trash-fill"></i>
                                                Hapus
                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="text-center text-body-secondary py-4"
                            >

                                <i class="bi bi-people fs-2 d-block mb-2"></i>

                                Belum ada data pengguna.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="card-footer text-body-secondary">

        Total pengguna:
        <strong>{{ $users->count() }}</strong>

    </div>

</div>

@stop