@extends('layouts.login')

@section('main-content')
    <div class="login container">
        <div class="login-wrap">
            <div class="login-body">
                <div class="form-body">
                    <a href="{{ route('home') }}" class="logo">Devco
                    </a>
                    <p class="title">Đăng ký tài khoản</p>
                    <form action="{{ route('createUser') }}" class="account-form" method="POST">
                        @csrf

                        <div class="style-space">
                            <div class="form-login style-space">
                                <label for="fullname">Tên của bạn</label>
                                <input required type="text" value="{{ old('fullname') }}" name="fullname" id="fullname"
                                    class="form-input" />
                                @error('fullname')
                                    <span class="message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-login style-space email">
                            <label for="email">Email của bạn</label>
                            <input required value="{{ isset($email) ? $email : old('email') }}" type="email" name="email"
                                id="email" class="form-input" />

                            @error('email')
                                <span class="message">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-login password">
                            <label for="password">Mật khẩu</label>
                            <input required type="password" name="password" id="password" class="form-input" />
                            @error('password')
                                <span class="message">{{ $message }}</span>
                            @enderror
                        </div>
                        <input type="hidden" name="avatar" value="{{ old('avatar') }}">
                        <div class="submit">
                            <button type="submit" class="sign-in">Tạo tài khoản</button>
                        </div>
                    </form>
                    <div class="footer-content">
                        <span>Đã có tài khoản? </span>
                        <a href="{{ route('showLogin') }}" class="style-space sign-up">
                            Đăng nhập ngay
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
