@extends('layouts.master')
@section('link')
  <link href="//vjs.zencdn.net/7.10.2/video-js.min.css" rel="stylesheet">
@endsection

@section('main-content')
  <div class="main-lesson">
    <div class="main-content">
      <div class="course-content">
        <!-- Sec Title -->
        <div class="title">
          <h1> {!! $course->title !!} </h1>
        </div>
        <!-- Rating -->
        <div class="rating-content">

          @if (!empty($course->rating_avg_rating))
            <span>
              {{ number_format($course->rating_avg_rating, 1) }}
            </span>
          @endif

          <span class="stars">
            @inject('helper', 'App\Http\Controllers\HelperController')
            {!! $helper::render_star($course->rating_avg_rating) !!}
          </span>
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
        <!-- Video Info Boxed -->
        <div class="video-info-boxed">
          <div class="pull-left">
            <h6>Giảng viên</h6>
            <div class="info-author">
              <div class="authors">
                <a href="{{ route('instructor', ['slug' => $course->author->slug]) }}">
                  {{ $course->author->fullname }}
                </a>
              </div>
            </div>
          </div>
          <div class="pull-right">
            <ul class="social-box">
              <li class="share">Chia sẻ khóa học:</li>
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
              <li data-tab="class-detail" class="tab-btn">Thông tin khóa học
              </li>
              <li data-tab="curriculum" class="tab-btn">Nội dung khóa học
              </li>
              <li data-tab="review-box" class="tab-btn active-btn">
                Đánh giá từ học viên
              </li>
            </ul>

            <!-- Tabs Container -->
            <div class="tabs-content">
              <!-- Tab / Active Tab -->
              <div class="tab" id="class-detail">
                <div class="content">
                  <!-- Class Detail Content -->
                  <div class="class-detail-content">
                    <div class="text">{!! $course->description !!}</div>
                  </div>
                </div>
              </div>

              <!-- Tab -->
              <div class="tab" id="curriculum">
                @include('components.curriculum',
                ['course'=>$course])
              </div>

              <!-- Tab -->
              <div class="tab active-tab" id="review-box">
                @include('components.student-review',['course'=>$course])
                <!-- end student review box -->

                <!-- Review Comments Box -->
                @include('components.review-comment',['course'=>$course])
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
            @if (empty($coupon))
              <span class="original-price">
                @if ($course->price->price == 0.0)
                  Free
                @else
                  ${{ $course->price->price }}
                @endif
              </span>
            @else
              @if ($coupon->discount_price <= $course->price->price)
                <span class="original-price">
                  @if (!empty($isFree))
                    Free
                  @else
                    ${{ $coupon->discount_price }}
                  @endif
                </span>
                <span class="original-price sale-off">
                  ${{ $course->price->price }}
                </span>
                <span class="discount">{{ $saleOff }}% off</span>
              @endif
            @endif
          </div>

          <div class="buttons-box">
            @if (Auth::check() && ($globalUser->role->name === 'admin' || $globalUser->id === $course->author_id))
              <a href='{{ route('learning', ['url' => $course->slug]) }}' class='theme-btn btn-style-one'>
                <span class='txt'>Xem</span>
              </a>
            @elseif (!$isFree && !$isPurchased)
              <div data-coupon="{{ !empty($couponJSON) ? $couponJSON : '' }}" data-course="{{ $course->id }}"
                class='addToCart'>Add to cart</div>
              <button data-course="{{ $course->id }}" class="buy" id="buy">Buy now</button>
            @else
              @if ($isPurchased)
                <a href='{{ route('learning', ['url' => $course->slug]) }}' class="enroll">
                  Vào học
                </a>
              @else
                @if (!empty($isFreeCoupon) || $isFree)
                  <form action="{{ route('free-enroll') }}" method="post">
                    @csrf
                    @if (!empty($isFreeCoupon))
                      <input type="hidden" name="coupon" value="{{ $coupon->coupon_id }}">
                      <input type="hidden" name="code" value="{{ $coupon->code }}">
                    @endif

                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                    <button class="enroll" id="enroll">Tham gia khóa học</button>
                  </form>
                @endif
              @endif
            @endif
          </div>
          {{-- End button box --}}

          <div class="infor-course">
            <h4>Khóa học gồm có:</h4>

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

          @if ($course->price->price !== 0.0)
            <form action="" id="coupon-form" method="POST" class="coupon">
              @csrf

              @if (empty($globalUser))
                <div class="coupon-wrapper">
                  <input name="coupon-input" placeholder="Enter Coupon" type="text">
                  <button id="apply" type="submit">Apply</button>
                </div>
              @else
                @if (!$isPurchased && $globalUser->id !== $course->author_id)
                  <div class="coupon-wrapper">
                    <input name="coupon-input" placeholder="Enter Coupon" type="text">
                    <button id="apply" type="submit">Apply</button>
                  </div>
                @endif
              @endif

              @if (Request::method() == 'POST')
                @if (empty($coupon))
                  <p class="warning">Mã code vừa nhập không chính xác, vui lòng thử lại.
                  </p>
                @else
                  <div class="coupon-code d-flex">
                    <button id="remove" type="button" onclick="location.href = location.href">
                      <i class="fas fa-times"></i>
                    </button>
                    <p><b>{{ $coupon->code }}</b> đã được áp dụng</p>
                  </div>
                @endif
              @endif
            </form>
          @endif
        </div>
      </div>
      <!-- End  Widget -->
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
        <video class="video-js vjs-big-play-centered" id="videoPlayer" controls poster="{{ $course->thumbnail }}">

          <source src="{{ asset($course->video_demo) }}" type="video/mp4">

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
