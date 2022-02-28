@extends('layouts.overview-course')

@section('main-content')
    <div class="admin">
        <div class="admin__review">

            <div class="d-flex align-items-center header">
                <h1>Review courses</h1>
                <div class="right">
                    <span class="filter"> Filter: </span>
                    <span>Active
                        <a href=""><i class="fas fa-chevron-down"></i></a>
                    </span>
                </div>
            </div>
            <div class="admin-search">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Search..." />
            </div>
            <div class="admin-table">
                <table>

                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th>INSTRUCTOR</th>
                            <th>TITLE</th>
                            <th>PRICE</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>

                        @foreach ($courses as $course)
                            <tr>
                                <td>{{ $course->course->id }}</td>
                                <td><img src="{{ asset($course->course->author->avatar) }}" alt=""
                                        style="width: 50px;height: 50px;border-radius: 50% ">
                                </td>
                                <td>{{ $course->course->title }}</td>
                                <td>{{ $course->course->price->price }}</td>
                                <td>{{ $course->course->updated_at }}</td>
                                <td>
                                    <a href="{{ route('draft', ['id' => $course->course_id]) }}"><button>view</button></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
