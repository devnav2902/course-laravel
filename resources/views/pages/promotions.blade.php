@extends('layouts.instructor-courses',['course'=>$course])

@section('main-content')
    <div class="edit-course-section">
        <!-- Sec Title -->
        <div class="sec-title"></div>

        <div class="inner-column">
            <h6 class="">Promotions</h6>
            <!-- Edit Course Form -->
            <div class="">
                <!-- Form Group -->
                <div class="promotions">
                    <div class="coupons">
                        @include('components.create_coupon',['coupon'=>
                        $types_of_coupons,'price'=>$course->price->price,'id'=>$course->id])
                    </div>
                    <div class="coupons">
                        @include('components.active-coupons',
                        ['active_coupons'=>$active_coupons])
                    </div>
                    <div class="coupons">
                        @include('components.expired-coupons',
                        ['expired-coupons'=>$active_coupons])
                    </div>

                </div>
            </div>

        </div>
    @endsection
