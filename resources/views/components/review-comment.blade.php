<div class="review-comments-box">
  @if (!$course->hasCommented && $isPurchased && $course->count_progress)
    <div id="message-comment"></div>
    <form action="{{ route('rating') }}" class="form" id="comment-form" method="POST">
      @csrf
      <input type="hidden" name="course_id" value="{{ $course->id }}">
      <div class="user-comment">
        <p>Bạn đánh giá khóa học này thế nào?</p>
        <b>Để lại đánh giá cho khóa học này nhé!</b>
        <div class="star-rating">
          <input type="hidden" value="5" name="rating" id="user_rating">
        </div>

        <div class="form-input">
          <span id="alert-message"></span>
          <textarea placeholder="Để lại bình luận..." name="content" maxlength="512" id="comment" cols="30"
            rows="5"></textarea>

          <button type="submit" class="btn-style-two">Submit Review</button>
        </div>
      </div>
    </form>
  @endif

  @if (count($course->rating))
    <h6>Reviews</h6>

    <!-- Reviewer Comment Box -->
    <div class="comment-box">
      @foreach ($course->rating as $rating)
        <div class="reviewer-comment-box">
          <div class="user-img">
            <img src=" {{ asset($rating->user->avatar) }}" alt="">
          </div>
          <div class="comment_content">
            <h4>{{ $rating->user->fullname }}
            </h4>
            <div class="rating">
              @inject('helper', 'App\Http\Controllers\HelperController')
              {!! $helper::render_star($rating->rating) !!}
              {{ $rating->created_at }}
            </div>
            <div class="text">
              {{ $rating->content }}
            </div>
            <div class="helpful">
              Bình luận này hữu ích với bạn?
            </div>
            <ul class="like-option">
              <li><i class="icon fas fa-thumbs-up"></i></li>
              <li><i class="fas icon fa-thumbs-down"></i></li>
              <li class="report">Report</li>
            </ul>
          </div>
        </div>
      @endforeach
    </div>

    {{-- {{ $course->rating->links() }} --}}
  @endif
</div>
