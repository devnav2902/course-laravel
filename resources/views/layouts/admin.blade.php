<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! SEOMeta::generate() !!}

    <link rel="stylesheet" href="{{ asset('style/style.css') }}">
</head>

<body>
    <div class="wrapper adminpage">
        <!-- nav -->
        @include('components.nav-top')
        <!-- end nav -->
        <main class="main main-adminpage">
            <div class="sidebar">
                <ul class="navbar">
                    <li>
                        <a class="navbar-link" href="/fecourses/admin">
                            <span><i class="far fa-chart-bar"></i>Dashboard</span></a>
                    </li>
                    <li>
                        <a class="navbar-link" href="/fecourses">
                            <span><i class="fas fa-h-square"></i> Trang chủ</span></a>
                    </li>
                    <li>
                        <div class="navbar-link" href="#">
                            <span><i class="far fa-list-alt"></i> Quản lí khóa học</span>
                            <ul>
                                <li><a href="manage-course">Tất cả khóa học</a></li>
                                <li><span class="add-new-course">Tạo khóa học mới</span></li>
                            </ul>
                        </div>
                        <input type="hidden" id='create-course' name="create-course" class="create-course">
                    </li>
                    <li>
                        <div class="navbar-link" href="#">
                            <span>
                                <i class="fas fa-box-open"></i></i>Danh mục
                            </span>
                            <ul>
                                <li><a href="manage-category/create">Chỉnh sửa danh mục</a></li>
                            </ul>
                            </a>
                    </li>

                    <li>
                        <a class="navbar-link" href="slide/edit">
                            <span><i class="fas fa-sliders-h"></i></i>Chỉnh sửa slide</span></a>
                    </li>
                    <li>
                        <a class="navbar-link" href="team.html">
                            <span><i class="fas fa-chalkboard-teacher"></i>Instructors</span></a>
                    </li>
                    <li>
                        <a class="navbar-link" href="contact.html">
                            <span><i class="fas fa-mail-bulk"></i>Contact Us</span></a>
                    </li>
                </ul>

            </div>
            <div class="main-content">
                @yield('main-content')
            </div>
        </main>
        <!-- footer -->
        @include('components.footer')
    </div>



    @yield('script')
</body>

</html>
