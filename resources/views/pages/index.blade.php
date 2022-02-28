@extends('layouts.master')
@section('main-content')
  <div class="main-home">
    <div class="main-home__content">
      <div class="banner-content">
        <img width="1340" height="400"
          src="https://static.skillshare.com/cdn-cgi/image/quality=85,format=auto/assets/images/browse/browse-banner-1.webp"
          alt="">
        <div class="content-box">
          <h1 class="short-title">Khóa học tại Devco</h1>
          <p class="subtitle">Tất cả kiến thức tại Devco đều được review bởi đội ngũ chuyên gia có kinh
            nghiệm. Hãy chọn instructor mà bạn tin tưởng & bắt đầu trải nghiệm.</p>
        </div>
      </div>

      <div class="page-wrapper">
        <div class="page-wrapper__content">
          {{-- <div class="section-title"></div> --}}

          <div class="latest-courses list-items">
            <h2 class="title">Khóa học mới</h2>
            <div class="container_wrap">
              <div class="box-courses">
                <div class="nav">
                  <i class="fas btn fa-chevron-left btnLeft"></i><i class="fas btn fa-chevron-right btnRight"></i>
                </div>
                <div class="list-courses">
                  @foreach ($latestCourses as $course)
                    @include('components.course',['course'=>$course])
                  @endforeach
                </div>
              </div>
            </div>
          </div>

          <div class="featured_course list-items">
            <h2 class="title">Khóa học nổi bật</h2>
            <div class="container_wrap">
              <div class="box-courses">
                <div class="nav">
                  <i class="fas btn fa-chevron-left btnLeft"></i><i class="fas btn fa-chevron-right btnRight"></i>
                </div>
                <div class="list-courses">
                  @foreach ($featuredCourses as $course)
                    @include('components.course',['course'=>$course])
                  @endforeach
                </div>
              </div>
            </div>
          </div>

          <div class="bestseller_course list-items">
            <h2 class="title">Khóa học bán chạy</h2>
            <div class="container_wrap">
              <div class="box-courses">
                <div class="nav">
                  <i class="fas btn fa-chevron-left btnLeft"></i><i class="fas btn fa-chevron-right btnRight"></i>
                </div>
                <div class="list-courses">
                  @foreach ($bestseller as $course)
                    @include('components.course',['course'=>$course])
                  @endforeach
                </div>
              </div>
            </div>
          </div>

          <div class="authors list-items">
            <h2 class="title">Giảng viên tiêu biểu</h2>
            <div class="container_wrap">
              <div class="nav">
                <i class="fas btn fa-chevron-left btnLeft"></i><i class="fas btn fa-chevron-right btnRight"></i>
              </div>
              <div class="author-box">
                @foreach ($instructors as $author)
                  <a class="inner-box" href="{{ route('instructor', ['slug' => $author->slug]) }}">
                    <div class="image">
                      <img src="{{ asset($author->avatar) }}" alt="" />
                    </div>
                    <div class="name">
                      {{ $author->fullname }}
                    </div>

                    <div class="author-box__footer">
                      <div class="num_students">
                        <span class="num fw-bold">
                          {{ $author->count_students }}
                        </span>
                        {{ $author->count_students > 1 ? 'students' : 'student' }}
                      </div>
                      <div class="num_courses">
                        <span class="num fw-bold">
                          {{ $author->course_count }}
                        </span>
                        {{ $author->course_count > 1 ? 'courses' : 'course' }}
                      </div>
                    </div>
                  </a>
                @endforeach
              </div>

            </div>
          </div>
        </div>
      </div>
      <div class="content-wrapper d-flex align-items-center">
        <img src="https://s.udemycdn.com/home/non-student-cta/instructor-1x-v3.jpg" class="image" alt=""
          width="400" height="400">
        <div class="">
          <h3 class="header">Become an instructor</h3>
          <p class="content">
            Trở thành giảng viên tại Devco, chia sẻ kiến thức & nhận lại không giới hạn giá trị.
          </p>
          <div class="link">
            <a href="{{ route('instructor-courses') }}" class="btn-style-two">Bắt đầu ngay</a>
          </div>
        </div>
      </div>
    </div>

  </div>
  </div>
@endsection
@section('script')
  <script type="module" src="{{ asset('js/home.js') }}"></script>
@endsection
