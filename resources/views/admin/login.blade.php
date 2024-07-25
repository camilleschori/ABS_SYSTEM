@section('title', 'Login')
@extends('admin.layout')


@section('content')

    <div id="auth">

        <div class="row h-100 justify-content-center align-items-center glass">


            <div class="col-lg-3 col-10 bg-white shadow-sm border rounded-4 glass ">
                <div id="auth-left" style="padding: 2rem">
                    <div class="mb-4 text-center">
                        <a href="/"><img src="{{ url('admin/assets/images/logo.webp') }}" class="img-fluid" width="130"
                                alt="Logo"></a>
                    </div>
                    <h3 class="mb-3 text-center">تسجيل دخول</h3>
                    {{-- <p class="mb-3">قم بكتابة البريد الالكتروني وكلمة المرور للدخول</p> --}}

                    <form action="{{ route('admin.login.submit') }}" method="POST">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-2 @error('email') is-invalid @enderror">
                            <input type="email" class="form-control form-control-xl" placeholder="البريد الالكتروني"
                                name="email" value="{{ old('email') }}">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group position-relative has-icon-left mb-2">
                            <input type="password"
                                class="form-control form-control-xl @error('password') is-invalid @enderror "
                                placeholder="كلمة المرور" name="password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-check form-check-lg d-flex align-items-end">
                            <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault"
                                name="remember_me" {{ old('remember_me') ? 'checked' : '' }}>
                            <label class="form-check-label text-gray-600" for="flexCheckDefault">
                                ابقني متصلاً
                            </label>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-sm mt-5">تسجيل الدخول</button>
                    </form>

                    <div class="text-center mt-5 text-danger">
                        @error('no_permissions')
                            {{ $message }}
                        @enderror
                    </div>

                </div>
            </div>

            <div class="copywrite text-center">
                <p class="mb-0">Powred by <a href="https://www.sky-control.net" target="_blank">Sky Control</a> | All
                    Right Reserved © {{ date('Y') }} </p>
            </div>


        </div>

    </div>

@endsection
