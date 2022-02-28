<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        {!! SEOMeta::generate() !!}

        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css"
            integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />

        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"
            integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw=="
            crossorigin="anonymous"
            referrerpolicy="no-referrer"
        />

        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"
            integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w=="
            crossorigin="anonymous"
        />
        <link
            rel="stylesheet"
            type="text/css"
            href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"
        />

        <link
            href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
            rel="stylesheet"
        />

        <link
            href="https://unpkg.com/filepond@^4/dist/filepond.css"
            rel="stylesheet"
        />
        <link
            href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css"
            rel="stylesheet"
        />
        <link
            href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css"
            rel="stylesheet"
        />
        @yield('link')

        <link rel="stylesheet" href="{{ asset('style/style.css') }}" />
    </head>

    <body class="body-overview">
        <div class="wrapper instructor-page">
            <main class="main-overview-page">
                <div class="sidebar-menu">
                    <div class="menu">
                        <ul>
                            <li>
                                <a class="logo" href="{{ route('home') }}">
                                    <span>D</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('instructor-courses') }}">
                                    <i class="fas fa-tv"></i>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('instructor-overview') }}">
                                    <i class="fas fa-chart-bar"></i>
                                </a>
                            </li>
                            @if ($globalUser->role->name === 'admin')
                            <li>
                                <a
                                    href="{{
                                        route('submission-courses-list')
                                    }}"
                                >
                                    <i class="fas fa-eye"></i>
                                </a>
                            </li>
                            @endif
                            <div class="hover">
                                <div class="hover__item">
                                    <a class="logo" href="{{ route('home') }}">
                                        <div class="logo__container">
                                            <span class="first-letter">D</span>
                                            <span class="full-text">Devco</span>
                                        </div>
                                    </a>
                                </div>
                                <div class="hover__item">
                                    <a href="{{ route('instructor-courses') }}">
                                        <i class="fas fa-tv"></i>
                                        <span>Courses</span>
                                    </a>
                                </div>
                                <div class="hover__item">
                                    <a
                                        href="{{
                                            route('instructor-overview')
                                        }}"
                                    >
                                        <i class="fas fa-chart-bar"></i>
                                        <span>Performance</span>
                                    </a>
                                </div>
                                @if ($globalUser->role->name === 'admin')
                                <div class="hover__item">
                                    <a
                                        href="{{
                                            route('submission-courses-list')
                                        }}"
                                    >
                                        <i class="fas fa-eye"></i>
                                        <span>Review courses</span>
                                    </a>
                                </div>
                                @endif
                            </div>
                        </ul>
                    </div>
                </div>
                <div class="main-content main-overview-content">
                    @yield('main-content')
                </div>
            </main>
            <!-- footer -->
            @include('components.footer')
        </div>

        <script
            src="https://code.jquery.com/jquery-3.6.0.min.js"
            integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
            crossorigin="anonymous"
        ></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
        <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

        <script
            type="module"
            src="{{ asset('js/instructor-courses.js') }}"
        ></script>
        @yield('script')
    </body>
</html>
