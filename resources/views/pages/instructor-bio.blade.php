@extends('layouts.master')
@section('main-content')
    @if (count($courses))
        <div class="profile">
            <div class="instructor-profile--left-column">
                <div class="instructor">INSTRUCTOR</div>

                <h1 class="name-author">{{ $author->fullname }}</h1>
                <h2 class="headline" style="font-size: 1.4rem">{{ $author->bio->headline }}</h2>

                <div class="instructor-profile">
                    <div class="total-tag">
                        <div class="heading-sm">Total students</div>
                        <div class="number">
                            {{ $totalStudents }}
                        </div>
                    </div>
                    <div class="review-tag">
                        <div class="heading-sm">Reviews</div>
                        <div class="number">
                            {{ $totalReviews }}
                        </div>
                    </div>
                </div>

                <h2 class="info-title">About me</h2>
                <div class="show-more">
                    <div class="content markdown">
                        {!! $author->bio->bio !!}
                    </div>

                    <div class="my-course">
                        <h2 class="course-title">
                            My courses&nbsp;({{ $totalCourses }})
                        </h2>

                        <div class="list-courses">
                            @foreach ($courses as $item)
                                @include('components.course',
                                ['course'=>$item])
                            @endforeach
                        </div>

                        {{ $courses->links() }}

                    </div>

                </div>
            </div>

            <div class="instructor-profile--right-column">
                <div class="img">
                    <img src="{{ asset($author->avatar) }}" alt="" class="avatar" />
                </div>
                @if (!empty($author->bio->linkedin))
                    <div class="socical-link">
                        <div class="my-link">
                            <a href="{{ $author->bio->linkedin }}"><i
                                    class="fab fa-linkedin"></i><span>Linkedin</span></a>
                        </div>
                    </div>
                @endif
                @if (!empty($author->bio->twitter))
                    <div class="socical-link">
                        <div class="my-link">
                            <a href="{{ $author->bio->twitter }}"><i class="fab fa-twitter"></i><span>Twitter</span></a>
                        </div>
                    </div>
                @endif
                @if (!empty($author->bio->facebook))
                    <div class="socical-link">
                        <div class="my-link">
                            <a href="{{ $author->bio->facebook }}"><i
                                    class="fab fa-facebook"></i><span>Facebook</span></a>
                        </div>
                    </div>
                @endif
                @if (!empty($author->bio->youtube))
                    <div class="socical-link">
                        <div class="my-link">
                            <a href="{{ $author->bio->youtube }}"><i class="fab fa-youtube"></i><span>Youtube</span></a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="user-profile">
            <div class="header-bar">
                <h1>{{ $author->fullname }}</h1>

            </div>
            <div class="user-profile-content d-flex">
                <div class="user-profile__left">
                    <img src="{{ asset($author->avatar) }}" alt="" class="circle-img avatar mb-1" />
                    <h2>{{ $author->bio->headline }}</h2>
                    <ul class="social-box d-flex align-items-center justify-content-center ">
                        @if (!empty($author->bio->linkedin))
                            <li class="socical-link">
                                <div class="my-link">
                                    <a href="{{ $author->bio->linkedin }}"><i class="fab fa-linkedin"></i></a>
                                </div>
                            </li>
                        @endif
                        @if (!empty($author->bio->twitter))
                            <li class="socical-link">
                                <div class="my-link">
                                    <a href="{{ $author->bio->twitter }}"><i class="fab fa-twitter"></i></a>
                                </div>
                            </li>
                        @endif
                        @if (!empty($author->bio->facebook))
                            <li class="socical-link">
                                <div class="my-link">
                                    <a href="{{ $author->bio->facebook }}"><i class="fab fa-facebook"></i></a>
                                </div>
                            </li>
                        @endif
                        @if (!empty($author->bio->youtube))
                            <li class="socical-link">
                                <div class="my-link">
                                    <a href="{{ $author->bio->youtube }}"><i class="fab fa-youtube"></i></a>
                                </div>
                            </li>
                        @endif
                        {{-- <li class="facebook">
                            <a href="#" class=""><i class=" facebook-icon fab fa-facebook-f"></i></a>
                        </li>
                        <li class="google ml-1">
                            <a href="#" class=""><i class=" google-icon fab fa-google"></i></a>
                        </li>
                        <li class="twitter ml-1">
                            <a href="#" class=""><i class=" twitter-icon fab fa-twitter"></i></a>
                        </li> --}}
                    </ul>
                </div>
                @if (!empty($author->bio))
                    <div class="user-profile__right">
                        <div class="biography">
                            {!! $author->bio->bio !!}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif

@endsection
