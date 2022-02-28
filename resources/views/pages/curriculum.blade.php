@extends('layouts.instructor-courses',['course' => $course])

@section('main-content')

    <div class="edit-course-section">

        <h6 class="">Chương trình học tập</h6>

        <!-- Edit Course Form -->
        <div class="edit-course-form">
            <!-- Form Group -->

            <div class="curriculum-list">
                @if (!count($course->section))
                    <div class="curriculum-item curriculum-list__section curriculum-item__add">
                        <div data-section="" class="curriculum-content section-content section-editor">
                            <form class="section-form">
                                <div class="section-form__title">
                                    <span class="section-form-txt">Thêm chương học</span>
                                    <input maxlength="80" name="title" placeholder="Enter a Title" type="text" value="">
                                    <input name="id" type="hidden" value="">
                                    <input name="course" type="hidden" value="1">
                                </div>
                                <div class="section-form__footer">
                                    <button type="button">Cancel</button>
                                    <button type="button" class="add-section">
                                        Thêm chương học
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

                @foreach ($course->section as $section)
                    <div class="curriculum-item curriculum-list__section">
                        <div data-section="{{ $section->id }}" class="curriculum-content section-content section-editor">
                            <div class="section-content__title">
                                <span class="section">Chương {{ $section->order }}:</span>
                                <span class="curriculum-title">
                                    <i class="fas fa-file-alt"></i>
                                    <span>{!! $section->title !!}</span>
                                </span>
                                <button type="button" class="item-icon-button section-edit-btn"><i
                                        class="fas fa-pencil-alt"></i></button>
                                <button type="button" class="item-icon-button section-delete-btn">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>

                        <ul class="lecture-wrapper">
                            @foreach ($section->lecture as $lecture)
                                <li data-lecture="{{ $lecture->id }}" class="curriculum-content lecture-content">
                                    <div class="lecture-content__title">
                                        <div class="lecture-editor">
                                            <span class="lecture">
                                                <i class="fas fa-check-circle"></i>
                                                <span class="order">Bài giảng {{ $lecture->order }}:</span>
                                            </span>
                                            <span class="curriculum-title">
                                                <i class="fas fa-file-alt"></i>
                                                <span>{!! $lecture->title !!}</span>
                                            </span>
                                            <button class="lecture-edit-btn item-icon-button"><i
                                                    class="fas fa-pencil-alt"></i></button>
                                            <button class="lecture-delete-btn item-icon-button">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                        @if (empty($lecture->src))
                                            <div class="add-content">
                                                <button class="lecture-add-content">+ Nội dung</button>
                                            </div>
                                        @endif
                                        <div class="lecture-collapse">
                                            <button class="lecture-collapse-btn"><i
                                                    class="fas fa-chevron-down"></i></button>
                                        </div>
                                    </div>

                                    @if (!count($lecture->resource) && empty($lecture->src))
                                        <div class="content-tab content-resources">
                                            <div class="content-tab__asset content-tab__main">
                                                <div class="add-resource">
                                                    <button class="lecture-add-resource">+ Tài liệu</button>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="content-tab content-resources">
                                            <div class="content-tab__asset content-tab__main">
                                                @if (!empty($lecture->src))
                                                    <div class="table">
                                                        <table>
                                                            <thead>
                                                                <tr>
                                                                    <th>Filename</th>
                                                                    <th>Type</th>
                                                                    <th>Status</th>
                                                                    <th>Date</th>
                                                                    <th></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>{{ $lecture->original_filename }}</td>
                                                                    <td>Video</td>
                                                                    <td>Success</td>
                                                                    <td>{{ $lecture->updated_at }}</td>
                                                                    <td><button class="replace-btn"
                                                                            type="button">Replace</button></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                        <span class="note">
                                                            <b>Note: </b>
                                                            Video phải đạt tối thiểu 720p và không vượt quá 2.0 GB
                                                        </span>
                                                    </div>
                                                @endif

                                                @if (!count($lecture->resource))
                                                    <div class="add-resource">
                                                        <button class="lecture-add-resource">+ Tài liệu</button>
                                                    </div>
                                                @else
                                                    <div class="resources">
                                                        <p>Downloadable materials</p>
                                                        <div class="list">
                                                            @foreach ($lecture->resource as $resource)
                                                                <div data-lecture="{{ $lecture->id }}"
                                                                    data-resource="{{ $resource->id }}"
                                                                    class="item">
                                                                    <div class="item__file">
                                                                        <div class="icon">
                                                                            <i class="fas fa-download"></i>
                                                                        </div>
                                                                        <span class="filename">
                                                                            {{ $resource->original_filename }}
                                                                        </span>
                                                                    </div>
                                                                    <button type="button" class="delete-asset-btn">
                                                                        <i class="fas fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            @endforeach
                                                        </div>

                                                        <div class="add-resource">
                                                            <button class="lecture-add-resource">+ Tài liệu</button>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    {{-- <div class="content-tab">
                                            <div class="content-tab__header">
                                                <span>
                                                    Add video
                                                </span>
                                                <button type="button" class="content-tab-close">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <div class="content-tab__media">
                                                <div class="content-tab__media-file">

                                                    <div class="input-group">
                                                        <div class="file-upload">
                                                            No file selected
                                                        </div>
                                                        <button type="button" class="button-select-video">
                                                            Select Video
                                                        </button>
                                                    </div>
                                                    <span class="note">
                                                        <b>Note: </b>
                                                        All files should be at least 720p and less than 2.0 GB.
                                                    </span>
                                                </div>
                                            </div>
                                        </div> --}}
                                    {{-- <div class="content-tab content-resource">
                                            <div class="content-tab__header">
                                                <span>
                                                    Downloadable file
                                                </span>
                                                <button type="button" class="content-tab-close">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <div class="content-tab__resource">
                                                <div class="content-tab__resource-file">

                                                    <div class="input-group">
                                                        <div class="file-upload">
                                                            No file selected
                                                        </div>
                                                        <button type="button" class="button-select-file">
                                                            Select File
                                                        </button>
                                                    </div>
                                                    <span class="note">
                                                        <b>Note: </b>
                                                        A resource is for any type of document that can be used to help
                                                        students in the lecture. Make sure everything is legible and the
                                                        file size is less
                                                        than 1 GiB.
                                                    </span>
                                                </div>
                                            </div>
                                        </div> --}}

                                </li>
                            @endforeach

                            <div class="curriculum-add-item">
                                <button class="add-item" data-curriculum="lecture">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </ul>

                    </div>
                @endforeach
            </div>
            @if (count($course->section))
                <div class="wrapper-section">
                    <div class="curriculum-add-item">
                        <button class="add-item" data-curriculum="section">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            @endif
        </div>

    </div>

@endsection

@section('script')
    <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>

    <script type="module" src="{{ asset('js/curriculum.js') }}"></script>
@endsection
