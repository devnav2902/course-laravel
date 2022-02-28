@extends('layouts.master')

@section('main-content')
    <div class="menu-notifications">
        <div class="title-notification">
            <h2>Notifications</h2>
        </div>
        <ul>
            <li class="wrap">
                @foreach ($notification_course as $notifi)
                    <a href="{{ route('entry-course', ['id' => $notifi->course_id]) }}">
                        <img src="" alt="">
                        <div class="right">
                            <span class="title">
                                {{ $notifi->entity->text_start }}
                                <a href="{{ route('entry-course', ['id' => $notifi->course_id]) }}">
                                    {!! $notifi->course->title !!}
                                </a>
                                {{ $notifi->entity->text_end }}
                            </span>
                            <span>1 day ago</span>
                        </div>
                    </a>
                @endforeach
            </li>
        </ul>
    </div>
@endsection
