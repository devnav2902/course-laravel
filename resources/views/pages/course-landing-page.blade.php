@extends('layouts.instructor-courses',['course'=>$course])
@section('main-content')
  <div id="message-auto" class="rounded"></div>

  <div class="edit-course-section">
    <form method="POST" id='form-course' action="" enctype="multipart/form-data">

      <div class="inner-column">
        <h6 class="">Thông tin khóa học</h6>

        <!-- Edit Course Form -->
        <div class="edit-course-form">
          <!-- Form Group -->
          <div class="form-group">
            <label>Tiêu đề khóa học</label>
            <input class="course-title " type="text" name="title" value="{!! $course->title !!}"
              placeholder="Nhập tiêu đề cho khóa học" required>
          </div>

          <div class="form-group">
            <label>Mô tả khóa học</label>

            <textarea class="description " name="description" id="description" placeholder="Nhập mô tả ngắn về khóa học"
              required>{{ $course->description }}</textarea>
          </div>


          <div class="form-group">
            <label>Promotional video</label>
            <input type="text" id="demo-video-url" class="demo-video-url" name="video_demo"
              value="{{ $course->video_demo }}" class="autoSaveValue"
              placeholder="https://www.youtube.com/dummy-video.com">
          </div>


          <div class="form-group">
            <label for="categories">Thông tin cơ bản</label>
            <div class="category-box">
              <select name="category[]" id="" multiple class="cat-multi">
                @foreach ($categories as $category)
                  <option value="{{ $category->id }}" @if (isset($category->selected))
                    selected
                @endif>
                {{ $category->title }}</option>
                @endforeach

              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="thumbnail" id="label-thumbnail" data-course="{{ $course->id }}">Hình ảnh khóa
              học</label>
            <input type="image" name="thumbnail" id="thumbnail">

            @if (!empty($course->thumbnail))
              <div class="gallery">
                <div class="image-item">
                  <img title="thumbnail post" src="{{ asset($course->thumbnail) }}" alt="Không tìm thấy hình này!">
                </div>
              </div>
            @endif
          </div>

          <div class="form-group">
            <label>Thông tin cá nhân</label>
            <div class="instructor-profile">
              <div class="instructor-profile__info">
                Tất cả các thông tin của giảng viên phải được điền đầy đủ trước khi khóa học được mở bán
                công khai. Bao gồm tên, hình ảnh, và giới thiệu ngắn tối thiểu 50 từ.

                <a href="{{ route('profile') }}">Tới trang profile.</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
  <!-- end edit course -->
@endsection
