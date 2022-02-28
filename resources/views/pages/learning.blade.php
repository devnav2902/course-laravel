<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('title')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"
    integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w=="
    crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdn.plyr.io/3.6.9/plyr.css" />
  <link rel="stylesheet" href="{{ asset('style/style.css') }}">
</head>

<body class="default">
  <header>
    <div class="header-container d-flex align-items-center">
      <div class="logo"><a href="{{ route('home') }}">devco</a></div>
      <div class="vertical-divider"></div>
      <div class="header-title">
        <h1 class="course-title">
          <a href="{{ route('course', ['url' => $course->slug]) }}">
            {{ $course->title }}
          </a>
        </h1>
      </div>
      <div class="progress">
        <div class="progress__wrapper d-flex align-items-center">
          <div id="progress" data-course="{{ $course->id }}" data-lectures="{{ $course->lecture->count() }}"
            data-progress="{{ $data_progress }}">
          </div>
          <div class="txt">Your progress</div>
          {{-- <button><i class="fas fa-chevron-down"></i></button> --}}
        </div>
      </div>
    </div>
  </header>
  <main class="main-content-wrapper">
    <div class="open-course-content">
      <button><i class="fas fa-arrow-left"></i><span>Course content</span></button>
    </div>
    <div class="learning-content">
      <div class="video-content">
        <div class="video-player">
          <video controls>
            <source src="{{ asset($course->section[0]->lecture[0]->src) }}">
          </video>
        </div>
      </div>
      <div class="sidebar-container">
        <div class="sidebar-container__header d-flex align-items-center">
          <div class="title">Course content</div>
          <button type="button" id="sidebar-close-btn">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="sections">
          @foreach ($course->section as $key => $section)
            <div class="section" data-section="{{ $section->id }}">
              <div class="section__header d-flex">
                <div class="container">
                  <div class="title-section">
                    Section {{ $section->order }}:&nbsp;
                    {{ $section->title }}</div>
                  <div class="bottom">
                    <span>
                      <span
                        class="count">{{ $section->countProgress->count() }}</span>/{{ $section->lecture->count() }}
                    </span>
                    {{-- |
                                        <span class="duration">40min</span> --}}
                  </div>
                </div>
                <button type="button">
                  <i class="{{ $section->order == 1 ? 'show' : '' }} fas fa-chevron-down">
                  </i>
                </button>
              </div>
              <div class="accordion-panel {{ $section->order == 1 ? '' : 'd-none' }}">
                @foreach ($section->lecture as $lecture)
                  <li class="curriculum-item {{ $key == 0 && $lecture->order == 1 ? 'is-current' : '' }} d-flex ">
                    <input type="hidden" class="lecture" value="{{ $lecture->src }}">
                    <div class="progress-toggle">
                      <label id="">
                        @if ($lecture->progress)
                          <input {{ $lecture->progress->progress ? 'checked' : '' }} value="{{ $lecture->id }}"
                            type="checkbox" name="progress" />
                        @else
                          <input value="{{ $lecture->id }}" type="checkbox" name="progress" />
                        @endif
                        <span></span>
                      </label>
                    </div>
                    <div class="link">
                      <div class="text">
                        {{ $lecture->order }}.&nbsp;{!! $lecture->title !!}
                      </div>
                      <div class="bottom d-flex align-items-center">
                        {{-- <div class="duration">
                                                    <i class="fas fa-play-circle"></i>
                                                    <span class="times">15min</span>
                                                </div> --}}

                        @if (count($lecture->resource))
                          <div class="resource-list">
                            <button class="dropdown d-flex align-items-center">
                              <i class="fas fa-folder-open"></i>
                              Resources
                              <i class="fas fa-chevron-down"></i>
                            </button>

                            <ul class="list">
                              @foreach ($lecture->resource as $resource)
                                <li>
                                  <button class="d-flex download-btn align-items-center">
                                    <i class="fas fa-file-download"></i>
                                    <div class="filename">
                                      {{ $resource->original_filename }}
                                    </div>
                                  </button>
                                </li>
                              @endforeach
                            </ul>

                          </div>
                        @endif
                      </div>
                    </div>
                  </li>
                @endforeach
              </div>
            </div>
          @endforeach
        </div>

      </div>
    </div>
    <!-- end learning content -->
    <div class="content-footer">
      <div class="bar">
        <ul>
          <li class="is-current">Overview</li>
          <li>Notes</li>
        </ul>
      </div>
      <div class="content-footer__data">
        <div class="container">
          <div class="container__content">
            <div class="title">About this course</div>
            <div class="row">
              <p class="title">Description</p>
              <div class="course-description">
                {!! $course->description !!}
              </div>
            </div>

            <div class="row">
              <p class="title">Instructor</p>
              <div class="instructor-profile">
                <div class="header">
                  <img src="{{ asset($author->avatar) }}" alt="">
                  <div class="profile-title">
                    <a href='{{ route('instructor', ['slug' => $author->slug]) }}'>
                      {{ $author->fullname }}
                    </a>
                    <div class="headline">
                      {!! $author->bio->headline !!}
                    </div>
                  </div>
                </div>
                <div class="profile-social-links">
                  @if (!empty($author->bio->linkedin))
                    <div class="socical-link">
                      <div class="my-link">
                        <a href="{{ $author->bio->linkedin }}"><i class="fab fa-linkedin">
                          </i></a>
                      </div>
                    </div>
                  @endif
                  @if (!empty($author->bio->twitter))
                    <div class="socical-link">
                      <div class="my-link">
                        <a href="{{ $author->bio->twitter }}"><i class="fab fa-twitter">
                          </i>
                        </a>
                      </div>
                    </div>
                  @endif
                  @if (!empty($author->bio->facebook))
                    <div class="socical-link">
                      <div class="my-link">
                        <a href="{{ $author->bio->facebook }}"><i class="fab fa-facebook">
                          </i></a>
                      </div>
                    </div>
                  @endif
                  @if (!empty($author->bio->youtube))
                    <div class="socical-link">
                      <div class="my-link">
                        <a href="{{ $author->bio->youtube }}"><i class="fab fa-youtube">
                          </i></a>
                      </div>
                    </div>
                  @endif
                </div>
                <div class="profile-description">
                  {!! $author->bio->bio !!}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/progressbar.js/0.6.1/progressbar.min.js"
    integrity="sha512-7IoDEsIJGxz/gNyJY/0LRtS45wDSvPFXGPuC7Fo4YueWMNOmWKMAllEqo2Im3pgOjeEwsOoieyliRgdkZnY0ow=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdn.plyr.io/3.6.9/plyr.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <script type="module" src="{{ asset('js/learning.js') }}"></script>
</body>

</html>
