@extends('layouts.adminlte')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard Admin')
@section('page_description', 'Sistem Informasi Pelayanan Puskestren')

@section('content')

<div class="row">

    {{-- Total Pengguna --}}
    <div class="col-lg-3 col-md-6 col-12 mb-3">
        <div class="small-box text-bg-primary">

            <div class="inner">
                <h3>{{ \App\Models\User::count() }}</h3>
                <p>Total Pengguna</p>
            </div>

            <svg
                class="small-box-icon"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
            >
                <path d="M16 11c1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3 1.34 3 3 3Zm-8 0c1.66 0 3-1.34 3-3S9.66 5 8 5 5 6.34 5 8s1.34 3 3 3Zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5C15 14.17 10.33 13 8 13Zm8 0c-.29 0-.62.02-.97.05C16.03 13.82 17 14.78 17 16.5V19h7v-2.5c0-2.33-4.67-3.5-7-3.5Z"/>
            </svg>

            <a
                href="{{ route('admin.users.index') }}"
                class="small-box-footer"
            >
                Management Pengguna
                <i class="bi bi-arrow-right-circle"></i>
            </a>

        </div>
    </div>


    {{-- Total Pasien --}}
    <div class="col-lg-3 col-md-6 col-12 mb-3">
        <div class="small-box text-bg-success">

            <div class="inner">
                <h3>{{ \App\Models\Pasien::count() }}</h3>
                <p>Total Pasien</p>
            </div>

            <svg
                class="small-box-icon"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
            >
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4Zm0 2c-3.31 0-6 1.69-6 4v2h12v-2c0-2.31-2.69-4-6-4Z"/>
            </svg>

            <a
                href="#"
                class="small-box-footer"
            >
                Data Pasien
                <i class="bi bi-arrow-right-circle"></i>
            </a>

        </div>
    </div>


    {{-- Total Dokter --}}
    <div class="col-lg-3 col-md-6 col-12 mb-3">
        <div class="small-box text-bg-warning">

            <div class="inner">
                <h3>{{ \App\Models\Dokter::count() }}</h3>
                <p>Total Dokter</p>
            </div>

            <svg
                class="small-box-icon"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
            >
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4Zm0 2c-3.31 0-6 1.69-6 4v2h12v-2c0-2.31-2.69-4-6-4Zm7-5h-2V7h2V5h2v2h2v2h-2v2h-2V9Z"/>
            </svg>

            <a
                href="#"
                class="small-box-footer"
            >
                Data Dokter
                <i class="bi bi-arrow-right-circle"></i>
            </a>

        </div>
    </div>


    {{-- Total Kunjungan --}}
    <div class="col-lg-3 col-md-6 col-12 mb-3">
        <div class="small-box text-bg-danger">

            <div class="inner">
                <h3>{{ \App\Models\Kunjungan::count() }}</h3>
                <p>Total Kunjungan</p>
            </div>

            <svg
                class="small-box-icon"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
            >
                <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.89-2-2-2Zm0 16H5V8h14v11ZM7 10h5v5H7v-5Z"/>
            </svg>

            <a
                href="#"
                class="small-box-footer"
            >
                Data Kunjungan
                <i class="bi bi-arrow-right-circle"></i>
            </a>

        </div>
    </div>

</div>


{{-- Informasi Admin --}}
<div class="row mt-3">

    <div class="col-lg-8">

        <div class="card">

            <div class="card-header">

                <h3 class="card-title">
                    <i class="bi bi-person-circle me-2"></i>
                    Informasi Administrator
                </h3>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-6 mb-3">

                        <strong>Nama</strong>

                        <div class="text-body-secondary">
                            {{ auth()->user()->name }}
                        </div>

                    </div>

                    <div class="col-md-6 mb-3">

                        <strong>Email</strong>

                        <div class="text-body-secondary">
                            {{ auth()->user()->email }}
                        </div>

                    </div>

                    <div class="col-md-6">

                        <strong>Role</strong>

                        <div>
                            <span class="badge text-bg-primary">
                                {{ ucfirst(auth()->user()->role) }}
                            </span>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <strong>Status</strong>

                        <div>
                            <span class="badge text-bg-success">
                                {{ ucfirst(auth()->user()->status) }}
                            </span>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- Quick Action --}}
    <div class="col-lg-4">

        <div class="card card-primary">

            <div class="card-header">

                <h3 class="card-title">
                    <i class="bi bi-lightning-charge-fill me-2"></i>
                    Akses Cepat
                </h3>

            </div>

            <div class="card-body d-grid gap-2">

                <a
                    href="{{ route('admin.users.index') }}"
                    class="btn btn-primary"
                >
                    <i class="bi bi-people-fill me-2"></i>
                    Management Pengguna
                </a>

                <a
                    href="{{ route('admin.users.create') }}"
                    class="btn btn-outline-primary"
                >
                    <i class="bi bi-person-plus-fill me-2"></i>
                    Tambah Pengguna
                </a>

            </div>

        </div>

    </div>

</div>

@stop