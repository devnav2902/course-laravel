@extends('layouts.master')
@section('link')
    <link href="//vjs.zencdn.net/7.10.2/video-js.min.css" rel="stylesheet">
@endsection
@section('main-content')
    <div class="main-lesson">
        <div class="header-content">
            @if ($globalUser->role->name === 'user')
                <i class="fas fa-exclamation-triangle"></i>
                <div class="notification">
                    <h6>Khóa học này đang trong chế độ xét duyệt.</h6>
                    <span class="contact">Để biết thêm thông tin, vui lòng liên hệ
                        <a
                            href="{{ route('instructor', ['slug' => $course->author->slug]) }}">{{ $course->author->fullname }}</a>.</span>
                </div>
            @else
                <form id="approved" action="{{ route('course-ratify') }}" method="POST"> @csrf</form>
                <form id="unapproved" action="{{ route('course-ratify') }}" method="post"> @csrf</form>

                <div class="actions">
                    <input form="unapproved" type="hidden" value="{{ $course->id }}" name="course_id">
                    <input form="unapproved" type="hidden" value="unapproved" name="option">
                    <input form="approved" type="hidden" value="{{ $course->id }}" name="course_id">
                    <input form="approved" type="hidden" value="approved" name="option">

                    <button form="unapproved" type="submit">Cần chỉnh sửa</button>
                    <button form="approved" type="submit">Chấp thuận</button>
                </div>
            @endif
        </div>
        <div class="main-content">
            <div class="course-content">
                <!-- Sec Title -->
                <div class="title">
                    <h1> {!! $course->title !!} </h1>

                </div>
                <!-- Rating -->
                <div class="rating-content">

                    <span>
                        0.0
                    </span>

                    <span class="stars">
                        <i class="fas fa-star"></i>
                    </span>
                    <span>
                        0 ratings
                    </span>
                    <span>
                        0 students
                    </span>


                </div>
                <!-- Video Info Boxed -->
                <div class="video-info-boxed">
                    <div class="pull-left">
                        <h6>Giảng viên</h6>
                        <div class="info-author">
                            <div class="authors">
                                {{ $course->author->fullname }}
                            </div>

                        </div>
                    </div>
                    <div class="pull-right">
                        <ul class="social-box">
                            <li class="share">Chia sẻ trên:</li>
                            <li class="facebook">
                                <a href="#" class=""><i class=" facebook-icon fab fa-facebook-f"></i></a>
                            </li>
                            <li class="google">
                                <a href="#" class=""><i class=" google-icon fab fa-google"></i></a>
                            </li>
                            <li class="twitter">
                                <a href="#" class=""><i class=" twitter-icon fab fa-twitter"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- End Video Info Boxed -->

                <!-- Course Info Tabs-->
                <div class="course-info-tabs rounded">
                    <!-- Course Tabs-->
                    <div class="course-tabs tabs-box">
                        <!-- Tab Btns -->
                        <ul class="tab-btns tab-buttons">
                            <li data-tab="class-detail" class="tab-btn">Thông tin học tập</li>
                            <li data-tab="curriculum" class="tab-btn">Nội dung khóa học</li>
                            <li data-tab="review-box" class="tab-btn active-btn">
                                Student feedback
                            </li>
                        </ul>

                        <!-- Tabs Container -->
                        <div class="tabs-content">
                            <!-- Tab / Active Tab -->
                            <div class="tab" id="class-detail">
                                <div class="content">
                                    <!-- Class Detail Content -->
                                    <div class="class-detail-content">
                                        <div class="text markdown">{!! $course->description !!}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab -->
                            <div class="tab" id="curriculum">
                                <div class="content">
                                    <!-- Accordion Box -->
                                    <ul class="accordion-box">
                                        <!-- Block -->
                                        @foreach ($course->section as $section)

                                            <li class="accordion block">
                                                <div class="acc-btn">
                                                    <div class="icon-outer">
                                                        <i class="fas fa-angle-down"></i>
                                                    </div>
                                                    {!! $section->title !!}
                                                </div>
                                                {{-- <div class="acc-content" style="display: none;"> --}}
                                                <div class="acc-content">
                                                    @foreach ($section->lecture as $lecture)

                                                        <div class="content">
                                                            {{-- <input type="hidden" value="<?php echo $video['video_url']; ?>"> --}}
                                                            <a href="#" class="play-media">
                                                                <div class="pull-left">
                                                                    <i
                                                                        class="fas fa-lock media-icon"></i>{!! $lecture->title !!}
                                                                </div>
                                                                <div class="pull-right">
                                                                    <div class="minutes">35 Minutes</div>
                                                                </div>
                                                            </a>
                                                        </div>
                                                        <!-- end content -->
                                                    @endforeach
                                                </div>
                                            </li>
                                        @endforeach


                                    </ul>
                                </div>
                            </div>

                            <!-- Tab -->
                            <div class="tab active-tab" id="review-box">
                                <div class="student-review-box">
                                    <h6>Student feedback</h6>

                                    <!-- Inner Student Review Box -->
                                    <div class="inner-student-review-box">
                                        Khóa học này chưa có đánh giá.
                                    </div>
                                    <!-- end inner -->
                                </div>
                                <!-- end student review box -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-content__sidebar">
                <!-- Review Widget -->
                <div class="widget-content sticky-top">
                    <!-- Video Box -->
                    <div class="intro-video" style="background-image: url('{{ asset($course->thumbnail) }}');">
                        <div class="intro-video-play">
                            <span class="lightbox-image intro-video-box" class="media-play-symbol"><i
                                    class="fas fa-play media-icon"></i> </span>
                        </div>
                        <h4>Xem thử</h4>
                    </div>
                    <!-- End Video Box -->
                    <div class="price">

                        <span class="original-price">
                            ${{ $course->price->price }}
                        </span>

                    </div>


                    <div class="infor-course">
                        <h4>Khóa học này gồm có:</h4>
                        {{-- <li>{{ $course->section->lecture->resource_count }} downloadable resources</li> --}}
                        <li>
                            @php $resource_count = 0 @endphp
                            @foreach ($course->section as $section)
                                @php $resource_count += $section->resource->count() @endphp
                            @endforeach
                            {{ $resource_count }} tài liệu học tập
                        </li>
                        <li>{{ $course->section->count() }} chương học</li>
                        <li>{{ $course->lecture->count() }} bài giảng</li>
                    </div>

                </div>
                <!-- End  Widget -->
            </div>
            <!-- ALERT -->
            <div class="alert-box">
                <div class="box">
                    <h1></h1>
                    <span></span>
                    <button class="view-course" type="button">Xem ngay</button>
                </div>
            </div>
        </div>
    </div>
    <div class="video-demo hidden">
        <div class="video-container">
            <div class="video">
                <div class="video-top">
                    <div class="video-top-left">
                        <h5>Course Preview</h5>
                    </div>
                    <div class="video-top-right">
                        <i class="fas fa-times"></i>
                    </div>
                </div>
                <h4>{{ $course->title }}</h4>
                <video class="video-js vjs-big-play-centered" id="videoPlayer" controls
                    poster="{{ $course->thumbnail }}">

                    <source src="{{ asset('helpers/video.mp4') }}" type="video/mp4">

                    <p class="vjs-no-js">
                        To view this video please enable JavaScript, and consider upgrading to a
                        web browser that
                        <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                    </p>
                </video>

            </div>

        </div>
    </div>

    <!-- end wrapper -->

@endsection
@section('script')
    <script type="module" src="{{ asset('js/course-lesson.js') }}"></script>
    <script src="//vjs.zencdn.net/7.10.2/video.min.js">
    </script>
@endsection
