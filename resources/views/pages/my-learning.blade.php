@extends('layouts.master')
@section('main-content')

    <div class="my-learning-section">
        <div class="my-learning-section__header">
            <div class="header-bar">
                <h1>My learning</h1>

                <div class="bar">
                    <span>All courses</span>
                </div>
            </div>
        </div>
        @if (!count($courses))
            <div class="txt">
                <p>
                    Start learning from over 183,000 courses today.
                </p>
                <p>
                    When you enroll in a course, it will appear here.
                    <a href="{{ route('category') }}">Browse now.</a>
                </p>

            </div>
        @else
            <div class="my-learning-section__courses">
                <div class="list-courses">
                    @foreach ($courses as $course)
                        @include('components.learning',
                        ['course'=>$course])
                    @endforeach
                </div>
            </div>

            {{ $courses->links() }}

        @endif
    </div>

@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/progressbar.js/0.6.1/progressbar.min.js"
        integrity="sha512-7IoDEsIJGxz/gNyJY/0LRtS45wDSvPFXGPuC7Fo4YueWMNOmWKMAllEqo2Im3pgOjeEwsOoieyliRgdkZnY0ow=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script>
        $(".progress-wrapper .progress").each(function(i, e) {
            const current_progress = $(this).data('progress')
            // $(e).data('progress')
            const line = new ProgressBar.Line($(this)[0], {
                strokeWidth: 2,
                trailColor: "#f5f5f5",
                easing: "easeOut",
                color: "#93cb0b",
                duration: 1500,
            });

            line.animate(current_progress);
        })
    </script>
@endsection
