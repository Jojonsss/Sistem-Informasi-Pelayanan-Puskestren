<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login - Puskestren</title>

    @vite([
        'resources/css/adminlte.css',
        'resources/js/adminlte.js'
    ])
</head>

<body class="login-page bg-body-secondary">

    <div class="login-box">

        <div class="card card-outline card-primary">

            {{-- Logo / Nama Aplikasi --}}
            <div class="card-header text-center">

                <a
                    href="#"
                    class="h1 text-decoration-none"
                >
                    <b>PUSKESTREN</b>
                </a>

            </div>

            <div class="card-body">

                <p class="login-box-msg">
                    Sistem Informasi Pelayanan Puskestren
                </p>

                {{-- Pesan Error Login --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                {{-- Form Login --}}
                <form
                    action="{{ route('login.process') }}"
                    method="POST"
                >

                    @csrf

                    {{-- Email --}}
                    <div class="input-group mb-3">

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="Email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                        >

                        <div class="input-group-text">
                            <span class="bi bi-envelope"></span>
                        </div>

                    </div>

                    {{-- Password --}}
                    <div class="input-group mb-3">

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Password"
                            required
                        >

                        <div class="input-group-text">
                            <span class="bi bi-lock-fill"></span>
                        </div>

                    </div>

                    {{-- Tombol Login --}}
                    <div class="row">

                        <div class="col-12">

                            <button
                                type="submit"
                                class="btn btn-primary w-100"
                            >

                                <i class="bi bi-box-arrow-in-right me-1"></i>

                                Login

                            </button>

                        </div>

                    </div>

                </form>

                <div class="text-center mt-4">

                    <small class="text-body-secondary">
                        Sistem Informasi Pelayanan Puskestren
                    </small>

                </div>

            </div>

        </div>

    </div>

</body>

</html>