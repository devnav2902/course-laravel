<div class="course">
  <a href="{{ route('course', ['url' => $course->slug]) }}" class="image-course">
    <img src="{{ asset($course->thumbnail) }}" alt="" />
  </a>
  <div class="profile-course">
    <div class="name-course truncate">
      <a href="{{ route('course', ['url' => $course->slug]) }}">
        {{ $course->title }}
      </a>
    </div>
    <a href="{{ route('instructor', ['slug' => $course->author->slug]) }}" class="author ">
      {{ $course->author->fullname }}
    </a>
    <div class="rating-price">
      @if (!empty($course->rating_avg_rating))
        <div class="rating">
          <span class="avg-rating">
            {{ number_format($course->rating_avg_rating, 1) }}
          </span>
          <div class="stars-rating">
            @inject('helper', 'App\Http\Controllers\HelperController')
            {!! $helper::render_star($course->rating_avg_rating) !!}
          </div>
          @if (!empty($course->rating_count))
            <span class="count">
              ({{ $course->rating_count }})
            </span>
          @endif
        </div>
      @endif

      <h4 class="price ">
        @if ($course->price->price == 0.0)
          Free
        @else
          ${{ $course->price->price }}
        @endif
      </h4>
    </div>
  </div>
</div>
