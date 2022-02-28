@extends('layouts.login')

@section('main-content')
    <div class="login container">
        <div class="login-wrap">
            <div class="login-body">
                <div class="form-body">
                    <a href="{{ route('home') }}" class="logo">
                        Devco
                    </a>

                    <form action="{{ route('login') }}" class="signin-form" method="POST">
                        @csrf
                        <div class="form-login style-space">
                            <label for="email">Email của bạn</label>
                            <input autocomplete="email" type="email" value="{{ old('email') }}" name="email" id="email"
                                class="form-input" />
                            @error('email')
                                <span class="message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-login password">
                            <label for="password">Mật khẩu</label>
                            <input autocomplete="current-password" type="password" name="password" id="password"
                                class="form-input" />
                            @error('password')
                                <span class="message">{{ $message }}</span>
                            @enderror
                        </div>
                        <p class="form-login style-space quiz password">
                            <a href="">Quên mật khẩu?</a>
                        </p>

                        @error('message')
                            <span class="message">{{ $message }}</span>
                        @enderror

                        <div class="checkbox-container d-flex">
                            <input id="remember" name="remember" checked type="checkbox">
                            <label for="remember">Remember me</label>
                        </div>
                        <div class="submit">
                            <button type="submit" class="sign-in">Đăng nhập</button>
                        </div>
                    </form>
                    <div class="style-space-page OR">
                        <span>Hoặc</span>
                    </div>
                    <div class="sign-up">
                        <span>Chưa có tài khoản? </span>
                        <a href="{{ route('sign-up') }}" class="style-space">
                            Đăng ký ngay
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
