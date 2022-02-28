@extends('layouts.overview-course',['courses' => $courses])
@section('main-content')

  <div class="my-course-section">
    @if (!count($courses))
      <div class="empty">
        <div class="empty__header">
          <span>Bạn chưa tạo khóa học nào!</span>

          <a href="{{ route('show-create-course') }}" class="add-new-course btn-style-two">Tạo khóa học mới</a>
        </div>

        <div class="img">
          <img
            src="https://cdn.dribbble.com/users/2217210/screenshots/12013698/media/c5149aa66b86b923cbf219707265bf16.jpg"
            alt="" />
        </div>
      </div>
    @else
      <div class="menu-courses">
        <h2>Courses</h2>

        <div class="menu-courses-wrapper">
          <div class="search">
            <input type="text" placeholder="Tìm khóa học" />
            <i class="fas fa-search"></i>
          </div>

          <select name="" id="">
            <option value="">Newest</option>
            <option value="">A-Z</option>
          </select>

          <a href="{{ route('show-create-course') }}" class="menu-courses-wrapper__create-course btn-style-two">
            Tạo khóa học mới</a>
        </div>

        <ul>
          @foreach ($courses as $course)
            <li>
              <div class="img-courses">
                <img alt="" src="https://s.udemycdn.com/course/200_H/placeholder.jpg" />
              </div>
              <div class="info @if (!$course->submit_for_review) info-hover @endif ">
                <h5>{!! $course->title !!}</h5>

                <time>
                  {{ $course->updated_at }}
                </time>

                <div class="status">
                  @if ($course->isPublished)
                    <strong>Public</strong>
                    <span>Draft</span>
                  @else
                    <strong>Draft</strong>
                    <span>Public</span>
                  @endif
                </div>

                @if (!$course->submit_for_review)
                  <a class="view" href="{{ route('entry-course', ['id' => $course->id]) }}">Edit / Manage
                    course</a>
                @endif
              </div>
              @if ($course->submit_for_review)
                <div class="in-review">
                  <div class="in-review-top">
                    <i class="far fa-clock"></i>
                    <span>Đang được xem xét</span>
                  </div>
                  <span>Submitted On {{ $course->updated_at }}</span>
                </div>
              @endif
            </li>
          @endforeach
        </ul>
      </div>

      <div class="page-container">{{ $courses->onEachSide(1)->links() }}</div>
    @endif
  </div>

@endsection
