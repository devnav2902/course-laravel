@extends('layouts.instructor-courses',['course' => $course])
@section('main-content')
    <div class="edit-course-section">
        <!-- Sec Title -->
        <div class="sec-title">

        </div>
        <form method="POST" id='form-course' action="{{ route('update-price', ['id' => $course->id]) }}">
            @csrf
            <div class="inner-column">

                <h6 class="">Giá khóa học</h6>
                <!-- Edit Course Form -->

                <p>Vui lòng chọn mức giá cho khóa học của bạn bên dưới và nhấp vào 'Save'.</p>

                <p>
                    Nếu bạn tạo khóa học miễn phí, tổng thời lượng của nội dung video phải dưới 2 giờ.
                </p>
                <div class="">
                    <!-- Form Group -->

                    <div class="price">
                        <div class="select">
                            <select name="price" id="">
                                <option value="" selected disabled>Select</option>

                                @foreach ($allPrice as $price)
                                    <option value="{{ $price->id }}" @if ($course->price_id === $price->id) selected @endif>
                                        @if ($price->price === 0.0) Free
                                        @else
                                            ${{ $price->price }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button class="button">Save</button>
                    </div>

                </div>
        </form>
    </div>
@endsection
