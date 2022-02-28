<div class="ratings">
    <span>
        @if (!empty($course->rating_avg_rating))
            {{ number_format($course->rating_avg_rating, 1) }}
        @else
            0.0
        @endif
    </span>
    <div class="stars">
        @inject('helper', 'App\Http\Controllers\HelperController')
        {!! $helper::render_star($course->rating_avg_rating) !!}
    </div>
    <span>
        @if ($course->rating_count >= 2)
            {{ $course->rating_count }} ratings
        @else
            {{ $course->rating_count }} rating
        @endif

    </span>
    <span>
        @if ($course->course_bill_count >= 2)
            {{ $course->course_bill_count }} students
        @else
            {{ $course->course_bill_count }} student
        @endif
    </span>
</div>
