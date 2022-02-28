<div class="course">
  <a href="{{ route('learning', ['url' => $course->slug]) }}" class="image-course">
    <img src="{{ asset($course->thumbnail) }}" alt="" />
  </a>
  <div class="profile-course">
    <h4 class="name-course truncate">
      <a target="_blank" href="{{ route('learning', ['url' => $course->slug]) }}">
        {{ $course->title }}
      </a>
    </h4>
    <a target="_blank" href="{{ route('instructor', ['slug' => $course->author->slug]) }}" class="author ">
      {{ $course->author->fullname }}
    </a>

    @if ((float) $course->count_progress === 0.0)
      <div class="course-footer">
        <a href="{{ route('learning', ['url' => $course->slug]) }}">
          Bắt đầu học
        </a>
      </div>
    @else
      <div class="course-footer">
        <div class="progress-wrapper">
          <div data-progress="{{ $course->count_progress }}" class="progress"></div>
          <div class="progress-info">
            <span class="count-progress">{{ $course->count_progress * 100 }}%</span>
            <span>Complete</span>
          </div>
        </div>

        <div class="course-rating">
          @if (count($course->rating))
            @inject('helper', 'App\Http\Controllers\HelperController')
            {!! $helper::render_star($course->rating[0]->rating) !!}
            <a href="javascript:void(0)">Bạn đã đánh giá</a>
          @else
            @inject('helper', 'App\Http\Controllers\HelperController')
            {!! $helper::render_star(0) !!}
            <a href="{{ route('course', ['url' => $course->slug]) }}">Để lại đánh giá</a>
          @endif
        </div>
      </div>
    @endif
  </div>
</div>
