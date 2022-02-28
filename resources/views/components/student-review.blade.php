<div class="student-review-box">
    <h6>Student feedback</h6>

    <!-- Inner Student Review Box -->
    <div class="inner-student-review-box">
        <!-- Rating Column -->
        <div class="rating-column">
            <div class="inner-column">
                @if (!empty($course->rating_avg_rating))
                    <div class="total-rating">
                        {{ number_format($course->rating_avg_rating, 1) }}
                    </div>
                @endif
                <div class="rating">
                    @inject('helper', 'App\Http\Controllers\HelperController')
                    {!! $helper::render_star($course->rating_avg_rating) !!}
                </div>
                <div class="title">Course Rating</div>
            </div>
        </div>
        <!-- Graph Column -->
        <div class="graph-column">
            <!-- Skills -->
            <div class="skills">
                @for ($i = count($graph) - 1; $i >= 0; $i--)
                    @php $rating =$i+1; @endphp
                    <div class="skill-item">
                        <div class="skill-bar">
                            <div class="bar-inner">
                                <div class="bar progress-line" style="width:{{ $graph[$i]->percent }}%"
                                    data-percent="{{ $graph[$i]->percent }}">
                                </div>
                            </div>

                            <div class=" rating">
                                <div class="stars">
                                    <i class="fas fa-star"></i>
                                    @if ($rating == 1)
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    @elseif ($rating == 2)
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    @elseif ($rating == 3)
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    @elseif($rating == 4)
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                    @elseif($rating == 5)
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    @endif
                                </div>
                                <span>
                                    {{ $graph[$i]->percent . '%' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>
            <!-- end skills -->
        </div>
        <!-- end graph column -->
    </div>
    <!-- end inner -->
</div>
