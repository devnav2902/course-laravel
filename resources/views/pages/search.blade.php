@extends('layouts.master')

@section('main-content')
    <div class="main-categories">
        <div class="main-categories__content">
            <!-- left side -->
            <div class="left-side">
                <div class="categories-box">
                    <div class="title">
                        <h2>Danh mục</h2>
                    </div>
                    <div class="categories">
                        <a class="" href=" {{ route('category') }}">Tất cả khóa học</a>

                        @foreach ($categories as $category)
                            <a href="{{ route('category', ['url' => $category->slug]) }}" class="">
                                {{ $category->title }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- category container -->
            <div class="category-page-container">
                <!-- Sec Title -->
                <div class="sec-title">
                    <h2>{{ $courses->total() }} Results for "{{ $keyword }}"</h2>
                </div>
                <div class="all-courses">
                    @foreach ($courses as $course)
                        <div class="course-block">

                            <div class="image">
                                <a href="{{ route('course', ['url' => $course->slug]) }}"><img
                                        src="{{ $course->thumbnail }}" alt="{{ $course->title }}" />
                                </a>
                            </div>
                            <div class="content">
                                <h6>
                                    <a href="{{ route('course', ['url' => $course->slug]) }}">
                                        {{ $course->title }} </a>
                                </h6>

                                <ul class="post-meta">
                                    @foreach ($course->category as $key => $item)
                                        @if ($key === count($course->category) - 1)
                                            <li>
                                                <a href="{{ route('category', ['url' => $item->slug]) }}">
                                                    {{ $item->title }}
                                                </a>
                                            </li>
                                        @else
                                            <li>
                                                <a href="{{ route('category', ['url' => $item->slug]) }}">
                                                    {{ $item->title }}
                                                </a>
                                            </li>,&nbsp;
                                        @endif
                                    @endforeach
                                </ul>
                                @include('components.ratings',['course'=>$course])
                                <div class="footer-content">
                                    <div class="pull-left">
                                        <div class="author">
                                            <a href="{{ route('instructor', ['slug' => $course->author->slug]) }}">
                                                {{ $course->author->fullname }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="pull-right">
                                        <div class="price">
                                            @if ($course->price->price == 0.0)
                                                Free
                                            @else
                                                ${{ $course->price->price }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="page-container">{{ $courses->onEachSide(1)->withQueryString()->links() }}</div>
    </div>
@endsection
