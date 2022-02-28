@extends('layouts.overview-course')
@section('link')

@endsection
@section('main-content')

    <div class="overview-container">
        <div class="overview-content">
            <div class="overview-title">
                <h2>Overview</h2>
            </div>
            <div class="metrics-content">

                <div class="overview-body">
                    <div class="top-metrics">
                        <div class="nav-overview-container">
                            <ul class="nav-tabs">
                                @if ($globalUser->role->name === 'admin')
                                    <li class="">
                                        <button class="">
                                            <div class="instructor-analytics--metrics-data">
                                                <div>
                                                    <div class="text-midnight-lighter">
                                                        Tổng số giảng viên
                                                    </div>
                                                    <div class="text-midnight">
                                                        {{ $allInstructors }}
                                                    </div>
                                                </div>
                                            </div>
                                        </button>
                                    </li>
                                    <li class="">
                                        <button class="">
                                            <div class="instructor-analytics--metrics-data">
                                                <div>
                                                    <div class="text-midnight-lighter">
                                                        Tổng số học viên
                                                    </div>
                                                    <div class="text-midnight">
                                                        {{ $allStudents }}
                                                    </div>

                                                </div>
                                            </div>
                                        </button>
                                    </li>
                                @endif
                                <li class="">
                                    <button class="">
                                        <div class="instructor-analytics--metrics-data">
                                            <div>
                                                <div class="text-midnight-lighter">
                                                    Khóa học của bạn
                                                </div>
                                                <div class="text-midnight">
                                                    {{ $allCoursesByInstructor }}
                                                </div>

                                            </div>
                                        </div>
                                    </button>
                                </li>
                            </ul>
                            <ul class=" nav-tabs">
                                <li class="overview-item overview-active" data-chart="revenueChart">
                                    <button>
                                        <div class="instructor-analytics--metrics-data">
                                            <div>
                                                <div class="text-midnight-lighter">
                                                    Tổng doanh thu
                                                </div>
                                                <div class="text-midnight">
                                                    {{ $totalRevenue }}$
                                                </div>
                                                <div class="text-midnight-lighter">{{ $totalRevenueInMonth }}$ trong tháng
                                                    này
                                                </div>
                                            </div>
                                        </div>
                                    </button>
                                </li>
                                <li class="overview-item" data-chart="enrollmentsChart">
                                    <button>
                                        <div class="instructor-analytics--metrics-data">
                                            <div>
                                                <div class="text-midnight-lighter">
                                                    Học viên
                                                </div>
                                                <div class="text-midnight">
                                                    {{ $totalStudents }}
                                                </div>
                                                <div class="text-midnight-lighter">{{ $numberOfStudentsInMonth }} trong
                                                    tháng này
                                                </div>
                                            </div>
                                        </div>
                                    </button>
                                </li>
                                <li class="overview-item" data-chart="ratingChart">
                                    <button>
                                        <div class="instructor-analytics--metrics-data">
                                            <div>
                                                <div class="text-midnight-lighter">
                                                    Đánh giá khóa học của bạn
                                                </div>
                                                <div class="text-midnight">
                                                    {{ number_format($ratingCourses, 1) }}
                                                </div>
                                                <div class="text-midnight-lighter">{{ $numberOfRatingsInMonth }} đánh giá
                                                    trong
                                                    tháng này
                                                </div>
                                            </div>
                                        </div>
                                    </button>
                                </li>
                                @if ($globalUser->role->name === 'admin')
                                    <li class="overview-item" data-chart="coursesChart">
                                        <button>
                                            <div class="instructor-analytics--metrics-data">
                                                <div>
                                                    <div class="text-midnight-lighter">
                                                        Tổng số khóa học
                                                    </div>
                                                    <div class="text-midnight">
                                                        {{ $allCourses }}
                                                    </div>
                                                    <div class="text-midnight-lighter">{{ $allCoursesInMonth }} trong
                                                        tháng này
                                                    </div>
                                                </div>
                                            </div>
                                        </button>
                                    </li>


                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane">
                            <div class="instructor-analytics--chart">

                                <div class="instructor-analytics-message">


                                    <div class="containerChart activeChart">
                                        <canvas id="revenueChart"></canvas>
                                    </div>

                                    <div class="containerChart">
                                        <canvas id="enrollmentsChart"></canvas>
                                    </div>
                                    <div class="containerChart">
                                        <canvas id="ratingChart"></canvas>
                                    </div>
                                    <div class="containerChart">
                                        <canvas id="coursesChart"></canvas>
                                    </div>
                                    <div class="containerChart">
                                        <canvas id="instructorChart"></canvas>
                                    </div>
                                    <div class="containerChart">
                                        <canvas id="studentChart"></canvas>
                                    </div>
                                    {{-- @endif --}}
                                </div>
                            </div>
                            <div class="instructor-analytics--chart-footer">
                                <a href="">
                                    <span>Revenue Report</span>
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.min.js"
        integrity="sha512-GMGzUEevhWh8Tc/njS0bDpwgxdCJLQBWG3Z2Ct+JGOpVnEmjvNx6ts4v6A2XJf1HOrtOsfhv3hBKpK9kE5z8AQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="module" src="{{ asset('js/chart.js') }}"></script>
@endsection
