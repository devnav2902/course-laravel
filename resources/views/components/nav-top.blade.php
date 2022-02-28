{{-- {{ dd($globalNotificationCourse) }} --}}
<nav class="nav-top">
    <div class="nav-content">
        <div class="logo"><a href="{{ route('home') }}">devco</a></div>
        <div class="category-link">
            <a href="{{ route('category') }}">Danh mục khóa học</a>
        </div>
        <form action="{{ route('search') }}" class="search-bar">

            <div class="icon">
                <svg style="fill: #000;" class="search-icon" height="20" viewBox="0 0 24 24" width="20">
                    <path
                        d="M10 17a7 7 0 1 0 0-14 7 7 0 0 0 0 14zm6-1.708l5.854 5.854a.5.5 0 0 1-.708.708l-5.854-5.855a8 8 0 1 1 .707-.707z">
                    </path>
                </svg>
            </div>

            <input type="text" placeholder="Chào bạn! hôm nay bạn muốn học gì?" autocomplete="off" class="input-search"
                name="input-search" />


            <div class="search">
                <div class="search-result">
                    <div class="result-search"></div>
                    <div class="see-more">
                        <button type="submit" class="btn btn-form a-see-more">
                            Xem thêm...
                        </button>
                    </div>
                </div>
            </div>
        </form>

        @if (!Auth::check())
            <a class="instructor" href="{{ route('instructor-courses') }}">Giảng dạy trên Devco</a>
            <div class="shopping-cart">
                <a href="{{ route('cart') }}" class="link">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="notification-badge"></span>
                </a>
            </div>
            <a class='btn-style-two login-button' href='{{ route('showLogin') }}'>Đăng nhập</a>
            <a class='btn-style-two signup-button' href='{{ route('sign-up') }}'>Đăng ký</a>
        @else
            <div class="user">

                <a href="{{ route('instructor-courses') }}" class="">Quản lý khóa học</a>

                <a href="{{ route('my-learning') }}" class="">My learning</a>

                <div class="shopping-cart">
                    <a href="{{ route('cart') }}" class="link">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="notification-badge"></span>
                    </a>
                </div>

                <div class="notification">
                    <div class="icon-notification @if (count($globalNotificationCourse)) has @endif">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="wrapper-notification">
                        <div class="header-notification d-flex">
                            <h6>Thông báo</h6>
                            {{-- <a href="{{ route('notification') }}">Xem tất cả</a> --}}
                        </div>

                        @if (!count($globalNotificationCourse))
                            <div class="notification-tab-pane center">
                                Không có thông báo mới.
                            </div>
                        @else
                            <div class="notification-tab-pane">
                                @foreach ($globalNotificationCourse as $courses)
                                    @foreach ($courses->notification_course as $notifi)
                                        @include('components.notification-item',
                                        ['notifi'=>$notifi])
                                    @endforeach
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>


                <div class="user-dropdown d-flex">
                    <span class="profile-img">
                        <img src="{{ asset($globalUser->avatar) }}" alt="" />
                    </span>
                    <div class="icon"><i class="fas fa-chevron-down"></i></div>
                    <div class="profile-content">
                        <div class="profile-info">
                            <a href="{{ route('instructor', ['slug' => $globalUser->slug]) }}">
                                <div class="user-img">
                                    <img src="{{ asset($globalUser->avatar) }}" alt="">
                                </div>
                                <div class="account">
                                    <p>{{ $globalUser->fullname }}</p>
                                    <span>{{ $globalUser->email }}</span>
                                </div>
                            </a>
                        </div>
                        <!-- Pages -->
                        <ul class="pages">
                            @if ($globalUser->role->name === 'user')
                                <li><a href='{{ route('instructor-courses') }}'>Instructor dashboard</a></li>
                                <li><a href='{{ route('purchase-history') }}'>Lịch sử thanh toán</a></li>
                            @else
                                <li><a href='{{ route('instructor-courses') }}'>Dashboard</a></li>
                            @endif

                            <li><a href='{{ route('profile') }}'>Profile & settings
                                </a></li>
                            <li><a href='{{ route('logout') }}'>Đăng xuất</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        @endif
</nav>
