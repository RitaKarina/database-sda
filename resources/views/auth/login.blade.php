@extends('layouts.public')

@section('title', 'Login Pengelola Data')

@section('navigation')
    <a href="{{ route('public.home') }}">Beranda</a>
@endsection

@section('content')
    <section class="container py-5">
        <div class="row justify-content-center">
            <div class="col-sm-10 col-md-7 col-lg-5">
                <div class="text-center mb-4">
                    <x-logo size="52" class="brand-logo mx-auto mb-3" />
                    <div class="section-kicker mb-2">Akses pengelola data</div>
                    <h1 class="h3 fw-bold">Login Pengelola Data</h1>
                    <p class="text-secondary">Masuk untuk mengelola data sumber daya air.</p>
                </div>

                <div class="data-card p-4 p-md-5">
                    <form method="POST" action="{{ route('login.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email Pengelola Data</label>
                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                class="form-control form-control-lg @error('email') is-invalid @enderror"
                                autocomplete="username"
                                inputmode="email"
                                required
                                autofocus
                            >
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label fw-semibold">Password</label>
                            <div class="input-group input-group-lg">
                                <input
                                    id="password"
                                    name="password"
                                    type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    autocomplete="current-password"
                                    required
                                >
                                <button
                                    class="btn btn-outline-secondary"
                                    type="button"
                                    id="toggle-password"
                                    aria-label="Tampilkan password"
                                    aria-pressed="false"
                                >
                                    <i class="fa-regular fa-eye" aria-hidden="true"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-sda btn-lg w-100 rounded-pill">
                            <i class="fa-solid fa-right-to-bracket me-2" aria-hidden="true"></i>Masuk
                        </button>
                    </form>
                </div>
                <p class="small text-center text-secondary mt-3 mb-0">
                    Akun Pengelola Data dibuat oleh administrator melalui proses internal.
                </p>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('toggle-password');

        togglePassword.addEventListener('click', () => {
            const isVisible = passwordInput.type === 'text';
            passwordInput.type = isVisible ? 'password' : 'text';
            togglePassword.setAttribute('aria-pressed', String(!isVisible));
            togglePassword.setAttribute('aria-label', isVisible ? 'Tampilkan password' : 'Sembunyikan password');
            togglePassword.innerHTML = `<i class="fa-regular ${isVisible ? 'fa-eye' : 'fa-eye-slash'}" aria-hidden="true"></i>`;
        });
    </script>
@endpush
