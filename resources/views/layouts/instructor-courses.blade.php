<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {!! SEOMeta::generate() !!}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css"
        integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"
        integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"
        integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w=="
        crossorigin="anonymous" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
        rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">


    <link rel="stylesheet" href="{{ asset('style/style.css') }}">

</head>

<body>
    <div class="wrapper instructor-page">
        <nav class="nav">
            <div class="nav-content">
                <a href="{{ route('instructor-courses') }}">
                    <i class="fas fa-chevron-left"></i>
                    <span class="back">Trở về trang khóa học</span>
                </a>
                <span title="{!! $course->title !!}" class="course-title">{!! $course->title !!}</span>
                <span class="header-status">
                    @if ($course->isPublished === 0)
                        Draft
                    @else
                        Published
                    @endif
                </span>

                <a target="_blank" href="{{ route('draft', ['id' => $course->id]) }}" class="preview">
                    Xem thử
                </a>

                {{-- <button class="save">Save</button> --}}
            </div>

        </nav>
        <main class="main-instructor-page">
            <div class="sidebar">
                <ul class="navbar">
                    <li>
                        <strong>Create your content</strong>
                        <a class="navbar-link" href="{{ route('entry-course', ['id' => $course->id]) }}">
                            <span><i class="fas fa-h-square"></i>Thông tin khóa học</span></a>
                        <a class="navbar-link" href="{{ route('curriculum', ['id' => $course->id]) }}">
                            <span><i class="far fa-chart-bar"></i>Chương trình học</span></a>

                        <a class="navbar-link" href="{{ route('price', ['id' => $course->id]) }}">
                            <span><i class="fas fa-chalkboard-teacher"></i>Giá khóa học</span></a>

                        <a class="navbar-link" href="{{ route('promotions', ['id' => $course->id]) }}">
                            <span><i class="fas fa-mail-bulk"></i>Khuyến mại</span></a>

                    </li>
                </ul>
                <form action="{{ route('submit-for-review') }}" method="post">
                    @csrf
                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <button type="submit" class="submit">Yêu cầu xem xét</button>
                </form>
            </div>
            <div class="main-content">
                @yield('main-content')
            </div>
        </main>
        <!-- footer -->
        @include('components.footer')
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script type="module" src="{{ asset('js/instructor-courses.js') }}"></script>
    @yield('script')
</body>

</html>
